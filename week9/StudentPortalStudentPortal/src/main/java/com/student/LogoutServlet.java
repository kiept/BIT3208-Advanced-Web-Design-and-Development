package com.student;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.Cookie;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;

/**
 * Servlet implementation class LogoutServlet
 * Handles user logout, session destruction, and cookie clearing
 */
@WebServlet("/logout")
public class LogoutServlet extends HttpServlet {
	private static final long serialVersionUID = 1L;
       
    /**
     * @see HttpServlet#HttpServlet()
     */
    public LogoutServlet() {
        super();
    }

	/**
	 * Handles GET requests - logs out the user and destroys the session
	 * @see HttpServlet#doGet(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		// Get the current session
		HttpSession session = request.getSession(false);
		
		if (session != null) {
			// Log the logout event
			String username = (String) session.getAttribute("user");
			String sessionId = session.getId();
			System.out.println("[LOGOUT] User: " + username + " | Session ID: " + sessionId);
			
			// Invalidate the session (destroys all session data)
			session.invalidate();
		}
		
		// Clear theme cookie by setting max age to 0
		Cookie[] cookies = request.getCookies();
		if (cookies != null) {
			for (Cookie cookie : cookies) {
				if ("theme".equals(cookie.getName())) {
					Cookie clearCookie = new Cookie("theme", "");
					clearCookie.setMaxAge(0);
					clearCookie.setPath("/");
					response.addCookie(clearCookie);
				}
			}
		}
		
		// Optional: Clear "rememberMe" cookie if user didn't want it
		// Cookie rememberCookie = new Cookie("rememberMe", "");
		// rememberCookie.setMaxAge(0);
		// rememberCookie.setPath("/");
		// response.addCookie(rememberCookie);
		
		// Display logout message and redirect to login page
		response.setContentType("text/html;charset=UTF-8");
		response.getWriter().println("<html>");
		response.getWriter().println("<head><title>Logout</title></head>");
		response.getWriter().println("<body>");
		response.getWriter().println("<h2>Logout Successful</h2>");
		response.getWriter().println("<p>You have been successfully logged out.</p>");
		response.getWriter().println("<p>Redirecting to login page...</p>");
		response.getWriter().println("<script>");
		response.getWriter().println("setTimeout(function() {");
		response.getWriter().println("  window.location.href = 'login.jsp';");
		response.getWriter().println("}, 2000);");
		response.getWriter().println("</script>");
		response.getWriter().println("</body>");
		response.getWriter().println("</html>");
	}

	/**
	 * Handles POST requests - delegates to doGet
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		doGet(request, response);
	}
	
	/**
	 * Servlet initialization - called once when servlet loads
	 */
	@Override
	public void init() throws ServletException {
		super.init();
		System.out.println("[SERVLET LIFECYCLE] LogoutServlet initialized");
	}
	
	/**
	 * Servlet destruction - called once when servlet is unloaded
	 */
	@Override
	public void destroy() {
		System.out.println("[SERVLET LIFECYCLE] LogoutServlet destroyed");
		super.destroy();
	}
}
