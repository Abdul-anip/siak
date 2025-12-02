<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Jurusan</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=jurusan&aksi=save">

    <label>Kode</label>
    <input class="input" name="jurKode">

    <label>Nama Jurusan</label>
    <input class="input" name="jurNama" required>

    <label>Nama Asing</label>
    <input class="input" name="jurNamaAsing">

    <label>
        <input type="checkbox" name="jurIsAktif" checked> Aktif
    </label><br><br>

    <button class="btn" type="submit" name="save_jurusan">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=jurusan">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
