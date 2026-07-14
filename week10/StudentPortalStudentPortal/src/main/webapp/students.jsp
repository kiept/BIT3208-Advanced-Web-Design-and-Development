<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.util.List" %>
<%@ page import="com.student.Student" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>body{background:#f4f6f8}</style>
</head>
<body>
<div class="container mt-4">
    <div class="controls mb-3">
        <a class="btn btn-success" href="add-student">+ Add Student</a>
        <a class="btn btn-link" href="dashboard">Back to Dashboard</a>
    </div>

    <h2>Students</h2>
    <%
        List<Student> students = (List<Student>) request.getAttribute("students");
        if (students == null || students.isEmpty()) {
    %>
        <p>No students found. <a href="add-student">Add one</a>.</p>
    <%
        } else {
    %>
        <table class="table table-striped">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Course</th>
                <th>Email</th>
                <th>Actions</th>
            </tr>
            <%
                for (Student s : students) {
            %>
            <tr>
                <td><%= s.getId() %></td>
                <td><%= s.getName() %></td>
                <td><%= s.getCourse() %></td>
                <td><%= s.getEmail() %></td>
                <td>
                    <a class="btn btn-sm btn-outline-primary" href="edit-student?id=<%= s.getId() %>">Edit</a>
                    <form action="delete-student" method="post" style="display:inline; margin:0; padding:0;">
                        <input type="hidden" name="id" value="<%= s.getId() %>" />
                        <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this student?');">Delete</button>
                    </form>
                </td>
            </tr>
            <%
                }
            %>
        </table>
    <%
        }
    %>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
