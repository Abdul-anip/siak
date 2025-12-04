<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Daftar Data Kelas</h2>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="message-box error"> 
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM PENCARIAN -->
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarKelas">

        <div style="background:#f0f7ff;padding:20px;border-radius:8px;margin-bottom:20px;border:1px solid #dbe9fb;">
            <h3 style="margin-top:0;color:#0A3B6F;">Pencarian Daftar Data Kelas Berdasarkan:</h3>
            
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px;">
                <!-- TAHUN AKADEMIK -->
                <div>
                    <label style="margin-top:0;font-weight:600;">Thn-Smt Akademik <span style="color:red">*</span></label>
                    <select name="thakdId" class="input" required>
                        <option value="">-- Pilih Tahun-Semester --</option>
                        <?php 
                        // Reset pointer hasil query
                        $listTa->data_seek(0);
                        while($t = $listTa->fetch_assoc()): 
                            $semesterLabel = ($t['thakdSemester'] == '1') ? 'Ganjil' : 'Genap';
                            $tahunDisplay = $t['thakdTahun'] . '/' . ($t['thakdTahun'] + 1) . ' - ' . $semesterLabel;
                            $selected = (isset($thakdId) && $thakdId == $t['thakdId']) ? 'selected' : '';
                        ?>
                            <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($tahunDisplay) ?>
                                <?= $t['thakdIsAktif'] ? ' 🟢 Aktif' : '' ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small style="color:#666;">Pilih tahun akademik dan semester</small>
                </div>
                
                <!-- PROGRAM STUDI -->
                <div>
                    <label style="margin-top:0;font-weight:600;">Program Studi <span style="color:red">*</span></label>
                    <select name="prodiId" class="input" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php 
                        // Reset pointer hasil query
                        $listProdi->data_seek(0);
                        while($p = $listProdi->fetch_assoc()): 
                            $selected = (isset($prodiId) && $prodiId == $p['prodiId']) ? 'selected' : '';
                        ?>
                            <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($p['prodiNama']) ?> (<?= htmlspecialchars($p['prodiJenjang']) ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <small style="color:#666;">Pilih program studi</small>
                </div>
            </div>

            <button class="btn" type="submit" name="cari" value="1" style="width:100%; background:#5cb85c; font-size:16px; padding:12px;">
                🔍 Cari Data Kelas
            </button>
        </div>
    </form>

    <!-- HASIL PENCARIAN -->
    <?php if (isset($_GET['cari']) && $rows !== null): ?>

        <div style="margin-bottom:15px;padding:12px;background:#e3f2fd;border-left:4px solid #2196F3;border-radius:4px;">
            <strong>Menampilkan hasil untuk:</strong><br>
            Tahun Akademik: <strong><?= isset($thakdId) ? htmlspecialchars($thakdId) : '-' ?></strong> | 
            Program Studi: <strong><?= isset($prodiId) ? htmlspecialchars($prodiId) : '-' ?></strong>
        </div>

        <?php if ($rows->num_rows > 0): ?>

            <div style="overflow-x:auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width:50px;">No.</th>
                            <th>Nama Kelas</th>
                            <th style="text-align:center;">Jlh Mahasiswa</th>
                            <th style="text-align:center;">Jlh Dosen</th>
                            <th style="text-align:center;">Jlh MK</th>
                            <th style="text-align:center;">Jlh SKS</th>
                            <th style="text-align:center;">Jlh Jam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1; 
                        $totalMhs = 0;
                        $totalDosen = 0;
                        $totalMK = 0;
                        $totalSKS = 0;
                        $totalJam = 0;
                        
                        while($r = $rows->fetch_assoc()): 
                            $totalMhs += $r['JlhMahasiswa'];
                            $totalDosen += $r['JlhDosen'];
                            $totalMK += $r['JlhMK'];
                            $totalSKS += $r['JlhSKS'];
                            $totalJam += $r['JlhJam'];
                        ?>
                        <tr>
                            <td data-label="No."><?= $no++ ?></td>
                            <td data-label="Nama Kelas"><strong><?= htmlspecialchars($r['NamaKelas']) ?></strong></td>
                            <td data-label="Jlh Mahasiswa" style="text-align:center;"><?= $r['JlhMahasiswa'] ?></td>
                            <td data-label="Jlh Dosen" style="text-align:center;"><?= $r['JlhDosen'] ?></td>
                            <td data-label="Jlh MK" style="text-align:center;"><?= $r['JlhMK'] ?></td>
                            <td data-label="Jlh SKS" style="text-align:center;"><?= $r['JlhSKS'] ?></td>
                            <td data-label="Jlh Jam" style="text-align:center;"><?= $r['JlhJam'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                        
                        <!-- TOTAL ROW -->
                        <tr style="background:#f0f7ff;font-weight:bold;">
                            <td colspan="2" style="text-align:right;">TOTAL:</td>
                            <td style="text-align:center;"><?= $totalMhs ?></td>
                            <td style="text-align:center;"><?= $totalDosen ?></td>
                            <td style="text-align:center;"><?= $totalMK ?></td>
                            <td style="text-align:center;"><?= $totalSKS ?></td>
                            <td style="text-align:center;"><?= $totalJam ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div style="margin-top:15px;padding:12px;background:#f1f8e9;border-left:4px solid #8bc34a;border-radius:4px;">
                ✅ Ditemukan <strong><?= $rows->num_rows ?></strong> kelas
            </div>

        <?php else: ?>
            
            <div style="padding:40px;text-align:center;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;">
                <div style="font-size:48px;margin-bottom:15px;">📭</div>
                <h3 style="margin:0 0 10px 0;color:#856404;">Tidak Ada Data Kelas</h3>
                <p style="color:#856404;margin-bottom:20px;">
                    Tidak ditemukan kelas untuk kombinasi Tahun Akademik dan Program Studi yang dipilih.
                </p>
                <a href="index.php?page=kelas&aksi=tambah" class="btn" style="background:#ff9800;">
                    ➕ Tambah Kelas Baru
                </a>
            </div>

        <?php endif; ?>

    <?php elseif(isset($_GET['cari'])): ?>
        
        <div style="padding:20px;text-align:center;background:#ffebee;border:1px solid #ef5350;border-radius:8px;">
            <strong style="color:#c62828;">⚠️ Silakan isi form pencarian dengan lengkap!</strong>
        </div>

    <?php endif; ?>

</div>

<!-- DEBUG SECTION (Hanya untuk development) -->
<?php if (isset($_GET['debug']) && isset($_GET['cari'])): ?>
<div class="card-content" style="margin-top:20px;background:#fff3e0;border:2px solid #ff9800;">
    <h3>🔧 Debug Information</h3>
    <pre style="background:#fff;padding:15px;border-radius:4px;overflow:auto;">
<strong>GET Parameters:</strong>
<?php print_r($_GET); ?>

<strong>Selected Values:</strong>
thakdId: <?= isset($thakdId) ? $thakdId : 'NULL' ?>

prodiId: <?= isset($prodiId) ? $prodiId : 'NULL' ?>

<strong>Query Result:</strong>
Rows Found: <?= isset($rows) ? $rows->num_rows : 'NULL' ?>

<?php if(isset($rows) && $rows->num_rows > 0): ?>
<strong>Data:</strong>
<?php 
$rows->data_seek(0);
while($r = $rows->fetch_assoc()): 
    print_r($r);
endwhile;
?>
<?php endif; ?>
    </pre>
    <p><small>💡 Tambahkan <code>&debug=1</code> di URL untuk melihat debug info</small></p>
</div>
<?php endif; ?>

<?php include "views/layout/footer.php"; ?>