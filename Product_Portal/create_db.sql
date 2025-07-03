CREATE DATABASE IF NOT EXISTS product_portal;
USE product_portal;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    specs TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    status ENUM('pending', 'approved') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
