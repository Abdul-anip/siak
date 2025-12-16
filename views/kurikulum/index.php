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
            <i class="fas fa-book-open text-primary-600 mr-3"></i>Data Kurikulum
        </h1>
        <p class="text-gray-600">Kelola data kurikulum setiap program studi</p>
    </div>
    <a href="index.php?page=kurikulum&aksi=tambah"
       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i>Tambah Kurikulum
    </a>
</div>

<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Daftar Jurusan</h3>
            <div class="flex items-center space-x-2">
            
                <form method="GET" class="flex items-center space-x-3">
                    <input type="hidden" name="page" value="kurikulum">
                    <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" 
                        placeholder="Cari nama kurikulum / prodi..."
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
                    <th class="px-6 py-4">#</th>
                    <th class="px-6 py-4">Prodi</th>
                    <th class="px-6 py-4">Tahun</th>
                    <th class="px-6 py-4">Nama Kurikulum</th>
                    <th class="px-6 py-4 text-center">Aktif</th>
                    <th class="px-6 py-4 text-center w-48">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                <?php $no=1; $rows->data_seek(0); while($r = $rows->fetch_assoc()): ?>
                <tr>
                    <td class="px-6 py-4"><?= $no++ ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($r['prodiNama']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($r['kurTahun']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($r['kurNama']) ?></td>

                    <td class="px-6 py-4 text-center">
                        <?= $r['kurIsAktif'] ? 
                            '<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Aktif</span>' :
                            '<span class="px-3 py-1 rounded-full bg-gray-200 text-gray-700 text-xs font-semibold">Tidak</span>'
                        ?>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center space-x-2">

                            <a href="index.php?page=kurikulum&aksi=edit&id=<?= $r['kurId'] ?>" 
                                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>

                            <a href="index.php?page=kurikulum&aksi=delete&id=<?= $r['kurId'] ?>" 
                                onclick="return confirm('Hapus kurikulum ini?')"
                                class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200">
                                <i class="fas fa-trash-alt mr-1"></i>Hapus
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>

                <?php if ($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center text-gray-500">
                        <i class="fas fa-inbox text-5xl text-gray-300 mb-3"></i>
                        <p class="text-lg font-semibold">Belum Ada Data Kurikulum</p>
                        <a href="index.php?page=kurikulum&aksi=tambah" 
                           class="inline-block mt-4 px-6 py-3 text-white bg-primary-600 rounded-lg">Tambah Data</a>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
