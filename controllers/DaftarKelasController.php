<?php

require "models/DaftarKelas.php";
require "models/TahunAkademik.php";
require "models/Prodi.php";

$daftarKelas = new DaftarKelas($koneksi);
$tahunAkademik = new TahunAkademik($koneksi);
$prodi = new Prodi($koneksi);

// Ambil data untuk dropdown
$listTa = $tahunAkademik->all();
$listProdi = $prodi->all();

// Inisialisasi variabel hasil pencarian
$rows = null;
$thakdId = null;
$prodiId = null;

// Proses pencarian jika form di-submit
if (isset($_GET['cari'])) {
    
    $thakdId = $_GET['thakdId'] ?? '';
    $prodiId = $_GET['prodiId'] ?? '';
    
    // Validasi input
    if (empty($thakdId) || empty($prodiId)) {
        $error = "Harap pilih Tahun Akademik dan Program Studi!";
    } else {
        // Ambil data kelas
        $rows = $daftarKelas->getByTahunAkademikAndProdi($thakdId, $prodiId);
        
        // Debug: Cek apakah ada data kelas
        if ($rows->num_rows == 0) {
            $debugResult = $daftarKelas->debugCheckData($thakdId, $prodiId);
            
            if ($debugResult->num_rows == 0) {
                $error = "⚠️ Tidak ada kelas yang terdaftar untuk:<br>
                         - Tahun Akademik ID: <strong>" . htmlspecialchars($thakdId) . "</strong><br>
                         - Program Studi ID: <strong>" . htmlspecialchars($prodiId) . "</strong><br><br>
                         💡 Silakan tambah data kelas terlebih dahulu di menu <a href='index.php?page=kelas'>Data Kelas</a>";
            }
        }
    }
}

// Tampilkan view
require "views/daftarKelas/index.php";
?>