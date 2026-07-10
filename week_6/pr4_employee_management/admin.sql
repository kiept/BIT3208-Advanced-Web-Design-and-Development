-- Admin user insert for Employee Records DB
-- Credentials (change as needed):
--   email: admin@example.com
--   password: admin123

USE week6_employees;

INSERT INTO users (username, email, password)
VALUES ('admin', 'admin@example.com', '$2y$12$mgZ2qFxkFkH72FZ.mXNYVuJKlU9NdNHnCpWlEUmSBFHisn0grtVMi');

-- If your `users` table uses a different database name, import into that DB or edit the USE line above.
