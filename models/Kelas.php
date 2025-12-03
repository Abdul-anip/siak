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
}
?>