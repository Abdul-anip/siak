<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIAKAD</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="center-wrap">
    <div class="card">
        <!-- Logo/Title -->
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #3b82f6, #4f46e5); border-radius: 1rem; margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);">
                <span style="color: white; font-size: 2rem; font-weight: bold;">S</span>
            </div>
            <h2 style="margin: 0; font-size: 1.875rem; font-weight: 700; color: #111827;">Selamat Datang</h2>
            <p style="color: #6b7280; margin-top: 0.5rem; font-size: 0.9375rem;">Masuk ke Sistem Informasi Akademik</p>
        </div>

        <!-- Alert Messages -->
        <?php if(isset($error)): ?>
            <div style="padding: 1rem; background: #fee2e2; border: 1px solid #ef4444; border-radius: 0.5rem; margin-bottom: 1.5rem; color: #991b1b;">
                <strong>❌ Error!</strong><br>
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <div style="padding: 1rem; background: #d1fae5; border: 1px solid #10b981; border-radius: 0.5rem; margin-bottom: 1.5rem; color: #065f46;">
                <strong>✅ Berhasil!</strong><br>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="post" action="index.php?page=login&aksi=login_process">
            <label for="username">Username</label>
            <input 
                class="input" 
                type="text" 
                id="username"
                name="username" 
                placeholder="Masukkan username Anda" 
                required
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input 
                class="input" 
                type="password" 
                id="password"
                name="password" 
                placeholder="Masukkan password Anda" 
                required
                autocomplete="current-password"
            >

            <button class="btn" type="submit" name="login" style="width: 100%; margin-top: 0.5rem;">
                🔐 Masuk ke Sistem
            </button>
        </form>

        <!-- Divider -->
        <div style="position: relative; margin: 2rem 0;">
            <hr>
            <span style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 0 1rem; color: #9ca3af; font-size: 0.875rem;">
                ATAU
            </span>
        </div>

        <!-- Register Link -->
        <div style="text-align: center;">
            <p style="color: #6b7280; margin-bottom: 1rem; font-size: 0.9375rem;">Belum punya akun?</p>
            <a class="btn" href="index.php?page=login&aksi=register" style="width: 100%; background: #6b7280;">
                📝 Daftar Sekarang
            </a>
        </div>

        <!-- Footer Note -->
        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb; text-align: center; color: #9ca3af; font-size: 0.8125rem;">
            <p style="margin: 0;">© 2025 SIAKAD. All rights reserved.</p>
        </div>
    </div>
</div>

</body>
</html>