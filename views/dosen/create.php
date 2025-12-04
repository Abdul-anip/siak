<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar">
    <h2>Tambah Dosen</h2>
</div>

<div class="card-content">

<?php if (isset($error)): ?>
<div class="message-box error"> 
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=dosen&aksi=save">

    <label>NIDN <span style="color:red">*</span></label>
    <input class="input" name="dsnNidn" required
        value="<?= isset($old['dsnNidn']) ? htmlspecialchars($old['dsnNidn']) : '' ?>"
        placeholder="Contoh: 0006058102">
    <small>Nomor Induk Dosen Nasional (10 digit)</small>

    <label>Gelar Depan</label>
    <input class="input" name="dsnGelarDepan"
        value="<?= isset($old['dsnGelarDepan']) ? htmlspecialchars($old['dsnGelarDepan']) : '' ?>"
        placeholder="Contoh: Dr., Ir., Prof.">
    <small>Opsional - Gelar akademik sebelum nama</small>

    <label>Nama Lengkap <span style="color:red">*</span></label>
    <input class="input" name="dsnNama" required
        value="<?= isset($old['dsnNama']) ? htmlspecialchars($old['dsnNama']) : '' ?>"
        placeholder="Contoh: Ahmad Dahlan">

    <label>Gelar Belakang</label>
    <input class="input" name="dsnGelarBelakang"
        value="<?= isset($old['dsnGelarBelakang']) ? htmlspecialchars($old['dsnGelarBelakang']) : '' ?>"
        placeholder="Contoh: S.T., M.T., Ph.D">
    <small>Opsional - Gelar akademik setelah nama</small>

    <label>Jenis Kelamin <span style="color:red">*</span></label>
    <select class="input" name="dsnJenisKelaminKode" required>
        <option value="L" <?= (isset($old['dsnJenisKelaminKode']) && $old['dsnJenisKelaminKode']=='L') ? 'selected' : '' ?>>
            Laki-laki
        </option>
        <option value="P" <?= (isset($old['dsnJenisKelaminKode']) && $old['dsnJenisKelaminKode']=='P') ? 'selected' : '' ?>>
            Perempuan
        </option>
    </select>

    <label>Jurusan <span style="color:red">*</span></label>
    <select name="dsnJurId" class="input" id="jurusan-select" required>
        <option value="0">-- Pilih Jurusan --</option>

        <?php
        $jurusan->data_seek(0); 
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"
                <?= (isset($old['dsnJurId']) && $old['dsnJurId'] == $j['jurId']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($j['jurNama']) ?>
            </option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi <span style="color:red">*</span></label>
    <select name="dsnProdiId" class="input" id="prodi-select" required>
        <option value="0">-- Pilih Prodi --</option>
    </select>

    <label>Kelas (Opsional)</label>
    <select name="klsId" class="input" id="kelas-select">
        <option value="0">-- Pilih Kelas --</option>
    </select>
    <small>Jika dipilih, dosen akan didaftarkan ke semua matakuliah di kelas tersebut</small>

    <div style="display: flex; gap: 10px; margin-top: 20px;">
        <button class="btn" name="save_dosen" type="submit">💾 Simpan</button>
        <a class="btn" style="background:#777" href="index.php?page=dosen">❌ Batal</a>
    </div>

</form>

<!-- INFO BOX -->
<div style="margin-top: 30px; padding: 15px; background: #E3F2FD; border-radius: 8px; border-left: 4px solid #2196F3;">
    <strong>💡 Tips Pengisian:</strong>
    <ul style="margin: 10px 0 0 20px; padding: 0;">
        <li><strong>NIDN</strong>: Nomor unik dosen (10 digit)</li>
        <li><strong>Gelar</strong>: Pisahkan gelar depan (Dr., Prof.) dan belakang (S.T., M.T.)</li>
        <li><strong>Kelas</strong>: Jika dipilih, dosen otomatis mengampu semua matakuliah di kelas</li>
    </ul>
</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('jurusan-select');
        const prodiSelect = document.getElementById('prodi-select');
        const kelasSelect = document.getElementById('kelas-select');
        
        const oldJurusanId = jurusanSelect.value;
        const oldProdiId = '<?= isset($old['dsnProdiId']) ? htmlspecialchars($old['dsnProdiId']) : '' ?>';
        const oldKelasId = '<?= isset($old['klsId']) ? htmlspecialchars($old['klsId']) : '' ?>'; 

        prodiSelect.disabled = true;
        kelasSelect.disabled = true;

        function updateKelasOptions(prodiId, selectedKelasId = '') {
            kelasSelect.innerHTML = '<option value="0">Memuat...</option>';
            kelasSelect.disabled = true;

            if (prodiId === "" || prodiId === "0") {
                kelasSelect.innerHTML = '<option value="0">-- Pilih Kelas --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listKelasByProdi&prodiId=${prodiId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '';
                    
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '0';
                    defaultOpt.textContent = '-- Pilih Kelas (Opsional) --';
                    kelasSelect.appendChild(defaultOpt);

                    if (data.kelas && data.kelas.length > 0) {
                        data.kelas.forEach(kelas => {
                            const option = document.createElement('option');
                            option.value = kelas.id;
                            option.textContent = kelas.nama;
                            if (kelas.id == selectedKelasId) {
                                option.selected = true;
                            }
                            kelasSelect.appendChild(option);
                        });
                        kelasSelect.disabled = false;
                    } else {
                        kelasSelect.innerHTML = '<option value="0">-- Tidak ada Kelas Aktif --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching kelas:', error);
                    kelasSelect.innerHTML = '<option value="0">-- Error memuat data --</option>';
                });
        }
        
        function updateProdiOptions(jurId, selectedProdiId = '') {
            prodiSelect.innerHTML = '<option value="0">Memuat...</option>';
            prodiSelect.disabled = true;
            kelasSelect.innerHTML = '<option value="0">-- Pilih Kelas --</option>';
            kelasSelect.disabled = true;

            if (jurId === "" || jurId === "0") {
                prodiSelect.innerHTML = '<option value="0">-- Pilih Prodi --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listByJurusan&jurId=${jurId}`)
                .then(response => response.json())
                .then(data => {
                    prodiSelect.innerHTML = '';
                    
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '0';
                    defaultOpt.textContent = '-- Pilih Prodi --';
                    prodiSelect.appendChild(defaultOpt);

                    if (data.prodis && data.prodis.length > 0) {
                        data.prodis.forEach(prodi => {
                            const option = document.createElement('option');
                            option.value = prodi.id;
                            option.textContent = prodi.label;
                            if (prodi.id == selectedProdiId) {
                                option.selected = true;
                            }
                            prodiSelect.appendChild(option);
                        });
                        prodiSelect.disabled = false;
                        
                        if (selectedProdiId) {
                            updateKelasOptions(selectedProdiId, oldKelasId);
                        }

                    } else {
                        prodiSelect.innerHTML = '<option value="0">-- Tidak ada Prodi --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching prodi:', error);
                    prodiSelect.innerHTML = '<option value="0">-- Error memuat data --</option>';
                });
        }
        
        jurusanSelect.addEventListener('change', function() {
            updateProdiOptions(this.value); 
        });

        prodiSelect.addEventListener('change', function() {
            updateKelasOptions(this.value);
        });

        if (oldJurusanId && oldJurusanId != '0') {
            updateProdiOptions(oldJurusanId, oldProdiId);
        } else if (jurusanSelect.value != '0') {
            updateProdiOptions(jurusanSelect.value, oldProdiId);
        }
    });
</script>

<?php include "views/layout/footer.php"; ?>