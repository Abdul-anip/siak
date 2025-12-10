<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                Pasca Kuliah
            </h1>
            <p class="text-white/90">Manajemen alumni, wisuda, dan layanan pascakuliah</p>
        </div>
    </div>
</div>

<!-- Quick Access Menu -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Menu Pasca Kuliah</h2>
        <p class="text-gray-600 text-sm">Layanan untuk mahasiswa alumni</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Menu 1: Data Alumni -->
        <a href="index.php?page=halamanKosong" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-indigo-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <img src="assets/img/daftar_nilai.png" alt="Data Alumni" class="w-10 h-10">
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Rapor Semester</h3>
            <p class="text-gray-600 text-sm">Lihat Rapor Semester</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-indigo-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>
        
    </div>
</div>



<style>
/* Card Hover Effects */
.card-hover {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.card-hover:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Smooth Transitions */
* {
    transition: all 0.3s ease;
}
</style>

<?php include "views/layout/footer.php"; ?>