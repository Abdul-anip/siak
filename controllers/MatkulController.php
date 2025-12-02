<?php

require "models/Matkul.php";
require "models/Kurikulum.php";

$matkul = new Matkul($koneksi);
$kur = new Kurikulum($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    $rows = $matkul->all();
    require "views/matkul/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $listKur = $kur->all();
    require "views/matkul/create.php";
}

else if ($aksi == "save" && isset($_POST['save_matkul'])) {

    $result = $matkul->store($_POST);

    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {

        $error = $result['error'];   
        $listKur = $kur->all();      // kirim ulang data kurikulum
        $old = $_POST;               // simpan data yg sudah diinput user

        require "views/matkul/create.php";
        exit;
    }

    // Jika sukses → redirect
    header("Location: index.php?page=matkul");
    exit;
}


// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $matkul->get($_GET['id']);
    $listKur = $kur->all();
    require "views/matkul/edit.php";
}

// SIMPAN EDIT
else if ($aksi == "update" && isset($_POST['update_matkul'])) {
    $matkul->update($_POST['mkId'], $_POST);
    header("Location: index.php?page=matkul");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $matkul->delete($_GET['id']);
    header("Location: index.php?page=matkul");
}
?>
