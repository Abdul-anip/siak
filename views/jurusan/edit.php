<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=jurusan" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Jurusan
            </h1>
            <p class="text-gray-600 mt-1">Perbarui informasi jurusan <?= htmlspecialchars($data['jurNama']) ?></p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Edit Data Jurusan</h3>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                
                <form method="post" action="index.php?page=jurusan&aksi=update" class="space-y-6">

                    <input type="hidden" name="jurId" value="<?= $data['jurId'] ?>">

                    <!-- ID Info (Read-only) -->
                    <div class="bg-gray-50 border-2 border-gray-200 rounded-xl p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs text-gray-500 mb-1">ID Jurusan</p>
                                <p class="text-lg font-bold text-gray-800">#<?= $data['jurId'] ?></p>
                            </div>
                            <div class="w-12 h-12 bg-gray-200 rounded-xl flex items-center justify-center">
                                <i class="fas fa-database text-gray-600 text-xl"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Kode Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-hashtag text-primary-600 mr-2"></i>
                            Kode Jurusan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="jurKode"
                            value="<?= htmlspecialchars($data['jurKode']) ?>"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none font-mono"
                        >
                    </div>

                    <!-- Nama Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-primary-600 mr-2"></i>
                            Nama Jurusan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="jurNama"
                            value="<?= htmlspecialchars($data['jurNama']) ?>"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                    </div>

                    <!-- Nama Asing -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-globe text-primary-600 mr-2"></i>
                            Nama Asing <span class="text-gray-400">(Opsional)</span>
                        </label>
                        <input 
                            type="text"
                            name="jurNamaAsing"
                            value="<?= htmlspecialchars($data['jurNamaAsing']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                    </div>

                    <!-- Status Aktif -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-toggle-on text-primary-600 mr-2"></i>
                            Status
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="jurIsAktif" 
                                <?= $data['jurIsAktif'] ? 'checked' : '' ?>
                                class="sr-only peer"
                            >
                            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Jurusan Aktif</span>
                        </label>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            name="update_jurusan"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Update Data
                        </button>
                        <a 
                            href="index.php?page=jurusan"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-200"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Info Sidebar -->
    <div class="lg:col-span-1 space-y-6">
        
        <!-- History Card -->
        <div class="bg-white border-2 border-gray-200 rounded-2xl p-6">
            <h4 class="font-bold text-gray-800 mb-4 flex items-center">
                <i class="fas fa-history text-primary-600 mr-2"></i>
                Informasi Data
            </h4>
            <div class="space-y-3">
                <div class="flex items-start">
                    <i class="fas fa-database text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-xs text-gray-500">ID Database</p>
                        <p class="text-sm font-semibold text-gray-800">#<?= $data['jurId'] ?></p>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-calendar text-gray-400 mr-3 mt-1"></i>
                    <div>
                        <p class="text-xs text-gray-500">Status</p>
                        <p class="text-sm font-semibold text-gray-800">
                            <?= $data['jurIsAktif'] ? '✅ Aktif' : '❌ Non-Aktif' ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Warning Card -->
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
                    <ul class="text-sm text-yellow-700 space-y-2">
                        <li>• Perubahan data akan mempengaruhi data terkait</li>
                        <li>• Pastikan data sudah benar sebelum menyimpan</li>
                        <li>• Backup data jika diperlukan</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Delete Card -->
        <div class="bg-red-50 border-2 border-red-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-trash-alt text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-red-800 mb-2">Hapus Data?</h4>
                    <p class="text-sm text-red-700 mb-3">
                        Jika ingin menghapus jurusan ini, klik tombol di bawah.
                    </p>
                    <a 
                        href="index.php?page=jurusan&aksi=delete&id=<?= $data['jurId'] ?>"
                        onclick="return confirm('⚠️ PERINGATAN!\n\nYakin ingin menghapus jurusan <?= htmlspecialchars($data['jurNama']) ?>?\n\nData yang terkait:\n- Program Studi\n- Dosen\n- Mahasiswa\n\nAkan terpengaruh!\n\nLanjutkan?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition text-sm font-semibold"
                    >
                        <i class="fas fa-trash-alt mr-2"></i>
                        Hapus Jurusan
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>