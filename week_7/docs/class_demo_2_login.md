## Class Demonstration 2 — User Login

Goal:
- Validate credentials, create sessions, and redirect users.

Files to inspect:
- [login.php](week_7/auth_system/login.php)
- [includes/auth.php](week_7/auth_system/includes/auth.php)

Steps demonstrated:
1. Accept email and password from a POST form.
2. Fetch user row by email and verify with `password_verify()`.
3. Use `session_regenerate_id(true)` and store `user_id` in session.
4. Redirect users to role-specific dashboards.
