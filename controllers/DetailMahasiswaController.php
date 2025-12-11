<?php

// Pastikan path sudah benar
require "models/Mahasiswa.php";

$mahasiswa = new Mahasiswa($koneksi);

$aksi = $_GET['aksi'] ?? 'detail';
$nim = $_GET['id'] ?? null;

if ($aksi == "detail" && $nim) {
    
    $mhsNim = htmlspecialchars($nim, ENT_QUOTES, 'UTF-8');
    $dataMahasiswa = $mahasiswa->get($mhsNim);
    
    
    // --- 3. Ambil Data Program Studi (Prodi) Mahasiswa ---
    // (Diasumsikan tabel program_studi menggunakan prodiId)
    $stmtProdi = $koneksi->prepare("
        SELECT p.prodiNama, p.prodiJenjang
        FROM program_studi p
        WHERE p.prodiId = ?
    ");
    $stmtProdi->bind_param("i", $dataMahasiswa['mhsProdiId']);
    $stmtProdi->execute();
    $queryProdi = $stmtProdi->get_result();
    $dataProdi = $queryProdi ? $queryProdi->fetch_assoc() : null;
    $stmtProdi->close();
    
    // --- 4. Ambil Riwayat Kelas yang Pernah Diikuti Mahasiswa ---
    $stmtKelas = $koneksi->prepare("
        SELECT 
            k.klsNama, 
            t.thakdTahun, 
            t.thakdSemester,
            p.prodiNama,
            -- Asumsi tabel kelas_mahasiswa memiliki kolom klsmhsMhsNim
            km.klsmhsIsAktif,
            -- Hitung jumlah matakuliah yang diambil mahasiswa di kelas ini
            (SELECT COUNT(DISTINCT kmk.klsmkMkId)
             FROM kelas_matakuliah kmk 
             WHERE kmk.klsmkKlsId = k.klsId
            ) AS jlhMatkulDiambil
        FROM kelas_mahasiswa km
        INNER JOIN kelas k ON km.klsmhsKlsId = k.klsId
        LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE km.klsmhsMhsNim = ?
        ORDER BY t.thakdId DESC
    ");
    $stmtKelas->bind_param("s", $mhsNim);
    $stmtKelas->execute();
    $queryKelas = $stmtKelas->get_result();
    $stmtKelas->close();
    
    // --- 5. Logika Status Akademik dan Statistik ---
    $totalKelasDiikuti = $queryKelas ? $queryKelas->num_rows : 0;
    
    // Logika Status Akademik (mhsStsAkademik)
    $statusMap = [
        'A' => 'Aktif', // Aktif
        'L' => 'Lulus',
        'C' => 'Cuti',
        'D' => 'Drop Out',
        'K' => 'Keluar',
        'M' => 'Meninggal',
    ];
    $mhsStsAkademik = $dataMahasiswa['mhsStsAkademik'] ?? 'A';
    $statusAkademik = $statusMap[$mhsStsAkademik] ?? 'Tidak Diketahui';
    $isAktif = ($mhsStsAkademik == 'A'); // Boolean untuk menentukan warna
    
    // Label Semester Aktif
    $mhsSmsAktif = $dataMahasiswa['mhsSmsAktif'] ?? 0;
    
    require "views/detailMahasiswa/index.php";
}

?>