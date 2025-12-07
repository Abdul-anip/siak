<?php
/**
 * Model: DaftarDosenKelas
 * Menangani data dosen per kelas beserta matakuliah yang diampu
 */

class DaftarDosenKelas {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }



    /**
     * Ambil info detail kelas berdasarkan ID
     */
    function getKelasInfo($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                k.klsId,
                k.klsNama,
                
                -- Tahun Akademik
                t.thakdId,
                t.thakdTahun,
                t.thakdSemester,
                CONCAT(t.thakdTahun, '/', (t.thakdTahun + 1), ' - ', 
                    CASE t.thakdSemester 
                        WHEN '1' THEN 'Ganjil' 
                        WHEN '2' THEN 'Genap' 
                    END
                ) AS tahunAkademikLabel,
                
                -- Program Studi
                p.prodiId,
                p.prodiNama,
                p.prodiJenjang
                
            FROM kelas k
            
            LEFT JOIN tahun_akademik t 
                ON k.klsThakdId = t.thakdId
                
            LEFT JOIN program_studi p 
                ON k.klsProdiId = p.prodiId
                
            WHERE k.klsId = '$klsId'
        ";

        $result = $this->db->query($query);
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Ambil daftar kelas berdasarkan Tahun Akademik dan Prodi
     */
    function getKelasByTahunProdi($thakdId, $prodiId) {
        $thakdId = $this->db->real_escape_string($thakdId);
        $prodiId = $this->db->real_escape_string($prodiId);

        $query = "
            SELECT 
                klsId,
                klsNama
            FROM kelas
            WHERE klsThakdId = '$thakdId'
            AND klsProdiId = '$prodiId'
            ORDER BY klsNama ASC
        ";

        return $this->db->query($query);
    }

    /**
     * Hitung jumlah dosen unik di kelas
     */
    function getTotalDosen($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                COUNT(DISTINCT klsdsnDsnNidn) AS totalDosen
            FROM kelas_dosen
            WHERE klsdsnKlsId = '$klsId'
            AND klsdsnIsAktif = 1
        ";

        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalDosen'];
        }
        return 0;
    }

    /**
     * Hitung total matakuliah yang diajar
     */
    function getTotalMatakuliah($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                COUNT(DISTINCT klsdsnMkId) AS totalMK
            FROM kelas_dosen
            WHERE klsdsnKlsId = '$klsId'
            AND klsdsnIsAktif = 1
        ";

        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalMK'];
        }
        return 0;
    }

    function getByKelas($klsId){
        $klsId = $this->db->real_escape_string($klsId);
        
        $sql = "
            SELECT 
                d.dsnNidn, 
                d.dsnNama, 
                d.dsnGelarDepan, 
                d.dsnGelarBelakang,
                mk.mkNama,
                mk.mkKode,
                mk.mkSks,
                kdsn.klsdsnIsAktif,
                CASE 
                    WHEN kdsn.klsdsnIsAktif = 1 THEN 'Aktif'
                    ELSE 'Non-Aktif'
                END AS Status
            FROM kelas_dosen kdsn
            JOIN dosen d ON kdsn.klsdsnDsnNidn = d.dsnNidn
            JOIN matakuliah mk ON kdsn.klsdsnMkId = mk.mkId
            WHERE kdsn.klsdsnKlsId = '$klsId' 
            AND kdsn.klsdsnIsAktif = 1
            ORDER BY mk.mkNama, d.dsnNama
        ";
        
        return $this->db->query($sql);
    }
}
?>