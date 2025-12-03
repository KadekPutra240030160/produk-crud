# Aplikasi CRUD Produk – Backend Sederhana

Aplikasi back-end sederhana untuk mengelola entitas **Produk** menggunakan PHP dan MySQL. Dibuat sebagai tugas mata kuliah **Pengembangan Sistem Backend**.

## 📦 Entitas: Produk

- **Tabel**: `products`
- **Atribut**:
  - `nama` (teks, wajib, maks 100 karakter)
  - `harga` (numerik, ≥ 0)
  - `kategori` (pilihan: `elektronik`, `pakaian`)
  - `status` (pilihan: `tersedia`, `habis`)
  - `gambar_path` (string opsional, menyimpan path file di `uploads/`)
  - `created_at` (timestamp otomatis)

## 🛠️ Spesifikasi Teknis

- **Bahasa**: PHP 8.x (native)
- **Database**: MySQL
- **Driver**: PDO
- **Arsitektur**: Modular (pemisahan config, model, dan tampilan)
- **File upload**: Disimpan di `public/uploads/`, path disimpan di database

## 📂 Struktur Folder
roduk-crud/<br>
&nbsp;&nbsp;public/<br>
&nbsp;&nbsp;&nbsp;&nbsp;index.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;create.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;edit.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;delete.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;uploads/<br>
&nbsp;&nbsp;src/<br>
&nbsp;&nbsp;&nbsp;&nbsp;config/<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Database.php<br>
&nbsp;&nbsp;&nbsp;&nbsp;models/<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Produk.php<br>
&nbsp;&nbsp;schema.sql<br>
&nbsp;&nbsp;README.md

## ▶️ Cara Menjalankan

1. **Impor database**:
   - Buat database baru di MySQL (misal: `produk_db`)
   - Jalankan file `schema.sql` untuk membuat tabel

2. **Konfigurasi koneksi**:
   - Sesuaikan username/password di `src/config/Database.php`

3. **Jalankan server**:
   ```bash
   cd public
   php -S localhost:8000