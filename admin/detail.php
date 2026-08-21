<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/auth.php';

$id = (int)($_GET['id'] ?? 0);
$pdo = getDB();
$stmt = $pdo->prepare("SELECT * FROM participants WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    die('Data peserta tidak ditemukan. <a href="dashboard.php">Kembali</a>');
}

require_once __DIR__ . '/../includes/scoring.php';
$profiles = require __DIR__ . '/../includes/profiles_full.php';
$descriptions = require __DIR__ . '/../includes/descriptions.php';

$changeP = $p['change_profil_idx'] ? ($profiles[$p['change_profil_idx']] ?? null) : null;
$changeVals = ['D' => $p['change_d'], 'I' => $p['change_i'], 'S' => $p['change_s'], 'C' => $p['change_c']];
$dominantLetter = getDominantTrait($changeVals);
$dominantDesc = $descriptions[$dominantLetter] ?? null;

function barHeight($val, $max = 24) {
    return max(2, round((abs($val) / $max) * 100));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Detail Hasil - <?= htmlspecialchars($p['nama']) ?></title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="container">
    <div class="admin-header">
        <h1>Detail Hasil DISC</h1>
        <div><a href="dashboard.php">&larr; Kembali</a> &nbsp;|&nbsp; <a href="export_pdf.php?id=<?= $p['id'] ?>">Download PDF</a></div>
    </div>

    <div class="card">
        <table class="bio-table">
            <tr><td><strong>Nama</strong></td><td><?= htmlspecialchars($p['nama']) ?></td></tr>
            <tr><td><strong>Usia</strong></td><td><?= (int)$p['usia'] ?> tahun</td></tr>
            <tr><td><strong>Jenis Kelamin</strong></td><td><?= htmlspecialchars($p['jenis_kelamin']) ?></td></tr>
            <tr><td><strong>Tanggal Tes</strong></td><td><?= date('d/m/Y H:i', strtotime($p['tanggal_tes'])) ?></td></tr>
        </table>
    </div>

    <div class="card">
        <h2>Grafik D.I.S.C.</h2>
        <div class="charts" style="justify-content: center;">
            <div class="chart-block" style="max-width: 400px; width: 100%;">
                <h3>Hasil Grafik D.I.S.C.</h3>
                <div class="bar-chart">
                    <?php foreach ($changeVals as $letter => $val): ?>
                    <div class="bar-col">
                        <div class="bar-value"><?= $val ?></div>
                        <div class="bar" style="height: <?= barHeight($val) ?>px; background: var(--color-<?= strtolower($letter) ?>);"></div>
                        <div class="bar-label" style="<?= $letter === $dominantLetter ? 'font-weight:bold; color:var(--color-' . strtolower($letter) . '); font-size:1.2rem;' : '' ?>"><?= $letter ?></div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <h2>Hasil Profil Kepribadian D.I.S.C.</h2>
        <p><strong>Faktor Dominan:</strong> <span style="font-size: 1.1rem; color: var(--color-<?= strtolower($dominantLetter) ?>); font-weight: bold;"><?= htmlspecialchars($dominantLetter) ?> (<?= htmlspecialchars($dominantDesc['label'] ?? '') ?>)</span></p>
        <?php if ($changeP): ?>
        <p><strong>Tipe Profil:</strong> Kode <?= htmlspecialchars($changeP['code']) ?> &mdash; <strong><?= htmlspecialchars($changeP['name']) ?></strong></p>
        <?php if (!empty($changeP['traits'])): ?>
        <p><strong>Karakteristik:</strong> <?= htmlspecialchars(implode(', ', $changeP['traits'])) ?></p>
        <?php endif; ?>
        <?php if (!empty($changeP['deskripsi'])): ?>
        <p><strong>Deskripsi Profil:</strong> <?= htmlspecialchars($changeP['deskripsi']) ?></p>
        <?php elseif (!empty($dominantDesc['deskripsi'])): ?>
        <p><strong>Deskripsi Profil:</strong> <?= htmlspecialchars($dominantDesc['deskripsi']) ?></p>
        <?php endif; ?>
        <?php if (!empty($changeP['job_match'])): ?>
        <p><strong>Rekomendasi Pekerjaan (Job Match):</strong> <?= htmlspecialchars($changeP['job_match']) ?></p>
        <?php elseif (!empty($dominantDesc['job_match'])): ?>
        <p><strong>Rekomendasi Pekerjaan (Job Match):</strong> <?= htmlspecialchars($dominantDesc['job_match']) ?></p>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
