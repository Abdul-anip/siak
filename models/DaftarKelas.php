<?php

class DaftarKelas {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    /**
     * Ambil daftar kelas berdasarkan Tahun Akademik dan Prodi
     * dengan agregasi jumlah mahasiswa, dosen, matakuliah, SKS, dan jam
     */
    function getByTahunAkademikAndProdi($thakdId, $prodiId) {
        
        $thakdId = $this->db->real_escape_string($thakdId);
        $prodiId = $this->db->real_escape_string($prodiId);

        $query = "
            SELECT 
                k.klsId,
                k.klsNama AS NamaKelas,
                
                -- Jumlah Mahasiswa
                (SELECT COUNT(*) 
                 FROM kelas_mahasiswa km 
                 WHERE km.klsmhsKlsId = k.klsId 
                 AND km.klsmhsIsAktif = 1
                ) AS JlhMahasiswa,
                
                -- Jumlah Dosen
                (SELECT COUNT(DISTINCT klsdsnDsnNidn) 
                 FROM kelas_dosen kd 
                 WHERE kd.klsdsnKlsId = k.klsId 
                 AND kd.klsdsnIsAktif = 1
                ) AS JlhDosen,
                
                -- Jumlah Mata Kuliah
                (SELECT COUNT(*) 
                 FROM kelas_matakuliah kmk 
                 WHERE kmk.klsmkKlsId = k.klsId
                ) AS JlhMK,
                
                -- Jumlah SKS (total dari semua matakuliah di kelas)
                (SELECT COALESCE(SUM(m.mkSks), 0)
                 FROM kelas_matakuliah kmk
                 LEFT JOIN matakuliah m ON kmk.klsmkMkId = m.mkId
                 WHERE kmk.klsmkKlsId = k.klsId
                ) AS JlhSKS,
                
                -- Jumlah Jam (asumsi: 1 SKS = 50 menit, dibulatkan ke jam)
                (SELECT COALESCE(SUM(m.mkSks), 0)
                 FROM kelas_matakuliah kmk
                 LEFT JOIN matakuliah m ON kmk.klsmkMkId = m.mkId
                 WHERE kmk.klsmkKlsId = k.klsId
                ) AS JlhJam
                
            FROM kelas k
            WHERE k.klsThakdId = '$thakdId'
            AND k.klsProdiId = '$prodiId'
            ORDER BY k.klsNama ASC
        ";

        return $this->db->query($query);
    }
    
    function debugCheckData($thakdId, $prodiId) {
        $thakdId = $this->db->real_escape_string($thakdId);
        $prodiId = $this->db->real_escape_string($prodiId);
        
        return $this->db->query("
            SELECT 
                k.*,
                t.thakdTahun,
                t.thakdSemester,
                p.prodiNama
            FROM kelas k
            LEFT JOIN tahun_akademik t ON k.klsThakdId = t.thakdId
            LEFT JOIN program_studi p ON k.klsProdiId = p.prodiId
            WHERE k.klsThakdId = '$thakdId'
            AND k.klsProdiId = '$prodiId'
        ");
    }
}
?>