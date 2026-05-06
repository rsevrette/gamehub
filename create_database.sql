
CREATE DATABASE IF NOT EXISTS games_db;
USE games_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    description TEXT,
    image VARCHAR(255),
    user_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id)
    ON DELETE CASCADE
);