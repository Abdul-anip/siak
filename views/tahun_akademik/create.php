<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Tahun Akademik</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div style="padding:10px;background:#fdd;border:1px solid #f99;margin-bottom:10px;border-radius:6px;">
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=tahun_akademik&aksi=save">

    <label>ID Tahun Akademik (contoh: 20241)</label>
    <input 
        class="input" 
        name="thakdId" 
        type="number" 
        minlength="5" 
        maxlength="5"
        placeholder="20241"
        value="<?= htmlspecialchars($old['thakdId'] ?? '') ?>" 
        required
    >
    <small style="color:#666">
        Format: TAHUN (YYYY) + SEMESTER (1 = Ganjil, 2 = Genap)<br>
        Contoh: 2024 Ganjil → 20241, 2024 Genap → 20242
    </small>

    <label>Tahun Akademik Awal (YYYY)</label> <input 
        class="input" 
        name="thakdTahun" 
        type="text"
        placeholder="Contoh: 2025" value="<?= htmlspecialchars($old['thakdTahun'] ?? '') ?>" 
        required
    >
    <small style="color:#666">
        Masukkan tahun awal akademik. Tampilan pada sistem: **2025/2026**.
    </small>

    <label>Semester</label>
    <select class="input" name="thakdSemester" required>
        <option value="1" <?= isset($old['thakdSemester']) && $old['thakdSemester'] == '1' ? 'selected' : '' ?>>
            Ganjil (1)
        </option>
        <option value="2" <?= isset($old['thakdSemester']) && $old['thakdSemester'] == '2' ? 'selected' : '' ?>>
            Genap (2)
        </option>
    </select>

    <label>Tanggal Mulai</label>
    <input 
        class="input" 
        name="thakdTglMulai" 
        type="date"
        value="<?= htmlspecialchars($old['thakdTglMulai'] ?? '') ?>"
    >

    <label>Tanggal Selesai</label>
    <input 
        class="input" 
        name="thakdTglSelesai" 
        type="date"
        value="<?= htmlspecialchars($old['thakdTglSelesai'] ?? '') ?>"
    >

    <label>
        <input 
            type="checkbox" 
            name="thakdIsAktif"
            <?= isset($old['thakdIsAktif']) ? 'checked' : '' ?>
        >
        Aktif
    </label>

    <br><br>

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="save_ta">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=tahun_akademik">Batal</a>
    </div>

</form>

</div>

<?php include "views/layout/footer.php"; ?>