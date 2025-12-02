<?php

class Mahasiswa {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all($search = ""){
        $where = "1=1";

        if($search != ""){
            $s = $this->db->real_escape_string($search);
            $where .= " AND (m.mhsNim LIKE '%$s%' OR m.mhsNama LIKE '%$s%')";
        }

        return $this->db->query("
            SELECT m.*, j.jurNama, p.prodiNama 
            FROM mahasiswa m
            LEFT JOIN jurusan j ON m.mhsJurId = j.jurId
            LEFT JOIN program_studi p ON m.mhsProdiId = p.prodiId
            WHERE $where
            ORDER BY m.mhsNama
        ");
    }

    function get($nim){
        $nim = $this->db->real_escape_string($nim);
        return $this->db->query("
            SELECT * FROM mahasiswa WHERE mhsNim = '$nim'
        ")->fetch_assoc();
    }

    function store($data){
        // VALIDASI AWAL (cek apakah isset)
        if (!isset($data['mhsNim']) || !isset($data['mhsNama']) || !isset($data['mhsJenisKelamin']) || !isset($data['mhsJurId']) || !isset($data['mhsProdiId'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $mhsNim = $data['mhsNim'];
        $mhsNama = $data['mhsNama'];

        // VALIDASI DUPLIKASI NIM
        $cek = $this->db->query("
            SELECT mhsNim FROM mahasiswa 
            WHERE mhsNim='$mhsNim'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "NIM <b>$mhsNim</b> sudah terdaftar."
            ];
        }

        // INSERT DATA
        $stmt = $this->db->prepare("
            INSERT INTO mahasiswa
            (mhsNim, mhsNama, mhsTempatLahir, mhsTglLahir, mhsJenisKelamin, mhsJurId, mhsProdiId, mhsKodeKelas, mhsStsAkademik, mhsSmsAktif)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'A', 0)
        ");

        $stmt->bind_param("sssssiis",
            $data['mhsNim'],
            $data['mhsNama'],
            $data['mhsTempatLahir'],
            $data['mhsTglLahir'],
            $data['mhsJenisKelamin'],
            $data['mhsJurId'],
            $data['mhsProdiId'],
            $data['mhsKodeKelas']
        );

        $stmt->execute();

        return ['status' => true];
    }

    function update($nim, $data){
        $stmt = $this->db->prepare("
            UPDATE mahasiswa
            SET mhsNama=?, mhsTempatLahir=?, mhsTglLahir=?, mhsJenisKelamin=?, 
                mhsJurId=?, mhsProdiId=?, mhsKodeKelas=?, mhsStsAkademik=?, mhsSmsAktif=?
            WHERE mhsNim=?
        ");

        $stmt->bind_param("ssssiiisis",
            $data['mhsNama'],
            $data['mhsTempatLahir'],
            $data['mhsTglLahir'],
            $data['mhsJenisKelamin'],
            $data['mhsJurId'],
            $data['mhsProdiId'],
            $data['mhsKodeKelas'],
            $data['mhsStsAkademik'],
            $data['mhsSmsAktif'],
            $nim
        );

        return $stmt->execute();
    }

    function delete($nim){
        $nim = $this->db->real_escape_string($nim);
        return $this->db->query("DELETE FROM mahasiswa WHERE mhsNim = '$nim'");
    }
}
?>
