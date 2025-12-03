<?php
session_start();

/* ---------------------------------------------------------
   LOAD KONEKSI DATABASE
--------------------------------------------------------- */
require "config/database.php";

/* ---------------------------------------------------------
   HELPER
--------------------------------------------------------- */
function h($s){
    return htmlspecialchars($s, ENT_QUOTES);
}

/* ---------------------------------------------------------
   ROUTING
--------------------------------------------------------- */
$page = $_GET['page'] ?? 'beranda';

/* ---------------------------------------------------------
   AUTH PAGES (public, tanpa login)
--------------------------------------------------------- */
$public_pages = ['login', 'register', 'logout'];

if (!isset($_SESSION['login']) && !in_array($page, $public_pages)) {
    header("Location: index.php?page=login");
    exit;
}

/* ---------------------------------------------------------
   HANDLE LOGOUT
--------------------------------------------------------- */
if ($page == "logout") {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

/* ---------------------------------------------------------
   LOAD CONTROLLER BERDASARKAN PAGE
--------------------------------------------------------- */
switch ($page) {

    /* ===================== AUTH ===================== */
    case "login":
    case "register":
        require "controllers/AuthController.php";
        break;

    /* ===================== DASHBOARD ===================== */
    case "beranda":
        require "views/beranda.php";
        break;

    /* ===================== PRA, PER, PASCA ===================== */
    case "prakuliah":
        require "views/prakuliah/index.php";
        break;


    case "perkuliahan":
        require "views/perkuliahan/index.php";
        break;

    case "pascakuliah":
        require "views/pascakuliah/index.php";
        break;

    case "daftarKelas":
        require "controllers/DaftarKelasController.php";
        break;

    case "kelas":
        require "controllers/KelasController.php";
        break;
    

    /* ===================== DATA MASTER ===================== */
    case "jurusan":
        require "controllers/JurusanController.php";
        break;

    case "prodi":
        require "controllers/ProdiController.php";
        break;

    case "kurikulum":
        require "controllers/KurikulumController.php";
        break;

    case "matkul":
        require "controllers/MatkulController.php";
        break;

    case "dosen":
        require "controllers/DosenController.php";
        break;

    case "mahasiswa":
        require "controllers/MahasiswaController.php";
        break;

    case "tahun_akademik":
        require "controllers/TahunAkademikController.php";
        break;

    /* ===================== USER ===================== */
    case "password":
        require "controllers/PasswordController.php";
        break;

    /* ===================== FALLBACK ===================== */
    default:
        require "views/404.php";
        break;
}

?>
