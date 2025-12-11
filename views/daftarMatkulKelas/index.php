<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Header Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-1">Daftar Data Matakuliah Kelas</h1>
            <p class="text-white/90 text-sm">
                Cari dan kelola data Matakuliah berdasarkan tahun akademik, program studi, dan kelas
            </p>
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

    <!-- FORM PENCARIAN STEP 1: Pilih Tahun & Prodi -->
    <?php if (!isset($_GET['tahap']) && !isset($_GET['cari'])): ?>
    
    <form method="get" action="index.php" class="mb-6">
        <input type="hidden" name="page" value="daftarMatkulKelas">
        <input type="hidden" name="tahap" value="pilih_kelas">

        <div class="bg-blue-50 border border-blue-100 rounded-2xl shadow-lg overflow-hidden mb-6">
            <!-- Header Form -->
            <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-search text-purple-600 text-xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Pencarian Data Kelas</h3>
                </div>
            </div>

            <!-- Body Form -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    
                    <!-- TAHUN AKADEMIK -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">
                            <i class="fas fa-calendar-alt text-purple-600 mr-2"></i>
                            Tahun-Semester Akademik <span class="text-red-500">*</span>
                        </label>
                        <select name="thakdId" 
                                class="input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" 
                                required>
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
                                    <?= $t['thakdIsAktif'] ? '  Aktif' : '' ?>
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
                        <select name="prodiId" 
                                class="input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                                required>
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
                <button 
                    class="btn w-full bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center" 
                    type="submit" name="cari" value="1">
                    <i class="fas fa-search mr-2"></i>
                    Lanjutkan ke Pilih Kelas
                </button>
            </div>
        </div>
    </form>

    <?php endif; ?>

    <!-- FORM PENCARIAN STEP 2: Pilih Kelas -->
    <?php if (isset($_GET['tahap']) && $_GET['tahap'] == 'pilih_kelas' && isset($listKelas) && $listKelas->num_rows > 0): ?>
    
    <form method="get" action="index.php" class="mb-6">
        <input type="hidden" name="page" value="daftarMatkulKelas">
        <input type="hidden" name="thakdId" value="<?= htmlspecialchars($thakdId) ?>">
        <input type="hidden" name="prodiId" value="<?= htmlspecialchars($prodiId ?? '') ?>">

        <div class="bg-white border border-gray-100 rounded-2xl shadow-lg overflow-hidden mb-6">
            <!-- Header Step 2 -->
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                <div class="flex items-center">
                    <i class="fas fa-layer-group text-indigo-600 text-xl mr-3"></i>
                    <h3 class="text-lg font-bold text-gray-800">Step 2: Pilih Nama Kelas</h3>
                </div>
            </div>

            <!-- Body Step 2 -->
            <div class="p-6 space-y-4">
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">
                        Nama Kelas <span class="text-red-500">*</span>
                    </label>
                    <select name="klsId" 
                            class="input w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" 
                            required>
                        <option value="">-- Pilih Nama Kelas --</option>
                        <?php while($k = $listKelas->fetch_assoc()): ?>
                            <option value="<?= $k['klsId'] ?>">
                                <?= htmlspecialchars($k['klsNama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <p class="text-xs text-gray-500 flex items-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pilih kelas yang ingin dilihat daftar matakuliahnya
                    </p>
                </div>

                <div class="flex flex-col md:flex-row gap-3 mt-4">
                    <button 
                        class="btn flex-1 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center" 
                        type="submit" name="cari" value="1">
                        <i class="fas fa-search mr-2"></i>
                        Tampilkan Daftar Matakuliah
                    </button>
                    <a href="index.php?page=daftarMatkulKelas" 
                       class="btn inline-flex items-center justify-center px-5 py-3 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition duration-200">
                        <i class="fas fa-undo mr-2"></i>
                        Ulangi Pencarian
                    </a>
                </div>
            </div>
        </div>
    </form>

    <?php endif; ?>

    <!-- HASIL PENCARIAN: Tabel Matakuliah -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- INFO KELAS -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg mb-6">
            <div class="flex items-start gap-3">
                <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 mb-2">Informasi Kelas</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-1 text-sm text-blue-900/90">
                        <div class="flex">
                            <span class="w-32 font-semibold">Tahun Akademik</span>
                            <span class="flex-1">: <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?></span>
                        </div>
                        <div class="flex">
                            <span class="w-32 font-semibold">Program Studi</span>
                            <span class="flex-1">: <?= htmlspecialchars($kelasInfo['prodiNama']) ?> (<?= htmlspecialchars($kelasInfo['prodiJenjang']) ?>)</span>
                        </div>
                        <div class="flex">
                            <span class="w-32 font-semibold">Nama Kelas</span>
                            <span class="flex-1">: <?= htmlspecialchars($kelasInfo['klsNama']) ?></span>
                        </div>
                        <div class="flex items-center">
                            <span class="w-32 font-semibold">Total SKS</span>
                            <span class="flex-1">
                                : <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-600 text-white">
                                    <?= $totalSKS ?> SKS
                                  </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TABEL MATAKULIAH -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white">
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-16">No</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Kode</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Nama Matakuliah</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">SKS</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">Semester</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">T/P</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">KMK</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $no = 1; 
                        $totalSKSTable = 0;
                        while($r = $rows->fetch_assoc()): 
                            $totalSKSTable += $r['SKS'];
                            $isTeori = ($r['T_P'] == 'T');
                            $tpBgClass = $isTeori ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700';
                        ?>
                        <tr class="hover:bg-purple-50 transition duration-200">
                            <td class="px-4 py-3 text-center text-sm text-gray-700 font-semibold"><?= $no++ ?></td>
                            <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                                <?= htmlspecialchars($r['mkKode']) ?>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <a href="index.php?page=detailMatkul&id=<?= $r['mkId'] ?>" 
                                class="group inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                    <?= htmlspecialchars($r['mkNama']) ?>
                                    <i class="fas fa-external-link-alt ml-2 text-xs opacity-0 group-hover:opacity-100 transition duration-200"></i>
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center text-sm font-semibold text-gray-800">
                                <?= $r['SKS'] ?>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">
                                <?= $r['Semester'] ?>
                            </td>
                            <td class="px-4 py-3 text-center text-sm">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold <?= $tpBgClass ?>">
                                    <?= $r['T_P'] ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-sm text-gray-700">
                                <?= htmlspecialchars($r['KMK']) ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <!-- TOTAL ROW -->
                        <tr class="bg-gradient-to-r from-purple-50 to-indigo-50 font-bold">
                            <td colspan="3" class="px-4 py-3 text-right text-sm text-gray-800">TOTAL SKS:</td>
                            <td class="px-4 py-3 text-center text-sm text-blue-700 text-base">
                                <?= $totalSKSTable ?>
                            </td>
                            <td colspan="3" class="px-4 py-3"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- FOOTER INFO -->
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mt-6 flex items-center">
            <i class="fas fa-check-circle text-green-500 text-xl mr-3"></i>
            <p class="text-sm text-green-800">
                Ditemukan <strong><?= $rows->num_rows ?></strong> matakuliah | 
                Total <strong><?= $totalSKSTable ?> SKS</strong>
            </p>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="index.php?page=daftarMatkulKelas" 
               class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-search mr-2"></i>
                Cari Kelas Lain
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-print mr-2"></i>
                Cetak
            </button>
        </div>

    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>
        
        <!-- TIDAK ADA DATA MATAKULIAH -->
        <div class="bg-white rounded-2xl shadow-lg p-10 text-center border border-yellow-200">
            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-inbox text-4xl text-yellow-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-yellow-800 mb-3">Tidak Ada Matakuliah</h3>
            <p class="text-yellow-800/90 mb-6 max-w-md mx-auto">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki matakuliah yang terdaftar.
            </p>
            <div class="flex justify-center">
                <a href="index.php?page=daftarMatkulKelas" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Pilih Kelas Lain
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- CSS TAMBAHAN UNTUK PRINT -->
<style>
@media print {
    .sidebar, .topbar .btn, .btn, .bg-gradient-to-r, .bg-blue-50, .bg-green-50 {
        display: none !important;
    }
    
    .content-wrapper {
        margin-left: 0 !important;
        padding: 20px !important;
    }
    
    .card-content {
        box-shadow: none !important;
        border: 1px solid #000;
    }
    
    table {
        page-break-inside: auto;
        width: 100%;
        border-collapse: collapse;
    }

    table th, table td {
        border: 1px solid #000;
        padding: 4px;
        font-size: 11px;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    thead {
        display: table-header-group;
    }
    
    @page {
        margin: 1cm;
    }
}
</style>

<?php include "views/layout/footer.php"; ?>
