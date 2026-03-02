<?php
// Database Connection (without database selection first)
$conn = new mysqli('localhost', 'root', '', '');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create Database
$sql_create_db = "CREATE DATABASE IF NOT EXISTS ecommerce_db";
if ($conn->query($sql_create_db) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select database
$conn->select_db('ecommerce_db');

// Create Products Table
$sql_create_table = "CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_create_table) === TRUE) {
    echo "<br>Table 'products' created successfully";
} else {
    echo "<br>Error creating table: " . $conn->error;
}

// Insert Sample Products
$sample_products = [
    ['Laptop Dell XPS 13', 'Laptop tingkat tinggi dengan prosesor Intel Core i7', 15000000, 'laptop1.jpg', 5],
    ['Smartphone Samsung Galaxy S21', 'Smartphone terbaru dengan kamera 64MP', 12000000, 'phone1.jpg', 10],
    ['Headphone Sony WH-1000XM4', 'Headphone noise-cancelling terbaik', 4500000, 'headphone1.jpg', 8],
    ['Tablet iPad Pro 11 inch', 'Tablet produktif dengan layar retina', 10000000, 'tablet1.jpg', 6],
    ['Smart Watch Apple Watch Series 7', 'Smartwatch dengan fitur kesehatan lengkap', 5000000, 'watch1.jpg', 12]
];

foreach ($sample_products as $product) {
    $name = $conn->real_escape_string($product[0]);
    $desc = $conn->real_escape_string($product[1]);
    $price = $product[2];
    $image = $product[3];
    $stock = $product[4];
    
    $sql_insert = "INSERT INTO products (name, description, price, image, stock) 
                   VALUES ('$name', '$desc', $price, '$image', $stock)";
    
    $conn->query($sql_insert);
}

echo "<br>Sample products inserted successfully";
$conn->close();
?>