<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>



<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=dosen" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-plus-circle text-primary-600 mr-3"></i>Tambah Dosen
            </h1>
            <p class="text-gray-600 mt-1">Lengkapi form berikut untuk menambahkan data dosen baru</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Data Dosen</h3>
            </div>

            <div class="p-6">

                <?php if (isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 rounded-lg p-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                        <div>
                            <p class="text-sm font-medium text-red-800">Terjadi Kesalahan!</p>
                            <p class="text-sm text-red-700 mt-1"><?= $error ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <form method="post" action="index.php?page=dosen&aksi=save" class="space-y-6">

                    <!-- NIDN -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            NIDN <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="dsnNidn" required
                            value="<?= $old['dsnNidn'] ?? '' ?>"
                            placeholder="Contoh: 0006058102"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                        <p class="text-xs text-gray-500"><i class="fas fa-info-circle mr-1"></i>Nomor Induk Dosen Nasional</p>
                    </div>

                    <!-- Gelar Depan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Gelar Depan</label>
                        <input type="text" name="dsnGelarDepan"
                            value="<?= $old['dsnGelarDepan'] ?? '' ?>"
                            placeholder="Contoh: Dr., Prof."
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="dsnNama" required
                            value="<?= $old['dsnNama'] ?? '' ?>"
                            placeholder="Contoh: Ahmad Dahlan"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Gelar Belakang -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Gelar Belakang</label>
                        <input type="text" name="dsnGelarBelakang"
                            value="<?= $old['dsnGelarBelakang'] ?? '' ?>"
                            placeholder="Contoh: S.T., M.T., Ph.D"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Jenis Kelamin</label>
                        <select name="dsnJenisKelaminKode" class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                            <option value="L" <?= ($old['dsnJenisKelaminKode'] ?? '') == 'L' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= ($old['dsnJenisKelaminKode'] ?? '') == 'P' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <!-- Jurusan -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Jurusan</label>
                        <select name="dsnJurId" id="jurusan-select"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl" required>
                            <option value="0">-- Pilih Jurusan --</option>
                            <?php $jurusan->data_seek(0); while($j = $jurusan->fetch_assoc()): ?>
                                <option value="<?= $j['jurId'] ?>" <?= ($old['dsnJurId'] ?? '') == $j['jurId'] ? 'selected' : '' ?>>
                                    <?= $j['jurNama'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Prodi -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Program Studi</label>
                        <select name="dsnProdiId" id="prodi-select"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl" required>
                            <option value="0">-- Pilih Prodi --</option>
                            <?php 
                            $listProdi->data_seek(0); // Reset pointer
                            while($p = $listProdi->fetch_assoc()): 
                            ?>
                                <option value="<?= $p['prodiId'] ?>" <?= ($old['dsnProdiId'] ?? '') == $p['prodiId'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Pilih Kelas (Opsional) -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-chalkboard text-indigo-600 mr-2"></i>
                            Daftarkan ke Kelas (Opsional)
                        </label>
                        <select name="klsId" id="klsId" 
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500">
                            <option value="0">-- Tidak Didaftarkan ke Kelas --</option>
                            <?php if(isset($listKelas)): ?>
                                <?php while($k = $listKelas->fetch_assoc()): ?>
                                    <option value="<?= $k['klsId'] ?>" 
                                            data-prodi="<?= $k['klsProdiId'] ?>"
                                            <?= isset($old['klsId']) && $old['klsId'] == $k['klsId'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($k['kelasLabel']) ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                        <p class="text-xs text-gray-500 flex items-center mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Dosen akan otomatis mengajar <strong>semua matakuliah</strong> yang ada di kelas ini
                        </p>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        
                        <button type="submit" name="save_dosen"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-xl shadow-lg">
                            <i class="fas fa-save mr-2"></i> Simpan Data
                        </button>

                        <a href="index.php?page=dosen"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 rounded-xl">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="lg:col-span-1 space-y-6">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-800 mb-2">💡 Tips Pengisian</h4>
            <ul class="text-sm text-blue-700 space-y-2">
                <li>NIDN wajib 10 digit</li>
                <li>Gelar depan & belakang bersifat opsional</li>
                <li>Prodi muncul setelah memilih jurusan</li>
                <li>Kelas bersifat opsional</li>
            </ul>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
            <p class="text-sm text-yellow-700">Pastikan data dosen benar sebelum menyimpan.</p>
        </div>

    </div>
</div>

<script>
// Filter kelas berdasarkan prodi yang dipilih
document.addEventListener('DOMContentLoaded', function() {
    const prodiSelect = document.querySelector('select[name="dsnProdiId"]');
    const kelasSelect = document.getElementById('klsId');
    
    if (prodiSelect && kelasSelect) {
        // Simpan semua opsi kelas
        const allKelasOptions = Array.from(kelasSelect.options);
        
        prodiSelect.addEventListener('change', function() {
            const selectedProdiId = this.value;
            
            // Reset dropdown kelas
            kelasSelect.innerHTML = '<option value="0">-- Tidak Didaftarkan ke Kelas --</option>';
            
            // Filter kelas berdasarkan prodi
            allKelasOptions.forEach(option => {
                if (option.value === '0' || option.dataset.prodi === selectedProdiId) {
                    kelasSelect.appendChild(option.cloneNode(true));
                }
            });
        });
        
        // Trigger saat pertama kali load (jika ada old value)
        if (prodiSelect.value && prodiSelect.value !== '0') {
            prodiSelect.dispatchEvent(new Event('change'));
        }
    }
});
</script>

<?php include "views/layout/footer.php"; ?>
