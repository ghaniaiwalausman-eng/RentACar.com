-- install.sql
-- Run this to set up the database manually if needed

CREATE DATABASE IF NOT EXISTS rentacar_db;
USE rentacar_db;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cars table
CREATE TABLE IF NOT EXISTS cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    type VARCHAR(30) NOT NULL,
    fuel VARCHAR(30) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    rating DECIMAL(3,1) DEFAULT 4.5,
    seats INT DEFAULT 5,
    image_url TEXT,
    deals BOOLEAN DEFAULT FALSE,
    available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bookings table
CREATE TABLE IF NOT EXISTS bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    car_name VARCHAR(100),
    renter_name VARCHAR(100),
    email VARCHAR(100),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days INT,
    total_price DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'confirmed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (car_id) REFERENCES cars(id)
);

-- Email logs table
CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample cars
INSERT INTO cars (brand, model, type, fuel, price, rating, seats, image_url, deals) VALUES
('Toyota', 'Camry', 'sedan', 'petrol', 65, 4.8, 5, 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop', true),
('Honda', 'CR-V', 'suv', 'diesel', 85, 4.7, 5, 'https://images.unsplash.com/photo-1568605117036-5fe5e7fa0ab7?w=400&h=300&fit=crop', false),
('Ford', 'Mustang', 'convertible', 'petrol', 150, 4.9, 4, 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop', true),
('Tesla', 'Model 3', 'sedan', 'electric', 120, 4.9, 5, 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=400&h=300&fit=crop', true),
('BMW', 'X5', 'suv', 'diesel', 190, 4.8, 7, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop', false),
('Toyota', 'RAV4', 'suv', 'hybrid', 95, 4.8, 5, 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&h=300&fit=crop', false),
('Honda', 'Civic', 'sedan', 'petrol', 55, 4.6, 5, 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=400&h=300&fit=crop', false),
('Chevrolet', 'Corvette', 'convertible', 'petrol', 220, 4.9, 2, 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop', true);
