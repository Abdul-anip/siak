<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Jurusan</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div style="padding:10px;background:#fdd;border:1px solid #f99;margin-bottom:10px;border-radius:6px;">
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=jurusan&aksi=save">

    <label>Kode</label>
    <input class="input" name="jurKode" value="<?= $old['jurKode'] ?? '' ?>" required>

    <label>Nama Jurusan</label>
    <input class="input" name="jurNama" value="<?= $old['jurNama'] ?? '' ?>" required>

    <label>Nama Asing</label>
    <input class="input" name="jurNamaAsing" value="<?= $old['jurNamaAsing'] ?? '' ?>">

    <label>
        <input type="checkbox" name="jurIsAktif" <?= isset($old['jurIsAktif']) ? 'checked' : 'checked' ?>> Aktif
    </label><br><br>

    <button class="btn" type="submit" name="save_jurusan">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=jurusan">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>