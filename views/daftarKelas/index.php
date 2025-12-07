<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Header Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-1">Daftar Data Kelas</h1>
            <p class="text-white/90 text-sm">Cari dan kelola data kelas berdasarkan tahun akademik dan program studi</p>
        </div>
    </div>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6"> 
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                <p class="text-red-700 font-medium"><?= $error ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- FORM PENCARIAN -->
    <form method="get" action="index.php" class="mb-6">
        <input type="hidden" name="page" value="daftarKelas">

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header Form -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-search text-purple-600 text-xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Pencarian Data Kelas</h3>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <!-- TAHUN AKADEMIK -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>
                            Tahun-Semester Akademik <span class="text-red-500">*</span>
                        </label>
                        <select name="thakdId" class="input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" required>
                            <option value="">-- Pilih Tahun-Semester --</option>
                            <?php 
                            $listTa->data_seek(0);
                            while($t = $listTa->fetch_assoc()): 
                                $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                                $tahunDisplay = $t['thakdTahun'] . '/' . ($t['thakdTahun'] + 1) . ' - ' . $semesterLabel;
                                $selected = (isset($thakdId) && $thakdId == $t['thakdId']) ? 'selected' : '';
                            ?>
                                <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($tahunDisplay) ?>
                                    <?= $t['thakdIsAktif'] ? ' 🟢 Aktif' : '' ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <p class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pilih tahun akademik dan semester
                        </p>
                    </div>
                    
                    <!-- PROGRAM STUDI -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-graduation-cap text-indigo-600 mr-2"></i>
                            Program Studi <span class="text-red-500">*</span>
                        </label>
                        <select name="prodiId" class="input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" required>
                            <option value="">-- Pilih Program Studi --</option>
                            <?php 
                            $listProdi->data_seek(0);
                            while($p = $listProdi->fetch_assoc()): 
                                $selected = (isset($prodiId) && $prodiId == $p['prodiId']) ? 'selected' : '';
                            ?>
                                <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                        <p class="text-xs text-gray-500 flex items-center">
                            <i class="fas fa-info-circle mr-1"></i>
                            Pilih program studi yang ingin dicari
                        </p>
                    </div>
                </div>

                <!-- Button -->
                <button class="btn w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center" type="submit" name="cari" value="1">
                    <i class="fas fa-search mr-2"></i>
                    Cari Data Kelas
                </button>
            </div>
        </div>
    </form>

    <!-- HASIL PENCARIAN -->
    <?php if (isset($_GET['cari']) && $rows !== null): ?>

        <!-- Info Badge -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-info-circle text-blue-500 text-xl mr-3"></i>
                <div>
                    <p class="text-sm font-semibold text-blue-800">Menampilkan hasil pencarian</p>
                    <p class="text-xs text-blue-600 mt-1">
                        Tahun Akademik: <strong><?= isset($thakdId) ? htmlspecialchars($thakdId) : '-' ?></strong> | 
                        Program Studi: <strong><?= isset($prodiId) ? htmlspecialchars($prodiId) : '-' ?></strong>
                    </p>
                </div>
            </div>
        </div>

        <?php if ($rows->num_rows > 0): ?>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <?php 
                $totalMhs = 0;
                $totalDosen = 0;
                $totalMK = 0;
                $totalSKS = 0;
                $totalJam = 0;
                $tempRows = $rows;
                $tempRows->data_seek(0);
                while($r = $tempRows->fetch_assoc()): 
                    $totalMhs += $r['JlhMahasiswa'];
                    $totalDosen += $r['JlhDosen'];
                    $totalMK += $r['JlhMK'];
                    $totalSKS += $r['JlhSKS'];
                    $totalJam += $r['JlhJam'];
                endwhile;
                ?>
                
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-4 text-white shadow-lg">
                    <div class="text-3xl font-bold mb-1"><?= $rows->num_rows ?></div>
                    <div class="text-sm opacity-90">Total Kelas</div>
                </div>
                
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
                    <div class="text-3xl font-bold mb-1"><?= $totalMhs ?></div>
                    <div class="text-sm opacity-90">Mahasiswa</div>
                </div>
                
                <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-4 text-white shadow-lg">
                    <div class="text-3xl font-bold mb-1"><?= $totalSKS ?></div>
                    <div class="text-sm opacity-90">Total SKS</div>
                </div>
                
                <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-4 text-white shadow-lg">
                    <div class="text-3xl font-bold mb-1"><?= $totalMK ?></div>
                    <div class="text-sm opacity-90">Mata Kuliah</div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="table w-full">
                        <thead>
                            <tr class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                                <th class="px-6 py-4 text-center text-sm font-bold" style="width:60px;">No.</th>
                                <th class="px-6 py-4 text-left text-sm font-bold">Nama Kelas</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">Mahasiswa</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">Dosen</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">MK</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">SKS</th>
                                <th class="px-6 py-4 text-center text-sm font-bold">Jam</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            <?php 
                            $no = 1; 
                            $rows->data_seek(0);
                            while($r = $rows->fetch_assoc()): 
                            ?>
                            <tr class="hover:bg-purple-50 transition duration-200">
                                <td class="px-6 py-4 text-center text-sm font-semibold text-gray-700"><?= $no++ ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-500 rounded-lg flex items-center justify-center text-white font-bold mr-3">
                                            <?= substr($r['NamaKelas'], 0, 1) ?>
                                        </div>
                                        <span class="font-semibold text-gray-800"><?= htmlspecialchars($r['NamaKelas']) ?></span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                        <i class="fas fa-users mr-1"></i>
                                        <?= $r['JlhMahasiswa'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                                        <?= $r['JlhDosen'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                        <?= $r['JlhMK'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                        <?= $r['JlhSKS'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-pink-100 text-pink-700">
                                        <?= $r['JlhJam'] ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                            
                            <!-- TOTAL ROW -->
                            <tr class="bg-gradient-to-r from-purple-50 to-indigo-50 font-bold">
                                <td colspan="2" class="px-6 py-4 text-right text-sm font-bold text-gray-800">TOTAL:</td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-blue-700"><?= $totalMhs ?></td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-green-700"><?= $totalDosen ?></td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-purple-700"><?= $totalMK ?></td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-orange-700"><?= $totalSKS ?></td>
                                <td class="px-6 py-4 text-center text-sm font-bold text-pink-700"><?= $totalJam ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Success Message -->
            <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mt-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
                    <p class="text-sm font-semibold text-green-800">
                        Ditemukan <strong><?= $rows->num_rows ?></strong> kelas
                    </p>
                </div>
            </div>

        <?php else: ?>
            
            <!-- Empty State -->
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
                <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-inbox text-4xl text-yellow-600"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Data Kelas</h3>
                <p class="text-gray-600 mb-6 max-w-md mx-auto">
                    Tidak ditemukan kelas untuk kombinasi Tahun Akademik dan Program Studi yang dipilih.
                </p>
                <a href="index.php?page=kelas&aksi=tambah" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Kelas Baru
                </a>
            </div>

        <?php endif; ?>

    <?php elseif(isset($_GET['cari'])): ?>
        
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 text-xl mr-3"></i>
                <p class="text-sm font-semibold text-red-800">Silakan isi form pencarian dengan lengkap!</p>
            </div>
        </div>

    <?php endif; ?>

</div>

<style>
/* Custom Scrollbar */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #a855f7;
    border-radius: 10px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #9333ea;
}

/* Table Hover Animation */
tbody tr {
    transition: all 0.2s ease;
}

tbody tr:hover {
    transform: scale(1.01);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

/* Focus States */
select:focus, input:focus {
    outline: none;
}
</style>

<?php include "views/layout/footer.php"; ?>