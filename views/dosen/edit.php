<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Edit Dosen</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=dosen&aksi=update">

    <input type="hidden" name="dsnNidn" value="<?= $data['dsnNidn'] ?>">

    <label>NIDN</label>
    <input class="input" value="<?= $data['dsnNidn'] ?>" disabled style="background:#eee">
    <small>NIDN tidak dapat diubah</small>

    <label>Gelar Depan</label>
    <input class="input" name="dsnGelarDepan" 
        value="<?= htmlspecialchars($data['dsnGelarDepan'] ?? '') ?>"
        placeholder="Contoh: Dr., Ir., Prof.">

    <label>Nama Lengkap</label>
    <input class="input" name="dsnNama" value="<?= htmlspecialchars($data['dsnNama']) ?>" required>

    <label>Gelar Belakang</label>
    <input class="input" name="dsnGelarBelakang" 
        value="<?= htmlspecialchars($data['dsnGelarBelakang'] ?? '') ?>"
        placeholder="Contoh: S.T., M.T., Ph.D">

    <label>Jenis Kelamin</label>
    <select class="input" name="dsnJenisKelaminKode">
        <option value="L" <?= $data['dsnJenisKelaminKode']=='L'?'selected':'' ?>>Laki-laki</option>
        <option value="P" <?= $data['dsnJenisKelaminKode']=='P'?'selected':'' ?>>Perempuan</option>
    </select>

    <label>Jurusan</label>
    <select name="dsnJurId" class="input">
        <?php
         /** @var mysqli_result $jurusan */
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"
                <?= $j['jurId']==$data['dsnJurId']?'selected':'' ?>>
                <?= $j['jurNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select name="dsnProdiId" class="input">
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"
                <?= $p['prodiId']==$data['dsnProdiId']?'selected':'' ?>>
                <?= $p['prodiNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <button class="btn" name="update_dosen" type="submit">💾 Update</button>
        <a class="btn" style="background:#777" href="index.php?page=dosen">❌ Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>