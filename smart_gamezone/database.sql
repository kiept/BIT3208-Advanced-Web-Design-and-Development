CREATE DATABASE IF NOT EXISTS smart_gamezone;

USE smart_gamezone;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    image_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS game_ideas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO products (name, price, description, image_url) VALUES
('OMEN Gaming PC', 220000.00, 'High-performance gaming desktop for competitive play.', 'images/omen-pc.jpg'),
('HyperX Keyboard', 15000.00, 'Mechanical keyboard with RGB lighting.', 'images/hyperx-keyboard.jpg'),
('Gaming Headset', 12000.00, 'Immersive surround sound headset.', 'images/gaming-headset.jpg'),
('Gaming Mouse', 8000.00, 'Precision mouse for fast reactions.', 'images/gaming-mouse.jpg');
