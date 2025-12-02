<aside class="sidebar">
    <div class="sidebar-title">SIAKAD</div>
    <div class="sidebar-user">
        Welcome,<br><strong><?= htmlspecialchars($_SESSION['user']) ?></strong>
    </div>

    <div class="menu-title">Menu Utama</div>
    <a href="index.php?page=beranda">🏠 Beranda</a>
    <a href="index.php?page=prakuliah">📌 Pra Kuliah</a>
    <a href="index.php?page=perkuliahan">📚 Perkuliahan</a>
    <a href="index.php?page=pascakuliah">🎓 Pasca Kuliah</a>

    <div class="menu-title">Data Master</div>
    <a href="index.php?page=jurusan">📁 Jurusan</a>
    <a href="index.php?page=prodi">📁 Program Studi</a>
    <a href="index.php?page=kurikulum">📁 Kurikulum</a>
    <a href="index.php?page=matkul">📁 Mata Kuliah</a>
    <a href="index.php?page=dosen">📁 Dosen</a>
    <a href="index.php?page=mahasiswa">📁 Mahasiswa</a>
    <a href="index.php?page=tahun_akademik">📅 Tahun Akademik</a>

    <div class="menu-title">User</div>
    <a href="index.php?page=password">🔑 Password</a>
    <a href="index.php?page=logout">🚪 Logout</a>
</aside>

<main class="content-wrapper">