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
    $search = $_GET['search'] ?? "";
    $rows = $mhs->all($search);
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

    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {
        $error = $result['error'];
        $jurusan = $jur->all();
        $listProdi = $prodi->all();
        $old = $_POST;

        require "views/mahasiswa/create.php";
        exit;
    }

//DAFTARKAN MAHASISWA BARU KE KELAS
    $mhsNim    = $_POST['mhsNim'];
    $prodiId   = $_POST['mhsProdiId'];
    $kodeKelas = $_POST['mhsKodeKelas'];

    $taAktif = $koneksi->query("SELECT thakdId FROM tahun_akademik WHERE thakdIsAktif = 1 LIMIT 1")->fetch_assoc();
    $thakdId = $taAktif['thakdId'] ?? 0;
    
    if ($thakdId > 0) {
        
        $kelasNamaPattern = "%." . $kodeKelas; 
        
        $stmtKelas = $koneksi->prepare("
            SELECT klsId FROM kelas
            WHERE klsThakdId = ? AND klsProdiId = ? AND klsNama LIKE ? 
            LIMIT 1
        ");

        $stmtKelas->bind_param("iis", $thakdId, $prodiId, $kelasNamaPattern);
        $stmtKelas->execute();
        $resKelas = $stmtKelas->get_result();
        $dataKelas = $resKelas->fetch_assoc();
        $stmtKelas->close();

        if ($dataKelas) {
            $klsId = $dataKelas['klsId'];
            
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_mahasiswa (klsmhsKlsId, klsmhsMhsNim, klsmhsIsAktif)
                VALUES (?, ?, 1)
            ");
            $stmtEnroll->bind_param("is", $klsId, $mhsNim);
            $stmtEnroll->execute();
            $stmtEnroll->close();
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
