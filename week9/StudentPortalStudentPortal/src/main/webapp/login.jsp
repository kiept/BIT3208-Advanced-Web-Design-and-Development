<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 10px;
        }

        .login-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 400px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 5px;
        }

        .login-header p {
            color: #666;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
            font-size: 14px;
        }

        .form-group input[type="text"],
        .form-group input[type="password"],
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus,
        .form-group select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group.checkbox {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .form-group.checkbox input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            cursor: pointer;
        }

        .form-group.checkbox label {
            margin: 0;
            cursor: pointer;
            font-size: 13px;
        }

        .error-message {
            color: #d32f2f;
            background-color: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success-message {
            color: #388e3c;
            background-color: #e8f5e9;
            border-left: 4px solid #388e3c;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }

        .login-button:active {
            transform: translateY(0);
        }

        .demo-credentials {
            background-color: #f5f5f5;
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }

        .demo-credentials h4 {
            margin-bottom: 8px;
            color: #333;
        }

        .demo-credentials p {
            margin: 5px 0;
        }

        .demo-credentials code {
            background-color: #fff;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            color: #e74c3c;
        }

        .form-info {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #999;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 25px;
            }

            .login-header h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h1>🎓 Student Portal</h1>
            <p>Secure Login System</p>
        </div>

        <%
            // Display error message if login failed
            String error = (String) request.getAttribute("error");
            String rememberedUsername = (String) request.getAttribute("rememberedUsername");
            if (rememberedUsername == null) {
                rememberedUsername = "";
            }
        %>

        <% if (error != null && !error.isEmpty()) { %>
            <div class="error-message">
                <strong>Login Failed:</strong> <%= error %>
            </div>
        <% } %>

        <form method="POST" action="login" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" value="<%= rememberedUsername %>" 
                       placeholder="Enter your username" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" 
                       placeholder="Enter your password" required autocomplete="current-password">
            </div>

            <div class="form-group">
                <label for="theme">Preferred Theme:</label>
                <select id="theme" name="theme">
                    <option value="Light">Light Mode</option>
                    <option value="Dark">Dark Mode</option>
                    <option value="Blue">Blue Mode</option>
                </select>
            </div>

            <div class="form-group checkbox">
                <input type="checkbox" id="rememberMe" name="rememberMe" value="yes">
                <label for="rememberMe">Remember my username</label>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>

        <div class="demo-credentials">
            <h4>📝 Demo Credentials:</h4>
            <p>Username: <code>student</code></p>
            <p>Password: <code>password123</code></p>
            <p style="margin-top: 10px; font-style: italic;">
                Use these credentials to test the application's session and cookie functionality.
            </p>
        </div>

        <div class="form-info">
            <p>Session Timeout: 30 minutes | All sessions are secure and encrypted</p>
        </div>
    </div>

    <script>
        function validateForm() {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === '') {
                alert('Please enter your username!');
                document.getElementById('username').focus();
                return false;
            }

            if (password === '') {
                alert('Please enter your password!');
                document.getElementById('password').focus();
                return false;
            }

            if (username.length < 3) {
                alert('Username must be at least 3 characters long!');
                document.getElementById('username').focus();
                return false;
            }

            if (password.length < 6) {
                alert('Password must be at least 6 characters long!');
                document.getElementById('password').focus();
                return false;
            }

            return true;
        }

        // Check for remembered username on page load
        window.addEventListener('load', function() {
            const username = document.getElementById('username').value;
            if (username) {
                document.getElementById('rememberMe').checked = true;
            }
        });
    </script>
</body>
</html>
