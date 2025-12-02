<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Login - SIAKAD</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="center-wrap">
    <div class="card" style="width:350px;background:white;padding:20px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">

        <h2 style="margin-top:0;">LOGIN</h2>

        <?php if(isset($error)): ?>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <p style="color:green"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post" action="index.php?page=login&aksi=login_process">
            <input class="input" type="text" name="username" placeholder="Username" required>
            <input class="input" type="password" name="password" placeholder="Password" required>
            <button class="btn" type="submit" name="login">LOGIN</button>
        </form>

        <hr>
        <p>Belum punya akun?</p>
        <a class="btn" href="index.php?page=login&aksi=register">REGISTER</a>

    </div>
</div>

</body>
</html>
