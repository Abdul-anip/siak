<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Tahun Akademik</h2>
    <a class="btn" href="index.php?page=tahun_akademik&aksi=tambah">+ Tambah Tahun Akademik</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>ID</th>
        <th>Tahun</th>
        <th>Semester</th>
        <th>Tanggal Mulai</th>
        <th>Tanggal Selesai</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['thakdId']) ?></td>
        <td><?= htmlspecialchars($r['thakdTahun']) ?></td>
        <td><?= htmlspecialchars($r['thakdSemester']) ?></td>
        <td><?= htmlspecialchars($r['thakdTglMulai']) ?></td>
        <td><?= htmlspecialchars($r['thakdTglSelesai']) ?></td>
        <td><?= $r['thakdIsAktif'] ? 'Ya' : 'Tidak' ?></td>

        <td>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus tahun akademik ini?')"
                href="index.php?page=tahun_akademik&aksi=delete&id=<?= $r['thakdId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
