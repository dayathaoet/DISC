<?php
// ============================================================
// Konfigurasi koneksi database
// Sesuaikan dengan setting Laragon Anda (default Laragon: user root, password kosong)
// ============================================================
define('DB_HOST', 'localhost');
define('DB_NAME', 'disc_test');
define('DB_USER', 'root');
define('DB_PASS', 'root');

session_start();

function getDB() {
    static $pdo = null;
    if ($pdo === null) {
        try {
            $pdo = new PDO(
                'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
                DB_USER,
                DB_PASS,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die('Koneksi database gagal: ' . htmlspecialchars($e->getMessage()) .
                '<br>Pastikan Laragon aktif dan database "disc_test" sudah di-import dari schema.sql');
        }
    }
    return $pdo;
}
