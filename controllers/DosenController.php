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
        $jurusan   = $jur->all();        
        $listProdi = $prodi->all();      
        $old       = $_POST;             

        require "views/dosen/create.php";
        exit;
    }

    /* =========================================================
       PERBAIKAN CRITICAL: Daftarkan Dosen ke Kelas dengan Matakuliah
       ========================================================= */

    $dsnNidn = $koneksi->real_escape_string($_POST['dsnNidn']);
    $klsId = isset($_POST['klsId']) ? intval($_POST['klsId']) : 0;

    // Hanya lanjutkan jika klsId valid (bukan 0)
    if ($klsId > 0) {
        
        // Ambil SEMUA matakuliah di kelas ini
        $mkKelas = $koneksi->query("
            SELECT klsmkMkId FROM kelas_matakuliah 
            WHERE klsmkKlsId = " . $klsId
        );
        
        // Jika ada matakuliah di kelas
        if ($mkKelas && $mkKelas->num_rows > 0) {
            
            // Siapkan prepared statement untuk insert ke kelas_dosen
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_dosen (klsdsnKlsId, klsdsnDsnNidn, klsdsnMkId, klsdsnIsAktif)
                VALUES (?, ?, ?, 1)
            ");
            
            if (!$stmtEnroll) {
                // Jika prepare gagal, log error
                error_log("Prepare statement gagal: " . $koneksi->error);
            } else {
                // Loop untuk setiap matakuliah di kelas
                while ($mk = $mkKelas->fetch_assoc()) {
                    $mkId = intval($mk['klsmkMkId']);
                    
                    // Bind parameter dan execute
                    $stmtEnroll->bind_param("isi", $klsId, $dsnNidn, $mkId);
                    
                    if (!$stmtEnroll->execute()) {
                        // Log jika insert gagal
                        error_log("Insert kelas_dosen gagal untuk mkId=$mkId: " . $stmtEnroll->error);
                    }
                }
                
                $stmtEnroll->close();
            }
            
        } else {
            // Tidak ada matakuliah di kelas (opsional: tampilkan warning)
            // $_SESSION['warning'] = "Kelas belum memiliki matakuliah yang terdaftar.";
        }
    }

    // Redirect ke halaman daftar dosen
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