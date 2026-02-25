-- Database creation
CREATE DATABASE IF NOT EXISTS kiosk_sebastiaan_jeran;
USE kiosk_sebastiaan_jeran;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image_path VARCHAR(255),
    category VARCHAR(50) DEFAULT 'algemeen'
);

-- Orders table (The ID will serve as the order number)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'paid', 'completed') DEFAULT 'pending',
    total_amount DECIMAL(10, 2) DEFAULT 0.00
);

-- Items within an order
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    price_at_purchase DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Sample Data (Voorbeeld producten)
INSERT INTO products (name, description, price, image_path, category) VALUES
('Happy Burger', 'Heerlijke plantaardige burger met verse sla en tomaat.', 8.50, 'assets/burger.png', 'hoofdgerecht'),
('Dino Fries', 'Krokante frietjes in de vorm van dinosaurussen.', 3.50, 'assets/fries.png', 'bijgerecht'),
('Volcano Shake', 'Aardbeienshake met een vurige twist.', 4.00, 'assets/shake.png', 'dranken'),
('Jungle Juice', 'Verse tropische mix van sinaasappel en mango.', 3.00, 'assets/juice.png', 'dranken');
