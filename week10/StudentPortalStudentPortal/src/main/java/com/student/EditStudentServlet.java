package com.student;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/edit-student")
public class EditStudentServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private StudentDAO dao = new StudentDAO();

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String idParam = request.getParameter("id");
        if (idParam == null) {
            response.sendRedirect(request.getContextPath() + "/students");
            return;
        }
        try {
            int id = Integer.parseInt(idParam);
            Student s = dao.getStudentById(id);
            if (s == null) {
                response.sendRedirect(request.getContextPath() + "/students");
                return;
            }
            request.setAttribute("student", s);
            request.getRequestDispatcher("edit-student.jsp").forward(request, response);
        } catch (NumberFormatException e) {
            response.sendRedirect(request.getContextPath() + "/students");
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String idParam = request.getParameter("id");
        String name = request.getParameter("name");
        String course = request.getParameter("course");
        String email = request.getParameter("email");

        if (idParam == null || name == null || course == null || email == null) {
            request.setAttribute("error", "All fields are required.");
            request.getRequestDispatcher("edit-student.jsp").forward(request, response);
            return;
        }

        try {
            int id = Integer.parseInt(idParam);
            Student s = new Student(id, name.trim(), course.trim(), email.trim());
            boolean ok = dao.updateStudent(s);
            if (ok) {
                response.sendRedirect(request.getContextPath() + "/students");
            } else {
                request.setAttribute("error", "Unable to update student. Check server logs.");
                request.setAttribute("student", s);
                request.getRequestDispatcher("edit-student.jsp").forward(request, response);
            }
        } catch (NumberFormatException e) {
            response.sendRedirect(request.getContextPath() + "/students");
        }
    }
}
