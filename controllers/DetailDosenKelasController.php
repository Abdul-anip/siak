<?php
// Pastikan model Dosen tersedia
require "models/Dosen.php"; 

$dosen = new Dosen($koneksi);

// Mengambil NIDN dari URL
$nidn = $_GET['id'] ?? null;
$aksi = $_GET['aksi'] ?? 'detail';

/* ============================================================
    TAMPILKAN DETAIL DOSEN
    ============================================================ */
if ($aksi == "detail" && $nidn) {
    
    // --- 1. Sanitasi Input ---
    // NIDN mungkin merupakan string atau integer tergantung format universitas
    // Kita pastikan ia bersih dari karakter yang berbahaya (walaupun Prepared Statement akan membantu)
    $dsnNidn = htmlspecialchars($nidn, ENT_QUOTES, 'UTF-8');
    
    // --- 2. Ambil Data Dasar Dosen ---
    $dataDosen = $dosen->get($dsnNidn);
    
    if (!$dataDosen) {
        $error = "Data dosen tidak ditemukan!";
        require "views/404.php";
        exit;
    }

    // Buat nama lengkap dosen untuk kemudahan tampilan di view
    $gelarDepan = $dataDosen['dsnGelarDepan'] ?? '';
    $gelarBelakang = $dataDosen['dsnGelarBelakang'] ?? '';
    
    $dataDosen['namaLengkap'] = trim(
        (empty($gelarDepan) ? '' : $gelarDepan . ' ') .
        $dataDosen['dsnNama'] .
        (empty($gelarBelakang) ? '' : ', ' . $gelarBelakang)
    );
    
    $stmtMatkul = $koneksi->prepare("
        SELECT DISTINCT
            m.mkId, 
            m.mkKode, 
            m.mkNama,
            m.mkSks,
            COUNT(kd.klsdsnKlsId) AS jumlahKelas
        FROM kelas_dosen kd
        INNER JOIN matakuliah m ON kd.klsdsnMkId = m.mkId
        WHERE kd.klsdsnDsnNidn = ? 
        AND kd.klsdsnIsAktif = 1
        GROUP BY m.mkId, m.mkKode, m.mkNama, m.mkSks
        ORDER BY m.mkNama ASC
    ");
    $stmtMatkul->bind_param("s", $dsnNidn);
    $stmtMatkul->execute();
    $queryMatkul = $stmtMatkul->get_result();
    $stmtMatkul->close();
    
    $stmtKelas = $koneksi->prepare("
        SELECT 
            k.klsId,
            k.klsNama,
            t.thakdTahun,
            t.thakdSemester,
            p.prodiNama,
            p.prodiJenjang,
            -- Hitung jumlah matakuliah yang diajarkan dosen ini di kelas ini
            (SELECT COUNT(klsdsnMkId) 
             FROM kelas_dosen 
             WHERE klsdsnKlsId = k.klsId 
             AND klsdsnDsnNidn = ?
             AND klsdsnIsAktif = 1
            ) AS jlhMatkulDiajar,
            -- Hitung jumlah mahasiswa di kelas ini
            (SELECT COUNT(klsmhsMhsNim) 
             FROM kelas_mahasiswa 
             WHERE klsmhsKlsId = k.klsId 
             AND klsmhsIsAktif = 1
            ) AS jlhMahasiswa
        FROM kelas_dosen kd
        INNER JOIN kelas k ON kd.klsdsnKlsId = k.klsId
        LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE kd.klsdsnDsnNidn = ?
        AND kd.klsdsnIsAktif = 1
        GROUP BY k.klsId, k.klsNama, t.thakdTahun, t.thakdSemester, p.prodiNama, p.prodiJenjang
        ORDER BY t.thakdId DESC, k.klsNama ASC
    ");
    $stmtKelas->bind_param("ss", $dsnNidn, $dsnNidn); // NIDN digunakan 2 kali
    $stmtKelas->execute();
    $queryKelas = $stmtKelas->get_result();
    $stmtKelas->close();

    // --- 5. Statistik ---
    $totalMatkulDiajar = $queryMatkul ? $queryMatkul->num_rows : 0;
    $totalKelasDiampu = $queryKelas ? $queryKelas->num_rows : 0;
    
    // Hitung total SKS yang diajarkan (berdasarkan totalMatkulDiajar * SKS)
    // Ini memerlukan iterasi hasil query Matkul, atau dibuatkan query terpisah yang menjumlahkan SKS

    // Hitung total mahasiswa unik yang pernah/sedang diajar
    $stmtTotalMhs = $koneksi->prepare("
        SELECT COUNT(DISTINCT km.klsmhsMhsNim) AS total
        FROM kelas_dosen kd
        INNER JOIN kelas_mahasiswa km ON kd.klsdsnKlsId = km.klsmhsKlsId
        WHERE kd.klsdsnDsnNidn = ?
        AND kd.klsdsnIsAktif = 1
        AND km.klsmhsIsAktif = 1
    ");
    $stmtTotalMhs->bind_param("s", $dsnNidn);
    $stmtTotalMhs->execute();
    $queryTotalMhs = $stmtTotalMhs->get_result();
    
    $totalMahasiswa = 0;
    if ($queryTotalMhs && $row = $queryTotalMhs->fetch_assoc()) {
        $totalMahasiswa = $row['total'];
    }
    $stmtTotalMhs->close();
    
    // --- 6. Tampilkan View ---
    require "views/detailDosen/index.php";

} 

?>