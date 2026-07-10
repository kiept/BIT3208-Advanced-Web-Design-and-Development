# Week 4 - Backend Basics

This folder contains simple PHP examples for Week 4 tasks:

- `init_db.php` - initializes a SQLite database `database/app.sqlite`.
- `includes/db.php` - PDO helper to connect to the database.
- `includes/functions.php` - session and auth helpers.
- `index.php` - dynamic welcome page (session-aware).
- `register.php` / `login.php` / `logout.php` - basic authentication flow.
- `admin.php` - simple protected admin dashboard.
- `checkout.php` - simple form submission that stores orders.
- `contact.php` - contact form example.
- `css/style.css` - styles used by these pages.

To initialize the database and try the demo locally:

```bash
cd week4
php init_db.php
php -S 127.0.0.1:8080
# then open http://127.0.0.1:8080/index.php
```
