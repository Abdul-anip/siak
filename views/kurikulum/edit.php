<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="mb-8">
    <div class="flex items-center space-x-3 mb-4">
        <a href="index.php?page=kurikulum" class="text-gray-600 hover:text-gray-800">
            <i class="fas fa-arrow-left text-xl"></i>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-edit text-primary-600 mr-3"></i>Edit Kurikulum
            </h1>
            <p class="text-gray-600 mt-1">Perbarui informasi kurikulum pada form berikut.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

            <div class="bg-gradient-to-r from-primary-600 to-secondary-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white">Form Edit Kurikulum</h3>
            </div>

            <div class="p-6">

                <form method="post" action="index.php?page=kurikulum&aksi=update" class="space-y-6">

                    <input type="hidden" name="kurId" value="<?= $data['kurId'] ?>">

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Program Studi *</label>
                        <select name="kurProdiId" required
                            class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                            <option value="0">-- Pilih Program Studi --</option>
                            <?php while($p = $listProdi->fetch_assoc()): ?>
                                <option value="<?= $p['prodiId'] ?>"
                                    <?= $p['prodiId'] == $data['kurProdiId'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($p['prodiNama']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Tahun Kurikulum *</label>
                        <input type="text" name="kurTahun" required
                               value="<?= htmlspecialchars($data['kurTahun']) ?>"
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Nama Kurikulum *</label>
                        <input type="text" name="kurNama" required
                               value="<?= htmlspecialchars($data['kurNama']) ?>"
                               class="w-full px-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-gray-700">Status</label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="kurIsAktif"
                                   <?= $data['kurIsAktif'] ? 'checked' : '' ?>
                                   class="sr-only peer">

                            <div class="w-14 h-7 bg-gray-300 rounded-full peer peer-checked:bg-primary-600
                                    relative after:content-[''] after:absolute after:top-0.5 after:left-[4px]
                                    after:w-6 after:h-6 after:bg-white after:rounded-full after:transition-all
                                    peer-checked:after:translate-x-full"></div>

                            <span class="ml-3 text-sm text-gray-700">Kurikulum Aktif</span>
                        </label>
                    </div>

                    <div class="flex gap-3 pt-6 border-t border-gray-200">
                        <button type="submit" name="update_kurikulum"
                            class="flex-1 px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 
                                   text-white font-semibold rounded-xl shadow-lg">
                            Update Data
                        </button>

                        <a href="index.php?page=kurikulum"
                           class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl">
                            Batal
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div class="lg:col-span-1 space-y-6">

        <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6">
            <h4 class="font-bold text-blue-800 mb-2">Tips</h4>
            <p class="text-sm text-blue-700">Periksa kembali tahun dan nama kurikulum sebelum menyimpan.</p>
        </div>

        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-2xl p-6">
            <h4 class="font-bold text-yellow-800 mb-2">Catatan</h4>
            <p class="text-sm text-yellow-700">Kurikulum aktif mempengaruhi data mata kuliah.</p>
        </div>

    </div>
</div>

<?php include "views/layout/footer.php"; ?>
