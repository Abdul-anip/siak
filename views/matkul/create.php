<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Matakuliah</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div style="padding:10px;background:#fdd;border:1px solid #f99;margin-bottom:10px;">
    <?= $error ?>
</div>
<?php endif; ?>


<form method="post" action="index.php?page=matkul&aksi=save">

    <label>Kurikulum</label>
    <select name="mkKurId" class="input">
        <option value="0">-- Pilih Kurikulum --</option>
        <?php while($k = $listKur->fetch_assoc()): ?>
            <option value="<?= $k['kurId'] ?>"
                <?= isset($old['mkKurId']) && $old['mkKurId'] == $k['kurId'] ? 'selected' : '' ?>>
                <?= $k['kurNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Kode</label>
    <input class="input" name="mkKode" 
       value="<?= $old['mkKode'] ?? '' ?>" required>

    <label>Nama</label>
    <input class="input" name="mkNama" 
       value="<?= $old['mkNama'] ?? '' ?>" required>

    <label>Semester</label>
    <input class="input" type="number" min="1" name="mkSemester"
       value="<?= $old['mkSemester'] ?? '' ?>" required>

    <label>SKS</label>
    <input class="input" type="number" min="0" name="mkSks"
       value="<?= $old['mkSks'] ?? '' ?>" required>

    <label>
        <input type="checkbox" name="mkIsAktif"
            <?= isset($old['mkIsAktif']) ? 'checked' : '' ?>>
        Aktif
    </label><br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" type="submit" name="save_matkul">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=matkul">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
