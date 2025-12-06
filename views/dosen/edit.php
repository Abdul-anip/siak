<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=dosen" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Dosen
            </h1>
            <p class="text-gray-600 mt-1">Perbarui data dosen pada form berikut</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Form Section -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Dosen</h3>
            </div>

            <div class="p-6">

                <?php if (isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3 mt-0.5"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-700 mt-1"><?= $error ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post" action="index.php?page=dosen&aksi=update" class="space-y-6">

                    <input type="hidden" name="dsnNidn" value="<?= $data['dsnNidn'] ?>">

                    <!-- NIDN -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">NIDN</label>
                        <input 
                            type="text"
                            value="<?= htmlspecialchars($data['dsnNidn']) ?>"
                            disabled
                            class="w-full px-4 py-3 bg-gray-200 border-2 border-gray-300 rounded-xl"
                        >
                        <p class="text-xs text-gray-500">NIDN tidak dapat diubah</p>
                    </div>

                    <!-- Gelar Depan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Gelar Depan</label>
                        <input 
                            type="text"
                            name="dsnGelarDepan"
                            value="<?= htmlspecialchars($data['dsnGelarDepan'] ?? '') ?>"
                            placeholder="Contoh: Dr., Ir., Prof."
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input 
                            type="text"
                            name="dsnNama"
                            required
                            value="<?= htmlspecialchars($data['dsnNama']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                    </div>

                    <!-- Gelar Belakang -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Gelar Belakang</label>
                        <input 
                            type="text"
                            name="dsnGelarBelakang"
                            value="<?= htmlspecialchars($data['dsnGelarBelakang'] ?? '') ?>"
                            placeholder="Contoh: S.T., M.T., Ph.D"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                        <select 
                            name="dsnJenisKelaminKode"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                            <option value="L" <?= $data['dsnJenisKelaminKode']=='L'?'selected':'' ?>>Laki-laki</option>
                            <option value="P" <?= $data['dsnJenisKelaminKode']=='P'?'selected':'' ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Jurusan</label>
                        <select 
                            name="dsnJurId"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                            <?php while($j = $jurusan->fetch_assoc()): ?>
                                <option value="<?= $j['jurId'] ?>" 
                                    <?= $j['jurId']==$data['dsnJurId']?'selected':'' ?>>
                                    <?= htmlspecialchars($j['jurNama']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Program Studi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Program Studi</label>
                        <select 
                            name="dsnProdiId"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl"
                        >
                            <?php while($p = $listProdi->fetch_assoc()): ?>
                                <option value="<?= $p['prodiId'] ?>" 
                                    <?= $p['prodiId']==$data['dsnProdiId']?'selected':'' ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button 
                            type="submit" 
                            name="update_dosen"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-1 transition duration-200"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Update Data
                        </button>

                        <a 
                            href="index.php?page=dosen"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300"
                        >
                            <i class="fas fa-times mr-2"></i>
                            Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="lg:col-span-1 space-y-6">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class="fas fa-user-edit text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-blue-800 mb-2">Informasi Edit Dosen</h4>
                    <p class="text-sm text-blue-700">
                        Pastikan data dosen diperbarui dengan benar. Perubahan akan mempengaruhi jadwal dan matakuliah terkait.
                    </p>
                </div>
            </div>
        </div>

    </div>

</div>

<?php include "views/layout/footer.php"; ?>
