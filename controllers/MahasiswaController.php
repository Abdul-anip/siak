<?php

require "models/Mahasiswa.php";
require "models/Jurusan.php";
require "models/Prodi.php";

$mhs = new Mahasiswa($koneksi);
$jur = new Jurusan($koneksi);
$prodi = new Prodi($koneksi);

$aksi = $_GET['aksi'] ?? "index";

// LIST
if ($aksi == "index") {
    
    $q = $_GET['q'] ?? '';

        if ($q) {
            $rows = $mhs->search($q);
        } else {
            $rows = $mhs->all();
        }

    require "views/mahasiswa/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $jurusan = $jur->all();
    $listProdi = $prodi->all();
    require "views/mahasiswa/create.php";
}

// SIMPAN DATA
else if ($aksi == "save" && isset($_POST['save_mahasiswa'])) {
    $result = $mhs->store($_POST);

    if (!$result['status']) {
        $error = $result['error'];
        $jurusan = $jur->all();
        $listProdi = $prodi->all();
        $old = $_POST;

        require "views/mahasiswa/create.php";
        exit;
    }

    /* =========================================================
       PERBAIKAN: Daftarkan Mahasiswa ke Kelas
       ========================================================= */

    $mhsNim = $koneksi->real_escape_string($_POST['mhsNim']);
    $klsId = isset($_POST['klsId']) ? intval($_POST['klsId']) : 0;

    // Hanya lanjutkan jika klsId valid (bukan 0 atau kosong)
    if ($klsId > 0) {
        
        // Cek apakah mahasiswa sudah terdaftar di kelas ini
        $cekExist = $koneksi->query("
            SELECT klsmhsId FROM kelas_mahasiswa 
            WHERE klsmhsKlsId = $klsId AND klsmhsMhsNim = '$mhsNim'
        ");
        
        // Jika belum terdaftar, baru insert
        if ($cekExist->num_rows == 0) {
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_mahasiswa (klsmhsKlsId, klsmhsMhsNim, klsmhsIsAktif)
                VALUES (?, ?, 1)
            ");
            
            if ($stmtEnroll) {
                $stmtEnroll->bind_param("is", $klsId, $mhsNim);
                
                if (!$stmtEnroll->execute()) {
                    error_log("Insert kelas_mahasiswa gagal: " . $stmtEnroll->error);
                }
                
                $stmtEnroll->close();
            } else {
                error_log("Prepare statement kelas_mahasiswa gagal: " . $koneksi->error);
            }
        }
    }

    header("Location: index.php?page=mahasiswa");
    exit;   
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $mhs->get($_GET['id']);
    $jurusan = $jur->all();
    $listProdi = $prodi->all();
    require "views/mahasiswa/edit.php";
}

// SIMPAN EDIT
else if ($aksi == "update" && isset($_POST['update_mahasiswa'])) {
    $mhs->update($_POST['mhsNim'], $_POST);
    header("Location: index.php?page=mahasiswa");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $mhs->delete($_GET['id']);
    header("Location: index.php?page=mahasiswa");
}

?>