<?php
require_once '../src/models/Produk.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID tidak valid.");
}

$produk = new Produk();
$produk->id = (int)$_GET['id'];


 $data = $produk->readOne();
 if ($data && $data['gambar_path']) {
     $filePath = __DIR__ . '/uploads/' . $data['gambar_path'];
     if (file_exists($filePath)) {
         unlink($filePath);
     }
 }

// Hapus dari database
if ($produk->delete()) {
    header("Location: index.php?msg=deleted");
} else {
    die("Gagal menghapus produk.");
}
exit;
?>