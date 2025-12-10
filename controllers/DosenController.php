<?php

require "models/Dosen.php";
require "models/Jurusan.php";
require "models/Prodi.php";

$dosen = new Dosen($koneksi);
$jur = new Jurusan($koneksi);
$prodi = new Prodi($koneksi);

$aksi = $_GET['aksi'] ?? "index";


// LIST
if ($aksi == "index") {

    $q = $_GET['q'] ?? '';

        if ($q) {
            $rows = $dosen->search($q);
        } else {
            $rows = $dosen->all();
        }

    require "views/dosen/index.php";
}


// FORM TAMBAH
// FORM TAMBAH
else if ($aksi == "tambah") {

    $jurusan = $jur->all();
    $listProdi = $prodi->all();
    
    // ✅ TAMBAHAN: Ambil daftar kelas aktif
    $listKelas = $koneksi->query("
        SELECT 
            k.klsId, 
            k.klsNama,
            k.klsProdiId,
            CONCAT(
                t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                CASE t.thakdSemester 
                    WHEN '1' THEN 'Ganjil' 
                    WHEN '2' THEN 'Genap' 
                END,
                ' | ', p.prodiNama, ' | Kelas ', k.klsNama
            ) AS kelasLabel
        FROM kelas k
        JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        JOIN program_studi p ON k.klsProdiId = p.prodiId
        WHERE t.thakdIsAktif = 1
        ORDER BY p.prodiNama, k.klsNama
    ");

    require "views/dosen/create.php";
}


// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_dosen'])) {

    $result = $dosen->store($_POST);

    // Jika ERROR → tampilkan form create
    if (!$result['status']) {

        $error     = $result['error'];   
        $jurusan   = $jur->all();        
        $listProdi = $prodi->all();
        
        // ✅ TAMBAHAN: Kirim ulang list kelas jika error
        $listKelas = $koneksi->query("
            SELECT 
                k.klsId, 
                k.klsNama,
                k.klsProdiId,
                CONCAT(
                    t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                    CASE t.thakdSemester 
                        WHEN '1' THEN 'Ganjil' 
                        WHEN '2' THEN 'Genap' 
                    END,
                    ' | ', p.prodiNama, ' | Kelas ', k.klsNama
                ) AS kelasLabel
            FROM kelas k
            JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
            JOIN program_studi p ON k.klsProdiId = p.prodiId
            WHERE t.thakdIsAktif = 1
            ORDER BY p.prodiNama, k.klsNama
        ");
        
        $old       = $_POST;             

        require "views/dosen/create.php";
        exit;
    }

    /* =========================================================
       PERBAIKAN: Daftarkan Dosen ke Kelas dengan Matakuliah
       ========================================================= */

    $dsnNidn = $koneksi->real_escape_string($_POST['dsnNidn']);
    $klsId = isset($_POST['klsId']) ? intval($_POST['klsId']) : 0;

    // Hanya lanjutkan jika klsId valid (bukan 0)
    if ($klsId > 0) {
        
        // Debug: Log untuk memastikan klsId diterima
        error_log("DEBUG: klsId = $klsId, dsnNidn = $dsnNidn");
        
        // Ambil SEMUA matakuliah di kelas ini
        $mkKelas = $koneksi->query("
            SELECT klsmkMkId 
            FROM kelas_matakuliah 
            WHERE klsmkKlsId = $klsId
        ");
        
        // Debug: Cek jumlah matakuliah
        if ($mkKelas) {
            error_log("DEBUG: Jumlah matakuliah di kelas = " . $mkKelas->num_rows);
        } else {
            error_log("ERROR: Query kelas_matakuliah gagal - " . $koneksi->error);
        }
        
        // Jika ada matakuliah di kelas
        if ($mkKelas && $mkKelas->num_rows > 0) {
            
            // Siapkan prepared statement untuk insert ke kelas_dosen
            $stmtEnroll = $koneksi->prepare("
                INSERT INTO kelas_dosen (klsdsnKlsId, klsdsnDsnNidn, klsdsnMkId, klsdsnIsAktif)
                VALUES (?, ?, ?, 1)
                ON DUPLICATE KEY UPDATE klsdsnIsAktif = 1
            ");
            
            if (!$stmtEnroll) {
                // Jika prepare gagal, log error
                error_log("ERROR: Prepare statement gagal - " . $koneksi->error);
            } else {
                // Counter untuk tracking
                $successCount = 0;
                $errorCount = 0;
                
                // Loop untuk setiap matakuliah di kelas
                while ($mk = $mkKelas->fetch_assoc()) {
                    $mkId = intval($mk['klsmkMkId']);
                    
                    // Bind parameter dan execute
                    $stmtEnroll->bind_param("isi", $klsId, $dsnNidn, $mkId);
                    
                    if ($stmtEnroll->execute()) {
                        $successCount++;
                        error_log("SUCCESS: Insert dosen $dsnNidn ke mkId=$mkId berhasil");
                    } else {
                        $errorCount++;
                        error_log("ERROR: Insert kelas_dosen gagal untuk mkId=$mkId - " . $stmtEnroll->error);
                    }
                }
                
                $stmtEnroll->close();
                
                // Log ringkasan
                error_log("SUMMARY: $successCount berhasil, $errorCount gagal");
                
                // Set session message untuk user feedback
                if ($successCount > 0) {
                    $_SESSION['success'] = "Dosen berhasil ditambahkan dan didaftarkan ke $successCount matakuliah di kelas.";
                }
                if ($errorCount > 0) {
                    $_SESSION['warning'] = "$errorCount matakuliah gagal didaftarkan.";
                }
            }
            
        } else {
            // Tidak ada matakuliah di kelas - berikan feedback ke user
            $_SESSION['warning'] = "Dosen berhasil ditambahkan, tetapi kelas belum memiliki matakuliah. Silakan tambahkan matakuliah ke kelas terlebih dahulu.";
            error_log("WARNING: Kelas $klsId tidak memiliki matakuliah");
        }
    } else {
        // Jika klsId = 0, dosen hanya disimpan tanpa didaftarkan ke kelas
        $_SESSION['info'] = "Dosen berhasil ditambahkan tanpa didaftarkan ke kelas.";
        error_log("INFO: Dosen ditambahkan tanpa kelas (klsId = 0)");
    }

    // Redirect ke halaman daftar dosen
    header("Location: index.php?page=dosen");
    exit;
}


// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {

    $data = $dosen->get($_GET['id']);
    $jurusan   = $jur->all();
    $listProdi = $prodi->all();

    require "views/dosen/edit.php";
}


// SIMPAN UPDATE
else if ($aksi == "update" && isset($_POST['update_dosen'])) {

    $dosen->update($_POST['dsnNidn'], $_POST);

    header("Location: index.php?page=dosen");
}


// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {

    $dosen->delete($_GET['id']);

    header("Location: index.php?page=dosen");
}

?>