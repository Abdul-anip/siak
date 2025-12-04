<?php include "views/layout/header.php"; ?>
<?php include "views/layout/sidebar.php"; ?>

<div class="topbar"><h2>Tambah Mahasiswa</h2></div>

<div class="card-content">

<?php if (isset($error)): ?>
<div style="padding:10px;background:#fdd;border:1px solid #f99;margin-bottom:10px;">
    <?= $error ?>
</div>
<?php endif; ?>

<form method="post" action="index.php?page=mahasiswa&aksi=save">

    <label>NIM</label>
    <input class="input" name="mhsNim" 
       value="<?= $old['mhsNim'] ?? '' ?>" required>

    <label>Nama Lengkap</label>
    <input class="input" name="mhsNama" 
       value="<?= $old['mhsNama'] ?? '' ?>" required>

    <label>Tempat Lahir</label>
    <input class="input" name="mhsTempatLahir"
       value="<?= $old['mhsTempatLahir'] ?? '' ?>">

    <label>Tanggal Lahir</label>
    <input class="input" type="date" name="mhsTglLahir"
       value="<?= $old['mhsTglLahir'] ?? '' ?>">

    <label>Jenis Kelamin</label>
    <select class="input" name="mhsJenisKelamin">
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>

    <label>Jurusan</label>
    <select class="input" name="mhsJurId" id="jurusan-select" required>
        <option value="">-- Pilih Jurusan --</option>
        <?php
        /** @var mysqli_result $jurusan */
        $jurusan->data_seek(0); // Reset pointer
        while($j = $jurusan->fetch_assoc()): ?>
            <option value="<?= $j['jurId'] ?>"><?= $j['jurNama'] ?></option>
        <?php endwhile; ?>
    </select>

    <label>Program Studi</label>
    <select class="input" name="mhsProdiId" id="prodi-select" required>
        <option value="">-- Pilih Prodi --</option>
        <?php 
        ?>
    </select>

    <label>Kelas</label>
    <select class="input" name="klsId" id="kelas-select" required>
        <option value="">-- Pilih Kelas --</option>
    </select>
    <div style="display: flex; gap: 10px; margin-top: 10px;">

    <div style="display: flex; gap: 10px; margin-top: 10px;">
    <button class="btn" name="save_mahasiswa">Simpan</button>
    <a class="btn" style="background:#777" href="index.php?page=mahasiswa">Batal</a>
    </div>
</form>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jurusanSelect = document.getElementById('jurusan-select');
        const prodiSelect = document.getElementById('prodi-select');
        const kelasSelect = document.getElementById('kelas-select');
        
        // Data lama untuk mempertahankan nilai setelah error
        const oldJurusanId = jurusanSelect.value;
        const oldProdiId = '<?= $old['mhsProdiId'] ?? '' ?>';
        const oldKelasId = '<?= $old['klsId'] ?? '' ?>'; 
        
        // Awalnya, nonaktifkan Prodi dan Kelas
        prodiSelect.disabled = true;
        kelasSelect.disabled = true;

        // FUNGSI 1: Memuat Opsi Kelas
        function updateKelasOptions(prodiId, selectedKelasId = '') {
            kelasSelect.innerHTML = '<option value="">Memuat...</option>';
            kelasSelect.disabled = true;

            if (prodiId === "" || prodiId === "0") {
                kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listKelasByProdi&prodiId=${prodiId}`)
                .then(response => response.json())
                .then(data => {
                    kelasSelect.innerHTML = '';
                    
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '';
                    defaultOpt.textContent = '-- Pilih Kelas --';
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
                        kelasSelect.innerHTML = '<option value="">-- Tidak ada Kelas Aktif --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching kelas:', error);
                    kelasSelect.innerHTML = '<option value="">-- Error memuat data --</option>';
                });
        }
        
        // FUNGSI 2: Memuat Opsi Prodi (Pemicu Kelas)
        function updateProdiOptions(jurId, selectedProdiId = '') {
            prodiSelect.innerHTML = '<option value="">Memuat...</option>';
            prodiSelect.disabled = true;
            kelasSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            kelasSelect.disabled = true;

            if (jurId === "" || jurId === "0") {
                prodiSelect.innerHTML = '<option value="">-- Pilih Prodi --</option>';
                return;
            }

            fetch(`index.php?page=prodi&aksi=listByJurusan&jurId=${jurId}`)
                .then(response => response.json())
                .then(data => {
                    prodiSelect.innerHTML = '';
                    
                    const defaultOpt = document.createElement('option');
                    defaultOpt.value = '';
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
                        
                        // CHAINING: Jika Prodi dipilih, muat Kelas
                        if (selectedProdiId) {
                            updateKelasOptions(selectedProdiId, oldKelasId);
                        }

                    } else {
                        prodiSelect.innerHTML = '<option value="">-- Tidak ada Prodi --</option>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching prodi:', error);
                    prodiSelect.innerHTML = '<option value="">-- Error memuat data --</option>';
                });
        }
        
        // Event Listener: Jurusan change -> load Prodi
        jurusanSelect.addEventListener('change', function() {
            updateProdiOptions(this.value); 
        });

        // Event Listener: Prodi change -> load Kelas
        prodiSelect.addEventListener('change', function() {
            updateKelasOptions(this.value);
        });

        // Initial Load Logic (for initial view or re-display after error)
        if (oldJurusanId) {
            updateProdiOptions(oldJurusanId, oldProdiId);
        } else {
            updateProdiOptions(jurusanSelect.value, oldProdiId);
        }
    });
</script>

<?php include "views/layout/footer.php"; ?>
