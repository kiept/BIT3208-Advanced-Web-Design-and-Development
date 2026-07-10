# Week 6 — Library Book Management

This module implements a simple Book CRUD system for Week 6 deliverables.

Files:
- `db.php` — MySQL connection helper (set credentials for XAMPP)
- `index.php` — Add/View/Edit/Delete books, with search
- `css/style.css` — basic UI
- `database.sql` — SQL dump to create `week6_books` and sample data

How to run:
1. Import `database.sql` into your MySQL (phpMyAdmin or mysql CLI).
2. Adjust `db.php` DB credentials if needed.
3. Serve the folder with PHP built-in server or place in XAMPP `htdocs`.

Examples:
```bash
cd week_6/pr2_book_management
php -S 127.0.0.1:8082
# open http://127.0.0.1:8082/index.php
```
