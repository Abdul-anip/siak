<?php

require "models/Kurikulum.php";
require "models/Prodi.php";

$kurikulum = new Kurikulum($koneksi);
$prodi = new Prodi($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    $rows = $kurikulum->all();
    require "views/kurikulum/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $listProdi = $prodi->all();
    require "views/kurikulum/create.php";
}

// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_kurikulum'])) {
    $kurikulum->store($_POST);
    header("Location: index.php?page=kurikulum");
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $kurikulum->get($_GET['id']);
    $listProdi = $prodi->all();
    require "views/kurikulum/edit.php";
}

// SIMPAN EDIT
else if ($aksi == "update" && isset($_POST['update_kurikulum'])) {
    $kurikulum->update($_POST['kurId'], $_POST);
    header("Location: index.php?page=kurikulum");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $kurikulum->delete($_GET['id']);
    header("Location: index.php?page=kurikulum");
}

?>
