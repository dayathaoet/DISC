<?php
// Sertakan file ini di awal setiap halaman admin untuk memastikan sudah login
if (empty($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
