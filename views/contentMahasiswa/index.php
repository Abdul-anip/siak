<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                Manajemen Data Mahasiswa
            </h1>
            <p class="text-white/90">Kelola seluruh data dan aktivitas mahasiswa</p>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
            <i class="fas fa-user-graduate text-2xl"></i>
            <div class="text-sm">
                <p class="font-semibold">Total Mahasiswa</p>
                <p class="opacity-90 text-xl font-bold">1,234</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Menu -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Menu Mahasiswa</h2>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Menu 1: Data Mahasiswa -->
        <a href="index.php?page=mahasiswa" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-users text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Data Mahasiswa</h3>
            <p class="text-gray-600 text-sm">Kelola data lengkap mahasiswa dan profil akademik</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-blue-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 2: Aktivitas Kuliah -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-chalkboard-teacher text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-green-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Aktivitas Kuliah</h3>
            <p class="text-gray-600 text-sm">Monitor kehadiran dan kegiatan perkuliahan mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-green-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 3: Pembayaran UKT -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-money-bill-wave text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-purple-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Pembayaran UKT</h3>
            <p class="text-gray-600 text-sm">Kelola pembayaran dan verifikasi UKT mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-purple-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 4: Tagihan Pembayaran -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-orange-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-file-invoice-dollar text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-orange-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tagihan Pembayaran</h3>
            <p class="text-gray-600 text-sm">Monitor tagihan dan riwayat pembayaran mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-orange-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 5: File Foto KTM -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-pink-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-id-card text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-pink-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">File Foto KTM</h3>
            <p class="text-gray-600 text-sm">Kelola dan verifikasi foto untuk Kartu Tanda Mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-pink-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 6: File Foto Wisuda -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-indigo-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-user-graduate text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">File Foto Wisuda</h3>
            <p class="text-gray-600 text-sm">Kelola dokumentasi foto untuk keperluan wisuda</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-indigo-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>
    </div>
</div>


<style>
/* Card Hover Animation */
.card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Gradient Text */
.gradient-text {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}
</style>

<?php include "views/layout/footer.php"; ?>