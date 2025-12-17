<?php

require "models/Rapor.php";

$raporModel = new Rapor($koneksi);

// Ambil data mahasiswa untuk dropdown
$listMahasiswa = $raporModel->getAllMahasiswa();

// Inisialisasi variabel
$selectedNim = $_GET['nim'] ?? '';
$selectedSemester = $_GET['semester'] ?? '';
$dataRapor = null;
$message = '';

// Jika form disubmit (ada params nim dan semester)
if ($selectedNim && $selectedSemester) {
    $dataRapor = $raporModel->getRaporByNimAndSemester($selectedNim, $selectedSemester);
    
    if (!$dataRapor || $dataRapor->num_rows == 0) {
        $message = "Data rapor tidak ditemukan untuk mahasiswa dan semester tersebut.";
        $dataRapor = null; // Reset jika kosong
    }
}

require "views/pascakuliah/rapor.php";
?>
