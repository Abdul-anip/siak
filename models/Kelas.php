<?php

class Kelas {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    /**
     * Ambil semua data kelas dengan join ke tabel terkait
     */
    function all(){
        return $this->db->query("
            SELECT 
                k.*,
                p.prodiNama,
                t.thakdTahun,
                t.thakdSemester,
                CONCAT(t.thakdTahun, ' - ', 
                    CASE t.thakdSemester 
                        WHEN '1' THEN 'Ganjil' 
                        WHEN '2' THEN 'Genap' 
                    END
                ) AS tahunAkademikLabel
            FROM kelas k
            LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
            LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
            ORDER BY k.klsThakdId DESC, k.klsNama ASC
        ");
    }

    /**
     * Ambil satu data kelas berdasarkan ID
     */
    function get($id){
        $id = $this->db->real_escape_string($id);
        return $this->db->query("
            SELECT * FROM kelas WHERE klsId = '$id'
        ")->fetch_assoc();
    }

    /**
     * Simpan data kelas baru dengan validasi
     */
    function store($data){
        // VALIDASI AWAL
        if (empty($data['klsThakdId']) || empty($data['klsProdiId']) || empty($data['klsNama'])) {
            return [
                'status' => false,
                'error' => "Semua field wajib diisi!"
            ];
        }

        // VALIDASI: Tahun Akademik & Prodi tidak boleh 0
        if ($data['klsThakdId'] == 0 || $data['klsProdiId'] == 0) {
            return [
                'status' => false,
                'error' => "Tahun Akademik dan Program Studi wajib dipilih."
            ];
        }

        $klsThakdId = $this->db->real_escape_string($data['klsThakdId']);
        $klsProdiId = $this->db->real_escape_string($data['klsProdiId']);
        $klsNama = $this->db->real_escape_string($data['klsNama']);

        // VALIDASI DUPLIKASI: Kombinasi Tahun Akademik + Prodi + Nama Kelas harus unik
        $cek = $this->db->query("
            SELECT klsId FROM kelas 
            WHERE klsThakdId = '$klsThakdId' 
            AND klsProdiId = '$klsProdiId' 
            AND klsNama = '$klsNama'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Kelas <b>$klsNama</b> sudah ada untuk Prodi dan Tahun Akademik ini."
            ];
        }

        // INSERT DATA
        $stmt = $this->db->prepare("
            INSERT INTO kelas (klsThakdId, klsProdiId, klsNama)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param(
            "iis",
            $data['klsThakdId'],
            $data['klsProdiId'],
            $data['klsNama']
        );

        $stmt->execute();
        return ['status' => true];
    }

    /**
     * Update data kelas
     */
    function update($id, $data){
        $stmt = $this->db->prepare("
            UPDATE kelas
            SET klsThakdId=?, klsProdiId=?, klsNama=?
            WHERE klsId=?
        ");

        $stmt->bind_param(
            "iisi",
            $data['klsThakdId'],
            $data['klsProdiId'],
            $data['klsNama'],
            $id
        );

        return $stmt->execute();
    }

    /**
     * Hapus data kelas
     */
    function delete($id){
        $id = $this->db->real_escape_string($id);
        return $this->db->query("DELETE FROM kelas WHERE klsId = '$id'");
    }

    /**
     * Hitung jumlah mahasiswa dalam kelas
     */
    function countMahasiswa($klsId){
        $klsId = $this->db->real_escape_string($klsId);
        $result = $this->db->query("
            SELECT COUNT(*) as total 
            FROM kelas_mahasiswa 
            WHERE klsmhsKlsId = '$klsId' AND klsmhsIsAktif = 1
        ");
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    /**
     * Mencari daftar kelas dan menghitung agregasi (Mhs, Dosen, MK, SKS, Jam)
     */
    function findKelas($thakdId, $prodiId){
        // Escape input
        $thakdId = $this->db->real_escape_string($thakdId);
        $prodiId = $this->db->real_escape_string($prodiId);

        $sql = "
            SELECT 
                k.klsId,
                k.klsNama AS NamaKelas,
                
                -- Hitung Jumlah Mahasiswa
                (SELECT COUNT(klsmhsId) FROM kelas_mahasiswa WHERE klsmhsKlsId = k.klsId AND klsmhsIsAktif = 1) AS JlhMahasiswa,
                
                -- Hitung Jumlah Dosen (Distinct NIDN)
                (
                    SELECT COUNT(DISTINCT klsdsnDsnNidn) 
                    FROM kelas_dosen 
                    WHERE klsdsnKlsId = k.klsId AND klsdsnIsAktif = 1
                ) AS JlhDosen,
                
                -- Hitung Jumlah Mata Kuliah
                (SELECT COUNT(klsmkId) FROM kelas_matakuliah WHERE klsmkKlsId = k.klsId) AS JlhMK,
                
                -- Hitung Total SKS
                (
                    SELECT SUM(m.mkSks) 
                    FROM kelas_matakuliah km 
                    JOIN matakuliah m ON km.klsmkMkId = m.mkId
                    WHERE km.klsmkKlsId = k.klsId
                ) AS JlhSKS,
                
                -- Hitung Total Jam (diasumsikan sama dengan Jlh SKS)
                (
                    SELECT SUM(m.mkSks) 
                    FROM kelas_matakuliah km 
                    JOIN matakuliah m ON km.klsmkMkId = m.mkId
                    WHERE km.klsmkKlsId = k.klsId
                ) AS JlhJam
                
            FROM kelas k
            WHERE 1=1
        ";

        if (!empty($thakdId)) {
            $sql .= " AND k.klsThakdId = '$thakdId'";
        }
        if (!empty($prodiId)) {
            $sql .= " AND k.klsProdiId = '$prodiId'";
        }
        
        $sql .= " ORDER BY k.klsNama ASC";

        return $this->db->query($sql);
    }

    
}
?>