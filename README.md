# Aplikasi CRUD Produk – Backend Sederhana

Dibuat untuk tugas mata kuliah **Pengembangan Sistem Backend**.

## Entitas
- **Produk**: nama, harga, kategori, status, gambar

## Teknologi
- PHP 8.x (native)
- MySQL (PDO)
- Built-in server PHP

## Struktur
- `public/` → halaman HTML & file upload
- `src/config/` → koneksi database
- `src/models/` → logika CRUD

## Cara Menjalankan
1. Buat database `produk_db` di MySQL
2. Impor `schema.sql`
3. Sesuaikan koneksi di `src/config/Database.php`
4. Jalankan:
   ```bash
   cd public
   php -S localhost:8000