<?php

class Dosen {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT d.*, j.jurNama, p.prodiNama 
            FROM dosen d
            LEFT JOIN jurusan j ON d.dsnJurId = j.jurId
            LEFT JOIN program_studi p ON d.dsnProdiId = p.prodiId
            ORDER BY d.dsnNama
        ");
    }

    function get($nidn){
        $nidn = $this->db->real_escape_string($nidn);
        return $this->db->query("SELECT * FROM dosen WHERE dsnNidn = '$nidn'")->fetch_assoc();
    }

    function store($data){

        // ------------------------
        // VALIDASI DASAR
        // ------------------------
        if (empty($data['dsnNidn']) || empty($data['dsnNama']) ||
            empty($data['dsnJenisKelaminKode']) ||
            empty($data['dsnJurId']) || empty($data['dsnProdiId'])) {

            return [
                'status' => false,
                'error'  => "Pastikan semua field wajib sudah diisi."
            ];
        }

        // VALIDASI jurusan & prodi tidak boleh 0
        if ($data['dsnJurId'] == 0 || $data['dsnProdiId'] == 0) {
            return [
                'status' => false,
                'error'  => "Jurusan dan Program Studi wajib dipilih."
            ];
        }

        // Escape input
        $dsnNidn = $this->db->real_escape_string($data['dsnNidn']);

        // ------------------------
        // VALIDASI DUPLIKASI NIDN
        // ------------------------
        $cek = $this->db->query("
            SELECT dsnNidn FROM dosen 
            WHERE dsnNidn = '$dsnNidn'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error'  => "NIDN <b>$dsnNidn</b> sudah terdaftar."
            ];
        }

        // ------------------------
        // INSERT DATA DENGAN GELAR
        // ------------------------
        $stmt = $this->db->prepare("
            INSERT INTO dosen (
                dsnNidn, 
                dsnJurId, 
                dsnProdiId, 
                dsnNama, 
                dsnJenisKelaminKode,
                dsnGelarDepan,
                dsnGelarBelakang
            )
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        // Ambil gelar atau kosongkan jika tidak diisi
        $gelarDepan = $data['dsnGelarDepan'] ?? '';
        $gelarBelakang = $data['dsnGelarBelakang'] ?? '';

        $stmt->bind_param(
            "siissss",
            $data['dsnNidn'],
            $data['dsnJurId'],
            $data['dsnProdiId'],
            $data['dsnNama'],
            $data['dsnJenisKelaminKode'],
            $gelarDepan,
            $gelarBelakang
        );

        $stmt->execute();
        $stmt->close();

        return ['status' => true];
    }

    function update($nidn, $data){

        $stmt = $this->db->prepare("
            UPDATE dosen
            SET dsnJurId=?, 
                dsnProdiId=?, 
                dsnNama=?, 
                dsnJenisKelaminKode=?,
                dsnGelarDepan=?,
                dsnGelarBelakang=?
            WHERE dsnNidn=?
        ");

        $gelarDepan = $data['dsnGelarDepan'] ?? '';
        $gelarBelakang = $data['dsnGelarBelakang'] ?? '';

        $stmt->bind_param(
            "iisssss",
            $data['dsnJurId'],
            $data['dsnProdiId'],
            $data['dsnNama'],
            $data['dsnJenisKelaminKode'],
            $gelarDepan,
            $gelarBelakang,
            $nidn
        );

        return $stmt->execute();
    }

    function delete($nidn){
        $nidn = $this->db->real_escape_string($nidn);
        return $this->db->query("DELETE FROM dosen WHERE dsnNidn = '$nidn'");
    }

    function countDosen($klsId){
        $klsId = $this->db->real_escape_string($klsId);
        
        $sql = "
            SELECT COUNT(DISTINCT klsdsnDsnNidn) AS total 
            FROM kelas_dosen 
            WHERE klsdsnKlsId = '$klsId' AND klsdsnIsAktif = 1
        ";
        
        $result = $this->db->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0; 
    }

    function getDosenByKelas($klsId){
        $klsId = $this->db->real_escape_string($klsId);
        
        $sql = "
            SELECT 
                d.dsnNidn, 
                d.dsnNama, 
                d.dsnGelarDepan, 
                d.dsnGelarBelakang,
                mk.mkNama,
                mk.mkKode,
                mk.mkSks
            FROM kelas_dosen kdsn
            JOIN dosen d ON kdsn.klsdsnDsnNidn = d.dsnNidn
            JOIN matakuliah mk ON kdsn.klsdsnMkId = mk.mkId
            WHERE kdsn.klsdsnKlsId = '$klsId' 
              AND kdsn.klsdsnIsAktif = 1
            ORDER BY mk.mkNama, d.dsnNama
        ";
        
        return $this->db->query($sql);
    }
}

?>