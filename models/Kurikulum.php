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
        // VALIDASI AWAL
        if (!isset($data['kurProdiId']) || !isset($data['kurTahun']) || !isset($data['kurNama'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $kurProdiId = $data['kurProdiId'];
        $kurTahun = $data['kurTahun'];
        $kurNama = $data['kurNama'];

        // VALIDASI DUPLIKASI (Prodi + Tahun harus unik)
        $cek = $this->db->query("
            SELECT kurId FROM kurikulum 
            WHERE kurProdiId='$kurProdiId' AND kurTahun='$kurTahun'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Kurikulum tahun <b>$kurTahun</b> sudah ada untuk prodi ini."
            ];
        }

        // INSERT DATA
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

        $stmt->execute();

        return ['status' => true];
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