<?php
session_start();

/*
  index.php SIAKAD sederhana (CRUD utama)
  Requirements:
*/

/* ------------------- KONFIGURASI KONEKSI ------------------- */
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "db_siak";

$koneksi = new mysqli($db_host, $db_user, $db_pass, $db_name);
if($koneksi->connect_error){
    die("Koneksi gagal: " . $koneksi->connect_error);
}
$koneksi->set_charset("utf8");

// ========================= REGISTER ========================
if(isset($_POST['register'])){

    $u  = $_POST['username'];
    $p  = $_POST['password'];

    // Pastikan user baru langsung aktif
    $sql = "
        INSERT INTO user 
        (appusrNama, appusrPassword, appusrGrupUser, appusrIsEnabled)
        VALUES 
        ('$u', '$p', 'user', 1)
    ";

    $query = $koneksi->query($sql);

    if($query){
        $reg_success = "Registrasi berhasil! Silakan login.";
    } else {
        $reg_error = "Registrasi gagal: " . $koneksi->error;
    }
}

/* ------------------- LOGIN ------------------- */
if(!isset($_SESSION['login']) && isset($_POST['login'])){
    $u = $_POST['username'];
    $p = $_POST['password'];

    $stmt = $koneksi->prepare("
        SELECT appusrID, appusrNama, appusrGrupUser 
        FROM `user` 
        WHERE appusrNama = ? 
        AND appusrPassword = ? 
        AND appusrIsEnabled = 1
    ");

    $stmt->bind_param("ss", $u, $p);
    $stmt->execute();

    $res = $stmt->get_result();

    if($res && $res->num_rows > 0){
        $user = $res->fetch_assoc();
        
        $_SESSION['login'] = true;
        $_SESSION['user']  = $user['appusrNama'];
        $_SESSION['userid'] = $user['appusrID'];
        $_SESSION['grup']  = $user['appusrGrupUser'];

        header("Location: index.php?page=beranda");
        exit;
    } else {
        $error = "Username atau password salah / akun belum aktif.";
    }

    $stmt->close();
}

/* ------------------- LOGOUT ------------------- */
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
    exit;
}

/* ------------------- HELPERS ------------------- */
function h($s){ return htmlspecialchars($s, ENT_QUOTES); }

/* ------------------- PROCESS CRUD ACTIONS -------------------
 We will detect actions via GET parameters like:
 - act=jurusan_add, jurusan_edit, jurusan_delete
 - act=prodi_..., kurikulum_..., matkul_..., dosen_..., mahasiswa_..., thakd_...
----------------------------------------------------------------*/
$act = isset($_GET['act']) ? $_GET['act'] : "";

if(isset($_SESSION['login'])){
    // JURUSAN
    if($act === "jurusan_add" && isset($_POST['save_jurusan'])){
        $kode = $_POST['jurKode'] ?? '';
        $nama = $_POST['jurNama'] ?? '';
        $nama = trim($nama);
        $stmt = $koneksi->prepare("INSERT INTO jurusan (jurKode, jurNama, jurNamaAsing, jurIsAktif) VALUES (?, ?, ?, ?)");
        $is = isset($_POST['jurIsAktif']) ? 1 : 0;
        $as = $_POST['jurNamaAsing'] ?? '';
        $stmt->bind_param("sssi", $kode, $nama, $as, $is);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=jurusan");
        exit;
    }
    if($act === "jurusan_edit" && isset($_POST['update_jurusan'])){
        $id = intval($_POST['jurId']);
        $kode = $_POST['jurKode'] ?? '';
        $nama = trim($_POST['jurNama'] ?? '');
        $as = $_POST['jurNamaAsing'] ?? '';
        $is = isset($_POST['jurIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("UPDATE jurusan SET jurKode=?, jurNama=?, jurNamaAsing=?, jurIsAktif=? WHERE jurId=?");
        $stmt->bind_param("sssii", $kode, $nama, $as, $is, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=jurusan");
        exit;
    }
    if($act === "jurusan_delete" && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM jurusan WHERE jurId = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=jurusan");
        exit;
    }

    // PROGRAM STUDI (program_studi)
    if($act === "prodi_add" && isset($_POST['save_prodi'])){
        $prodiJurId = intval($_POST['prodiJurId'] ?? 0);
        $prodiKode = $_POST['prodiKode'] ?? '';
        $prodiNama = trim($_POST['prodiNama'] ?? '');
        $prodiJenjang = $_POST['prodiJenjang'] ?? '';
        $prodiEmail = $_POST['prodiEmail'] ?? '';
        $prodiWebsite = $_POST['prodiWebsite'] ?? '';
        $prodiIsAktif = isset($_POST['prodiIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("INSERT INTO program_studi (prodiJurId, prodiKode, prodiNama, prodiNamaAsing, prodiJenjang, prodiEmail, prodiWebsite, prodiIsAktif) VALUES (?, ?, ?, '', ?, ?, ?, ?)");
        $stmt->bind_param("isssssi", $prodiJurId, $prodiKode, $prodiNama, $prodiJenjang, $prodiEmail, $prodiWebsite, $prodiIsAktif);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=prodi");
        exit;
    }
    if($act === "prodi_edit" && isset($_POST['update_prodi'])){
        $id = intval($_POST['prodiId']);
        $prodiJurId = intval($_POST['prodiJurId'] ?? 0);
        $prodiKode = $_POST['prodiKode'] ?? '';
        $prodiNama = trim($_POST['prodiNama'] ?? '');
        $prodiJenjang = $_POST['prodiJenjang'] ?? '';
        $prodiEmail = $_POST['prodiEmail'] ?? '';
        $prodiWebsite = $_POST['prodiWebsite'] ?? '';
        $prodiIsAktif = isset($_POST['prodiIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("UPDATE program_studi SET prodiJurId=?, prodiKode=?, prodiNama=?, prodiJenjang=?, prodiEmail=?, prodiWebsite=?, prodiIsAktif=? WHERE prodiId=?");
        $stmt->bind_param("isssssii", $prodiJurId, $prodiKode, $prodiNama, $prodiJenjang, $prodiEmail, $prodiWebsite, $prodiIsAktif, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=prodi");
        exit;
    }
    if($act === "prodi_delete" && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM program_studi WHERE prodiId = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=prodi");
        exit;
    }

    // KURIKULUM
    if($act === "kurikulum_add" && isset($_POST['save_kurikulum'])){
        $kurProdiId = intval($_POST['kurProdiId'] ?? 0);
        $kurTahun = $_POST['kurTahun'] ?? '';
        $kurNama = trim($_POST['kurNama'] ?? '');
        $kurIsAktif = isset($_POST['kurIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("INSERT INTO kurikulum (kurProdiId, kurTahun, kurNama, kurIsAktif) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $kurProdiId, $kurTahun, $kurNama, $kurIsAktif);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=kurikulum");
        exit;
    }
    if($act === "kurikulum_edit" && isset($_POST['update_kurikulum'])){
        $id = intval($_POST['kurId']);
        $kurProdiId = intval($_POST['kurProdiId'] ?? 0);
        $kurTahun = $_POST['kurTahun'] ?? '';
        $kurNama = trim($_POST['kurNama'] ?? '');
        $kurIsAktif = isset($_POST['kurIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("UPDATE kurikulum SET kurProdiId=?, kurTahun=?, kurNama=?, kurIsAktif=? WHERE kurId=?");
        $stmt->bind_param("issii", $kurProdiId, $kurTahun, $kurNama, $kurIsAktif, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=kurikulum");
        exit;
    }
    if($act === "kurikulum_delete" && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM kurikulum WHERE kurId = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=kurikulum");
        exit;
    }

    // MATAKULIAH
    if($act === "matkul_add" && isset($_POST['save_matkul'])){
        $mkKurId = intval($_POST['mkKurId'] ?? 0);
        $mkKode = trim($_POST['mkKode'] ?? '');
        $mkNama = trim($_POST['mkNama'] ?? '');
        $mkSemester = intval($_POST['mkSemester'] ?? 0);
        $mkSks = intval($_POST['mkSks'] ?? 0);
        $mkIsAktif = isset($_POST['mkIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("INSERT INTO matakuliah (mkKurId, mkKode, mkNama, mkNamaAsing, mkSemester, mkSks, mkIsAktif) VALUES (?, ?, ?, '', ?, ?, ?)");
        $stmt->bind_param("issiii", $mkKurId, $mkKode, $mkNama, $mkSemester, $mkSks, $mkIsAktif);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=matkul");
        exit;
    }
    if($act === "matkul_edit" && isset($_POST['update_matkul'])){
        $id = intval($_POST['mkId']);
        $mkKurId = intval($_POST['mkKurId'] ?? 0);
        $mkKode = trim($_POST['mkKode'] ?? '');
        $mkNama = trim($_POST['mkNama'] ?? '');
        $mkSemester = intval($_POST['mkSemester'] ?? 0);
        $mkSks = intval($_POST['mkSks'] ?? 0);
        $mkIsAktif = isset($_POST['mkIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("UPDATE matakuliah SET mkKurId=?, mkKode=?, mkNama=?, mkSemester=?, mkSks=?, mkIsAktif=? WHERE mkId=?");
        $stmt->bind_param("issiiii", $mkKurId, $mkKode, $mkNama, $mkSemester, $mkSks, $mkIsAktif, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=matkul");
        exit;
    }
    if($act === "matkul_delete" && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM matakuliah WHERE mkId = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=matkul");
        exit;
    }

    // DOSEN
    if($act === "dosen_add" && isset($_POST['save_dosen'])){
        $nidn = trim($_POST['dsnNidn'] ?? '');
        $dsnJurId = intval($_POST['dsnJurId'] ?? 0);
        $dsnProdiId = intval($_POST['dsnProdiId'] ?? 0);
        $dsnNama = trim($_POST['dsnNama'] ?? '');
        $dsnJK = $_POST['dsnJenisKelaminKode'] ?? 'L';
        $stmt = $koneksi->prepare("INSERT INTO dosen (dsnNidn, dsnJurId, dsnProdiId, dsnNama, dsnJenisKelaminKode) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("siiss", $nidn, $dsnJurId, $dsnProdiId, $dsnNama, $dsnJK);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=dosen");
        exit;
    }
    if($act === "dosen_edit" && isset($_POST['update_dosen'])){
        $nidn = trim($_POST['dsnNidn']);
        $dsnJurId = intval($_POST['dsnJurId'] ?? 0);
        $dsnProdiId = intval($_POST['dsnProdiId'] ?? 0);
        $dsnNama = trim($_POST['dsnNama'] ?? '');
        $dsnJK = $_POST['dsnJenisKelaminKode'] ?? 'L';
        $stmt = $koneksi->prepare("UPDATE dosen SET dsnJurId=?, dsnProdiId=?, dsnNama=?, dsnJenisKelaminKode=? WHERE dsnNidn=?");
        $stmt->bind_param("iisss", $dsnJurId, $dsnProdiId, $dsnNama, $dsnJK, $nidn);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=dosen");
        exit;
    }
    if($act === "dosen_delete" && isset($_GET['id'])){
        $nidn = $koneksi->real_escape_string($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM dosen WHERE dsnNidn = ?");
        $stmt->bind_param("s",$nidn);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=dosen");
        exit;
    }

// MAHASISWA - ADD
if($act === "mahasiswa_add" && isset($_POST['save_mahasiswa'])){
    $mhsNim = trim($_POST['mhsNim'] ?? '');
    $mhsNama = trim($_POST['mhsNama'] ?? '');
    $mhsJurId = intval($_POST['mhsJurId'] ?? 0);
    $mhsProdiId = intval($_POST['mhsProdiId'] ?? 0);
    $mhsTglLahir = $_POST['mhsTglLahir'] ?? NULL;
    $mhsJenisKelamin = $_POST['mhsJenisKelamin'] ?? 'L';
    $mhsKodeKelas = $_POST['mhsKodeKelas'] ?? 'A';
    $mhsTempatLahir = trim($_POST['mhsTempatLahir'] ?? '');
    
    $stmt = $koneksi->prepare("
        INSERT INTO mahasiswa 
        (mhsNim, mhsNama, mhsTempatLahir, mhsTglLahir, mhsJenisKelamin, mhsJurId, mhsProdiId, mhsKodeKelas, mhsStsAkademik, mhsSmsAktif) 
        VALUES 
        (?, ?, ?, ?, ?, ?, ?, ?, 'A', 0)
    ");
    
    $stmt->bind_param(
        "sssssiis", 
        $mhsNim,
        $mhsNama,
        $mhsTempatLahir,
        $mhsTglLahir,
        $mhsJenisKelamin,
        $mhsJurId,
        $mhsProdiId,
        $mhsKodeKelas
    );
    
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?page=mahasiswa");
    exit;
}

// MAHASISWA - EDIT
if($act === "mahasiswa_edit" && isset($_POST['update_mahasiswa'])){
    $mhsNim = trim($_POST['mhsNim']);
    $mhsNama = trim($_POST['mhsNama'] ?? '');
    $mhsJurId = intval($_POST['mhsJurId'] ?? 0);
    $mhsProdiId = intval($_POST['mhsProdiId'] ?? 0);
    $mhsTglLahir = $_POST['mhsTglLahir'] ?? NULL;
    $mhsJenisKelamin = $_POST['mhsJenisKelamin'] ?? 'L';
    $mhsKodeKelas = $_POST['mhsKodeKelas'] ?? 'A';
    $mhsTempatLahir = trim($_POST['mhsTempatLahir'] ?? '');
    $mhsStsAkademik = $_POST['mhsStsAkademik'] ?? 'A';
    $mhsSmsAktif = intval($_POST['mhsSmsAktif'] ?? 0);
    
    $stmt = $koneksi->prepare("
        UPDATE mahasiswa 
        SET mhsNama=?, 
            mhsTempatLahir=?, 
            mhsTglLahir=?, 
            mhsJenisKelamin=?, 
            mhsJurId=?, 
            mhsProdiId=?, 
            mhsKodeKelas=?,
            mhsStsAkademik=?,
            mhsSmsAktif=?
        WHERE mhsNim=?
    ");
    
    $stmt->bind_param(
        "ssssiiisis",
        $mhsNama,
        $mhsTempatLahir,
        $mhsTglLahir,
        $mhsJenisKelamin,
        $mhsJurId,
        $mhsProdiId,
        $mhsKodeKelas,
        $mhsStsAkademik,
        $mhsSmsAktif,
        $mhsNim
    );
    
    $stmt->execute();
    $stmt->close();
    header("Location: index.php?page=mahasiswa");
    exit;
}


    if($act === "mahasiswa_delete" && isset($_GET['id'])){
        $nim = $koneksi->real_escape_string($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM mahasiswa WHERE mhsNim = ?");
        $stmt->bind_param("s",$nim);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=mahasiswa");
        exit;
    }

    // TAHUN AKADEMIK
    if($act === "thakd_add" && isset($_POST['save_thakd'])){
        $thakdId = intval($_POST['thakdId'] ?? 0);
        $thakdTahun = $_POST['thakdTahun'] ?? '';
        $thakdSemester = $_POST['thakdSemester'] ?? '1';
        $thakdTglMulai = $_POST['thakdTglMulai'] ?: NULL;
        $thakdTglSelesai = $_POST['thakdTglSelesai'] ?: NULL;
        $thakdIsAktif = isset($_POST['thakdIsAktif']) ? 1 : 0;
        $stmt = $koneksi->prepare("INSERT INTO tahun_akademik (thakdId, thakdTahun, thakdSemester, thakdTglMulai, thakdTglSelesai, thakdIsAktif) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssi", $thakdId, $thakdTahun, $thakdSemester, $thakdTglMulai, $thakdTglSelesai, $thakdIsAktif);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=tahun_akademik");
        exit;
    }
    if($act === "thakd_delete" && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $stmt = $koneksi->prepare("DELETE FROM tahun_akademik WHERE thakdId = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php?page=tahun_akademik");
        exit;
    }
}

/* ------------------- OUTPUT HTML ------------------- */
?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>SIAKAD </title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
/* GLOBAL */
body { margin:0; font-family: Arial, Helvetica, sans-serif; background: #f3f6fa; color:#222; }
a { color:inherit; }

/* LOGIN CARD */
.center-wrap { display:flex; align-items:center; justify-content:center; min-height:100vh; }
.card { width:380px; background:white; padding:20px; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.08); }

/* SIDEBAR */
.sidebar {
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: linear-gradient(180deg,#f7fbff,#e7f2ff);
    border-right:1px solid #dce6f2;
    padding:18px;
    box-sizing: border-box;
}
.sidebar-title { text-align:center; font-weight:700; color:#0c4a85; font-size:20px; margin-bottom:8px; }
.sidebar-user { background:#fff; border-radius:8px; padding:10px; text-align:center; margin-bottom:12px; box-shadow:0 2px 6px rgba(0,0,0,0.03); }
.menu-title { color:#0a4873; font-weight:700; margin-top:14px; margin-bottom:6px; font-size:13px; }
.sidebar a { display:block; padding:8px 10px; border-radius:6px; text-decoration:none; color:#16314a; margin:6px 0; font-size:14px; }
.sidebar a:hover { background:#dceefb; color:#0a3b6f; font-weight:700; }

/* CONTENT */
.content { margin-left: 290px; padding: 24px; min-height:100vh; box-sizing:border-box; }
.card-content { background:white; padding:18px; border-radius:10px; box-shadow:0 6px 18px rgba(0,0,0,0.04); }

/* TABLE */
.table { width:100%; border-collapse:collapse; }
.table th, .table td { padding:8px 10px; border:1px solid #e6eef8; text-align:left; font-size:14px; }
.table th { background:#f6fafc; color:#0b4b85; }

/* FORMS */
.input, select { width:100%; padding:8px 10px; margin:6px 0 12px; border:1px solid #dbe9fb; border-radius:6px; box-sizing:border-box; }
.btn { display:inline-block; padding:8px 12px; border-radius:6px; text-decoration:none; background:#2380d9; color:white; border:none; cursor:pointer; }
.btn.small { padding:6px 8px; font-size:13px; }
.topbar { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }

/* responsive */
@media(max-width:860px){
    .sidebar { position:relative; width:100%; height:auto; }
    .content { margin-left:0; }
}
</style>
</head>
<body>

<?php if(!isset($_SESSION['login'])): ?>

<!-- LOGIN / REGISTER -->
<div class="center-wrap">
    <div class="card">
        <h2 style="margin-top:0">SIAKAD - Login</h2>

        <?php if(isset($error)) echo "<p style='color:red'>".h($error)."</p>"; ?>
        <?php if(isset($reg_success)) echo "<p style='color:green'>".h($reg_success)."</p>"; ?>
        <form method="post">
            <input class="input" type="text" name="username" placeholder="Username" required>
            <input class="input" type="password" name="password" placeholder="Password" required>
            <button class="btn" type="submit" name="login">LOGIN</button>
        </form>

        <hr>
        <h4>Registrasi</h4>
        <?php if(isset($reg_error)) echo "<p style='color:red'>".h($reg_error)."</p>"; ?>
        <form method="post">
            <input class="input" type="text" name="username" placeholder="Buat Username (unik)" required>
            <input class="input" type="password" name="password" placeholder="Buat Password" required>
            <button class="btn" type="submit" name="register">REGISTER</button>
        </form>
        <p style="font-size:12px;color:#666;margin-top:10px"></code></p>
    </div>
</div>

<?php else: ?>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="sidebar-title">SIAKAD</div>
    <div class="sidebar-user">
        Welcome,<br><strong><?= h($_SESSION['user']); ?></strong>
    </div>

    <div class="menu-title">Menu Utama</div>
    <a href="index.php?page=beranda">🏠 Beranda</a>
    <a href="index.php?page=prakuliah">📌 Pra Kuliah</a>
    <a href="index.php?page=perkuliahan">📚 Perkuliahan</a>
    <a href="index.php?page=pascakuliah">🎓 Pasca Kuliah</a>

    <div class="menu-title">Data Master</div>
    <a href="index.php?page=jurusan">📁 Data Jurusan</a>
    <a href="index.php?page=prodi">📁 Data Prodi</a>
    <a href="index.php?page=kurikulum">📁 Kurikulum</a>
    <a href="index.php?page=matkul">📁 Matakuliah</a>
    <a href="index.php?page=dosen">📁 Data Dosen</a>
    <a href="index.php?page=mahasiswa">📁 Data Mahasiswa</a>
    <a href="index.php?page=tahun_akademik">📅 Tahun Akademik</a>

    <div class="menu-title">User</div>
    <a href="index.php?page=password">🔑 Ubah Password</a>
    <a href="index.php?logout=1">🚪 Logout</a>
</div>

<!-- CONTENT -->
<div class="content">
<?php  
$page = isset($_GET['page']) ? $_GET['page'] : "beranda";
?>

<?php
/* ---------------- BERANDA (ICON MENU) ---------------- */
if ($page == "beranda") {
?>
<style>
.menu-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 25px;
    margin-top: 25px;
}
.menu-box {
    background: white;
    padding: 25px;
    text-align: center;
    border-radius: 14px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    cursor: pointer;
    transition: .2s;
}
.menu-box:hover {
    transform: translateY(-5px);
    background: #eef6ff;
}
.menu-box img {
    width: 70px;
    margin-bottom: 10px;
}
.menu-title {
    font-size: 18px;
    font-weight: bold;
    color: #0b3d70;
}
</style>

<div class="card-content">
    <h2>Beranda SIAKAD</h2>
    <p>Silakan pilih menu.</p>

    <div class="menu-grid">

        <div class="menu-box" onclick="location.href='index.php?page=prakuliah'">
            <img src="icons/prakuliah.png">
            <div class="menu-title">Pra Kuliah</div>
        </div>

        <div class="menu-box" onclick="location.href='index.php?page=perkuliahan'">
            <img src="icons/perkuliahan.png">
            <div class="menu-title">Perkuliahan</div>
        </div>

        <div class="menu-box" onclick="location.href='index.php?page=pascakuliah'">
            <img src="icons/pascakuliah.png">
            <div class="menu-title">Pasca Kuliah</div>
        </div>

        <div class="menu-box" onclick="location.href='index.php?page=datamaster'">
            <img src="icons/datamaster.png">
            <div class="menu-title">Data Master</div>
        </div>

        <div class="menu-box" onclick="location.href='index.php?page=user'">
            <img src="icons/user.png">
            <div class="menu-title">User</div>
        </div>

    </div>
</div>

<?php
}
/* ---------------- END BERANDA ---------------- */
/* ---------------- PRA KULIAH ---------------- */
if($page == "prakuliah"){
?>
<style>
.submenu-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 22px;
    margin-top: 25px;
}
.sub-box {
    background: #fff;
    border-radius: 12px;
    text-align: center;
    padding: 20px 10px;
    cursor: pointer;
    border: 1px solid #e9eef5;
    transition: .2s;
}
.sub-box:hover {
    background:#eef6ff;
    transform: scale(1.05);
}
.sub-box img {
    width: 55px;
    margin-bottom: 12px;
}
.sub-title {
    font-size: 15px;
    font-weight: bold;
}
</style>

<div class="card-content">
    <h2>Pra Kuliah</h2>

    <div class="submenu-grid">

        <div class="sub-box">
            <img src="icons/kelas.png">
            <div class="sub-title">Daftar Kelas</div>
        </div>

        <div class="sub-box">
            <img src="icons/matkul.png">
            <div class="sub-title">Daftar Mata Kuliah</div>
        </div>

        <div class="sub-box">
            <img src="icons/dosen.png">
            <div class="sub-title">Dosen Kelas</div>
        </div>

        <div class="sub-box">
            <img src="icons/mahasiswa.png">
            <div class="sub-title">Mahasiswa Kelas</div>
        </div>

    </div>
</div>

<?php 
}
/* ---------------- PERKULIAHAN ---------------- */
if($page == "perkuliahan"){
?>
<div class="card-content">
    <h2>Perkuliahan</h2>

    <div class="submenu-grid">

        <div class="sub-box">
            <img src="icons/jadwal.png">
            <div class="sub-title">Jadwal Kuliah</div>
        </div>

        <div class="sub-box">
            <img src="icons/modul.png">
            <div class="sub-title">Modul Kuliah</div>
        </div>

        <div class="sub-box">
            <img src="icons/presensi.png">
            <div class="sub-title">Presensi</div>
        </div>

        <div class="sub-box">
            <img src="icons/warning.png">
            <div class="sub-title">Surat Peringatan</div>
        </div>

    </div>
</div>

<?php 
}

if($page == "pascakuliah"){
?>
<div class="card-content">
    <h2>Pasca Kuliah</h2>

    <div class="submenu-grid">

        <div class="sub-box">
            <img src="icons/khs.png">
            <div class="sub-title">Rapor / KHS</div>
        </div>

    </div>
</div>
<?php 
}

if($page == "datamaster"){
?>
<div class="card-content">
    <h2>Data Master</h2>

    <div class="submenu-grid">

        <div class="sub-box" onclick="location.href='index.php?page=jurusan'">
            <img src="icons/jurusan.png">
            <div class="sub-title">Jurusan</div>
        </div>

        <div class="sub-box" onclick="location.href='index.php?page=prodi'">
            <img src="icons/prodi.png">
            <div class="sub-title">Prodi</div>
        </div>

        <div class="sub-box" onclick="location.href='index.php?page=kurikulum'">
            <img src="icons/kurikulum.png">
            <div class="sub-title">Kurikulum</div>
        </div>

        <div class="sub-box" onclick="location.href='index.php?page=matkul'">
            <img src="icons/matkul.png">
            <div class="sub-title">Mata Kuliah</div>
        </div>

        <div class="sub-box" onclick="location.href='index.php?page=dosen'">
            <img src="icons/dosen.png">
            <div class="sub-title">Dosen</div>
        </div>

        <div class="sub-box" onclick="location.href='index.php?page=mahasiswa'">
            <img src="icons/mahasiswa.png">
            <div class="sub-title">Mahasiswa</div>
        </div>

    </div>
</div>
<?php 
} 

if($page == "user"){
?>
<div class="card-content">
    <h2>User</h2>

    <div class="submenu-grid">

        <div class="sub-box" onclick="location.href='index.php?page=password'">
            <img src="icons/password.png">
            <div class="sub-title">Ubah Password</div>
        </div>

    </div>
</div>
<?php 
} 

/* ------------- JURUSAN CRUD ------------- */
else if($page == "jurusan"){
    echo "<div class='topbar'><h2>Data Jurusan</h2><div><a class='btn' href='index.php?page=jurusan&aksi=tambah'>+ Tambah Jurusan</a></div></div>";
    echo "<div class='card-content'>";
    if(isset($_GET['aksi']) && $_GET['aksi'] == 'tambah'){
        // form tambah
        ?>
        <h3>Tambah Jurusan</h3>
        <form method="post" action="index.php?act=jurusan_add">
            <label>Kode</label>
            <input class="input" name="jurKode" />
            <label>Nama Jurusan</label>
            <input class="input" name="jurNama" required />
            <label>Nama Asing</label>
            <input class="input" name="jurNamaAsing" />
            <label><input type="checkbox" name="jurIsAktif" checked /> Aktif</label><br><br>
            <button class="btn" name="save_jurusan" type="submit">Simpan</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=jurusan">Batal</a>
        </form>
        <?php
    } else if(isset($_GET['aksi']) && $_GET['aksi'] == 'edit' && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $r = $koneksi->query("SELECT * FROM jurusan WHERE jurId = $id")->fetch_assoc();
        ?>
        <h3>Edit Jurusan</h3>
        <form method="post" action="index.php?act=jurusan_edit">
            <input type="hidden" name="jurId" value="<?=h($r['jurId'])?>">
            <label>Kode</label>
            <input class="input" name="jurKode" value="<?=h($r['jurKode'])?>" />
            <label>Nama Jurusan</label>
            <input class="input" name="jurNama" value="<?=h($r['jurNama'])?>" required />
            <label>Nama Asing</label>
            <input class="input" name="jurNamaAsing" value="<?=h($r['jurNamaAsing'])?>" />
            <label><input type="checkbox" name="jurIsAktif" <?=($r['jurIsAktif']? 'checked':'')?> /> Aktif</label><br><br>
            <button class="btn" name="update_jurusan" type="submit">Update</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=jurusan">Batal</a>
        </form>
        <?php
    } else {
        // list
        $res = $koneksi->query("SELECT * FROM jurusan ORDER BY jurId ASC");
        echo "<table class='table'><tr><th>#</th><th>Kode</th><th>Nama Jurusan</th><th>Aktif</th><th>Aksi</th></tr>";
        $no=1;
        while($row = $res->fetch_assoc()){
            echo "<tr>
                    <td>".($no++)."</td>
                    <td>".h($row['jurKode'])."</td>
                    <td>".h($row['jurNama'])."</td>
                    <td>".($row['jurIsAktif']? 'Ya':'Tidak')."</td>
                    <td>
                        <a class='btn small' style='background:#2d9cdb' href='index.php?page=jurusan&aksi=edit&id=".h($row['jurId'])."'>Edit</a>
                        <a class='btn small' style='background:#d9534f' href='index.php?act=jurusan_delete&id=".h($row['jurId'])."' onclick=\"return confirm('Hapus jurusan ini?')\">Hapus</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    echo "</div>";
}


/* ------------- PROGRAM STUDI CRUD ------------- */
else if($page == "prodi"){
    echo "<div class='topbar'><h2>Data Program Studi</h2><div><a class='btn' href='index.php?page=prodi&aksi=tambah'>+ Tambah Prodi</a></div></div>";
    echo "<div class='card-content'>";
    if(isset($_GET['aksi']) && $_GET['aksi']=='tambah'){
        // ambil jurusan untuk dropdown
        $jur = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
        ?>
        <h3>Tambah Program Studi</h3>
        <form method="post" action="index.php?act=prodi_add">
            <label>Jurusan</label>
            <select name="prodiJurId" class="input">
                <option value="0">-- Pilih Jurusan --</option>
                <?php while($j=$jur->fetch_assoc()): ?>
                    <option value="<?=h($j['jurId'])?>"><?=h($j['jurNama'])?></option>
                <?php endwhile; ?>
            </select>
            <label>Kode</label><input class="input" name="prodiKode" />
            <label>Nama</label><input class="input" name="prodiNama" required />
            <label>Jenjang</label><input class="input" name="prodiJenjang" />
            <label>Email</label><input class="input" name="prodiEmail" />
            <label>Website</label><input class="input" name="prodiWebsite" />
            <label><input type="checkbox" name="prodiIsAktif" checked /> Aktif</label><br><br>
            <button class="btn" name="save_prodi" type="submit">Simpan</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=prodi">Batal</a>
        </form>
        <?php
    } else if(isset($_GET['aksi']) && $_GET['aksi']=='edit' && isset($_GET['id'])){
        $id = intval($_GET['id']);
        $row = $koneksi->query("SELECT * FROM program_studi WHERE prodiId=$id")->fetch_assoc();
        $jur = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
        ?>
        <h3>Edit Prodi</h3>
        <form method="post" action="index.php?act=prodi_edit">
            <input type="hidden" name="prodiId" value="<?=h($row['prodiId'])?>">
            <label>Jurusan</label>
            <select name="prodiJurId" class="input">
                <option value="0">-- Pilih Jurusan --</option>
                <?php while($j=$jur->fetch_assoc()): ?>
                    <option value="<?=h($j['jurId'])?>" <?=($j['jurId']==$row['prodiJurId']?'selected':'')?>><?=h($j['jurNama'])?></option>
                <?php endwhile; ?>
            </select>
            <label>Kode</label><input class="input" name="prodiKode" value="<?=h($row['prodiKode'])?>" />
            <label>Nama</label><input class="input" name="prodiNama" value="<?=h($row['prodiNama'])?>" required />
            <label>Jenjang</label><input class="input" name="prodiJenjang" value="<?=h($row['prodiJenjang'])?>" />
            <label>Email</label><input class="input" name="prodiEmail" value="<?=h($row['prodiEmail'])?>" />
            <label>Website</label><input class="input" name="prodiWebsite" value="<?=h($row['prodiWebsite'])?>" />
            <label><input type="checkbox" name="prodiIsAktif" <?=($row['prodiIsAktif']? 'checked':'')?> /> Aktif</label><br><br>
            <button class="btn" name="update_prodi" type="submit">Update</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=prodi">Batal</a>
        </form>
        <?php
    } else {
        $res = $koneksi->query("SELECT p.*, j.jurNama FROM program_studi p LEFT JOIN jurusan j ON p.prodiJurId = j.jurId ORDER BY p.prodiId");
        echo "<table class='table'><tr><th>#</th><th>Kode</th><th>Nama</th><th>Jurusan</th><th>Jenjang</th><th>Aktif</th><th>Aksi</th></tr>";
        $no=1;
        while($r=$res->fetch_assoc()){
            echo "<tr>
                    <td>".($no++)."</td>
                    <td>".h($r['prodiKode'])."</td>
                    <td>".h($r['prodiNama'])."</td>
                    <td>".h($r['jurNama'])."</td>
                    <td>".h($r['prodiJenjang'])."</td>
                    <td>".($r['prodiIsAktif']? 'Ya':'Tidak')."</td>
                    <td>
                        <a class='btn small' style='background:#2d9cdb' href='index.php?page=prodi&aksi=edit&id=".h($r['prodiId'])."'>Edit</a>
                        <a class='btn small' style='background:#d9534f' href='index.php?act=prodi_delete&id=".h($r['prodiId'])."' onclick=\"return confirm('Hapus prodi ini?')\">Hapus</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    echo "</div>";
}

/* ------------- KURIKULUM CRUD ------------- */
else if ($page == "kurikulum") {

    echo "
    <div class='topbar'>
        <h2>Data Kurikulum</h2>
        <div><a class='btn' href='index.php?page=kurikulum&aksi=tambah'>+ Tambah Kurikulum</a></div>
    </div>
    <div class='card-content'>
    ";

    /* --------------------------------------------------
       FORM TAMBAH KURIKULUM
    ---------------------------------------------------- */
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {

        $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
        ?>

        <h3>Tambah Kurikulum</h3>
        <form method="post" action="index.php?act=kurikulum_add">

            <label>Program Studi</label>
            <select name="kurProdiId" class="input">
                <option value="0">-- Pilih Prodi --</option>
                <?php while ($p = $prodi->fetch_assoc()): ?>
                    <option value="<?= h($p['prodiId']) ?>"><?= h($p['prodiNama']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Tahun (format YYYY)</label>
            <input class="input" name="kurTahun" placeholder="2024" required />

            <label>Nama Kurikulum</label>
            <input class="input" name="kurNama" required />

            <label>
                <input type="checkbox" name="kurIsAktif" checked />
                Aktif
            </label><br><br>

            <button class="btn" name="save_kurikulum" type="submit">Simpan</button>
            <a class="btn" href="index.php?page=kurikulum" style="background:#777;margin-left:8px">Batal</a>

        </form>
        <?php
    }

    /* --------------------------------------------------
       FORM EDIT KURIKULUM
    ---------------------------------------------------- */
    else if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit' && isset($_GET['id'])) {

        $id = intval($_GET['id']);
        $kurikulum = $koneksi->query("SELECT * FROM kurikulum WHERE kurId = $id")->fetch_assoc();

        if (!$kurikulum) {
            echo "<p style='color:red'>Data kurikulum tidak ditemukan!</p>";
            echo "<a class='btn' href='index.php?page=kurikulum'>Kembali</a>";
        } else {

            $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
            ?>

            <h3>Edit Kurikulum: <?= h($kurikulum['kurNama']) ?></h3>

            <form method="post" action="index.php?act=kurikulum_edit">

                <input type="hidden" name="kurId" value="<?= h($kurikulum['kurId']) ?>" />

                <label>Program Studi</label>
                <select name="kurProdiId" class="input">
                    <option value="0">-- Pilih Prodi --</option>
                    <?php while ($p = $prodi->fetch_assoc()): ?>
                        <option value="<?= h($p['prodiId']) ?>"
                            <?= ($p['prodiId'] == $kurikulum['kurProdiId'] ? 'selected' : '') ?>>
                            <?= h($p['prodiNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Tahun (format YYYY)</label>
                <input class="input" name="kurTahun" placeholder="2024"
                       value="<?= h($kurikulum['kurTahun']) ?>" required />

                <label>Nama Kurikulum</label>
                <input class="input" name="kurNama" value="<?= h($kurikulum['kurNama']) ?>" required />

                <label>
                    <input type="checkbox" name="kurIsAktif"
                        <?= ($kurikulum['kurIsAktif'] ? 'checked' : '') ?> />
                    Aktif
                </label><br><br>

                <button class="btn" name="update_kurikulum" type="submit">💾 Update</button>
                <a class="btn" href="index.php?page=kurikulum" style="background:#777;margin-left:8px">❌ Batal</a>

            </form>
            <?php
        }
    }

    /* --------------------------------------------------
       LIST DATA KURIKULUM
    ---------------------------------------------------- */
    else {

        $res = $koneksi->query("
            SELECT k.*, p.prodiNama
            FROM kurikulum k
            LEFT JOIN program_studi p ON k.kurProdiId = p.prodiId
            ORDER BY k.kurId
        ");

        echo "
        <table class='table'>
            <tr>
                <th>#</th>
                <th>Prodi</th>
                <th>Tahun</th>
                <th>Nama Kurikulum</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>";

        $no = 1;

        while ($r = $res->fetch_assoc()) {
            echo "
            <tr>
                <td>" . ($no++) . "</td>
                <td>" . h($r['prodiNama']) . "</td>
                <td>" . h($r['kurTahun']) . "</td>
                <td>" . h($r['kurNama']) . "</td>
                <td>" . ($r['kurIsAktif'] ? 'Ya' : 'Tidak') . "</td>
                <td>
                    <a class='btn small' style='background:#2d9cdb'
                       href='index.php?page=kurikulum&aksi=edit&id=" . h($r['kurId']) . "'>Edit</a>

                    <a class='btn small' style='background:#d9534f'
                       onclick=\"return confirm('Hapus kurikulum ini?')\"
                       href='index.php?act=kurikulum_delete&id=" . h($r['kurId']) . "'>Hapus</a>
                </td>
            </tr>";
        }

        echo "</table>";
    }

    echo "</div>"; // end card-content
}


/* ------------- MATAKULIAH CRUD ------------- */
else if ($page == "matkul") {

    echo "
    <div class='topbar'>
        <h2>Data Matakuliah</h2>
        <div><a class='btn' href='index.php?page=matkul&aksi=tambah'>+ Tambah Matakuliah</a></div>
    </div>
    <div class='card-content'>
    ";

    /* --------------------------------------------------
       FORM TAMBAH MATAKULIAH
    ---------------------------------------------------- */
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {

        $kur = $koneksi->query("SELECT kurId, kurNama FROM kurikulum ORDER BY kurTahun DESC");
        ?>

        <h3>Tambah Matakuliah</h3>
        <form method="post" action="index.php?act=matkul_add">

            <label>Kurikulum</label>
            <select name="mkKurId" class="input">
                <option value="0">-- Pilih Kurikulum --</option>
                <?php while ($k = $kur->fetch_assoc()): ?>
                    <option value="<?= h($k['kurId']) ?>"><?= h($k['kurNama']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Kode</label>
            <input class="input" name="mkKode" required />

            <label>Nama</label>
            <input class="input" name="mkNama" required />

            <label>Semester</label>
            <input class="input" type="number" min="1" max="12" name="mkSemester" />

            <label>SKS</label>
            <input class="input" type="number" min="0" name="mkSks" />

            <label>
                <input type="checkbox" name="mkIsAktif" checked />
                Aktif
            </label><br><br>

            <button class="btn" type="submit" name="save_matkul">Simpan</button>
            <a class="btn" href="index.php?page=matkul" style="background:#777;margin-left:8px">Batal</a>

        </form>
        <?php
    }

    /* --------------------------------------------------
       FORM EDIT MATAKULIAH
    ---------------------------------------------------- */
    else if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit' && isset($_GET['id'])) {

        $id = intval($_GET['id']);
        $matkul = $koneksi->query("SELECT * FROM matakuliah WHERE mkId = $id")->fetch_assoc();

        if (!$matkul) {
            echo "<p style='color:red'>Data matakuliah tidak ditemukan!</p>";
            echo "<a class='btn' href='index.php?page=matkul'>Kembali</a>";
        } else {

            $kur = $koneksi->query("SELECT kurId, kurNama FROM kurikulum ORDER BY kurTahun DESC");
            ?>

            <h3>Edit Matakuliah: <?= h($matkul['mkNama']) ?></h3>
            <form method="post" action="index.php?act=matkul_edit">

                <input type="hidden" name="mkId" value="<?= h($matkul['mkId']) ?>" />

                <label>Kurikulum</label>
                <select name="mkKurId" class="input">
                    <option value="0">-- Pilih Kurikulum --</option>
                    <?php while ($k = $kur->fetch_assoc()): ?>
                        <option value="<?= h($k['kurId']) ?>"
                            <?= ($k['kurId'] == $matkul['mkKurId'] ? 'selected' : '') ?>>
                            <?= h($k['kurNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Kode</label>
                <input class="input" name="mkKode" value="<?= h($matkul['mkKode']) ?>" required />

                <label>Nama</label>
                <input class="input" name="mkNama" value="<?= h($matkul['mkNama']) ?>" required />

                <label>Semester</label>
                <input class="input" type="number" min="1" max="12" name="mkSemester"
                       value="<?= h($matkul['mkSemester']) ?>" />

                <label>SKS</label>
                <input class="input" type="number" min="0" name="mkSks"
                       value="<?= h($matkul['mkSks']) ?>" />

                <label>
                    <input type="checkbox" name="mkIsAktif"
                           <?= ($matkul['mkIsAktif'] ? 'checked' : '') ?> />
                    Aktif
                </label><br><br>

                <button class="btn" name="update_matkul" type="submit">💾 Update</button>
                <a class="btn" href="index.php?page=matkul" style="background:#777;margin-left:8px">❌ Batal</a>

            </form>
            <?php
        }
    }

    /* --------------------------------------------------
       LIST DATA MATAKULIAH
    ---------------------------------------------------- */
    else {

        $res = $koneksi->query("
            SELECT m.*, k.kurNama 
            FROM matakuliah m 
            LEFT JOIN kurikulum k ON m.mkKurId = k.kurId 
            ORDER BY m.mkId DESC
        ");

        echo "
        <table class='table'>
            <tr>
                <th>#</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kurikulum</th>
                <th>Sem</th>
                <th>SKS</th>
                <th>Aktif</th>
                <th>Aksi</th>
            </tr>";

        $no = 1;

        while ($r = $res->fetch_assoc()) {
            echo "
            <tr>
                <td>" . ($no++) . "</td>
                <td>" . h($r['mkKode']) . "</td>
                <td>" . h($r['mkNama']) . "</td>
                <td>" . h($r['kurNama']) . "</td>
                <td>" . h($r['mkSemester']) . "</td>
                <td>" . h($r['mkSks']) . "</td>
                <td>" . ($r['mkIsAktif'] ? 'Ya' : 'Tidak') . "</td>
                <td>
                    <a class='btn small' style='background:#2d9cdb'
                       href='index.php?page=matkul&aksi=edit&id=" . h($r['mkId']) . "'>Edit</a>

                    <a class='btn small' style='background:#d9534f'
                       onclick=\"return confirm('Hapus matakuliah ini?')\"
                       href='index.php?act=matkul_delete&id=" . h($r['mkId']) . "'>Hapus</a>
                </td>
            </tr>";
        }

        echo "</table>";
    }

    echo "</div>"; // end card-content
}




/* ------------- DOSEN CRUD ------------- */
else if ($page == "dosen") {

    echo "
    <div class='topbar'>
        <h2>Data Dosen</h2>
        <div><a class='btn' href='index.php?page=dosen&aksi=tambah'>+ Tambah Dosen</a></div>
    </div>
    <div class='card-content'>
    ";

    /* ---------------------- FORM TAMBAH DOSEN ---------------------- */
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah') {

        $jur   = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
        $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
        ?>

        <h3>Tambah Dosen</h3>
        <form method="post" action="index.php?act=dosen_add">

            <label>NIDN</label>
            <input class="input" name="dsnNidn" required />

            <label>Nama</label>
            <input class="input" name="dsnNama" required />

            <label>Jenis Kelamin</label>
            <select class="input" name="dsnJenisKelaminKode">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <label>Jurusan</label>
            <select name="dsnJurId" class="input">
                <option value="0">-- Pilih Jurusan --</option>
                <?php while ($j = $jur->fetch_assoc()): ?>
                    <option value="<?= h($j['jurId']) ?>"><?= h($j['jurNama']) ?></option>
                <?php endwhile; ?>
            </select>

            <label>Program Studi</label>
            <select name="dsnProdiId" class="input">
                <option value="0">-- Pilih Prodi --</option>
                <?php while ($p = $prodi->fetch_assoc()): ?>
                    <option value="<?= h($p['prodiId']) ?>"><?= h($p['prodiNama']) ?></option>
                <?php endwhile; ?>
            </select>

            <button class="btn" type="submit" name="save_dosen">Simpan</button>
            <a class="btn" href="index.php?page=dosen" style="background:#777;margin-left:8px">Batal</a>

        </form>
        <?php
    }

    /* ---------------------- FORM EDIT DOSEN ---------------------- */
    else if (isset($_GET['aksi']) && $_GET['aksi'] == 'edit' && isset($_GET['id'])) {

        $nidn  = $koneksi->real_escape_string($_GET['id']);
        $dosen = $koneksi->query("SELECT * FROM dosen WHERE dsnNidn = '$nidn'")->fetch_assoc();

        if (!$dosen) {
            echo "<p style='color:red'>Data dosen tidak ditemukan!</p>";
        } else {

            $jur   = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
            $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
            ?>

            <h3>Edit Dosen: <?= h($dosen['dsnNama']) ?></h3>

            <form method="post" action="index.php?act=dosen_edit">

                <input type="hidden" name="dsnNidn" value="<?= h($dosen['dsnNidn']) ?>" />

                <label>NIDN</label>
                <input class="input" value="<?= h($dosen['dsnNidn']) ?>" disabled style="background:#f0f0f0" />
                

                <label>Nama</label>
                <input class="input" name="dsnNama" value="<?= h($dosen['dsnNama']) ?>" required />

                <label>Jenis Kelamin</label>
                <select class="input" name="dsnJenisKelaminKode">
                    <option value="L" <?= ($dosen['dsnJenisKelaminKode'] == 'L' ? 'selected' : '') ?>>Laki-laki</option>
                    <option value="P" <?= ($dosen['dsnJenisKelaminKode'] == 'P' ? 'selected' : '') ?>>Perempuan</option>
                </select>

                <label>Jurusan</label>
                <select name="dsnJurId" class="input">
                    <option value="0">-- Pilih Jurusan --</option>
                    <?php while ($j = $jur->fetch_assoc()): ?>
                        <option value="<?= h($j['jurId']) ?>"
                            <?= ($j['jurId'] == $dosen['dsnJurId'] ? 'selected' : '') ?>>
                            <?= h($j['jurNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <label>Program Studi</label>
                <select name="dsnProdiId" class="input">
                    <option value="0">-- Pilih Prodi --</option>
                    <?php while ($p = $prodi->fetch_assoc()): ?>
                        <option value="<?= h($p['prodiId']) ?>"
                            <?= ($p['prodiId'] == $dosen['dsnProdiId'] ? 'selected' : '') ?>>
                            <?= h($p['prodiNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>

                <button class="btn" name="update_dosen" type="submit">💾 Update</button>
                <a class="btn" href="index.php?page=dosen" style="background:#777;margin-left:8px">❌ Batal</a>

            </form>
            <?php
        }
    }

    /* ---------------------- LIST DATA DOSEN ---------------------- */
    else {

        $r = $koneksi->query("
            SELECT d.*, j.jurNama, p.prodiNama
            FROM dosen d
            LEFT JOIN jurusan j ON d.dsnJurId = j.jurId
            LEFT JOIN program_studi p ON d.dsnProdiId = p.prodiId
            ORDER BY d.dsnNama
        ");

        echo "
        <table class='table'>
        <tr>
            <th>#</th><th>NIDN</th><th>Nama</th>
            <th>Jurusan</th><th>Prodi</th><th>JK</th><th>Aksi</th>
        </tr>";

        $no = 1;
        while ($row = $r->fetch_assoc()) {
            echo "
            <tr>
                <td>" . ($no++) . "</td>
                <td>" . h($row['dsnNidn']) . "</td>
                <td>" . h($row['dsnNama']) . "</td>
                <td>" . h($row['jurNama']) . "</td>
                <td>" . h($row['prodiNama']) . "</td>
                <td>" . h($row['dsnJenisKelaminKode']) . "</td>
                <td>
                    <a class='btn small' style='background:#2d9cdb'
                        href='index.php?page=dosen&aksi=edit&id=" . h($row['dsnNidn']) . "'>Edit</a>

                    <a class='btn small' style='background:#d9534f'
                        onclick=\"return confirm('Hapus dosen ini?')\"
                        href='index.php?act=dosen_delete&id=" . h($row['dsnNidn']) . "'>Hapus</a>
                </td>
            </tr>";
        }

        echo "</table>";
    }

    echo "</div>"; // end card-content
}


/* ------------- MAHASISWA CRUD ------------- */
else if($page == "mahasiswa"){
    echo "<div class='topbar'><h2>Data Mahasiswa</h2><div><a class='btn' href='index.php?page=mahasiswa&aksi=tambah'>+ Tambah Mahasiswa</a></div></div>";
    echo "<div class='card-content'>";
    
    // FORM TAMBAH
    if(isset($_GET['aksi']) && $_GET['aksi']=='tambah'){
        $jur = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
        $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
        ?>
        <h3>Tambah Mahasiswa</h3>
        <form method="post" action="index.php?act=mahasiswa_add">
            <label>NIM</label>
            <input class="input" name="mhsNim" required placeholder="Contoh: 2211071001" />
            
            <label>Nama Lengkap</label>
            <input class="input" name="mhsNama" required />
            
            <label>Tempat Lahir</label>
            <input class="input" name="mhsTempatLahir" placeholder="Contoh: Padang" />
            
            <label>Tanggal Lahir</label>
            <input class="input" name="mhsTglLahir" type="date" />
            
            <label>Jenis Kelamin</label>
            <select class="input" name="mhsJenisKelamin">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
            
            <label>Jurusan</label>
            <select name="mhsJurId" class="input" required>
                <option value="0">-- Pilih Jurusan --</option>
                <?php while($j=$jur->fetch_assoc()): ?>
                    <option value="<?=h($j['jurId'])?>"><?=h($j['jurNama'])?></option>
                <?php endwhile; ?>
            </select>
            
            <label>Program Studi</label>
            <select name="mhsProdiId" class="input" required>
                <option value="0">-- Pilih Prodi --</option>
                <?php while($p=$prodi->fetch_assoc()): ?>
                    <option value="<?=h($p['prodiId'])?>"><?=h($p['prodiNama'])?></option>
                <?php endwhile; ?>
            </select>
            
            <label>Kode Kelas</label>
            <select class="input" name="mhsKodeKelas">
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>
            
            <button class="btn" name="save_mahasiswa" type="submit">💾 Simpan</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=mahasiswa">❌ Batal</a>
        </form>
        <?php
    } 
    // FORM EDIT
    else if(isset($_GET['aksi']) && $_GET['aksi']=='edit' && isset($_GET['id'])){
        $nim = $koneksi->real_escape_string($_GET['id']);
        $mhs = $koneksi->query("SELECT * FROM mahasiswa WHERE mhsNim = '$nim'")->fetch_assoc();
        
        if(!$mhs){
            echo "<p style='color:red'>Data mahasiswa tidak ditemukan!</p>";
            echo "<a class='btn' href='index.php?page=mahasiswa'>Kembali</a>";
        } else {
            $jur = $koneksi->query("SELECT jurId, jurNama FROM jurusan ORDER BY jurNama");
            $prodi = $koneksi->query("SELECT prodiId, prodiNama FROM program_studi ORDER BY prodiNama");
            ?>
            <h3>Edit Mahasiswa</h3>
            <form method="post" action="index.php?act=mahasiswa_edit">
                <input type="hidden" name="mhsNim" value="<?=h($mhs['mhsNim'])?>" />
                
                <label>NIM</label>
                <input class="input" value="<?=h($mhs['mhsNim'])?>" disabled style="background:#f0f0f0" />
                <small style="color:#666">NIM tidak dapat diubah</small>
                
                <label>Nama Lengkap</label>
                <input class="input" name="mhsNama" value="<?=h($mhs['mhsNama'])?>" required />
                
                <label>Tempat Lahir</label>
                <input class="input" name="mhsTempatLahir" value="<?=h($mhs['mhsTempatLahir'])?>" />
                
                <label>Tanggal Lahir</label>
                <input class="input" name="mhsTglLahir" type="date" value="<?=h($mhs['mhsTglLahir'])?>" />
                
                <label>Jenis Kelamin</label>
                <select class="input" name="mhsJenisKelamin">
                    <option value="L" <?=($mhs['mhsJenisKelamin']=='L'?'selected':'')?>>Laki-laki</option>
                    <option value="P" <?=($mhs['mhsJenisKelamin']=='P'?'selected':'')?>>Perempuan</option>
                </select>
                
                <label>Jurusan</label>
                <select name="mhsJurId" class="input" required>
                    <option value="0">-- Pilih Jurusan --</option>
                    <?php while($j=$jur->fetch_assoc()): ?>
                        <option value="<?=h($j['jurId'])?>" <?=($j['jurId']==$mhs['mhsJurId']?'selected':'')?>><?=h($j['jurNama'])?></option>
                    <?php endwhile; ?>
                </select>
                
                <label>Program Studi</label>
                <select name="mhsProdiId" class="input" required>
                    <option value="0">-- Pilih Prodi --</option>
                    <?php while($p=$prodi->fetch_assoc()): ?>
                        <option value="<?=h($p['prodiId'])?>" <?=($p['prodiId']==$mhs['mhsProdiId']?'selected':'')?>><?=h($p['prodiNama'])?></option>
                    <?php endwhile; ?>
                </select>
                
                <label>Kode Kelas</label>
                <select class="input" name="mhsKodeKelas">
                    <option value="A" <?=($mhs['mhsKodeKelas']=='A'?'selected':'')?>>A</option>
                    <option value="B" <?=($mhs['mhsKodeKelas']=='B'?'selected':'')?>>B</option>
                    <option value="C" <?=($mhs['mhsKodeKelas']=='C'?'selected':'')?>>C</option>
                    <option value="D" <?=($mhs['mhsKodeKelas']=='D'?'selected':'')?>>D</option>
                </select>
                
                <label>Status Akademik</label>
                <select class="input" name="mhsStsAkademik">
                    <option value="A" <?=($mhs['mhsStsAkademik']=='A'?'selected':'')?>>A - Aktif</option>
                    <option value="L" <?=($mhs['mhsStsAkademik']=='L'?'selected':'')?>>L - Lulus</option>
                    <option value="C" <?=($mhs['mhsStsAkademik']=='C'?'selected':'')?>>C - Cuti</option>
                    <option value="D" <?=($mhs['mhsStsAkademik']=='D'?'selected':'')?>>D - DO</option>
                    <option value="K" <?=($mhs['mhsStsAkademik']=='K'?'selected':'')?>>K - Keluar</option>
                    <option value="M" <?=($mhs['mhsStsAkademik']=='M'?'selected':'')?>>M - Meninggal</option>
                </select>
                
                <label>Semester Aktif</label>
                <input class="input" name="mhsSmsAktif" type="number" min="0" max="14" value="<?=h($mhs['mhsSmsAktif'])?>" />
                
                <button class="btn" name="update_mahasiswa" type="submit">💾 Update</button>
                <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=mahasiswa">❌ Batal</a>
            </form>
            <?php
        }
    } 
    // LIST DATA
    else {
        // Filter & Search
        $where = "1=1";
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        if($search != ''){
            $s = $koneksi->real_escape_string($search);
            $where .= " AND (m.mhsNim LIKE '%$s%' OR m.mhsNama LIKE '%$s%')";
        }
        
        $res = $koneksi->query("
            SELECT m.*, j.jurNama, p.prodiNama 
            FROM mahasiswa m 
            LEFT JOIN jurusan j ON m.mhsJurId=j.jurId 
            LEFT JOIN program_studi p ON m.mhsProdiId=p.prodiId 
            WHERE $where
            ORDER BY m.mhsNama
        ");
        
        // Search Box
        ?>
        <div style="margin-bottom:15px">
            <form method="get" style="display:flex;gap:8px">
                <input type="hidden" name="page" value="mahasiswa" />
                <input class="input" name="search" placeholder="🔍 Cari NIM atau Nama..." value="<?=h($search)?>" style="flex:1" />
                <button class="btn" type="submit">Cari</button>
                <?php if($search != ''): ?>
                    <a class="btn" style="background:#777" href="index.php?page=mahasiswa">Reset</a>
                <?php endif; ?>
            </form>
        </div>
        <?php
        
        echo "<table class='table'>";
        echo "<tr>
                <th style='width:40px'>#</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>Tempat/Tgl Lahir</th>
                <th>JK</th>
                <th>Jurusan</th>
                <th>Prodi</th>
                <th>Kelas</th>
                <th>Status</th>
                <th>Sms</th>
                <th style='width:150px'>Aksi</th>
              </tr>";
        
        if($res->num_rows == 0){
            echo "<tr><td colspan='11' style='text-align:center;color:#999'>Tidak ada data</td></tr>";
        } else {
            $no=1;
            while($r=$res->fetch_assoc()){
                $ttl = h($r['mhsTempatLahir']);
                if($r['mhsTglLahir']){
                    $ttl .= ', ' . date('d-m-Y', strtotime($r['mhsTglLahir']));
                }
                
                $statusLabel = [
                    'A' => 'Aktif',
                    'L' => 'Lulus', 
                    'C' => 'Cuti',
                    'D' => 'DO',
                    'K' => 'Keluar',
                    'M' => 'Meninggal'
                ];
                $statusText = $statusLabel[$r['mhsStsAkademik']] ?? $r['mhsStsAkademik'];
                
                echo "<tr>
                        <td>".($no++)."</td>
                        <td><strong>".h($r['mhsNim'])."</strong></td>
                        <td>".h($r['mhsNama'])."</td>
                        <td>$ttl</td>
                        <td>".h($r['mhsJenisKelamin'])."</td>
                        <td>".h($r['jurNama'])."</td>
                        <td>".h($r['prodiNama'])."</td>
                        <td>".h($r['mhsKodeKelas'])."</td>
                        <td>$statusText</td>
                        <td>".h($r['mhsSmsAktif'])."</td>
                        <td>
                            <a class='btn small' style='background:#2d9cdb' href='index.php?page=mahasiswa&aksi=edit&id=".h($r['mhsNim'])."'>✏️ Edit</a>
                            <a class='btn small' style='background:#d9534f' href='index.php?act=mahasiswa_delete&id=".h($r['mhsNim'])."' onclick=\"return confirm('Hapus mahasiswa ".h($r['mhsNama'])."?')\">🗑️ Hapus</a>
                        </td>
                      </tr>";
            }
        }
        echo "</table>";
        
        echo "<div style='margin-top:15px;color:#666;font-size:13px'>";
        echo "Total: <strong>".$res->num_rows."</strong> mahasiswa";
        echo "</div>";
    }
    echo "</div>";
}

/* ------------- TAHUN AKADEMIK CRUD ------------- */
else if($page == "tahun_akademik"){
    echo "<div class='topbar'><h2>Tahun Akademik</h2><div><a class='btn' href='index.php?page=tahun_akademik&aksi=tambah'>+ Tambah Tahun</a></div></div>";
    echo "<div class='card-content'>";
    if(isset($_GET['aksi']) && $_GET['aksi']=='tambah'){
        ?>
        <h3>Tambah Tahun Akademik</h3>
        <form method="post" action="index.php?act=thakd_add">
            <label>ID (angka unik)</label><input class="input" name="thakdId" type="number" required />
            <label>Tahun (YYYY)</label><input class="input" name="thakdTahun" required />
            <label>Semester</label>
            <select class="input" name="thakdSemester">
                <option value="1">Ganjil (1)</option>
                <option value="2">Genap (2)</option>
            </select>
            <label>Tgl Mulai</label><input class="input" name="thakdTglMulai" type="date" />
            <label>Tgl Selesai</label><input class="input" name="thakdTglSelesai" type="date" />
            <label><input type="checkbox" name="thakdIsAktif" checked /> Aktif</label><br><br>
            <button class="btn" name="save_thakd" type="submit">Simpan</button>
            <a class="btn" style="background:#777;margin-left:8px" href="index.php?page=tahun_akademik">Batal</a>
        </form>
        <?php
    } else {
        $res = $koneksi->query("SELECT * FROM tahun_akademik ORDER BY thakdId DESC");
        echo "<table class='table'><tr><th>#</th><th>ID</th><th>Tahun</th><th>Semester</th><th>Mulai</th><th>Selesai</th><th>Aktif</th><th>Aksi</th></tr>";
        $no=1;
        while($r=$res->fetch_assoc()){
            echo "<tr>
                    <td>".($no++)."</td>
                    <td>".h($r['thakdId'])."</td>
                    <td>".h($r['thakdTahun'])."</td>
                    <td>".h($r['thakdSemester'])."</td>
                    <td>".h($r['thakdTglMulai'])."</td>
                    <td>".h($r['thakdTglSelesai'])."</td>
                    <td>".($r['thakdIsAktif']? 'Ya':'Tidak')."</td>
                    <td>
                        <a class='btn small' style='background:#d9534f' href='index.php?act=thakd_delete&id=".h($r['thakdId'])."' onclick=\"return confirm('Hapus tahun akademik ini?')\">Hapus</a>
                    </td>
                  </tr>";
        }
        echo "</table>";
    }
    echo "</div>";
}

/* ------------- UBAH PASSWORD (sederhana) ------------- */
else if($page == "password"){
    echo "<div class='card-content'><h2>Ubah Password</h2>";
    if(isset($_POST['chg_password'])){
        $old = $_POST['oldpw'];
        $new = $_POST['newpw'];
        $uid = $_SESSION['userid'];
        // cek password lama (di DB password disimpan plain di SQL sample)
        $stmt = $koneksi->prepare("SELECT appusrPassword FROM `user` WHERE appusrID = ?");
        $stmt->bind_param("s",$uid); $stmt->execute(); $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        if(!$row || $row['appusrPassword'] !== $old){
            echo "<p style='color:red'>Password lama salah.</p>";
        } else {
            $stmt2 = $koneksi->prepare("UPDATE `user` SET appusrPassword = ? WHERE appusrID = ?");
            $stmt2->bind_param("ss",$new,$uid);
            $stmt2->execute();
            echo "<p style='color:green'>Password berhasil diubah.</p>";
            $stmt2->close();
        }
        $stmt->close();
    }
    ?>
    <form method="post">
        <label>Password Lama</label><input class="input" type="password" name="oldpw" required />
        <label>Password Baru</label><input class="input" type="password" name="newpw" required />
        <button class="btn" name="chg_password" type="submit">Ubah Password</button>
    </form>
    </div>
<?php
}

/* ---------- default fallback ---------- */
else {
    echo "<div class='card-content'><h2>Halaman tidak ditemukan</h2></div>";
}
?>
</div>

<?php endif; ?>

</body>
</html>
