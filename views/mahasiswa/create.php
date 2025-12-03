<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar"><h2>Tambah Mahasiswa</h2></div>

<div class="card-content">

<?php if (isset($error)): ?>
<div style="padding:10px;background:#fdd;border:1px solid #f99;margin-bottom:10px;">
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=mahasiswa&aksi=save">

    <label>NIM</label>
    <input class="input" name="mhsNim" 
       value="<?= $old['mhsNim'] ?? '' ?>" required>

    <label>Nama Lengkap</label>
    <input class="input" name="mhsNama" 
       value="<?= $old['mhsNama'] ?? '' ?>" required>

    <label>Tempat Lahir</label>
    <input class="input" name="mhsTempatLahir"
       value="<?= $old['mhsTempatLahir'] ?? '' ?>">

    <label>Tanggal Lahir</label>
    <input class="input" type="date" name="mhsTglLahir"
       value="<?= $old['mhsTglLahir'] ?? '' ?>">

    <label>Jenis Kelamin</label>
    <select class="input" name="mhsJenisKelamin">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Jurusan</label>
    <select class="input" name="mhsJurId" required>
        <option value="">-- Pilih Jurusan --</option>
        <?php
        /** @var mysqli_result $jurusan */
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"><?= $j['jurNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select class="input" name="mhsProdiId" required>
        <option value="">-- Pilih Prodi --</option>
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"><?= $p['prodiNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Kode Kelas</label>
    <select class="input" name="mhsKodeKelas">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
    </select>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="save_mahasiswa">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=mahasiswa">Batal</a>
    </div>
</form>

</div>

<?php include "views/layout/footer.php"; ?>
