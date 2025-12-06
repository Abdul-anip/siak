<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=matkul" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Matakuliah
            </h1>
            <p class="text-gray-600 mt-1">Perbarui data matakuliah di bawah ini</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Matakuliah</h3>
            </div>

            <div class="p-6">

                <form method="post" action="index.php?page=matkul&aksi=update" class="space-y-6">

                    <input type="hidden" name="mkId" value="<?= $data['mkId'] ?>">

                    <!-- Kurikulum -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kurikulum</label>
                        <select name="mkKurId"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                            <option value="0">-- Pilih Kurikulum --</option>
                            <?php while($k = $listKur->fetch_assoc()): ?>
                                <option value="<?= $k['kurId'] ?>"
                                    <?= $k['kurId']==$data['mkKurId'] ? 'selected' : '' ?>>
                                    <?= $k['kurNama'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Kode -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Kode</label>
                        <input type="text" name="mkKode"
                            value="<?= htmlspecialchars($data['mkKode']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Nama -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Nama</label>
                        <input type="text" name="mkNama"
                            value="<?= htmlspecialchars($data['mkNama']) ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Semester -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Semester</label>
                        <input type="number" min="1" name="mkSemester"
                            value="<?= $data['mkSemester'] ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- SKS -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">SKS</label>
                        <input type="number" min="0" name="mkSks"
                            value="<?= $data['mkSks'] ?>"
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Status</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="mkIsAktif"
                                <?= $data['mkIsAktif'] ? 'checked' : '' ?>
                                class="sr-only peer">
                            <div class="w-14 h-7 bg-gray-300 rounded-full peer peer-checked:bg-primary-600
                                after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                after:bg-white after:border-gray-300 after:border after:rounded-full
                                after:h-6 after:w-6 after:transition-all peer-checked:after:translate-x-full">
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-700">Aktif</span>
                        </label>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 pt-6 border-t border-gray-200">

                        <button type="submit" name="update_matkul"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                            bg-gradient-to-r from-primary-600 to-secondary-600 text-white rounded-xl">
                            <i class="fas fa-save mr-2"></i> Update Data
                        </button>

                        <a href="index.php?page=matkul"
                            class="flex-1 inline-flex items-center justify-center px-6 py-3 
                            bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>

                    </div>

                </form>
            </div>
        </div>
    </div>

</div>

<?php include "views/layout/footer.php"; ?>
