<?php
// views/beranda.php
// Simple home page — gunakan layout header/sidebar/footer yg sudah ada
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<div class="card-content">
    <h2>Beranda SIAKAD</h2>
    <p>Selamat datang, <?= isset($_SESSION['user']) ? htmlspecialchars($_SESSION['user']) : 'Tamu' ?>.</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:20px">
        <div class="menu-box" onclick="location.href='index.php?page=contentMahasiswa'">
            <img src="assets/img/folder-mhs.png" style="width:60px">
            <div class="menu-title">Mahasiswa</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="assets/img/prakuliah.png" style="width:60px">
            <div class="menu-title">Pra Kuliah</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=perkuliahan'">
            <img src="assets/img/perkuliahan.png" style="width:60px">
            <div class="menu-title">Perkuliahan</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=pascakuliah'">
            <img src="assets/img/pascakuliah.png" style="width:60px">
            <div class="menu-title">Pasca Kuliah</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=pascakuliah'">
            <img src="assets/img/data_master.png" style="width:60px">
            <div class="menu-title">Data Master</div>
        </div>
        <div class="menu-box" onclick="location.href='index.php?page=pascakuliah'">
            <img src="assets/img/user.png" style="width:60px">
            <div class="menu-title">User</div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>
