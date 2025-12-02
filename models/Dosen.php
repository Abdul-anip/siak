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
                'error'  => "Pastikan semua field sudah diisi."
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
        // INSERT DATA
        // ------------------------
        $stmt = $this->db->prepare("
            INSERT INTO dosen (dsnNidn, dsnJurId, dsnProdiId, dsnNama, dsnJenisKelaminKode)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "siiss",
            $data['dsnNidn'],
            $data['dsnJurId'],
            $data['dsnProdiId'],
            $data['dsnNama'],
            $data['dsnJenisKelaminKode']
        );

        $stmt->execute();

        return ['status' => true];
    }

    function update($nidn, $data){

        // Jika suatu saat kamu butuh update NIDN, tambahkan validasi duplicate di sini.
        // Untuk sekarang tidak perlu karena NIDN dikunci (disabled di form)

        $stmt = $this->db->prepare("
            UPDATE dosen
            SET dsnJurId=?, dsnProdiId=?, dsnNama=?, dsnJenisKelaminKode=?
            WHERE dsnNidn=?
        ");

        $stmt->bind_param(
            "iisss",
            $data['dsnJurId'],
            $data['dsnProdiId'],
            $data['dsnNama'],
            $data['dsnJenisKelaminKode'],
            $nidn
        );

        return $stmt->execute();
    }

    function delete($nidn){
        $nidn = $this->db->real_escape_string($nidn);
        return $this->db->query("DELETE FROM dosen WHERE dsnNidn = '$nidn'");
    }
}
?>
