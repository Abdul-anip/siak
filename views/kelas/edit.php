<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- ========================================
     PAGE HEADER - EDIT KELAS
======================================== -->
<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=kelas" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Kelas
            </h1>
            <p class="text-gray-600 mt-1">Perbarui data kelas pada form berikut</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <!-- ========================================
         FORM SECTION
    ======================================== -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Kelas</h3>
            </div>

            <div class="p-6">

                <?php if (isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-700 mt-1"><?= $error ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- ========================================
                     FORM START
                ======================================== -->
                <form method="post" action="index.php?page=kelas&aksi=update" class="space-y-6">

                    <!-- hidden ID -->
                    <input type="hidden" name="klsId" value="<?= $data['klsId'] ?>">

                    <!-- Tahun Akademik -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar text-primary-600 mr-2"></i>
                            Tahun Akademik <span class="text-red-500">*</span>
                        </label>

                        <select 
                            name="klsThakdId"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none"
                        >
                            <option value="0">-- Pilih Tahun Akademik --</option>

                            <?php while($t = $listTahunAkademik->fetch_assoc()): ?>
                                <?php 
                                    $selected = ($t['thakdId'] == $data['klsThakdId']) ? 'selected' : '';
                                    $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                                ?>
                                <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                    <?= $t['thakdTahun'] ?> - <?= $semesterLabel ?> 
                                    <?= $t['thakdIsAktif'] ? ' (Aktif)' : '' ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Program Studi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-building text-primary-600 mr-2"></i>
                            Program Studi <span class="text-red-500">*</span>
                        </label>

                        <select 
                            name="klsProdiId"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none"
                        >
                            <option value="0">-- Pilih Program Studi --</option>

                            <?php while($p = $listProdi->fetch_assoc()): ?>
                                <?php $selected = ($p['prodiId'] == $data['klsProdiId']) ? 'selected' : ''; ?>
                                <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?> (<?= $p['prodiJenjang'] ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Nama Kelas -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-chalkboard text-primary-600 mr-2"></i>
                            Nama Kelas <span class="text-red-500">*</span>
                        </label>

                        <input 
                            type="text"
                            name="klsNama"
                            value="<?= htmlspecialchars($data['klsNama']) ?>"
                            required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl
                                   focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 
                                   transition duration-200 outline-none"
                        >
                        <p class="text-xs text-gray-500">
                            Contoh: <b>III.A</b>, <b>IV.B</b>, <b>V.C</b>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">

                        <button 
                            type="submit" 
                            name="update_kelas"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gradient-to-r from-primary-600 to-secondary-600 
                                   text-white font-semibold rounded-xl shadow-lg 
                                   hover:shadow-xl transform hover:-translate-y-1 
                                   transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>Update Data
                        </button>

                        <a 
                            href="index.php?page=kelas"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                                   bg-gray-200 text-gray-700 font-semibold rounded-xl 
                                   hover:bg-gray-300 transition duration-200"
                        >
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- ========================================
         SIDEBAR info
    ======================================== -->
    <div class="lg:col-span-1 space-y-6">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-800 mb-1">ℹ️ Informasi Kelas</h4>
            <p class="text-sm text-blue-700 mb-1">ID Kelas: <b><?= $data['klsId'] ?></b></p>
            <p class="text-sm text-blue-700">
                Jumlah Mahasiswa: 
                <b><?= $kelas->countMahasiswa($data['klsId']) ?></b> mahasiswa
            </p>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
            <p class="text-sm text-yellow-700">
                Pastikan data sudah benar sebelum menyimpan. Perubahan akan mempengaruhi seluruh sistem akademik.
            </p>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>
