<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Welcome Section -->
<div class="bg-gradient-to-r from-primary-600 to-secondary-600 rounded-2xl p-8 mb-8 text-white shadow-xl">
    <div class="flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-3xl font-bold mb-2">
                Selamat Datang, <?= htmlspecialchars($_SESSION['user']) ?>! 👋
            </h1>
            <p class="text-white/90">Sistem Informasi Akademik Modern - Dashboard Overview</p>
        </div>
        <div class="flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-xl">
            <i class="fas fa-calendar-alt text-2xl"></i>
            <div class="text-sm">
                <p class="font-semibold"><?= date('d F Y') ?></p>
                <p class="opacity-90"><?= date('l') ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    
    <!-- Card 1: Mahasiswa -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-user-graduate text-2xl text-blue-600"></i>
            </div>
            <span class="bg-blue-100 text-blue-600 text-xs font-semibold px-3 py-1 rounded-full">
                +12%
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Mahasiswa</h3>
        <p class="text-3xl font-bold text-gray-800">1,234</p>
        <a href="index.php?page=mahasiswa" class="mt-4 text-sm text-blue-600 hover:text-blue-700 font-medium inline-flex items-center">
            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <!-- Card 2: Dosen -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-2xl text-green-600"></i>
            </div>
            <span class="bg-green-100 text-green-600 text-xs font-semibold px-3 py-1 rounded-full">
                +5%
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Dosen</h3>
        <p class="text-3xl font-bold text-gray-800">156</p>
        <a href="index.php?page=dosen" class="mt-4 text-sm text-green-600 hover:text-green-700 font-medium inline-flex items-center">
            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <!-- Card 3: Kelas -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-door-open text-2xl text-purple-600"></i>
            </div>
            <span class="bg-purple-100 text-purple-600 text-xs font-semibold px-3 py-1 rounded-full">
                24
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Total Kelas</h3>
        <p class="text-3xl font-bold text-gray-800">48</p>
        <a href="index.php?page=kelas" class="mt-4 text-sm text-purple-600 hover:text-purple-700 font-medium inline-flex items-center">
            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>

    <!-- Card 4: Mata Kuliah -->
    <div class="bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 border border-gray-100 card-hover">
        <div class="flex items-center justify-between mb-4">
            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center">
                <i class="fas fa-book text-2xl text-orange-600"></i>
            </div>
            <span class="bg-orange-100 text-orange-600 text-xs font-semibold px-3 py-1 rounded-full">
                Active
            </span>
        </div>
        <h3 class="text-gray-500 text-sm font-medium mb-1">Mata Kuliah</h3>
        <p class="text-3xl font-bold text-gray-800">342</p>
        <a href="index.php?page=matkul" class="mt-4 text-sm text-orange-600 hover:text-orange-700 font-medium inline-flex items-center">
            Lihat Detail <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</div>

<!-- Quick Access Menu -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Akses Cepat</h2>
        <button class="text-sm text-gray-600 hover:text-gray-800 font-medium">
            Lihat Semua <i class="fas fa-arrow-right ml-2"></i>
        </button>
    </div>
    
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        
        <!-- Menu 1 -->
        <a href="index.php?page=contentMahasiswa" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 text-center card-hover border border-gray-100">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <i class="fas fa-users text-2xl text-white"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800">Mahasiswa</p>
        </a>

        <!-- Menu 2 -->
        <a href="index.php?page=prakuliah" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 text-center card-hover border border-gray-100">
            <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <i class="fas fa-clipboard-list text-2xl text-white"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800">Pra Kuliah</p>
        </a>

        <!-- Menu 3 -->
        <a href="index.php?page=perkuliahan" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 text-center card-hover border border-gray-100">
            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <i class="fas fa-chalkboard-teacher text-2xl text-white"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800">Perkuliahan</p>
        </a>

        <!-- Menu 4 -->
        <a href="index.php?page=pascakuliah" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 text-center card-hover border border-gray-100">
            <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <i class="fas fa-user-graduate text-2xl text-white"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800">Pasca Kuliah</p>
        </a>

    

        <!-- Menu 6 -->
        <a href="index.php?page=password" class="group bg-white rounded-2xl p-6 shadow-lg hover:shadow-xl transition duration-300 text-center card-hover border border-gray-100">
            <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition duration-300">
                <i class="fas fa-user-cog text-2xl text-white"></i>
            </div>
            <p class="text-sm font-semibold text-gray-800">User</p>
        </a>
    </div>
</div>

<!-- Recent Activity & Announcements -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    
    <!-- Recent Activity -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">Aktivitas Terbaru</h3>
            <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="flex items-start space-x-4 p-4 bg-blue-50 rounded-xl hover:bg-blue-100 transition">
                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-user-plus text-white"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">Mahasiswa Baru Terdaftar</p>
                    <p class="text-xs text-gray-600 mt-1">John Doe berhasil mendaftar</p>
                    <p class="text-xs text-gray-500 mt-1">2 menit yang lalu</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 bg-green-50 rounded-xl hover:bg-green-100 transition">
                <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-check text-white"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">Kelas Diupdate</p>
                    <p class="text-xs text-gray-600 mt-1">Kelas III.A telah diperbarui</p>
                    <p class="text-xs text-gray-500 mt-1">15 menit yang lalu</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 bg-purple-50 rounded-xl hover:bg-purple-100 transition">
                <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-book text-white"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-800">Mata Kuliah Baru</p>
                    <p class="text-xs text-gray-600 mt-1">Algoritma Pemrograman ditambahkan</p>
                    <p class="text-xs text-gray-500 mt-1">1 jam yang lalu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Announcements -->
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-gray-800">Pengumuman</h3>
            <button class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                Lihat Semua
            </button>
        </div>
        
        <div class="space-y-4">
            <div class="border-l-4 border-blue-500 bg-blue-50 p-4 rounded-r-xl hover:bg-blue-100 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Penerimaan Mahasiswa Baru</p>
                        <p class="text-xs text-gray-600 mt-1">Pendaftaran dibuka mulai 1 Januari 2025</p>
                    </div>
                    <span class="bg-blue-500 text-white text-xs px-2 py-1 rounded-full">New</span>
                </div>
            </div>

            <div class="border-l-4 border-orange-500 bg-orange-50 p-4 rounded-r-xl hover:bg-orange-100 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Libur Semester</p>
                        <p class="text-xs text-gray-600 mt-1">Semester gasal berakhir 15 Desember 2024</p>
                    </div>
                    <span class="bg-orange-500 text-white text-xs px-2 py-1 rounded-full">Important</span>
                </div>
            </div>

            <div class="border-l-4 border-green-500 bg-green-50 p-4 rounded-r-xl hover:bg-green-100 transition">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-gray-800">Update Sistem</p>
                        <p class="text-xs text-gray-600 mt-1">SIAKAD versi 2.0 telah diluncurkan</p>
                    </div>
                    <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">Update</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "views/layout/footer.php"; ?>