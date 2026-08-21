<?php
require_once __DIR__ . '/includes/config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$ok = $id > 0 && isset($_SESSION['last_result_id']) && $_SESSION['last_result_id'] === $id;
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tes Selesai</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container narrow">
    <div class="card center">
        <?php if ($ok): ?>
            <h1>Terima Kasih!</h1>
            <p>Tes D.I.S.C. Anda telah berhasil disimpan.</p>
            <p class="muted">Hasil tes akan direview oleh admin/HR.</p>
        <?php else: ?>
            <h1>Data tidak ditemukan</h1>
            <p><a href="index.php">Kembali ke awal</a></p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
