<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<?php if (isset($error)): ?> 
 
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
        <strong>Gagal menghapus data!</strong><br>
        <?= htmlspecialchars($error) ?>
    </div>
 <?php endif; ?>


<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            Data Dosen
        </h1>
        <p class="text-gray-600">Kelola data dosen secara efektif dan terstruktur</p>
    </div>
    
    <a href="index.php?page=dosen&aksi=tambah" 
       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 
       bg-gradient-to-r from-primary-600 to-secondary-600 text-white 
       font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Dosen
    </a>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Total Dosen -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-user-tie text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Total Dosen Terdaftar</p>
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
                    <input type="hidden" name="page" value="dosen">
                    <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" 
                        placeholder="Cari nama / NIDN dosen..."
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

                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Dosen</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jurusan</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prodi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">JK</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">
                <?php $no = 1; $rows->data_seek(0); while($r = $rows->fetch_assoc()): ?>

                <?php
                    // Format nama + gelar
                    $nama = '';
                    if ($r['dsnGelarDepan']) $nama .= $r['dsnGelarDepan'] . ' ';
                    $nama .= $r['dsnNama'];
                    if ($r['dsnGelarBelakang']) $nama .= ', ' . $r['dsnGelarBelakang'];
                ?>

                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $no++ ?></td>

                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">

                            <div class="w-10 h-10 bg-gradient-to-br 
                                from-primary-500 to-secondary-500 
                                rounded-xl flex items-center justify-center 
                                text-white font-bold shadow-lg">
                                <?= strtoupper(substr($r['dsnNama'], 0, 1)) ?>
                            </div>

                            <div>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($nama) ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($r['dsnNidn']) ?></p>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($r['jurNama']) ?></td>
                    <td class="px-6 py-4 text-sm text-gray-600"><?= htmlspecialchars($r['prodiNama']) ?></td>

                    <td class="px-6 py-4 text-center text-sm text-gray-600">
                        <?= $r['dsnJenisKelaminKode'] == 'L' ? 'Laki-laki' : 'Perempuan' ?>
                    </td>

                    <!-- Aksi -->
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">

                            <a href="index.php?page=dosen&aksi=edit&id=<?= $r['dsnNidn'] ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-100 
                               text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <a href="index.php?page=dosen&aksi=delete&id=<?= $r['dsnNidn'] ?>"
                               onclick="return confirm('Yakin ingin menghapus dosen ini?')"
                               class="inline-flex items-center px-4 py-2 bg-red-100 
                               text-red-700 rounded-lg hover:bg-red-200 transition duration-200 font-medium">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </a>

                        </div>
                    </td>
                </tr>

                <?php endwhile; ?>

                <!-- Empty State -->
                <?php if ($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold mb-2">Belum Ada Data Dosen</p>
                            <p class="text-gray-400 text-sm mb-6">Tambahkan data dosen pertama Anda.</p>
                            <a href="index.php?page=dosen&aksi=tambah" 
                               class="inline-flex items-center px-6 py-3 
                               bg-gradient-to-r from-primary-600 to-secondary-600 
                               text-white rounded-xl hover:shadow-xl transform hover:-translate-y-1 transition font-semibold">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Data
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
