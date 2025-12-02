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

        return $stmt->execute();
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
        return $this->db->query("DELETE FROM jurusan WHERE jurId = $id");
    }
}
?>
