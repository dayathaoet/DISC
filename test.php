<?php
require_once __DIR__ . '/includes/config.php';

// Data biodata dikirim dari index.php via POST, simpan ke session
if (isset($_POST['nama'])) {
    $_SESSION['biodata'] = [
        'nama' => trim($_POST['nama']),
        'usia' => (int)$_POST['usia'],
        'jenis_kelamin' => $_POST['jenis_kelamin'],
    ];
}

if (empty($_SESSION['biodata'])) {
    header('Location: index.php');
    exit;
}

$questions = require __DIR__ . '/includes/questions.php';
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
<div class="container">
    <h1>D.I.S.C. Test</h1>
    <p class="subtitle">
        Untuk setiap nomor, beri tanda pada kolom <strong>P</strong> di samping kalimat yang
        <strong>PALING</strong> menggambarkan diri Anda, dan kolom <strong>K</strong> di samping kalimat yang
        <strong>PALING TIDAK</strong> menggambarkan diri Anda. Setiap nomor hanya boleh 1 tanda P dan 1 tanda K,
        dan tidak boleh pada kalimat yang sama.
    </p>

    <form action="submit.php" method="post" id="discForm">
        <table class="test-table">
            <thead>
                <tr><th>No</th><th>Gambaran Diri</th><th>P</th><th>K</th></tr>
            </thead>
            <tbody>
            <?php foreach ($questions as $no => $items): ?>
                <?php foreach ($items as $idx => $text): $pos = $idx + 1; ?>
                <tr class="<?= $idx === 0 ? 'q-start' : '' ?>">
                    <?php if ($idx === 0): ?>
                        <td rowspan="4" class="qno"><?= $no ?></td>
                    <?php endif; ?>
                    <td class="qtext"><?= htmlspecialchars($text) ?></td>
                    <td class="qradio"><input type="radio" name="most[<?= $no ?>]" value="<?= $pos ?>" required></td>
                    <td class="qradio"><input type="radio" name="least[<?= $no ?>]" value="<?= $pos ?>" required></td>
                </tr>
            <?php endforeach; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
        <button type="submit" class="btn-primary">Selesai & Lihat Hasil</button>
    </form>
</div>

<script>
// Cegah memilih pernyataan yang sama sebagai P dan K pada nomor yang sama
document.getElementById('discForm').addEventListener('submit', function (e) {
    for (let q = 1; q <= 24; q++) {
        const mostChecked = document.querySelector(`input[name="most[${q}]"]:checked`);
        const leastChecked = document.querySelector(`input[name="least[${q}]"]:checked`);
        if (!mostChecked || !leastChecked) {
            e.preventDefault();
            alert('Nomor ' + q + ' belum lengkap diisi (P dan K).');
            return;
        }
        if (mostChecked.value === leastChecked.value) {
            e.preventDefault();
            alert('Nomor ' + q + ': pernyataan yang sama tidak boleh dipilih sebagai P dan K sekaligus.');
            return;
        }
    }
});
</script>
</body>
</html>
