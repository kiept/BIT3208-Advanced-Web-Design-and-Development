## Class Demonstration 1 — User Registration

Goal:
- Show how to build a registration form that saves users to the database with hashed passwords.

Files to inspect / run:
- [register.php](week_7/auth_system/register.php)
- [db.php](week_7/auth_system/db.php)

Steps demonstrated:
1. Create an HTML form for full name, email, password, and role.
2. Server-side validation for required fields.
3. Use `password_hash()` to securely hash passwords before storing.
4. Store the user via prepared statements to prevent SQL injection.

Try it:
1. Import `database.sql` from the module.
2. Start a PHP server and open `register.php`.
