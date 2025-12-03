<?php
/**
 * TEST DATABASE - Untuk debugging masalah Daftar Kelas
 * Akses via: http://localhost/siakad/test_database.php
 */

require "config/database.php";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Database - SIAKAD</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .box { background: white; padding: 20px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { color: #0A3B6F; border-bottom: 2px solid #1E88E5; padding-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #EAF4FF; color: #0A3B6F; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; }
        .info { background: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 4px; }
        pre { background: #f8f9fa; padding: 15px; border-radius: 4px; overflow-x: auto; }
    </style>
</head>
<body>

<h1>🔍 Test Database SIAKAD</h1>
<p style="color:#666;">Script untuk debugging masalah Daftar Kelas</p>

<!-- TEST 1: Cek Koneksi Database -->
<div class="box">
    <h2>1️⃣ Test Koneksi Database</h2>
    <?php if($koneksi->connect_error): ?>
        <div class="error">❌ Koneksi GAGAL: <?= $koneksi->connect_error ?></div>
    <?php else: ?>
        <div class="success">✅ Koneksi database berhasil!</div>
        <p>Database: <strong><?= $koneksi->get_server_info() ?></strong></p>
    <?php endif; ?>
</div>

<!-- TEST 2: Cek Data Tahun Akademik -->
<div class="box">
    <h2>2️⃣ Data Tahun Akademik</h2>
    <?php
    $ta = $koneksi->query("SELECT * FROM tahun_akademik ORDER BY thakdId DESC");
    if($ta && $ta->num_rows > 0):
    ?>
        <div class="success">✅ Ditemukan <?= $ta->num_rows ?> tahun akademik</div>
        <table>
            <tr>
                <th>ID</th>
                <th>Tahun</th>
                <th>Semester</th>
                <th>Tgl Mulai</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
            </tr>
            <?php while($t = $ta->fetch_assoc()): ?>
            <tr>
                <td><?= $t['thakdId'] ?></td>
                <td><?= $t['thakdTahun'] ?></td>
                <td><?= $t['thakdSemester'] == '1' ? 'Ganjil' : 'Genap' ?></td>
                <td><?= $t['thakdTglMulai'] ?></td>
                <td><?= $t['thakdTglSelesai'] ?></td>
                <td><?= $t['thakdIsAktif'] ? '🟢 Aktif' : '⚪ Tidak Aktif' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">❌ Tidak ada data tahun akademik!</div>
    <?php endif; ?>
</div>

<!-- TEST 3: Cek Data Program Studi -->
<div class="box">
    <h2>3️⃣ Data Program Studi</h2>
    <?php
    $prodi = $koneksi->query("SELECT p.*, j.jurNama FROM program_studi p LEFT JOIN jurusan j ON p.prodiJurId = j.jurId ORDER BY p.prodiId");
    if($prodi && $prodi->num_rows > 0):
    ?>
        <div class="success">✅ Ditemukan <?= $prodi->num_rows ?> program studi</div>
        <table>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Nama Prodi</th>
                <th>Jurusan</th>
                <th>Jenjang</th>
                <th>Status</th>
            </tr>
            <?php while($p = $prodi->fetch_assoc()): ?>
            <tr>
                <td><?= $p['prodiId'] ?></td>
                <td><?= $p['prodiKode'] ?></td>
                <td><?= $p['prodiNama'] ?></td>
                <td><?= $p['jurNama'] ?></td>
                <td><?= $p['prodiJenjang'] ?></td>
                <td><?= $p['prodiIsAktif'] ? '🟢 Aktif' : '⚪ Tidak Aktif' ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">❌ Tidak ada data program studi!</div>
    <?php endif; ?>
</div>

<!-- TEST 4: Cek Data Kelas -->
<div class="box">
    <h2>4️⃣ Data Kelas</h2>
    <?php
    $kelas = $koneksi->query("
        SELECT 
            k.*,
            t.thakdTahun,
            t.thakdSemester,
            p.prodiNama
        FROM kelas k
        LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
        LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
        ORDER BY k.klsId
    ");
    if($kelas && $kelas->num_rows > 0):
    ?>
        <div class="success">✅ Ditemukan <?= $kelas->num_rows ?> kelas</div>
        <table>
            <tr>
                <th>ID Kelas</th>
                <th>Nama Kelas</th>
                <th>Tahun Akademik ID</th>
                <th>Tahun/Semester</th>
                <th>Prodi ID</th>
                <th>Nama Prodi</th>
            </tr>
            <?php while($k = $kelas->fetch_assoc()): ?>
            <tr>
                <td><?= $k['klsId'] ?></td>
                <td><strong><?= $k['klsNama'] ?></strong></td>
                <td><?= $k['klsThakdId'] ?></td>
                <td><?= $k['thakdTahun'] ?>/<?= ($k['thakdTahun']+1) ?> - <?= $k['thakdSemester']=='1'?'Ganjil':'Genap' ?></td>
                <td><?= $k['klsProdiId'] ?></td>
                <td><?= $k['prodiNama'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">❌ Tidak ada data kelas!</div>
        <div class="info" style="margin-top:10px;">
            💡 Silakan tambah data kelas melalui menu <a href="index.php?page=kelas&aksi=tambah">Data Kelas</a>
        </div>
    <?php endif; ?>
</div>

<!-- TEST 5: Cek Data Mahasiswa per Kelas -->
<div class="box">
    <h2>5️⃣ Data Mahasiswa per Kelas</h2>
    <?php
    $kelasMhs = $koneksi->query("
        SELECT 
            k.klsNama,
            COUNT(km.klsmhsId) as jumlah_mahasiswa
        FROM kelas k
        LEFT JOIN kelas_mahasiswa km ON k.klsId = km.klsmhsKlsId AND km.klsmhsIsAktif = 1
        GROUP BY k.klsId, k.klsNama
        ORDER BY k.klsNama
    ");
    if($kelasMhs && $kelasMhs->num_rows > 0):
    ?>
        <table>
            <tr>
                <th>Nama Kelas</th>
                <th>Jumlah Mahasiswa</th>
            </tr>
            <?php while($km = $kelasMhs->fetch_assoc()): ?>
            <tr>
                <td><?= $km['klsNama'] ?></td>
                <td><?= $km['jumlah_mahasiswa'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">❌ Tidak ada data kelas!</div>
    <?php endif; ?>
</div>

<!-- TEST 6: Cek Data Dosen per Kelas -->
<div class="box">
    <h2>6️⃣ Data Dosen per Kelas</h2>
    <?php
    $kelasDosen = $koneksi->query("
        SELECT 
            k.klsNama,
            COUNT(DISTINCT kd.klsdsnDsnNidn) as jumlah_dosen
        FROM kelas k
        LEFT JOIN kelas_dosen kd ON k.klsId = kd.klsdsnKlsId AND kd.klsdsnIsAktif = 1
        GROUP BY k.klsId, k.klsNama
        ORDER BY k.klsNama
    ");
    if($kelasDosen && $kelasDosen->num_rows > 0):
    ?>
        <table>
            <tr>
                <th>Nama Kelas</th>
                <th>Jumlah Dosen</th>
            </tr>
            <?php while($kd = $kelasDosen->fetch_assoc()): ?>
            <tr>
                <td><?= $kd['klsNama'] ?></td>
                <td><?= $kd['jumlah_dosen'] ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php else: ?>
        <div class="error">❌ Tidak ada data kelas!</div>
    <?php endif; ?>
</div>

<!-- TEST 7: Test Query Daftar Kelas -->
<div class="box">
    <h2>7️⃣ Test Query Daftar Kelas</h2>
    <p>Test dengan data yang ada di database:</p>
    <?php
    // Ambil tahun akademik pertama
    $taFirst = $koneksi->query("SELECT thakdId FROM tahun_akademik ORDER BY thakdId DESC LIMIT 1")->fetch_assoc();
    // Ambil prodi pertama yang punya kelas
    $prodiFirst = $koneksi->query("SELECT DISTINCT klsProdiId FROM kelas LIMIT 1")->fetch_assoc();
    
    if($taFirst && $prodiFirst):
        $testThakdId = $taFirst['thakdId'];
        $testProdiId = $prodiFirst['klsProdiId'];
    ?>
        <div class="info">
            Testing dengan:<br>
            - Tahun Akademik ID: <strong><?= $testThakdId ?></strong><br>
            - Program Studi ID: <strong><?= $testProdiId ?></strong>
        </div>
        
        <?php
        $testQuery = "
            SELECT 
                k.klsId,
                k.klsNama AS NamaKelas,
                (SELECT COUNT(*) FROM kelas_mahasiswa km WHERE km.klsmhsKlsId = k.klsId AND km.klsmhsIsAktif = 1) AS JlhMahasiswa,
                (SELECT COUNT(DISTINCT klsdsnDsnNidn) FROM kelas_dosen kd WHERE kd.klsdsnKlsId = k.klsId AND kd.klsdsnIsAktif = 1) AS JlhDosen,
                (SELECT COUNT(*) FROM kelas_matakuliah kmk WHERE kmk.klsmkKlsId = k.klsId) AS JlhMK,
                (SELECT COALESCE(SUM(m.mkSks), 0) FROM kelas_matakuliah kmk LEFT JOIN matakuliah m ON kmk.klsmkMkId = m.mkId WHERE kmk.klsmkKlsId = k.klsId) AS JlhSKS,
                (SELECT COALESCE(SUM(m.mkSks), 0) FROM kelas_matakuliah kmk LEFT JOIN matakuliah m ON kmk.klsmkMkId = m.mkId WHERE kmk.klsmkKlsId = k.klsId) AS JlhJam
            FROM kelas k
            WHERE k.klsThakdId = '$testThakdId'
            AND k.klsProdiId = '$testProdiId'
            ORDER BY k.klsNama ASC
        ";
        
        $testResult = $koneksi->query($testQuery);
        
        if($testResult && $testResult->num_rows > 0):
        ?>
            <div class="success" style="margin-top:10px;">✅ Query berhasil! Ditemukan <?= $testResult->num_rows ?> kelas</div>
            <table>
                <tr>
                    <th>Nama Kelas</th>
                    <th>Jlh Mhs</th>
                    <th>Jlh Dosen</th>
                    <th>Jlh MK</th>
                    <th>Jlh SKS</th>
                    <th>Jlh Jam</th>
                </tr>
                <?php while($tr = $testResult->fetch_assoc()): ?>
                <tr>
                    <td><?= $tr['NamaKelas'] ?></td>
                    <td><?= $tr['JlhMahasiswa'] ?></td>
                    <td><?= $tr['JlhDosen'] ?></td>
                    <td><?= $tr['JlhMK'] ?></td>
                    <td><?= $tr['JlhSKS'] ?></td>
                    <td><?= $tr['JlhJam'] ?></td>
                </tr>
                <?php endwhile; ?>
            </table>
            
            <div class="success" style="margin-top:10px;">
                🎉 <strong>QUERY BEKERJA!</strong> Masalahnya kemungkinan di form atau controller.
            </div>
        <?php else: ?>
            <div class="error" style="margin-top:10px;">❌ Query tidak mengembalikan hasil</div>
            <pre><?= $testQuery ?></pre>
        <?php endif; ?>
        
    <?php else: ?>
        <div class="error">❌ Tidak ada data untuk test</div>
    <?php endif; ?>
</div>

<!-- KESIMPULAN -->
<div class="box" style="background:#e8f5e9;border:2px solid #4caf50;">
    <h2>📊 Kesimpulan & Solusi</h2>
    <?php
    $ta = $koneksi->query("SELECT COUNT(*) as total FROM tahun_akademik")->fetch_assoc();
    $prodi = $koneksi->query("SELECT COUNT(*) as total FROM program_studi")->fetch_assoc();
    $kelas = $koneksi->query("SELECT COUNT(*) as total FROM kelas")->fetch_assoc();
    $mhs = $koneksi->query("SELECT COUNT(*) as total FROM kelas_mahasiswa WHERE klsmhsIsAktif=1")->fetch_assoc();
    ?>
    
    <ul style="line-height:2;">
        <li>Tahun Akademik: <strong><?= $ta['total'] ?></strong></li>
        <li>Program Studi: <strong><?= $prodi['total'] ?></strong></li>
        <li>Kelas: <strong><?= $kelas['total'] ?></strong></li>
        <li>Relasi Mahasiswa-Kelas: <strong><?= $mhs['total'] ?></strong></li>
    </ul>
    
    <?php if($kelas['total'] == 0): ?>
        <div class="error">
            ⚠️ <strong>MASALAH DITEMUKAN:</strong> Tidak ada data kelas!<br><br>
            <strong>Solusi:</strong><br>
            1. Tambah data kelas melalui menu <a href="index.php?page=kelas&aksi=tambah">Data Kelas</a><br>
            2. Pastikan Tahun Akademik dan Program Studi sudah dipilih dengan benar
        </div>
    <?php else: ?>
        <div class="success">
            ✅ Database sudah memiliki data yang cukup untuk menampilkan Daftar Kelas
        </div>
    <?php endif; ?>
</div>

<div style="text-align:center;margin-top:30px;padding:20px;background:white;border-radius:8px;">
    <a href="index.php" class="btn" style="background:#1E88E5;color:white;padding:12px 24px;text-decoration:none;border-radius:6px;display:inline-block;">
        🏠 Kembali ke Beranda
    </a>
</div>

</body>
</html>