<?php

class TahunAkademik {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT * FROM tahun_akademik 
            ORDER BY thakdId DESC
        ");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM tahun_akademik WHERE thakdId = $id
        ")->fetch_assoc();
    }

    function store($data){
        // VALIDASI AWAL
        if (!isset($data['thakdId']) || !isset($data['thakdTahun']) || !isset($data['thakdSemester'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $thakdId = $data['thakdId'];
        $thakdTahun = $data['thakdTahun'];
        $thakdSemester = $data['thakdSemester'];

        // VALIDASI DUPLIKASI ID
        $cek = $this->db->query("
            SELECT thakdId FROM tahun_akademik 
            WHERE thakdId='$thakdId'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "ID Tahun Akademik <b>$thakdId</b> sudah terdaftar."
            ];
        }

        // VALIDASI DUPLIKASI Tahun + Semester
        $cek2 = $this->db->query("
            SELECT thakdId FROM tahun_akademik 
            WHERE thakdTahun='$thakdTahun' AND thakdSemester='$thakdSemester'
        ");

        if ($cek2->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Tahun Akademik <b>$thakdTahun Semester $thakdSemester</b> sudah terdaftar."
            ];
        }

        // INSERT DATA
        $isAktif = isset($data['thakdIsAktif']) ? 1 : 0;
        $tglMulai = $data['thakdTglMulai'] ?: NULL;
        $tglSelesai = $data['thakdTglSelesai'] ?: NULL;

        $stmt = $this->db->prepare("
            INSERT INTO tahun_akademik (thakdId, thakdTahun, thakdSemester, thakdTglMulai, thakdTglSelesai, thakdIsAktif)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param("issssi",
            $data['thakdId'],
            $data['thakdTahun'],
            $data['thakdSemester'],
            $tglMulai,
            $tglSelesai,
            $isAktif
        );

        $stmt->execute();

        return ['status' => true];
    }

    function update($id, $data){
        $isAktif = isset($data['thakdIsAktif']) ? 1 : 0;
        $tglMulai = $data['thakdTglMulai'] ?: NULL;
        $tglSelesai = $data['thakdTglSelesai'] ?: NULL;

        $stmt = $this->db->prepare("
            UPDATE tahun_akademik 
            SET thakdTahun=?, thakdSemester=?, thakdTglMulai=?, thakdTglSelesai=?, thakdIsAktif=?
            WHERE thakdId=?
        ");

        $stmt->bind_param("ssssii",
            $data['thakdTahun'],
            $data['thakdSemester'],
            $tglMulai,
            $tglSelesai,
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){
        return $this->db->query("DELETE FROM tahun_akademik WHERE thakdId = $id");
    }
}
?>