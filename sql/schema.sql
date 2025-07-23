CREATE DATABASE IF NOT EXISTS hospital;

USE hospital;

CREATE TABLE IF NOT EXISTS patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    dob DATE,
    gender VARCHAR(10),
    email VARCHAR(100),
    phone VARCHAR(15),
    symptoms TEXT,
    department VARCHAR(50),
    agree TINYINT(1),
    photo VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
