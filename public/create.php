<?php
require_once '../src/models/Produk.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk = new Produk();
    $produk->nama = trim($_POST['nama']);
    $produk->harga = (float)$_POST['harga'];
    $produk->kategori = $_POST['kategori'];
    $produk->status = $_POST['status'];
    $produk->gambar_path = null;

    // Validasi
    if (empty($produk->nama) || strlen($produk->nama) > 100) {
        $error = "Nama wajib diisi dan maksimal 100 karakter.";
    } elseif ($produk->harga < 0) {
        $error = "Harga tidak boleh negatif.";
    } elseif (!in_array($produk->kategori, ['elektronik', 'pakaian'])) {
        $error = "Kategori tidak valid.";
    } elseif (!in_array($produk->status, ['tersedia', 'habis'])) {
        $error = "Status tidak valid.";
    } else {
        // Handle upload gambar
        if (!empty($_FILES['gambar']['name'])) {
            $uploadDir = 'uploads/';
            $fileName = basename($_FILES['gambar']['name']);
            // Bersihkan nama file
            $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
            $fileName = time() . '_' . $fileName;
            $target = $uploadDir . $fileName;
            $fileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            $fileSize = $_FILES['gambar']['size'];

            $allowedTypes = ['jpg', 'jpeg', 'png'];
            if (!in_array($fileType, $allowedTypes)) {
                $error = "Hanya file JPG/PNG yang diizinkan.";
            } elseif ($fileSize > 2 * 1024 * 1024) {
                $error = "Ukuran file maksimal 2 MB.";
            } else {
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $produk->gambar_path = $fileName;
                } else {
                    $error = "Gagal mengupload gambar.";
                }
            }
        }

        if (!$error) {
            if ($produk->create()) {
                header("Location: index.php?msg=created");
                exit;
            } else {
                $error = "Gagal menyimpan data ke database.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Produk</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; font-weight: bold; }
        input, select { padding: 5px; width: 250px; }
        button { padding: 8px 16px; background: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background: #218838; }
        .error { color: red; margin-bottom: 15px; }
    </style>
</head>
<body>
    <h1>➕ Tambah Produk Baru</h1>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" min="0" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="elektronik">Elektronik</option>
                <option value="pakaian">Pakaian</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="tersedia">Tersedia</option>
                <option value="habis">Habis</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar:</label>
            <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png">
            <small>Format: JPG/PNG, maks 2 MB</small>
        </div>

        <button type="submit">Simpan Produk</button>
        <a href="index.php" style="margin-left: 10px;">Batal</a>
    </form>
</body>