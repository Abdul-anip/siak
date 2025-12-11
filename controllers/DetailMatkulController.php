<?php

require "models/Matkul.php";
require "models/DaftarMatkulKelas.php";

$matkul = new Matkul($koneksi);
$daftarMatkulKelas = new DaftarMatkulKelas($koneksi);

$aksi = $_GET['aksi'] ?? 'detail';

/* ============================================================
   TAMPILKAN DETAIL MATAKULIAH
   ============================================================ */
if ($aksi == "detail" && isset($_GET['id'])) {
    
    $mkId = intval($_GET['id']);
    
    // Ambil data matakuliah
    $dataMatkul = $matkul->get($mkId);
    
    if (!$dataMatkul) {
        $error = "Data matakuliah tidak ditemukan!";
        require "views/404.php";
        exit;
    }
    
    // Ambil data kurikulum
    $queryKurikulum = $koneksi->query("
        SELECT k.*, p.prodiNama, p.prodiJenjang
        FROM kurikulum k
        LEFT JOIN program_studi p ON k.kurProdiId = p.prodiId
        WHERE k.kurId = {$dataMatkul['mkKurId']}
    ");
    $dataKurikulum = $queryKurikulum ? $queryKurikulum->fetch_assoc() : null;
    
    // Ambil daftar kelas yang menggunakan matakuliah ini
    $queryKelas = $koneksi->query("
        SELECT 
            km.klsmkId,
            k.klsId,
            k.klsNama,
            t.thakdTahun,
            t.thakdSemester,
            CONCAT(t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                CASE t.thakdSemester 
                    WHEN '1' THEN 'Ganjil' 
                    WHEN '2' THEN 'Genap' 
                END
            ) AS tahunAkademikLabel,
            p.prodiNama,
            p.prodiJenjang,
            -- Hitung jumlah mahasiswa di kelas
            (SELECT COUNT(*) 
             FROM kelas_mahasiswa 
             WHERE klsmhsKlsId = k.klsId 
             AND klsmhsIsAktif = 1
            ) AS jlhMahasiswa,
            -- Hitung jumlah dosen yang mengajar matakuliah ini di kelas tersebut
            (SELECT COUNT(DISTINCT klsdsnDsnNidn)
             FROM kelas_dosen 
             WHERE klsdsnKlsId = k.klsId 
             AND klsdsnMkId = $mkId
             AND klsdsnIsAktif = 1
            ) AS jlhDosen
        FROM kelas_matakuliah km
        INNER JOIN kelas k ON km.klsmkKlsId = k.klsId
        LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE km.klsmkMkId = $mkId
        ORDER BY t.thakdId DESC, k.klsNama ASC
    ");
    
    // Ambil daftar dosen yang mengajar matakuliah ini
    $queryDosen = $koneksi->query("
        SELECT DISTINCT
            d.dsnNidn,
            d.dsnNama,
            d.dsnGelarDepan,
            d.dsnGelarBelakang,
            CONCAT(
                COALESCE(d.dsnGelarDepan, ''), 
                IF(d.dsnGelarDepan IS NOT NULL AND d.dsnGelarDepan != '', ' ', ''),
                d.dsnNama,
                IF(d.dsnGelarBelakang IS NOT NULL AND d.dsnGelarBelakang != '', ', ', ''),
                COALESCE(d.dsnGelarBelakang, '')
            ) AS namaLengkap,
            k.klsNama,
            t.thakdTahun,
            t.thakdSemester,
            p.prodiNama
        FROM kelas_dosen kd
        INNER JOIN dosen d ON kd.klsdsnDsnNidn = d.dsnNidn
        INNER JOIN kelas k ON kd.klsdsnKlsId = k.klsId
        LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE kd.klsdsnMkId = $mkId
        AND kd.klsdsnIsAktif = 1
        ORDER BY t.thakdId DESC, d.dsnNama ASC
    ");
    
    // Statistik
    $totalKelas = $queryKelas ? $queryKelas->num_rows : 0;
    $totalDosen = $queryDosen ? $queryDosen->num_rows : 0;
    
    // Hitung total mahasiswa yang mengambil matakuliah ini
    $queryTotalMhs = $koneksi->query("
        SELECT COUNT(DISTINCT km.klsmhsMhsNim) AS total
        FROM kelas_mahasiswa km
        INNER JOIN kelas_matakuliah kmk ON km.klsmhsKlsId = kmk.klsmkKlsId
        WHERE kmk.klsmkMkId = $mkId
        AND km.klsmhsIsAktif = 1
    ");
    $totalMahasiswa = 0;
    if ($queryTotalMhs && $row = $queryTotalMhs->fetch_assoc()) {
        $totalMahasiswa = $row['total'];
    }
    
    // Tampilkan view
    require "views/detailMatkul/index.php";
}

?>