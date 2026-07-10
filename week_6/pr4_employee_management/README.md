# Week 6 — Employee Records Management

This module implements an Employee CRUD system with optional authentication.

Files:
- `db.php` — MySQL connection helper (set credentials for XAMPP)
- `includes/auth.php` — simple session/auth helpers
- `index.php` — Employee CRUD (protected by login)
- `login.php`, `register.php`, `logout.php` — auth flows
- `js/validation.js` — client-side registration validation
- `css/style.css` — responsive UI
- `database.sql` — SQL dump to create `employees` and `users` tables

How to run:
1. Import `database.sql` into your MySQL (phpMyAdmin or mysql CLI).
2. Adjust `db.php` DB credentials if needed (XAMPP defaults: user `root`, empty password).
3. Serve the folder with PHP built-in server or place in XAMPP `htdocs`.

Example:
```bash
cd week_6/pr4_employee_management
php -S 127.0.0.1:8083
# open http://127.0.0.1:8083/register.php to create an account
# then login at http://127.0.0.1:8083/login.php
```

Notes:
- Create the first user using `register.php` (passwords hashed with PHP `password_hash`).
- The module uses prepared statements for SQL operations.
