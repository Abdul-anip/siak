<?php

class Matkul {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function all(){
        return $this->db->query("
            SELECT m.*, k.kurNama 
            FROM matakuliah m 
            LEFT JOIN kurikulum k ON m.mkKurId = k.kurId
            ORDER BY m.mkId DESC
        ");
    }

    function get($id){
        return $this->db->query("
            SELECT * FROM matakuliah WHERE mkId = $id
        ")->fetch_assoc();
    }

    function store($data)
    {
        // VALIDASI AWAL (cek apakah isset)
        if (!isset($data['mkKurId']) || !isset($data['mkKode']) || !isset($data['mkNama'])) {
            return [
                'status' => false,
                'error' => "Form tidak lengkap! Pastikan semua field terisi."
            ];
        }

        $mkKurId = $data['mkKurId'];
        $mkKode  = $data['mkKode'];
        $mkNama  = $data['mkNama'];

        // VALIDASI DUPLIKASI
        $cek = $this->db->query("
            SELECT mkId FROM matakuliah 
            WHERE mkKurId='$mkKurId' AND mkKode='$mkKode'
        ");

        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Kode matkul <b>$mkKode</b> sudah ada pada kurikulum tersebut."
            ];
        }

        // INSERT DATA - PERBAIKAN: Tambahkan mkNamaAsing
        $isAktif = isset($data['mkIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            INSERT INTO matakuliah 
            (mkKurId, mkKode, mkNama, mkNamaAsing, mkSemester, mkSks, mkIsAktif)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $mkNamaAsing = $data['mkNamaAsing'] ?? '';

        $stmt->bind_param(
            "issssii",
            $mkKurId,
            $mkKode,
            $mkNama,
            $mkNamaAsing,
            $data['mkSemester'],
            $data['mkSks'],
            $isAktif
        );

        $result = $stmt->execute();
        $stmt->close();

        if (!$result) {
            return [
                'status' => false,
                'error' => "Gagal menyimpan data: " . $this->db->error
            ];
        }

        return ['status' => true];
    }

    function update($id, $data){

        $isAktif = isset($data['mkIsAktif']) ? 1 : 0;

        $stmt = $this->db->prepare("
            UPDATE matakuliah
            SET mkKurId=?, mkKode=?, mkNama=?, mkSemester=?, mkSks=?, mkIsAktif=?
            WHERE mkId=?
        ");

        // 7 parameter total:
        // i s s i i i i
        $stmt->bind_param(
            "issiiii",
            $data['mkKurId'],
            $data['mkKode'],
            $data['mkNama'],
            $data['mkSemester'],
            $data['mkSks'],
            $isAktif,
            $id
        );

        return $stmt->execute();
    }

    function delete($id){

        $id = $this->db->real_escape_string($id);

        $cek = $this->db->query("
            SELECT COUNT(*) as total FROM matakuliah 
            WHERE mkId = '$id'
        ")->fetch_assoc();

        if ($cek['total'] > 0) {
            throw new Exception("Matakuliah dengan Id $id tidak dapat dihapus karena masih digunakan difitur lain.");
        }

        return $this->db->query("DELETE FROM matakuliah WHERE mkId = $id");
    }

    function search($keyword){
        $keyword = $this->db->real_escape_string($keyword);
        return $this->db->query("
            SELECT m.*, k.kurNama 
            FROM matakuliah m 
            LEFT JOIN kurikulum k ON m.mkKurId = k.kurId
            WHERE m.mkKode LIKE '%$keyword%' OR m.mkNama LIKE '%$keyword%'
            ORDER BY m.mkId DESC
        ");
    }

}
?>