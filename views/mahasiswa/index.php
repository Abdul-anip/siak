<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<?php if (isset($error)): ?>
<div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-lg mb-4">
    <strong>Gagal menghapus data!</strong><br>
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<?php if (isset($_GET['success']) && $_GET['success'] == 'delete'): ?>
<div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg mb-4">
    Data mahasiswa berhasil dihapus.
</div>
<?php endif; ?>


<!-- Page Header -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Data Mahasiswa</h1>
        <p class="text-gray-600">Kelola data mahasiswa dengan mudah dan efisien</p>
    </div>
    <a href="index.php?page=mahasiswa&aksi=tambah" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus mr-2"></i>
        Tambah Mahasiswa
    </a>
</div>


<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-users text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Mahasiswa</p>
    </div>
    
    
</div>

<!-- Data Table -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Daftar Jurusan</h3>
            <div class="flex items-center space-x-2">
            
                <form method="GET" class="flex items-center space-x-3">
                    <input type="hidden" name="page" value="mahasiswa">
                    <input type="text" name="q" value="<?= $_GET['q'] ?? '' ?>" 
                        placeholder="Cari NIM atau Nama Mahasiswa..."
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-primary-500
                            focus:border-primary-500 w-56 text-sm">

                    <button type="submit" 
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm">
                        <i class="fas fa-search mr-1"></i> Cari
                    </button>

                
                <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition text-sm">
                    <i class="fas fa-print mr-2"></i>Print
                </button>
            </div>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">NIM</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">TTL</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">JK</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Prodi</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php 
                $no = 1; 
                while($r = $rows->fetch_assoc()): 
                    $statusColors = [
                        'A' => ['bg' => 'bg-green-100', 'text' => 'text-green-700', 'label' => 'Aktif'],
                        'L' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'label' => 'Lulus'],
                        'C' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-700', 'label' => 'Cuti'],
                        'D' => ['bg' => 'bg-red-100', 'text' => 'text-red-700', 'label' => 'DO'],
                        'K' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Keluar'],
                        'M' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'label' => 'Meninggal']
                    ];
                    $status = $statusColors[$r['mhsStsAkademik']] ?? $statusColors['A'];
                ?>
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-600"><?= $no++ ?></td>
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm font-semibold text-primary-600"><?= htmlspecialchars($r['mhsNim']) ?></span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center text-white font-bold">
                                <?= strtoupper(substr($r['mhsNama'], 0, 1)) ?>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-800"><?= htmlspecialchars($r['mhsNama']) ?></p>
                                <p class="text-xs text-gray-500"><?= htmlspecialchars($r['jurNama']) ?></p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">
                        <?= htmlspecialchars($r['mhsTempatLahir']) ?>,<br>
                        <span class="text-xs text-gray-500">
                            <?= $r['mhsTglLahir'] ? date('d-m-Y', strtotime($r['mhsTglLahir'])) : '-' ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center justify-center w-10 h-10 rounded-full <?= $r['mhsJenisKelamin'] == 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' ?> font-bold">
                            <?= $r['mhsJenisKelamin'] ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-sm font-semibold text-gray-800"><?= htmlspecialchars($r['prodiNama']) ?></p>
                            <p class="text-xs text-gray-500">Kelas <?= htmlspecialchars($r['mhsKodeKelas']) ?> | Semester <?= $r['mhsSmsAktif'] ?></p>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold <?= $status['bg'] ?> <?= $status['text'] ?>">
                            <?= $status['label'] ?>
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-center space-x-2">
                            <a href="index.php?page=mahasiswa&aksi=edit&id=<?= $r['mhsNim'] ?>" 
                               class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="index.php?page=mahasiswa&aksi=delete&id=<?= $r['mhsNim'] ?>" 
                               onclick="return confirm('Yakin ingin menghapus mahasiswa ini?')"
                               class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200"
                               title="Hapus">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold mb-2">Belum Ada Data Mahasiswa</p>
                            <p class="text-gray-400 text-sm mb-4">Mulai dengan menambahkan mahasiswa pertama</p>
                            <a href="index.php?page=mahasiswa&aksi=tambah" class="inline-flex items-center px-6 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition">
                                <i class="fas fa-plus mr-2"></i>Tambah Mahasiswa
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer -->
    <?php if($rows->num_rows > 0): ?>
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex items-center justify-between">
        <p class="text-sm text-gray-600">
            Menampilkan <span class="font-semibold text-gray-800"><?= $rows->num_rows ?></span> data mahasiswa
        </p>
        <div class="flex items-center space-x-2">
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                <i class="fas fa-chevron-left mr-2"></i>Previous
            </button>
            <button class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition">
                1
            </button>
            <button class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                Next<i class="fas fa-chevron-right ml-2"></i>
            </button>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php include "views/layout/footer.php"; ?>