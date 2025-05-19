-- Create database
CREATE DATABASE IF NOT EXISTS smartstay;
USE smartstay;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    userPassword VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Rooms table
CREATE TABLE rooms (
    id INT PRIMARY KEY AUTO_INCREMENT,
    roomName VARCHAR(100) NOT NULL,
    roomDescription TEXT,
    price DECIMAL(10,2) NOT NULL,
    capacity INT NOT NULL,
    image_url VARCHAR(255),
    is_available BOOLEAN DEFAULT true
);

-- Bookings table
CREATE TABLE bookings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    room_id INT NOT NULL,
    check_in DATE NOT NULL,
    check_out DATE NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    bookingStatus ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (room_id) REFERENCES rooms(id)
);

-- Sample room data
INSERT INTO rooms (roomName, roomDescription, price, capacity, image_url, is_available) VALUES
('Deluxe Suite', 'Spacious suite with ocean view', 299.99, 2, 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg', true),
('Family Room', 'Perfect for families, includes kitchen', 399.99, 4, 'https://images.pexels.com/photos/271619/pexels-photo-271619.jpeg', true),
('Presidential Suite', 'Luxury suite with private balcony', 599.99, 2, 'https://images.pexels.com/photos/262048/pexels-photo-262048.jpeg', true),
('Beach Room', 'Comfortable room for three', 249.99, 3, 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg', true),
('Atlantic Room', 'Comfortable room for two', 169.99, 2, 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg', true),
('Exquisite Room', 'Comfortable room for two', 179.99, 2, 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg', true),