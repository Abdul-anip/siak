<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Kurikulum</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=kurikulum&aksi=update">

    <input type="hidden" name="kurId" value="<?= $data['kurId'] ?>">

    <label>Program Studi</label>
    <select name="kurProdiId" class="input">
        <option value="0">-- Pilih Prodi --</option>
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"
                <?= $p['prodiId'] == $data['kurProdiId'] ? 'selected' : '' ?>>
                <?= $p['prodiNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Tahun (YYYY)</label>
    <input class="input" name="kurTahun" value="<?= htmlspecialchars($data['kurTahun']) ?>" required>

    <label>Nama Kurikulum</label>
    <input class="input" name="kurNama" value="<?= htmlspecialchars($data['kurNama']) ?>" required>

    <label>
        <input type="checkbox" name="kurIsAktif" <?= $data['kurIsAktif'] ? 'checked' : '' ?>> Aktif
    </label><br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="update_kurikulum" type="submit">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=kurikulum">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
