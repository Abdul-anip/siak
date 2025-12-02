<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Tahun Akademik</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=tahun_akademik&aksi=save">

    <label>Kode Tahun Akademik (contoh: 20241)</label>
    <input class="input" name="taKode" required>

    <label>Semester</label>
    <select class="input" name="taSemester" required>
        <option value="Ganjil">Ganjil</option>
        <option value="Genap">Genap</option>
    </select>

    <label>
        <input type="checkbox" name="taIsAktif"> Aktif
    </label>

    <br><br>
    
    <button class="btn" name="save_ta">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=tahun_akademik">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
