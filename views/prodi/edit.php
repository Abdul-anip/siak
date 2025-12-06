<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=prodi" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <!-- EDIT MODE -->
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Program Studi
            </h1>
            <p class="text-gray-600 mt-1">Perbarui data Program Studi di bawah ini</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM SECTION -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- Form Header -->
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Program Studi</h3>
            </div>

            <div class="p-6">

                <!-- ERROR MESSAGE -->
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

                <form method="post" action="index.php?page=prodi&aksi=update" class="space-y-6">

                    <!-- ID -->
                    <input type="hidden" name="prodiId" value="<?= $data['prodiId'] ?>">

                    <!-- Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-folder-tree text-primary-600 mr-2"></i>
                            Jurusan
                        </label>
                        <select 
                            name="prodiJurId"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
                        >
                            <option value="0">-- Pilih Jurusan --</option>
                            <?php while($j = $jurusan->fetch_assoc()): ?>
                            <option value="<?= $j['jurId'] ?>"
                                <?= $j['jurId'] == $data['prodiJurId'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($j['jurNama']) ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Kode -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-barcode text-primary-600 mr-2"></i>
                            Kode Prodi
                        </label>
                        <input 
                            type="text"
                            name="prodiKode"
                            value="<?= htmlspecialchars($data['prodiKode']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
                        >
                    </div>

                    <!-- Nama Prodi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-graduation-cap text-primary-600 mr-2"></i>
                            Nama Program Studi <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text"
                            name="prodiNama"
                            required
                            value="<?= htmlspecialchars($data['prodiNama']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
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
                            value="<?= htmlspecialchars($data['prodiJenjang']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
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
                            value="<?= htmlspecialchars($data['prodiEmail']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
                        >
                    </div>

                    <!-- Website -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-globe text-primary-600 mr-2"></i>
                            Website
                        </label>
                        <input 
                            type="text"
                            name="prodiWebsite"
                            value="<?= htmlspecialchars($data['prodiWebsite']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 
                                   focus:ring-primary-100 transition duration-200 outline-none"
                        >
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            <i class="fas fa-toggle-on text-primary-600 mr-2"></i>
                            Status Program Studi
                        </label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="prodiIsAktif"
                                <?= $data['prodiIsAktif'] ? 'checked' : '' ?>
                                class="sr-only peer"
                            >
                            <div class="w-14 h-7 bg-gray-300 peer-focus:ring-4 peer-focus:ring-primary-200 
                                        rounded-full peer peer-checked:bg-primary-600 peer-checked:after:translate-x-full 
                                        after:content-[''] after:absolute after:top-0.5 after:left-[4px] 
                                        after:bg-white after:border-gray-300 after:border after:rounded-full 
                                        after:h-6 after:w-6 after:transition-all"></div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Data Aktif</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">

                        <button 
                            type="submit" 
                            name="update_prodi"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gradient-to-r from-primary-600 to-secondary-600 
                                   text-white font-semibold rounded-xl shadow-lg 
                                   hover:shadow-xl hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i> Update Data
                        </button>

                        <a 
                            href="index.php?page=prodi"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gray-200 text-gray-700 font-semibold rounded-xl 
                                   hover:bg-gray-300 transition duration-200"
                        >
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1 space-y-6">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-800 mb-2">💡 Tips Pengisian</h4>
            <ul class="text-sm text-blue-700 space-y-2">
                <li><i class="fas fa-check-circle mr-2"></i>Pastikan data benar sebelum update</li>
                <li><i class="fas fa-check-circle mr-2"></i>Email & website opsional</li>
                <li><i class="fas fa-check-circle mr-2"></i>Status aktif menentukan penggunaan prodi</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
            <p class="text-sm text-yellow-700">
                Perubahan data Program Studi akan mempengaruhi kelas dan mahasiswa terkait.
            </p>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>
