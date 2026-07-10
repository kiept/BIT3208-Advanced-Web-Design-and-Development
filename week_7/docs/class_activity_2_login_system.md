## Class Activity 2 — Build a Login System

Requirements:
- Authenticate users by email and password.
- Create a session on successful login.
- Provide error messages on failure.

Implementation pointers:
- Use `login.php` and `includes/auth.php`.
- On success, use `session_regenerate_id(true)` and set `$_SESSION['user_id']`.

Deliverables:
- Screenshot of login attempt success and failure.
