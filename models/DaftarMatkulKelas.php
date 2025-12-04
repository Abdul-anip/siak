<?php
/**
 * Model: DaftarMatkulKelas
 * Menangani data matakuliah per kelas
 */

class DaftarMatkulKelas {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    /**
     * Ambil daftar matakuliah berdasarkan Kelas tertentu
     * Menampilkan: No, Kode MK, Nama Matakuliah, SKS, Semester, T/P (Teori/Praktek), KMK (Kode Mata Kuliah)
     */
    function getByKelas($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                mk.mkId,
                mk.mkKode,
                mk.mkNama,
                mk.mkSks AS SKS,
                mk.mkSemester AS Semester,
                
                -- Deteksi T/P berdasarkan nama atau field tambahan (contoh sederhana)
                CASE 
                    WHEN mk.mkNama LIKE '%Praktikum%' OR mk.mkNama LIKE '%Lab%' THEN 'P'
                    ELSE 'T'
                END AS T_P,
                
                -- Kolom KMK placeholder (bisa diisi manual atau dari field tambahan)
                '' AS KMK,
                
                -- Info Kurikulum
                kur.kurNama AS NamaKurikulum
                
            FROM kelas_matakuliah kmk
            
            INNER JOIN matakuliah mk 
                ON kmk.klsmkMkId = mk.mkId
                
            LEFT JOIN kurikulum kur 
                ON mk.mkKurId = kur.kurId
                
            WHERE kmk.klsmkKlsId = '$klsId'
            
            ORDER BY mk.mkSemester ASC, mk.mkKode ASC
        ";

        return $this->db->query($query);
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
     * Untuk dropdown "Nama Kelas"
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
     * Hitung total SKS dari matakuliah di kelas
     */
    function getTotalSKS($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                COALESCE(SUM(mk.mkSks), 0) AS totalSKS
            FROM kelas_matakuliah kmk
            LEFT JOIN matakuliah mk ON kmk.klsmkMkId = mk.mkId
            WHERE kmk.klsmkKlsId = '$klsId'
        ";

        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['totalSKS'];
        }
        return 0;
    }
}
?>