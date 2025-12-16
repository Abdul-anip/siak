<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

 <?php if (isset($error)): ?> 
 
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
        <strong>Gagal menghapus data!</strong><br>
        <?= htmlspecialchars($error) ?>
    </div>
 <?php endif; ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-book text-primary-600 mr-3"></i>Data Matakuliah
        </h1>
        <p class="text-gray-600">Kelola data Matakuliah berdasarkan kurikulum</p>
    </div>

    <a href="index.php?page=matkul&aksi=tambah" 
       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i>Tambah Matakuliah
    </a>
</div>

<!-- Statistik (Opsional) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-book-open text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Total Matakuliah</p>
    </div>
</div>

<!-- Tabel Matakuliah -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

    
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Daftar Jurusan</h3>
            <div class="flex items-center space-x-2">
            
                <form method="GET" class="flex items-center space-x-3">
                    <input type="hidden" name="page" value="matkul">
                    <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" 
                        placeholder="Cari kode / nama matakuliah..."
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500
                            focus:border-primary-500 w-56 text-sm">

                    <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>

                
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
            </div>
        </div>
    </div>


    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Nama Matakuliah</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">Kurikulum</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Semester</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">SKS</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aktif</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php $no=1; while($r = $rows->fetch_assoc()): ?>
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4"><?= $no++ ?></td>
                    <td class="px-6 py-4 font-semibold text-gray-800"><?= htmlspecialchars($r['mkKode']) ?></td>
                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($r['mkNama']) ?></td>
                    <td class="px-6 py-4 text-gray-700"><?= htmlspecialchars($r['kurNama']) ?></td>

                    <td class="px-6 py-4 text-center"><?= $r['mkSemester'] ?></td>
                    <td class="px-6 py-4 text-center"><?= $r['mkSks'] ?></td>

                    <td class="px-6 py-4 text-center">
                        <?php if($r['mkIsAktif']): ?>
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                Aktif
                            </span>
                        <?php else: ?>
                            <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-semibold">
                                Non-Aktif
                            </span>
                        <?php endif; ?>
                    </td>

                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="index.php?page=matkul&aksi=edit&id=<?= $r['mkId'] ?>"
                               class="px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition">
                               <i class="fas fa-edit mr-1"></i>Edit
                            </a>

                            <a href="index.php?page=matkul&aksi=delete&id=<?= $r['mkId'] ?>"
                               onclick="return confirm('Hapus matakuliah ini?')"
                               class="px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition">
                               <i class="fas fa-trash mr-1"></i>Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
