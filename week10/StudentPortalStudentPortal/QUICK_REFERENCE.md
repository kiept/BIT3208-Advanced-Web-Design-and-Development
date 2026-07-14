# Quick Reference Guide

## API Quick Reference

### Servlet Lifecycle Methods

```java
@Override
public void init() throws ServletException {
    // Called once when servlet loads
    System.out.println("Servlet initialized");
}

protected void doGet(HttpServletRequest request, HttpServletResponse response) {
    // Called for GET requests
}

protected void doPost(HttpServletRequest request, HttpServletResponse response) {
    // Called for POST requests
}

@Override
public void destroy() {
    // Called once when servlet unloads
    System.out.println("Servlet destroyed");
}
```

---

## Session Management

### Create Session
```java
HttpSession session = request.getSession(true);
// or
HttpSession session = request.getSession();
```

### Store Data in Session
```java
session.setAttribute("user", "john");
session.setAttribute("loginTime", new Date());
session.setAttribute("role", "Student");
```

### Retrieve Data from Session
```java
String user = (String) session.getAttribute("user");
Date loginTime = (Date) session.getAttribute("loginTime");
```

### Destroy Session
```java
session.invalidate();
```

### Get Session ID
```java
String sessionId = session.getId();
```

### Get Session Creation Time
```java
long creationTime = session.getCreationTime(); // milliseconds
```

### Get Last Accessed Time
```java
long lastAccessed = session.getLastAccessedTime();
```

### Get Session Timeout
```java
int timeout = session.getMaxInactiveInterval(); // seconds
```

### Set Session Timeout
```java
session.setMaxInactiveInterval(1800); // 30 minutes
```

### List All Session Attributes
```java
Enumeration<String> attrs = session.getAttributeNames();
while (attrs.hasMoreElements()) {
    String attr = attrs.nextElement();
    Object value = session.getAttribute(attr);
    System.out.println(attr + " = " + value);
}
```

### Check if Session Exists
```java
HttpSession session = request.getSession(false);
if (session != null) {
    // Session exists
} else {
    // No session
}
```

---

## Cookie Management

### Create Cookie
```java
Cookie cookie = new Cookie("name", "value");
response.addCookie(cookie);
```

### Set Cookie Properties
```java
Cookie cookie = new Cookie("theme", "Dark");
cookie.setMaxAge(365 * 24 * 60 * 60);  // 1 year (seconds)
cookie.setPath("/");                     // Available to all pages
cookie.setDomain("example.com");         // Cookie domain
cookie.setHttpOnly(true);                // No JavaScript access
cookie.setSecure(true);                  // HTTPS only
response.addCookie(cookie);
```

### Read Cookies
```java
Cookie[] cookies = request.getCookies();
if (cookies != null) {
    for (Cookie c : cookies) {
        String name = c.getName();
        String value = c.getValue();
        System.out.println(name + "=" + value);
    }
}
```

### Find Specific Cookie
```java
String searchName = "theme";
Cookie[] cookies = request.getCookies();
Cookie found = null;
if (cookies != null) {
    for (Cookie c : cookies) {
        if (c.getName().equals(searchName)) {
            found = c;
            break;
        }
    }
}
```

### Delete Cookie
```java
Cookie cookie = new Cookie("cookieName", "");
cookie.setMaxAge(0);
cookie.setPath("/");
response.addCookie(cookie);
```

### Common Cookie Settings

```java
// Remember user for 30 days
Cookie rememberMe = new Cookie("rememberMe", username);
rememberMe.setMaxAge(30 * 24 * 60 * 60);
response.addCookie(rememberMe);

// Theme preference for 1 year
Cookie theme = new Cookie("theme", "Dark");
theme.setMaxAge(365 * 24 * 60 * 60);
response.addCookie(theme);

// Session-only cookie (deleted when browser closes)
Cookie sessionCookie = new Cookie("sessionData", value);
sessionCookie.setMaxAge(-1);
response.addCookie(sessionCookie);
```

---

## Common Patterns

### Protect Page with Session Check
```java
<%
    HttpSession userSession = request.getSession(false);
    if (userSession == null || userSession.getAttribute("user") == null) {
        response.sendRedirect("login.jsp");
        return;
    }
%>
```

### Login Handling
```java
// Validate credentials
if (validateUser(username, password)) {
    // Create session
    HttpSession session = request.getSession(true);
    session.setAttribute("user", username);
    
    // Optional: Create cookie
    Cookie cookie = new Cookie("rememberMe", username);
    cookie.setMaxAge(30 * 24 * 60 * 60);
    response.addCookie(cookie);
    
    // Redirect
    response.sendRedirect("dashboard.jsp");
} else {
    request.setAttribute("error", "Invalid credentials");
    request.getRequestDispatcher("login.jsp").forward(request, response);
}
```

### Logout Handling
```java
// Get session
HttpSession session = request.getSession(false);

if (session != null) {
    // Invalidate
    session.invalidate();
}

// Optional: Clear cookies
Cookie cookie = new Cookie("rememberMe", "");
cookie.setMaxAge(0);
response.addCookie(cookie);

// Redirect
response.sendRedirect("login.jsp");
```

---

## Request/Response Methods

### Get Request Parameters
```java
String username = request.getParameter("username");
String[] interests = request.getParameterValues("interest");
```

### Get Request Headers
```java
String userAgent = request.getHeader("User-Agent");
String accept = request.getHeader("Accept");
```

### Get Request Information
```java
String method = request.getMethod();           // GET, POST
String uri = request.getRequestURI();          // /app/page.jsp
String query = request.getQueryString();       // param=value
String ip = request.getRemoteAddr();           // Client IP
int port = request.getRemotePort();            // Client port
String host = request.getServerName();         // Server name
int serverPort = request.getServerPort();      // Server port
String protocol = request.getProtocol();       // HTTP/1.1
```

### Send Response
```java
// Set content type
response.setContentType("text/html;charset=UTF-8");

// Get writer
PrintWriter out = response.getWriter();
out.println("<html>...</html>");

// Send redirect
response.sendRedirect("page.jsp");

// Forward to another resource
request.getRequestDispatcher("page.jsp").forward(request, response);
```

---

## JSP Quick Tags

### Check Session
```jsp
<%
    if (session != null && session.getAttribute("user") != null) {
        // User logged in
    }
%>
```

### Display Session Attribute
```jsp
<%= session.getAttribute("user") %>
```

### Iterate Session Attributes
```jsp
<%
    Enumeration<String> attrs = session.getAttributeNames();
    while (attrs.hasMoreElements()) {
        String attr = attrs.nextElement();
        Object value = session.getAttribute(attr);
%>
    <%= attr %>: <%= value %><br>
<%
    }
%>
```

### Display Current Time
```jsp
<%= new java.util.Date() %>
```

### Format Date
```jsp
<%
    java.text.SimpleDateFormat sdf = 
        new java.text.SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
    String formatted = sdf.format(new java.util.Date());
%>
<%= formatted %>
```

---

## web.xml Configuration Examples

### Session Timeout
```xml
<session-config>
    <timeout>30</timeout>  <!-- Minutes -->
</session-config>
```

### Cookie Configuration
```xml
<session-config>
    <cookie-config>
        <name>JSESSIONID</name>
        <domain>example.com</domain>
        <path>/</path>
        <comment>Session cookie</comment>
        <http-only>true</http-only>
        <secure>false</secure>
        <max-age>-1</max-age>
    </cookie-config>
</session-config>
```

### Servlet Mapping
```xml
<servlet-mapping>
    <servlet-name>LoginServlet</servlet-name>
    <url-pattern>/login</url-pattern>
</servlet-mapping>
```

### Error Page
```xml
<error-page>
    <error-code>404</error-code>
    <location>/error.jsp</location>
</error-page>
```

---

## Common Time Conversions

```java
// Milliseconds to seconds
long seconds = milliseconds / 1000;

// Seconds to minutes
long minutes = seconds / 60;

// Create date from milliseconds
long timeInMs = 1234567890;
Date date = new Date(timeInMs);

// Format date
SimpleDateFormat sdf = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
String formatted = sdf.format(date);

// Session timeout calculations
int maxInactiveInterval = session.getMaxInactiveInterval(); // seconds
long timeToTimeout = (maxInactiveInterval * 1000) - 
                     (System.currentTimeMillis() - 
                      session.getLastAccessedTime());
long minutesLeft = timeToTimeout / 60000;
```

---

## Debugging Tips

### Print Session Info
```java
System.out.println("Session ID: " + session.getId());
System.out.println("Created: " + new Date(session.getCreationTime()));
System.out.println("Last Accessed: " + new Date(session.getLastAccessedTime()));
System.out.println("Max Inactive: " + session.getMaxInactiveInterval() + " sec");
```

### Print All Cookies
```java
Cookie[] cookies = request.getCookies();
if (cookies != null) {
    for (Cookie c : cookies) {
        System.out.println(c.getName() + "=" + c.getValue() + 
                          "; MaxAge=" + c.getMaxAge());
    }
}
```

### Print Request Info
```java
System.out.println("Method: " + request.getMethod());
System.out.println("URI: " + request.getRequestURI());
System.out.println("Query: " + request.getQueryString());
System.out.println("Remote IP: " + request.getRemoteAddr());
```

---

## Error Handling

### Check for Null Session
```java
HttpSession session = request.getSession(false);
if (session == null) {
    response.sendRedirect("login.jsp");
    return;
}
```

### Check for Null Attribute
```java
Object value = session.getAttribute("user");
if (value == null) {
    // Handle missing attribute
}
```

### Safe Cookie Reading
```java
String cookieValue = "";
Cookie[] cookies = request.getCookies();
if (cookies != null) {
    for (Cookie c : cookies) {
        if ("cookieName".equals(c.getName())) {
            cookieValue = c.getValue();
            break;
        }
    }
}
```

---

## Performance Tips

1. **Minimize Session Data**
   - Only store essential information
   - Remove large objects
   
2. **Use Appropriate Timeout**
   - 15-30 minutes typical
   - Longer for admin systems
   
3. **Cookie Best Practices**
   - Keep small (< 4KB)
   - Don't store sensitive data
   
4. **Session Cleanup**
   - Always invalidate on logout
   - Handle expiration gracefully

---

## Security Checklist

- [ ] Use HTTPS in production
- [ ] Hash passwords (never plain text)
- [ ] Validate all input
- [ ] Use HttpOnly on cookies
- [ ] Set appropriate timeout
- [ ] Invalidate on logout
- [ ] Use prepared statements for SQL
- [ ] Implement CSRF protection
- [ ] Log security events
- [ ] Regular security updates

---

## Files Quick Reference

| File | Purpose |
|------|---------|
| LoginServlet.java | Handles login |
| LogoutServlet.java | Handles logout |
| login.jsp | Login form page |
| dashboard.jsp | User dashboard |
| session-info.jsp | Session details |
| error.jsp | Error handling |
| web.xml | Configuration |

---

## URL Patterns

```
Login Page:         http://localhost:8080/StudentPortal/login.jsp
Login Action:       http://localhost:8080/StudentPortal/login (POST)
Dashboard:          http://localhost:8080/StudentPortal/dashboard.jsp
Session Info:       http://localhost:8080/StudentPortal/session-info.jsp
Logout Action:      http://localhost:8080/StudentPortal/logout (GET/POST)
Error Page:         http://localhost:8080/StudentPortal/error.jsp
```

---

## Browser Developer Tools (F12)

**View Cookies:**
1. Press F12
2. Application tab
3. Cookies section
4. Select domain
5. View cookie details

**Console for Debugging:**
1. Press F12
2. Console tab
3. JavaScript console available
4. View network requests

---

## Keyboard Shortcuts

| Shortcut | Action |
|----------|--------|
| F12 | Open Developer Tools |
| Ctrl+Shift+I | Open Inspector |
| Ctrl+Shift+K | Open Console |
| Ctrl+Shift+M | Toggle Device Mode |
| Ctrl+F5 | Hard Refresh (clear cache) |
| Ctrl+Shift+Delete | Open Clear History |

---

## Common Port Numbers

| Service | Port |
|---------|------|
| HTTP | 8080 |
| HTTPS | 8443 |
| MySQL | 3306 |
| PostgreSQL | 5432 |
| Oracle | 1521 |
| MongoDB | 27017 |

---

## Useful Commands

### Compile Java Files
```bash
javac -d build/classes src/main/java/com/student/*.java
```

### Start Tomcat
```bash
# Windows
catalina.bat run

# Linux/Mac
./catalina.sh run
```

### Stop Tomcat
```bash
# Windows (Ctrl+C or)
catalina.bat stop

# Linux/Mac (Ctrl+C or)
./catalina.sh stop
```

### View Tomcat Logs
```bash
# Linux/Mac
tail -f logs/catalina.out

# Windows
type logs\catalina.out
```

---

**Last Updated**: July 2024
**Version**: 1.0
