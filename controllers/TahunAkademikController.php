<?php

require "models/TahunAkademik.php";

$ta = new TahunAkademik($koneksi);
$aksi = $_GET['aksi'] ?? 'index';

/* ============================================================
   LIST
   ============================================================ */
if ($aksi == "index") {

    $rows = $ta->all();
    require "views/tahun_akademik/index.php";
}


/* ============================================================
   FORM TAMBAH
   ============================================================ */
else if ($aksi == "tambah") {

    require "views/tahun_akademik/create.php";
}


/* ============================================================
   SIMPAN TAMBAH
   ============================================================ */
else if ($aksi == "save" && isset($_POST['save_ta'])) {

    $result = $ta->store($_POST);

    // Jika validasi GAGAL → tampilkan form create dengan error
    if (!$result['status']) {

        $error = $result['error'];
        $old   = $_POST;

        require "views/tahun_akademik/create.php";
        exit;
    }

    header("Location: index.php?page=tahun_akademik");
    exit;
}


/* ============================================================
   FORM EDIT
   ============================================================ */
else if ($aksi == "edit" && isset($_GET['id'])) {

    $data = $ta->get($_GET['id']);

    if (!$data) {
        $error = "Data Tahun Akademik tidak ditemukan!";
        require "views/tahun_akademik/index.php";
        exit;
    }

    require "views/tahun_akademik/edit.php";
}


/* ============================================================
   SIMPAN UPDATE
   ============================================================ */
else if ($aksi == "update" && isset($_POST['update_ta'])) {

    $result = $ta->update($_POST['taId'], $_POST);

    if (!$result['status']) {

        $error = $result['error'];
        $old   = $_POST;

        // ambil ulang data lama dari database jika perlu
        $data = $ta->get($_POST['taId']);

        require "views/tahun_akademik/edit.php";
        exit;
    }

    header("Location: index.php?page=tahun_akademik");
    exit;
}


/* ============================================================
   DELETE
   ============================================================ */
else if ($aksi == "delete" && isset($_GET['id'])) {

    $ta->delete($_GET['id']);

    header("Location: index.php?page=tahun_akademik");
    exit;
}

?>
