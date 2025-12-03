<?php
require_once '../src/models/Produk.php';
$produk = new Produk();
$stmt = $produk->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Produk</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 30px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f5f5f5; }
        img { max-width: 50px; height: auto; }
        .aksi a { margin-right: 10px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>
    <h1>📦 Daftar Produk</h1>
    <a href="create.php">➕ Tambah Produk Baru</a>

    <?php
if (isset($_GET['msg'])) {
    $msgs = [
        'created' => '✅ Produk berhasil ditambahkan!',
        'updated' => '✅ Produk berhasil diperbarui!',
        'deleted' => '🗑️ Produk berhasil dihapus!'
    ];
    $msg = $_GET['msg'];
    if (isset($msgs[$msg])) {
        echo "<p style='color:green; background:#e6f4ea; padding:10px; border-radius:4px; margin:15px 0;'>{$msgs[$msg]}</p>";
    }
}
?>

<table>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt->fetch()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= ucfirst($row['kategori']) ?></td>
                <td>
                    <?php if ($row['status'] == 'tersedia'): ?>
                        <span style="color: green;">✅ Tersedia</span>
                    <?php else: ?>
                        <span style="color: red;">❌ Habis</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if ($row['gambar_path']): ?>
                        <img src="uploads/<?= htmlspecialchars($row['gambar_path']) ?>" alt="Gambar">
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
                <td class="aksi">
                    <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" 
                       onclick="return confirm('Yakin hapus produk ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>