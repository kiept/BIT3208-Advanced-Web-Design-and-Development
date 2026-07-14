<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ page import="java.util.Enumeration" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Information - Student Portal</title>
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

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #667eea;
            font-size: 24px;
        }

        .back-button {
            background: #667eea;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
        }

        .back-button:hover {
            background: #764ba2;
        }

        .info-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .info-card h2 {
            color: #333;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
            font-size: 18px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th {
            background: #f5f5f5;
            color: #333;
            text-align: left;
            padding: 12px;
            border-bottom: 2px solid #ddd;
            font-weight: 600;
        }

        .info-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .info-table tr:hover {
            background: #f9f9f9;
        }

        .label-cell {
            font-weight: 600;
            color: #555;
            width: 30%;
        }

        .value-cell {
            color: #667eea;
            word-break: break-all;
        }

        .code {
            background: #f0f0f0;
            padding: 5px 10px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
            font-size: 12px;
        }

        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #856404;
            font-size: 14px;
        }

        .success {
            background: #d4edda;
            border-left: 4px solid #28a745;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            color: #155724;
            font-size: 14px;
        }

        .legend {
            background: #e3f2fd;
            border-left: 4px solid #2196f3;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: #1565c0;
            line-height: 1.6;
        }

        .no-session {
            background: #ffebee;
            border-left: 4px solid #d32f2f;
            padding: 20px;
            border-radius: 5px;
            color: #d32f2f;
            text-align: center;
        }

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
            }

            .back-button {
                width: 100%;
                text-align: center;
            }

            .info-table {
                font-size: 12px;
            }

            .info-table th,
            .info-table td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Session Information</h1>
            <a href="dashboard.jsp" class="back-button">← Back to Dashboard</a>
        </div>

        <%
            HttpSession userSession = request.getSession(false);
            
            if (userSession == null || userSession.getAttribute("user") == null) {
        %>
            <div class="info-card">
                <div class="no-session">
                    <h2>❌ No Active Session</h2>
                    <p>You are not logged in. Please <a href="login.jsp" style="color: inherit; font-weight: bold;">log in</a> to view session information.</p>
                </div>
            </div>
        <%
            } else {
                String username = (String) userSession.getAttribute("user");
                String loginTime = (String) userSession.getAttribute("loginTime");
                String sessionId = (String) userSession.getAttribute("sessionId");
                String role = (String) userSession.getAttribute("role");
                
                long creationTime = userSession.getCreationTime();
                long lastAccessedTime = userSession.getLastAccessedTime();
                int maxInactiveInterval = userSession.getMaxInactiveInterval();
                
                java.text.SimpleDateFormat sdf = new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss.SSS");
                String sessionCreatedTime = sdf.format(new java.util.Date(creationTime));
                String sessionLastAccessedTime = sdf.format(new java.util.Date(lastAccessedTime));
                
                long sessionDuration = (lastAccessedTime - creationTime) / 1000; // in seconds
                long sessionDurationMinutes = sessionDuration / 60;
                long sessionDurationSeconds = sessionDuration % 60;
        %>
            <!-- Session Overview -->
            <div class="success">
                ✅ <strong>Session Status:</strong> Active and Valid | Session has been running for <%= sessionDurationMinutes %>m <%= sessionDurationSeconds %>s
            </div>

            <!-- Basic Session Information -->
            <div class="info-card">
                <h2>🔐 Basic Session Information</h2>
                <table class="info-table">
                    <tr>
                        <td class="label-cell">Session ID:</td>
                        <td class="value-cell"><span class="code"><%= sessionId %></span></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Username:</td>
                        <td class="value-cell"><%= username %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">User Role:</td>
                        <td class="value-cell"><%= role %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Login Time:</td>
                        <td class="value-cell"><%= loginTime %></td>
                    </tr>
                </table>
            </div>

            <!-- Session Lifecycle Information -->
            <div class="info-card">
                <h2>⏱️ Session Lifecycle</h2>
                <table class="info-table">
                    <tr>
                        <td class="label-cell">Session Created:</td>
                        <td class="value-cell"><%= sessionCreatedTime %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Last Accessed:</td>
                        <td class="value-cell"><%= sessionLastAccessedTime %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Session Duration:</td>
                        <td class="value-cell"><%= sessionDurationMinutes %> minutes <%= sessionDurationSeconds %> seconds</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Inactivity Timeout:</td>
                        <td class="value-cell"><%= maxInactiveInterval %> seconds (<%= maxInactiveInterval / 60 %> minutes)</td>
                    </tr>
                    <tr>
                        <td class="label-cell">Time to Auto-Logout:</td>
                        <td class="value-cell"><%= (maxInactiveInterval * 1000 - (System.currentTimeMillis() - lastAccessedTime)) / 1000 %> seconds</td>
                    </tr>
                </table>
            </div>

            <!-- Session Attributes -->
            <div class="info-card">
                <h2>📋 Session Attributes</h2>
                <table class="info-table">
                    <thead>
                        <tr>
                            <th>Attribute Name</th>
                            <th>Attribute Value</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <%
                            Enumeration<String> attrs = userSession.getAttributeNames();
                            boolean hasAttributes = false;
                            while (attrs.hasMoreElements()) {
                                hasAttributes = true;
                                String attrName = attrs.nextElement();
                                Object attrValue = userSession.getAttribute(attrName);
                                String attrType = attrValue != null ? attrValue.getClass().getSimpleName() : "null";
                        %>
                        <tr>
                            <td class="label-cell"><span class="code"><%= attrName %></span></td>
                            <td class="value-cell"><%= attrValue %></td>
                            <td class="value-cell"><span class="code"><%= attrType %></span></td>
                        </tr>
                        <%
                            }
                            if (!hasAttributes) {
                        %>
                        <tr>
                            <td colspan="3" style="text-align: center; color: #999;">No additional attributes stored</td>
                        </tr>
                        <%
                            }
                        %>
                    </tbody>
                </table>
            </div>

            <!-- Request Information -->
            <div class="info-card">
                <h2>📡 Request Information</h2>
                <table class="info-table">
                    <tr>
                        <td class="label-cell">Request Method:</td>
                        <td class="value-cell"><%= request.getMethod() %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Request URI:</td>
                        <td class="value-cell"><span class="code"><%= request.getRequestURI() %></span></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Query String:</td>
                        <td class="value-cell"><%= request.getQueryString() != null ? request.getQueryString() : "None" %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">Remote Address:</td>
                        <td class="value-cell"><%= request.getRemoteAddr() %></td>
                    </tr>
                    <tr>
                        <td class="label-cell">User Agent:</td>
                        <td class="value-cell"><span class="code"><%= request.getHeader("User-Agent") %></span></td>
                    </tr>
                </table>
            </div>

            <!-- Session Management Legend -->
            <div class="legend">
                <strong>ℹ️ Session Management Information:</strong>
                <p style="margin-top: 10px;">
                    • <strong>Session ID:</strong> Unique identifier for this session, stored in cookies and transmitted with each request<br>
                    • <strong>Session Attributes:</strong> Data stored server-side for the user (secure, not visible in cookies)<br>
                    • <strong>Inactivity Timeout:</strong> Session automatically expires if no requests received within this time<br>
                    • <strong>Session Lifecycle:</strong> Created on login, updated on each request, destroyed on logout or timeout<br>
                    • <strong>Security:</strong> Sessions are managed by Apache Tomcat with secure cookie configuration
                </p>
            </div>

            <!-- Warning if session is about to expire -->
            <%
                long timeUntilTimeout = (maxInactiveInterval * 1000) - (System.currentTimeMillis() - lastAccessedTime);
                if (timeUntilTimeout < 600000) { // Less than 10 minutes
            %>
            <div class="warning">
                ⚠️ <strong>Warning:</strong> Your session will expire in <%= timeUntilTimeout / 60000 %> minutes. 
                Please refresh the page or make a request to extend your session.
            </div>
            <%
                }
            %>
        <%
            }
        %>
    </div>
</body>
</html>
