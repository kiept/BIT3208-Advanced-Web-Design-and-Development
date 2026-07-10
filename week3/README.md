# Week 3 — JS Basics, DOM & PHP Intro

This folder provides small demos and exercises for Week 3.

Pages:
- `index.html` — JS form validation, live preview, dynamic menu, links to PHP demos.
- `js/validation.js` — email validation and password strength checker.
- `js/dom.js` — live preview and menu toggle.
- `php/index.php` — PHP welcome page and simple form that stores a name in `$_SESSION`.
- `php/process.php` — processes the form and demonstrates session storage.
- `php/db_test.php` — example MySQL connection test (edit credentials as needed).

How to run:

Front-end pages (no server required):
```bash
open week3/index.html
```

PHP pages (requires PHP built-in server):
```bash
cd week3/php
php -S 127.0.0.1:8020
# then open http://127.0.0.1:8020/index.php and http://127.0.0.1:8020/db_test.php
```

Exercises covered:
- JS variables, events, input handling
- Form validation and alerts
- DOM manipulation (show/hide, live update)
- Basic PHP syntax, sessions, form handling
- MySQL connection string example for backend practice
