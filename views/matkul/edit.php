<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Matakuliah</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=matkul&aksi=update">

    <input type="hidden" name="mkId" value="<?= $data['mkId'] ?>">

    <label>Kurikulum</label>
    <select name="mkKurId" class="input">
        <option value="0">-- Pilih Kurikulum --</option>
        <?php while($k = $listKur->fetch_assoc()): ?>
            <option value="<?= $k['kurId'] ?>"
                <?= $k['kurId']==$data['mkKurId'] ? 'selected' : '' ?>>
                <?= $k['kurNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Kode</label>
    <input class="input" name="mkKode" value="<?= htmlspecialchars($data['mkKode']) ?>">

    <label>Nama</label>
    <input class="input" name="mkNama" value="<?= htmlspecialchars($data['mkNama']) ?>">

    <label>Semester</label>
    <input class="input" type="number" name="mkSemester" value="<?= $data['mkSemester'] ?>">

    <label>SKS</label>
    <input class="input" type="number" name="mkSks" value="<?= $data['mkSks'] ?>">

    <label>
        <input type="checkbox" name="mkIsAktif" <?= $data['mkIsAktif'] ? 'checked' : '' ?>> Aktif
    </label><br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="update_matkul" type="submit">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=matkul">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
