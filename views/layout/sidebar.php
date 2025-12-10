<!-- Sidebar Overlay (Mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="sidebar no-print fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 w-72 bg-white shadow-2xl z-40 overflow-y-auto">
    
    <!-- Sidebar Header -->
    <div class="sticky top-0 bg-gradient-to-r from-primary-600 to-secondary-600 p-6 z-10">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg">
                    <i class="fas fa-graduation-cap text-2xl text-primary-600"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-xl">SIAKAD</h1>
                    <p class="text-white text-xs opacity-90">Sistem Akademik</p>
                </div>
            </div>
            <button id="closeSidebarBtn" class="lg:hidden text-white hover:bg-white/20 rounded-lg p-2">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- User Info -->
        <div class="mt-4 bg-white/10 backdrop-blur-sm rounded-xl p-3 border border-white/20">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-primary-600"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm truncate">
                        <?= htmlspecialchars($_SESSION['user']) ?>
                    </p>
                    <p class="text-white text-xs opacity-75">
                        <?= htmlspecialchars($_SESSION['grup'] ?? 'User') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-4 space-y-1">
        
        <!-- Menu Utama -->
        <div class="mb-4">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Menu Utama
            </p>
            
            <a href="index.php?page=beranda" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-home w-5 text-center"></i>
                <span class="font-medium">Beranda</span>
            </a>
            
            <a href="index.php?page=contentMahasiswa" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-users w-5 text-center"></i>
                <span class="font-medium">Mahasiswa</span>
            </a>
            
            <a href="index.php?page=prakuliah" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-clipboard-list w-5 text-center"></i>
                <span class="font-medium">Pra Kuliah</span>
            </a>
            
            <a href="index.php?page=perkuliahan" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-chalkboard-teacher w-5 text-center"></i>
                <span class="font-medium">Perkuliahan</span>
            </a>
            
            <a href="index.php?page=pascakuliah" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-user-graduate w-5 text-center"></i>
                <span class="font-medium">Pasca Kuliah</span>
            </a>
            
            <a href="index.php?page=user" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-user-cog w-5 text-center"></i>
                <span class="font-medium">User</span>
            </a>
        </div>

        <!-- Data Master -->
        <div class="mb-4">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Data Master
            </p>
            
            <a href="index.php?page=kelas" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-door-open w-5 text-center"></i>
                <span class="font-medium">Kelas</span>
            </a>
            
            <a href="index.php?page=jurusan" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-folder w-5 text-center"></i>
                <span class="font-medium">Jurusan</span>
            </a>
            
            <a href="index.php?page=prodi" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-folder-open w-5 text-center"></i>
                <span class="font-medium">Program Studi</span>
            </a>
            
            <a href="index.php?page=kurikulum" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-book-open w-5 text-center"></i>
                <span class="font-medium">Kurikulum</span>
            </a>
            
            <a href="index.php?page=matkul" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-book w-5 text-center"></i>
                <span class="font-medium">Mata Kuliah</span>
            </a>
            
            <a href="index.php?page=dosen" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-chalkboard-user w-5 text-center"></i>
                <span class="font-medium">Dosen</span>
            </a>
            
            <a href="index.php?page=mahasiswa" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-user-graduate w-5 text-center"></i>
                <span class="font-medium">Mahasiswa</span>
            </a>
            
            <a href="index.php?page=tahun_akademik" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-calendar-alt w-5 text-center"></i>
                <span class="font-medium">Tahun Akademik</span>
            </a>
        </div>

        <!-- User Menu -->
        <div class="mb-4">
            <p class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                Pengaturan
            </p>
            
            <a href="index.php?page=password" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-gray-700 hover:bg-primary-50 hover:text-primary-600 group">
                <i class="fas fa-key w-5 text-center"></i>
                <span class="font-medium">Ubah Password</span>
            </a>
            
            <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')" class="sidebar-link flex items-center space-x-3 px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 group">
                <i class="fas fa-sign-out-alt w-5 text-center"></i>
                <span class="font-medium">Logout</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sticky bottom-0 bg-gray-50 p-4 border-t">
        <div class="text-center text-xs text-gray-500">
            <p>&copy; <?= date('Y') ?> SIAK</p>
            <p class="mt-1">Sistem Informasi Akademik</p>
        </div>
    </div>

</aside>

<!-- Main Content Wrapper -->
<main class="flex-1 lg:ml-0 overflow-x-hidden">
    
    <!-- Top Bar -->
    <div class="no-print sticky top-0 z-30 bg-white border-b shadow-sm">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <h2 class="text-2xl font-bold text-gray-800" id="pageTitle">Dashboard</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <!-- Search -->
                <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-search text-xl"></i>
                </button>
                
                <!-- User Menu -->
                <div class="relative">
                    <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg">
                        <div class="w-8 h-8 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-sm">
                                <?= strtoupper(substr($_SESSION['user'], 0, 1)) ?>
                            </span>
                        </div>
                        <i class="fas fa-chevron-down text-gray-600 text-sm"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="p-6">

<style>
    /* Sidebar Active Link */
    .sidebar-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    /* Mobile Menu Animation */
    @keyframes slideIn {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }
    
    .mobile-menu-open {
        animation: slideIn 0.3s ease;
    }
</style>

<script>
// Mobile Menu Toggle
const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const closeSidebarBtn = document.getElementById('closeSidebarBtn');
const sidebar = document.getElementById('sidebar');
const sidebarOverlay = document.getElementById('sidebarOverlay');

function openSidebar() {
    sidebar.classList.remove('-translate-x-full');
    sidebar.classList.add('mobile-menu-open');
    sidebarOverlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeSidebar() {
    sidebar.classList.add('-translate-x-full');
    sidebar.classList.remove('mobile-menu-open');
    sidebarOverlay.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

mobileMenuBtn?.addEventListener('click', openSidebar);
closeSidebarBtn?.addEventListener('click', closeSidebar);
sidebarOverlay?.addEventListener('click', closeSidebar);

// Close sidebar on ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
        closeSidebar();
    }
});

// Active Link Highlighting
const currentPage = new URLSearchParams(window.location.search).get('page') || 'beranda';
document.querySelectorAll('.sidebar-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.includes(`page=${currentPage}`)) {
        link.classList.add('active');
        // Smooth scroll into view for active link
        link.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

// Update Page Title dynamically
const pageTitles = {
    'beranda': 'Dashboard',
    'contentMahasiswa': 'Mahasiswa',
    'prakuliah': 'Pra Kuliah',
    'perkuliahan': 'Perkuliahan',
    'pascakuliah': 'Pasca Kuliah',
    'dataMaster': 'Data Master',
    'user': 'Manajemen User',
    'kelas': 'Data Kelas',
    'jurusan': 'Data Jurusan',
    'prodi': 'Program Studi',
    'kurikulum': 'Kurikulum',
    'matkul': 'Mata Kuliah',
    'dosen': 'Data Dosen',
    'mahasiswa': 'Data Mahasiswa',
    'tahun_akademik': 'Tahun Akademik',
    'password': 'Ubah Password'
};

const pageTitle = document.getElementById('pageTitle');
if (pageTitle && pageTitles[currentPage]) {
    pageTitle.textContent = pageTitles[currentPage];
}

// Add smooth hover effect
document.querySelectorAll('.sidebar-link').forEach(link => {
    link.addEventListener('mouseenter', function() {
        this.style.transform = 'translateX(4px)';
    });
    link.addEventListener('mouseleave', function() {
        this.style.transform = 'translateX(0)';
    });
});
</script>