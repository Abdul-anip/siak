<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center space-x-4">
        <a 
            href="index.php?page=user" 
            class="p-3 bg-white rounded-xl shadow-lg hover:shadow-xl transition duration-200"
        >
            <i class="fas fa-arrow-left text-gray-600"></i>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-user-edit text-primary-600 mr-3"></i>
                Edit User
            </h1>
            <p class="text-gray-600 mt-2">Perbarui informasi user</p>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if(isset($error)): ?>
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-xl shadow-sm alert-auto-hide">
        <div class="flex items-start">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl mt-0.5"></i>
            <div class="ml-4">
                <h3 class="text-red-800 font-semibold text-lg">Gagal Menyimpan</h3>
                <p class="text-red-700 mt-1"><?= $error ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Form Edit User -->
<div class="max-w-4xl">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3 text-white">
                    <i class="fas fa-user-circle text-3xl"></i>
                    <div>
                        <h2 class="text-xl font-bold">Edit Informasi User</h2>
                        <p class="text-sm opacity-90">ID User: <?= $data['appusrID'] ?></p>
                    </div>
                </div>
                
                <?php if($data['appusrID'] == $_SESSION['userid']): ?>
                    <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full text-white text-sm font-semibold">
                        <i class="fas fa-star mr-1"></i> Akun Anda
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Form Body -->
        <form method="post" action="index.php?page=user&aksi=update" class="p-8 space-y-6">
            
            <!-- Hidden ID -->
            <input type="hidden" name="appusrID" value="<?= $data['appusrID'] ?>">
            
            <!-- Username -->
            <div class="space-y-2">
                <label for="appusrNama" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-user text-primary-600 mr-2"></i>Username
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="appusrNama"
                        name="appusrNama" 
                        value="<?= htmlspecialchars($data['appusrNama']) ?>"
                        required
                        placeholder="Contoh: admin123"
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                    >
                    <i class="fas fa-at absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <p class="text-xs text-gray-500 mt-1">
                    Username harus unik dan tidak boleh sama dengan user lain
                </p>
            </div>

            <!-- Password Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-lock text-yellow-600 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-1">Informasi Password</h4>
                        <p class="text-sm text-gray-700">
                            Password tidak dapat diedit di sini. 
                            <?php if($data['appusrID'] == $_SESSION['userid']): ?>
                                Gunakan menu <a href="index.php?page=password" class="text-blue-600 hover:underline font-semibold">Ubah Password</a> untuk mengubah password Anda.
                            <?php else: ?>
                                Gunakan tombol <strong>"Reset Password"</strong> di daftar user untuk mereset password ke default.
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grup User -->
            <div class="space-y-2">
                <label for="appusrGrupUser" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-users text-primary-600 mr-2"></i>Grup User
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select 
                        id="appusrGrupUser"
                        name="appusrGrupUser" 
                        required
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none appearance-none"
                    >
                        <option value="">-- Pilih Grup User --</option>
                        <option value="admin" <?= $data['appusrGrupUser'] == 'admin' ? 'selected' : '' ?>>
                            👑 Admin
                        </option>
                        <option value="user" <?= $data['appusrGrupUser'] == 'user' ? 'selected' : '' ?>>
                            👤 User
                        </option>
                        <option value="dosen" <?= $data['appusrGrupUser'] == 'dosen' ? 'selected' : '' ?>>
                            👨‍🏫 Dosen
                        </option>
                        <option value="mahasiswa" <?= $data['appusrGrupUser'] == 'mahasiswa' ? 'selected' : '' ?>>
                            🎓 Mahasiswa
                        </option>
                    </select>
                    <i class="fas fa-shield-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <i class="fas fa-chevron-down absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                </div>
            </div>

            <!-- No HP -->
            <div class="space-y-2">
                <label for="appusrNoHp" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-phone text-primary-600 mr-2"></i>No HP
                    <span class="text-gray-400 text-xs">(Opsional)</span>
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="appusrNoHp"
                        name="appusrNoHp" 
                        value="<?= htmlspecialchars($data['appusrNoHp'] ?? '') ?>"
                        placeholder="Contoh: 081234567890"
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                    >
                    <i class="fas fa-mobile-alt absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="bg-gray-50 rounded-xl p-6 border-2 border-gray-200">
                <label class="flex items-center cursor-pointer">
                    <input 
                        type="checkbox" 
                        name="appusrIsEnabled" 
                        <?= $data['appusrIsEnabled'] == 1 ? 'checked' : '' ?>
                        <?= $data['appusrID'] == $_SESSION['userid'] ? 'disabled' : '' ?>
                        class="w-5 h-5 text-primary-600 border-gray-300 rounded focus:ring-primary-500 cursor-pointer"
                    >
                    <div class="ml-3">
                        <span class="text-sm font-semibold text-gray-800">
                            <i class="fas fa-toggle-on text-green-500 mr-2"></i>
                            User Aktif
                        </span>
                        <p class="text-xs text-gray-600 mt-1">
                            <?php if($data['appusrID'] == $_SESSION['userid']): ?>
                                Anda tidak dapat menonaktifkan akun Anda sendiri
                            <?php else: ?>
                                User aktif dapat login ke sistem. Nonaktifkan jika ingin melarang akses sementara.
                            <?php endif; ?>
                        </p>
                    </div>
                </label>
            </div>

            <!-- Last Updated Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-info-circle text-blue-600 text-xl mt-0.5"></i>
                    <div class="text-sm text-gray-700">
                        <p><strong>User ID:</strong> <?= $data['appusrID'] ?></p>
                        <p class="mt-1"><strong>Status Saat Ini:</strong> 
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?= $data['appusrIsEnabled'] == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                <?= $data['appusrIsEnabled'] == 1 ? 'Aktif' : 'Non-Aktif' ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6 border-t">
                <a 
                    href="index.php?page=user" 
                    class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition duration-200"
                >
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                
                <button 
                    type="submit" 
                    name="update_user"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Form Validation
document.querySelector('form').addEventListener('submit', function(e) {
    const username = document.getElementById('appusrNama').value.trim();
    
    if (username.length < 3) {
        e.preventDefault();
        alert('Username minimal 3 karakter!');
        return false;
    }
});
</script>

<?php include "views/layout/footer.php"; ?>