<?php

require "models/DaftarDosenKelas.php";
require "models/TahunAkademik.php";
require "models/Prodi.php";

$daftarDosenKelas = new DaftarDosenKelas($koneksi);
$tahunAkademik = new TahunAkademik($koneksi);
$prodi = new Prodi($koneksi);

// Ambil data untuk dropdown
$listTa = $tahunAkademik->all();
$listProdi = $prodi->all();

// Inisialisasi variabel
$rows = null;
$kelasInfo = null;
$listKelas = null;
$thakdId = null;
$prodiId = null;
$klsId = null;
$totalDosen = 0;
$totalMatakuliah = 0;

if (isset($_GET['tahap']) && $_GET['tahap'] == 'pilih_kelas') {
    
    $thakdId = $_GET['thakdId'] ?? '';
    $prodiId = $_GET['prodiId'] ?? '';
    
    if (empty($thakdId) || empty($prodiId)) {
        $error = "Harap pilih Tahun Akademik dan Program Studi!";
    } else {

        $listKelas = $daftarDosenKelas->getKelasByTahunProdi($thakdId, $prodiId);
        
        if ($listKelas->num_rows == 0) {
            $error = "Tidak ada kelas yang terdaftar untuk:<br>
                     - Tahun Akademik ID: <strong>" . htmlspecialchars($thakdId) . "</strong><br>
                     - Program Studi ID: <strong>" . htmlspecialchars($prodiId) . "</strong><br><br>
                     Silakan tambah data kelas terlebih dahulu di menu <a href='index.php?page=kelas'>Data Kelas</a>";
        }
    }
}

else if (isset($_GET['cari'])) {
    
    $thakdId = $_GET['thakdId'] ?? '';
    $prodiId = $_GET['prodiId'] ?? '';
    $klsId = $_GET['klsId'] ?? '';
    
    if (empty($thakdId) || empty($prodiId) || empty($klsId)) {
        $error = "Harap pilih Tahun Akademik, Program Studi, dan Nama Kelas!";
    } else {
        $kelasInfo = $daftarDosenKelas->getKelasInfo($klsId);
        
        if (!$kelasInfo) {
            $error = " Data kelas tidak ditemukan!";
        } else {
            $rows = $daftarDosenKelas->getByKelas($klsId);
            
            $totalDosen = $daftarDosenKelas->getTotalDosen($klsId);
            $totalMatakuliah = $daftarDosenKelas->getTotalMatakuliah($klsId);
            
            if ($rows->num_rows == 0) {
                $error = " Tidak ada dosen yang terdaftar untuk kelas <strong>" . htmlspecialchars($kelasInfo['klsNama']) . "</strong><br><br>
                          Silakan tambah data dosen kelas terlebih dahulu.";
            }
        }
    }
}

require "views/daftarDosenKelas/index.php";
?>