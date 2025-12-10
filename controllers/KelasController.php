<?php

require "models/Kelas.php";
require "models/TahunAkademik.php";
require "models/Prodi.php";

$kelas = new Kelas($koneksi);
$tahunAkademik = new TahunAkademik($koneksi);
$prodi = new Prodi($koneksi);

$aksi = $_GET['aksi'] ?? "index";


/* ============================================================
   LIST DATA KELAS
   ============================================================ */
if ($aksi == "index") {

    $q = $_GET['q'] ?? '';

        if ($q) {
            $rows = $kelas->search($q);
        } else {
            $rows = $kelas->all();
        }

    require "views/kelas/index.php";
}


/* ============================================================
   FORM TAMBAH KELAS
   ============================================================ */
else if ($aksi == "tambah") {
    $listTahunAkademik = $tahunAkademik->all();
    $listProdi = $prodi->all();
    require "views/kelas/create.php";
}


/* ============================================================
   SIMPAN DATA KELAS BARU
   ============================================================ */
else if ($aksi == "save" && isset($_POST['save_kelas'])) {
    $result = $kelas->store($_POST);

    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {
        $error = $result['error'];
        $listTahunAkademik = $tahunAkademik->all();
        $listProdi = $prodi->all();
        $old = $_POST;

        require "views/kelas/create.php";
        exit;
    }

    // Jika sukses → redirect ke halaman list
    header("Location: index.php?page=kelas");
    exit;
}


/* ============================================================
   FORM EDIT KELAS
   ============================================================ */
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $kelas->get($_GET['id']);
    
    if (!$data) {
        $error = "Data kelas tidak ditemukan!";
        require "views/kelas/index.php";
        exit;
    }

    $listTahunAkademik = $tahunAkademik->all();
    $listProdi = $prodi->all();
    require "views/kelas/edit.php";
}


/* ============================================================
   SIMPAN UPDATE KELAS
   ============================================================ */
else if ($aksi == "update" && isset($_POST['update_kelas'])) {
    $kelas->update($_POST['klsId'], $_POST);
    header("Location: index.php?page=kelas");
    exit;
}


/* ============================================================
   DELETE KELAS
   ============================================================ */
else if ($aksi == "delete" && isset($_GET['id'])) {
    $kelas->delete($_GET['id']);
    header("Location: index.php?page=kelas");
    exit;
}

?>