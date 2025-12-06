<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- PAGE HEADER -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-1">
            <i class="fas fa-folder-open text-primary-600 mr-3"></i>
            Data Program Studi
        </h1>
        <p class="text-gray-600">Kelola data program studi dengan lebih mudah</p>
    </div>

    <a href="index.php?page=prodi&aksi=tambah"
       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r 
              from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg 
              hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i>
        Tambah Program Studi
    </a>
</div>

<!-- STATISTICS CARD -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-folder-open text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Total Program Studi</p>
    </div>
</div>

<!-- MAIN TABLE -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

    <!-- HEADER -->
    <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-bold text-gray-800">Daftar Program Studi</h3>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Nama Prodi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Jurusan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider">Jenjang</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php $no = 1; $rows->data_seek(0); while ($r = $rows->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50 transition duration-150">

                    <!-- NO -->
                    <td class="px-6 py-4 text-sm font-medium text-gray-700"><?= $no++ ?></td>

                    <!-- KODE PRODI -->
                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($r['prodiKode']) ?></td>

                    <!-- NAMA PRODI + AVATAR -->
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-primary-500 text-white rounded-xl flex items-center justify-center font-bold shadow">
                                <?= strtoupper(substr($r['prodiNama'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900"><?= htmlspecialchars($r['prodiNama']) ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($r['jurNama']) ?></p>
                            </div>
                        </div>
                    </td>

                    <!-- JURUSAN -->
                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($r['jurNama']) ?></td>

                    <!-- JENJANG -->
                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($r['prodiJenjang']) ?></td>

                    <!-- STATUS -->
                    <td class="px-6 py-4 text-center">
                        <?php if ($r['prodiIsAktif']): ?>
                            <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                Tidak Aktif
                            </span>
                        <?php endif; ?>
                    </td>

                    <!-- ACTION BUTTONS -->
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">

                            <a href="index.php?page=prodi&aksi=edit&id=<?= $r['prodiId'] ?>"
                               class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>

                            <a href="index.php?page=prodi&aksi=delete&id=<?= $r['prodiId'] ?>"
                               onclick="return confirm('Yakin ingin menghapus data ini?')"
                               class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                <i class="fas fa-trash mr-1"></i>Hapus
                            </a>

                        </div>
                    </td>

                </tr>
                <?php endwhile; ?>

                <?php if ($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center text-gray-500">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-4"></i><br>
                        Belum ada data Program Studi
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
