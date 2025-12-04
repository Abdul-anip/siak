<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>📚 Daftar Data Matakuliah Kelas</h2>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="message-box error"> 
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM PENCARIAN STEP 1: Pilih Tahun Akademik & Prodi -->
    <?php if (!isset($_GET['tahap']) && !isset($_GET['cari'])): ?>
    
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarMatkulKelas">
        <input type="hidden" name="tahap" value="pilih_kelas">

        <div style="background:#f0f7ff;padding:20px;border-radius:8px;margin-bottom:20px;border:1px solid #dbe9fb;">
            <h3 style="margin-top:0;color:#0A3B6F;">🔍 Step 1: Pilih Tahun Akademik dan Program Studi</h3>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                
                <!-- TAHUN AKADEMIK -->
                <div>
                    <label style="margin-top:0;font-weight:600;">Thn-Smt Akademik <span style="color:red">*</span></label>
                    <select name="thakdId" class="input" required>
                        <option value="">-- Pilih Tahun-Semester --</option>
                        <?php 
                        $listTa->data_seek(0);
                        while($t = $listTa->fetch_assoc()): 
                            $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                            $tahunDisplay = $t['thakdTahun'] . '/' . ($t['thakdTahun'] + 1) . ' - ' . $semesterLabel;
                        ?>
                            <option value="<?= $t['thakdId'] ?>">
                                <?= htmlspecialchars($tahunDisplay) ?>
                                <?= $t['thakdIsAktif'] ? ' 🟢 Aktif' : '' ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- PROGRAM STUDI -->
                <div>
                    <label style="margin-top:0;font-weight:600;">Program Studi <span style="color:red">*</span></label>
                    <select name="prodiId" class="input" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php 
                        $listProdi->data_seek(0);
                        while($p = $listProdi->fetch_assoc()): 
                        ?>
                            <option value="<?= $p['prodiId'] ?>">
                                <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <button class="btn" type="submit" style="width:100%; background:#2196F3; font-size:16px; padding:12px;">
                ▶️ Lanjut ke Pilih Kelas
            </button>
        </div>
    </form>

    <?php endif; ?>

    <!-- FORM PENCARIAN STEP 2: Pilih Kelas -->
    <?php if (isset($_GET['tahap']) && $_GET['tahap'] == 'pilih_kelas' && isset($listKelas) && $listKelas->num_rows > 0): ?>
    
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarMatkulKelas">
        <input type="hidden" name="thakdId" value="<?= htmlspecialchars($thakdId) ?>">
        <input type="hidden" name="prodiId" value="<?= htmlspecialchars($prodiId ?? '') ?>">

        <div style="background:#f0f7ff;padding:20px;border-radius:8px;margin-bottom:20px;border:1px solid #dbe9fb;">
            <h3 style="margin-top:0;color:#0A3B6F;">🔍 Step 2: Pilih Nama Kelas</h3>
            
            <div style="margin-bottom: 15px;">
                <label style="margin-top:0;font-weight:600;">Nama Kelas <span style="color:red">*</span></label>
                <select name="klsId" class="input" required>
                    <option value="">-- Pilih Nama Kelas --</option>
                    <?php while($k = $listKelas->fetch_assoc()): ?>
                        <option value="<?= $k['klsId'] ?>">
                            <?= htmlspecialchars($k['klsNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <small style="color:#666;">Pilih kelas yang ingin dilihat daftar matakuliahnya</small>
            </div>

            <div style="display:flex; gap:10px;">
                <button class="btn" type="submit" name="cari" value="1" style="flex:1; background:#5cb85c; font-size:16px; padding:12px;">
                    🔍 Tampilkan Daftar Matakuliah
                </button>
                <a href="index.php?page=daftarMatkulKelas" class="btn" style="background:#777; padding:12px 24px;">
                    ↩️ Ulang
                </a>
            </div>
        </div>
    </form>

    <?php endif; ?>

    <!-- HASIL PENCARIAN: Tabel Matakuliah -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- INFO KELAS -->
        <div style="background:#e3f2fd;padding:15px;border-left:4px solid #2196F3;border-radius:4px;margin-bottom:20px;">
            <h3 style="margin:0 0 10px 0;color:#0A3B6F;">Informasi Kelas</h3>
            <table style="width:100%; max-width:600px;">
                <tr>
                    <td style="padding:4px 0; width:200px;"><strong>Tahun Akademik</strong></td>
                    <td style="padding:4px 0;">: <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?></td>
                </tr>
                <tr>
                    <td style="padding:4px 0;"><strong>Program Studi</strong></td>
                    <td style="padding:4px 0;">: <?= htmlspecialchars($kelasInfo['prodiNama']) ?> (<?= htmlspecialchars($kelasInfo['prodiJenjang']) ?>)</td>
                </tr>
                <tr>
                    <td style="padding:4px 0;"><strong>Nama Kelas</strong></td>
                    <td style="padding:4px 0;">: <?= htmlspecialchars($kelasInfo['klsNama']) ?></td>
                </tr>
                <tr>
                    <td style="padding:4px 0;"><strong>Total SKS</strong></td>
                    <td style="padding:4px 0;">: <span style="background:#4CAF50;color:white;padding:2px 12px;border-radius:12px;font-weight:bold;"><?= $totalSKS ?> SKS</span></td>
                </tr>
            </table>
        </div>

        <!-- TABEL MATAKULIAH -->
        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width:50px;">No</th>
                        <th>Kode</th>
                        <th>Nama Matakuliah</th>
                        <th style="text-align:center;width:80px;">SKS</th>
                        <th style="text-align:center;width:100px;">Semester</th>
                        <th style="text-align:center;width:80px;">T/P</th>
                        <th style="text-align:center;width:100px;">KMK</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $totalSKSTable = 0;
                    while($r = $rows->fetch_assoc()): 
                        $totalSKSTable += $r['SKS'];
                    ?>
                    <tr>
                        <td data-label="No" style="text-align:center;"><?= $no++ ?></td>
                        <td data-label="Kode"><strong><?= htmlspecialchars($r['mkKode']) ?></strong></td>
                        <td data-label="Nama Matakuliah"><?= htmlspecialchars($r['mkNama']) ?></td>
                        <td data-label="SKS" style="text-align:center;"><?= $r['SKS'] ?></td>
                        <td data-label="Semester" style="text-align:center;"><?= $r['Semester'] ?></td>
                        <td data-label="T/P" style="text-align:center;">
                            <span style="display:inline-block; padding:2px 8px; border-radius:4px; font-weight:600; 
                                        background:<?= $r['T_P']=='T' ? '#E3F2FD' : '#FFF3E0' ?>; 
                                        color:<?= $r['T_P']=='T' ? '#1976D2' : '#F57C00' ?>;">
                                <?= $r['T_P'] ?>
                            </span>
                        </td>
                        <td data-label="KMK" style="text-align:center;"><?= htmlspecialchars($r['KMK']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                    
                    <!-- TOTAL ROW -->
                    <tr style="background:#f0f7ff;font-weight:bold;">
                        <td colspan="3" style="text-align:right;">TOTAL SKS:</td>
                        <td style="text-align:center;color:#2196F3;font-size:1.1em;"><?= $totalSKSTable ?></td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- FOOTER INFO -->
        <div style="margin-top:15px;padding:12px;background:#f1f8e9;border-left:4px solid #8bc34a;border-radius:4px;">
            Ditemukan <strong><?= $rows->num_rows ?></strong> matakuliah | 
            Total <strong><?= $totalSKSTable ?> SKS</strong>
        </div>

        <!-- TOMBOL AKSI -->
        <div style="margin-top:20px;display:flex;gap:10px;">
            <a href="index.php?page=daftarMatkulKelas" class="btn" style="background:#2196F3;">
                Cari Kelas Lain
            </a>
            <button onclick="window.print()" class="btn" style="background:#4CAF50;">
                Cetak
            </button>
        </div>

    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>
        
        <!-- TIDAK ADA DATA MATAKULIAH -->
        <div style="padding:40px;text-align:center;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;">
            <div style="font-size:48px;margin-bottom:15px;">📭</div>
            <h3 style="margin:0 0 10px 0;color:#856404;">Tidak Ada Matakuliah</h3>
            <p style="color:#856404;margin-bottom:20px;">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki matakuliah yang terdaftar.
            </p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <a href="index.php?page=daftarMatkulKelas" class="btn" style="background:#2196F3;">
                    🔄 Pilih Kelas Lain
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- CSS TAMBAHAN UNTUK PRINT -->
<style>
@media print {
    .sidebar, .topbar .btn, .btn {
        display: none !important;
    }
    
    .content-wrapper {
        margin-left: 0 !important;
        padding: 20px !important;
    }
    
    .card-content {
        box-shadow: none !important;
        border: 1px solid #000;
    }
    
    table {
        page-break-inside: auto;
    }
    
    tr {
        page-break-inside: avoid;
        page-break-after: auto;
    }
    
    thead {
        display: table-header-group;
    }
    
    @page {
        margin: 1cm;
    }
}
</style>

<?php include "views/layout/footer.php"; ?>