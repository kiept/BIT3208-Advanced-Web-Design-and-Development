<%@ page contentType="text/html; charset=UTF-8" pageEncoding="UTF-8" %>
<%@ page import="java.util.List" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GTNm9aS3d8YQq7qQ1Yk2+X5Q5J7l2FQv3mZl0Y5qjF5Q5jY6Z" crossorigin="anonymous">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height:100vh; }
        .card { border-radius:10px }
        .welcome { color: white }
    </style>
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-white">🎓 Student Portal Dashboard</h3>
        <a href="logout" class="btn btn-danger">Logout</a>
    </div>

    <div class="jumbotron bg-transparent p-4 welcome">
        <h1 class="display-5">Welcome, <%= request.getAttribute("username") %> 👋</h1>
        <p class="lead">You have successfully logged into your Student Portal</p>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <h5>User Information</h5>
                <p class="mb-1"><strong>Username:</strong> <%= request.getAttribute("username") %></p>
                <p class="mb-1"><strong>Role:</strong> <%= request.getAttribute("role") %></p>
                <p class="mb-1"><strong>Login Time:</strong> <%= request.getAttribute("loginTime") %></p>
                <p class="mb-1"><strong>Theme:</strong> <%= request.getAttribute("theme") %></p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <h5>Session Information</h5>
                <p class="mb-1"><strong>Session ID:</strong> <code><%= request.getAttribute("sessionId") %></code></p>
                <p class="mb-1"><strong>Created:</strong> <%= request.getAttribute("sessionCreatedTime") %></p>
                <p class="mb-1"><strong>Last Accessed:</strong> <%= request.getAttribute("sessionLastAccessedTime") %></p>
                <%
                    int maxInactiveInterval = (Integer) request.getAttribute("maxInactiveInterval");
                %>
                <p class="mb-1"><strong>Timeout:</strong> <%= maxInactiveInterval / 60 %> minutes</p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <h5>Cookies</h5>
                <p class="mb-1"><strong>Theme Preference:</strong> <%= request.getAttribute("theme") %></p>
                <p class="mb-1"><strong>Remember Me:</strong> <%= request.getAttribute("rememberMe") %></p>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card p-3">
                <h5>Session Attributes</h5>
                <%
                    List<String> attrList = (List<String>) request.getAttribute("attrList");
                    if (attrList == null || attrList.isEmpty()) {
                %>
                    <p>No session attributes.</p>
                <%
                    } else {
                %>
                    <ul>
                        <%
                            for (String attr : attrList) {
                        %>
                            <li><%= attr %></li>
                        <%
                            }
                        %>
                    </ul>
                <%
                    }
                %>
            </div>
        </div>
    </div>

    <div class="d-flex gap-2">
        <a class="btn btn-primary mr-2" href="students">Manage Students</a>
        <button class="btn btn-secondary" onclick="location.reload()">Refresh</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
