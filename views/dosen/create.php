<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Dosen</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=dosen&aksi=save">

    <label>NIDN</label>
    <input class="input" name="dsnNidn" required>

    <label>Nama Lengkap</label>
    <input class="input" name="dsnNama" required>

    <label>Jenis Kelamin</label>
    <select class="input" name="dsnJenisKelaminKode">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Jurusan</label>
    <select name="dsnJurId" class="input">
        <option value="0">-- Pilih Jurusan --</option>
        <?php 
        /** @var mysqli_result $jur */
        while($j = $jur->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"><?= $j['jurNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select name="dsnProdiId" class="input" required>
        <option value="0">-- Pilih Prodi --</option>
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"><?= $p['prodiNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <button class="btn" name="save_dosen" type="submit">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=dosen">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
