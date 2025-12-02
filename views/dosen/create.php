<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Dosen</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div class="message-box error"> 
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=dosen&aksi=save">

    <label>NIDN</label>
    <input class="input" name="dsnNidn" required
        value="<?= isset($old['dsnNidn']) ? htmlspecialchars($old['dsnNidn']) : '' ?>">

    <label>Nama Lengkap</label>
    <input class="input" name="dsnNama" required
        value="<?= isset($old['dsnNama']) ? htmlspecialchars($old['dsnNama']) : '' ?>">

    <label>Jenis Kelamin</label>
    <select class="input" name="dsnJenisKelaminKode">
        <option value="L" <?= (isset($old['dsnJenisKelaminKode']) && $old['dsnJenisKelaminKode']=='L') ? 'selected' : '' ?>>
            Laki-laki
        </option>
        <option value="P" <?= (isset($old['dsnJenisKelaminKode']) && $old['dsnJenisKelaminKode']=='P') ? 'selected' : '' ?>>
            Perempuan
        </option>
    </select>

    <label>Jurusan</label>
    <select name="dsnJurId" class="input" required>
        <option value="0">-- Pilih Jurusan --</option>

        <?php
        
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"
                <?= (isset($old['dsnJurId']) && $old['dsnJurId'] == $j['jurId']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($j['jurNama']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select name="dsnProdiId" class="input" required>
        <option value="0">-- Pilih Prodi --</option>

        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"
                <?= (isset($old['dsnProdiId']) && $old['dsnProdiId'] == $p['prodiId']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($p['prodiNama']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="save_dosen" type="submit">Simpan</button>
        <a class="btn" style="background:#777" href="index.php?page=dosen">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
