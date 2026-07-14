package com.student;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.SQLException;

import javax.naming.InitialContext;
import javax.naming.NamingException;
import javax.sql.DataSource;

/**
 * Utility class to manage JDBC connection.
 * By default this tries to lookup a JNDI DataSource at java:comp/env/jdbc/studentdb.
 * If not available, it falls back to DriverManager using the embedded constants below.
 *
 * Ensure MySQL Connector/J is added to WEB-INF/lib or project's classpath, or configured in Tomcat's lib.
 */
public class DBUtil {
    // Fallback settings (edit if not using JNDI)
    private static final String DB_URL = "jdbc:mysql://localhost:3306/studentdb?useSSL=false&allowPublicKeyRetrieval=true&serverTimezone=UTC";
    private static final String DB_USER = "root";
    private static final String DB_PASSWORD = "password"; // <-- change this

    private static DataSource dataSource;

    static {
        // Try obtaining DataSource via JNDI; if not available, fall back to DriverManager.
        try {
            InitialContext ctx = new InitialContext();
            dataSource = (DataSource) ctx.lookup("java:comp/env/jdbc/studentdb");
        } catch (NamingException ne) {
            dataSource = null;
            // Fall back: ensure Driver is available for DriverManager usage
            try {
                Class.forName("com.mysql.cj.jdbc.Driver");
            } catch (ClassNotFoundException e) {
                throw new ExceptionInInitializerError("MySQL JDBC Driver not found. Add Connector/J to classpath.");
            }
        }
    }

    public static Connection getConnection() throws SQLException {
        if (dataSource != null) {
            return dataSource.getConnection();
        }
        // Fallback to DriverManager using configured constants
        return DriverManager.getConnection(DB_URL, DB_USER, DB_PASSWORD);
    }
}
