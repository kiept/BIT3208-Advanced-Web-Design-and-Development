package com.student;

import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Enumeration;
import java.util.List;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

@WebServlet("/dashboard")
public class DashboardServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        HttpSession session = request.getSession(false);
        if (session == null || session.getAttribute("user") == null) {
            response.sendRedirect("login.jsp");
            return;
        }

        String username = (String) session.getAttribute("user");
        String loginTime = (String) session.getAttribute("loginTime");
        String sessionId = (String) session.getAttribute("sessionId");
        String role = (String) session.getAttribute("role");

        // cookies
        Cookie[] cookies = request.getCookies();
        String theme = "Light";
        String rememberMe = "No";
        if (cookies != null) {
            for (Cookie c : cookies) {
                if ("theme".equals(c.getName())) theme = c.getValue();
                if ("rememberMe".equals(c.getName())) rememberMe = "Yes - " + c.getValue();
            }
        }

        // session times
        long creationTime = session.getCreationTime();
        long lastAccessedTime = session.getLastAccessedTime();
        SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
        String sessionCreatedTime = sdf.format(new java.util.Date(creationTime));
        String sessionLastAccessedTime = sdf.format(new java.util.Date(lastAccessedTime));
        int maxInactiveInterval = session.getMaxInactiveInterval();

        // session attributes list
        Enumeration<String> attrs = session.getAttributeNames();
        List<String> attrList = new ArrayList<>();
        while (attrs.hasMoreElements()) {
            attrList.add(attrs.nextElement());
        }

        request.setAttribute("username", username);
        request.setAttribute("loginTime", loginTime);
        request.setAttribute("sessionId", sessionId);
        request.setAttribute("role", role);
        request.setAttribute("theme", theme);
        request.setAttribute("rememberMe", rememberMe);
        request.setAttribute("sessionCreatedTime", sessionCreatedTime);
        request.setAttribute("sessionLastAccessedTime", sessionLastAccessedTime);
        request.setAttribute("maxInactiveInterval", maxInactiveInterval);
        request.setAttribute("attrList", attrList);

        request.getRequestDispatcher("dashboard.jsp").forward(request, response);
    }
}
