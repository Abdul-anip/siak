<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Header Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-1">Daftar Data Dosen Kelas</h1>
            <p class="text-white/90 text-sm">
                Cari dan kelola data dosen pengampu berdasarkan tahun akademik, program studi, dan kelas
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

    <!-- FORM PENCARIAN - LENGKAP -->
    <?php if (!isset($_GET['cari'])): ?>
    
    <form method="get" action="index.php" class="mb-6">
        <input type="hidden" name="page" value="daftarDosenKelas">

        <div class="bg-purple-50 border border-purple-100 rounded-2xl shadow-lg p-6 mb-6">
            <h3 class="text-center text-lg font-bold text-purple-900 mb-6">
                Pencarian Daftar Data Dosen Kelas Berdasarkan:
            </h3>
            
            <!-- ROW 1: Tahun Akademik & Semester -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <label class="md:w-52 text-sm font-semibold text-gray-700 md:text-right">
                    Thn-Smt Akademik
                </label>
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <!-- Tahun -->
                    <select name="thakdId" 
                            class="input w-full sm:w-52 px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" 
                            required>
                        <option value="">-- Pilih Tahun Akademik --</option>
                        <?php 
                        $listTa->data_seek(0);
                        while($t = $listTa->fetch_assoc()): 
                            $tahunDisplay = $t['thakdTahun'] . '/' . ($t['thakdTahun'] + 1);
                            $selected = (isset($thakdId) && $thakdId == $t['thakdId']) ? 'selected' : '';
                        ?>
                            <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($tahunDisplay) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    
                    <!-- Semester -->
                    <select name="semester" 
                            class="input w-full sm:w-40 px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
                        <option value="">-- Pilih Semester --</option>
                        <option value="1" <?= (isset($semester) && $semester == '1') ? 'selected' : '' ?>>Ganjil</option>
                        <option value="2" <?= (isset($semester) && $semester == '2') ? 'selected' : '' ?>>Genap</option>
                    </select>
                </div>
            </div>
            
            <!-- ROW 2: Program Studi -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <label class="md:w-52 text-sm font-semibold text-gray-700 md:text-right">
                    Program Studi
                </label>
                <select name="prodiId" 
                        class="input w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200" 
                        required>
                    <option value="">-- Pilih Program Studi --</option>
                    <?php 
                    $listProdi->data_seek(0);
                    while($p = $listProdi->fetch_assoc()): 
                        $selected = (isset($prodiId) && $prodiId == $p['prodiId']) ? 'selected' : '';
                    ?>
                        <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($p['prodiKode'] . ' - ' . $p['prodiNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <!-- ROW 3: Nama Kelas -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <label class="md:w-52 text-sm font-semibold text-gray-700 md:text-right">
                    Nama Kelas
                </label>
                <select name="klsId" 
                        class="input w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200" 
                        required 
                        id="kelasSelect">
                    <option value="">-- Pilih Kelas --</option>
                    <?php if(isset($listKelas)): ?>
                        <?php while($k = $listKelas->fetch_assoc()): ?>
                            <option value="<?= $k['klsId'] ?>">
                                <?= htmlspecialchars($k['klsNama']) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- TOMBOL CARI -->
            <div class="mt-6 flex justify-center">
                <button class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 text-green-950 font-bold px-10 py-3 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center" 
                        type="submit" name="cari" value="1">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
            </div>
        </div>
    </form>

    <?php endif; ?>

    <!-- HASIL PENCARIAN: Tabel Dosen -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- HEADER INFO KELAS & STATISTIK -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-purple-100">
            <h3 class="text-center text-lg font-bold text-purple-900 mb-2">
                Data Dosen Kelas <?= htmlspecialchars($kelasInfo['klsNama']) ?> 
            </h3>
            <p class="text-center text-sm text-gray-600 mb-6">
                Tahun Akademik <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?>
            </p>
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $totalDosen ?></div>
                    <div class="text-sm opacity-90">Total Dosen</div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-sky-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $totalMatakuliah ?></div>
                    <div class="text-sm opacity-90">Total Matakuliah</div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $rows->num_rows ?></div>
                    <div class="text-sm opacity-90">Total Pengampu</div>
                </div>
            </div>
        </div>

        <!-- TABEL DOSEN -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900">
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-16">No.</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Nama Dosen</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Matakuliah</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-28">Kode</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">SKS</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">Jam</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-28">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $no = 1; 
                        $rows->data_seek(0); // Reset pointer
                        while($r = $rows->fetch_assoc()):
                             
                            // Format nama dosen dengan gelar
                            $namaDosen = '';
                            if (!empty($r['dsnGelarDepan'])) {
                                $namaDosen .= $r['dsnGelarDepan'] . ' ';
                            }
                            $namaDosen .= $r['dsnNama'];
                            if (!empty($r['dsnGelarBelakang'])) {
                                $namaDosen .= ', ' . $r['dsnGelarBelakang'];
                            }

                            $isAktif = ($r['Status'] == 'Aktif');
                            $statusClass = $isAktif 
                                ? 'bg-green-100 text-green-700' 
                                : 'bg-red-100 text-red-700';
                        ?>
                        <tr class="hover:bg-purple-50 transition duration-200">
                            <td data-label="No." class="px-4 py-3 text-center text-sm text-gray-700 font-semibold">
                                <?= $no++ ?>
                            </td>
                            <td data-label="Nama Dosen" class="px-4 py-3 text-sm">
                                <a href="index.php?page=detailDosen&nidn=<?= htmlspecialchars($r['dsnNidn']) ?>" 
                                   class="group inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                    <span class="font-semibold text-indigo-700">
                                        <?= htmlspecialchars($namaDosen) ?>
                                    </span>
                                    <i class="fas fa-external-link-alt ml-2 text-xs opacity-0 group-hover:opacity-100 transition duration-200"></i>
                               
                            </td>
                            <td data-label="Matakuliah" class="px-4 py-3 text-sm text-gray-700">
                                <?= htmlspecialchars($r['mkNama']) ?>
                            </td>
                            <td data-label="Kode" class="px-4 py-3 text-center text-sm">
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-md bg-blue-50 text-blue-700 font-semibold text-xs">
                                    <?= htmlspecialchars($r['mkKode']) ?>
                                </span>
                            </td>
                            <td data-label="SKS" class="px-4 py-3 text-center text-sm font-semibold text-gray-800">
                                
                            <?= $r['mkSks'] ?>
                            </td>
                            <td data-label="Jam" class="px-4 py-3 text-center text-sm text-gray-700">
                                
                                <?= $r['mkSks'] ?>
                            </td>
                            <td data-label="Status" class="px-4 py-3 text-center text-sm">
                            <?php
                            $isAktif = ($r['Status'] == 'Aktif');
                            $statusClass = $isAktif 
                                ? 'bg-green-100 text-green-700' 
                                : 'bg-red-100 text-red-700';
                            ?>
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                <?= $r['Status'] ?>
                            </span>
                        </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- FOOTER ACTIONS -->
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="index.php?page=daftarDosenKelas" 
               class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-search mr-2"></i>
                Cari Kelas Lain
            </a>
            <button onclick="window.print()" 
                    class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-print mr-2"></i>
                Cetak
            </button>
            <button onclick="exportToExcel()" 
                    class="inline-flex items-center px-5 py-3 bg-amber-500 hover:bg-amber-600 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-file-excel mr-2"></i>
                Export Excel
            </button>
            <button onclick="exportToPDF()" 
                    class="inline-flex items-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                <i class="fas fa-file-pdf mr-2"></i>
                Export PDF
            </button>
        </div>

    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>
        
        <!-- TIDAK ADA DATA DOSEN -->
        <div class="bg-white rounded-2xl shadow-lg p-10 text-center border border-yellow-200">
            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user-slash text-4xl text-yellow-700"></i>
            </div>
            <h3 class="text-2xl font-bold text-yellow-800 mb-3">Tidak Ada Dosen</h3>
            <p class="text-yellow-800/90 mb-6 max-w-md mx-auto">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki dosen yang terdaftar.
            </p>
            <div class="flex justify-center">
                <a href="index.php?page=daftarDosenKelas" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Pilih Kelas Lain
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- JAVASCRIPT UNTUK DYNAMIC DROPDOWN -->
<script>
// Auto-load kelas saat prodi atau tahun dipilih (opsional redirect)
document.addEventListener('DOMContentLoaded', function() {
    const prodiSelect = document.querySelector('select[name="prodiId"]');
    const thakdSelect = document.querySelector('select[name="thakdId"]');
    const kelasSelect = document.getElementById('kelasSelect');
    
    if (prodiSelect && thakdSelect && kelasSelect) {
        prodiSelect.addEventListener('change', loadKelas);
        thakdSelect.addEventListener('change', loadKelas);
    }
    
    function loadKelas() {
        const thakdId = thakdSelect.value;
        const prodiId = prodiSelect.value;
        
        if (thakdId && prodiId) {
            // Redirect dengan parameter untuk load kelas
            window.location.href = `index.php?page=daftarDosenKelas&tahap=pilih_kelas&thakdId=${thakdId}&prodiId=${prodiId}`;
        }
    }
});
<?php if (isset($kelasInfo)): ?>
// Export to Excel function
function exportToExcel() {
    const table = document.querySelector('.table');
    const kelasName = '<?= htmlspecialchars($kelasInfo['klsNama'] ?? 'Kelas') ?>';
    const ta = '<?= htmlspecialchars($kelasInfo['tahunAkademikLabel'] ?? '') ?>';
    
    if (!table) return;
    
    const html = table.outerHTML;
    const blob = new Blob(['\ufeff', html], {
        type: 'application/vnd.ms-excel'
    });
    
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `Daftar_Dosen_${kelasName}_${ta}.xls`;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Export to PDF (simple version using print)
function exportToPDF() {
    window.print();
}
<?php endif; ?>
</script>

<!-- CSS TAMBAHAN UNTUK PRINT & RESPONSIVE TABLE -->
<style>
@media print {
    .sidebar, .topbar .btn, .btn, form {
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
    
    tbody tr:nth-child(even) {
        background: #f9f9f9 !important;
    }
    
    @page {
        margin: 1cm;
        size: landscape;
    }
}

/* Responsive Table */
@media (max-width: 860px) {
    .table thead {
        display: none;
    }
    
    .table,
    .table tbody,
    .table tr,
    .table td {
        display: block;
        width: 100%;
    }
    
    .table tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background: #ffffff;
    }
    
    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
        padding: 8px 10px;
        font-size: 13px;
    }
    
    .table td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 45%;
        font-weight: 600;
        text-align: left;
        color: #6A1B9A;
    }
}
</style>

<?php include "views/layout/footer.php"; ?>
