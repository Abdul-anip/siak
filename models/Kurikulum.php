<?php

class Kurikulum {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT k.*, p.prodiNama 
            FROM kurikulum k
            LEFT JOIN program_studi p ON k.kurProdiId = p.prodiId
            ORDER BY k.kurId ASC
        ");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM kurikulum WHERE kurId = $id
        ")->fetch_assoc();
    }

    function store($data){
        $isAktif = isset($data['kurIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            INSERT INTO kurikulum (kurProdiId, kurTahun, kurNama, kurIsAktif)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("issi",
            $data['kurProdiId'],
            $data['kurTahun'],
            $data['kurNama'],
            $isAktif
        );

        return $stmt->execute();
    }

    function update($id, $data){
        $isAktif = isset($data['kurIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            UPDATE kurikulum 
            SET kurProdiId=?, kurTahun=?, kurNama=?, kurIsAktif=?
            WHERE kurId=?
        ");

        $stmt->bind_param("issii",
            $data['kurProdiId'],
            $data['kurTahun'],
            $data['kurNama'],
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){
        return $this->db->query("DELETE FROM kurikulum WHERE kurId = $id");
    }
}
?>
