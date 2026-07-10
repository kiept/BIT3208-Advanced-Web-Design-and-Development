# Week 7: User Authentication and Session Management

This folder contains three complete demonstration systems for user authentication and session management using PHP and MySQL.

## 📁 Folder Structure

```
week_7/
├── cd1_user_registration/
│   ├── database.sql
│   ├── db.php
│   └── index.php
├── cd2_user_login/
│   ├── db.php
│   └── index.php
├── cd3_protected_dashboard/
│   ├── db.php
│   └── index.php
└── README.md
```

## 🎯 Class Demonstrations Overview

### CD1: User Registration
- **Purpose**: Create registration form with secure password storage
- **Features**:
  - Form validation (username, email, password requirements)
  - Password strength indicator
  - BCRYPT password hashing
  - Duplicate account prevention
  - Success feedback with next steps
- **Database**: `week7_auth` → `users` table

### CD2: User Login
- **Purpose**: Authenticate users and create server-side sessions
- **Features**:
  - Credential validation
  - Session creation with PHP
  - Login time tracking
  - Error messages for invalid credentials
  - Remember me checkbox
  - Automatic redirect to dashboard
- **Database**: `week7_auth` → `users` table

### CD3: Protected Dashboard
- **Purpose**: Display protected content with session verification
- **Features**:
  - Session verification (redirect if not logged in)
  - User profile information display
  - Session details (ID, duration, login time)
  - Security status indicators
  - Secure logout functionality
  - Authorization checks on page load

## 🔐 Security Features Implemented

### Password Security
- ✅ BCRYPT hashing algorithm
- ✅ Password strength indicator
- ✅ Minimum length validation (6 characters)
- ✅ Password confirmation field

### Session Security
- ✅ PHP session_start() for session management
- ✅ User ID stored in $_SESSION
- ✅ Login time tracking
- ✅ Session destruction on logout
- ✅ Automatic redirect for unauthorized access

### Input Security
- ✅ Input sanitization using real_escape_string()
- ✅ Email format validation
- ✅ Username uniqueness validation
- ✅ Prepared against SQL injection

## 🚀 Setup Instructions

### Prerequisites
- PHP 7.4+ with MySQLi extension
- MySQL Server running
- Apache/Nginx web server (or PHP built-in server)

### Setup Steps

1. **Create Database:**
   ```bash
   mysql -u root -p < cd1_user_registration/database.sql
   ```

2. **Configure Database Connection:**
   - Edit `db.php` in each folder if needed
   - Default: `localhost`, `root`, no password
   - Database: `week7_auth`

3. **Access the Application:**
   - Registration: `http://localhost/week_7/cd1_user_registration/index.php`
   - Login: `http://localhost/week_7/cd2_user_login/index.php`
   - Dashboard: `http://localhost/week_7/cd3_protected_dashboard/index.php` (requires login)

### Using PHP Built-in Server

```bash
cd /path/to/week_7
php -S localhost:8000
```

Then access:
- `http://localhost:8000/cd1_user_registration/index.php`
- `http://localhost:8000/cd2_user_login/index.php`
- `http://localhost:8000/cd3_protected_dashboard/index.php`

## 📋 User Flow

```
User Registration (CD1)
    ↓
[Account Created with Hashed Password]
    ↓
User Login (CD2)
    ↓
[Credentials Validated]
    ↓
[Session Created - $_SESSION populated]
    ↓
Protected Dashboard (CD3)
    ↓
[Access Verified - User Info Displayed]
    ↓
Logout
    ↓
[Session Destroyed - Redirect to Login]
```

## 🧪 Demo Credentials

```
Username: testuser
Password: password123
```

These credentials are pre-loaded in the database during setup.

## 📊 Database Schema

### Users Table
```sql
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,      -- BCRYPT hashed
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    registration_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

## 🛠 Technical Implementation

### Password Hashing
```php
// During Registration
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// During Login
if (password_verify($input_password, $hashed_password)) {
    // Password is correct
}
```

### Session Management
```php
// Creating Session
session_start();
$_SESSION['user_id'] = $user_id;
$_SESSION['username'] = $username;
$_SESSION['first_name'] = $first_name;
$_SESSION['login_time'] = time();

// Checking Session
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Destroying Session
session_destroy();
```

## 💡 Key Concepts Demonstrated

### CD1: User Registration
- Form validation and error handling
- Password hashing best practices
- Duplicate prevention
- User feedback mechanisms

### CD2: User Login
- Credential validation against database
- Secure password verification
- Session initialization
- User experience with redirects

### CD3: Protected Dashboard
- Access control and authorization
- Session validation
- Secure logout
- User information display
- Session metadata tracking

## 🔍 Troubleshooting

### "Connection failed"
- Verify MySQL server is running
- Check database credentials in `db.php`
- Ensure `week7_auth` database exists

### "Login failed"
- Verify database has `users` table
- Check demo credentials are inserted
- Verify password hashing is working

### "Access Denied to Dashboard"
- Ensure you're logged in first
- Check that session_start() is called
- Clear browser cookies if needed

### Password Verification Issues
- Ensure password uses at least 6 characters
- Verify both passwords match
- Check BCRYPT is available in PHP

## 📚 Learning Outcomes

By completing these demonstrations, students will understand:

1. ✓ User registration with validation
2. ✓ Secure password hashing and verification
3. ✓ Session creation and management
4. ✓ User authentication process
5. ✓ Access control and authorization
6. ✓ Secure logout mechanisms
7. ✓ Database integration for authentication
8. ✓ Security best practices

## 📝 Files Reference

### database.sql
- User table schema
- Demo user data insertion
- Constraints and indexes

### db.php
- Database connection
- Password hashing functions
- Input sanitization
- Password verification

### index.php (CD1)
- Registration form
- Form validation
- Password strength indicator
- Success messaging

### index.php (CD2)
- Login form
- Credential verification
- Session creation
- Error handling
- Redirect to dashboard

### index.php (CD3)
- Session verification
- User profile display
- Session information
- Logout functionality
- Protected content

---

**Created**: 2026-07-10  
**Subject**: BIT3208 - User Authentication and Session Management  
**Week**: 7
