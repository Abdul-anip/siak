<?php 
include "views/layout/header.php"; 
include "views/layout/sidebar.php"; 
?>

<div class="bg-gradient-to-r from-green-600 to-emerald-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-extrabold mb-1">
                <?= htmlspecialchars($dataMahasiswa['mhsNama']) ?>
            </h1>
            <p class="text-white/90 text-lg font-medium">
                NIM: <?= htmlspecialchars($dataMahasiswa['mhsNim']) ?>
            </p>
        </div>
        <div class="flex items-center space-x-3">
             <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold 
                <?= $isAktif ? 'bg-white text-green-700' : 'bg-white text-red-700' ?>">
                Status: <?= $statusAkademik ?>
            </span>
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
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-emerald-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-emerald-600 uppercase tracking-wider">Total Kelas Diikuti</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $totalKelasDiikuti ?></p>
            </div>
            <i class="fas fa-chalkboard-teacher text-4xl text-emerald-300"></i>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-purple-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-purple-600 uppercase tracking-wider">Program Studi</p>
                <p class="text-3xl font-bold text-gray-800 mt-1">
                    <?= htmlspecialchars($dataProdi['prodiJenjang'] ?? 'N/A') ?>
                </p>
            </div>
            <i class="fas fa-graduation-cap text-4xl text-purple-300"></i>
        </div>
        
        <div class="bg-white p-6 rounded-2xl shadow-lg border border-yellow-100 flex items-center justify-between">
            <div>
                <p class="text-sm font-semibold text-yellow-600 uppercase tracking-wider">Semester Aktif</p>
                <p class="text-3xl font-bold text-gray-800 mt-1"><?= $mhsSmsAktif ?></p>
            </div>
            <i class="fas fa-calendar-check text-4xl text-yellow-300"></i>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg p-6 mb-8 border border-gray-100">
        <h3 class="text-xl font-bold text-gray-800 border-b pb-3 mb-4 flex items-center">
            <i class="fas fa-id-card-alt text-green-600 mr-2"></i> Data Akademik & Pribadi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Program Studi</span>
                <span class="flex-1">: 
                    <?= htmlspecialchars($dataProdi['prodiNama'] ?? 'N/A') ?> (<?= htmlspecialchars($dataProdi['prodiJenjang'] ?? 'N/A') ?>)
                </span>
            </div>
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Kode Kelas Saat Ini</span>
                <span class="flex-1">: <?= htmlspecialchars($dataMahasiswa['mhsKodeKelas'] ?? '-') ?></span>
            </div>
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Tempat Lahir</span>
                <span class="flex-1">: <?= htmlspecialchars($dataMahasiswa['mhsTempatLahir'] ?? '-') ?></span>
            </div>
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Tanggal Lahir</span>
                <span class="flex-1">: <?= htmlspecialchars($dataMahasiswa['mhsTglLahir'] ?? '-') ?></span>
            </div>
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Jenis Kelamin</span>
                <span class="flex-1">: 
                    <?php 
                    $jk = $dataMahasiswa['mhsJenisKelamin'] ?? 'L';
                    echo ($jk == 'L' ? 'Laki-laki' : 'Perempuan');
                    ?>
                </span>
            </div>
            <div class="flex">
                <span class="w-40 font-semibold text-gray-600">Status Akademik</span>
                <span class="flex-1">: <?= $statusAkademik ?></span>
            </div>
            
        </div>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="bg-gray-50 px-6 py-4 border-b">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-history text-blue-600 mr-2"></i> Riwayat Kelas yang Diikuti (<?= $totalKelasDiikuti ?>)
            </h3>
        </div>
        
        <?php if ($queryKelas->num_rows > 0): ?>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-16">No</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Tahun Akademik</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Nama Kelas</th>
                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide">Prodi</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-28">Jlh Matkul</th>
                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide w-24">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php 
                    $no = 1; 
                    $semesterLabelMap = ['1' => 'Ganjil', '2' => 'Genap'];

                    while($r = $queryKelas->fetch_assoc()): 
                        $taLabel = htmlspecialchars($r['thakdTahun']) . '/' . (htmlspecialchars($r['thakdTahun']) + 1) . ' - ' . $semesterLabelMap[$r['thakdSemester']];
                        $statusClass = $r['klsmhsIsAktif'] ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700';
                        $statusText = $r['klsmhsIsAktif'] ? 'Aktif' : 'Selesai';
                    ?>
                    <tr class="hover:bg-blue-50 transition duration-200">
                        <td class="px-4 py-3 text-center text-sm text-gray-700 font-semibold"><?= $no++ ?></td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-800">
                            <?= $taLabel ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($r['klsNama']) ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-700">
                            <?= htmlspecialchars($r['prodiNama']) ?>
                        </td>
                         <td class="px-4 py-3 text-center text-sm font-semibold text-gray-800">
                            <?= $r['jlhMatkulDiambil'] ?>
                        </td>
                        <td class="px-4 py-3 text-center text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $statusClass ?>">
                                <?= $statusText ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <p class="p-6 text-center text-gray-500">Mahasiswa ini belum terdaftar mengikuti kelas manapun.</p>
        <?php endif; ?>
    </div>


</div>

<style>
/* ... (Styling Print) ... */
</style>

<?php include "views/layout/footer.php"; ?>