<?php
require_once __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>D.I.S.C. Test</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container narrow">
    <h1>D.I.S.C. Test</h1>
    <p class="subtitle">Isi data diri Anda sebelum memulai tes.</p>

    <form action="test.php" method="post" class="card">
        <label>Nama Lengkap
            <input type="text" name="nama" required>
        </label>
        <label>Usia
            <input type="number" name="usia" min="15" max="80" required>
        </label>
        <label>Jenis Kelamin
            <select name="jenis_kelamin" required>
                <option value="">-- Pilih --</option>
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </label>
        <button type="submit" class="btn-primary">Mulai Tes</button>
    </form>
</div>
</body>
</html>
