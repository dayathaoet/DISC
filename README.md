# D.I.S.C. Test

> Aplikasi tes kepribadian D.I.S.C. berbasis PHP dan MySQL, lengkap dengan dashboard admin serta ekspor laporan PDF.

![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?logo=mysql&logoColor=white)
![Status](https://img.shields.io/badge/status-ready%20to%20use-2ea44f)

## Tentang Proyek

D.I.S.C. Test membantu organisasi atau tim HR menyelenggarakan tes DISC secara digital. Peserta mengisi data diri dan 24 kelompok pernyataan; sistem kemudian menghitung skor **D**ominance, **I**nfluence, **S**teadiness, dan **C**onscientiousness dalam tiga perspektif: **MOST**, **LEAST**, dan **CHANGE**.

Hasil tes tersimpan di database dan dapat dikelola oleh administrator melalui dashboard internal.

## Fitur Utama

- 24 kelompok pertanyaan DISC dengan pilihan **Paling (P)** dan **Kurang (K)**.
- Validasi di browser dan server untuk memastikan jawaban lengkap serta P/K tidak sama.
- Perhitungan skor MOST, LEAST, dan CHANGE pada setiap dimensi DISC.
- Klasifikasi hingga 40 profil, berikut karakteristik, deskripsi, dan job match.
- Dashboard admin untuk melihat, mencari, dan membuka detail peserta.
- Visualisasi grafik skor DISC pada halaman detail.
- Ekspor hasil peserta ke PDF.
- Jawaban mentah tetap disimpan agar hasil dapat dihitung ulang di kemudian hari.

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend | PHP native |
| Database | MySQL |
| Akses database | PDO (`pdo_mysql`) |
| PDF | FPDF (sudah termasuk dalam proyek) |
| Frontend | HTML, CSS, JavaScript |

## Prasyarat

- PHP 8.0 atau lebih baru, dengan ekstensi `pdo_mysql` aktif.
- MySQL 8.0 atau versi yang kompatibel.
- Apache/Nginx. Untuk pengembangan lokal Windows, Laragon direkomendasikan.

> Composer tidak diperlukan; FPDF telah tersedia di folder `fpdf/`.

## Instalasi

### 1. Salin proyek

Untuk Laragon, letakkan proyek di direktori `www`:

```text
D:\laragon\www\disc-test
```

### 2. Buat database dan impor data awal

Jalankan Apache dan MySQL, lalu impor [disc_test.sql](disc_test.sql) melalui phpMyAdmin atau HeidiSQL.

Alternatif menggunakan MySQL CLI:

```powershell
mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS disc_test CHARACTER SET utf8mb4"
mysql -u root -p disc_test < disc_test.sql
```

File dump mencakup struktur tabel, akun admin awal, dan data contoh peserta.

### 3. Atur koneksi database

Perbarui nilai di [includes/config.php](includes/config.php) sesuai konfigurasi MySQL Anda:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'disc_test');
define('DB_USER', 'root');
define('DB_PASS', 'root');
```

Pada beberapa instalasi Laragon, password untuk user `root` adalah kosong. Jika demikian, gunakan:

```php
define('DB_PASS', '');
```

### 4. Jalankan aplikasi

Buka salah satu alamat berikut di browser:

```text
http://disc-test.test
```

atau

```text
http://localhost/disc-test
```

## Akses Admin

| Kredensial | Nilai awal |
| --- | --- |
| URL | `/admin/login.php` |
| Username | `admin` |
| Password | `admin123` |

> Demi keamanan, segera ganti password bawaan setelah instalasi.

Untuk membuat hash password baru:

```powershell
php -r "echo password_hash('PASSWORD_BARU', PASSWORD_DEFAULT), PHP_EOL;"
```

Lalu jalankan perintah berikut pada database:

```sql
UPDATE admin_users
SET password_hash = 'HASH_PASSWORD_BARU'
WHERE username = 'admin';
```

## Alur Penggunaan

```text
Peserta
  Isi biodata → Kerjakan 24 soal → Jawaban divalidasi dan disimpan → Konfirmasi hasil

Admin
  Login → Dashboard peserta → Detail skor/profil → Unduh PDF
```

## Struktur Proyek

```text
disc-test/
├── admin/
│   ├── login.php             # Halaman masuk admin
│   ├── dashboard.php         # Daftar dan pencarian peserta
│   ├── detail.php            # Detail skor, grafik, dan profil peserta
│   └── export_pdf.php        # Pembuatan laporan PDF
├── assets/
│   └── style.css             # Gaya aplikasi
├── fpdf/                     # Library FPDF
├── includes/
│   ├── config.php            # Konfigurasi database dan session
│   ├── questions.php         # Bank 24 pertanyaan
│   ├── real_key.php          # Pemetaan jawaban ke dimensi DISC
│   ├── scaling_tables.php    # Tabel konversi skor
│   ├── scoring.php           # Mesin skor dan klasifikasi profil
│   ├── profiles_full.php     # Data 40 profil
│   └── descriptions.php      # Deskripsi faktor DISC
├── disc_test.sql             # Database, akun awal, dan data contoh
├── index.php                 # Form biodata
├── test.php                  # Halaman tes
├── submit.php                # Validasi serta penyimpanan jawaban
└── hasil.php                 # Halaman konfirmasi peserta
```

## Catatan Keamanan

- Jangan menyimpan kredensial produksi dalam repositori publik.
- Ganti kata sandi admin bawaan sebelum digunakan selain untuk pengembangan lokal.
- Gunakan HTTPS dan batasi akses ke folder `admin/` pada deployment produksi.
- Hasil tes kepribadian sebaiknya menjadi salah satu bahan pertimbangan, bukan satu-satunya dasar keputusan rekrutmen atau penilaian.

## Lisensi

Belum ada lisensi yang ditetapkan. Tambahkan file `LICENSE` sebelum mendistribusikan atau membuka penggunaan proyek kepada publik.
