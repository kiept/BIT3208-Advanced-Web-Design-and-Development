## Class Demonstration 3 — Protected Dashboard

Goal:
- Restrict access to authenticated users and display their information.

Files to inspect:
- [student_dashboard.php](week_7/auth_system/student_dashboard.php)
- [lecturer_dashboard.php](week_7/auth_system/lecturer_dashboard.php)
- [admin_dashboard.php](week_7/auth_system/admin_dashboard.php)

Steps demonstrated:
1. Use `require_login()` to block unauthenticated access.
2. Optionally check roles with `require_role()`.
3. Show `fullname` and `email` retrieved from the `users` table.
