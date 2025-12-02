<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Kurikulum</h2>
    <a class="btn" href="index.php?page=kurikulum&aksi=tambah">+ Tambah Kurikulum</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>Prodi</th>
        <th>Tahun</th>
        <th>Nama Kurikulum</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['prodiNama']) ?></td>
        <td><?= htmlspecialchars($r['kurTahun']) ?></td>
        <td><?= htmlspecialchars($r['kurNama']) ?></td>
        <td><?= $r['kurIsAktif'] ? 'Ya' : 'Tidak' ?></td>

        <td>
            <a class="btn small" href="index.php?page=kurikulum&aksi=edit&id=<?= $r['kurId'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus kurikulum ini?')"
                href="index.php?page=kurikulum&aksi=delete&id=<?= $r['kurId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
