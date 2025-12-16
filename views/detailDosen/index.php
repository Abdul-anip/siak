<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="bg-gradient-to-r from-blue-600 to-teal-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-extrabold mb-1">
                <?= htmlspecialchars($dataDosen['namaLengkap']) ?>
            </h1>
            <p class="text-white/90 text-lg font-medium">
                NIDN: <?= htmlspecialchars($dataDosen['dsnNidn']) ?>
            </p>
        </div>
        <div class="flex items-center space-x-3">
            <button onclick="window.print()" 
                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl transition duration-200">
                <i class="fas fa-print mr-2"></i>
                Cetak
            </button>
            <a href="javascript:history.back()" 
                class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white font-semibold rounded-xl transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>
</div>

<div class="card-content">
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-blue-600 uppercase tracking-wider">Matakuliah Unik</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalMatkulDiajar ?></p>
            </div>
            <i class="fas fa-book-open text-4xl text-blue-300"></i>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-teal-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-teal-600 uppercase tracking-wider">Kelas Diampu</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalKelasDiampu ?></p>
            </div>
            <i class="fas fa-chalkboard text-4xl text-teal-300"></i>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-lg border border-purple-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-purple-600 uppercase tracking-wider">Total Mahasiswa</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalMahasiswa ?></p>
            </div>
            <i class="fas fa-user-graduate text-4xl text-purple-300"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center">
            <i class="fas fa-id-card-alt text-blue-600 mr-2"></i> Data Pribadi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
            <div class="flex">
                <span class="w-32 font-semibold text-gray-600">NIDN</span>
                <span class="flex-1">: <?= htmlspecialchars($dataDosen['dsnNidn']) ?></span>
            </div>
            <div class="flex">
                <span class="w-32 font-semibold text-gray-600">Nama Lengkap</span>
                <span class="flex-1">: <?= htmlspecialchars($dataDosen['namaLengkap']) ?></span>
            </div>
            <div class="flex">
                <span class="w-32 font-semibold text-gray-600">Gelar Depan</span>
                <span class="flex-1">: <?= htmlspecialchars($dataDosen['dsnGelarDepan'] ?? '-') ?></span>
            
            
            </div>
        </div>
    
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 mb-8">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-graduation-cap text-purple-600 mr-2"></i> Daftar Matakuliah Unik yang Diajarkan (<?= $totalMatkulDiajar ?>)
            </h3>
        </div>
        
        <?php if ($queryMatkul->num_rows > 0): ?>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Kode</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Nama Matakuliah</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-20">SKS</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-32">Jumlah Kelas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1; while($r = $queryMatkul->fetch_assoc()): ?>
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
                            <?= $r['mkSks'] ?>
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-semibold text-gray-800">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                <?= $r['jumlahKelas'] ?> Kelas
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="p-6 text-center text-gray-500">Dosen ini belum terdaftar mengajar matakuliah apapun.</p>
        <?php endif; ?>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-layer-group text-teal-600 mr-2"></i> Daftar Kelas yang Diampu (<?= $totalKelasDiampu ?>)
            </h3>
        </div>
        
        <?php if ($queryKelas->num_rows > 0): ?>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Prodi</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">Tahun Akademik</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">Jlh Matkul</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">Jlh Mhs</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php $no = 1; while($k = $queryKelas->fetch_assoc()): ?>
                    <tr class="hover:bg-teal-50 transition duration-200">
                        <td class="px-4 py-3 text-center text-sm text-gray-700 font-semibold"><?= $no++ ?></td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            <?= htmlspecialchars($k['klsNama']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($k['prodiNama']) ?> (<?= htmlspecialchars($k['prodiJenjang']) ?>)
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            <?= htmlspecialchars($k['thakdTahun']) ?>/<?= htmlspecialchars($k['thakdTahun']+1) ?>
                        </td>
                         <td class="px-4 py-3 text-center text-sm font-semibold text-gray-800">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-100 text-teal-700">
                                <?= $k['jlhMatkulDiajar'] ?>
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-700">
                            <?= $k['jlhMahasiswa'] ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="p-6 text-center text-gray-500">Dosen ini belum terdaftar mengampu kelas apapun.</p>
        <?php endif; ?>
    </div>

</div>

<style>
@media print {
    /* Sembunyikan elemen non-penting saat dicetak */
    .sidebar, .topbar, .bg-gradient-to-r, .btn {
        display: none !important;
    }
    .card-content {
        box-shadow: none !important;
    }
    /* ... (Tambahkan kembali styling print yang Anda inginkan di file Matkul sebelumnya) ... */
}
</style>

<?php include "views/layout/footer.php"; ?>