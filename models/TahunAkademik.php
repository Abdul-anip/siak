<?php

class TahunAkademik {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT * FROM tahun_akademik 
            ORDER BY taId DESC
        ");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM tahun_akademik WHERE taId = $id
        ")->fetch_assoc();
    }

    function store($data){
        $isAktif = isset($data['taIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            INSERT INTO tahun_akademik (taKode, taSemester, taIsAktif)
            VALUES (?, ?, ?)
        ");

        $stmt->bind_param("ssi",
            $data['taKode'],
            $data['taSemester'],
            $isAktif
        );

        return $stmt->execute();
    }

    function update($id, $data){
        $isAktif = isset($data['taIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            UPDATE tahun_akademik 
            SET taKode=?, taSemester=?, taIsAktif=?
            WHERE taId=?
        ");

        $stmt->bind_param("ssii",
            $data['taKode'],
            $data['taSemester'],
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){
        return $this->db->query("DELETE FROM tahun_akademik WHERE taId = $id");
    }
}
?>
