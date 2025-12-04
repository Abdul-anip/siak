<?php

require "models/Prodi.php";
require "models/Jurusan.php";

$prodi = new Prodi($koneksi);
$jur = new Jurusan($koneksi);

$aksi = $_GET['aksi'] ?? 'index';

// LIST
if ($aksi == "index") {
    $rows = $prodi->all();
    require "views/prodi/index.php";
}

// FORM TAMBAH
else if ($aksi == "tambah") {
    $jurusan = $jur->all();
    require "views/prodi/create.php";
}

// SIMPAN TAMBAH
else if ($aksi == "save" && isset($_POST['save_prodi'])) {
    $result = $prodi->store($_POST);

    // Jika ERROR → tampilkan form create dengan pesan error
    if (!$result['status']) {
        $error = $result['error'];
        $jurusan = $jur->all();
        $old = $_POST;

        require "views/prodi/create.php";
        exit;
    }

    // Jika sukses → redirect
    header("Location: index.php?page=prodi");
    exit;
}

// FORM EDIT
else if ($aksi == "edit" && isset($_GET['id'])) {
    $data = $prodi->get($_GET['id']);
    $jurusan = $jur->all();
    require "views/prodi/edit.php";
}

// SIMPAN UPDATE
else if ($aksi == "update" && isset($_POST['update_prodi'])) {
    $prodi->update($_POST['prodiId'], $_POST);
    header("Location: index.php?page=prodi");
}

// DELETE
else if ($aksi == "delete" && isset($_GET['id'])) {
    $prodi->delete($_GET['id']);
    header("Location: index.php?page=prodi");
}

// --- FETCH PRODI BY JURUSAN (AJAX ENDPOINT) ---
else if ($aksi == "listByJurusan") {
    header('Content-Type: application/json');
    
    $jurId = $_GET['jurId'] ?? 0;
    
    // Query untuk mengambil Prodi berdasarkan Jurusan ID
    $rows = $koneksi->query("
        SELECT prodiId, prodiNama, prodiJenjang
        FROM program_studi 
        WHERE prodiJurId = " . intval($jurId) . " AND prodiIsAktif = 1
        ORDER BY prodiNama
    ");
    
    $prodis = [];
    while($r = $rows->fetch_assoc()) {
        $prodis[] = [
            'id' => $r['prodiId'],
            'nama' => $r['prodiNama'],
            'label' => $r['prodiNama'] . ' (' . $r['prodiJenjang'] . ')'
        ];
    }
    
    echo json_encode(['prodis' => $prodis]);
    exit; // PENTING: Hentikan eksekusi setelah output JSON
}

// --- FETCH KELAS BY PRODI (AJAX ENDPOINT) ---
else if ($aksi == "listKelasByProdi") {
    header('Content-Type: application/json');
    
    $prodiId = $_GET['prodiId'] ?? 0;
    
    // 1. Ambil ID Tahun Akademik yang Aktif
    $taAktif = $koneksi->query("SELECT thakdId FROM tahun_akademik WHERE thakdIsAktif = 1 LIMIT 1")->fetch_assoc();
    $thakdId = $taAktif['thakdId'] ?? 0;

    $kelas = [];

    if ($prodiId > 0 && $thakdId > 0) {
        // 2. Query untuk mengambil Kelas berdasarkan Prodi ID dan Tahun Aktif
        $rows = $koneksi->query("
            SELECT klsId, klsNama 
            FROM kelas 
            WHERE klsProdiId = " . intval($prodiId) . " 
            AND klsThakdId = " . intval($thakdId) . "
            ORDER BY klsNama
        ");
        
        while($r = $rows->fetch_assoc()) {
            $kelas[] = [
                'id' => $r['klsId'],
                'nama' => $r['klsNama'],
                'label' => $r['klsNama']
            ];
        }
    }
    
    echo json_encode(['kelas' => $kelas]);
    exit; // Hentikan eksekusi setelah output JSON
}


?>