CREATE DATABASE produk_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_general_ci;

USE produk_db;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    harga DECIMAL(10,2) NOT NULL CHECK (harga >= 0),
    kategori ENUM('elektronik', 'pakaian') NOT NULL,
    status ENUM('tersedia', 'habis') NOT NULL,
    gambar_path VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);