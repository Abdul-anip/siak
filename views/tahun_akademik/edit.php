<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Tahun Akademik</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=tahun_akademik&aksi=update">

    <input type="hidden" name="taId" value="<?= $data['taId'] ?>">

    <label>Kode Tahun Akademik</label>
    <input class="input" name="taKode" value="<?= htmlspecialchars($data['taKode']) ?>" required>

    <label>Semester</label>
    <select class="input" name="taSemester">
        <option value="Ganjil" <?= $data['taSemester']=='Ganjil'?'selected':'' ?>>Ganjil</option>
        <option value="Genap" <?= $data['taSemester']=='Genap'?'selected':'' ?>>Genap</option>
    </select>

    <label>
        <input type="checkbox" name="taIsAktif" <?= $data['taIsAktif'] ? 'checked':'' ?>> Aktif
    </label>

    <br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="update_ta">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=tahun_akademik">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
