-- Employee Records Database for Week 6
CREATE DATABASE IF NOT EXISTS week6_employees;
USE week6_employees;
CREATE TABLE IF NOT EXISTS employees (
  employee_id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(200) NOT NULL,
  email VARCHAR(200) NOT NULL,
  position VARCHAR(150),
  phone VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO employees (name,email,position,phone) VALUES
('Alice Johnson','alice.j@example.com','Manager','+123456789'),
('Bob Smith','bob.smith@example.com','Developer','+123456780');

-- Users table for basic auth
CREATE TABLE IF NOT EXISTS users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(100) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Optionally insert a default admin (password: admin123)
-- To create hashed password, register via the register.php form or use PHP to hash and insert.
