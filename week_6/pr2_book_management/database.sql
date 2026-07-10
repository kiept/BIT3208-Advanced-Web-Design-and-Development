-- Books table for Week 6
CREATE DATABASE IF NOT EXISTS week6_books;
USE week6_books;
CREATE TABLE IF NOT EXISTS books (
  book_id INT PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255),
  category VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO books (title,author,category) VALUES
('Learning PHP','Author A','Programming'),
('Intro to Databases','Author B','Database');
