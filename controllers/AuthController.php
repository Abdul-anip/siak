<?php
require "models/User.php";
$userModel = new User($koneksi);

$aksi = $_GET['aksi'] ?? 'login';

// LOGOUT
if ($aksi == "logout") {
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}

// PROCESS LOGIN
if ($aksi == "login_process" && isset($_POST['login'])) {

    $u = $_POST['username'];
    $p = $_POST['password'];

    $user = $userModel->login($u, $p);

    if ($user) {
        $_SESSION['login'] = true;
        $_SESSION['user']  = $user['appusrNama'];
        $_SESSION['userid'] = $user['appusrID'];
        $_SESSION['grup']  = $user['appusrGrupUser'];

        header("Location: index.php?page=beranda");
        exit;

    } else {
        $error = "Username / password salah atau akun tidak aktif.";
    }
}

// PROCESS REGISTER
if ($aksi == "register_process" && isset($_POST['register'])) {

    $u = $_POST['username'];
    $p = $_POST['password'];

    if ($userModel->register($u, $p)) {
        $success = "Registrasi berhasil! Silakan login.";
    } else {
        $error = "Registrasi gagal.";
    }
}

// SHOW VIEWS
if ($aksi == "register") {
    require "views/auth/register.php";
} else {
    require "views/auth/login.php";
}
?>
