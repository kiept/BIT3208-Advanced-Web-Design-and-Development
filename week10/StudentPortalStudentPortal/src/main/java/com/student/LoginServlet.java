package com.student;

import java.io.IOException;
import java.time.LocalDateTime;
import java.time.format.DateTimeFormatter;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class LoginServlet
 * Handles user authentication, session creation, and cookie management
 */
@WebServlet("/login")
public class LoginServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
	
	// Simple in-memory user validation (in production, query a database)
	private static final String VALID_USERNAME = "student";
	private static final String VALID_PASSWORD = "password123";
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public LoginServlet() {
        super();
    }

	/**
	 * Handles GET requests - displays the login form or redirects if already logged in
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// Check if user is already logged in
		HttpSession session = request.getSession(false);
		if (session != null && session.getAttribute("user") != null) {
			// User is already logged in, redirect to dashboard
			response.sendRedirect("dashboard");
			return;
		}
		
		// Check for "Remember Me" cookie
		String rememberedUsername = "";
		Cookie[] cookies = request.getCookies();
		if (cookies != null) {
			for (Cookie cookie : cookies) {
				if ("rememberMe".equals(cookie.getName())) {
					rememberedUsername = cookie.getValue();
					break;
				}
			}
		}
		
		// Forward to login page with remembered username
		request.setAttribute("rememberedUsername", rememberedUsername);
		request.getRequestDispatcher("login.jsp").forward(request, response);
	}

	/**
	 * Handles POST requests - validates credentials and creates session
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		String username = request.getParameter("username");
		String password = request.getParameter("password");
		String rememberMe = request.getParameter("rememberMe");
		String theme = request.getParameter("theme");
		
		// Validate input
		if (username == null || username.trim().isEmpty() || password == null || password.trim().isEmpty()) {
			request.setAttribute("error", "Username and Password are required!");
			request.getRequestDispatcher("login.jsp").forward(request, response);
			return;
		}
		
		// Validate credentials
		if (validateUser(username.trim(), password.trim())) {
			// Create HttpSession
			HttpSession session = request.getSession(true);
			
			// Store user information in session
			session.setAttribute("user", username.trim());
			session.setAttribute("loginTime", LocalDateTime.now().format(DateTimeFormatter.ofPattern("yyyy-MM-dd HH:mm:ss")));
			session.setAttribute("sessionId", session.getId());
			session.setAttribute("role", "Student");
			
			// Handle "Remember Me" functionality
			if ("on".equals(rememberMe) || "yes".equals(rememberMe)) {
				// Create a cookie to remember the username for 30 days
				Cookie rememberCookie = new Cookie("rememberMe", username.trim());
				rememberCookie.setMaxAge(30 * 24 * 60 * 60); // 30 days
				rememberCookie.setPath("/");
				response.addCookie(rememberCookie);
			}
			
			// Store theme preference in cookie
			if (theme != null && !theme.isEmpty()) {
				Cookie themeCookie = new Cookie("theme", theme);
				themeCookie.setMaxAge(365 * 24 * 60 * 60); // 1 year
				themeCookie.setPath("/");
				response.addCookie(themeCookie);
			} else {
				// Set default theme
				Cookie themeCookie = new Cookie("theme", "Light");
				themeCookie.setMaxAge(365 * 24 * 60 * 60);
				themeCookie.setPath("/");
				response.addCookie(themeCookie);
			}
			
			// Log the event
			System.out.println("[LOGIN] User: " + username + " | Session ID: " + session.getId() + 
							   " | Login Time: " + session.getAttribute("loginTime"));
			
			// Redirect to dashboard servlet
			response.sendRedirect("dashboard");
		} else {
			// Invalid credentials
			request.setAttribute("error", "Invalid username or password!");
			request.setAttribute("rememberedUsername", username.trim());
			request.getRequestDispatcher("login.jsp").forward(request, response);
		}
	}
	
	/**
	 * Validates user credentials
	 * In production, this would query a database
	 * @param username The username to validate
	 * @param password The password to validate
	 * @return true if valid, false otherwise
	 */
	private boolean validateUser(String username, String password) {
		// Hardcoded validation for demonstration
		// In production, query a database
		return username.equals(VALID_USERNAME) && password.equals(VALID_PASSWORD);
	}
	
	/**
	 * Servlet initialization - called once when servlet loads
	 */
	@Override
	public void init() throws ServletException {
		super.init();
		System.out.println("[SERVLET LIFECYCLE] LoginServlet initialized");
	}
	
	/**
	 * Servlet destruction - called once when servlet is unloaded
	 */
	@Override
	public void destroy() {
		System.out.println("[SERVLET LIFECYCLE] LoginServlet destroyed");
		super.destroy();
	}
}
