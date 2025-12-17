<!-- Sidebar Overlay (Mobile) -->
<div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-40 hidden lg:hidden"></div>

<!-- Sidebar -->
<aside id="sidebar" class="sidebar no-print fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 w-80 bg-gradient-to-b from-indigo-50 to-white shadow-xl z-40 overflow-y-auto">
    
    <!-- Sidebar Header -->
    <div class="sticky top-0 bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-700 p-6 z-10 shadow-lg">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-xl transform hover:scale-105 transition-transform">
                    <i class="fas fa-graduation-cap text-2xl text-indigo-600"></i>
                </div>
                <div>
                    <h1 class="text-white font-bold text-2xl tracking-tight">SIAK</h1>
                    <p class="text-indigo-200 text-xs font-medium">Sistem Akademik</p>
                </div>
            </div>
            <button id="closeSidebarBtn" class="lg:hidden text-white hover:bg-white/20 rounded-xl p-2 transition-all">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>
        
        <!-- User Info -->
        <div class="bg-white/15 backdrop-blur-md rounded-2xl p-4 border border-white/20 shadow-lg">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-md">
                    <i class="fas fa-user text-indigo-600 text-lg"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-white font-semibold text-sm truncate">
                        <?= htmlspecialchars($_SESSION['user']) ?>
                    </p>
                    <p class="text-indigo-200 text-xs font-medium mt-0.5">
                        <?= htmlspecialchars($_SESSION['grup'] ?? 'User') ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <nav class="p-5 space-y-2">
        
        <!-- Menu Utama -->
        <div class="mb-6">
            <p class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                Menu Utama
            </p>
            
            <a href="index.php?page=beranda" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group">
                <i class="fas fa-home w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Beranda</span>
            </a>
            
            <a href="index.php?page=contentMahasiswa" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group">
                <i class="fas fa-users w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Mahasiswa</span>
            </a>
            
            <!-- ACCORDION MENU: Pra Kuliah -->
            <div class="menu-accordion mt-2">
                <button 
                    onclick="toggleAccordion('prakuliah')"
                    class="sidebar-link accordion-trigger flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group"
                    data-menu="prakuliah"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clipboard-list w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold">Pra Kuliah</span>
                    </div>
                    <i class="fas fa-chevron-down accordion-icon transition-transform duration-300"></i>
                </button>
                
                <!-- Sub Menu Pra Kuliah -->
                <div id="submenu-prakuliah" class="accordion-content overflow-hidden transition-all duration-300 max-h-0">
                    <div class="ml-6 mt-2 space-y-1 border-l-2 border-indigo-200 pl-4">
                        <a href="index.php?page=daftarKelas" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Daftar Kelas</span>
                        </a>
                        <a href="index.php?page=daftarMatkulKelas" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Daftar Mata Kuliah</span>
                        </a>
                        <a href="index.php?page=daftarDosenKelas" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Dosen Kelas</span>
                        </a>
                        <a href="index.php?page=daftarMahasiswaKelas" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Mahasiswa Kelas</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- ACCORDION MENU: Perkuliahan -->
            <div class="menu-accordion mt-2">
                <button 
                    onclick="toggleAccordion('perkuliahan')"
                    class="sidebar-link accordion-trigger flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group"
                    data-menu="perkuliahan"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-chalkboard-teacher w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold">Perkuliahan</span>
                    </div>
                    <i class="fas fa-chevron-down accordion-icon transition-transform duration-300"></i>
                </button>
                
                <!-- Sub Menu Perkuliahan -->
                <div id="submenu-perkuliahan" class="accordion-content overflow-hidden transition-all duration-300 max-h-0">
                    <div class="ml-6 mt-2 space-y-1 border-l-2 border-indigo-200 pl-4">
                        <a href="index.php?page=halamanKosong" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Jadwal Kuliah</span>
                        </a>
                        <a href="index.php?page=halamanKosong" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Modul Kuliah</span>
                        </a>
                        <a href="index.php?page=halamanKosong" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Presensi Kuliah</span>
                        </a>
                        <a href="index.php?page=halamanKosong" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Surat Peringatan</span>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- ACCORDION MENU: Pasca Kuliah -->
            <div class="menu-accordion mt-2">
                <button 
                    onclick="toggleAccordion('pascakuliah')"
                    class="sidebar-link accordion-trigger flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group"
                    data-menu="pascakuliah"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user-graduate w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold">Pasca Kuliah</span>
                    </div>
                    <i class="fas fa-chevron-down accordion-icon transition-transform duration-300"></i>
                </button>
                
                <!-- Sub Menu Pasca Kuliah -->
                <div id="submenu-pascakuliah" class="accordion-content overflow-hidden transition-all duration-300 max-h-0">
                    <div class="ml-6 mt-2 space-y-1 border-l-2 border-indigo-200 pl-4">
                        <a href="index.php?page=raporSemester" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Rapor Semester</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Master -->
        <div class="mb-6">
            <p class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                Data Master
            </p>
            <div class="menu-accordion">
                <button 
                    type="button"
                    onclick="toggleAccordion('dataMaster')"
                    class="sidebar-link accordion-trigger flex items-center justify-between w-full px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group"
                    data-menu="dataMaster"
                >
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-database w-5 text-center group-hover:scale-110 transition-transform"></i>
                        <span class="font-semibold">Data Master</span>
                    </div>
                    <i class="fas fa-chevron-down accordion-icon transition-transform duration-300"></i>
                </button>
                
                <div id="submenu-dataMaster" class="accordion-content overflow-hidden transition-all duration-300 max-h-0">
                    <div class="ml-6 mt-2 space-y-1 border-l-2 border-indigo-200 pl-4">
                        <a href="index.php?page=kelas" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Kelas</span>
                        </a>
                        <a href="index.php?page=jurusan" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Jurusan</span>
                        </a>
                        <a href="index.php?page=prodi" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Program Studi</span>
                        </a>
                        <a href="index.php?page=matkul" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Mata Kuliah</span>
                        </a>
                        <a href="index.php?page=dosen" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Dosen</span>
                        </a>
                        <a href="index.php?page=mahasiswa" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Mahasiswa</span>
                        </a>
                        <a href="index.php?page=kurikulum" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Kurikulum</span>
                        </a>
                        <a href="index.php?page=tahun_akademik" class="sidebar-link submenu-link flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm text-gray-600 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <i class="fas fa-circle text-xs"></i>
                            <span class="font-medium">Tahun Akademik</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <a href="index.php?page=user" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group">
            <i class="fas fa-user-cog w-5 text-center group-hover:scale-110 transition-transform"></i>
            <span class="font-semibold">User</span>
        </a>

        <!-- Pengaturan -->
        <div class="mb-4 pt-4 border-t border-gray-200">
            <p class="px-3 py-2 text-xs font-bold text-gray-500 uppercase tracking-wider">
                Pengaturan
            </p>
            
            <a href="index.php?page=password" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-xl text-gray-700 hover:bg-gradient-to-r hover:from-indigo-50 hover:to-purple-50 hover:text-indigo-600 transition-all duration-200 group">
                <i class="fas fa-key w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Ubah Password</span>
            </a>
            
            <a href="index.php?page=logout" onclick="return confirm('Yakin ingin logout?')" class="sidebar-link flex items-center space-x-3 px-4 py-3.5 rounded-xl text-red-600 hover:bg-red-50 hover:shadow-md transition-all duration-200 group">
                <i class="fas fa-sign-out-alt w-5 text-center group-hover:scale-110 transition-transform"></i>
                <span class="font-semibold">Logout</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="sticky bottom-0 bg-gradient-to-t from-white via-indigo-50 to-transparent p-4 border-t border-indigo-100">
        <div class="text-center text-xs text-gray-600">
            <p class="font-semibold">&copy; <?= date('Y') ?> SIAK</p>
            <p class="mt-1 text-gray-500">Sistem Informasi Akademik</p>
            <p class="mt-0.5 text-indigo-600 font-medium">Risqa Putri Hanifa</p>
        </div>
    </div>

</aside>

<!-- Main Content Wrapper -->
<main class="flex-1 lg:ml-0 overflow-x-hidden">
    
    <!-- Top Bar -->
    <div class="no-print sticky top-0 z-30 bg-white border-b shadow-sm">
        <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
                <button id="mobileMenuBtn" class="lg:hidden p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-2xl font-bold text-gray-800" id="pageTitle">Dashboard</h2>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="relative p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
                
                <button class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg">
                    <i class="fas fa-search text-xl"></i>
                </button>
                
                <div class="relative">
                    <button class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded-lg">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-500 rounded-full flex items-center justify-center">
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
    /* Scrollbar Styling */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }
    
    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.3);
        border-radius: 10px;
    }
    
    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(99, 102, 241, 0.5);
    }

    /* Active States */
    .sidebar-link.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .accordion-trigger.active {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .accordion-trigger.active .accordion-icon {
        transform: rotate(180deg);
    }
    
    .submenu-link.active {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(118, 75, 162, 0.15) 100%);
        color: #667eea;
        font-weight: 700;
        border-left: 3px solid #667eea;
    }
    
    /* Hover Effects */
    .sidebar-link:hover {
        transform: translateX(2px);
    }
    
    /* Mobile Animation */
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
function toggleAccordion(menuId) {
    const submenu = document.getElementById(`submenu-${menuId}`);
    const trigger = document.querySelector(`[data-menu="${menuId}"]`);
    const isOpen = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';
    
    document.querySelectorAll('.accordion-content').forEach(content => {
        content.style.maxHeight = '0px';
    });
    
    document.querySelectorAll('.accordion-trigger').forEach(btn => {
        btn.classList.remove('active');
    });
    
    if (!isOpen) {
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        trigger.classList.add('active');
        localStorage.setItem('activeAccordion', menuId);
    } else {
        localStorage.removeItem('activeAccordion');
    }
}

function initializeAccordionState() {
    const currentPage = new URLSearchParams(window.location.search).get('page') || 'beranda';
    
    const pageAccordionMap = {
        'daftarKelas': 'prakuliah',
        'daftarMatkulKelas': 'prakuliah',
        'daftarDosenKelas': 'prakuliah',
        'daftarMahasiswaKelas': 'prakuliah',
        'raporSemester': 'pascakuliah',
        'kelas': 'dataMaster',
        'jurusan': 'dataMaster',
        'prodi': 'dataMaster',
        'matkul': 'dataMaster',
        'dosen': 'dataMaster',
        'mahasiswa': 'dataMaster',
        'kurikulum': 'dataMaster',
        'tahun_akademik': 'dataMaster',
        'user': 'dataMaster'
    };
    
    const accordionId = pageAccordionMap[currentPage];
    
    if (accordionId) {
        const submenu = document.getElementById(`submenu-${accordionId}`);
        const trigger = document.querySelector(`[data-menu="${accordionId}"]`);
        
        if (submenu && trigger) {
            submenu.style.transition = 'none';
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
            trigger.classList.add('active');
            
            setTimeout(() => {
                submenu.style.transition = 'max-height 0.3s ease';
            }, 10);
            
            localStorage.setItem('activeAccordion', accordionId);
        }
    }
}

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

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
        closeSidebar();
    }
});

const currentPage = new URLSearchParams(window.location.search).get('page') || 'beranda';

document.querySelectorAll('.sidebar-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href && href.includes(`page=${currentPage}`)) {
        link.classList.add('active');
        link.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }
});

const pageTitles = {
    'beranda': 'Dashboard',
    'contentMahasiswa': 'Mahasiswa',
    'pascakuliah': 'Pasca Kuliah',
    'raporSemester': 'Rapor Semester',
    'daftarKelas': 'Daftar Kelas',
    'daftarMatkulKelas': 'Daftar Mata Kuliah',
    'daftarDosenKelas': 'Dosen Kelas',
    'daftarMahasiswaKelas': 'Mahasiswa Kelas',
    'user': 'Manajemen User',
    'kelas': 'Data Kelas',
    'jurusan': 'Data Jurusan',
    'prodi': 'Program Studi',
    'matkul': 'Mata Kuliah',
    'dosen': 'Data Dosen',
    'mahasiswa': 'Data Mahasiswa',
    'kurikulum': 'Data Kurikulum',
    'tahun_akademik': 'Tahun Akademik',
    'password': 'Ubah Password'
};

const pageTitle = document.getElementById('pageTitle');
if (pageTitle && pageTitles[currentPage]) {
    pageTitle.textContent = pageTitles[currentPage];
}

document.addEventListener('DOMContentLoaded', function() {
    initializeAccordionState();
});
</script>