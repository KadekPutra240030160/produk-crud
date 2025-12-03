<?php
require_once '../src/models/Produk.php';

$error = "";
$produk = new Produk();

// Ambil ID dari URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID produk tidak valid.");
}
$produk->id = (int)$_GET['id'];

// Ambil data produk lama
$dataLama = $produk->readOne();
if (!$dataLama) {
    die("Produk tidak ditemukan.");
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $produk->nama = trim($_POST['nama']);
    $produk->harga = (float)$_POST['harga'];
    $produk->kategori = $_POST['kategori'];
    $produk->status = $_POST['status'];
    $produk->gambar_path = null; // default: tidak ganti gambar

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
        // Cek apakah ada upload gambar baru
        if (!empty($_FILES['gambar']['name'])) {
            $uploadDir = 'uploads/';
            $fileName = basename($_FILES['gambar']['name']);
            $fileName = preg_replace('/[^a-zA-Z0-9._-]/', '_', $fileName);
            $fileName = time() . '_' . $fileName;
            $target = $uploadDir . $fileName;
            $ext = strtolower(pathinfo($target, PATHINFO_EXTENSION));
            $size = $_FILES['gambar']['size'];

            if (in_array($ext, ['jpg', 'jpeg', 'png']) && $size <= 2 * 1024 * 1024) {
                if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target)) {
                    $produk->gambar_path = $fileName;
                } else {
                    $error = "Gagal mengupload gambar baru.";
                }
            } else {
                $error = "Gambar harus JPG/PNG dan maks 2 MB.";
            }
        }
        // Jika tidak upload, biarkan $gambar_path = null → tidak diupdate

        if (!$error) {
            if ($produk->update()) {
                header("Location: index.php?msg=updated");
                exit;
            } else {
                $error = "Gagal memperbarui data.";
            }
        }
    }
} else {
    // Isi form dengan data lama (saat pertama kali buka halaman)
    $produk->nama = $dataLama['nama'];
    $produk->harga = $dataLama['harga'];
    $produk->kategori = $dataLama['kategori'];
    $produk->status = $dataLama['status'];
    $produk->gambar_path = $dataLama['gambar_path'];
    $dataLama = $dataLama; // agar bisa dipakai di view
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Produk</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        .form-group { margin-bottom: 15px; }
        label { display: inline-block; width: 120px; font-weight: bold; }
        input, select { padding: 5px; width: 250px; }
        button { padding: 8px 16px; background: #007bff; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; margin-bottom: 15px; }
        .gambar-lama { margin-top: 5px; font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
    <h1>✏️ Edit Produk</h1>

    <?php if ($error): ?>
        <div class="error"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?= htmlspecialchars($dataLama['nama']) ?>" maxlength="100" required>
        </div>

        <div class="form-group">
            <label for="harga">Harga:</label>
            <input type="number" id="harga" name="harga" value="<?= $dataLama['harga'] ?>" min="0" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="elektronik" <?= $dataLama['kategori'] == 'elektronik' ? 'selected' : '' ?>>Elektronik</option>
                <option value="pakaian" <?= $dataLama['kategori'] == 'pakaian' ? 'selected' : '' ?>>Pakaian</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="tersedia" <?= $dataLama['status'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= $dataLama['status'] == 'habis' ? 'selected' : '' ?>>Habis</option>
            </select>
        </div>

        <div class="form-group">
            <label for="gambar">Gambar Baru:</label>
            <input type="file" id="gambar" name="gambar" accept="image/jpeg,image/png">
            <div class="gambar-lama">
                Gambar saat ini:
                <?php if ($dataLama['gambar_path']): ?>
                    <img src="uploads/<?= htmlspecialchars($dataLama['gambar_path']) ?>" width="50">
                <?php else: ?>
                    —
                <?php endif; ?>
            </div>
            <small>Biarkan kosong jika tidak ingin ganti gambar.</small>
        </div>

        <button type="submit">Simpan Perubahan</button>
        <a href="index.php" style="margin-left: 10px;">Batal</a>
    </form>
</body>
</html>