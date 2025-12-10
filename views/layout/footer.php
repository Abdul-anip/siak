</div> <!-- End Content Area -->
    
    <!-- Footer -->
    <footer class="no-print bg-white border-t mt-12">
        <div class="px-6 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <p class="text-gray-600 text-sm">
                        &copy; <?= date('Y') ?> <span class="font-semibold text-gray-800">SIAK</span>. 
                        
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Sistem Informasi Akademik
                    </p>
                </div>
                
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition">
                        <i class="fas fa-question-circle"></i>
                        <span class="ml-2 text-sm">Bantuan</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition">
                        <i class="fas fa-book"></i>
                        <span class="ml-2 text-sm">Dokumentasi</span>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary-600 transition">
                        <i class="fas fa-envelope"></i>
                        <span class="ml-2 text-sm">Kontak</span>
                    </a>
                </div>
            </div>
        </div>
    </footer>

</main> <!-- End Main Content -->

</div> <!-- End Flex Container -->

<!-- Toast Notification Container -->
<div id="toastContainer" class="fixed bottom-4 right-4 z-50 space-y-2"></div>

<script>
// Toast Notification System
function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    
    const icons = {
        success: 'fa-check-circle',
        error: 'fa-exclamation-circle',
        warning: 'fa-exclamation-triangle',
        info: 'fa-info-circle'
    };
    
    const colors = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        warning: 'bg-yellow-500',
        info: 'bg-blue-500'
    };
    
    toast.className = `${colors[type]} text-white px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 transform transition-all duration-300 translate-x-full`;
    toast.innerHTML = `
        <i class="fas ${icons[type]} text-xl"></i>
        <span class="font-medium">${message}</span>
        <button onclick="this.parentElement.remove()" class="ml-4 hover:bg-white/20 rounded p-1">
            <i class="fas fa-times"></i>
        </button>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => toast.classList.remove('translate-x-full'), 100);
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

// Smooth Scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Auto-hide alerts after 5 seconds
setTimeout(() => {
    document.querySelectorAll('.alert-auto-hide').forEach(alert => {
        alert.style.transition = 'opacity 0.5s ease';
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>

</body>
</html>