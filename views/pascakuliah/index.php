<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                🎓 Pasca Kuliah
            </h1>
            <p class="text-white/90">Manajemen alumni, wisuda, dan layanan pascakuliah</p>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
            <i class="fas fa-graduation-cap text-2xl"></i>
            <div class="text-sm">
                <p class="font-semibold">Status</p>
                <p class="opacity-90">Layanan Aktif</p>
            </div>
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
        <a href="index.php?page=alumni" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-indigo-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-user-graduate text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Data Alumni</h3>
            <p class="text-gray-600 text-sm">Kelola database dan profil alumni perguruan tinggi</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-indigo-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 2: Jadwal Wisuda -->
        <a href="index.php?page=jadwalWisuda" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-purple-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-calendar-alt text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-purple-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Jadwal Wisuda</h3>
            <p class="text-gray-600 text-sm">Atur jadwal dan peserta upacara wisuda</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-purple-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 3: Transkrip Nilai -->
        <a href="index.php?page=transkripNilai" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-blue-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-file-alt text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-blue-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Transkrip Nilai</h3>
            <p class="text-gray-600 text-sm">Cetak dan kelola transkrip nilai mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-blue-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 4: Surat Keterangan Lulus -->
        <a href="index.php?page=suratLulus" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-green-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-certificate text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-green-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Surat Keterangan Lulus</h3>
            <p class="text-gray-600 text-sm">Generate dan verifikasi SKL mahasiswa</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-green-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 5: Ijazah -->
        <a href="index.php?page=ijazah" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-orange-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-scroll text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-orange-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Ijazah</h3>
            <p class="text-gray-600 text-sm">Kelola penerbitan dan distribusi ijazah</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-orange-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>

        <!-- Menu 6: Tracer Study -->
        <a href="index.php?page=tracerStudy" class="group bg-white rounded-2xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 hover:border-pink-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center group-hover:scale-110 transition duration-300 shadow-lg">
                    <i class="fas fa-chart-line text-3xl text-white"></i>
                </div>
                <i class="fas fa-arrow-right text-2xl text-gray-300 group-hover:text-pink-500 group-hover:translate-x-1 transition duration-300"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Tracer Study</h3>
            <p class="text-gray-600 text-sm">Pelacakan alumni dan feedback lulusan</p>
            <div class="mt-4 pt-4 border-t border-gray-100">
                <span class="text-pink-600 text-sm font-semibold">Lihat Detail →</span>
            </div>
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Card 1 -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-users text-2xl text-indigo-600"></i>
            </div>
            <span class="bg-indigo-100 text-indigo-600 text-xs font-semibold px-3 py-1 rounded-full">
                2024
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Alumni</h3>
        <p class="text-3xl font-bold text-gray-800">3,456</p>
        <p class="text-xs text-gray-500 mt-2">Terdaftar s/d 2024</p>
    </div>

    <!-- Card 2 -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-graduation-cap text-2xl text-green-600"></i>
            </div>
            <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                Lulus
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Lulus Tahun Ini</h3>
        <p class="text-3xl font-bold text-gray-800">287</p>
        <p class="text-xs text-gray-500 mt-2">Periode 2024</p>
    </div>

    <!-- Card 3 -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-calendar-check text-2xl text-purple-600"></i>
            </div>
            <span class="bg-purple-100 text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">
                Upcoming
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Wisuda Mendatang</h3>
        <p class="text-3xl font-bold text-gray-800">156</p>
        <p class="text-xs text-gray-500 mt-2">15 Januari 2025</p>
    </div>

    <!-- Card 4 -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-briefcase text-2xl text-orange-600"></i>
            </div>
            <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-3 py-1 rounded-full">
                Working
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Alumni Bekerja</h3>
        <p class="text-3xl font-bold text-gray-800">89%</p>
        <p class="text-xs text-gray-500 mt-2">Dari total alumni</p>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
        <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">
            Lihat Semua
        </button>
    </div>
    
    <div class="space-y-4">
        <div class="flex items-start space-x-4 p-4 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
            <div class="w-10 h-10 bg-indigo-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-graduation-cap text-white"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">Wisuda Periode Januari</p>
                <p class="text-xs text-gray-600 mt-1">156 mahasiswa siap diwisuda</p>
                <p class="text-xs text-gray-500 mt-1">Jadwal: 15 Januari 2025</p>
            </div>
        </div>

        <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-certificate text-white"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">SKL Telah Diterbitkan</p>
                <p class="text-xs text-gray-600 mt-1">42 Surat Keterangan Lulus baru</p>
                <p class="text-xs text-gray-500 mt-1">2 jam yang lalu</p>
            </div>
        </div>

        <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-chart-line text-white"></i>
            </div>
            <div class="flex-1">
                <p class="text-sm font-semibold text-gray-800">Tracer Study Update</p>
                <p class="text-xs text-gray-600 mt-1">78 alumni mengisi survei bulan ini</p>
                <p class="text-xs text-gray-500 mt-1">1 hari yang lalu</p>
            </div>
        </div>
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