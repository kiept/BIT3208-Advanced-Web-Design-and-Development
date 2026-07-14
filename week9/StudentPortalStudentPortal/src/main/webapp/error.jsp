<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Student Portal</title>
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

        .error-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            padding: 40px;
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .error-icon {
            font-size: 64px;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 32px;
            font-weight: bold;
            color: #d32f2f;
            margin-bottom: 10px;
        }

        .error-message {
            font-size: 18px;
            color: #333;
            margin-bottom: 10px;
        }

        .error-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .error-buttons {
            display: flex;
            gap: 10px;
            flex-direction: column;
        }

        .error-button {
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none;
            display: inline-block;
        }

        .error-button-primary {
            background: #667eea;
            color: white;
        }

        .error-button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .error-button-secondary {
            background: #f5f5f5;
            color: #333;
            border: 1px solid #ddd;
        }

        .error-button-secondary:hover {
            background: #eee;
        }

        .error-details {
            background: #f5f5f5;
            border-left: 4px solid #d32f2f;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            text-align: left;
            font-size: 12px;
            color: #666;
        }

        .error-details strong {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        .error-details code {
            display: block;
            background: white;
            padding: 5px;
            border-radius: 3px;
            margin: 5px 0;
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">❌</div>
        
        <div class="error-code">
            <%= pageContext.getErrorData().getStatusCode() %>
        </div>
        
        <div class="error-message">
            Page Not Found
        </div>
        
        <div class="error-description">
            The page you are looking for does not exist or has been moved. 
            Please check the URL and try again, or navigate back to the login page.
        </div>
        
        <div class="error-buttons">
            <a href="login.jsp" class="error-button error-button-primary">Go to Login</a>
            <button class="error-button error-button-secondary" onclick="history.back()">Go Back</button>
        </div>
        
        <div class="error-details">
            <strong>Error Details:</strong>
            <code>Timestamp: <%= new java.util.Date() %></code>
            <code>Request URI: <%= pageContext.getErrorData().getRequestURI() %></code>
        </div>
    </div>
</body>
</html>
