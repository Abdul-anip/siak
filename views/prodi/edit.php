<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Program Studi</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=prodi&aksi=update">

    <input type="hidden" name="prodiId" value="<?= $data['prodiId'] ?>">

    <label>Jurusan</label>
    <select name="prodiJurId" class="input">
        <option value="0">-- Pilih Jurusan --</option>
        <?php
        /** @var mysqli_result $jurusan */
         while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"
                <?= $j['jurId'] == $data['prodiJurId'] ? 'selected' : '' ?>>
                <?= $j['jurNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Kode</label>
    <input class="input" name="prodiKode" value="<?= htmlspecialchars($data['prodiKode']) ?>">

    <label>Nama Prodi</label>
    <input class="input" name="prodiNama" required value="<?= htmlspecialchars($data['prodiNama']) ?>">

    <label>Jenjang</label>
    <input class="input" name="prodiJenjang" value="<?= htmlspecialchars($data['prodiJenjang']) ?>">

    <label>Email</label>
    <input class="input" name="prodiEmail" value="<?= htmlspecialchars($data['prodiEmail']) ?>">

    <label>Website</label>
    <input class="input" name="prodiWebsite" value="<?= htmlspecialchars($data['prodiWebsite']) ?>">

    <label>
        <input type="checkbox" name="prodiIsAktif" <?= $data['prodiIsAktif'] ? 'checked' : '' ?>> Aktif
    </label><br><br>

    <button class="btn" type="submit" name="update_prodi">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=prodi">Batal</a>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
