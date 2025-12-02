<?php
$koneksi = new mysqli("localhost", "root", "", "db_siak");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$koneksi->set_charset("utf8");
