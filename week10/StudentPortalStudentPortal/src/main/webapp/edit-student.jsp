<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="com.student.Student" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background:#f4f6f8 }
        .form-box { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 12px rgba(0,0,0,0.08) }
        .error { color: #c62828; margin-bottom: 12px }
    </style>
</head>
<body>
    <div class="form-box container mt-4 p-4">
        <h2>Edit Student</h2>
        <%
            String error = (String) request.getAttribute("error");
            Student s = (Student) request.getAttribute("student");
            if (error != null && !error.isEmpty()) {
        %>
            <div class="alert alert-danger"><%= error %></div>
        <%
            }
            if (s == null) s = new Student();
        %>
        <form action="edit-student" method="post">
            <input type="hidden" name="id" value="<%= s.getId() %>" />
            <div class="form-group">
                <label for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" required value="<%= s.getName() != null ? s.getName() : "" %>" />
            </div>
            <div class="form-group">
                <label for="course">Course</label>
                <input class="form-control" type="text" id="course" name="course" required value="<%= s.getCourse() != null ? s.getCourse() : "" %>" />
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required value="<%= s.getEmail() != null ? s.getEmail() : "" %>" />
            </div>
            <div>
                <button class="btn btn-primary" type="submit">Save Changes</button>
                <a class="btn btn-link" href="students" style="margin-left:8px">Cancel</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
