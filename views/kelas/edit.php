<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>✏️ Edit Kelas</h2>
</div>

<div class="card-content">

<form method="post" action="index.php?page=kelas&aksi=update">

    <input type="hidden" name="klsId" value="<?= $data['klsId'] ?>">

    <label>Tahun Akademik <span style="color: red;">*</span></label>
    <select name="klsThakdId" class="input" required>
        <option value="0">-- Pilih Tahun Akademik --</option>
        <?php 
        /** @var mysqli_result $listTahunAkademik */
        while($t = $listTahunAkademik->fetch_assoc()): 
            $selected = ($t['thakdId'] == $data['klsThakdId']) ? 'selected' : '';
            $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
        ?>
            <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                <?= $t['thakdTahun'] ?> - <?= $semesterLabel ?>
                <?= $t['thakdIsAktif'] ? '✅ (Aktif)' : '' ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi <span style="color: red;">*</span></label>
    <select name="klsProdiId" class="input" required>
        <option value="0">-- Pilih Program Studi --</option>
        <?php 
        /** @var mysqli_result $listProdi */
        while($p = $listProdi->fetch_assoc()): 
            $selected = ($p['prodiId'] == $data['klsProdiId']) ? 'selected' : '';
        ?>
            <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
            </option>
        <?php endwhile; ?>
    </select>

    <label>Nama Kelas <span style="color: red;">*</span></label>
    <input 
        class="input" 
        name="klsNama" 
        value="<?= htmlspecialchars($data['klsNama']) ?>"
        required
    >

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <button class="btn" name="update_kelas" type="submit">
            💾 Update
        </button>
        <a class="btn" style="background:#777" href="index.php?page=kelas">
            ❌ Batal
        </a>
    </div>

</form>

<div style="margin-top: 30px; padding: 15px; background: #E3F2FD; border-radius: 8px; border-left: 4px solid #2196F3;">
    <strong>ℹ️ Informasi Kelas:</strong>
    <ul style="margin: 10px 0 0 20px; padding: 0; list-style: none;">
        <li>📊 ID Kelas: <strong><?= $data['klsId'] ?></strong></li>
        <li>👥 Jumlah Mahasiswa: <strong><?= $kelas->countMahasiswa($data['klsId']) ?></strong> mahasiswa</li>
    </ul>
</div>

</div>

<?php include "views/layout/footer.php"; ?>