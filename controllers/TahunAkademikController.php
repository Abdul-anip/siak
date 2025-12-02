<?php

require "models/TahunAkademik.php";

$ta = new TahunAkademik($koneksi);
$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    $rows = $ta->all();
    require "views/tahun_akademik/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    require "views/tahun_akademik/create.php";
}

// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_ta'])) {
    $ta->store($_POST);
    header("Location: index.php?page=tahun_akademik");
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $ta->get($_GET['id']);
    require "views/tahun_akademik/edit.php";
}

// SIMPAN UPDATE
else if ($aksi == "update" && isset($_POST['update_ta'])) {
    $ta->update($_POST['taId'], $_POST);
    header("Location: index.php?page=tahun_akademik");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $ta->delete($_GET['id']);
    header("Location: index.php?page=tahun_akademik");
}

?>
