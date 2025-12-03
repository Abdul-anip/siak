<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>➕ Tambah Kelas</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div class="message-box error">
    <strong>❌ Error!</strong><br>
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=kelas&aksi=save">

    <label>Tahun Akademik <span style="color: red;">*</span></label>
    <select name="klsThakdId" class="input" required>
        <option value="0">-- Pilih Tahun Akademik --</option>
        <?php 
        /** @var mysqli_result $listTahunAkademik */
        while($t = $listTahunAkademik->fetch_assoc()): 
            $selected = (isset($old['klsThakdId']) && $old['klsThakdId'] == $t['thakdId']) ? 'selected' : '';
            $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
        ?>
            <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                <?= $t['thakdTahun'] ?> - <?= $semesterLabel ?>
                <?= $t['thakdIsAktif'] ? '✅ (Aktif)' : '' ?>
            </option>
        <?php endwhile; ?>
    </select>
    <small>Pilih tahun akademik untuk kelas ini</small>

    <label>Program Studi <span style="color: red;">*</span></label>
    <select name="klsProdiId" class="input" required>
        <option value="0">-- Pilih Program Studi --</option>
        <?php 
        /** @var mysqli_result $listProdi */
        while($p = $listProdi->fetch_assoc()): 
            $selected = (isset($old['klsProdiId']) && $old['klsProdiId'] == $p['prodiId']) ? 'selected' : '';
        ?>
            <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
            </option>
        <?php endwhile; ?>
    </select>
    <small>Pilih program studi untuk kelas ini</small>

    <label>Nama Kelas <span style="color: red;">*</span></label>
    <input 
        class="input" 
        name="klsNama" 
        placeholder="Contoh: III.A, IV.B, V.C"
        value="<?= isset($old['klsNama']) ? htmlspecialchars($old['klsNama']) : '' ?>"
        required
    >
    <small>Format: [Tingkat].[Kode Kelas] - Contoh: III.A (Tingkat 3 Kelas A)</small>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <button class="btn" name="save_kelas" type="submit">
            💾 Simpan
        </button>
        <a class="btn" style="background:#777" href="index.php?page=kelas">
            ❌ Batal
        </a>
    </div>

</form>

<div style="margin-top: 30px; padding: 15px; background: #FFF3CD; border-radius: 8px; border-left: 4px solid #FFC107;">
    <strong>💡 Tips Penamaan Kelas:</strong>
    <ul style="margin: 10px 0 0 20px; padding: 0;">
        <li>Gunakan format standar: <strong>Tingkat.Kelas</strong></li>
        <li>Contoh: <code>I.A</code>, <code>II.B</code>, <code>III.C</code></li>
        <li>Tingkat menggunakan angka Romawi (I, II, III, IV, dst)</li>
        <li>Kelas menggunakan huruf (A, B, C, D, dst)</li>
    </ul>
</div>

</div>

<?php include "views/layout/footer.php"; ?>