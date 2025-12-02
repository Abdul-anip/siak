<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Matakuliah</h2>
    <a class="btn" href="index.php?page=matkul&aksi=tambah">+ Tambah Matakuliah</a>
</div>

<div class="card-content">

<table class="table">
    <tr>
        <th>#</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>Kurikulum</th>
        <th>Semester</th>
        <th>SKS</th>
        <th>Aktif</th>
        <th>Aksi</th>
    </tr>

    <?php $no=1; while($r = $rows->fetch_assoc()): ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= htmlspecialchars($r['mkKode']) ?></td>
        <td><?= htmlspecialchars($r['mkNama']) ?></td>
        <td><?= htmlspecialchars($r['kurNama']) ?></td>
        <td><?= $r['mkSemester'] ?></td>
        <td><?= $r['mkSks'] ?></td>
        <td><?= $r['mkIsAktif'] ? 'Ya' : 'Tidak' ?></td>

        <td>
            <a class="btn small" href="index.php?page=matkul&aksi=edit&id=<?= $r['mkId'] ?>">Edit</a>

            <a class="btn small" style="background:#d9534f"
                onclick="return confirm('Hapus matakuliah ini?')"
                href="index.php?page=matkul&aksi=delete&id=<?= $r['mkId'] ?>">Hapus</a>
        </td>
    </tr>
    <?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
