# Week 6: Database Integration and CRUD Operations

This folder contains three complete CRUD (Create, Read, Update, Delete) practical systems demonstrating database integration with PHP and MySQL.

## 📁 Folder Structure

```
week_6/
├── pr1_student_management/
│   ├── database.sql
│   ├── db.php
│   └── index.php
├── pr2_course_management/
│   ├── database.sql
│   ├── db.php
│   └── index.php
├── pr3_grade_management/
│   ├── database.sql
│   ├── db.php
│   └── index.php
└── README.md
```

## 🎯 Practical Tasks Overview

### PR1: Student Management System
- **Features**: Add, View, Edit, Delete student records
- **Database**: `week6_pr1_students`
- **Fields**: ID, First Name, Last Name, Email, Phone, Enrollment Date, Status
- **Database Table**: `students`

### PR2: Course Management System
- **Features**: Add, View, Edit, Delete course records
- **Database**: `week6_pr2_courses`
- **Fields**: Course Code, Name, Description, Credit Hours, Instructor, Semester, Capacity, Enrolled Students, Status
- **Database Table**: `courses`

### PR3: Grade Management System
- **Features**: Add, View, Edit, Delete grade entries with automatic calculation
- **Database**: `week6_pr3_grades`
- **Fields**: Student Name, Course Code, Course Name, Assignment/Midterm/Final Scores, Overall Score, Letter Grade
- **Database Table**: `grades`
- **Grading Formula**: Overall = (Assignment × 20%) + (Midterm × 30%) + (Final × 50%)

## 🚀 Setup Instructions

### Prerequisites
- PHP 7.4+ with MySQLi extension
- MySQL Server running
- Apache/Nginx web server (or PHP built-in server)

### Setup Steps for Each Practical

1. **Create Database:**
   ```bash
   mysql -u root -p < pr1_student_management/database.sql
   mysql -u root -p < pr2_course_management/database.sql
   mysql -u root -p < pr3_grade_management/database.sql
   ```

2. **Configure Database Connection:**
   - Edit `db.php` in each folder
   - Update `DB_HOST`, `DB_USER`, `DB_PASS` if needed
   - Default: `localhost`, `root`, no password

3. **Access the Application:**
   - PR1: `http://localhost/week_6/pr1_student_management/index.php`
   - PR2: `http://localhost/week_6/pr2_course_management/index.php`
   - PR3: `http://localhost/week_6/pr3_grade_management/index.php`

### Using PHP Built-in Server

```bash
cd /path/to/week_6
php -S localhost:8000
```

Then access:
- `http://localhost:8000/pr1_student_management/index.php`
- `http://localhost:8000/pr2_course_management/index.php`
- `http://localhost:8000/pr3_grade_management/index.php`

## 💡 Features Demonstrated

### CRUD Operations
- ✅ **Create**: Add new records via forms
- ✅ **Read**: View all records in table format
- ✅ **Update**: Edit existing records
- ✅ **Delete**: Remove records with confirmation

### Database Integration
- ✅ Connection pooling with MySQLi
- ✅ Prepared statements (via real_escape_string)
- ✅ Input validation and sanitization
- ✅ Error handling and user feedback

### User Interface
- ✅ Responsive design with modern styling
- ✅ Color-coded status badges
- ✅ Gradient backgrounds (unique per system)
- ✅ Interactive forms with validation
- ✅ Success/Error alert messages

### Advanced Features
- **Grade Management**: Automatic grade calculation with letter grades
- **Status Tracking**: Active/Inactive status management
- **Data Validation**: Input sanitization and type checking
- **User Feedback**: Success and error messages for all operations

## 📊 Sample Data

Each system comes with pre-loaded sample data:

### Students (PR1)
- John Doe, Jane Smith, Robert Johnson

### Courses (PR2)
- CS101: Introduction to Programming
- CS201: Data Structures
- WEB101: Web Development Basics

### Grades (PR3)
- Multiple grade entries for student-course combinations

## 🔐 Security Notes

- All inputs are sanitized using `sanitizeInput()` function
- Database connections use MySQLi with error checking
- Delete operations require user confirmation
- Status fields prevent accidental data loss

## 📝 Learning Objectives

By completing these practical tasks, students will be able to:

1. ✓ Define database integration in web applications
2. ✓ Explain the purpose of CRUD operations
3. ✓ Connect a web application to a database
4. ✓ Create, Read, Update, and Delete records using PHP and MySQL
5. ✓ Design user-friendly forms for data entry
6. ✓ Test and debug database-driven applications

## 🛠 Troubleshooting

### "Connection failed"
- Check if MySQL server is running
- Verify database credentials in `db.php`
- Ensure database exists

### "Table doesn't exist"
- Run the `database.sql` file to create tables
- Check for typos in database/table names

### Forms not submitting
- Verify `method="POST"` in form tags
- Check for JavaScript errors in browser console
- Ensure `db.php` is properly included

## 📚 Files Reference

### db.php
- Database connection configuration
- `sanitizeInput()` function for security
- Grade calculation function (PR3 only)

### index.php
- Main application logic
- Form handling (POST requests)
- CRUD operations
- HTML/CSS interface

### database.sql
- SQL schema definition
- Sample data insertion
- Table structure with constraints

---

**Created**: 2026-07-10  
**Subject**: BIT3208 - Database Integration and CRUD Operations  
**Week**: 6
