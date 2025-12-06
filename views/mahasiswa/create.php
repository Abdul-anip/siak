<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=mahasiswa" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-user-plus text-primary-600 mr-3"></i>Tambah Mahasiswa
            </h1>
            <p class="text-gray-600 mt-1">Isi formulir di bawah untuk mendaftarkan mahasiswa baru</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            
            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Data Mahasiswa</h3>
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

                <form method="post" action="index.php?page=mahasiswa&aksi=save" class="space-y-6">

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-id-card text-primary-600 mr-2"></i>NIM <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="mhsNim" value="<?= $old['mhsNim'] ?? '' ?>" required
                            placeholder="Contoh: 23010920"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user text-primary-600 mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="mhsNama" value="<?= $old['mhsNama'] ?? '' ?>" required
                            placeholder="Masukkan nama lengkap"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>Tempat Lahir
                            </label>
                            <input type="text" name="mhsTempatLahir" value="<?= $old['mhsTempatLahir'] ?? '' ?>"
                                placeholder="Kota Lahir"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar text-primary-600 mr-2"></i>Tanggal Lahir
                            </label>
                            <input type="date" name="mhsTglLahir" value="<?= $old['mhsTglLahir'] ?? '' ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-venus-mars text-primary-600 mr-2"></i>Jenis Kelamin
                        </label>
                        <select name="mhsJenisKelamin"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                            <option value="L" <?= (isset($old['mhsJenisKelamin']) && $old['mhsJenisKelamin'] == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="P" <?= (isset($old['mhsJenisKelamin']) && $old['mhsJenisKelamin'] == 'P') ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-4">Data Akademik</h4>
                        
                        <div class="space-y-2 mb-4">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-university text-primary-600 mr-2"></i>Jurusan <span class="text-red-500">*</span>
                            </label>
                            <select name="mhsJurId" id="jurusan-select" required
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                                <option value="">-- Pilih Jurusan --</option>
                                <?php
                                /** @var mysqli_result $jurusan */
                                if(isset($jurusan)) {
                                    $jurusan->data_seek(0);
                                    while($j = $jurusan->fetch_assoc()): ?>
                                        <option value="<?= $j['jurId'] ?>" <?= (isset($old['mhsJurId']) && $old['mhsJurId'] == $j['jurId']) ? 'selected' : '' ?>>
                                            <?= $j['jurNama'] ?>
                                        </option>
                                <?php endwhile; 
                                } ?>
                            </select>
                        </div>

                        <div class="space-y-2 mb-4">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-graduation-cap text-primary-600 mr-2"></i>Program Studi <span class="text-red-500">*</span>
                            </label>
                            <select name="mhsProdiId" id="prodi-select" required disabled
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none disabled:bg-gray-200 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Jurusan Terlebih Dahulu --</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-users text-primary-600 mr-2"></i>Kelas <span class="text-red-500">*</span>
                            </label>
                            <select name="klsId" id="kelas-select" required disabled
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none disabled:bg-gray-200 disabled:cursor-not-allowed">
                                <option value="">-- Pilih Prodi Terlebih Dahulu --</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" name="save_mahasiswa"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>
                        <a href="index.php?page=mahasiswa"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition duration-200">
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
                    <h4 class="font-bold text-blue-800 mb-2">💡 Tips Pengisian</h4>
                    <ul class="text-sm text-blue-700 space-y-2">
                        <li class="flex items-start"><i class="fas fa-check-circle mr-2 mt-0.5"></i><span>Pastikan NIM unik (belum terdaftar).</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle mr-2 mt-0.5"></i><span>Pilih Jurusan terlebih dahulu untuk memunculkan Prodi.</span></li>
                        <li class="flex items-start"><i class="fas fa-check-circle mr-2 mt-0.5"></i><span>Data yang disimpan akan langsung aktif.</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('jurusan-select');
        const prodiSelect = document.getElementById('prodi-select');
        const kelasSelect = document.getElementById('kelas-select');
        
        // Data lama untuk mempertahankan nilai setelah error (Sticky Form)
        // Kita ambil value dari PHP dan masukkan ke variabel JS
        const oldJurusanId = jurusanSelect.value; 
        const oldProdiId = '<?= $old['mhsProdiId'] ?? '' ?>';
        const oldKelasId = '<?= $old['klsId'] ?? '' ?>'; 
        
        // FUNGSI 1: Memuat Opsi Kelas
        function updateKelasOptions(prodiId, selectedKelasId = '') {
            kelasSelect.innerHTML = '<option value="">Memuat...</option>';
            kelasSelect.disabled = true;

            if (prodiId === "" || prodiId === "0") {
                kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listKelasByProdi&prodiId=${prodiId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '';
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '';
                    defaultOpt.textContent = '-- Pilih Kelas --';
                    kelasSelect.appendChild(defaultOpt);

                    if (data.kelas && data.kelas.length > 0) {
                        data.kelas.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.id;
                            option.textContent = kelas.nama;
                            if (kelas.id == selectedKelasId) {
                                option.selected = true;
                            }
                            kelasSelect.appendChild(option);
                        });
                        kelasSelect.disabled = false;
                        kelasSelect.classList.remove('bg-gray-200', 'cursor-not-allowed'); // Hapus style disabled
                    } else {
                        kelasSelect.innerHTML = '<option value="">-- Tidak ada Kelas Aktif --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching kelas:', error);
                    kelasSelect.innerHTML = '<option value="">-- Error memuat data --</option>';
                });
        }
        
        // FUNGSI 2: Memuat Opsi Prodi (Pemicu Kelas)
        function updateProdiOptions(jurId, selectedProdiId = '') {
            prodiSelect.innerHTML = '<option value="">Memuat...</option>';
            prodiSelect.disabled = true;
            
            // Reset Kelas juga jika Jurusan berubah
            kelasSelect.innerHTML = '<option value="">-- Pilih Prodi Terlebih Dahulu --</option>';
            kelasSelect.disabled = true;
            kelasSelect.classList.add('bg-gray-200', 'cursor-not-allowed');

            if (jurId === "" || jurId === "0") {
                prodiSelect.innerHTML = '<option value="">-- Pilih Jurusan Terlebih Dahulu --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listByJurusan&jurId=${jurId}`)
                .then(response => response.json())
                .then(data => {
                    prodiSelect.innerHTML = '';
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '';
                    defaultOpt.textContent = '-- Pilih Prodi --';
                    prodiSelect.appendChild(defaultOpt);

                    if (data.prodis && data.prodis.length > 0) {
                        data.prodis.forEach(prodi => {
                            const option = document.createElement('option');
                            option.value = prodi.id;
                            option.textContent = prodi.label;
                            if (prodi.id == selectedProdiId) {
                                option.selected = true;
                            }
                            prodiSelect.appendChild(option);
                        });
                        prodiSelect.disabled = false;
                        prodiSelect.classList.remove('bg-gray-200', 'cursor-not-allowed');

                        // CHAINING: Jika Prodi dipilih (karena data lama), muat Kelas
                        if (selectedProdiId) {
                            updateKelasOptions(selectedProdiId, oldKelasId);
                        }

                    } else {
                        prodiSelect.innerHTML = '<option value="">-- Tidak ada Prodi --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching prodi:', error);
                    prodiSelect.innerHTML = '<option value="">-- Error memuat data --</option>';
                });
        }
        
        // Event Listeners
        jurusanSelect.addEventListener('change', function() {
            updateProdiOptions(this.value); 
        });

        prodiSelect.addEventListener('change', function() {
            updateKelasOptions(this.value);
        });

        // Initial Load Logic
        if (oldJurusanId) {
            updateProdiOptions(oldJurusanId, oldProdiId);
        }
    });
</script>

<?php include "views/layout/footer.php"; ?>