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
        return $this->db->query("
            SELECT * FROM dosen WHERE dsnNidn = '$nidn'
        ")->fetch_assoc();
    }

    function store($data){
        $stmt = $this->db->prepare("
            INSERT INTO dosen (dsnNidn, dsnJurId, dsnProdiId, dsnNama, dsnJenisKelaminKode)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("siiss",
            $data['dsnNidn'],
            $data['dsnJurId'],
            $data['dsnProdiId'],
            $data['dsnNama'],
            $data['dsnJenisKelaminKode']
        );

        return $stmt->execute();
    }

    function update($nidn, $data){
        $stmt = $this->db->prepare("
            UPDATE dosen
            SET dsnJurId=?, dsnProdiId=?, dsnNama=?, dsnJenisKelaminKode=?
            WHERE dsnNidn=?
        ");

        $stmt->bind_param("iisss",
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
