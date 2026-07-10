## Class Demonstration 4 — Logout Functionality

Goal:
- Properly destroy sessions and redirect users on logout.

Files to inspect:
- [logout.php](week_7/auth_system/logout.php)
- [includes/auth.php](week_7/auth_system/includes/auth.php)

Steps demonstrated:
1. Clear `$_SESSION` and remove session cookie.
2. Call `session_destroy()` and redirect to `login.php`.
