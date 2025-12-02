<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Kurikulum</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=kurikulum&aksi=save">

    <label>Program Studi</label>
    <select name="kurProdiId" class="input">
        <option value="0">-- Pilih Prodi --</option>
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"><?= $p['prodiNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Tahun (YYYY)</label>
    <input class="input" name="kurTahun" required placeholder="2024">

    <label>Nama Kurikulum</label>
    <input class="input" name="kurNama" required>

    <label>
        <input type="checkbox" name="kurIsAktif" checked> Aktif
    </label><br><br>

    <button class="btn" type="submit" name="save_kurikulum">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=kurikulum">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
