# Sistem Informasi Persediaan Obat Apotek (FIFO)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

Sistem Informasi Persediaan Obat Apotek berbasis web yang dikembangkan menggunakan framework **Laravel** dan basis data **MySQL**. Aplikasi ini dirancang untuk mengelola stok obat secara efisien menggunakan metode **FIFO (First-In, First-Out)** guna meminimalkan risiko obat kedaluwarsa.

Proyek ini dikembangkan sebagai **Tugas Akhir** program D4 Manajemen Informatika Universitas Negeri Surabaya dan telah diuji dengan 11 skenario *Black Box Testing* dengan tingkat kelulusan 100%.

---

## 🌟 Fitur Utama

- **Rotasi Stok Otomatis (Metode FIFO):** Pengeluaran obat diprioritaskan berdasarkan batch obat yang masuk terlebih dahulu.
- **Peringatan & Notifikasi Kedaluwarsa:** Fitur deteksi otomatis untuk obat yang mendekati tanggal *expired*.
- **Multi-level Access Control (3 Level Pengguna):**
  - **Admin:** Pengelolaan penuh sistem, pengguna, dan konfigurasi master data.
  - **Apoteker/Petugas:** Pengelolaan transaksi masuk/keluar obat dan pemantauan stok.
  - **Kepala/Manajer:** Akses laporan persediaan dan analitis.
- **Manajemen Transaksi & Laporan:** Pencatatan obat masuk, obat keluar, serta rekapitulasi laporan stok terintegrasi.

---

## 🛠️ Teknologi & Stack

- **Framework Backend:** Laravel 10 (PHP 8.2)
- **Database:** MySQL
- **Frontend:** Blade Templating, Tailwind CSS, Vite
- **Testing:** Black Box Testing (11 Skenario Lulus)

---

## 🚀 Panduan Instalasi (Lokal)

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### 2. Kloning Repositori
```bash
git clone [https://github.com/Rosyidaauliyas/inventory-apotek.git](https://github.com/Rosyidaauliyas/inventory-apotek.git)
cd inventory-apotek
