<?php
// views/beranda.php
// Simple home page — gunakan layout header/sidebar/footer yg sudah ada
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<div class="card-content">
    <h2>Mahasiswa</h2>
    <p>Selamat datang, <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Tamu' ?>.</p>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:20px">
        <div class="menu-box" onclick="location.href='index.php?page=daftarKelas'">
            <img src="assets/img/users.png" style="width:60px">
            <div class="menu-title">Data Mahasiswa</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=daftarMatkulKelas'">
            <img src="assets/img/kuliah_mhs.png" style="width:60px">
            <div class="menu-title">Aktifitas Kuliah</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/output.png" style="width:60px">
            <div class="menu-title">Pembayaran UKT</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/tagihan.png" style="width:60px">
            <div class="menu-title">Tagihan Pembayaran</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/foto_ktm.png" style="width:60px">
            <div class="menu-title">File Foto KTM</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/foto_wisuda.png" style="width:60px">
            <div class="menu-title">File Foto Wisuda</div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
