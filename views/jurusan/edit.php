<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Jurusan</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=jurusan&aksi=update">

    <input type="hidden" name="jurId" value="<?= $data['jurId'] ?>">

    <label>Kode</label>
    <input class="input" name="jurKode" value="<?= htmlspecialchars($data['jurKode']) ?>">

    <label>Nama Jurusan</label>
    <input class="input" name="jurNama" required value="<?= htmlspecialchars($data['jurNama']) ?>">

    <label>Nama Asing</label>
    <input class="input" name="jurNamaAsing" value="<?= htmlspecialchars($data['jurNamaAsing']) ?>">

    <label>
        <input type="checkbox" name="jurIsAktif" <?= $data['jurIsAktif'] ? 'checked' : '' ?>> Aktif
    </label><br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" type="submit" name="update_jurusan">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=jurusan">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
