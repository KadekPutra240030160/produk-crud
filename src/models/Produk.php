<?php
require_once __DIR__ . '/../config/Database.php';

class Produk {
    private $conn;
    private $table = 'products';

    public $id;
    public $nama;
    public $harga;
    public $kategori;
    public $status;
    public $gambar_path;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // CREATE
    public function create() {
        $query = "INSERT INTO {$this->table} (nama, harga, kategori, status, gambar_path) 
                  VALUES (:nama, :harga, :kategori, :status, :gambar_path)";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':kategori', $this->kategori);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':gambar_path', $this->gambar_path);

        return $stmt->execute();
    }

    // READ ALL
    public function read() {
        $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // READ ONE
    public function readOne() {
        $query = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch();
    }

    // UPDATE
    public function update() {
        $query = "UPDATE {$this->table} SET 
                  nama = :nama,
                  harga = :harga,
                  kategori = :kategori,
                  status = :status";
        
        if ($this->gambar_path !== null) {
            $query .= ", gambar_path = :gambar_path";
        }
        $query .= " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':kategori', $this->kategori);
        $stmt->bindParam(':status', $this->status);
        if ($this->gambar_path !== null) {
            $stmt->bindParam(':gambar_path', $this->gambar_path);
        }
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // DELETE
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
?>