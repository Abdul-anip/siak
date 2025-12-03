<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>📚 Daftar Kelas</h2>
    <a class="btn" href="index.php?page=kelas&aksi=tambah">+ Tambah Kelas</a>
</div>

<div class="card-content">

<table class="table">
    <thead>
        <tr>
            <th style="width: 50px;">#</th>
            <th>Nama Kelas</th>
            <th>Program Studi</th>
            <th>Tahun Akademik</th>
            <th style="width: 100px; text-align: center;">Jumlah Mhs</th>
            <th style="width: 200px; text-align: center;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1; 
        while($r = $rows->fetch_assoc()): 
            // Hitung jumlah mahasiswa di kelas ini
            $jumlahMhs = $kelas->countMahasiswa($r['klsId']);
        ?>
        <tr>
            <td data-label="#"><?= $no++ ?></td>
            <td data-label="Nama Kelas">
                <strong><?= htmlspecialchars($r['klsNama']) ?></strong>
            </td>
            <td data-label="Program Studi">
                <?= htmlspecialchars($r['prodiNama']) ?>
            </td>
            <td data-label="Tahun Akademik">
                <?= htmlspecialchars($r['tahunAkademikLabel']) ?>
            </td>
            <td data-label="Jumlah Mhs" style="text-align: center;">
                <span style="display: inline-block; background: #EAF4FF; padding: 4px 12px; border-radius: 12px; font-weight: 600; color: #0A3B6F;">
                    <?= $jumlahMhs ?> Mhs
                </span>
            </td>
            <td data-label="Aksi" style="text-align: center;">
                <a class="btn small" href="index.php?page=kelas&aksi=edit&id=<?= $r['klsId'] ?>">
                    ✏️ Edit
                </a>

                <a class="btn small" style="background:#d9534f"
                    onclick="return confirm('⚠️ Hapus kelas <?= htmlspecialchars($r['klsNama']) ?>?\n\n<?= $jumlahMhs > 0 ? 'PERHATIAN: Kelas ini memiliki '.$jumlahMhs.' mahasiswa!' : '' ?>')"
                    href="index.php?page=kelas&aksi=delete&id=<?= $r['klsId'] ?>">
                    🗑️ Hapus
                </a>
            </td>
        </tr>
        <?php endwhile; ?>

        <?php if ($rows->num_rows == 0): ?>
        <tr>
            <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
                📭 Belum ada data kelas.<br>
                <a href="index.php?page=kelas&aksi=tambah" style="color: #1E88E5; text-decoration: none; font-weight: 600;">
                    + Tambah Kelas Pertama
                </a>
            </td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>

<div style="margin-top: 20px; padding: 15px; background: #F4F7FC; border-radius: 8px; border-left: 4px solid #1E88E5;">
    <strong>💡 Informasi:</strong><br>
    Total Kelas: <strong><?= $rows->num_rows ?></strong> kelas
</div>

</div>

<?php include "views/layout/footer.php"; ?>