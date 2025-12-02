<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Data Mahasiswa</h2>
    <a class="btn" href="index.php?page=mahasiswa&aksi=tambah">+ Tambah Mahasiswa</a>
</div>

<div class="card-content">

<!-- SEARCH BAR -->
<form method="get" style="display:flex; gap:10px; margin-bottom:15px;">
    <input type="hidden" name="page" value="mahasiswa">
    <input class="input" name="search" placeholder="🔍 Cari NIM atau Nama..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>" style="flex:1;">
    <button class="btn">Cari</button>
</form>

<table class="table">
<tr>
    <th>#</th>
    <th>NIM</th>
    <th>Nama</th>
    <th>TTL</th>
    <th>JK</th>
    <th>Jurusan</th>
    <th>Prodi</th>
    <th>Kelas</th>
    <th>Status</th>
    <th>Sms</th>
    <th>Aksi</th>
</tr>

<?php $no=1; while($r = $rows->fetch_assoc()): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><strong><?= $r['mhsNim'] ?></strong></td>
    <td><?= htmlspecialchars($r['mhsNama']) ?></td>
    <td>
        <?= htmlspecialchars($r['mhsTempatLahir']) ?>,
        <?= $r['mhsTglLahir'] ? date('d-m-Y', strtotime($r['mhsTglLahir'])) : '' ?>
    </td>
    <td><?= $r['mhsJenisKelamin'] ?></td>
    <td><?= htmlspecialchars($r['jurNama']) ?></td>
    <td><?= htmlspecialchars($r['prodiNama']) ?></td>
    <td><?= $r['mhsKodeKelas'] ?></td>
    <td><?= $r['mhsStsAkademik'] ?></td>
    <td><?= $r['mhsSmsAktif'] ?></td>

    <td>
        <a class="btn small" href="index.php?page=mahasiswa&aksi=edit&id=<?= $r['mhsNim'] ?>">Edit</a>

        <a class="btn small" style="background:#d9534f"
            onclick="return confirm('Hapus mahasiswa ini?')"
            href="index.php?page=mahasiswa&aksi=delete&id=<?= $r['mhsNim'] ?>">Hapus</a>
    </td>
</tr>
<?php endwhile; ?>

</table>

</div>

<?php include "views/layout/footer.php"; ?>
