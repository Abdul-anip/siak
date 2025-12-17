<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<div class="bg-white rounded-2xl shadow-lg p-6 mb-8">
    <div class="flex items-center space-x-3 mb-6">
        <i class="fas fa-file-alt text-2xl text-indigo-600"></i>
        <h1 class="text-2xl font-bold text-gray-800">Rapor Semester Mahasiswa</h1>
    </div>

    <!-- Filter Form -->
    <form action="index.php" method="GET" class="bg-gray-50 rounded-xl p-6 border border-gray-200">
        <input type="hidden" name="page" value="raporSemester">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            
            <!-- Dropdown Mahasiswa -->
            <div>
                <label for="nim" class="block text-sm font-semibold text-gray-700 mb-2">Mahasiswa</label>
                <select name="nim" id="nim" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    <?php while($mhs = $listMahasiswa->fetch_assoc()): ?>
                        <option value="<?= $mhs['mhsNim'] ?>" <?= $selectedNim == $mhs['mhsNim'] ? 'selected' : '' ?>>
                            <?= $mhs['mhsNama'] ?> - <?= $mhs['mhsNim'] ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Dropdown Semester -->
            <div>
                <label for="semester" class="block text-sm font-semibold text-gray-700 mb-2">Semester</label>
                <select name="semester" id="semester" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all" required>
                    <option value="">-- Pilih Semester --</option>
                    <?php for($i = 1; $i <= 14; $i++): ?>
                        <option value="<?= $i ?>" <?= $selectedSemester == $i ? 'selected' : '' ?>>
                            Semester <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-indigo-700 transform hover:scale-[1.02] transition-all shadow-md">
            <i class="fas fa-search mr-2"></i> Tampilkan Rapor
        </button>
    </form>
</div>

<?php if ($message): ?>
    <div class="bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 mb-6 flex items-center">
        <i class="fas fa-exclamation-circle mr-3 text-xl"></i>
        <?= $message ?>
    </div>
<?php endif; ?>

<?php if ($dataRapor): ?>
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden animate-fade-in-up">
        
        <!-- Table Header -->
        <div class="bg-indigo-900 text-white p-4">
            <h3 class="font-bold text-lg flex items-center">
                <i class="fas fa-list-ul mr-2"></i> Hasil Studi
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 font-bold w-32">Kode MK</th>
                        <th class="py-3 px-6 font-bold">Mata Kuliah</th>
                        <th class="py-3 px-6 font-bold text-center w-20">SKS</th>
                        <th class="py-3 px-6 font-bold text-center w-20">Nilai</th>
                        <th class="py-3 px-6 font-bold text-center w-20">Bobot</th>
                        <th class="py-3 px-6 font-bold text-center w-20">Total</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php 
                    $totalSks = 0;
                    $totalBobot = 0; // Total (SKS * Bobot)
                    ?>
                    <?php while($row = $dataRapor->fetch_assoc()): 
                        $mkBobot = (float) $row['khsBobotNilai'];
                        $mkSks = (int) $row['mkSks'];
                        $subTotal = $mkBobot * $mkSks;
                        
                        $totalSks += $mkSks;
                        $totalBobot += $subTotal;
                    ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-6 whitespace-nowrap font-medium"><?= htmlspecialchars($row['mkKode']) ?></td>
                        <td class="py-3 px-6"><?= htmlspecialchars($row['mkNama']) ?></td>
                        <td class="py-3 px-6 text-center"><?= $mkSks ?></td>
                        <td class="py-3 px-6 text-center font-bold text-indigo-600"><?= $row['khsKodeNilai'] ? $row['khsKodeNilai'] : '-' ?></td>
                        <td class="py-3 px-6 text-center"><?= number_format($mkBobot, 2) ?></td>
                        <td class="py-3 px-6 text-center font-semibold"><?= number_format($subTotal, 2) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                
                <!-- Footer Results -->
                <tfoot class="bg-gray-50 font-bold text-gray-800">
                    <tr class="border-t-2 border-indigo-100">
                        <td colspan="2" class="py-4 px-6 text-right uppercase text-xs tracking-wider">Total</td>
                        <td class="py-4 px-6 text-center text-indigo-700 bg-indigo-50"><?= $totalSks ?></td>
                        <td colspan="2" class="py-4 px-6"></td>
                        <td class="py-4 px-6 text-center text-indigo-700 bg-indigo-50"><?= number_format($totalBobot, 2) ?></td>
                    </tr>
                    <tr class="bg-indigo-50 text-indigo-900 text-lg border-t border-indigo-200">
                        <td colspan="5" class="py-4 px-6 text-right">Indeks Prestasi Semester (IPS)</td>
                        <td class="py-4 px-6 text-center font-extrabold">
                            <?php 
                                $ips = $totalSks > 0 ? ($totalBobot / $totalSks) : 0;
                                echo number_format($ips, 2);
                            ?>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="mt-6 mb-12">
        <a href="index.php?page=pascakuliah" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center transition-colors">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Menu Pasca Kuliah
        </a>
    </div>

<?php endif; ?>

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 20px, 0);
        }
        to {
            opacity: 1;
            transform: translate3d(0, 0, 0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.5s ease-out;
    }
</style>

<?php include "views/layout/footer.php"; ?>
