<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Data Jurusan
        </h1>
        <p class="text-gray-600">Kelola data jurusan dengan mudah dan efisien</p>
    </div>
    <a href="index.php?page=jurusan&aksi=tambah" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i>
        Tambah Jurusan
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-folder-open text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Total Jurusan</p>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-check-circle text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Aktif</span>
        </div>
        <p class="text-3xl font-bold">
            <?php 
            $aktif = 0;
            $temp = $rows->data_seek(0);
            while($r = $rows->fetch_assoc()) {
                if($r['jurIsAktif']) $aktif++;
            }
            echo $aktif;
            $rows->data_seek(0);
            ?>
        </p>
        <p class="text-sm opacity-90">Jurusan Aktif</p>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-building text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Program Studi</span>
        </div>
        <p class="text-3xl font-bold">-</p>
        <p class="text-sm opacity-90">Total Prodi</p>
    </div>
</div>

<!-- Data Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Daftar Jurusan</h3>
            <div class="flex items-center space-x-2">
            
                <form method="GET" class="flex items-center space-x-3">
                    <input type="hidden" name="page" value="jurusan">
                    <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" 
                        placeholder="Cari nama / kode jurusan..."
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

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-16">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Jurusan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Asing</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php 
                $no = 1; 
                while($row = $rows->fetch_assoc()): 
                ?>
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $no++ ?></td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-semibold bg-blue-100 text-blue-700 font-mono">
                            <?= htmlspecialchars($row['jurKode']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl flex items-center justify-center text-white font-bold shadow-lg">
                                <?= strtoupper(substr($row['jurNama'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($row['jurNama']) ?></p>
                                <p class="text-xs text-gray-500">ID: <?= $row['jurId'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <?= htmlspecialchars($row['jurNamaAsing'] ?: '-') ?>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <?php if($row['jurIsAktif']): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <i class="fas fa-check-circle mr-1"></i> Aktif
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">
                                <i class="fas fa-times-circle mr-1"></i> Non-Aktif
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="index.php?page=jurusan&aksi=edit&id=<?= $row['jurId'] ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 font-medium"
                               title="Edit">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>
                            <a href="index.php?page=jurusan&aksi=delete&id=<?= $row['jurId'] ?>" 
                               onclick="return confirm('⚠️ Yakin ingin menghapus jurusan <?= htmlspecialchars($row['jurNama']) ?>?\n\nData yang terkait dengan jurusan ini mungkin akan terpengaruh!')"
                               class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 font-medium"
                               title="Hapus">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold mb-2">Belum Ada Data Jurusan</p>
                            <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan jurusan pertama</p>
                            <a href="index.php?page=jurusan&aksi=tambah" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition font-semibold">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Jurusan
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer -->
    <?php if($rows->num_rows > 0): ?>
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <p class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold text-gray-800"><?= $rows->num_rows ?></span> jurusan
        </p>
    </div>
    <?php endif; ?>
</div>

<!-- Info Card -->
<div class="mt-8 bg-blue-50 border-l-4 border-blue-500 rounded-lg p-6">
    <div class="flex items-start">
        <i class="fas fa-info-circle text-blue-500 text-2xl mr-4 mt-1"></i>
        <div>
            <h4 class="font-bold text-blue-800 mb-2">Informasi Jurusan</h4>
            <p class="text-sm text-blue-700 mb-2">
                Jurusan adalah unit akademik yang mengelola program studi di perguruan tinggi.
            </p>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• Setiap jurusan dapat memiliki beberapa program studi</li>
                <li>• Kode jurusan harus unik</li>
                <li>• Pastikan data sudah benar sebelum menghapus</li>
            </ul>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>