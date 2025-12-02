<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Register - SIAKAD</title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<div class="center-wrap">
    <div class="card" style="width:350px;background:white;padding:20px;border-radius:12px;box-shadow:0 5px 15px rgba(0,0,0,0.1);">

        <h2 style="margin-top:0;">REGISTER</h2>

        <?php if(isset($error)): ?>
            <p style="color:red"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <?php if(isset($success)): ?>
            <p style="color:green"><?= htmlspecialchars($success) ?></p>
        <?php endif; ?>

        <form method="post" action="index.php?page=login&aksi=register_process">
            <input class="input" type="text" name="username" placeholder="Buat Username" required>
            <input class="input" type="password" name="password" placeholder="Buat Password" required>
            <button class="btn" type="submit" name="register">REGISTER</button>
        </form>

        <hr>
        <a class="btn" href="index.php?page=login">Kembali ke Login</a>

    </div>
</div>

</body>
</html>
