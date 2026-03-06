-- =====================================================
-- COMPLETE SQL DATABASE FOR RENTACAR SYSTEM
-- Run this entire script in phpMyAdmin or MySQL command line
-- =====================================================

-- Drop database if exists (optional - removes existing)
DROP DATABASE IF EXISTS rentacar_db;

-- Create fresh database
CREATE DATABASE rentacar_db;
USE rentacar_db;

-- =====================================================
-- TABLE: users (stores customer information)
-- =====================================================
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    driver_license VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE: cars (stores all vehicle information)
-- =====================================================
CREATE TABLE cars (
    id INT AUTO_INCREMENT PRIMARY KEY,
    brand VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT,
    type VARCHAR(30) NOT NULL,
    fuel VARCHAR(30) NOT NULL,
    transmission VARCHAR(20) DEFAULT 'Automatic',
    price_per_day DECIMAL(10,2) NOT NULL,
    price_per_week DECIMAL(10,2),
    price_per_month DECIMAL(10,2),
    rating DECIMAL(3,1) DEFAULT 4.5,
    seats INT DEFAULT 5,
    doors INT DEFAULT 4,
    mileage VARCHAR(20),
    color VARCHAR(30),
    license_plate VARCHAR(20) UNIQUE,
    image_url TEXT,
    description TEXT,
    features TEXT,
    deals BOOLEAN DEFAULT FALSE,
    available BOOLEAN DEFAULT TRUE,
    location VARCHAR(100) DEFAULT 'Main Office',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =====================================================
-- TABLE: bookings (stores all reservations)
-- =====================================================
CREATE TABLE bookings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_number VARCHAR(20) UNIQUE,
    user_id INT NOT NULL,
    car_id INT NOT NULL,
    car_name VARCHAR(100),
    renter_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    pickup_location VARCHAR(100),
    dropoff_location VARCHAR(100),
    total_days INT,
    daily_rate DECIMAL(10,2),
    total_price DECIMAL(10,2),
    tax_amount DECIMAL(10,2) DEFAULT 0,
    grand_total DECIMAL(10,2),
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'refunded') DEFAULT 'pending',
    status ENUM('pending', 'confirmed', 'active', 'completed', 'cancelled') DEFAULT 'pending',
    special_requests TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE
);

-- =====================================================
-- TABLE: email_logs (tracks all email confirmations)
-- =====================================================
CREATE TABLE email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT,
    recipient VARCHAR(100),
    subject VARCHAR(255),
    message TEXT,
    status ENUM('sent', 'failed') DEFAULT 'sent',
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL
);

-- =====================================================
-- TABLE: payments (detailed payment tracking)
-- =====================================================
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    booking_id INT NOT NULL,
    transaction_id VARCHAR(100) UNIQUE,
    amount DECIMAL(10,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
);

-- =====================================================
-- TABLE: car_reviews (customer ratings and reviews)
-- =====================================================
CREATE TABLE car_reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    car_id INT NOT NULL,
    user_id INT NOT NULL,
    booking_id INT,
    rating INT CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (car_id) REFERENCES cars(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE SET NULL
);

-- =====================================================
-- TABLE: locations (branches/pickup locations)
-- =====================================================
CREATE TABLE locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(20),
    phone VARCHAR(20),
    email VARCHAR(100),
    hours VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE
);

-- =====================================================
-- INSERT SAMPLE DATA
-- =====================================================

-- Insert sample users (passwords are 'password123' hashed)
INSERT INTO users (name, email, password, phone, address, driver_license) VALUES
('John Smith', 'john.smith@email.com', '$2y$10$YourHashedPasswordHere1234567890', '+1-555-0101', '123 Main St, New York, NY 10001', 'NY123456'),
('Sarah Johnson', 'sarah.j@email.com', '$2y$10$YourHashedPasswordHere1234567890', '+1-555-0102', '456 Oak Ave, Los Angeles, CA 90001', 'CA789012'),
('Michael Chen', 'michael.chen@email.com', '$2y$10$YourHashedPasswordHere1234567890', '+1-555-0103', '789 Pine Rd, Chicago, IL 60601', 'IL345678'),
('Emma Wilson', 'emma.w@email.com', '$2y$10$YourHashedPasswordHere1234567890', '+1-555-0104', '321 Elm St, Miami, FL 33101', 'FL901234'),
('James Brown', 'james.b@email.com', '$2y$10$YourHashedPasswordHere1234567890', '+1-555-0105', '654 Cedar Ln, Las Vegas, NV 89101', 'NV567890');

-- Insert sample cars (with real Unsplash images)
INSERT INTO cars (brand, model, year, type, fuel, transmission, price_per_day, seats, doors, image_url, deals, available, location, description, features) VALUES
('Toyota', 'Camry', 2024, 'sedan', 'petrol', 'Automatic', 65, 5, 4, 'https://images.unsplash.com/photo-1621007947382-bb3c3994e3fb?w=400&h=300&fit=crop', TRUE, TRUE, 'New York', 'Sleek and reliable sedan perfect for business trips', 'Bluetooth, Backup Camera, Cruise Control, USB Port'),
('Honda', 'CR-V', 2024, 'suv', 'diesel', 'Automatic', 85, 5, 5, 'https://images.unsplash.com/photo-1568605117036-5fe5e7fa0ab7?w=400&h=300&fit=crop', FALSE, TRUE, 'Los Angeles', 'Spacious SUV ideal for family vacations', 'AWD, Third Row, DVD Player, Roof Rack'),
('Ford', 'Mustang', 2024, 'convertible', 'petrol', 'Manual', 150, 4, 2, 'https://images.unsplash.com/photo-1584345604476-8ec5e12e42dd?w=400&h=300&fit=crop', TRUE, TRUE, 'Miami', 'Iconic American muscle car for an exciting drive', 'V8 Engine, Premium Sound, Leather Seats'),
('Tesla', 'Model 3', 2024, 'sedan', 'electric', 'Automatic', 120, 5, 4, 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=400&h=300&fit=crop', TRUE, TRUE, 'Los Angeles', 'High-tech electric vehicle with autopilot', 'Autopilot, Glass Roof, 15" Touchscreen, Supercharging'),
('BMW', 'X5', 2024, 'suv', 'diesel', 'Automatic', 190, 7, 5, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop', FALSE, TRUE, 'New York', 'Luxury SUV with premium features', 'Panoramic Roof, Heated Seats, HUD, Wireless Charging'),
('Toyota', 'RAV4', 2024, 'suv', 'hybrid', 'Automatic', 95, 5, 5, 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&h=300&fit=crop', FALSE, TRUE, 'Chicago', 'Fuel-efficient hybrid SUV', 'Hybrid Synergy Drive, Lane Assist, Apple CarPlay'),
('Honda', 'Civic', 2024, 'sedan', 'petrol', 'Automatic', 55, 5, 4, 'https://images.unsplash.com/photo-1550355291-bbee04a92027?w=400&h=300&fit=crop', FALSE, TRUE, 'Miami', 'Compact and fuel-efficient city car', 'Eco Assist, Multi-angle Camera, Digital Display'),
('Chevrolet', 'Corvette', 2024, 'convertible', 'petrol', 'Manual', 220, 2, 2, 'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop', TRUE, TRUE, 'Las Vegas', 'High-performance sports car for thrill-seekers', '495 HP, 0-60 in 3.0s, Performance Exhaust'),
('Nissan', 'Altima', 2024, 'sedan', 'petrol', 'Automatic', 60, 5, 4, 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop', FALSE, TRUE, 'Chicago', 'Comfortable midsize sedan', 'Zero Gravity Seats, Nissan Safety Shield'),
('Jeep', 'Wrangler', 2024, 'suv', 'petrol', 'Manual', 130, 5, 4, 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?w=400&h=300&fit=crop', TRUE, TRUE, 'Las Vegas', 'Off-road capable SUV for adventures', '4x4, Removable Doors, All-terrain Tires'),
('Audi', 'Q5', 2024, 'suv', 'diesel', 'Automatic', 175, 5, 5, 'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop', FALSE, TRUE, 'New York', 'Premium German SUV', 'Quattro AWD, Virtual Cockpit, Bang & Olufsen'),
('Lexus', 'RX 350', 2024, 'suv', 'petrol', 'Automatic', 165, 5, 5, 'https://images.unsplash.com/photo-1568605117036-5fe5e7fa0ab7?w=400&h=300&fit=crop', TRUE, TRUE, 'Los Angeles', 'Luxury hybrid SUV', 'Mark Levinson Audio, Semi-Aniline Leather, Heated Steering Wheel');

-- Insert sample locations
INSERT INTO locations (name, address, city, state, zip_code, phone, email, hours) VALUES
('Downtown NYC', '350 5th Ave', 'New York', 'NY', '10118', '+1-212-555-0100', 'nyc@rentacar.com', 'Mon-Sun 8am-10pm'),
('LAX Airport', '9020 Aviation Blvd', 'Los Angeles', 'CA', '90045', '+1-310-555-0200', 'lax@rentacar.com', '24/7'),
('Miami Beach', '1000 Collins Ave', 'Miami', 'FL', '33139', '+1-305-555-0300', 'miami@rentacar.com', 'Mon-Sun 9am-11pm'),
('Las Vegas Strip', '3770 S Las Vegas Blvd', 'Las Vegas', 'NV', '89109', '+1-702-555-0400', 'vegas@rentacar.com', '24/7'),
('Chicago Loop', '205 W Monroe St', 'Chicago', 'IL', '60606', '+1-312-555-0500', 'chicago@rentacar.com', 'Mon-Sat 8am-9pm, Sun 10am-6pm');

-- Insert sample bookings
INSERT INTO bookings (booking_number, user_id, car_id, car_name, renter_name, email, phone, start_date, end_date, total_days, daily_rate, total_price, tax_amount, grand_total, payment_status, status, pickup_location) VALUES
('BK-2025-001', 1, 1, 'Toyota Camry', 'John Smith', 'john.smith@email.com', '+1-555-0101', '2025-03-15', '2025-03-20', 5, 65, 325, 26.00, 351.00, 'paid', 'completed', 'New York'),
('BK-2025-002', 2, 4, 'Tesla Model 3', 'Sarah Johnson', 'sarah.j@email.com', '+1-555-0102', '2025-03-18', '2025-03-25', 7, 120, 840, 67.20, 907.20, 'paid', 'active', 'Los Angeles'),
('BK-2025-003', 3, 3, 'Ford Mustang', 'Michael Chen', 'michael.chen@email.com', '+1-555-0103', '2025-04-01', '2025-04-05', 4, 150, 600, 48.00, 648.00, 'pending', 'confirmed', 'Miami'),
('BK-2025-004', 1, 8, 'Chevrolet Corvette', 'John Smith', 'john.smith@email.com', '+1-555-0101', '2025-05-10', '2025-05-15', 5, 220, 1100, 88.00, 1188.00, 'paid', 'confirmed', 'Las Vegas'),
('BK-2025-005', 4, 2, 'Honda CR-V', 'Emma Wilson', 'emma.w@email.com', '+1-555-0104', '2025-03-22', '2025-03-28', 6, 85, 510, 40.80, 550.80, 'paid', 'active', 'Chicago');

-- Insert sample payments
INSERT INTO payments (booking_id, transaction_id, amount, payment_method, payment_status) VALUES
(1, 'TXN-001-2025', 351.00, 'Credit Card', 'completed'),
(2, 'TXN-002-2025', 907.20, 'PayPal', 'completed'),
(4, 'TXN-003-2025', 1188.00, 'Credit Card', 'completed'),
(5, 'TXN-004-2025', 550.80, 'Debit Card', 'completed');

-- Insert sample email logs
INSERT INTO email_logs (booking_id, recipient, subject, message) VALUES
(1, 'john.smith@email.com', 'Booking Confirmation - BK-2025-001', 'Your Toyota Camry booking is confirmed. Total: $351.00'),
(2, 'sarah.j@email.com', 'Booking Confirmation - BK-2025-002', 'Your Tesla Model 3 booking is confirmed. Total: $907.20'),
(3, 'michael.chen@email.com', 'Booking Confirmation - BK-2025-003', 'Your Ford Mustang booking is confirmed. Total: $648.00'),
(4, 'john.smith@email.com', 'Booking Confirmation - BK-2025-004', 'Your Chevrolet Corvette booking is confirmed. Total: $1188.00'),
(5, 'emma.w@email.com', 'Booking Confirmation - BK-2025-005', 'Your Honda CR-V booking is confirmed. Total: $550.80');

-- Insert sample reviews
INSERT INTO car_reviews (car_id, user_id, booking_id, rating, review_text) VALUES
(1, 1, 1, 5, 'Great car, very comfortable and fuel efficient!'),
(4, 2, 2, 5, 'Amazing electric vehicle, loved the autopilot feature'),
(3, 3, 3, 4, 'Powerful engine, but a bit loud on highway'),
(8, 1, 4, 5, 'Incredible performance, worth every penny!');

-- =====================================================
-- CREATE USEFUL VIEWS
-- =====================================================

-- View for available cars
CREATE VIEW available_cars AS
SELECT c.*, 
       CASE 
           WHEN b.id IS NULL THEN 'Available'
           WHEN b.end_date < CURDATE() THEN 'Available'
           ELSE 'Booked'
       END as current_status
FROM cars c
LEFT JOIN bookings b ON c.id = b.car_id 
    AND b.status IN ('confirmed', 'active')
    AND b.start_date <= CURDATE() 
    AND b.end_date >= CURDATE();

-- View for monthly revenue
CREATE VIEW monthly_revenue AS
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as total_bookings,
    SUM(grand_total) as revenue
FROM bookings
WHERE status IN ('completed', 'active')
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month DESC;

-- View for popular cars
CREATE VIEW popular_cars AS
SELECT 
    c.id,
    c.brand,
    c.model,
    COUNT(b.id) as booking_count,
    AVG(r.rating) as avg_rating
FROM cars c
LEFT JOIN bookings b ON c.id = b.car_id
LEFT JOIN car_reviews r ON c.id = r.car_id
GROUP BY c.id
ORDER BY booking_count DESC;

-- =====================================================
-- CREATE USEFUL STORED PROCEDURES
-- =====================================================

-- Procedure to check car availability
DELIMITER //
CREATE PROCEDURE CheckCarAvailability(
    IN car_id_param INT,
    IN start_date DATE,
    IN end_date DATE
)
BEGIN
    SELECT 
        c.*,
        CASE 
            WHEN EXISTS (
                SELECT 1 FROM bookings 
                WHERE car_id = car_id_param 
                AND status IN ('confirmed', 'active')
                AND (
                    (start_date BETWEEN start_date AND end_date)
                    OR (end_date BETWEEN start_date AND end_date)
                    OR (start_date <= start_date AND end_date >= end_date)
                )
            ) THEN 'Not Available'
            ELSE 'Available'
        END as availability
    FROM cars c
    WHERE c.id = car_id_param;
END//
DELIMITER ;

-- Procedure to calculate booking price
DELIMITER //
CREATE PROCEDURE CalculateBookingPrice(
    IN car_id_param INT,
    IN start_date DATE,
    IN end_date DATE
)
BEGIN
    DECLARE days INT;
    DECLARE daily_rate DECIMAL(10,2);
    DECLARE subtotal DECIMAL(10,2);
    DECLARE tax DECIMAL(10,2);
    DECLARE total DECIMAL(10,2);
    
    SELECT price_per_day INTO daily_rate FROM cars WHERE id = car_id_param;
    SET days = DATEDIFF(end_date, start_date);
    SET subtotal = days * daily_rate;
    SET tax = subtotal * 0.08; -- 8% tax
    SET total = subtotal + tax;
    
    SELECT 
        days as total_days,
        daily_rate,
        subtotal,
        tax as tax_amount,
        total as grand_total;
END//
DELIMITER ;

-- =====================================================
-- CREATE TRIGGERS
-- =====================================================

-- Trigger to generate booking number automatically
DELIMITER //
CREATE TRIGGER generate_booking_number
BEFORE INSERT ON bookings
FOR EACH ROW
BEGIN
    DECLARE next_id INT;
    SET next_id = (SELECT AUTO_INCREMENT FROM information_schema.tables 
                   WHERE table_name = 'bookings' 
                   AND table_schema = DATABASE());
    SET NEW.booking_number = CONCAT('BK-', YEAR(NEW.created_at), '-', LPAD(next_id, 6, '0'));
END//
DELIMITER ;

-- Trigger to update car_name in bookings
DELIMITER //
CREATE TRIGGER update_car_name
BEFORE INSERT ON bookings
FOR EACH ROW
BEGIN
    DECLARE car_name_val VARCHAR(100);
    SELECT CONCAT(brand, ' ', model) INTO car_name_val 
    FROM cars WHERE id = NEW.car_id;
    SET NEW.car_name = car_name_val;
END//
DELIMITER ;

-- =====================================================
-- CREATE INDEXES FOR BETTER PERFORMANCE
-- =====================================================

CREATE INDEX idx_bookings_dates ON bookings(start_date, end_date);
CREATE INDEX idx_bookings_user ON bookings(user_id);
CREATE INDEX idx_bookings_status ON bookings(status);
CREATE INDEX idx_cars_type ON cars(type);
CREATE INDEX idx_cars_fuel ON cars(fuel);
CREATE INDEX idx_cars_price ON cars(price_per_day);
CREATE INDEX idx_users_email ON users(email);

-- =====================================================
-- SAMPLE QUERIES FOR TESTING
-- =====================================================

-- 1. Get all available cars for specific dates
SELECT * FROM cars 
WHERE id NOT IN (
    SELECT car_id FROM bookings 
    WHERE status IN ('confirmed', 'active')
    AND '2025-04-01' BETWEEN start_date AND end_date
);

-- 2. Get user booking history with car details
SELECT 
    u.name,
    u.email,
    b.booking_number,
    b.car_name,
    b.start_date,
    b.end_date,
    b.total_days,
    b.grand_total,
    b.status
FROM users u
JOIN bookings b ON u.id = b.user_id
WHERE u.email = 'john.smith@email.com'
ORDER BY b.created_at DESC;

-- 3. Get revenue by month
SELECT 
    DATE_FORMAT(created_at, '%Y-%m') as month,
    COUNT(*) as bookings,
    SUM(grand_total) as revenue
FROM bookings
WHERE status = 'completed'
GROUP BY DATE_FORMAT(created_at, '%Y-%m')
ORDER BY month DESC;

-- 4. Get top rated cars
SELECT 
    c.brand,
    c.model,
    AVG(r.rating) as avg_rating,
    COUNT(r.id) as review_count
FROM cars c
LEFT JOIN car_reviews r ON c.id = r.car_id
GROUP BY c.id
HAVING review_count > 0
ORDER BY avg_rating DESC;

-- 5. Get upcoming bookings
SELECT 
    b.booking_number,
    b.car_name,
    b.renter_name,
    b.start_date,
    b.end_date,
    b.grand_total,
    TIMESTAMPDIFF(DAY, CURDATE(), b.start_date) as days_until_start
FROM bookings b
WHERE b.start_date > CURDATE()
AND b.status IN ('confirmed', 'pending')
ORDER BY b.start_date;

-- 6. Get current active rentals
SELECT 
    b.booking_number,
    b.car_name,
    b.renter_name,
    b.start_date,
    b.end_date,
    DATEDIFF(b.end_date, CURDATE()) as days_remaining,
    b.grand_total
FROM bookings b
WHERE b.start_date <= CURDATE() 
AND b.end_date >= CURDATE()
AND b.status = 'active';

-- 7. Get location-wise car availability
SELECT 
    l.name as location,
    l.city,
    COUNT(c.id) as total_cars,
    SUM(CASE WHEN c.available = TRUE THEN 1 ELSE 0 END) as available_cars
FROM locations l
LEFT JOIN cars c ON c.location = l.name
GROUP BY l.id;

-- 8. Get payment summary
SELECT 
    payment_method,
    COUNT(*) as transaction_count,
    SUM(amount) as total_amount,
    AVG(amount) as average_amount
FROM payments
WHERE payment_status = 'completed'
GROUP BY payment_method;

-- =====================================================
-- GRANT PRIVILEGES (if needed)
-- =====================================================

-- Create application user (optional)
CREATE USER IF NOT EXISTS 'rentacar_app'@'localhost' IDENTIFIED BY 'SecurePass123!';
GRANT SELECT, INSERT, UPDATE, DELETE ON rentacar_db.* TO 'rentacar_app'@'localhost';
FLUSH PRIVILEGES;

-- =====================================================
-- DATABASE STATUS CHECK
-- =====================================================

-- Show all tables
SHOW TABLES;

-- Show table structures
DESCRIBE users;
DESCRIBE cars;
DESCRIBE bookings;
DESCRIBE email_logs;

-- Count records
SELECT 'users' as table_name, COUNT(*) as record_count FROM users
UNION ALL
SELECT 'cars', COUNT(*) FROM cars
UNION ALL
SELECT 'bookings', COUNT(*) FROM bookings
UNION ALL
SELECT 'email_logs', COUNT(*) FROM email_logs
UNION ALL
SELECT 'payments', COUNT(*) FROM payments
UNION ALL
SELECT 'car_reviews', COUNT(*) FROM car_reviews;

-- Show database size
SELECT 
    table_schema as database_name,
    SUM(data_length + index_length) / 1024 / 1024 as size_mb,
    COUNT(*) as tables
FROM information_schema.tables 
WHERE table_schema = 'rentacar_db'
GROUP BY table_schema;
