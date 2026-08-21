<?php
// ============================================================
// Mesin penghitung skor DISC — REPLIKA PERSIS dari logika file Excel asli
// (DISC.xlsx: sheet Input, Sheet3, Result, Def)
//
// Alur:
// 1. Untuk tiap soal, jawaban P dan K (posisi 1-4) diterjemahkan ke huruf
//    D/I/S/C lewat kunci resmi (includes/real_key.php). Sebagian posisi
//    memang tidak dipetakan ke huruf manapun (null) — ini SESUAI rumus asli.
// 2. Dihitung skor mentah MOST (dari P) dan LEAST (dari K) per huruf,
//    lalu CHANGE = MOST - LEAST.
// 3. Skor mentah "diskalakan" lewat tabel standarisasi resmi
//    (includes/scaling_tables.php, dari sheet 'Sheet3').
// 4. Nilai skala diuji lewat 40 aturan boolean resmi (fungsi classify40)
//    untuk menentukan indeks tipe profil (1-40).
// 5. Indeks dipakai untuk mengambil kode, nama, trait, deskripsi, dan job
//    match dari includes/profiles_full.php (dari sheet 'Def').
// ============================================================

/**
 * Hitung skor MOST, LEAST, CHANGE (mentah) dari jawaban peserta.
 * $answers = [question_no => ['most' => posisi(1-4), 'least' => posisi(1-4)]]
 */
function calculateScores(array $answers, array $key = null) {
    $key = $key ?? require __DIR__ . '/real_key.php';

    $most  = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];
    $least = ['D' => 0, 'I' => 0, 'S' => 0, 'C' => 0];

    foreach ($answers as $qno => $ans) {
        if (!isset($key[$qno])) continue;
        $pLetter = $key[$qno]['P'][$ans['most']] ?? null;
        $kLetter = $key[$qno]['K'][$ans['least']] ?? null;
        if ($pLetter !== null) $most[$pLetter]++;
        if ($kLetter !== null) $least[$kLetter]++;
    }

    $change = [
        'D' => $most['D'] - $least['D'],
        'I' => $most['I'] - $least['I'],
        'S' => $most['S'] - $least['S'],
        'C' => $most['C'] - $least['C'],
    ];

    return [$most, $least, $change];
}

/**
 * Cari nilai skala (standar) untuk skor mentah tertentu, memakai tabel
 * lookup resmi (meniru perilaku VLOOKUP-approximate Excel: ambil baris
 * dengan kunci terbesar yang <= nilai mentah; clip ke ujung tabel bila
 * di luar jangkauan).
 */
function scaleValue(float $raw, array $table): array {
    $best = $table[0];
    foreach ($table as $row) {
        if ($row[0] <= $raw) {
            $best = $row;
        } else {
            break;
        }
    }
    return ['D' => $best[1], 'I' => $best[2], 'S' => $best[3], 'C' => $best[4]];
}

/**
 * 40 aturan klasifikasi profil resmi (dari sheet Result, kolom BH:CU).
 * Menerima nilai skala D/I/S/C, mengembalikan indeks 1-40 (indeks pertama
 * yang aturannya terpenuhi — sama seperti MATCH(1,...,0) di Excel).
 * Mengembalikan null jika tidak ada yang cocok (seharusnya tidak terjadi).
 */
function classify40(float $d, float $i, float $s, float $c): ?int {
    $rules = [
        1  => fn() => $d<=0 && $i<=0 && $s<=0 && $c>0,
        2  => fn() => $d>0 && $i<=0 && $s<=0 && $c<=0,
        3  => fn() => $d>0 && $i<=0 && $s<=0 && $c>0 && $c>=$d,
        4  => fn() => $d>0 && $i>0 && $s<=0 && $c<=0 && $i>=$d,
        5  => fn() => $d>0 && $i>0 && $s<=0 && $c>0 && $i>=$d && $d>=$c,
        6  => fn() => $d>0 && $i>0 && $s>0 && $c<=0 && $i>=$d && $d>=$s,
        7  => fn() => $d>0 && $i>0 && $s>0 && $c<=0 && $i>=$s && $s>=$d,
        8  => fn() => $d>0 && $i<=0 && $s>0 && $c>0 && $s>=$d && $d>=$c,
        9  => fn() => $d>0 && $i>0 && $s<=0 && $c<=0 && $d>=$i,
        10 => fn() => $d>0 && $i>0 && $s>0 && $c<=0 && $d>=$i && $i>=$s,
        11 => fn() => $d>0 && $i<=0 && $s>0 && $c<=0 && $d>=$s,
        12 => fn() => $d<=0 && $i>0 && $s>0 && $c>0 && $c>=$i && $i>=$s,
        13 => fn() => $d<=0 && $i>0 && $s>0 && $c>0 && $c>=$s && $s>=$i,
        14 => fn() => $d<=0 && $i>0 && $s>0 && $c>0 && $i>=$s && $i>=$c,
        15 => fn() => $d<=0 && $i<=0 && $s>0 && $c<=0,
        16 => fn() => $d<=0 && $i<=0 && $s>0 && $c>0 && $c>=$s,
        17 => fn() => $d<=0 && $i<=0 && $s>0 && $c>0 && $s>=$c,
        18 => fn() => $i<=0 && $s<=0 && $d>0 && $c>0 && $d>=$c,
        19 => fn() => $d>0 && $i>0 && $c>0 && $s<=0 && $d>=$i && $i>=$c,
        20 => fn() => $d>0 && $s>0 && $i>0 && $c<=0 && $d>=$s && $s>=$i,
        21 => fn() => $d>0 && $s>0 && $c>0 && $i<=0 && $d>=$s && $s>=$c,
        22 => fn() => $d>0 && $i>0 && $c>0 && $s<=0 && $d>=$c && $c>=$i,
        23 => fn() => $d>0 && $s>0 && $c>0 && $i<=0 && $d>=$c && $c>=$s,
        24 => fn() => $d<=0 && $s<=0 && $c<=0 && $i>0,
        25 => fn() => $i>0 && $s>0 && $d<=0 && $c<=0 && $i>=$s,
        26 => fn() => $i>0 && $c>0 && $d<=0 && $s<=0 && $i>=$c,
        27 => fn() => $d>0 && $i>0 && $c>0 && $s<=0 && $i>=$c && $c>=$d,
        28 => fn() => $d<=0 && $i>0 && $s>0 && $c>0 && $i>=$c && $c>=$s,
        29 => fn() => $d>0 && $i<=0 && $s>0 && $c<=0 && $s>=$d,
        30 => fn() => $i>0 && $s>0 && $d<=0 && $c<=0 && $s>=$i,
        31 => fn() => $d>0 && $i>0 && $s>0 && $c<=0 && $s>=$d && $d>=$i,
        32 => fn() => $d>0 && $i>0 && $s>0 && $c<=0 && $s>=$i && $i>=$d,
        33 => fn() => $i>0 && $s>0 && $c>0 && $d<=0 && $s>=$i && $i>=$c,
        34 => fn() => $d>0 && $i<=0 && $s>0 && $c>0 && $s>=$c && $c>=$d,
        35 => fn() => $i>0 && $s>0 && $c>0 && $d<=0 && $s>=$c && $c>=$i,
        36 => fn() => $i>0 && $c>0 && $d<=0 && $s<=0 && $c>=$i,
        37 => fn() => $d>0 && $i>0 && $c>0 && $s<=0 && $c>=$d && $d>=$i,
        38 => fn() => $d>0 && $s>0 && $c>0 && $i<=0 && $c>=$d && $d>=$s,
        39 => fn() => $d>0 && $i>0 && $c>0 && $s<=0 && $c>=$i && $i>=$d,
        40 => fn() => $d>0 && $s>0 && $c>0 && $i<=0 && $c>=$s && $s>=$d,
    ];
    foreach ($rules as $idx => $rule) {
        if ($rule()) return $idx;
    }
    return null;
}

/**
 * Tentukan profil lengkap (kode, nama, traits, deskripsi, job match) dari
 * skor mentah tertentu (MOST, LEAST, atau CHANGE) memakai tabel skala yang sesuai.
 * $tableName: 'most' | 'least' | 'change'
 */
function determineProfileFull(array $rawScores, string $tableName): array {
    $tables = require __DIR__ . '/scaling_tables.php';
    $table = $tables[$tableName];

    // Untuk tiap huruf, skor mentah di-scale terpisah (karena kurva tiap huruf
    // berbeda), sesuai VLOOKUP asli yang dipanggil terpisah untuk kolom D/I/S/C.
    $scaled = [];
    foreach (['D', 'I', 'S', 'C'] as $letter) {
        $scaled[$letter] = scaleValue((float)$rawScores[$letter], $table)[$letter];
    }

    $idx = classify40($scaled['D'], $scaled['I'], $scaled['S'], $scaled['C']);
    $profiles = require __DIR__ . '/profiles_full.php';

    if ($idx === null || !isset($profiles[$idx])) {
        return ['idx' => null, 'code' => '-', 'name' => 'Tidak Terklasifikasi', 'traits' => [], 'job_match' => '', 'deskripsi' => ''];
    }

    return array_merge(['idx' => $idx], $profiles[$idx]);
}

/**
 * Dapatkan huruf/faktor dominan tertinggi (D, I, S, atau C) berdasarkan Grafik D.I.S.C.
 */
function getDominantTrait(array $scores): string {
    $maxLetter = 'D';
    $maxVal = -9999;
    foreach (['D', 'I', 'S', 'C'] as $letter) {
        $val = (float)($scores[$letter] ?? 0);
        if ($val > $maxVal) {
            $maxVal = $val;
            $maxLetter = $letter;
        }
    }
    return $maxLetter;
}

