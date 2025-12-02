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
    $dosen->store($_POST);
    header("Location: index.php?page=dosen");
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $dosen->get($_GET['id']);
    $jurusan = $jur->all();
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
