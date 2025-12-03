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
produk-crud/
  public/
    index.php
    create.php
    edit.php
    delete.php
    uploads/
  src/
    config/
      Database.php
    models/
      Produk.php
  schema.sql
  README.md


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