# Java Web Services: Servlet Lifecycle, Session Management, and Cookies

## Project Overview

This project demonstrates a comprehensive implementation of Java web services with focus on:
- **Servlet Lifecycle**: Understanding init(), service(), and destroy() methods
- **Session Management**: Using HttpSession for server-side user tracking
- **Cookies**: Browser-based storage for user preferences
- **Authentication**: Simple login system with session tracking

## Project Structure

```
StudentPortal/
├── src/
│   └── main/
│       ├── java/
│       │   └── com/
│       │       └── student/
│       │           ├── LoginServlet.java      # Handles user login and session creation
│       │           └── LogoutServlet.java     # Handles user logout and session destruction
│       └── webapp/
│           ├── WEB-INF/
│           │   └── web.xml                    # Servlet configuration and mapping
│           ├── login.jsp                      # Login page with form
│           ├── dashboard.jsp                  # User dashboard after login
│           ├── session-info.jsp               # Detailed session information display
│           └── error.jsp                      # Error page for 404 errors
└── build/
    └── classes/
        └── [compiled Java classes]
```

## Features Implemented

### 1. **LoginServlet** (`LoginServlet.java`)
- **GET Request**: Displays login form, checks for remembered username
- **POST Request**: Validates credentials, creates HttpSession, manages cookies
- **Remember Me**: Creates persistent cookie for 30 days
- **Theme Preference**: Stores user's theme choice in cookie
- **Lifecycle Methods**:
  - `init()`: Called once when servlet loads
  - `service()`: Called for each request (handled by doGet/doPost)
  - `destroy()`: Called when servlet unloads

### 2. **LogoutServlet** (`LogoutServlet.java`)
- Invalidates user session
- Clears preference cookies
- Redirects to login page
- Logs logout event to server console

### 3. **Login Page** (`login.jsp`)
- Professional UI with gradient background
- Form validation (client-side & server-side)
- Remember Me checkbox for persistent login
- Theme selection dropdown (Light/Dark/Blue)
- Demo credentials display
- Error message display
- Responsive design

### 4. **Dashboard** (`dashboard.jsp`)
- Requires active session to access
- Displays user information
- Shows session details (ID, creation time, timeout)
- Displays cookies information
- Quick links to view detailed session info
- Logout button

### 5. **Session Info Page** (`session-info.jsp`)
- Detailed session lifecycle information
- Session attribute listing
- Request information
- Session timeout warnings
- Educational legend about session management

### 6. **Error Page** (`error.jsp`)
- Handles 404 errors
- User-friendly error display
- Links back to login page

## Session Management Explained

### How Sessions Work

1. **Session Creation**:
   ```java
   HttpSession session = request.getSession(true);
   session.setAttribute("user", username);
   ```

2. **Session Retrieval**:
   ```java
   HttpSession session = request.getSession(false);
   String user = (String) session.getAttribute("user");
   ```

3. **Session Destruction**:
   ```java
   session.invalidate();
   ```

### Session vs Cookies

| Feature | Session | Cookie |
|---------|---------|--------|
| Storage Location | Server | Browser |
| Security | More Secure | Less Secure |
| Storage Capacity | Unlimited | ~4KB |
| Access | Server-side only | Client can access |
| Best For | Authentication | Preferences |
| Timeout | Automatic | User-controlled |

## Cookies Implementation

### Creating a Cookie
```java
Cookie cookie = new Cookie("theme", "Dark");
cookie.setMaxAge(365 * 24 * 60 * 60); // 1 year
response.addCookie(cookie);
```

### Reading Cookies
```java
Cookie[] cookies = request.getCookies();
if (cookies != null) {
    for (Cookie c : cookies) {
        System.out.println(c.getName() + "=" + c.getValue());
    }
}
```

### Deleting a Cookie
```java
cookie.setMaxAge(0);
response.addCookie(cookie);
```

## Default Credentials

For testing purposes, use these credentials:
- **Username**: `student`
- **Password**: `password123`

## Deployment Instructions

### Prerequisites
- Eclipse IDE
- Apache Tomcat 9.0+
- Java 8 or higher

### Step 1: Create Dynamic Web Project
1. Open Eclipse
2. File → New → Dynamic Web Project
3. Project name: `StudentPortal`
4. Select Apache Tomcat as target runtime
5. Click Finish

### Step 2: Configure Tomcat
1. In Eclipse, go to Window → Preferences
2. Expand Server and select Runtime Environments
3. Click Add and select Apache Tomcat v9.0
4. Browse to Tomcat installation directory
5. Click Finish

### Step 3: Deploy Application
1. Copy all servlet files to `src/main/java/com/student/`
2. Copy all JSP files to `src/main/webapp/`
3. Update `web.xml` with provided configuration
4. Right-click project → Run As → Run on Server
5. Select Apache Tomcat v9.0
6. Click Finish

### Step 4: Access Application
1. Open browser
2. Navigate to: `http://localhost:8080/StudentPortal/login.jsp`
3. Use demo credentials to login

## Database & JDBC Setup (Week 10)

1. Create the database and table in MySQL (run these commands in your MySQL client):

   CREATE DATABASE studentdb;
   USE studentdb;
   CREATE TABLE students (
     id INT PRIMARY KEY AUTO_INCREMENT,
     name VARCHAR(100),
     course VARCHAR(100),
     email VARCHAR(100)
   );

2. MySQL Connector/J (JDBC driver):
   - Download the driver (mysql-connector-java) from MySQL website.
   - If using the JNDI DataSource (recommended), place the connector JAR in TOMCAT_HOME/lib so the container can create the DataSource.
   - If not using JNDI, you can place the connector JAR in `WEB-INF/lib/` of this webapp.

3. JNDI DataSource (recommended):
   - A sample `META-INF/context.xml` is included in this project. Edit `src/main/webapp/META-INF/context.xml` to match your DB username/password and URL.
   - Ensure `WEB-INF/web.xml` has the `<resource-ref>` for `jdbc/studentdb` (already included).
   - Restart Tomcat after placing the connector JAR and deploying the app.

4. JSTL (for JSP tag support):
   - This project uses JSTL tag library in the students and edit pages. Add the JSTL implementation JARs (e.g., `javax.servlet.jsp.jstl` and the implementation like `org.glassfish.web`) into `WEB-INF/lib` or your server libs.

5. DBUtil behavior in this project:
   - `DBUtil` looks up a JNDI DataSource at `java:comp/env/jdbc/studentdb` and will fail to initialize if the DataSource is not found.
   - Edit `src/main/webapp/META-INF/context.xml` or configure Tomcat to provide the `jdbc/studentdb` Resource.

## Quick Checklist to Run (summary)

- Create DB & table
- Put MySQL Connector/J jar into TOMCAT_HOME/lib
- (Optional) Adjust `META-INF/context.xml` credentials
- Start Tomcat and deploy the webapp
- Visit `/login.jsp` and use demo credentials

## Servlet Lifecycle Explained

### 1. **init() Method**
- Called **once** when servlet first loads
- Initializes resources
- Example:
  ```java
  @Override
  public void init() throws ServletException {
      System.out.println("LoginServlet initialized");
  }
  ```

### 2. **service() Method**
- Called **every time** a client sends a request
- Automatically routes to doGet() or doPost()
- Runs in separate thread for each request

### 3. **destroy() Method**
- Called **once** before servlet is unloaded
- Closes resources, saves data
- Example:
  ```java
  @Override
  public void destroy() {
      System.out.println("LoginServlet destroyed");
  }
  ```

### Lifecycle Diagram
```
                    ↓
            Load Servlet Class
                    ↓
            Create Instance
                    ↓
           Call init() [Once]
                    ↓
    ┌─────────────────────────────┐
    │  For Each Client Request:   │
    │  Call service()             │
    │  (routes to doGet/doPost)   │
    │                             │
    │  service() → doGet/doPost   │
    └─────────────────────────────┘
                    ↓
      [When Tomcat Stops/Reloads]
                    ↓
           Call destroy() [Once]
                    ↓
        Unload Servlet from Memory
```

## HTTP is Stateless - Why Sessions Matter

### Without Sessions
```
User Login Request
    ↓
Server: "Welcome John"
    ↓
User Views Dashboard
    ↓
Server: "Who are you?" (HTTP forgets)
    ↓
User must login again!
```

### With Sessions
```
User Login Request
    ↓
Server: Creates session, stores "John"
    ↓
User Views Dashboard
    ↓
Server: "Session says John" (Remembers!)
    ↓
User continues browsing
```

## Key Concepts

### 1. **Session ID**
- Unique identifier for each session
- Transmitted in JSESSIONID cookie
- Enables server to identify returning users

### 2. **Session Timeout**
- Default: 30 minutes (configured in web.xml)
- After timeout, session is automatically destroyed
- Enhances security by limiting session duration

### 3. **Session Invalidation**
- Manually called on logout
- Clears all session attributes
- Forces user to login again

### 4. **Cookie Configuration** (web.xml)
```xml
<session-config>
    <cookie-config>
        <http-only>true</http-only>
        <secure>false</secure>
    </cookie-config>
    <timeout>30</timeout>
</session-config>
```

## Testing the Application

### Test Case 1: Login
1. Go to login.jsp
2. Enter username: `student`
3. Enter password: `password123`
4. Select theme preference
5. Click Login
6. Observe: Welcome page, session ID displayed

### Test Case 2: Remember Me
1. Check "Remember my username"
2. Logout
3. Return to login page
4. Observe: Username is pre-filled

### Test Case 3: Session Timeout
1. Login to application
2. Wait 30 minutes without activity
3. Try to access dashboard
4. Observe: Redirected to login page (session expired)

### Test Case 4: Cookie Verification
1. Login and check dashboard
2. Open browser developer tools (F12)
3. Go to Application → Cookies
4. Verify: JSESSIONID and theme cookies exist
5. Note: Passwords never stored in cookies

### Test Case 5: Logout
1. Click Logout button
2. Observe: Session invalidated message
3. Return to dashboard
4. Observe: Redirected to login

## Server Console Output

When running on Tomcat, you'll see:
```
[SERVLET LIFECYCLE] LoginServlet initialized
[LOGIN] User: student | Session ID: ABC123... | Login Time: 2024-07-13 14:30:45
[LOGOUT] User: student | Session ID: ABC123...
[SERVLET LIFECYCLE] LogoutServlet initialized
```

## Security Best Practices

1. **Never store passwords in cookies**
2. **Use HTTPS in production** for encrypted communication
3. **Set HttpOnly flag** on cookies (already done in web.xml)
4. **Validate all user input** (done in LoginServlet)
5. **Use strong session timeouts** (30 minutes recommended)
6. **Invalidate sessions on logout** (implemented)
7. **Protect sensitive pages** with session checks (implemented)

## Common Issues and Solutions

| Issue | Cause | Solution |
|-------|-------|----------|
| 404 Error on /login | Servlet not mapped | Check web.xml mapping |
| Session becomes null | Session expired | Login again or adjust timeout |
| Cookie not persisting | Browser blocks cookies | Enable cookies or use HttpSession |
| Page refresh loses data | No session check | Implement session validation |
| Tomcat won't start | Port already in use | Change port 8080 to 8081 |

## Files to Modify/Create

### Existing File to Update:
- ✅ `LoginServlet.java` - Updated with full implementation

### New Files to Create:
- ✅ `LogoutServlet.java` - New servlet for logout
- ✅ `login.jsp` - Login form page
- ✅ `dashboard.jsp` - User dashboard
- ✅ `session-info.jsp` - Session details page
- ✅ `error.jsp` - Error handling page
- ✅ `web.xml` - Servlet configuration

## Learning Outcomes Achieved

By completing this project, you will understand:
- ✅ How Java Servlets process HTTP requests and responses
- ✅ Servlet lifecycle: init(), service(), destroy()
- ✅ Why HTTP is stateless and why sessions matter
- ✅ How to create and manage HttpSession objects
- ✅ Session attributes and their lifecycle
- ✅ How cookies store data in the browser
- ✅ Difference between sessions and cookies
- ✅ Session timeout and automatic invalidation
- ✅ Secure login system implementation
- ✅ Deployment on Apache Tomcat

## Extensions and Enhancements

Potential improvements:
1. **Database Integration**: Store users in MySQL/PostgreSQL
2. **Password Hashing**: Use BCrypt for secure passwords
3. **Remember Me Enhancement**: Use secure token approach
4. **Session Monitoring**: Track active sessions admin dashboard
5. **HTTPS Support**: Implement SSL/TLS encryption
6. **Multi-User Support**: Handle multiple concurrent sessions
7. **Audit Logging**: Log all login/logout events
8. **Two-Factor Authentication**: Additional security layer

## References

- [Apache Tomcat Documentation](http://tomcat.apache.org/tomcat-9.0-doc/)
- [Java Servlet Specification](https://projects.eclipse.org/projects/ee4j.servlet)
- [HTTP Cookies](https://developer.mozilla.org/en-US/docs/Web/HTTP/Cookies)
- [Session Management Best Practices](https://owasp.org/www-community/attacks/Session_fixation)

## Author Notes

This project demonstrates real-world web application concepts:
- Professional UI/UX design
- Proper error handling
- Security considerations
- Clean code structure
- Comprehensive documentation

Students should run this in a debugger to understand the flow of execution and how sessions are maintained across requests.

## Summary

This Student Portal application successfully demonstrates:
1. **Servlet Lifecycle**: Complete init(), service(), destroy() cycle
2. **Session Management**: HttpSession for secure user tracking
3. **Cookies**: Browser-based preference storage
4. **Authentication**: Complete login/logout system
5. **Deployment**: Production-ready Tomcat deployment

The application serves as an excellent foundation for building more complex enterprise web applications with advanced features like database integration, security frameworks, and microservices.

---

**Last Updated**: July 2024
**Version**: 1.0
**Status**: ✅ Complete and Ready for Deployment
