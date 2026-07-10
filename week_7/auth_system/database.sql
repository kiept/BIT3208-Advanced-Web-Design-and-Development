-- Week7 Authentication DB
CREATE DATABASE IF NOT EXISTS week7_auth;
USE week7_auth;

CREATE TABLE IF NOT EXISTS users (
  user_id INT PRIMARY KEY AUTO_INCREMENT,
  fullname VARCHAR(200) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Sample users (passwords hashed)
INSERT INTO users (fullname,email,password,role) VALUES
('Admin User','admin@school.edu','$2y$12$M3pPaxQPdTL1cOhwplLFE.bSWdxm8/FI4rb//FSx8neMyxOgRv4Mq','admin'),
('Lecturer One','lecturer@school.edu','$2y$12$bq06gvr5PoBS6g5Jkrhz/uWW6p4.lDU2qVEUr88NFvrHTgEzjXQe.','lecturer'),
('Student One','student@school.edu','$2y$12$TlbTwfOiezuexSQqr6gx8O265nQsv26ePznn0y.xRIzv2Tb3qfP32','student');
