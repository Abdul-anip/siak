<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Dosen</h2>
    <a class="btn" href="index.php?page=dosen&aksi=tambah">+ Tambah Dosen</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>NIDN</th>
        <th>Nama</th>
        <th>Jurusan</th>
        <th>Prodi</th>
        <th>JK</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['dsnNidn']) ?></td>
        <td><?= htmlspecialchars($r['dsnNama']) ?></td>
        <td><?= htmlspecialchars($r['jurNama']) ?></td>
        <td><?= htmlspecialchars($r['prodiNama']) ?></td>
        <td><?= htmlspecialchars($r['dsnJenisKelaminKode']) ?></td>

        <td>
            <a class="btn small" href="index.php?page=dosen&aksi=edit&id=<?= $r['dsnNidn'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus dosen ini?')"
                href="index.php?page=dosen&aksi=delete&id=<?= $r['dsnNidn'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
