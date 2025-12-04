<?php
/**
 * Controller: DaftarMahasiswaKelasController
 * Menangani logika pencarian dan tampilan daftar mahasiswa per kelas
 */

require "models/DaftarMahasiswaKelas.php";
require "models/TahunAkademik.php";
require "models/Prodi.php";

$daftarMahasiswaKelas = new DaftarMahasiswaKelas($koneksi);
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
$totalMahasiswa = 0;
$statsByGender = ['L' => 0, 'P' => 0];
$statsByStatus = [];

// STEP 1: User memilih Tahun Akademik dan Prodi
if (isset($_GET['tahap']) && $_GET['tahap'] == 'pilih_kelas') {
    
    $thakdId = $_GET['thakdId'] ?? '';
    $prodiId = $_GET['prodiId'] ?? '';
    
    // Validasi input
    if (empty($thakdId) || empty($prodiId)) {
        $error = "Harap pilih Tahun Akademik dan Program Studi!";
    } else {
        // Ambil daftar kelas untuk dropdown
        $listKelas = $daftarMahasiswaKelas->getKelasByTahunProdi($thakdId, $prodiId);
        
        if ($listKelas->num_rows == 0) {
            $error = "⚠️ Tidak ada kelas yang terdaftar untuk:<br>
                     - Tahun Akademik ID: <strong>" . htmlspecialchars($thakdId) . "</strong><br>
                     - Program Studi ID: <strong>" . htmlspecialchars($prodiId) . "</strong><br><br>
                     💡 Silakan tambah data kelas terlebih dahulu di menu <a href='index.php?page=kelas'>Data Kelas</a>";
        }
    }
}

// STEP 2: User memilih Kelas dan menampilkan data mahasiswa
else if (isset($_GET['cari'])) {
    
    $thakdId = $_GET['thakdId'] ?? '';
    $prodiId = $_GET['prodiId'] ?? '';
    $klsId = $_GET['klsId'] ?? '';
    
    // Validasi input
    if (empty($thakdId) || empty($prodiId) || empty($klsId)) {
        $error = "Harap pilih Tahun Akademik, Program Studi, dan Nama Kelas!";
    } else {
        // Ambil info kelas
        $kelasInfo = $daftarMahasiswaKelas->getKelasInfo($klsId);
        
        if (!$kelasInfo) {
            $error = "❌ Data kelas tidak ditemukan!";
        } else {
            // Ambil daftar mahasiswa
            $rows = $daftarMahasiswaKelas->getByKelas($klsId);
            
            // Hitung statistik
            $totalMahasiswa = $daftarMahasiswaKelas->getTotalMahasiswa($klsId);
            $statsByGender = $daftarMahasiswaKelas->getStatsByGender($klsId);
            $statsByStatus = $daftarMahasiswaKelas->getStatsByStatus($klsId);
            
            if ($rows->num_rows == 0) {
                $error = "⚠️ Tidak ada mahasiswa yang terdaftar untuk kelas <strong>" . htmlspecialchars($kelasInfo['klsNama']) . "</strong><br><br>
                         💡 Silakan tambah data mahasiswa kelas terlebih dahulu.";
            }
        }
    }
}

// Tampilkan view
require "views/daftarMahasiswaKelas/index.php";
?>