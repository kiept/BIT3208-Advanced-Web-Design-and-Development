# Deployment Guide: Apache Tomcat Setup and Application Launch

## Quick Start

This guide provides step-by-step instructions to deploy and test the Student Portal application on Apache Tomcat.

## Prerequisites

✅ **Required Software:**
- Java Development Kit (JDK) 8 or higher
- Apache Tomcat 9.0 or higher
- Eclipse IDE (optional, but recommended)
- Web browser (Chrome, Firefox, Edge, Safari)

✅ **Verify Installation:**

**Check Java Version:**
```bash
java -version
# Expected output: java version "1.8.0_xxx" or higher
```

**Check Tomcat Installation:**
Navigate to Tomcat installation directory and verify:
- `/bin/catalina.sh` (Linux/Mac)
- `/bin/catalina.bat` (Windows)

## Project Structure Verification

Before deployment, ensure your project has this structure:

```
StudentPortal/
├── src/
│   └── main/
│       ├── java/com/student/
│       │   ├── LoginServlet.java
│       │   └── LogoutServlet.java
│       └── webapp/
│           ├── WEB-INF/
│           │   ├── web.xml ✅ CRITICAL
│           │   └── lib/
│           ├── login.jsp
│           ├── dashboard.jsp
│           ├── session-info.jsp
│           ├── error.jsp
│           ├── META-INF/
│           └── index.jsp (optional)
├── build/classes/ [compiled Java files]
├── README.md
└── EXERCISES.md
```

## Deployment Steps

### Option 1: Using Eclipse IDE (Recommended)

#### Step 1: Import Project into Eclipse

1. **Open Eclipse IDE**
2. **File** → **Import**
3. Select **Existing Projects into Workspace**
4. **Browse** to `c:\Users\PC\Desktop\week9\StudentPortalStudentPortal`
5. **Click Finish**

#### Step 2: Configure Tomcat Server

1. **Window** → **Preferences**
2. **Server** → **Runtime Environments**
3. **Click Add**
4. Select **Apache Tomcat v9.0**
5. **Click Next**
6. **Browse** to Tomcat installation directory
7. Click **Finish** and **Apply and Close**

#### Step 3: Add Project to Tomcat

1. **Right-click StudentPortal project**
2. **Run As** → **Run on Server**
3. Select **Apache Tomcat v9.0 Server at localhost**
4. **Click Finish**

#### Step 4: Access Application

Open browser and navigate to:
```
http://localhost:8080/StudentPortalStudentPortal/login.jsp
```

---

### Option 2: Manual Deployment (Direct Tomcat)

#### Step 1: Build the Project

Using Eclipse or command line, compile Java files:

**In Eclipse:**
1. Right-click project
2. **Project** → **Clean** → **Build All**

**Command Line (Windows):**
```batch
cd c:\Users\PC\Desktop\week9\StudentPortalStudentPortal
javac -d build/classes src/main/java/com/student/*.java
```

#### Step 2: Create WAR File (Optional)

```bash
cd src/main
jar -cvf StudentPortal.war webapp/
```

#### Step 3: Deploy to Tomcat

**Method A: Copy to webapps folder**
```
Copy StudentPortal folder to: Tomcat_HOME/webapps/StudentPortal
```

**Method B: Deploy WAR file**
```
Copy StudentPortal.war to: Tomcat_HOME/webapps/
Tomcat will auto-extract it
```

#### Step 4: Start Tomcat

**Windows:**
```batch
cd Tomcat_HOME/bin
catalina.bat run
```

**Linux/Mac:**
```bash
cd Tomcat_HOME/bin
./catalina.sh run
```

#### Step 5: Verify Deployment

In Tomcat console, you should see:
```
[SERVLET LIFECYCLE] LoginServlet initialized
[SERVLET LIFECYCLE] LogoutServlet initialized
INFO: Deploying web application directory StudentPortal
INFO: Deployment of web application directory StudentPortal has finished
```

#### Step 6: Access Application

```
http://localhost:8080/StudentPortalStudentPortal/login.jsp
```

---

## Configuration

### web.xml Key Settings

The `web.xml` file includes:

**Session Configuration:**
```xml
<session-config>
    <cookie-config>
        <secure>false</secure>          <!-- Set true for HTTPS -->
        <http-only>true</http-only>     <!-- Prevents JavaScript access -->
    </cookie-config>
    <tracking-mode>COOKIE</tracking-mode>
    <timeout>30</timeout>                <!-- 30 minutes -->
</session-config>
```

**Servlet Mappings:**
```xml
<servlet-mapping>
    <servlet-name>LoginServlet</servlet-name>
    <url-pattern>/login</url-pattern>   <!-- Access via /login -->
</servlet-mapping>

<servlet-mapping>
    <servlet-name>LogoutServlet</servlet-name>
    <url-pattern>/logout</url-pattern>  <!-- Access via /logout -->
</servlet-mapping>
```

**Welcome Page:**
```xml
<welcome-file-list>
    <welcome-file>login.jsp</welcome-file>
</welcome-file-list>
```

### Changing Session Timeout

Edit `web.xml` line (in `<session-config>`):
```xml
<timeout>30</timeout>  <!-- Change 30 to desired minutes -->
```

**Common Settings:**
- `15` - 15 minutes (more secure)
- `30` - 30 minutes (default)
- `60` - 1 hour (user-friendly)
- `1440` - 1 day (very long)

### Changing Tomcat Port

If port 8080 is in use:

**Edit Tomcat_HOME/conf/server.xml:**
Find:
```xml
<Connector port="8080" protocol="HTTP/1.1"
           connectionTimeout="20000"
           redirectPort="8443" />
```

Change `8080` to desired port (e.g., `8081`):
```xml
<Connector port="8081" protocol="HTTP/1.1"
           connectionTimeout="20000"
           redirectPort="8443" />
```

Then access: `http://localhost:8081/StudentPortalStudentPortal/login.jsp`

---

## Testing Checklist

### ✅ Connectivity Tests

- [ ] Can access login page: `http://localhost:8080/StudentPortalStudentPortal/login.jsp`
- [ ] Page loads without errors
- [ ] Form elements are visible
- [ ] Demo credentials displayed

### ✅ Authentication Tests

- [ ] Login with `student` / `password123` succeeds
- [ ] Invalid credentials show error message
- [ ] Empty fields show validation error
- [ ] Successful login redirects to dashboard

### ✅ Session Management Tests

- [ ] Session ID displayed on dashboard
- [ ] Login time is correct
- [ ] Refresh page maintains session
- [ ] Username remains same after refresh
- [ ] Session attributes remain intact

### ✅ Cookie Tests

1. **Open Developer Tools (F12)**
2. **Go to Application tab**
3. **Click Cookies**
4. **Verify present:**
   - [ ] `JSESSIONID` cookie exists
   - [ ] `theme` cookie set to selected value
   - [ ] `rememberMe` cookie exists (if checked)

### ✅ Remember Me Feature

- [ ] Check "Remember me" during login
- [ ] Clear browser history/cache (NOT cookies)
- [ ] Close and reopen browser
- [ ] Navigate to login page
- [ ] Username field pre-filled
- [ ] Can login without re-entering username

### ✅ Logout Tests

- [ ] Click "Logout" button
- [ ] Shown logout confirmation page
- [ ] Automatically redirected to login.jsp
- [ ] Cannot access dashboard via back button
- [ ] Session is destroyed

### ✅ Session Expiration Test

- [ ] Login to application
- [ ] Wait 30 minutes without activity
- [ ] Try to access dashboard
- [ ] Redirected to login (session expired)

### ✅ Error Handling

- [ ] Access non-existent page: `http://localhost:8080/StudentPortalStudentPortal/notfound.jsp`
- [ ] Error page displays (404)
- [ ] Error page has "Go to Login" button
- [ ] Link returns to login page

---

## Troubleshooting

### Problem: "Failed to start the application"

**Solution:**
1. Check Tomcat logs: `Tomcat_HOME/logs/catalina.out`
2. Verify Java installation: `java -version`
3. Check port 8080 availability: Change in server.xml
4. Restart Tomcat service

### Problem: "404 - Resource not found"

**Solution:**
1. Verify project name matches URL
2. Check web.xml servlet mappings
3. Verify JSP files are in webapp directory
4. Restart Tomcat

### Problem: "Session becomes null immediately"

**Solution:**
1. Check cookies are enabled in browser
2. Verify web.xml session configuration
3. Check browser privacy settings
4. Clear browser cache and restart

### Problem: "Cookies not persisting"

**Solution:**
1. Enable cookies in browser settings
2. Verify cookie path: `/` in Servlet code
3. Check cookie expiration not set to 0
4. Verify `setMaxAge()` called correctly

### Problem: "Tomcat port already in use"

**Solution:**
1. Change port in server.xml (see Configuration section)
2. Or stop conflicting application:
   ```bash
   # Find process using port 8080
   netstat -ano | findstr :8080
   taskkill /PID [PID] /F
   ```

### Problem: "Java compilation errors"

**Solution:**
1. Verify JDK installation (not JRE)
2. Check Java compatibility: 8 or higher
3. Rebuild project: Project → Clean → Build
4. Check import statements in servlet files

### Problem: "Cannot connect to database" (if database added later)

**Solution:**
1. Verify database driver in WEB-INF/lib/
2. Check database URL in code
3. Verify credentials and permissions
4. Ensure database service is running

---

## Monitoring and Logging

### Viewing Tomcat Logs

**Eclipse Console:**
Shows real-time output when running in Eclipse

**Tomcat Logs (File):**
```
Tomcat_HOME/logs/catalina.out      # Main log
Tomcat_HOME/logs/localhost.log      # Application-specific
```

### Expected Console Output

**On Startup:**
```
INFO: Starting service Catalina
INFO: Starting Servlet engine: Apache Tomcat/9.0.x
[SERVLET LIFECYCLE] LoginServlet initialized
[SERVLET LIFECYCLE] LogoutServlet initialized
INFO: Deploying web application directory StudentPortal
INFO: Deployment of web application directory StudentPortal has finished
```

**On Login:**
```
[LOGIN] User: student | Session ID: 12345ABC | Login Time: 2024-07-13 14:30:45
```

**On Logout:**
```
[LOGOUT] User: student | Session ID: 12345ABC
```

### Enabling Debug Logging

Edit `Tomcat_HOME/conf/logging.properties`:
```properties
org.apache.catalina.level = FINE
```

---

## Performance Optimization

### 1. Session Pool Optimization
Set in web.xml:
```xml
<session-config>
    <timeout>20</timeout>  <!-- Reduce for better resource usage -->
</session-config>
```

### 2. Memory Settings
Set environment variable before starting Tomcat:

**Windows:**
```batch
set CATALINA_OPTS=-Xmx512m -Xms256m
```

**Linux/Mac:**
```bash
export CATALINA_OPTS=-Xmx512m -Xms256m
```

### 3. Connection Pooling
(Advanced topic for database integration)

---

## Security Checklist

Before deploying to production:

- [ ] Change demo credentials to real database
- [ ] Use HTTPS (set `secure=true` in web.xml)
- [ ] Hash passwords using BCrypt/Argon2
- [ ] Set HttpOnly flag on cookies ✅ (already done)
- [ ] Implement CSRF protection
- [ ] Use prepared statements for SQL queries
- [ ] Validate all user input
- [ ] Implement rate limiting on login
- [ ] Add audit logging
- [ ] Use secure session management ✅ (already done)

---

## Undeploying Application

### Remove from Eclipse
1. Right-click project
2. **Delete** → Select "Delete project contents"

### Remove from Tomcat
1. Stop Tomcat
2. Delete folder: `Tomcat_HOME/webapps/StudentPortal`
3. Delete file: `Tomcat_HOME/webapps/StudentPortal.war`
4. Restart Tomcat

---

## Verification Checklist

After deployment, verify:

| Item | Expected | Actual | Pass |
|------|----------|--------|------|
| Login page loads | Yes | | ✅ |
| Form validation works | Yes | | ✅ |
| Login with correct creds | Success | | ✅ |
| Login with wrong creds | Fails | | ✅ |
| Dashboard displays | Yes | | ✅ |
| Session ID shown | Yes | | ✅ |
| Cookies created | Yes | | ✅ |
| Remember Me works | Yes | | ✅ |
| Logout works | Yes | | ✅ |
| Session timeout works | Yes | | ✅ |
| Error page works | Yes | | ✅ |

---

## Next Steps

After successful deployment:

1. **Test Thoroughly** - Try all features
2. **Review Logs** - Check for errors
3. **Monitor Performance** - Watch resource usage
4. **Plan Enhancements** - Database integration, more features
5. **Document Setup** - Create deployment notes
6. **Backup Configuration** - Save working configuration

---

## Production Deployment

For production environment:

1. **Use HTTPS** - Install SSL certificate
2. **Database** - Move from hardcoded credentials
3. **Load Balancing** - Deploy on multiple servers
4. **Monitoring** - Set up health checks
5. **Backups** - Regular backup schedule
6. **Scaling** - Plan for user growth

---

## Support and Resources

**Tomcat Documentation:**
- http://tomcat.apache.org/tomcat-9.0-doc/

**Java Servlet Specification:**
- https://projects.eclipse.org/projects/ee4j.servlet

**Stack Overflow:**
- Tag: `tomcat`, `java-servlet`, `jsp`

**Common Errors Database:**
- See troubleshooting section above

---

## Summary

You are now ready to:
- ✅ Deploy Student Portal on Apache Tomcat
- ✅ Test session and cookie functionality
- ✅ Monitor application performance
- ✅ Troubleshoot common issues
- ✅ Scale to production environment

**Status**: Ready for Deployment ✅

---

**Last Updated**: July 2024
**Version**: 1.0
**Deployment Status**: Complete
