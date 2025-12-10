<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                Pra Kuliah
            </h1>
            <p class="text-white/90">Kelola data kelas dan persiapan perkuliahan</p>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
            <i class="fas fa-clipboard-list text-2xl"></i>
            <div class="text-sm">
                <p class="font-semibold"><?= date('d F Y') ?></p>
                <p class="opacity-90">Manajemen Pra Kuliah</p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Menu -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Menu Pra Kuliah</h2>
        <p class="text-gray-600 text-sm">Pilih menu untuk mengelola data</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <!-- Menu 1: Daftar Kelas -->
        <a href="index.php?page=daftarKelas" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-300 transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-door-open text-3xl text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Daftar Kelas</h3>
                <p class="text-gray-600 text-sm mb-4">Lihat dan kelola daftar kelas berdasarkan tahun akademik</p>
                <div class="mt-auto pt-4 border-t border-gray-100 w-full">
                    <div class="flex items-center justify-center text-purple-600 font-semibold text-sm group-hover:translate-x-1 transition duration-300">
                        Buka Menu
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Menu 2: Daftar Mata Kuliah -->
        <a href="index.php?page=daftarMatkulKelas" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-300 transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-book text-3xl text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Daftar Mata Kuliah</h3>
                <p class="text-gray-600 text-sm mb-4">Monitor mata kuliah per kelas dan program studi</p>
                <div class="mt-auto pt-4 border-t border-gray-100 w-full">
                    <div class="flex items-center justify-center text-blue-600 font-semibold text-sm group-hover:translate-x-1 transition duration-300">
                        Buka Menu
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Menu 3: Dosen Kelas -->
        <a href="index.php?page=daftarDosenKelas" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-300 transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-chalkboard-teacher text-3xl text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Dosen Kelas</h3>
                <p class="text-gray-600 text-sm mb-4">Lihat pembagian dosen pengampu per kelas</p>
                <div class="mt-auto pt-4 border-t border-gray-100 w-full">
                    <div class="flex items-center justify-center text-green-600 font-semibold text-sm group-hover:translate-x-1 transition duration-300">
                        Buka Menu
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>

        <!-- Menu 4: Mahasiswa Kelas -->
        <a href="index.php?page=daftarMahasiswaKelas" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-orange-300 transform hover:-translate-y-2">
            <div class="flex flex-col items-center text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-4 group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-user-graduate text-3xl text-white"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Mahasiswa Kelas</h3>
                <p class="text-gray-600 text-sm mb-4">Kelola daftar mahasiswa berdasarkan kelas</p>
                <div class="mt-auto pt-4 border-t border-gray-100 w-full">
                    <div class="flex items-center justify-center text-orange-600 font-semibold text-sm group-hover:translate-x-1 transition duration-300">
                        Buka Menu
                        <i class="fas fa-arrow-right ml-2"></i>
                    </div>
                </div>
            </div>
        </a>
    </div>
</div>


<style>
/* Custom Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.group:hover .group-hover\:scale-110 {
    transform: scale(1.1);
}

.group:hover .group-hover\:translate-x-1 {
    transform: translateX(4px);
}
</style>

<?php include "views/layout/footer.php"; ?>