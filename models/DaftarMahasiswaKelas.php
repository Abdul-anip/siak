<?php

class DaftarMahasiswaKelas {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    function getByKelas($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                km.klsmhsId,
                
                -- Data Mahasiswa
                m.mhsNim AS NIM,
                m.mhsNama AS NamaMahasiswa,
                m.mhsTempatLahir,
                m.mhsTglLahir,
                
                -- Gabung Tempat/Tanggal Lahir
                CONCAT(
                    COALESCE(m.mhsTempatLahir, '-'), 
                    ', ', 
                    COALESCE(DATE_FORMAT(m.mhsTglLahir, '%d-%m-%Y'), '-')
                ) AS TempatTglLahir,
                
                -- Jenis Kelamin
                m.mhsJenisKelamin AS JK,
                
                -- Program Studi
                p.prodiNama AS Prodi,
                p.prodiKode AS ProdiKode,
                
                -- Status Mahasiswa (dari tabel mahasiswa)
                CASE m.mhsStsAkademik
                    WHEN 'A' THEN 'Aktif'
                    WHEN 'L' THEN 'Lulus'
                    WHEN 'C' THEN 'Cuti'
                    WHEN 'D' THEN 'DO'
                    WHEN 'K' THEN 'Keluar'
                    WHEN 'M' THEN 'Meninggal'
                    ELSE 'Aktif'
                END AS Status,
                
                -- Status di Kelas
                km.klsmhsIsAktif AS StatusKelas,
                
                -- Semester Aktif
                m.mhsSmsAktif AS Semester
                
            FROM kelas_mahasiswa km
            
            INNER JOIN mahasiswa m 
                ON km.klsmhsMhsNim = m.mhsNim
                
            LEFT JOIN program_studi p 
                ON m.mhsProdiId = p.prodiId
                
            WHERE km.klsmhsKlsId = '$klsId'
            AND km.klsmhsIsAktif = 1
            
            ORDER BY m.mhsNama ASC
        ";

        return $this->db->query($query);
    }

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
                p.prodiKode,
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

    function getTotalMahasiswa($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                COUNT(*) AS total
            FROM kelas_mahasiswa
            WHERE klsmhsKlsId = '$klsId'
            AND klsmhsIsAktif = 1
        ";

        $result = $this->db->query($query);
        if ($result && $row = $result->fetch_assoc()) {
            return $row['total'];
        }
        return 0;
    }

    function getStatsByGender($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                m.mhsJenisKelamin AS gender,
                COUNT(*) AS total
            FROM kelas_mahasiswa km
            INNER JOIN mahasiswa m ON km.klsmhsMhsNim = m.mhsNim
            WHERE km.klsmhsKlsId = '$klsId'
            AND km.klsmhsIsAktif = 1
            GROUP BY m.mhsJenisKelamin
        ";

        $result = $this->db->query($query);
        $stats = ['L' => 0, 'P' => 0];
        
        while($row = $result->fetch_assoc()) {
            $stats[$row['gender']] = $row['total'];
        }
        
        return $stats;
    }

    function getStatsByStatus($klsId) {
        $klsId = $this->db->real_escape_string($klsId);

        $query = "
            SELECT 
                m.mhsStsAkademik AS status,
                COUNT(*) AS total
            FROM kelas_mahasiswa km
            INNER JOIN mahasiswa m ON km.klsmhsMhsNim = m.mhsNim
            WHERE km.klsmhsKlsId = '$klsId'
            AND km.klsmhsIsAktif = 1
            GROUP BY m.mhsStsAkademik
        ";

        $result = $this->db->query($query);
        $stats = [];
        
        while($row = $result->fetch_assoc()) {
            $statusLabel = [
                'A' => 'Aktif',
                'L' => 'Lulus',
                'C' => 'Cuti',
                'D' => 'DO',
                'K' => 'Keluar',
                'M' => 'Meninggal'
            ];
            
            $label = $statusLabel[$row['status']] ?? $row['status'];
            $stats[$label] = $row['total'];
        }
        
        return $stats;
    }
}
?>