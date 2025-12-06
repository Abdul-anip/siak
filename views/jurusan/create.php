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
                <i class="fas fa-plus-circle text-primary-600 mr-3"></i>Tambah Jurusan
            </h1>
            <p class="text-gray-600 mt-1">Lengkapi form di bawah untuk menambahkan jurusan baru</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <!-- Form Header -->
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Data Jurusan</h3>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                
                <!-- Alert Error -->
                <?php if (isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-pulse">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-700 mt-1"><?= $error ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post" action="index.php?page=jurusan&aksi=save" class="space-y-6">

                    <!-- Kode Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-hashtag text-primary-600 mr-2"></i>
                            Kode Jurusan <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="jurKode"
                            value="<?= $old['jurKode'] ?? '' ?>"
                            placeholder="Contoh: TI, SI, IF"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none font-mono"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Kode singkat untuk identifikasi jurusan (2-5 karakter)
                        </p>
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
                            value="<?= $old['jurNama'] ?? '' ?>"
                            placeholder="Contoh: Teknik Informatika"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Nama lengkap jurusan sesuai SK resmi
                        </p>
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
                            value="<?= $old['jurNamaAsing'] ?? '' ?>"
                            placeholder="Contoh: Informatics Engineering"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Nama jurusan dalam bahasa Inggris (jika ada)
                        </p>
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
                                <?= isset($old['jurIsAktif']) ? 'checked' : 'checked' ?>
                                class="sr-only peer"
                            >
                            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Jurusan Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Hanya jurusan aktif yang dapat digunakan dalam sistem
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            name="save_jurusan"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Simpan Data
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
        
        <!-- Tips Card -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-blue-800 mb-2">💡 Tips Pengisian</h4>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                            <span>Gunakan kode singkat dan mudah diingat</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                            <span>Nama jurusan harus sesuai SK resmi</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                            <span>Pastikan kode belum digunakan</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Example Card -->
        <div class="bg-purple-50 border-2 border-purple-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-book text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-purple-800 mb-2">📚 Contoh Data</h4>
                    <div class="text-sm text-purple-700 space-y-2">
                        <div class="bg-white rounded-lg p-3">
                            <p class="font-semibold mb-1">Teknik</p>
                            <p class="text-xs"><span class="font-mono bg-purple-100 px-2 py-0.5 rounded">TK</span></p>
                        </div>
                        <div class="bg-white rounded-lg p-3">
                            <p class="font-semibold mb-1">Teknik Informatika</p>
                            <p class="text-xs"><span class="font-mono bg-purple-100 px-2 py-0.5 rounded">TI</span></p>
                        </div>
                        <div class="bg-white rounded-lg p-3">
                            <p class="font-semibold mb-1">Sistem Informasi</p>
                            <p class="text-xs"><span class="font-mono bg-purple-100 px-2 py-0.5 rounded">SI</span></p>
                        </div>
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
                    <p class="text-sm text-yellow-700">
                        Kode jurusan tidak dapat diubah setelah disimpan. Pastikan data sudah benar!
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>