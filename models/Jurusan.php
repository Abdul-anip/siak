<?php

class Jurusan {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("SELECT * FROM jurusan ORDER BY jurId ASC");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM jurusan WHERE jurId = $id
        ")->fetch_assoc();
    }

    function store($data){
        // VALIDASI AWAL
        if (!isset($data['jurKode']) || !isset($data['jurNama'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $jurKode = $data['jurKode'];
        $jurNama = $data['jurNama'];

        // VALIDASI DUPLIKASI KODE
        $cek = $this->db->query("
            SELECT jurId FROM jurusan 
            WHERE jurKode='$jurKode'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Kode jurusan <b>$jurKode</b> sudah terdaftar."
            ];
        }

        // INSERT DATA
        $isAktif = isset($data['jurIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            INSERT INTO jurusan (jurKode, jurNama, jurNamaAsing, jurIsAktif)
            VALUES (?, ?, ?, ?)
        ");

        $stmt->bind_param("sssi",
            $data['jurKode'],
            $data['jurNama'],
            $data['jurNamaAsing'],
            $isAktif
        );

        $stmt->execute();

        return ['status' => true];
    }

    function update($id, $data){
        $isAktif = isset($data['jurIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            UPDATE jurusan
            SET jurKode = ?, jurNama = ?, jurNamaAsing = ?, jurIsAktif = ?
            WHERE jurId = ?
        ");

        $stmt->bind_param("sssii",
            $data['jurKode'],
            $data['jurNama'],
            $data['jurNamaAsing'],
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){
        $id = $this->db->real_escape_string($id);

        $cek = $this->db->query("
            SELECT COUNT(*) as total FROM jurusan 
            WHERE jurId = '$id'
        ")->fetch_assoc();

        if ($cek['total'] > 0) {
            throw new Exception("Jurusan dengan Id $id tidak dapat dihapus karena masih digunakan difitur lain.");
        }   

        return $this->db->query("DELETE FROM jurusan WHERE jurId = '$id'");
    }


    function search($keyword) {
        $keyword = $this->db->real_escape_string($keyword);
        $query = "
            SELECT * FROM jurusan 
            WHERE jurKode LIKE '%$keyword%' 
            OR jurNama LIKE '%$keyword%'
            ORDER BY jurId ASC
        ";
        return $this->db->query($query);
    }


}
?>