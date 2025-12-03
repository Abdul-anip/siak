<?php
// views/beranda.php
// Simple home page — gunakan layout header/sidebar/footer yg sudah ada
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<div class="card-content">
    <h2>Prakuliah</h2>
    <p>Selamat datang, <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Tamu' ?>.</p>

    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:20px">
        <div class="menu-box" onclick="location.href='index.php?page=daftarKelas'">
            <img src="assets/img/kelas.png" style="width:60px">
            <div class="menu-title">Daftar Kelas</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/matakuliah.png" style="width:60px">
            <div class="menu-title">Daftar Mata Kuliah</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/dosen.png" style="width:60px">
            <div class="menu-title">Dosen Kelas</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/mahasiswa.png" style="width:60px">
            <div class="menu-title">Mahasiswa Kelas</div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
