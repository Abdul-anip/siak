<?php
include "views/layout/header.php";
include "views/layout/sidebar.php";
?>

<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-key text-primary-600 mr-3"></i>
                Ubah Password
            </h1>
            <p class="text-gray-600 mt-2">Perbarui password akun Anda untuk keamanan yang lebih baik</p>
        </div>
    </div>
</div>

<!-- Alert Messages -->
<?php if(isset($error)): ?>
    <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-6 rounded-xl shadow-sm alert-auto-hide">
        <div class="flex items-start">
            <i class="fas fa-exclamation-circle text-red-500 text-2xl mt-0.5"></i>
            <div class="ml-4">
                <h3 class="text-red-800 font-semibold text-lg">Gagal Mengubah Password</h3>
                <p class="text-red-700 mt-1"><?= htmlspecialchars($error) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(isset($success)): ?>
    <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-6 rounded-xl shadow-sm alert-auto-hide">
        <div class="flex items-start">
            <i class="fas fa-check-circle text-green-500 text-2xl mt-0.5"></i>
            <div class="ml-4">
                <h3 class="text-green-800 font-semibold text-lg">Berhasil!</h3>
                <p class="text-green-700 mt-1"><?= htmlspecialchars($success) ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Change Password Form -->
<div class="max-w-2xl">
    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
        
        <!-- Form Header -->
        <div class="bg-gradient-to-r from-primary-600 to-secondary-600 p-6">
            <div class="flex items-center space-x-3 text-white">
                <i class="fas fa-shield-alt text-3xl"></i>
                <div>
                    <h2 class="text-xl font-bold">Keamanan Akun</h2>
                    <p class="text-sm opacity-90">Pastikan password Anda kuat dan unik</p>
                </div>
            </div>
        </div>

        <!-- Form Body -->
        <form method="post" action="index.php?page=password&aksi=update" class="p-8 space-y-6">
            
            <!-- Current User Info -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Username Aktif</p>
                        <p class="font-bold text-gray-800"><?= htmlspecialchars($_SESSION['user']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Password Lama -->
            <div class="space-y-2">
                <label for="old_password" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-lock text-primary-600 mr-2"></i>Password Lama
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="old_password"
                        name="old_password" 
                        required
                        placeholder="Masukkan password lama Anda"
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                    >
                    <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button 
                        type="button" 
                        onclick="togglePassword('old_password', 'toggleIcon1')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        <i class="fas fa-eye" id="toggleIcon1"></i>
                    </button>
                </div>
            </div>

            <!-- Password Baru -->
            <div class="space-y-2">
                <label for="new_password" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-lock text-primary-600 mr-2"></i>Password Baru
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="new_password"
                        name="new_password" 
                        required
                        minlength="4"
                        placeholder="Masukkan password baru (minimal 4 karakter)"
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                    >
                    <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button 
                        type="button" 
                        onclick="togglePassword('new_password', 'toggleIcon2')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        <i class="fas fa-eye" id="toggleIcon2"></i>
                    </button>
                </div>
                <div id="password-strength" class="hidden mt-2">
                    <div class="flex items-center space-x-2">
                        <div class="flex-1 bg-gray-200 rounded-full h-2">
                            <div id="strength-bar" class="h-2 rounded-full transition-all duration-300"></div>
                        </div>
                        <span id="strength-text" class="text-xs font-medium"></span>
                    </div>
                </div>
            </div>

            <!-- Konfirmasi Password -->
            <div class="space-y-2">
                <label for="confirm_password" class="block text-sm font-semibold text-gray-700">
                    <i class="fas fa-check-circle text-primary-600 mr-2"></i>Konfirmasi Password Baru
                    <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="confirm_password"
                        name="confirm_password" 
                        required
                        placeholder="Ketik ulang password baru"
                        class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                    >
                    <i class="fas fa-redo absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button 
                        type="button" 
                        onclick="togglePassword('confirm_password', 'toggleIcon3')"
                        class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                    >
                        <i class="fas fa-eye" id="toggleIcon3"></i>
                    </button>
                </div>
                <p id="match-message" class="text-xs mt-1 hidden"></p>
            </div>

            <!-- Password Tips -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-lightbulb text-yellow-600 text-xl mt-0.5"></i>
                    <div>
                        <h4 class="font-semibold text-gray-800 mb-2">Tips Password Kuat:</h4>
                        <ul class="text-sm text-gray-700 space-y-1">
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Minimal 8 karakter</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Kombinasi huruf besar dan kecil</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Gunakan angka dan simbol</li>
                            <li class="flex items-center"><i class="fas fa-check text-green-500 mr-2"></i>Hindari kata-kata umum</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-4 border-t">
                <a 
                    href="index.php?page=beranda" 
                    class="inline-flex items-center px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition duration-200"
                >
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
                
                <button 
                    type="submit" 
                    name="change_password"
                    class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200"
                >
                    <i class="fas fa-save mr-2"></i>
                    Simpan Password Baru
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Toggle Password Visibility
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password Strength Checker
const newPassword = document.getElementById('new_password');
const strengthBar = document.getElementById('strength-bar');
const strengthText = document.getElementById('strength-text');
const strengthContainer = document.getElementById('password-strength');

newPassword.addEventListener('input', function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    
    if (password.length > 0) {
        strengthContainer.classList.remove('hidden');
    } else {
        strengthContainer.classList.add('hidden');
    }
    
    updateStrengthUI(strength);
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 4) strength++;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^a-zA-Z\d]/.test(password)) strength++;
    return strength;
}

function updateStrengthUI(strength) {
    const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
    const texts = ['Sangat Lemah', 'Lemah', 'Sedang', 'Kuat', 'Sangat Kuat'];
    const widths = ['20%', '40%', '60%', '80%', '100%'];
    
    strengthBar.className = `h-2 rounded-full transition-all duration-300 ${colors[strength]}`;
    strengthBar.style.width = widths[strength];
    strengthText.textContent = texts[strength];
    strengthText.className = `text-xs font-medium ${colors[strength].replace('bg-', 'text-')}`;
}

// Password Match Checker
const confirmPassword = document.getElementById('confirm_password');
const matchMessage = document.getElementById('match-message');

confirmPassword.addEventListener('input', function() {
    if (this.value.length > 0) {
        if (this.value === newPassword.value) {
            matchMessage.textContent = '✓ Password cocok';
            matchMessage.className = 'text-xs mt-1 text-green-600 font-medium';
            matchMessage.classList.remove('hidden');
        } else {
            matchMessage.textContent = '✗ Password tidak cocok';
            matchMessage.className = 'text-xs mt-1 text-red-600 font-medium';
            matchMessage.classList.remove('hidden');
        }
    } else {
        matchMessage.classList.add('hidden');
    }
});

// Form Validation
const form = document.querySelector('form');
form.addEventListener('submit', function(e) {
    if (newPassword.value !== confirmPassword.value) {
        e.preventDefault();
        alert('Password baru dan konfirmasi password tidak cocok!');
        confirmPassword.focus();
    }
});
</script>

<?php include "views/layout/footer.php"; ?>