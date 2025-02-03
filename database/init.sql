CREATE TABLE IF NOT EXISTS users (
                                     id INT AUTO_INCREMENT PRIMARY KEY,
                                     username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) NOT NULL DEFAULT 'user'
    );

CREATE TABLE IF NOT EXISTS cars (
                                    id INT AUTO_INCREMENT PRIMARY KEY,
                                    brand VARCHAR(100) NOT NULL,
    model VARCHAR(100) NOT NULL,
    year INT,
    fuel_type VARCHAR(50),
    license_plate VARCHAR(50),
    photo_path VARCHAR(255)
    );

CREATE TABLE IF NOT EXISTS courses (
                                       id INT AUTO_INCREMENT PRIMARY KEY,
                                       title VARCHAR(100),
    description TEXT,
    duration INT,
    price DECIMAL(10,2),
    photo_path VARCHAR(255)
    );

CREATE TABLE IF NOT EXISTS instructors (
                                           id INT AUTO_INCREMENT PRIMARY KEY,
                                           name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(50),
    specialization VARCHAR(100),
    photo_path VARCHAR(255)
    );
