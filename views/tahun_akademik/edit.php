<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=tahun_akademik" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Tahun Akademik
            </h1>
            <p class="text-gray-600 mt-1">Perbarui informasi periode akademik</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Data</h3>
            </div>

            <div class="p-6">

                <form method="post" action="index.php?page=tahun_akademik&aksi=update" class="space-y-6">

                    <input type="hidden" name="taId" value="<?= $data['taId'] ?>">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-tag text-primary-600 mr-2"></i>Kode Tahun Akademik <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="taKode" 
                                value="<?= htmlspecialchars($data['taKode']) ?>" 
                                required
                                placeholder="Contoh: 2024/2025"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                            <p class="text-xs text-gray-500 mt-1">Format tampilan, contoh: 2024/2025</p>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-list-ol text-primary-600 mr-2"></i>Semester <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="taSemester" 
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                            >
                                <option value="Ganjil" <?= $data['taSemester']=='Ganjil'?'selected':'' ?>>Ganjil</option>
                                <option value="Genap" <?= $data['taSemester']=='Genap'?'selected':'' ?>>Genap</option>
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2 pt-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-toggle-on text-primary-600 mr-2"></i>Status Periode
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="taIsAktif" 
                                <?= $data['taIsAktif'] ? 'checked' : '' ?>
                                class="sr-only peer"
                            >
                            <div class="w-14 h-7 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-primary-600"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Periode Aktif</span>
                        </label>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            name="update_ta"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>Update Data
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
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
                    <p class="text-sm text-yellow-700 mb-2">
                        Mengubah status menjadi <b>Non-Aktif</b> dapat mempengaruhi data KRS mahasiswa yang sedang berjalan.
                    </p>
                    <p class="text-sm text-yellow-700">
                        Pastikan hanya ada satu Tahun Akademik yang <b>Aktif</b> pada satu waktu.
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>