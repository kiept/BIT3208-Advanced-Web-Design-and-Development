<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.util.Enumeration" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Portal - Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .dashboard-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .navbar {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .navbar h1 {
            color: #667eea;
            font-size: 24px;
        }

        .logout-button {
            background: #d32f2f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: background 0.3s;
        }

        .logout-button:hover {
            background: #c62828;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .card h2 {
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            font-size: 18px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #555;
            flex: 1;
        }

        .info-value {
            color: #667eea;
            font-weight: 500;
            text-align: right;
            flex: 1;
            word-break: break-all;
        }

        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-section h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .welcome-section p {
            font-size: 16px;
            opacity: 0.9;
        }

        .session-details {
            background: #f0f7ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .session-details strong {
            color: #667eea;
        }

        .session-details .detail {
            margin: 8px 0;
            font-size: 13px;
        }

        .session-details .detail code {
            background: white;
            padding: 2px 5px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }

        .cookie-section {
            background: #fff3e0;
            border-left: 4px solid #ff9800;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        .cookie-section strong {
            color: #ff6f00;
        }

        .cookie-section .detail {
            margin: 8px 0;
            font-size: 13px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .button-group button {
            flex: 1;
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .button-primary {
            background: #667eea;
            color: white;
        }

        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .button-danger {
            background: #d32f2f;
            color: white;
        }

        .button-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(211, 47, 47, 0.4);
        }

        .no-session {
            background: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 20px;
            border-radius: 5px;
            color: #d32f2f;
            text-align: center;
        }

        .lesson-info {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: #1565c0;
        }

        .lesson-info strong {
            color: #0d47a1;
        }

        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
            }

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .navbar h1 {
                width: 100%;
            }

            .logout-button {
                width: 100%;
            }

            .button-group {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <%
        // Check if user is logged in by checking session
        HttpSession userSession = request.getSession(false);
        
        if (userSession == null || userSession.getAttribute("user") == null) {
            // User is not logged in, redirect to login page
            response.sendRedirect("login.jsp");
            return;
        }
        
        // Get session attributes
        String username = (String) userSession.getAttribute("user");
        String loginTime = (String) userSession.getAttribute("loginTime");
        String sessionId = (String) userSession.getAttribute("sessionId");
        String role = (String) userSession.getAttribute("role");
        
        // Get cookies
        Cookie[] cookies = request.getCookies();
        String theme = "Light";
        String rememberMe = "No";
        
        if (cookies != null) {
            for (Cookie cookie : cookies) {
                if ("theme".equals(cookie.getName())) {
                    theme = cookie.getValue();
                }
                if ("rememberMe".equals(cookie.getName())) {
                    rememberMe = "Yes - " + cookie.getValue();
                }
            }
        }
        
        // Get session creation time
        long creationTime = userSession.getCreationTime();
        java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String sessionCreatedTime = sdf.format(new java.util.Date(creationTime));
        
        // Get last accessed time
        long lastAccessedTime = userSession.getLastAccessedTime();
        String sessionLastAccessedTime = sdf.format(new java.util.Date(lastAccessedTime));
        
        // Get session max inactive interval
        int maxInactiveInterval = userSession.getMaxInactiveInterval();
    %>

    <div class="dashboard-container">
        <!-- Navigation Bar -->
        <div class="navbar">
            <h1>🎓 Student Portal Dashboard</h1>
            <a href="logout" class="logout-button">Logout</a>
        </div>

        <!-- Welcome Section -->
        <div class="welcome-section">
            <h1>Welcome, <%= username %>! 👋</h1>
            <p>You have successfully logged into your Student Portal</p>
        </div>

        <!-- Main Content Grid -->
        <div class="content-grid">
            <!-- User Information Card -->
            <div class="card">
                <h2>👤 User Information</h2>
                <div class="info-row">
                    <span class="info-label">Username:</span>
                    <span class="info-value"><%= username %></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role:</span>
                    <span class="info-value"><%= role %></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Login Time:</span>
                    <span class="info-value"><%= loginTime %></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Current Theme:</span>
                    <span class="info-value"><%= theme %></span>
                </div>
            </div>

            <!-- Session Information Card -->
            <div class="card">
                <h2>🔐 Session Information</h2>
                <div class="session-details">
                    <strong>Session Management Details:</strong>
                    <div class="detail">Session ID: <code><%= sessionId %></code></div>
                    <div class="detail">Created: <%= sessionCreatedTime %></div>
                    <div class="detail">Last Accessed: <%= sessionLastAccessedTime %></div>
                    <div class="detail">Timeout: <%= maxInactiveInterval / 60 %> minutes</div>
                    <div class="detail" style="margin-top: 10px;">
                        <strong>Status:</strong> ✅ Active and Secure
                    </div>
                </div>
            </div>

            <!-- Cookie Information Card -->
            <div class="card">
                <h2>🍪 Cookie Information</h2>
                <div class="cookie-section">
                    <strong>Stored Cookies:</strong>
                    <div class="detail">Theme Preference: <%= theme %></div>
                    <div class="detail">Remember Me: <%= rememberMe %></div>
                    <div class="detail" style="margin-top: 10px;">
                        <strong>Cookie Storage:</strong> Browser-based, used for personalization
                    </div>
                </div>
            </div>

            <!-- Session Details Card -->
            <div class="card">
                <h2>📊 Session Details</h2>
                <div class="info-row">
                    <span class="info-label">Total Attributes:</span>
                    <span class="info-value"><%= userSession.getAttributeNames().hasMoreElements() ? "3+" : "N/A" %></span>
                </div>
                <%
                    Enumeration<String> attrs = userSession.getAttributeNames();
                    int attrCount = 0;
                    while (attrs.hasMoreElements()) {
                        attrCount++;
                        String attr = attrs.nextElement();
                %>
                    <div class="info-row">
                        <span class="info-label">Attribute <%= attrCount %>:</span>
                        <span class="info-value"><%= attr %></span>
                    </div>
                <%
                    }
                %>
            </div>

            <!-- Lesson Information -->
            <div class="card full-width">
                <h2>📚 About This Application</h2>
                <div class="lesson-info">
                    <strong>Learning Objectives Demonstrated:</strong>
                    <p style="margin-top: 10px;">
                        ✓ <strong>Servlet Lifecycle:</strong> LoginServlet and LogoutServlet handle init(), service(), and destroy() methods<br>
                        ✓ <strong>Session Management:</strong> HttpSession stores user information server-side (secure)<br>
                        ✓ <strong>Cookies:</strong> Browser stores theme preference and remember-me functionality<br>
                        ✓ <strong>Stateful Communication:</strong> HTTP stateless protocol overcome using sessions<br>
                        ✓ <strong>Security:</strong> Sessions managed securely with timeout and invalidation<br>
                        ✓ <strong>Deployment:</strong> Running on Apache Tomcat with proper servlet mapping
                    </p>
                </div>

                <div class="button-group" style="margin-top: 20px;">
                    <button class="button-primary" onclick="location.reload()">🔄 Refresh Page</button>
                    <button class="button-primary" onclick="viewSessionInfo()">📋 View Full Session Info</button>
                    <a href="logout" style="text-decoration: none;">
                        <button class="button-danger" style="width: 100%;">🚪 Logout</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function viewSessionInfo() {
            const sessionInfo = `
Session ID: <%= sessionId %>
Username: <%= username %>
Login Time: <%= loginTime %>
Role: <%= role %>
Current Theme: <%= theme %>
Remember Me: <%= rememberMe %>
Session Created: <%= sessionCreatedTime %>
Last Accessed: <%= sessionLastAccessedTime %>
Session Timeout: <%= maxInactiveInterval / 60 %> minutes
            `;
            alert(sessionInfo);
        }

        // Optional: Show alert if session is about to expire (< 2 minutes remaining)
        let sessionTimeout = <%= maxInactiveInterval * 1000 %>; // Convert to milliseconds
        let warningTimeout = setTimeout(function() {
            console.warn('Session is about to expire. Please save your work.');
        }, sessionTimeout - 120000); // 2 minutes before timeout

        // Clear warning if page is active
        document.addEventListener('mousemove', function() {
            clearTimeout(warningTimeout);
            warningTimeout = setTimeout(function() {
                console.warn('Session is about to expire. Please save your work.');
            }, sessionTimeout - 120000);
        });
    </script>
</body>
</html>
