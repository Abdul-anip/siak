<?php

require "models/Dosen.php";
require "models/Jurusan.php";
require "models/Prodi.php";

$dosen = new Dosen($koneksi);
$jur = new Jurusan($koneksi);
$prodi = new Prodi($koneksi);

$aksi = $_GET['aksi'] ?? "index";


// LIST
if ($aksi == "index") {

    $rows = $dosen->all();
    require "views/dosen/index.php";
}


// FORM TAMBAH
else if ($aksi == "tambah") {

    $jurusan = $jur->all();
    $listProdi = $prodi->all();

    require "views/dosen/create.php";
}


// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_dosen'])) {

    $result = $dosen->store($_POST);

    // Jika ERROR → tampilkan form create
    if (!$result['status']) {

        $error     = $result['error'];   
        $jurusan   = $jur->all();        // HARUS ADA!
        $listProdi = $prodi->all();      // Prodi
        $old       = $_POST;             // Data sebelumnya

        require "views/dosen/create.php";
        exit;
    }

    /* =========================================================
       LANGKAH BARU: OTOMATIS DAFTARKAN DOSEN KE KELAS (Asumsi)
       ========================================================= */

    $dsnNidn = $_POST['dsnNidn'];
    $klsId = $_POST['klsId'] ?? 0; // Dapatkan klsId dari form

    // Hanya lanjutkan jika klsId valid
    if ($klsId > 0) {
        
        // 1. CARI ID MATAKULIAH PERTAMA di Kelas ini (Karena tidak ada input MK di form)
        // Dosen harus ditugaskan ke sebuah MK agar record di kelas_dosen valid.
        $mkKelas = $koneksi->query("
            SELECT klsmkMkId FROM kelas_matakuliah 
            WHERE klsmkKlsId = " . intval($klsId) . " 
            LIMIT 1
        ")->fetch_assoc();
        
        $mkId = $mkKelas['klsmkMkId'] ?? 0;
        
        // 2. Jika ID Mata Kuliah ditemukan, lakukan penugasan Dosen
        if ($mkId > 0) {
            
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_dosen (klsdsnKlsId, klsdsnDsnNidn, klsdsnMkId, klsdsnIsAktif)
                VALUES (?, ?, ?, 1)
            ");
            
            // klsId (i), dsnNidn (s), mkId (i)
            $stmtEnroll->bind_param("isi", $klsId, $dsnNidn, $mkId);
            $stmtEnroll->execute();
            $stmtEnroll->close();
        }
        
    }

    header("Location: index.php?page=dosen");
    exit;
}


// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {

    $data = $dosen->get($_GET['id']);
    $jurusan   = $jur->all();
    $listProdi = $prodi->all();

    require "views/dosen/edit.php";
}


// SIMPAN UPDATE
else if ($aksi == "update" && isset($_POST['update_dosen'])) {

    $dosen->update($_POST['dsnNidn'], $_POST);

    header("Location: index.php?page=dosen");
}


// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {

    $dosen->delete($_GET['id']);

    header("Location: index.php?page=dosen");
}

?>
