<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=kelas" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-plus-circle text-primary-600 mr-3"></i>
                Tambah Kelas
            </h1>
            <p class="text-gray-600 mt-1">Lengkapi form di bawah untuk menambahkan kelas baru</p>
        </div>
    </div>
</div>


<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- FORM SECTION -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <!-- FORM HEADER -->
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Data Kelas</h3>
            </div>

            <!-- FORM CONTENT -->
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


                <form method="post" action="index.php?page=kelas&aksi=save" class="space-y-6">


                    <!-- Tahun Akademik -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar text-primary-600 mr-2"></i>
                            Tahun Akademik <span class="text-red-500">*</span>
                        </label>

                        <select name="klsThakdId" required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none">
                            <option value="0">-- Pilih Tahun Akademik --</option>

                            <?php while($t = $listTahunAkademik->fetch_assoc()): 
                                $selected = (isset($old['klsThakdId']) && $old['klsThakdId'] == $t['thakdId']) ? 'selected' : '';
                                $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                            ?>
                                <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                    <?= $t['thakdTahun'] ?> - <?= $semesterLabel ?>
                                    <?= $t['thakdIsAktif'] ? ' (Aktif)' : '' ?>
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Pilih tahun akademik aktif untuk kelas ini
                        </p>
                    </div>


                    <!-- Program Studi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-primary-600 mr-2"></i>
                            Program Studi <span class="text-red-500">*</span>
                        </label>

                        <select name="klsProdiId" required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none">
                            <option value="0">-- Pilih Program Studi --</option>

                            <?php while($p = $listProdi->fetch_assoc()): 
                                $selected = (isset($old['klsProdiId']) && $old['klsProdiId'] == $p['prodiId']) ? 'selected' : '';
                            ?>
                                <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>

                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>Pilih program studi untuk kelas ini
                        </p>
                    </div>


                    <!-- Nama Kelas -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-door-open text-primary-600 mr-2"></i>
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>

                        <input 
                            type="text"
                            name="klsNama"
                            placeholder="Contoh: III.A, II.B, I.C"
                            required
                            value="<?= $old['klsNama'] ?? '' ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl 
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none"
                        >

                        <p class="text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Format: <strong>Tingkat.Kelas</strong> contoh <strong>III.A</strong>
                        </p>
                    </div>


                    <!-- BUTTONS -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" name="save_kelas"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gradient-to-r from-primary-600 to-secondary-600 
                                   text-white font-semibold rounded-xl shadow-lg 
                                   hover:shadow-xl hover:-translate-y-1 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>

                        <a href="index.php?page=kelas"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gray-200 text-gray-700 font-semibold rounded-xl 
                                   hover:bg-gray-300 transition duration-200">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- INFO SIDEBAR -->
    <div class="lg:col-span-1 space-y-6">

        <!-- Tips -->
        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-lightbulb text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-blue-800 mb-2">💡 Tips Penamaan</h4>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li><i class="fas fa-check-circle mr-2"></i>Gunakan format <strong>Tingkat.Kelas</strong></li>
                        <li><i class="fas fa-check-circle mr-2"></i>Contoh: <code>I.A</code>, <code>III.C</code></li>
                        <li><i class="fas fa-check-circle mr-2"></i>Tingkat memakai angka Romawi</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Warning -->
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
                    <p class="text-sm text-yellow-700">
                        Pastikan Anda memilih Tahun Akademik dan Prodi yang benar. Perubahan kelas akan mempengaruhi mahasiswa dan mata kuliah di dalamnya.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>
