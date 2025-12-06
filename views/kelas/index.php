<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            <i class="fas fa-door-open text-primary-600 mr-3"></i>Daftar Kelas
        </h1>
        <p class="text-gray-600">Kelola data kelas, program studi, dan jumlah mahasiswa</p>
    </div>

    <a href="index.php?page=kelas&aksi=tambah"
       class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-to-r 
              from-primary-600 to-secondary-600 text-white font-semibold rounded-xl 
              shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200">
        <i class="fas fa-plus-circle mr-2"></i> Tambah Kelas
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <!-- Total Kelas -->
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-xl">
        <div class="flex items-center justify-between mb-2">
            <i class="fas fa-door-open text-3xl opacity-80"></i>
            <span class="bg-white/20 px-3 py-1 rounded-full text-sm font-semibold">Total</span>
        </div>
        <p class="text-3xl font-bold"><?= $rows->num_rows ?></p>
        <p class="text-sm opacity-90">Total Kelas</p>
    </div>

    

    

</div>

<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">

    <!-- Table Header -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800">Daftar Kelas</h3>

            <button onclick="window.print()"
                class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 
                       hover:bg-gray-50 transition text-sm">
                <i class="fas fa-print mr-2"></i>Print
            </button>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider w-12">#</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kelas</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Program Studi</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tahun Akademik</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Mhs</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider w-48">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-200">

                <?php 
                $no = 1;
                $rows->data_seek(0);
                while ($r = $rows->fetch_assoc()):
                    $jumlahMhs = $kelas->countMahasiswa($r['klsId']);
                ?>
                <tr class="hover:bg-gray-50 transition duration-200">
                    <td class="px-6 py-4 text-sm text-gray-600 font-medium"><?= $no++ ?></td>

                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800"><?= htmlspecialchars($r['klsNama']) ?></span>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600">
                        <?= htmlspecialchars($r['prodiNama']) ?>
                    </td>

                    <td class="px-6 py-4 text-sm text-gray-600">
                        <?= htmlspecialchars($r['tahunAkademikLabel']) ?>
                    </td>

                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                            <?= $jumlahMhs ?> Mhs
                        </span>
                    </td>

                    <!-- ACTION BUTTONS -->
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center space-x-2">

                            <a href="index.php?page=kelas&aksi=edit&id=<?= $r['klsId'] ?>"
                                class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg 
                                       hover:bg-blue-200 transition duration-200 font-medium">
                                <i class="fas fa-edit mr-1"></i> Edit
                            </a>

                            <a href="index.php?page=kelas&aksi=delete&id=<?= $r['klsId'] ?>"
                               onclick="return confirm('⚠️ Hapus kelas <?= htmlspecialchars($r['klsNama']) ?>?\n<?= $jumlahMhs > 0 ? 'PERHATIAN: Kelas ini memiliki '.$jumlahMhs.' mahasiswa!' : '' ?>')"
                               class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg 
                                      hover:bg-red-200 transition duration-200 font-medium">
                                <i class="fas fa-trash-alt mr-1"></i> Hapus
                            </a>

                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>

                <!-- EMPTY STATE -->
                <?php if ($rows->num_rows == 0): ?>
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                            <p class="text-gray-500 text-lg font-semibold mb-2">Belum Ada Data Kelas</p>
                            <p class="text-gray-400 text-sm mb-6">Mulai dengan menambahkan kelas pertama.</p>

                            <a href="index.php?page=kelas&aksi=tambah"
                               class="inline-flex items-center px-6 py-3 bg-gradient-to-r 
                                      from-primary-600 to-secondary-600 text-white rounded-xl hover:shadow-xl 
                                      transform hover:-translate-y-1 transition font-semibold">
                                <i class="fas fa-plus-circle mr-2"></i>Tambah Kelas
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
