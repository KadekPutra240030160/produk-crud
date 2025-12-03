<?php
// src/config/Database.php

class Database {
    private $host = '127.0.0.1';      // atau 'localhost'
    private $db_name = 'produk_db';   // ← sesuaikan dengan nama DB-mu
    private $username = 'root';       // ← sesuaikan (biasanya 'root')
    private $password = '';           // ← sesuaikan (default kosong di banyak instalasi lokal)

    public function getConnection() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $pdo = new PDO($dsn, $this->username, $this->password, $options);
            return $pdo;
        } catch (PDOException $e) {
            die("Koneksi GAGAL: " . $e->getMessage());
        }
    }
}
?>