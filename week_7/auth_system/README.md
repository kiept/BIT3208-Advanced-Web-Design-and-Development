# Week 7 — User Authentication and Session Management

This module implements registration, login, role-based dashboards, and logout.

Files:
- `db.php` — MySQL connection (edit credentials)
- `includes/auth.php` — session and role helpers
- `register.php`, `login.php`, `logout.php` — auth flows
- `student_dashboard.php`, `lecturer_dashboard.php`, `admin_dashboard.php` — protected pages
- `database.sql` — schema + sample users
- `css/style.css`, `js/validation.js` — UI and simple client validation

Teaching materials (individual pages):
- Class Demonstrations:
	- [Demo 1 — Registration](week_7/auth_system/docs/class_demo_1_registration.md)
	- [Demo 2 — Login](week_7/auth_system/docs/class_demo_2_login.md)
	- [Demo 3 — Dashboard](week_7/auth_system/docs/class_demo_3_dashboard.md)
	- [Demo 4 — Logout](week_7/auth_system/docs/class_demo_4_logout.md)
- Class Activities:
	- [Activity 1 — Registration System](week_7/auth_system/docs/class_activity_1_registration_system.md)
	- [Activity 2 — Login System](week_7/auth_system/docs/class_activity_2_login_system.md)
	- [Activity 3 — Secure Dashboard](week_7/auth_system/docs/class_activity_3_secure_dashboard.md)
- Practical Tasks:
	- [Practical 1 — Student Portal](week_7/auth_system/docs/practical_task_1_student_portal.md)
	- [Practical 2 — Employee Portal](week_7/auth_system/docs/practical_task_2_employee_portal.md)
	- [Practical 3 — Multi-User Auth](week_7/auth_system/docs/practical_task_3_multi_user_auth.md)

Run:
1. Import `database.sql` into MySQL (phpMyAdmin or CLI).
2. Adjust `db.php` credentials if needed.
3. Serve with PHP built-in server:

```bash
cd week_7/auth_system
php -S 127.0.0.1:8084
# open http://127.0.0.1:8084/login.php
```

Default sample users:
- admin@school.edu / admin123
- lecturer@school.edu / lecturer123
- student@school.edu / student123
