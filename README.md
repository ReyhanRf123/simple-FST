# 🏫 SIMPEL-FST

**Sistem Pengaduan Fasilitas Kampus - Fakultas Sains dan Teknologi (UIN Syarif Hidayatullah Jakarta)**

Platform pelaporan kerusakan fasilitas akademik yang modern, responsif, dan interaktif. Dibangun menggunakan arsitektur TALL Stack untuk memfasilitasi komunikasi dua arah antara sivitas akademika dan tim teknisi kampus secara *real-time*.

## 🚀 Fitur Utama
- **Dashboard Multi-Role:** Akses UI yang berbeda untuk Pelapor (Mahasiswa/Dosen) dan Admin (Teknisi/TU).
- **Pelaporan Cerdas & Live Chat:** Form pengaduan dengan *Quick Pills*, *preview* foto, dan ruang diskusi *real-time* di setiap tiket.
- **Antrean Prioritas:** Sistem otomatis mengurutkan daftar pengerjaan teknisi berdasarkan bobot urgensi fasilitas.
- **Rekap & Ekspor:** Filter laporan instan dan fitur cetak khusus (PDF/Print) untuk keperluan laporan bulanan.

## 💻 Teknologi yang Digunakan
- **Backend:** Laravel (PHP), MySQL
- **Frontend:** Livewire 3 (Volt), Alpine.js, Tailwind CSS

## 🛠️ Cara Menjalankan di Komputer Lokal

1. **Clone repository** dan masuk ke folder proyek:
   ```bash
   git clone [https://github.com/username-anda/simpel-fst.git](https://github.com/username-anda/simpel-fst.git)
   cd simpel-fst

    Install dependency backend dan frontend:
    Bash

    composer install && npm install

    Setup Environment & Database:
    Gandakan file konfigurasi dan atur kredensial database (pastikan MySQL lokal menyala).
    Bash

    cp .env.example .env

    (Buka file .env, atur DB_DATABASE sesuai nama database Anda, lalu jalankan perintah di bawah)
    Bash

    php artisan key:generate
    php artisan migrate
    php artisan storage:link

    Jalankan Aplikasi:
    Buka dua terminal berbeda dan jalankan perintah berikut:
    Bash

    npm run dev
    # dan di terminal satunya:
    php artisan serve

Aplikasi kini dapat diakses di http://127.0.0.1:8000.

    Catatan Role: Untuk berpindah peran antara admin dan user, Anda dapat mengubah nilainya secara manual melalui tabel users di database.