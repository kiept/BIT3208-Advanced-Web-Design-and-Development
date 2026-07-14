package com.student;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

/**
 * Data Access Object for Student entities.
 */
public class StudentDAO {

    private static final String INSERT_SQL = "INSERT INTO students(name, course, email) VALUES(?,?,?)";
    private static final String SELECT_ALL_SQL = "SELECT id, name, course, email FROM students ORDER BY id DESC";
    private static final String SELECT_BY_ID_SQL = "SELECT id, name, course, email FROM students WHERE id = ?";
    private static final String UPDATE_SQL = "UPDATE students SET name = ?, course = ?, email = ? WHERE id = ?";
    private static final String DELETE_SQL = "DELETE FROM students WHERE id = ?";

    public boolean addStudent(Student student) {
        try (Connection conn = DBUtil.getConnection();
             PreparedStatement ps = conn.prepareStatement(INSERT_SQL)) {
            ps.setString(1, student.getName());
            ps.setString(2, student.getCourse());
            ps.setString(3, student.getEmail());
            int affected = ps.executeUpdate();
            return affected == 1;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public List<Student> getAllStudents() {
        List<Student> list = new ArrayList<>();
        try (Connection conn = DBUtil.getConnection();
             PreparedStatement ps = conn.prepareStatement(SELECT_ALL_SQL);
             ResultSet rs = ps.executeQuery()) {
            while (rs.next()) {
                Student s = new Student(
                        rs.getInt("id"),
                        rs.getString("name"),
                        rs.getString("course"),
                        rs.getString("email")
                );
                list.add(s);
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return list;
    }

    public Student getStudentById(int id) {
        try (Connection conn = DBUtil.getConnection();
             PreparedStatement ps = conn.prepareStatement(SELECT_BY_ID_SQL)) {
            ps.setInt(1, id);
            try (ResultSet rs = ps.executeQuery()) {
                if (rs.next()) {
                    return new Student(
                            rs.getInt("id"),
                            rs.getString("name"),
                            rs.getString("course"),
                            rs.getString("email")
                    );
                }
            }
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    public boolean updateStudent(Student student) {
        try (Connection conn = DBUtil.getConnection();
             PreparedStatement ps = conn.prepareStatement(UPDATE_SQL)) {
            ps.setString(1, student.getName());
            ps.setString(2, student.getCourse());
            ps.setString(3, student.getEmail());
            ps.setInt(4, student.getId());
            int affected = ps.executeUpdate();
            return affected == 1;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }

    public boolean deleteStudent(int id) {
        try (Connection conn = DBUtil.getConnection();
             PreparedStatement ps = conn.prepareStatement(DELETE_SQL)) {
            ps.setInt(1, id);
            int affected = ps.executeUpdate();
            return affected == 1;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        }
    }
}
