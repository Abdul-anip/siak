<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<!-- Header Section -->
<div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div class="flex-1">
            <div class="flex items-center mb-2">
                <a href="javascript:history.back()" 
                   class="mr-3 w-10 h-10 flex items-center justify-center rounded-lg bg-white/20 hover:bg-white/30 transition duration-200">
                    <i class="fas fa-arrow-left text-white"></i>
                </a>
                <h1 class="text-2xl font-bold">Detail Matakuliah</h1>
            </div>
            <p class="text-white/90 text-sm">
                Informasi lengkap tentang matakuliah dan penggunaannya dalam kelas
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

    <!-- INFORMASI MATAKULIAH -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-6">
        <!-- Header -->
        <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-book text-purple-600 text-xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-800">Informasi Matakuliah</h3>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-4">
                
                <!-- Kode Matakuliah -->
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Kode Matakuliah</span>
                    <span class="text-base font-bold text-purple-700">
                        <?= htmlspecialchars($dataMatkul['mkKode']) ?>
                    </span>
                </div>

                <!-- Status -->
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Status</span>
                    <?php 
                    $statusClass = $dataMatkul['mkIsAktif'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                    $statusIcon = $dataMatkul['mkIsAktif'] ? 'fa-check-circle' : 'fa-times-circle';
                    $statusText = $dataMatkul['mkIsAktif'] ? 'Aktif' : 'Non-Aktif';
                    ?>
                    <span class="inline-flex items-center w-fit px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                        <i class="fas <?= $statusIcon ?> mr-2"></i>
                        <?= $statusText ?>
                    </span>
                </div>

                <!-- Nama Matakuliah -->
                <div class="flex flex-col lg:col-span-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Nama Matakuliah</span>
                    <span class="text-lg font-bold text-gray-800">
                        <?= htmlspecialchars($dataMatkul['mkNama']) ?>
                    </span>
                </div>

                <!-- Nama Inggris (jika ada) -->
                <?php if (!empty($dataMatkul['mkNamaAsing'])): ?>
                <div class="flex flex-col lg:col-span-2">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Nama (Bahasa Inggris)</span>
                    <span class="text-base text-gray-700 italic">
                        <?= htmlspecialchars($dataMatkul['mkNamaAsing']) ?>
                    </span>
                </div>
                <?php endif; ?>

                <!-- SKS -->
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Jumlah SKS</span>
                    <span class="inline-flex items-center w-fit px-4 py-2 rounded-lg bg-blue-50 text-blue-700 text-base font-bold">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        <?= $dataMatkul['mkSks'] ?> SKS
                    </span>
                </div>

                <!-- Semester -->
                <div class="flex flex-col">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1">Semester</span>
                    <span class="inline-flex items-center w-fit px-4 py-2 rounded-lg bg-indigo-50 text-indigo-700 text-base font-bold">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Semester <?= $dataMatkul['mkSemester'] ?>
                    </span>
                </div>

                <!-- Kurikulum -->
                <?php if ($dataKurikulum): ?>
                <div class="flex flex-col lg:col-span-2 bg-gray-50 p-4 rounded-lg">
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">
                        <i class="fas fa-layer-group mr-1"></i>
                        Kurikulum
                    </span>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <div>
                            <span class="text-gray-600">Nama:</span>
                            <span class="font-semibold text-gray-800 ml-2"><?= htmlspecialchars($dataKurikulum['kurNama']) ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Tahun:</span>
                            <span class="font-semibold text-gray-800 ml-2"><?= htmlspecialchars($dataKurikulum['kurTahun']) ?></span>
                        </div>
                        <div>
                            <span class="text-gray-600">Program Studi:</span>
                            <span class="font-semibold text-gray-800 ml-2"><?= htmlspecialchars($dataKurikulum['prodiNama']) ?></span>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- STATISTIK -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        
        <!-- Total Kelas -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-1">Total Kelas</p>
                    <h3 class="text-3xl font-bold"><?= $totalKelas ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-school text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Dosen -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-1">Total Dosen</p>
                    <h3 class="text-3xl font-bold"><?= $totalDosen ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-chalkboard-teacher text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-1">Total Mahasiswa</p>
                    <h3 class="text-3xl font-bold"><?= $totalMahasiswa ?></h3>
                </div>
                <div class="bg-white/20 rounded-full p-4">
                    <i class="fas fa-user-graduate text-3xl"></i>
                </div>
            </div>
        </div>

    </div>

    <!-- DAFTAR KELAS YANG MENGGUNAKAN MATAKULIAH INI -->
    <?php if ($queryKelas && $queryKelas->num_rows > 0): ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-6">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-list-ul text-blue-600 text-xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-800">Daftar Kelas</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white">
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Tahun Akademik</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Program Studi</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Nama Kelas</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase w-24">Mahasiswa</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase w-24">Dosen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    $no = 1;
                    $queryKelas->data_seek(0);
                    while($k = $queryKelas->fetch_assoc()): 
                    ?>
                    <tr class="hover:bg-blue-50 transition duration-200">
                        <td class="px-4 py-3 text-center text-sm font-semibold text-gray-700"><?= $no++ ?></td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($k['tahunAkademikLabel']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($k['prodiNama']) ?> (<?= htmlspecialchars($k['prodiJenjang']) ?>)
                        </td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            <?= htmlspecialchars($k['klsNama']) ?>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                <i class="fas fa-user-graduate mr-1"></i>
                                <?= $k['jlhMahasiswa'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                <i class="fas fa-chalkboard-teacher mr-1"></i>
                                <?= $k['jlhDosen'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- DAFTAR DOSEN PENGAMPU -->
    <?php if ($queryDosen && $queryDosen->num_rows > 0): ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-6">
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-users text-green-600 text-xl mr-3"></i>
                <h3 class="text-lg font-bold text-gray-800">Daftar Dosen Pengampu</h3>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-green-600 to-emerald-600 text-white">
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">NIDN</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Nama Dosen</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase">Tahun Akademik</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    $no = 1;
                    $queryDosen->data_seek(0);
                    while($d = $queryDosen->fetch_assoc()): 
                        $semesterLabel = ($d['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                        $tahunAwal = (int) $d['thakdTahun'];
                        $tahunDisplay = $tahunAwal . '/' . ($tahunAwal + 1) . ' - ' . $semesterLabel;
                    ?>
                    <tr class="hover:bg-green-50 transition duration-200">
                        <td class="px-4 py-3 text-center text-sm font-semibold text-gray-700"><?= $no++ ?></td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            <?= htmlspecialchars($d['dsnNidn']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($d['namaLengkap']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($d['klsNama']) ?> - <?= htmlspecialchars($d['prodiNama']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($tahunDisplay) ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- TOMBOL AKSI -->
    <div class="flex flex-wrap gap-3 mt-6">
        <a href="javascript:history.back()" 
           class="inline-flex items-center px-5 py-3 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali
        </a>
        <button onclick="window.print()" 
                class="inline-flex items-center px-5 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <i class="fas fa-print mr-2"></i>
            Cetak
        </button>
        <a href="index.php?page=matkul&aksi=edit&id=<?= $dataMatkul['mkId'] ?>" 
           class="inline-flex items-center px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-200">
            <i class="fas fa-edit mr-2"></i>
            Edit Matakuliah
        </a>
    </div>

</div>

<!-- CSS TAMBAHAN UNTUK PRINT -->
<style>
@media print {
    .sidebar, .topbar, .btn, header, button {
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
    
    @page {
        margin: 1cm;
    }
}
</style>

<?php include "views/layout/footer.php"; ?>