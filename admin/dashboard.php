<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/scoring.php';

$pdo = getDB();

$search = trim($_GET['q'] ?? '');
if ($search !== '') {
    $stmt = $pdo->prepare("SELECT * FROM participants WHERE nama LIKE ? ORDER BY tanggal_tes DESC");
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query("SELECT * FROM participants ORDER BY tanggal_tes DESC");
}
$participants = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard - D.I.S.C. Test</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <div class="admin-header">
        <h1>Dashboard Hasil Tes DISC</h1>
        <div>
            <span class="muted">Login sebagai <?= htmlspecialchars($_SESSION['admin_username']) ?></span>
            &nbsp;|&nbsp; <a href="logout.php">Logout</a>
        </div>
    </div>

    <form method="get" class="search-bar">
        <input type="text" name="q" placeholder="Cari nama peserta..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn-secondary">Cari</button>
        <?php if ($search !== ''): ?><a href="dashboard.php" class="btn-link">Reset</a><?php endif; ?>
    </form>

    <table class="data-table">
        <thead>
            <tr>
                <th>Nama</th><th>Usia</th><th>JK</th><th>Tanggal Tes</th>
                <th>Dominan & Tipe Profil</th><th>D</th><th>I</th><th>S</th><th>C</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($participants)): ?>
            <tr><td colspan="10" class="center muted">Belum ada data peserta.</td></tr>
        <?php endif; ?>
        <?php foreach ($participants as $p): 
            $dom = getDominantTrait(['D' => $p['change_d'], 'I' => $p['change_i'], 'S' => $p['change_s'], 'C' => $p['change_c']]);
        ?>
            <tr>
                <td><?= htmlspecialchars($p['nama']) ?></td>
                <td><?= (int)$p['usia'] ?></td>
                <td><?= htmlspecialchars($p['jenis_kelamin']) ?></td>
                <td><?= date('d/m/Y H:i', strtotime($p['tanggal_tes'])) ?></td>
                <td><span style="font-weight:bold; color:var(--color-<?= strtolower($dom) ?>);">Dominan <?= $dom ?></span><br><small><strong><?= htmlspecialchars($p['change_profil_kode']) ?></strong> - <?= htmlspecialchars($p['change_profil_nama']) ?></small></td>
                <td><?= $p['change_d'] ?></td>
                <td><?= $p['change_i'] ?></td>
                <td><?= $p['change_s'] ?></td>
                <td><?= $p['change_c'] ?></td>
                <td>
                    <a href="detail.php?id=<?= $p['id'] ?>">Lihat</a> |
                    <a href="export_pdf.php?id=<?= $p['id'] ?>">PDF</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
