<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Daftar Data Dosen Kelas</h2>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="message-box error"> 
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM PENCARIAN - LANGSUNG LENGKAP (Sesuai Gambar) -->
    <?php if (!isset($_GET['cari'])): ?>
    
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarDosenKelas">

        <div style="background:#E8D5F2;padding:20px;border-radius:8px;margin-bottom:20px;">
            <h3 style="margin-top:0;color:#6A1B9A;text-align:center;">
                Pencarian Daftar Data Dosen Kelas Berdasarkan :
            </h3>
            
            <!-- ROW 1: Tahun Akademik -->
            <div style="display:grid; grid-template-columns: 200px 1fr; gap: 15px; align-items:center; margin-bottom: 15px;">
                <label style="margin:0;font-weight:600;text-align:right;">Thn-Smt Akademik</label>
                <div style="display:flex; gap:10px;">
                    <!-- Tahun -->
                    <select name="thakdId" class="input" required style="width:150px;">
                        <option value="">2025/2026</option>
                        <?php 
                        $listTa->data_seek(0);
                        while($t = $listTa->fetch_assoc()): 
                            $tahunDisplay = $t['thakdTahun'] . '/' . ($t['thakdTahun'] + 1);
                            $selected = (isset($thakdId) && $thakdId == $t['thakdId']) ? 'selected' : '';
                        ?>
                            <option value="<?= $t['thakdId'] ?>" <?= $selected ?>>
                                <?= htmlspecialchars($tahunDisplay) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    
                    <!-- Semester -->
                    <select name="semester" class="input" style="width:120px;">
                        <option value="">Ganjil</option>
                        <option value="1">Ganjil</option>
                        <option value="2">Genap</option>
                    </select>
                </div>
            </div>
            
            <!-- ROW 2: Program Studi -->
            <div style="display:grid; grid-template-columns: 200px 1fr; gap: 15px; align-items:center; margin-bottom: 15px;">
                <label style="margin:0;font-weight:600;text-align:right;">Program Studi</label>
                <select name="prodiId" class="input" required>
                    <option value="">-- Pilih Program Studi --</option>
                    <?php 
                    $listProdi->data_seek(0);
                    while($p = $listProdi->fetch_assoc()): 
                        $selected = (isset($prodiId) && $prodiId == $p['prodiId']) ? 'selected' : '';
                    ?>
                        <option value="<?= $p['prodiId'] ?>" <?= $selected ?>>
                            <?= htmlspecialchars($p['prodiKode'] . ' - ' . $p['prodiNama']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            
            <!-- ROW 3: Nama Kelas -->
            <div style="display:grid; grid-template-columns: 200px 1fr; gap: 15px; align-items:center; margin-bottom: 15px;">
                <label style="margin:0;font-weight:600;text-align:right;">Nama Kelas</label>
                <select name="klsId" class="input" required id="kelasSelect">
                    <option value="">-- Pilih Kelas --</option>
                    <?php if(isset($listKelas)): ?>
                        <?php while($k = $listKelas->fetch_assoc()): ?>
                            <option value="<?= $k['klsId'] ?>">
                                <?= htmlspecialchars($k['klsNama']) ?>
                            </option>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- TOMBOL CARI -->
            <div style="text-align:center; margin-top:20px;">
                <button class="btn" type="submit" name="cari" value="1" 
                        style="background:#C5E1A5; color:#33691E; font-size:16px; padding:12px 40px; font-weight:bold;">
                    Cari
                </button>
            </div>
        </div>
    </form>

    <?php endif; ?>

    <!-- HASIL PENCARIAN: Tabel Dosen -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- HEADER INFO KELAS -->
        <div style="background:#fff;padding:20px;border-radius:8px;margin-bottom:20px;border:2px solid #E8D5F2;">
            <h3 style="margin:0 0 15px 0;color:#6A1B9A;text-align:center;">
                Data Dosen Kelas <?= htmlspecialchars($kelasInfo['klsNama']) ?> 
                TA <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?>
            </h3>
            
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:15px; margin-top:20px;">

                <div style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $totalDosen ?></div>
                    <div style="font-size:14px;opacity:0.9;">Total Dosen</div>
                </div>

                <div style="background:linear-gradient(135deg, #3498db 0%, #2980b9 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $totalMatakuliah ?></div>
                    <div style="font-size:14px;opacity:0.9;">Total Matakuliah</div>
                </div>

                <div style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $rows->num_rows ?></div>
                    <div style="font-size:14px;opacity:0.9;">Total Pengampu</div>
                </div>
            </div>
        </div>

        <!-- TABEL DOSEN -->
        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr style="background:#FFD54F;">
                        <th style="width:50px;text-align:center;">No.</th>
                        <th>Nama Dosen</th>
                        <th>Matakuliah</th>
                        <th style="text-align:center;width:120px;">Kode</th>
                        <th style="text-align:center;width:80px;">SKS</th>
                        <th style="text-align:center;width:80px;">Jam</th>
                        <th style="text-align:center;width:100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $rows->data_seek(0); // Reset pointer
                    while($r = $rows->fetch_assoc()): 
                        // Format nama dosen dengan gelar
                        $namaDosen = '';
                        if (!empty($r['dsnGelarDepan'])) {
                            $namaDosen .= $r['dsnGelarDepan'] . ' ';
                        }
                        $namaDosen .= $r['dsnNama'];
                        if (!empty($r['dsnGelarBelakang'])) {
                            $namaDosen .= ', ' . $r['dsnGelarBelakang'];
                        }
                    ?>
                    <tr>
                        <td data-label="No." style="text-align:center;"><?= $no++ ?></td>
                        <td data-label="Nama Dosen">
                            <strong style="color:#1976D2;"><?= htmlspecialchars($namaDosen) ?></strong>
                        </td>
                        <td data-label="Matakuliah"><?= htmlspecialchars($r['mkNama']) ?></td>
                        <td data-label="Kode" style="text-align:center;">
                            <code style="background:#E3F2FD;padding:4px 8px;border-radius:4px;font-weight:600;">
                                <?= htmlspecialchars($r['mkKode']) ?>
                            </code>
                        </td>
                        <td data-label="SKS" style="text-align:center;"><?= $r['SKS'] ?></td>
                        <td data-label="Jam" style="text-align:center;"><?= $r['Jam'] ?></td>
                        <td data-label="Status" style="text-align:center;">
                            <span style="display:inline-block; padding:4px 12px; border-radius:12px; font-weight:600; font-size:0.85em;
                                        background:<?= $r['Status']=='Aktif' ? '#C8E6C9' : '#FFCDD2' ?>; 
                                        color:<?= $r['Status']=='Aktif' ? '#2E7D32' : '#C62828' ?>;">
                                <?= $r['Status'] ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        

        <!-- FOOTER ACTIONS -->
        <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
            <a href="index.php?page=daftarDosenKelas" class="btn" style="background:#2196F3;">
                Cari Kelas Lain
            </a>
            <button onclick="window.print()" class="btn" style="background:#4CAF50;">
                Cetak
            </button>
            <button onclick="exportToExcel()" class="btn" style="background:#FF9800;">
                Export Excel
            </button>
            <button onclick="exportToPDF()" class="btn" style="background:#F44336;">
                Export PDF
            </button>
        </div>

    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>
        
        <!-- TIDAK ADA DATA DOSEN -->
        <div style="padding:40px;text-align:center;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;">
            <div style="font-size:48px;margin-bottom:15px;"></div>
            <h3 style="margin:0 0 10px 0;color:#856404;">Tidak Ada Dosen</h3>
            <p style="color:#856404;margin-bottom:20px;">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki dosen yang terdaftar.
            </p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <a href="index.php?page=daftarDosenKelas" class="btn" style="background:#2196F3;">
                    Pilih Kelas Lain
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- JAVASCRIPT UNTUK DYNAMIC DROPDOWN -->
<script>
// Auto-load kelas saat prodi dipilih (opsional)
document.addEventListener('DOMContentLoaded', function() {
    const prodiSelect = document.querySelector('select[name="prodiId"]');
    const thakdSelect = document.querySelector('select[name="thakdId"]');
    const kelasSelect = document.getElementById('kelasSelect');
    
    if (prodiSelect && thakdSelect && kelasSelect) {
        prodiSelect.addEventListener('change', loadKelas);
        thakdSelect.addEventListener('change', loadKelas);
    }
    
    function loadKelas() {
        const thakdId = thakdSelect.value;
        const prodiId = prodiSelect.value;
        
        if (thakdId && prodiId) {
            // Redirect dengan parameter untuk load kelas
            window.location.href = `index.php?page=daftarDosenKelas&tahap=pilih_kelas&thakdId=${thakdId}&prodiId=${prodiId}`;
        }
    }
});

// Export to Excel function
function exportToExcel() {
    const table = document.querySelector('.table');
    const kelasName = '<?= htmlspecialchars($kelasInfo['klsNama'] ?? 'Kelas') ?>';
    const ta = '<?= htmlspecialchars($kelasInfo['tahunAkademikLabel'] ?? '') ?>';
    
    let html = table.outerHTML;
    const blob = new Blob(['\ufeff', html], {
        type: 'application/vnd.ms-excel'
    });
    
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `Daftar_Dosen_${kelasName}_${ta}.xls`;
    a.click();
    window.URL.revokeObjectURL(url);
}

// Export to PDF (simple version using print)
function exportToPDF() {
    window.print();
}

</script>

<!-- CSS TAMBAHAN UNTUK PRINT -->
<style>
@media print {
    .sidebar, .topbar .btn, .btn, form {
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
    
    tbody tr:nth-child(even) {
        background: #f9f9f9 !important;
    }
    
    @page {
        margin: 1cm;
        size: landscape;
    }
}

/* Responsive Table */
@media (max-width: 860px) {
    .table thead {
        display: none;
    }
    
    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }
    
    .table tr {
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        background: #fff;
    }
    
    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
        padding: 8px 10px;
    }
    
    .table td:before {
        content: attr(data-label);
        position: absolute;
        left: 10px;
        width: 45%;
        font-weight: 600;
        text-align: left;
        color: #6A1B9A;
    }
}
</style>

<?php include "views/layout/footer.php"; ?>