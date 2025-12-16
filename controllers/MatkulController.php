<?php

require "models/Matkul.php";
require "models/Kurikulum.php";

$matkul = new Matkul($koneksi);
$kur = new Kurikulum($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    
    $q = $_GET['q'] ?? '';

        if ($q) {
            $rows = $matkul->search($q);
        } else {
            $rows = $matkul->all();
        }

    require "views/matkul/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $listKur = $kur->all();
    
    // ✅ TAMBAHAN: Ambil daftar kelas aktif
    $listKelas = $koneksi->query("
        SELECT k.klsId, k.klsNama, 
               CONCAT(t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                   CASE t.thakdSemester 
                       WHEN '1' THEN 'Ganjil' 
                       WHEN '2' THEN 'Genap' 
                   END, ' | ', p.prodiNama, ' | ', k.klsNama
               ) AS kelasLabel
        FROM kelas k
        JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE t.thakdIsAktif = 1
        ORDER BY p.prodiNama, k.klsNama
    ");
    
    require "views/matkul/create.php";
}

else if ($aksi == "save" && isset($_POST['save_matkul'])) {

    $result = $matkul->store($_POST);

    if (!$result['status']) {
        $error = $result['error'];   
        $listKur = $kur->all();
        
        // ✅ Kirim ulang list kelas jika error
        $listKelas = $koneksi->query("
            SELECT k.klsId, k.klsNama, 
                   CONCAT(t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                       CASE t.thakdSemester 
                           WHEN '1' THEN 'Ganjil' 
                           WHEN '2' THEN 'Genap' 
                       END, ' | ', p.prodiNama, ' | ', k.klsNama
                   ) AS kelasLabel
            FROM kelas k
            JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
            JOIN program_studi p ON k.klsProdiId = p.prodiId
            WHERE t.thakdIsAktif = 1
            ORDER BY p.prodiNama, k.klsNama
        ");
        
        $old = $_POST;
        require "views/matkul/create.php";
        exit;
    }

    // ✅ DAFTARKAN MATAKULIAH KE KELAS (seperti logika Dosen/Mahasiswa)
    $mkId = $koneksi->insert_id; // Ambil ID matakuliah yang baru dibuat
    $klsId = isset($_POST['klsId']) ? intval($_POST['klsId']) : 0;

    if ($klsId > 0) {
        // Cek apakah sudah terdaftar
        $cekExist = $koneksi->query("
            SELECT klsmkId FROM kelas_matakuliah 
            WHERE klsmkKlsId = $klsId AND klsmkMkId = $mkId
        ");
        
        if ($cekExist->num_rows == 0) {
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_matakuliah (klsmkKlsId, klsmkMkId)
                VALUES (?, ?)
            ");
            
            if ($stmtEnroll) {
                $stmtEnroll->bind_param("ii", $klsId, $mkId);
                
                if (!$stmtEnroll->execute()) {
                    error_log("Insert kelas_matakuliah gagal: " . $stmtEnroll->error);
                } else {
                    error_log("SUCCESS: Matakuliah $mkId berhasil didaftarkan ke kelas $klsId");
                }
                
                $stmtEnroll->close();
            } else {
                error_log("Prepare statement kelas_matakuliah gagal: " . $koneksi->error);
            }
        }
    }

    header("Location: index.php?page=matkul");
    exit;
}


// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $matkul->get($_GET['id']);
    $listKur = $kur->all();
    require "views/matkul/edit.php";
}

// SIMPAN EDIT
else if ($aksi == "update" && isset($_POST['update_matkul'])) {
    $matkul->update($_POST['mkId'], $_POST);
    header("Location: index.php?page=matkul");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    try {
        $matkul->delete($_GET['id']);
        header("Location: index.php?page=matkul&success=delete");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();

        // Ambil ulang data untuk ditampilkan
        $q = $_GET['q'] ?? '';
        if ($q) {
            $rows = $matkul->search($q);
        } else {
            $rows = $matkul->all();
        }

        require "views/matkul/index.php";
        exit;
}
}
?>