<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- HEADER SECTION -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-bold mb-1">Daftar Data Mahasiswa Kelas</h1>
            <p class="text-white/90 text-sm">
                Cari dan kelola data mahasiswa per kelas berdasarkan tahun akademik, program studi, dan kelas
            </p>
        </div>
        <div class="hidden md:block">
            <span class="px-4 py-2 rounded-lg bg-white/15 text-white text-sm font-medium border border-white/30 flex items-center gap-2">
                <i class="fas fa-user-graduate"></i>
                Kemahasiswaan
            </span>
        </div>
    </div>
</div>

<div class="card-content">

    <!-- ERROR MESSAGE -->
    <?php if (isset($error)): ?>
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-6">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 text-xl mr-3"></i>
                <p class="text-red-700 font-medium"><?= $error ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- ================================================== -->
    <!-- FORM PENCARIAN -->
    <!-- ================================================== -->
    <?php if (!isset($_GET['cari'])): ?>

    <form method="get" action="index.php" class="mb-6">
        <input type="hidden" name="page" value="daftarMahasiswaKelas">

        <div class="bg-purple-50 border border-purple-100 rounded-2xl shadow-lg p-6 mb-6">
            <h3 class="text-center text-lg font-bold text-purple-900 mb-6">
                Pencarian Daftar Data Mahasiswa Kelas Berdasarkan:
            </h3>

            <!-- ROW 1: Tahun Akademik & Semester -->
            <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                <label class="md:w-52 text-sm font-semibold text-gray-700 md:text-right">
                    Thn-Smt Akademik
                </label>
                <div class="flex flex-col sm:flex-row gap-3 w-full">
                    <!-- Tahun Akademik -->
                    <select name="thakdId"
                            class="input w-full sm:w-52 px-4 py-2.5 border-2 border-gray-200 rounded-xl 
                                   focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
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
                            class="input w-full sm:w-40 px-4 py-2.5 border-2 border-gray-200 rounded-xl 
                                   focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200">
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
                        class="input w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl 
                               focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition duration-200"
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
                        class="input w-full px-4 py-2.5 border-2 border-gray-200 rounded-xl 
                               focus:ring-2 focus:ring-purple-500 focus:border-transparent transition duration-200"
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

            <!-- BUTTON CARI -->
            <div class="mt-6 flex justify-center">
                <button class="btn bg-gradient-to-r from-green-500 to-lime-500 hover:from-green-600 hover:to-lime-600 
                               text-green-950 font-bold px-10 py-3 rounded-xl shadow-lg hover:shadow-xl 
                               transform hover:-translate-y-0.5 transition duration-200 flex items-center justify-center"
                        type="submit" name="cari" value="1">
                    <i class="fas fa-search mr-2"></i>
                    Cari
                </button>
            </div>
        </div>
    </form>

    <?php endif; ?>


    <!-- ================================================== -->
    <!-- HASIL PENCARIAN: ADA DATA MAHASISWA -->
    <!-- ================================================== -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- HEADER INFO & STATISTIK -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-purple-100">
            <h3 class="text-center text-lg font-bold text-purple-900 mb-2">
                Data Mahasiswa Kelas <?= htmlspecialchars($kelasInfo['klsNama']) ?>
            </h3>
            <p class="text-center text-sm text-gray-600 mb-6">
                Tahun Akademik <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?>
            </p>

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                <!-- Total Mahasiswa -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $totalMahasiswa ?></div>
                    <div class="text-sm opacity-90">Total Mahasiswa</div>
                </div>

                <!-- Laki-laki -->
                <div class="bg-gradient-to-br from-blue-500 to-sky-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $statsByGender['L'] ?? 0 ?></div>
                    <div class="text-sm opacity-90">Laki-laki</div>
                </div>

                <!-- Perempuan -->
                <div class="bg-gradient-to-br from-pink-500 to-rose-500 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $statsByGender['P'] ?? 0 ?></div>
                    <div class="text-sm opacity-90">Perempuan</div>
                </div>

                <!-- Status Aktif -->
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 text-white rounded-xl p-4 text-center shadow-md">
                    <div class="text-3xl font-bold mb-1"><?= $statsByStatus['Aktif'] ?? 0 ?></div>
                    <div class="text-sm opacity-90">Status Aktif</div>
                </div>
            </div>
        </div>

        <!-- TABEL MAHASISWA -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="p-4 border-b border-gray-100 flex flex-wrap justify-between items-center gap-4">
                <div>
                    <h4 class="text-sm font-bold text-gray-800">
                        Kelas <?= htmlspecialchars($kelasInfo['klsNama']) ?>
                    </h4>
                    <p class="text-xs text-gray-500">
                        Total <?= $rows->num_rows ?> mahasiswa
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <a href="index.php?page=daftarMahasiswaKelas" 
                       class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        <i class="fas fa-search mr-1"></i> Cari Kelas Lain
                    </a>
                    <button onclick="window.print()" 
                            class="inline-flex items-center px-3 py-2 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        <i class="fas fa-print mr-1"></i> Cetak
                    </button>
                    <button onclick="exportToExcel()" 
                            class="inline-flex items-center px-3 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg shadow-sm transition">
                        <i class="fas fa-file-excel mr-1"></i> Export Excel
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-amber-400 to-amber-500 text-gray-900">
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-14">No.</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide w-32">NIM</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Nama Mahasiswa</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Tempat / Tgl Lahir</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">JK</th>
                            <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Prodi</th>
                            <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-28">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php 
                        $no = 1;
                        $rows->data_seek(0);
                        while($r = $rows->fetch_assoc()):
                        ?>
                        <tr class="hover:bg-purple-50 transition duration-200">
                            <td data-label="No." class="px-4 py-3 text-center text-sm text-gray-700 font-semibold">
                                <?= $no++ ?>
                            </td>
                            <td data-label="NIM" class="px-4 py-3 text-sm">
                                <span class="font-mono text-sm font-semibold text-indigo-700 bg-indigo-50 px-2 py-1 rounded">
                                    <?= htmlspecialchars($r['NIM']) ?>
                                </span>
                            </td>
                            <td data-label="Nama Mahasiswa" class="px-4 py-3 text-sm">
                                <a href="index.php?page=detailMahasiswa&aksi=detail&id=<?= urlencode($r['NIM']) ?>" 
                                   class="group inline-flex items-center text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                                
                                    <?= htmlspecialchars($r['NamaMahasiswa']) ?>
                                    <i class="fas fa-external-link-alt ml-2 text-xs opacity-0 group-hover:opacity-100 transition duration-200"></i>
                                </a>
                            </td>
                            <td data-label="Tempat/Tgl Lahir" class="px-4 py-3 text-sm text-gray-700">
                                <i class="far fa-calendar-alt text-gray-400 mr-1.5 text-xs"></i>
                                <?= htmlspecialchars($r['TempatTglLahir']) ?>
                            </td>
                            <td data-label="JK" class="px-4 py-3 text-center text-sm">
                                <?php if($r['JK'] == 'L'): ?>
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 text-xs font-bold" title="Laki-laki">L</span>
                                <?php else: ?>
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-pink-100 text-pink-600 text-xs font-bold" title="Perempuan">P</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="Prodi" class="px-4 py-3 text-sm">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-gray-800">
                                        <?= htmlspecialchars($r['ProdiKode']) ?>
                                    </span>
                                    <span class="text-xs text-gray-500 truncate max-w-[180px]">
                                        <?= htmlspecialchars($r['Prodi']) ?>
                                    </span>
                                </div>
                            </td>
                            <td data-label="Status" class="px-4 py-3 text-center text-sm">
                                <?php
                                $statusColors = [
                                    'Aktif'   => ['bg' => '#ECFDF5', 'text' => '#047857', 'border' => '#A7F3D0'], // Emerald
                                    'Lulus'   => ['bg' => '#EFF6FF', 'text' => '#1D4ED8', 'border' => '#BFDBFE'], // Blue
                                    'Cuti'    => ['bg' => '#FFFBEB', 'text' => '#B45309', 'border' => '#FDE68A'], // Amber
                                    'DO'      => ['bg' => '#FEF2F2', 'text' => '#B91C1C', 'border' => '#FECACA'], // Red
                                    'Keluar'  => ['bg' => '#FFF7ED', 'text' => '#C2410C', 'border' => '#FED7AA'], // Orange
                                    'Meninggal' => ['bg' => '#F3F4F6', 'text' => '#374151', 'border' => '#E5E7EB'],
                                ];
                                $st = $r['Status'];
                                $c = $statusColors[$st] ?? ['bg' => '#F3F4F6', 'text' => '#374151', 'border' => '#E5E7EB'];
                                ?>
                                <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold border"
                                      style="background-color: <?= $c['bg'] ?>; color: <?= $c['text'] ?>; border-color: <?= $c['border'] ?>;">
                                    <?= $st ?>
                                </span>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>

    <!-- ================================================== -->
    <!-- HASIL PENCARIAN: TIDAK ADA DATA MAHASISWA -->
    <!-- ================================================== -->
    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>

        <div class="bg-white rounded-2xl shadow-lg p-10 text-center border border-yellow-200">
            <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-user-slash text-4xl text-yellow-700"></i>
            </div>
            <h3 class="text-2xl font-bold text-yellow-800 mb-3">Tidak Ada Mahasiswa</h3>
            <p class="text-yellow-800/90 mb-6 max-w-md mx-auto">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki mahasiswa yang terdaftar.
            </p>
            <div class="flex justify-center gap-3">
                <a href="index.php?page=daftarMahasiswaKelas" 
                   class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                    <i class="fas fa-sync-alt mr-2"></i>
                    Pilih Kelas Lain
                </a>
                <a href="index.php?page=mahasiswa&aksi=tambah"
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Mahasiswa
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- JAVASCRIPT -->
<script>
// Auto-load kelas saat prodi atau tahun dipilih
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
            window.location.href = `index.php?page=daftarMahasiswaKelas&tahap=pilih_kelas&thakdId=${thakdId}&prodiId=${prodiId}`;
        }
    }
});

<?php if (isset($kelasInfo)): ?>
// Export to Excel
function exportToExcel() {
    const table = document.querySelector('.table');
    if (!table) return;

    const kelasName = '<?= htmlspecialchars($kelasInfo['klsNama'] ?? 'Kelas') ?>';
    const ta = '<?= htmlspecialchars($kelasInfo['tahunAkademikLabel'] ?? '') ?>';

    const html = table.outerHTML;
    const blob = new Blob(['\ufeff', html], {
        type: 'application/vnd.ms-excel'
    });

    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `Daftar_Mahasiswa_${kelasName}_${ta}.xls`;
    a.click();
    window.URL.revokeObjectURL(url);
}
<?php endif; ?>
</script>

<!-- CSS TAMBAHAN UNTUK PRINT & RESPONSIVE TABLE -->
<style>
@media print {
    .sidebar,
    .topbar .btn,
    .btn,
    form,
    a[href*="page=daftarMahasiswaKelas"] {
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

    table th,
    table td {
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

/* Responsive Table untuk mobile */
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
