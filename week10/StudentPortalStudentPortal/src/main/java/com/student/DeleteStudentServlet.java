package com.student;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

@WebServlet("/delete-student")
public class DeleteStudentServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;
    private StudentDAO dao = new StudentDAO();

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        // Prefer POST for delete operations; support GET for convenience but redirect to list
        response.sendRedirect(request.getContextPath() + "/students");
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String idParam = request.getParameter("id");
        if (idParam != null) {
            try {
                int id = Integer.parseInt(idParam);
                dao.deleteStudent(id);
            } catch (NumberFormatException e) {
                // ignore invalid id
            }
        }
        response.sendRedirect(request.getContextPath() + "/students");
    }
}
