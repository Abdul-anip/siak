<?php
/**
 * Controller: PasswordController
 * Menangani perubahan password user
 */

require "models/User.php";
$userModel = new User($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// Pastikan user sudah login
if (!isset($_SESSION['userid'])) {
    header("Location: index.php?page=login");
    exit;
}

/* ============================================================
   TAMPILKAN FORM UBAH PASSWORD
   ============================================================ */
if ($aksi == "index") {
    require "views/user/change_password.php";
}

/* ============================================================
   PROSES UBAH PASSWORD
   ============================================================ */
else if ($aksi == "update" && isset($_POST['change_password'])) {
    
    $userid = $_SESSION['userid'];
    $oldPassword = $_POST['old_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    // Validasi input kosong
    if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
        $error = "Semua field harus diisi!";
        require "views/user/change_password.php";
        exit;
    }
    
    // Validasi panjang password baru
    if (strlen($newPassword) < 4) {
        $error = "Password baru minimal 4 karakter!";
        require "views/user/change_password.php";
        exit;
    }
    
    // Validasi konfirmasi password
    if ($newPassword !== $confirmPassword) {
        $error = "Password baru dan konfirmasi password tidak cocok!";
        require "views/user/change_password.php";
        exit;
    }
    
    // Validasi password lama
    $result = $userModel->verifyPassword($userid, $oldPassword);
    
    if (!$result['status']) {
        $error = $result['error'];
        require "views/user/change_password.php";
        exit;
    }
    
    // Update password
    $updateResult = $userModel->updatePassword($userid, $newPassword);
    
    if ($updateResult['status']) {
        $success = "Password berhasil diubah! Silakan login kembali.";
        
        // Optional: Logout otomatis setelah ubah password
        // session_destroy();
        // header("Location: index.php?page=login");
        // exit;
    } else {
        $error = $updateResult['error'];
    }
    
    require "views/user/change_password.php";
}

?>