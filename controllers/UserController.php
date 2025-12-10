<?php
/**
 * Controller: UserController
 * Menangani CRUD User Management
 */

require "models/User.php";
$userModel = new User($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

/* ============================================================
   LIST USERS
   ============================================================ */
if ($aksi == "index") {
    $search = $_GET['search'] ?? '';
    $rows = $userModel->all($search);
    require "views/user/index.php";
}

/* ============================================================
   FORM TAMBAH USER
   ============================================================ */
else if ($aksi == "tambah") {
    require "views/user/create.php";
}

/* ============================================================
   SIMPAN USER BARU
   ============================================================ */
else if ($aksi == "save" && isset($_POST['save_user'])) {
    
    $result = $userModel->store($_POST);
    
    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {
        $error = $result['error'];
        $old = $_POST;
        require "views/user/create.php";
        exit;
    }
    
    // Jika sukses → redirect ke list
    $_SESSION['success_message'] = "User berhasil ditambahkan!";
    header("Location: index.php?page=user");
    exit;
}

/* ============================================================
   FORM EDIT USER
   ============================================================ */
else if ($aksi == "edit" && isset($_GET['id'])) {
    
    $data = $userModel->get($_GET['id']);
    
    if (!$data) {
        $error = "User tidak ditemukan!";
        $rows = $userModel->all();
        require "views/user/index.php";
        exit;
    }
    
    require "views/user/edit.php";
}

/* ============================================================
   UPDATE USER
   ============================================================ */
else if ($aksi == "update" && isset($_POST['update_user'])) {
    
    $result = $userModel->update($_POST['appusrID'], $_POST);
    
    if (!$result['status']) {
        $error = $result['error'];
        $data = $userModel->get($_POST['appusrID']);
        require "views/user/edit.php";
        exit;
    }
    
    $_SESSION['success_message'] = "User berhasil diperbarui!";
    header("Location: index.php?page=user");
    exit;
}

/* ============================================================
   RESET PASSWORD USER
   ============================================================ */
else if ($aksi == "reset_password" && isset($_GET['id'])) {
    
    $userid = $_GET['id'];
    $defaultPassword = "123"; // Password default
    
    $result = $userModel->updatePassword($userid, $defaultPassword);
    
    if ($result['status']) {
        $_SESSION['success_message'] = "Password user berhasil direset ke '123'";
    } else {
        $_SESSION['error_message'] = "Gagal mereset password: " . $result['error'];
    }
    
    header("Location: index.php?page=user");
    exit;
}

/* ============================================================
   TOGGLE STATUS USER (AKTIF/NON-AKTIF)
   ============================================================ */
else if ($aksi == "toggle_status" && isset($_GET['id'])) {
    
    $userid = $_GET['id'];
    
    // Jangan izinkan disable user sendiri
    if ($userid == $_SESSION['userid']) {
        $_SESSION['error_message'] = "Anda tidak dapat menonaktifkan akun Anda sendiri!";
        header("Location: index.php?page=user");
        exit;
    }
    
    $result = $userModel->toggleStatus($userid);
    
    if ($result['status']) {
        $_SESSION['success_message'] = "Status user berhasil diubah!";
    } else {
        $_SESSION['error_message'] = "Gagal mengubah status user!";
    }
    
    header("Location: index.php?page=user");
    exit;
}

/* ============================================================
   DELETE USER
   ============================================================ */
else if ($aksi == "delete" && isset($_GET['id'])) {
    
    $userid = $_GET['id'];
    
    // Jangan izinkan hapus user sendiri
    if ($userid == $_SESSION['userid']) {
        $_SESSION['error_message'] = "Anda tidak dapat menghapus akun Anda sendiri!";
        header("Location: index.php?page=user");
        exit;
    }
    
    $userModel->delete($userid);
    
    $_SESSION['success_message'] = "User berhasil dihapus!";
    header("Location: index.php?page=user");
    exit;
}

?>