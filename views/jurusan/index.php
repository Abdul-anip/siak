<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Jurusan</h2>
    <a class="btn" href="index.php?page=jurusan&aksi=tambah">+ Tambah Jurusan</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>Kode</th>
        <th>Nama Jurusan</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($row = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($row['jurKode']) ?></td>
        <td><?= htmlspecialchars($row['jurNama']) ?></td>
        <td><?= $row['jurIsAktif'] ? 'Ya' : 'Tidak' ?></td>
        <td>
            <a class="btn small"
               href="index.php?page=jurusan&aksi=edit&id=<?= $row['jurId'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus jurusan ini?')"
                href="index.php?page=jurusan&aksi=delete&id=<?= $row['jurId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
