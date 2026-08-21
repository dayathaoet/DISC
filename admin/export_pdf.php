<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../fpdf/fpdf.php';

$id = (int)($_GET['id'] ?? 0);
$pdo = getDB();
$stmt = $pdo->prepare("SELECT * FROM participants WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$p) {
    die('Data peserta tidak ditemukan.');
}

require_once __DIR__ . '/../includes/scoring.php';
$profiles = require __DIR__ . '/../includes/profiles_full.php';
$descriptions = require __DIR__ . '/../includes/descriptions.php';

$changeP = $p['change_profil_idx'] ? ($profiles[$p['change_profil_idx']] ?? null) : null;
$changeVals = ['D' => $p['change_d'], 'I' => $p['change_i'], 'S' => $p['change_s'], 'C' => $p['change_c']];
$dominantLetter = getDominantTrait($changeVals);
$dominantDesc = $descriptions[$dominantLetter] ?? null;

class DiscPDF extends FPDF {
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Hasil Tes D.I.S.C.', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(120, 120, 120);
        $this->Cell(0, 5, 'Dokumen ini dihasilkan otomatis oleh sistem tes DISC internal', 0, 1, 'C');
        $this->SetTextColor(0, 0, 0);
        $this->Ln(4);
    }
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
    }
    function SectionTitle($title) {
        $this->SetFont('Arial', 'B', 12);
        $this->SetFillColor(230, 230, 250);
        $this->Cell(0, 8, $this->cleanText($title), 0, 1, 'L', true);
        $this->Ln(2);
    }
    function cleanText($text) {
        // FPDF pakai encoding cp1252; konversi dari UTF-8 supaya karakter aman
        return iconv('UTF-8', 'CP1252//TRANSLIT', $text);
    }
    function BarChart($title, $vals, $maxAbs) {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(0, 6, $this->cleanText($title), 0, 1);
        $startX = $this->GetX() + 10;
        $baseY = $this->GetY() + 35;
        $barWidth = 15;
        $gap = 8;
        $maxBarHeight = 30;
        $i = 0;
        foreach ($vals as $letter => $val) {
            $h = $maxAbs > 0 ? max(1, (abs($val) / $maxAbs) * $maxBarHeight) : 1;
            $x = $startX + $i * ($barWidth + $gap);
            $y = $baseY - $h;
            $colors = ['D' => [231,76,60], 'I' => [241,196,15], 'S' => [46,204,113], 'C' => [52,152,219]];
            [$r,$g,$b] = $colors[$letter];
            $this->SetFillColor($r, $g, $b);
            $this->Rect($x, $y, $barWidth, $h, 'F');
            $this->SetFont('Arial', '', 9);
            $this->SetXY($x, $baseY + 2);
            $this->Cell($barWidth, 5, $letter . ' (' . $val . ')', 0, 0, 'C');
            $i++;
        }
        $this->SetXY(10, $baseY + 10);
        $this->Ln(15);
    }
    function ProfileBlock($title, $prof, $dominantLetter, $dominantDesc) {
        $this->SectionTitle($title);
        $this->SetFont('Arial', 'B', 10);
        
        $domLabel = $dominantDesc['label'] ?? '';
        $this->Cell(0, 6, $this->cleanText('Faktor Dominan: ' . $dominantLetter . ' (' . $domLabel . ')'), 0, 1);
        
        if ($prof) {
            $this->Cell(0, 6, $this->cleanText('Tipe Profil: Kode ' . $prof['code'] . '  -  ' . $prof['name']), 0, 1);
            $this->SetFont('Arial', '', 9);
            if (!empty($prof['traits'])) {
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(0, 5, 'Karakteristik:', 0, 1);
                $this->SetFont('Arial', '', 9);
                $this->MultiCell(0, 5, $this->cleanText(implode(', ', $prof['traits'])));
                $this->Ln(1);
            }
            $deskripsi = !empty($prof['deskripsi']) ? $prof['deskripsi'] : ($dominantDesc['deskripsi'] ?? '');
            if (!empty($deskripsi)) {
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(0, 5, 'Deskripsi Profil:', 0, 1);
                $this->SetFont('Arial', '', 9);
                $this->MultiCell(0, 5, $this->cleanText($deskripsi));
                $this->Ln(1);
            }
            $jobMatch = !empty($prof['job_match']) ? $prof['job_match'] : ($dominantDesc['job_match'] ?? '');
            if (!empty($jobMatch)) {
                $this->SetFont('Arial', 'B', 9);
                $this->Cell(0, 5, 'Rekomendasi Pekerjaan (Job Match):', 0, 1);
                $this->SetFont('Arial', '', 9);
                $this->MultiCell(0, 5, $this->cleanText($jobMatch));
            }
        }
        $this->Ln(3);
    }
}

$pdf = new DiscPDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SectionTitle('Data Peserta');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(40, 7, 'Nama', 0, 0);
$pdf->Cell(0, 7, ': ' . $pdf->cleanText($p['nama']), 0, 1);
$pdf->Cell(40, 7, 'Usia', 0, 0);
$pdf->Cell(0, 7, ': ' . $p['usia'] . ' tahun', 0, 1);
$pdf->Cell(40, 7, 'Jenis Kelamin', 0, 0);
$pdf->Cell(0, 7, ': ' . $p['jenis_kelamin'], 0, 1);
$pdf->Cell(40, 7, 'Tanggal Tes', 0, 0);
$pdf->Cell(0, 7, ': ' . date('d/m/Y H:i', strtotime($p['tanggal_tes'])), 0, 1);
$pdf->Ln(4);

$pdf->SectionTitle('Grafik D.I.S.C.');
$pdf->BarChart('Hasil Grafik D.I.S.C.', $changeVals, 24);

$pdf->ProfileBlock('Hasil Profil Kepribadian D.I.S.C.', $changeP, $dominantLetter, $dominantDesc);

$filename = 'DISC_' . preg_replace('/[^A-Za-z0-9_-]/', '_', $p['nama']) . '_' . $p['id'] . '.pdf';
$pdf->Output('D', $filename);
