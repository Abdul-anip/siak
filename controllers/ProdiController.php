<?php

require "models/Prodi.php";
require "models/Jurusan.php";

$prodi = new Prodi($koneksi);
$jur = new Jurusan($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    $rows = $prodi->all();
    require "views/prodi/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $jurusan = $jur->all();
    require "views/prodi/create.php";
}

// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_prodi'])) {
    $result = $prodi->store($_POST);

    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {
        $error = $result['error'];
        $jurusan = $jur->all();
        $old = $_POST;

        require "views/prodi/create.php";
        exit;
    }

    // Jika sukses → redirect
    header("Location: index.php?page=prodi");
    exit;
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $prodi->get($_GET['id']);
    $jurusan = $jur->all();
    require "views/prodi/edit.php";
}

// SIMPAN UPDATE
else if ($aksi == "update" && isset($_POST['update_prodi'])) {
    $prodi->update($_POST['prodiId'], $_POST);
    header("Location: index.php?page=prodi");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $prodi->delete($_GET['id']);
    header("Location: index.php?page=prodi");
}
?>