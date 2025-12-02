<?php

require "models/Jurusan.php";
$jurusan = new Jurusan($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// --- LIST DATA ---
if ($aksi == "index") {
    $rows = $jurusan->all();
    require "views/jurusan/index.php";
}

// --- FORM TAMBAH ---
else if ($aksi == "tambah") {
    require "views/jurusan/create.php";
}

// --- SIMPAN TAMBAH ---
else if ($aksi == "save" && isset($_POST['save_jurusan'])) {
    $jurusan->store($_POST);
    header("Location: index.php?page=jurusan");
}

// --- FORM EDIT ---
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $jurusan->get($_GET['id']);
    require "views/jurusan/edit.php";
}

// --- SIMPAN EDIT ---
else if ($aksi == "update" && isset($_POST['update_jurusan'])) {
    $jurusan->update($_POST['jurId'], $_POST);
    header("Location: index.php?page=jurusan");
}

// --- HAPUS ---
else if ($aksi == "delete" && isset($_GET['id'])) {
    $jurusan->delete($_GET['id']);
    header("Location: index.php?page=jurusan");
}
?>
