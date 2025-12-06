<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- ========================================
     PAGE HEADER
========================================= -->
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=prodi" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-plus-circle text-primary-600 mr-3"></i>Tambah Program Studi
            </h1>
            <p class="text-gray-600 mt-1">Lengkapi form berikut untuk menambahkan Program Studi baru.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- ========================================
         FORM SECTION
    ========================================= -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Data Program Studi</h3>
            </div>

            <div class="p-6">

                <!-- Alert Error -->
                <?php if (isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4 animate-pulse">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-700 mt-1"><?= $error ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post" action="index.php?page=prodi&aksi=save" class="space-y-6">

                    <!-- Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-primary-600 mr-2"></i>
                            Jurusan <span class="text-red-500">*</span>
                        </label>

                        <select 
                            name="prodiJurId"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100
                                   transition duration-200 outline-none"
                        >
                            <option value="0">-- Pilih Jurusan --</option>
                            <?php while($j = $jurusan->fetch_assoc()): ?>
                                <option value="<?= $j['jurId'] ?>">
                                    <?= htmlspecialchars($j['jurNama']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Kode -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-code text-primary-600 mr-2"></i>
                            Kode Prodi
                        </label>
                        <input 
                            type="text"
                            name="prodiKode"
                            placeholder="Contoh: TI-01"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition"
                        >
                    </div>

                    <!-- Nama Prodi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-tag text-primary-600 mr-2"></i>
                            Nama Program Studi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="prodiNama"
                            required
                            placeholder="Contoh: Teknik Informatika"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
                        >
                    </div>

                    <!-- Jenjang -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-layer-group text-primary-600 mr-2"></i>
                            Jenjang
                        </label>
                        <input 
                            type="text"
                            name="prodiJenjang"
                            placeholder="D3 / D4 / S1"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
                        >
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-envelope text-primary-600 mr-2"></i>
                            Email Prodi
                        </label>
                        <input 
                            type="email"
                            name="prodiEmail"
                            placeholder="email@prodi.ac.id"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
                        >
                    </div>

                    <!-- Website -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-globe text-primary-600 mr-2"></i>
                            Website Prodi
                        </label>
                        <input 
                            type="text"
                            name="prodiWebsite"
                            placeholder="https://contoh.ac.id"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100"
                        >
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-toggle-on text-primary-600 mr-2"></i>
                            Status
                        </label>

                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="prodiIsAktif" checked class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-300 rounded-full peer 
                                        peer-checked:bg-primary-600 peer-focus:ring-4 peer-focus:ring-primary-200
                                        after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                        after:bg-white after:border after:rounded-full after:h-6 after:w-6
                                        after:transition-all peer-checked:after:translate-x-full"></div>
                            <span class="ml-3 text-sm text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit"
                            name="save_prodi"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gradient-to-r from-primary-600 to-secondary-600 text-white 
                                   font-semibold rounded-xl shadow-lg hover:shadow-xl transform 
                                   hover:-translate-y-1 transition"
                        >
                            <i class="fas fa-save mr-2"></i> Simpan
                        </button>

                        <a 
                            href="index.php?page=prodi"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition"
                        >
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- SIDEBAR INFO -->
    <div class="lg:col-span-1 space-y-6">

        <!-- Tips -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-800 mb-2">💡 Tips Pengisian</h4>
            <ul class="text-sm text-blue-700 space-y-2">
                <li>Pastikan nama prodi sesuai standar BAN-PT</li>
                <li>Gunakan email resmi prodi</li>
                <li>Website bersifat opsional tetapi dianjurkan</li>
            </ul>
        </div>

        <!-- Warning -->
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
            <p class="text-sm text-yellow-700">
                Perubahan data prodi dapat mempengaruhi relasi kurikulum, kelas, dan matakuliah.
            </p>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>
