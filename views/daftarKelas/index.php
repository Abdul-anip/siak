<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Daftar Data Kelas</h2>
</div>

<div class="card-content">

    <?php if (isset($error)): ?>
        <div class="message-box error"> 
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="get" action="index.php">
        <input type="hidden" name="page" value="daftarKelas">
        <input type="hidden" name="cari" value="1">

        <div style="background:#f0f7ff;padding:15px;border-radius:8px;margin-bottom:20px;border:1px solid #dbe9fb;">
            <h3 style="margin-top:0;">Pencarian Daftar Data Kelas Berdasarkan :</h3>
            
            <div style="display:flex; gap: 20px;">
                <div style="flex:1;">
                    <label style="margin-top:0;">Thn-Smt Akademik</label>
                    <select name="thakdId" class="input" required>
                        <option value="">-- Pilih Thn-Smt --</option>
                        <?php 
                        /** @var mysqli_result $listTa */
                        while($t = $listTa->fetch_assoc()): ?>
                            <?php 
                                $sem = $t['thakdSemester'] == '1' ? 'Ganjil' : 'Genap';
                                $display = $t['thakdTahun'] . " - " . $sem;
                            ?>
                            <option value="<?= $t['thakdId'] ?>"
                                <?= $t['thakdId'] == ($thakdId ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($display) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div style="flex:1;">
                    <label style="margin-top:0;">Program Studi</label>
                    <select name="prodiId" class="input" required>
                        <option value="">-- Pilih Program Studi --</option>
                        <?php 
                        /** @var mysqli_result $listProdi */
                        while($p = $listProdi->fetch_assoc()): ?>
                            <option value="<?= $p['prodiId'] ?>"
                                <?= $p['prodiId'] == ($prodiId ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($p['prodiNama']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <button class="btn" type="submit" style="width:100%; margin-top:10px; background:#5cb85c;">
                Cari
            </button>
        </div>
    </form>

    <?php if ($rows !== null): ?>

        <?php if ($rows->num_rows > 0): ?>

            <table class="table">
                <tr>
                    <th>No.</th>
                    <th>Nama Kelas</th>
                    <th>Jlh Mahasiswa</th>
                    <th>Jlh Dosen</th>
                    <th>Jlh MK</th>
                    <th>Jlh SKS</th>
                    <th>Jlh Jam</th>
                </tr>

                <?php $no=1; while($r = $rows->fetch_assoc()): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= htmlspecialchars($r['NamaKelas']) ?></td>
                    <td><?= $r['JlhMahasiswa'] ?></td>
                    <td><?= $r['JlhDosen'] ?></td>
                    <td><?= $r['JlhMK'] ?></td>
                    <td><?= $r['JlhSKS'] ?></td>
                    <td><?= $r['JlhJam'] ?></td>
                </tr>
                <?php endwhile; ?>

            </table>
        <?php else: ?>
            <div style="padding:10px;background:#fcf8e3;border:1px solid #faebcc;color:#8a6d3b;border-radius:6px;text-align:center;">
                Tidak ada data kelas ditemukan untuk kriteria tersebut.
            </div>
        <?php endif; ?>

    <?php endif; ?>

</div>

<?php include "views/layout/footer.php"; ?>