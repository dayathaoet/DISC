<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/scoring.php';

if (empty($_SESSION['biodata']) || empty($_POST['most']) || empty($_POST['least'])) {
    header('Location: index.php');
    exit;
}

$biodata = $_SESSION['biodata'];
$mostRaw = $_POST['most'];   // [qno => posisi]
$leastRaw = $_POST['least']; // [qno => posisi]

// Validasi server-side: 24 nomor harus terisi, dan most != least per nomor
$answers = [];
for ($q = 1; $q <= 24; $q++) {
    if (!isset($mostRaw[$q]) || !isset($leastRaw[$q])) {
        die('Jawaban tidak lengkap. <a href="test.php">Kembali</a>');
    }
    $m = (int)$mostRaw[$q];
    $l = (int)$leastRaw[$q];
    if ($m === $l || $m < 1 || $m > 4 || $l < 1 || $l > 4) {
        die('Jawaban tidak valid pada nomor ' . $q . '. <a href="test.php">Kembali</a>');
    }
    $answers[$q] = ['most' => $m, 'least' => $l];
}

[$most, $least, $change] = calculateScores($answers);

$mostProfile   = determineProfileFull($most, 'most');
$leastProfile  = determineProfileFull($least, 'least');
$changeProfile = determineProfileFull($change, 'change');

$pdo = getDB();
$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare("
        INSERT INTO participants
            (nama, usia, jenis_kelamin,
             most_d, most_i, most_s, most_c,
             least_d, least_i, least_s, least_c,
             change_d, change_i, change_s, change_c,
             most_profil_idx, most_profil_kode, most_profil_nama,
             least_profil_idx, least_profil_kode, least_profil_nama,
             change_profil_idx, change_profil_kode, change_profil_nama)
        VALUES (?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?,?, ?,?,?, ?,?,?, ?,?,?)
    ");
    $stmt->execute([
        $biodata['nama'], $biodata['usia'], $biodata['jenis_kelamin'],
        $most['D'], $most['I'], $most['S'], $most['C'],
        $least['D'], $least['I'], $least['S'], $least['C'],
        $change['D'], $change['I'], $change['S'], $change['C'],
        $mostProfile['idx'], $mostProfile['code'], $mostProfile['name'],
        $leastProfile['idx'], $leastProfile['code'], $leastProfile['name'],
        $changeProfile['idx'], $changeProfile['code'], $changeProfile['name'],
    ]);
    $participantId = $pdo->lastInsertId();

    $stmtAns = $pdo->prepare("
        INSERT INTO answers (participant_id, question_no, most_position, least_position)
        VALUES (?,?,?,?)
    ");
    foreach ($answers as $qno => $ans) {
        $stmtAns->execute([$participantId, $qno, $ans['most'], $ans['least']]);
    }

    $pdo->commit();
} catch (Exception $e) {
    $pdo->rollBack();
    die('Gagal menyimpan hasil: ' . htmlspecialchars($e->getMessage()));
}

unset($_SESSION['biodata']);
$_SESSION['last_result_id'] = $participantId;

header('Location: hasil.php?id=' . $participantId);
exit;
