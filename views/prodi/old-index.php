<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Program Studi</h2>
    <a class="btn" href="index.php?page=prodi&aksi=tambah">+ Tambah Prodi</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>Kode</th>
        <th>Nama Prodi</th>
        <th>Jurusan</th>
        <th>Jenjang</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['prodiKode']) ?></td>
        <td><?= htmlspecialchars($r['prodiNama']) ?></td>
        <td><?= htmlspecialchars($r['jurNama']) ?></td>
        <td><?= htmlspecialchars($r['prodiJenjang']) ?></td>
        <td><?= $r['prodiIsAktif'] ? 'Ya' : 'Tidak' ?></td>

        <td>
            <a class="btn small"
                href="index.php?page=prodi&aksi=edit&id=<?= $r['prodiId'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus prodi ini?')"
                href="index.php?page=prodi&aksi=delete&id=<?= $r['prodiId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
