<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-users-cog text-primary-600 mr-3"></i>
                Manajemen User
            </h1>
            <p class="text-gray-600 mt-2">Kelola akun pengguna sistem akademik</p>
        </div>
        <a 
            href="index.php?page=user&aksi=tambah" 
            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
        >
            <i class="fas fa-plus-circle mr-2"></i>
            Tambah User Baru
        </a>
    </div>
</div>

<!-- Alert Messages from Session -->
<?php if(isset($_SESSION['success_message'])): ?>
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-xl shadow-sm alert-auto-hide">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 text-2xl mt-0.5"></i>
            <div class="ml-4">
                <h3 class="text-green-800 font-semibold text-lg">Berhasil!</h3>
                <p class="text-green-700 mt-1"><?= htmlspecialchars($_SESSION['success_message']) ?></p>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['error_message'])): ?>
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-xl shadow-sm alert-auto-hide">
        <div class="flex items-start">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl mt-0.5"></i>
            <div class="ml-4">
                <h3 class="text-red-800 font-semibold text-lg">Error!</h3>
                <p class="text-red-700 mt-1"><?= htmlspecialchars($_SESSION['error_message']) ?></p>
            </div>
        </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<!-- Search & Filter Bar -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-100">
    <form method="get" action="index.php" class="flex flex-col md:flex-row gap-4">
        <input type="hidden" name="page" value="user">
        
        <div class="flex-1 relative">
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            <input 
                type="text" 
                name="search" 
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                placeholder="Cari username, grup user, atau no HP..."
                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
            >
        </div>
        
        <button 
            type="submit"
            class="px-8 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition duration-200 flex items-center justify-center"
        >
            <i class="fas fa-search mr-2"></i>
            Cari
        </button>
        
        <?php if(isset($_GET['search']) && $_GET['search'] != ''): ?>
            <a 
                href="index.php?page=user"
                class="px-8 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition duration-200 flex items-center justify-center"
            >
                <i class="fas fa-times mr-2"></i>
                Reset
            </a>
        <?php endif; ?>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    
    <!-- Table Header -->
    <div class="bg-gradient-to-r from-primary-600 to-secondary-600 p-6">
        <div class="flex items-center justify-between text-white">
            <div class="flex items-center space-x-3">
                <i class="fas fa-list text-2xl"></i>
                <div>
                    <h2 class="text-xl font-bold">Daftar User</h2>
                    <p class="text-sm opacity-90">Total: <?= $rows->num_rows ?> user</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Content -->
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b-2 border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        No
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Username
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Grup User
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        No HP
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php if($rows->num_rows > 0): ?>
                    <?php $no = 1; while($row = $rows->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900"><?= $no++ ?></span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">
                                            <?= strtoupper(substr($row['appusrNama'], 0, 1)) ?>
                                        </span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900">
                                            <?= htmlspecialchars($row['appusrNama']) ?>
                                        </p>
                                        <p class="text-xs text-gray-500">ID: <?= $row['appusrID'] ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full <?= $row['appusrGrupUser'] == 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' ?>">
                                    <i class="fas fa-<?= $row['appusrGrupUser'] == 'admin' ? 'crown' : 'user' ?> mr-1"></i>
                                    <?= htmlspecialchars($row['appusrGrupUser'] ?? 'user') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-900">
                                    <?= $row['appusrNoHp'] ? htmlspecialchars($row['appusrNoHp']) : '<span class="text-gray-400 italic">Tidak ada</span>' ?>
                                </p>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full <?= $row['appusrIsEnabled'] == 1 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <i class="fas fa-<?= $row['appusrIsEnabled'] == 1 ? 'check-circle' : 'times-circle' ?> mr-1"></i>
                                    <?= $row['appusrIsEnabled'] == 1 ? 'Aktif' : 'Non-Aktif' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    
                                    <!-- Edit Button -->
                                    <a 
                                        href="index.php?page=user&aksi=edit&id=<?= $row['appusrID'] ?>"
                                        class="p-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition duration-200"
                                        title="Edit User"
                                    >
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <!-- Reset Password Button -->
                                    <a 
                                        href="index.php?page=user&aksi=reset_password&id=<?= $row['appusrID'] ?>"
                                        onclick="return confirm('Reset password user ini ke \'123\'?')"
                                        class="p-2 bg-yellow-100 text-yellow-600 rounded-lg hover:bg-yellow-200 transition duration-200"
                                        title="Reset Password"
                                    >
                                        <i class="fas fa-key"></i>
                                    </a>
                                    
                                    <!-- Toggle Status Button -->
                                    <?php if($row['appusrID'] != $_SESSION['userid']): ?>
                                        <a 
                                            href="index.php?page=user&aksi=toggle_status&id=<?= $row['appusrID'] ?>"
                                            onclick="return confirm('Ubah status user ini?')"
                                            class="p-2 bg-purple-100 text-purple-600 rounded-lg hover:bg-purple-200 transition duration-200"
                                            title="Toggle Status"
                                        >
                                            <i class="fas fa-power-off"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <a 
                                            href="index.php?page=user&aksi=delete&id=<?= $row['appusrID'] ?>"
                                            onclick="return confirm('Yakin ingin menghapus user ini?')"
                                            class="p-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition duration-200"
                                            title="Hapus User"
                                        >
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-xs text-gray-500 italic px-2">(Anda)</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                                <h3 class="text-xl font-semibold text-gray-600 mb-2">Tidak ada data user</h3>
                                <p class="text-gray-500 mb-4">Belum ada user yang terdaftar atau tidak sesuai pencarian</p>
                                <a 
                                    href="index.php?page=user&aksi=tambah"
                                    class="inline-flex items-center px-6 py-3 bg-primary-600 text-white font-semibold rounded-xl hover:bg-primary-700 transition duration-200"
                                >
                                    <i class="fas fa-plus mr-2"></i>
                                    Tambah User Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Table Footer -->
    <div class="bg-gray-50 px-6 py-4 border-t">
        <div class="flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Menampilkan <span class="font-semibold"><?= $rows->num_rows ?></span> user
            </p>
            <div class="flex items-center space-x-2">
                <a href="#" class="px-3 py-1 bg-white border rounded-lg text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-chevron-left"></i>
                </a>
                <span class="px-3 py-1 bg-primary-600 text-white rounded-lg font-semibold">1</span>
                <a href="#" class="px-3 py-1 bg-white border rounded-lg text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>