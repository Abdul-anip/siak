<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=mahasiswa" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-user-edit text-primary-600 mr-3"></i>Edit Mahasiswa
            </h1>
            <p class="text-gray-600 mt-1">Perbarui data mahasiswa dan status akademik</p>
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

                <form method="post" action="index.php?page=mahasiswa&aksi=update" class="space-y-6">

                    <input type="hidden" name="mhsNim" value="<?= $data['mhsNim'] ?>">

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-id-card text-gray-400 mr-2"></i>NIM
                        </label>
                        <input type="text" value="<?= $data['mhsNim'] ?>" disabled
                            class="w-full px-4 py-3 bg-gray-200 text-gray-500 border-2 border-gray-200 rounded-xl cursor-not-allowed">
                        <p class="text-xs text-gray-400 mt-1"><i class="fas fa-lock mr-1"></i>NIM tidak dapat diubah</p>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-user text-primary-600 mr-2"></i>Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="mhsNama" value="<?= htmlspecialchars($data['mhsNama']) ?>" required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-map-marker-alt text-primary-600 mr-2"></i>Tempat Lahir
                            </label>
                            <input type="text" name="mhsTempatLahir" value="<?= $data['mhsTempatLahir'] ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-calendar text-primary-600 mr-2"></i>Tanggal Lahir
                            </label>
                            <input type="date" name="mhsTglLahir" value="<?= $data['mhsTglLahir'] ?>"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-venus-mars text-primary-600 mr-2"></i>Jenis Kelamin
                        </label>
                        <select name="mhsJenisKelamin"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                            <option value="L" <?= $data['mhsJenisKelamin']=='L'?'selected':'' ?>>Laki-laki</option>
                            <option value="P" <?= $data['mhsJenisKelamin']=='P'?'selected':'' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="border-t border-gray-200 pt-4 mt-4">
                        <h4 class="text-sm uppercase tracking-wide text-gray-500 font-bold mb-4">
                            <i class="fas fa-university mr-2"></i>Data Akademik
                        </h4>
                        
                        <div class="space-y-2 mb-4">
                            <label class="block text-sm font-semibold text-gray-700">Jurusan</label>
                            <select name="mhsJurId"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                                <?php 
                                /** @var mysqli_result $jurusan */
                                if(isset($jurusan)):
                                    $jurusan->data_seek(0);
                                    while($j = $jurusan->fetch_assoc()): ?>
                                        <option value="<?= $j['jurId'] ?>" <?= $j['jurId']==$data['mhsJurId']?'selected':'' ?>>
                                            <?= $j['jurNama'] ?>
                                        </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>

                        <div class="space-y-2 mb-4">
                            <label class="block text-sm font-semibold text-gray-700">Program Studi</label>
                            <select name="mhsProdiId"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                                <?php 
                                if(isset($listProdi)):
                                    while($p = $listProdi->fetch_assoc()): ?>
                                        <option value="<?= $p['prodiId'] ?>" <?= $p['prodiId']==$data['mhsProdiId']?'selected':'' ?>>
                                            <?= $p['prodiNama'] ?>
                                        </option>
                                <?php endwhile; endif; ?>
                            </select>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Kode Kelas</label>
                                <select name="mhsKodeKelas"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                                    <option value="A" <?= $data['mhsKodeKelas']=='A'?'selected':'' ?>>A</option>
                                    <option value="B" <?= $data['mhsKodeKelas']=='B'?'selected':'' ?>>B</option>
                                    <option value="C" <?= $data['mhsKodeKelas']=='C'?'selected':'' ?>>C</option>
                                    <option value="D" <?= $data['mhsKodeKelas']=='D'?'selected':'' ?>>D</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-semibold text-gray-700">Semester Aktif</label>
                                <input type="number" name="mhsSmsAktif" value="<?= $data['mhsSmsAktif'] ?>" min="1" max="14"
                                    class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                            </div>
                        </div>

                        <div class="space-y-2 mt-4">
                            <label class="block text-sm font-semibold text-gray-700">
                                <i class="fas fa-info-circle text-primary-600 mr-2"></i>Status Akademik
                            </label>
                            <select name="mhsStsAkademik"
                                class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none">
                                <option value="A" <?= $data['mhsStsAkademik']=='A'?'selected':'' ?>>🟢 Aktif</option>
                                <option value="L" <?= $data['mhsStsAkademik']=='L'?'selected':'' ?>>🎓 Lulus</option>
                                <option value="C" <?= $data['mhsStsAkademik']=='C'?'selected':'' ?>>🟠 Cuti</option>
                                <option value="D" <?= $data['mhsStsAkademik']=='D'?'selected':'' ?>>🔴 Drop Out (DO)</option>
                                <option value="K" <?= $data['mhsStsAkademik']=='K'?'selected':'' ?>>🚪 Keluar</option>
                                <option value="M" <?= $data['mhsStsAkademik']=='M'?'selected':'' ?>>⚫ Meninggal</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" name="update_mahasiswa"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
                            <i class="fas fa-save mr-2"></i>Update Data
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
        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <div class="flex items-start">
                <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-exclamation-triangle text-white text-xl"></i>
                </div>
                <div class="ml-4">
                    <h4 class="font-bold text-yellow-800 mb-2">⚠️ Perhatian</h4>
                    <p class="text-sm text-yellow-700">
                        Mengubah <b>Status Akademik</b> akan mempengaruhi akses mahasiswa terhadap sistem (KRS/KHS).
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>