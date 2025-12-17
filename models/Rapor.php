<?php

class Rapor {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    /**
     * Ambil daftar semua mahasiswa untuk dropdown
     */
    function getAllMahasiswa() {
        return $this->db->query("
            SELECT mhsNim, mhsNama 
            FROM mahasiswa 
            ORDER BY mhsNama ASC
        ");
    }

    /**
     * Ambil data rapor berdasarkan NIM dan Semester
     */
    function getRaporByNimAndSemester($nim, $semester) {
        $nim = $this->db->real_escape_string($nim);
        $semester = (int) $semester;

        // 1. Cari KRS ID untuk mahasiswa dan semester tersebut
        $krsQuery = $this->db->query("
            SELECT krsId 
            FROM krs 
            WHERE krsMhsNim = '$nim' AND krsSemester = $semester
        ");

        if ($krsQuery->num_rows == 0) {
            return null; // Data KRS tidak ditemukan
        }

        $krsData = $krsQuery->fetch_assoc();
        $krsId = $krsData['krsId'];

        // 2. Ambil detail nilai dari krs_khs join matakuliah
        $query = "
            SELECT 
                mk.mkKode, 
                mk.mkNama, 
                mk.mkSks, 
                khs.khsKodeNilai, 
                khs.khsBobotNilai
            FROM krs_khs khs
            JOIN matakuliah mk ON khs.khsMkId = mk.mkId
            WHERE khs.khsKrsId = $krsId
            ORDER BY mk.mkNama ASC
        ";

        return $this->db->query($query);
    }
}
?>
