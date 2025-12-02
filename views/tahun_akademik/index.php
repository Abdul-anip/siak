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
        <th>Kode</th>
        <th>Semester</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['taKode']) ?></td>
        <td><?= htmlspecialchars($r['taSemester']) ?></td>
        <td><?= $r['taIsAktif'] ? 'Ya' : 'Tidak' ?></td>

        <td>
            <a class="btn small" href="index.php?page=tahun_akademik&aksi=edit&id=<?= $r['taId'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus tahun akademik ini?')"
                href="index.php?page=tahun_akademik&aksi=delete&id=<?= $r['taId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
