<?php

class Prodi {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT p.*, j.jurNama 
            FROM program_studi p
            LEFT JOIN jurusan j ON p.prodiJurId = j.jurId
            ORDER BY p.prodiId ASC
        ");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM program_studi WHERE prodiId = $id
        ")->fetch_assoc();
    }

    function store($data){
        // VALIDASI AWAL
        if (!isset($data['prodiKode']) || !isset($data['prodiNama']) || !isset($data['prodiJurId'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $prodiKode = $data['prodiKode'];
        $prodiJurId = $data['prodiJurId'];

        // VALIDASI DUPLIKASI KODE
        $cek = $this->db->query("
            SELECT prodiId FROM program_studi 
            WHERE prodiKode='$prodiKode'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Kode prodi <b>$prodiKode</b> sudah terdaftar."
            ];
        }

        // INSERT DATA
        $isAktif = isset($data['prodiIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            INSERT INTO program_studi 
            (prodiJurId, prodiKode, prodiNama, prodiNamaAsing, prodiJenjang, prodiEmail, prodiWebsite, prodiIsAktif)
            VALUES (?, ?, ?, '', ?, ?, ?, ?)
        ");

        $stmt->bind_param("isssssi",
            $data['prodiJurId'],
            $data['prodiKode'],
            $data['prodiNama'],
            $data['prodiJenjang'],
            $data['prodiEmail'],
            $data['prodiWebsite'],
            $isAktif
        );

        $stmt->execute();

        return ['status' => true];
    }

    function update($id, $data){
        $isAktif = isset($data['prodiIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            UPDATE program_studi 
            SET prodiJurId=?, prodiKode=?, prodiNama=?, prodiJenjang=?, prodiEmail=?, prodiWebsite=?, prodiIsAktif=?
            WHERE prodiId=?
        ");

        $stmt->bind_param("isssssii",
            $data['prodiJurId'],
            $data['prodiKode'],
            $data['prodiNama'],
            $data['prodiJenjang'],
            $data['prodiEmail'],
            $data['prodiWebsite'],
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){
        return $this->db->query("DELETE FROM program_studi WHERE prodiId = $id");
    }
}
?>