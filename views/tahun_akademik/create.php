<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=tahun_akademik" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-calendar-plus text-primary-600 mr-3"></i>Tambah Tahun Akademik
            </h1>
            <p class="text-gray-600 mt-1">Buka periode akademik baru untuk perkuliahan</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Periode Akademik</h3>
            </div>

            <div class="p-6">
                
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

                <form method="post" action="index.php?page=tahun_akademik&aksi=save" class="space-y-6">

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-key text-primary-600 mr-2"></i>ID Tahun Akademik <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="thakdId" 
                            value="<?= htmlspecialchars($old['thakdId'] ?? '') ?>" 
                            placeholder="Contoh: 20241"
                            min="10000" max="99999" required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                        <p class="text-xs text-gray-500 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format wajib 5 digit: 4 digit Tahun + 1 digit Semester (1/2)
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar text-primary-600 mr-2"></i>Tahun Awal <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                name="thakdTahun" 
                                value="<?= htmlspecialchars($old['thakdTahun'] ?? '') ?>" 
                                placeholder="Contoh: 2024"
                                min="2000" max="2100" required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                            <p class="text-xs text-gray-500 mt-1">Sistem akan menampilkan: <b>2024/2025</b></p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-list-ol text-primary-600 mr-2"></i>Semester <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="thakdSemester" 
                                required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                                <option value="1" <?= (isset($old['thakdSemester']) && $old['thakdSemester'] == '1') ? 'selected' : '' ?>>1 - Ganjil</option>
                                <option value="2" <?= (isset($old['thakdSemester']) && $old['thakdSemester'] == '2') ? 'selected' : '' ?>>2 - Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-hourglass-start text-primary-600 mr-2"></i>Tanggal Mulai
                            </label>
                            <input 
                                type="date" 
                                name="thakdTglMulai" 
                                value="<?= htmlspecialchars($old['thakdTglMulai'] ?? '') ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-hourglass-end text-primary-600 mr-2"></i>Tanggal Selesai
                            </label>
                            <input 
                                type="date" 
                                name="thakdTglSelesai" 
                                value="<?= htmlspecialchars($old['thakdTglSelesai'] ?? '') ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-toggle-on text-primary-600 mr-2"></i>Status Periode
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="thakdIsAktif" 
                                <?= isset($old['thakdIsAktif']) ? 'checked' : '' ?>
                                class="sr-only peer"
                            >
                            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Set sebagai Aktif</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-2">
                            <i class="fas fa-exclamation-triangle mr-1 text-yellow-500"></i>
                            Hanya boleh ada <b>satu</b> Tahun Akademik yang aktif dalam satu waktu.
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            name="save_ta"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>
                        
                        <a 
                            href="index.php?page=tahun_akademik"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-200"
                        >
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">
        
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-blue-800 mb-2">💡 Tips Format ID</h4>
                    <p class="text-sm text-blue-800 mb-2">Gunakan format <b>YYYY</b> + <b>S</b></p>
                    <ul class="text-sm text-blue-700 space-y-3">
                        <li class="flex items-start bg-white p-2 rounded-lg border border-blue-100">
                            <code class="font-bold text-blue-900 mr-2">20241</code>
                            <span>2024 Semester Ganjil</span>
                        </li>
                        <li class="flex items-start bg-white p-2 rounded-lg border border-blue-100">
                            <code class="font-bold text-blue-900 mr-2">20242</code>
                            <span>2024 Semester Genap</span>
                        </li>
                        <li class="flex items-start bg-white p-2 rounded-lg border border-blue-100">
                            <code class="font-bold text-blue-900 mr-2">20251</code>
                            <span>2025 Semester Ganjil</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
                    <p class="text-sm text-yellow-700">
                        Pastikan tanggal mulai dan selesai tidak bertabrakan dengan tahun akademik lainnya.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>