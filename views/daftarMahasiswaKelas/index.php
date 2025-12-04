<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Daftar Data Mahasiswa Kelas</h2>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="message-box error"> 
            <?= $error ?>
        </div>
    <?php endif; ?>

    <!-- FORM PENCARIAN -->
    <?php if (!isset($_GET['cari'])): ?>
    
    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarMahasiswaKelas">

        <div style="background:#E8D5F2;padding:20px;border-radius:8px;margin-bottom:20px;">
            <h3 style="margin-top:0;color:#6A1B9A;text-align:center;">
                Pencarian Daftar Data Mahasiswa Kelas Berdasarkan :
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

    <!-- HASIL PENCARIAN: Tabel Mahasiswa -->
    <?php if (isset($_GET['cari']) && $kelasInfo && $rows && $rows->num_rows > 0): ?>

        <!-- HEADER INFO KELAS & STATISTIK -->
        <div style="background:#fff;padding:20px;border-radius:8px;margin-bottom:20px;border:2px solid #E8D5F2;">
            <h3 style="margin:0 0 15px 0;color:#6A1B9A;text-align:center;">
                Data Mahasiswa Kelas <?= htmlspecialchars($kelasInfo['klsNama']) ?> 
                TA <?= htmlspecialchars($kelasInfo['tahunAkademikLabel']) ?>
            </h3>
            
            <!-- STATISTIK CARDS -->
            <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:15px; margin-top:20px;">
                
                <!-- Total Mahasiswa -->
                <div style="background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $totalMahasiswa ?></div>
                    <div style="font-size:14px;opacity:0.9;">Total Mahasiswa</div>
                </div>
                
                <!-- Laki-laki -->
                <div style="background:linear-gradient(135deg, #3498db 0%, #2980b9 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $statsByGender['L'] ?></div>
                    <div style="font-size:14px;opacity:0.9;">Laki-laki</div>
                </div>
                
                <!-- Perempuan -->
                <div style="background:linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $statsByGender['P'] ?></div>
                    <div style="font-size:14px;opacity:0.9;">Perempuan</div>
                </div>
                
                <!-- Status Aktif -->
                <div style="background:linear-gradient(135deg, #27ae60 0%, #229954 100%);color:white;padding:20px;border-radius:8px;text-align:center;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
                    <div style="font-size:36px;font-weight:bold;"><?= $statsByStatus['Aktif'] ?? 0 ?></div>
                    <div style="font-size:14px;opacity:0.9;">Status Aktif</div>
                </div>
            </div>
        </div>

        <!-- TABEL MAHASISWA -->
        <div style="overflow-x:auto;">
            <table class="table">
                <thead>
                    <tr style="background:#FFD54F;">
                        <th style="width:50px;text-align:center;">No.</th>
                        <th style="width:120px;">NIM</th>
                        <th>Nama Mahasiswa</th>
                        <th style="width:180px;">Tempat/Tgl Lahir</th>
                        <th style="text-align:center;width:60px;">JK</th>
                        <th style="width:200px;">Prodi</th>
                        <th style="text-align:center;width:100px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1; 
                    $rows->data_seek(0); // Reset pointer
                    while($r = $rows->fetch_assoc()): 
                    ?>
                    <tr>
                        <td data-label="No." style="text-align:center;"><?= $no++ ?></td>
                        <td data-label="NIM">
                            <strong style="color:#1976D2;font-family:monospace;">
                                <?= htmlspecialchars($r['NIM']) ?>
                            </strong>
                        </td>
                        <td data-label="Nama Mahasiswa">
                            <strong><?= htmlspecialchars($r['NamaMahasiswa']) ?></strong>
                        </td>
                        <td data-label="Tempat/Tgl Lahir">
                            <?= htmlspecialchars($r['TempatTglLahir']) ?>
                        </td>
                        <td data-label="JK" style="text-align:center;">
                            <span style="display:inline-block; width:32px; height:32px; border-radius:50%; 
                                        line-height:32px; font-weight:bold; font-size:14px;
                                        background:<?= $r['JK']=='L' ? '#BBDEFB' : '#F8BBD0' ?>; 
                                        color:<?= $r['JK']=='L' ? '#1565C0' : '#C2185B' ?>;">
                                <?= $r['JK'] == 'L' ? 'L' : 'P' ?>
                            </span>
                        </td>
                        <td data-label="Prodi">
                            <div style="font-weight:600;color:#424242;">
                                <?= htmlspecialchars($r['ProdiKode']) ?>
                            </div>
                            <div style="font-size:0.85em;color:#757575;">
                                <?= htmlspecialchars($r['Prodi']) ?>
                            </div>
                        </td>
                        <td data-label="Status" style="text-align:center;">
                            <?php
                            $statusColors = [
                                'Aktif' => ['bg' => '#C8E6C9', 'text' => '#2E7D32'],
                                'Lulus' => ['bg' => '#BBDEFB', 'text' => '#1565C0'],
                                'Cuti' => ['bg' => '#FFF9C4', 'text' => '#F57F17'],
                                'DO' => ['bg' => '#FFCDD2', 'text' => '#C62828'],
                                'Keluar' => ['bg' => '#FFE0B2', 'text' => '#E65100'],
                                'Meninggal' => ['bg' => '#B0BEC5', 'text' => '#263238']
                            ];
                            
                            $status = $r['Status'];
                            $color = $statusColors[$status] ?? ['bg' => '#E0E0E0', 'text' => '#424242'];
                            ?>
                            <span style="display:inline-block; padding:5px 12px; border-radius:12px; 
                                        font-weight:600; font-size:0.85em;
                                        background:<?= $color['bg'] ?>; 
                                        color:<?= $color['text'] ?>;">
                                <?= $status ?>
                            </span>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- FOOTER INFO -->
        <div style="margin-top:15px;padding:12px;background:#f1f8e9;border-left:4px solid #8bc34a;border-radius:4px;">
            Total <strong><?= $rows->num_rows ?></strong> mahasiswa | 
            Laki-laki: <strong><?= $statsByGender['L'] ?></strong> | 
            Perempuan: <strong><?= $statsByGender['P'] ?></strong>
        </div>

        <!-- FOOTER ACTIONS -->
        <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap;">
            <a href="index.php?page=daftarMahasiswaKelas" class="btn" style="background:#2196F3;">
                Cari Kelas Lain
            </a>
            <button onclick="window.print()" class="btn" style="background:#4CAF50;">
                Cetak Daftar
            </button>
            <button onclick="exportToExcel()" class="btn" style="background:#FF9800;">
                Export Excel
            </button>
        </div>

    <?php elseif (isset($_GET['cari']) && $kelasInfo): ?>
        
        <!-- TIDAK ADA DATA MAHASISWA -->
        <div style="padding:40px;text-align:center;background:#fff3cd;border:1px solid #ffc107;border-radius:8px;">
            <div style="font-size:48px;margin-bottom:15px;"></div>
            <h3 style="margin:0 0 10px 0;color:#856404;">Tidak Ada Mahasiswa</h3>
            <p style="color:#856404;margin-bottom:20px;">
                Kelas <strong><?= htmlspecialchars($kelasInfo['klsNama']) ?></strong> belum memiliki mahasiswa yang terdaftar.
            </p>
            <div style="display:flex;gap:10px;justify-content:center;">
                <a href="index.php?page=daftarMahasiswaKelas" class="btn" style="background:#2196F3;">
                    Pilih Kelas Lain
                </a>
                <a href="index.php?page=mahasiswa&aksi=tambah" class="btn" style="background:#4CAF50;">
                    Tambah Mahasiswa
                </a>
            </div>
        </div>

    <?php endif; ?>

</div>

<!-- JAVASCRIPT -->
<script>
// Auto-load kelas saat prodi dipilih
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
            window.location.href = `index.php?page=daftarMahasiswaKelas&tahap=pilih_kelas&thakdId=${thakdId}&prodiId=${prodiId}`;
        }
    }
});

// Export to Excel
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
    a.download = `Daftar_Mahasiswa_${kelasName}_${ta}.xls`;
    a.click();
    window.URL.revokeObjectURL(url);
}


</script>

<!-- CSS TAMBAHAN -->
<style>
/* Hover effect untuk baris tabel */
.table tbody tr:hover {
    background-color: #FFF9C4 !important;
    transform: scale(1.01);
    transition: all 0.2s ease;
}

/* Print Styles */
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
    
    /* Print statistik cards */
    .card-content > div:first-of-type {
        page-break-after: avoid;
    }
    
    table {
        page-break-inside: auto;
        font-size: 11px;
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
    
    /* Tampilkan header di setiap halaman */
    .card-content h3 {
        page-break-after: avoid;
    }
}

/* Responsive Table */
@media (max-width: 860px) {
    /* Hide statistics cards on very small screens */
    .card-content > div:first-of-type > div:first-of-type {
        grid-template-columns: repeat(2, 1fr) !important;
    }
    
    .table thead {
        display: none;
    }
    
    .table, .table tbody, .table tr, .table td {
        display: block;
        width: 100%;
    }
    
    .table tr {
        margin-bottom: 15px;
        border: 2px solid #E8D5F2;
        border-radius: 8px;
        padding: 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .table td {
        text-align: right;
        padding-left: 50%;
        position: relative;
        border: none;
        padding: 10px;
        min-height: 40px;
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
    
    /* Adjust NIM and Status for mobile */
    .table td[data-label="NIM"],
    .table td[data-label="Status"] {
        text-align: center;
        padding-left: 10px;
    }
    
    .table td[data-label="NIM"]:before,
    .table td[data-label="Status"]:before {
        width: 100%;
        text-align: center;
        position: relative;
        left: 0;
        display: block;
        margin-bottom: 5px;
    }
}

/* Animasi untuk statistik cards */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card-content > div:first-of-type > div > div {
    animation: fadeInUp 0.5s ease-out;
}

.card-content > div:first-of-type > div > div:nth-child(1) { animation-delay: 0.1s; }
.card-content > div:first-of-type > div > div:nth-child(2) { animation-delay: 0.2s; }
.card-content > div:first-of-type > div > div:nth-child(3) { animation-delay: 0.3s; }
.card-content > div:first-of-type > div > div:nth-child(4) { animation-delay: 0.4s; }
</style>

<?php include "views/layout/footer.php"; ?>