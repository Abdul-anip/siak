<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar"><h2>Edit Mahasiswa</h2></div>

<div class="card-content">

<form method="post" action="index.php?page=mahasiswa&aksi=update">

    <input type="hidden" name="mhsNim" value="<?= $data['mhsNim'] ?>">

    <label>NIM</label>
    <input class="input" value="<?= $data['mhsNim'] ?>" disabled style="background:#eee">

    <label>Nama Lengkap</label>
    <input class="input" name="mhsNama" value="<?= htmlspecialchars($data['mhsNama']) ?>" required>

    <label>Tempat Lahir</label>
    <input class="input" name="mhsTempatLahir" value="<?= $data['mhsTempatLahir'] ?>">

    <label>Tanggal Lahir</label>
    <input class="input" type="date" name="mhsTglLahir" value="<?= $data['mhsTglLahir'] ?>">

    <label>Jenis Kelamin</label>
    <select class="input" name="mhsJenisKelamin">
        <option value="L" <?= $data['mhsJenisKelamin']=='L'?'selected':'' ?>>Laki-laki</option>
        <option value="P" <?= $data['mhsJenisKelamin']=='P'?'selected':'' ?>>Perempuan</option>
    </select>

    <label>Jurusan</label>
    <select class="input" name="mhsJurId">
        <?php 
        
        /** @var mysqli_result $jurusan */
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"
                <?= $j['jurId']==$data['mhsJurId']?'selected':'' ?>>
                <?= $j['jurNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select class="input" name="mhsProdiId">
        <?php while($p = $listProdi->fetch_assoc()): ?>
            <option value="<?= $p['prodiId'] ?>"
                <?= $p['prodiId']==$data['mhsProdiId']?'selected':'' ?>>
                <?= $p['prodiNama'] ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Kode Kelas</label>
    <select class="input" name="mhsKodeKelas">
        <option value="A" <?= $data['mhsKodeKelas']=='A'?'selected':'' ?>>A</option>
        <option value="B" <?= $data['mhsKodeKelas']=='B'?'selected':'' ?>>B</option>
        <option value="C" <?= $data['mhsKodeKelas']=='C'?'selected':'' ?>>C</option>
        <option value="D" <?= $data['mhsKodeKelas']=='D'?'selected':'' ?>>D</option>
    </select>

    <label>Status Akademik</label>
    <select class="input" name="mhsStsAkademik">
        <option value="A" <?= $data['mhsStsAkademik']=='A'?'selected':'' ?>>Aktif</option>
        <option value="L" <?= $data['mhsStsAkademik']=='L'?'selected':'' ?>>Lulus</option>
        <option value="C" <?= $data['mhsStsAkademik']=='C'?'selected':'' ?>>Cuti</option>
        <option value="D" <?= $data['mhsStsAkademik']=='D'?'selected':'' ?>>DO</option>
        <option value="K" <?= $data['mhsStsAkademik']=='K'?'selected':'' ?>>Keluar</option>
        <option value="M" <?= $data['mhsStsAkademik']=='M'?'selected':'' ?>>Meninggal</option>
    </select>

    <label>Semester Aktif</label>
    <input class="input" type="number" name="mhsSmsAktif" value="<?= $data['mhsSmsAktif'] ?>">

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="update_mahasiswa">Update</button>
    <a class="btn" style="background:#777" href="index.php?page=mahasiswa">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>
