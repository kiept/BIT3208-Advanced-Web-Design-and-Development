package com.student;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

/**
 * Servlet to handle adding a new student via a form
 */
@WebServlet("/add-student")
public class StudentServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private StudentDAO dao = new StudentDAO();

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        request.getRequestDispatcher("student-form.jsp").forward(request, response);
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String name = request.getParameter("name");
        String course = request.getParameter("course");
        String email = request.getParameter("email");

        if (name == null || name.trim().isEmpty() || course == null || course.trim().isEmpty() || email == null || email.trim().isEmpty()) {
            request.setAttribute("error", "All fields are required.");
            request.getRequestDispatcher("student-form.jsp").forward(request, response);
            return;
        }

        Student s = new Student(name.trim(), course.trim(), email.trim());
        boolean ok = dao.addStudent(s);
        if (ok) {
            response.sendRedirect(request.getContextPath() + "/students");
        } else {
            request.setAttribute("error", "Unable to add student. Check server logs.");
            request.getRequestDispatcher("student-form.jsp").forward(request, response);
        }
    }
}
