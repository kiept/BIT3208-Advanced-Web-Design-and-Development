# Week 5 - Databases & CRUD

This folder contains examples and exercises for Week 5 covering databases, table creation, and CRUD using PHP + SQLite.

Files:
- `init_db.php` — initializes `database/app.sqlite` with `students`, `products`, and `users` tables and sample data.
- `sql_dump.sql` — SQL statements (CREATE + sample INSERTs) for deliverables/screenshots.
- `students.php` — Add/View/Edit/Delete students (CRUD).
- `products.php` — Add/View/Edit/Delete products (CRUD).
- `users_admin.php` — View users table for login DB integration screenshots.
- `css/style.css` — styles for pages.

How to run locally:
```bash
cd week5
php init_db.php
php -S 127.0.0.1:8090
# open http://127.0.0.1:8090/students.php and http://127.0.0.1:8090/products.php
```

Deliverables checklist:
- Database screenshot: open `week5/database/app.sqlite` or use DB browser.
- Table creation screenshot: open `week5/sql_dump.sql` or query schema.
- CRUD operation screenshots: use the UI pages above and capture add/edit/delete.
- Login DB integration: see `users_admin.php`.
