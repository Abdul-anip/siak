<?php

class User {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    /* ============================================================
       LOGIN VALIDATION
       ============================================================ */
    function login($username, $password){
        $stmt = $this->db->prepare("
            SELECT appusrID, appusrNama, appusrGrupUser 
            FROM user
            WHERE appusrNama = ? 
            AND appusrPassword = ?
            AND appusrIsEnabled = 1
        ");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $res = $stmt->get_result();
        return $res->fetch_assoc();
    }

    /* ============================================================
       REGISTER NEW USER
       ============================================================ */
    function register($username, $password){
        // Validasi username sudah ada
        $cek = $this->db->query("
            SELECT appusrID FROM user 
            WHERE appusrNama = '{$this->db->real_escape_string($username)}'
        ");
        
        if ($cek->num_rows > 0) {
            return false;
        }
        
        $stmt = $this->db->prepare("
            INSERT INTO user (appusrNama, appusrPassword, appusrGrupUser, appusrIsEnabled)
            VALUES (?, ?, 'user', 1)
        ");
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }

    /* ============================================================
       GET ALL USERS (with search)
       ============================================================ */
    function all($search = ""){
        $where = "1=1";
        
        if($search != ""){
            $s = $this->db->real_escape_string($search);
            $where .= " AND (appusrNama LIKE '%$s%' OR appusrGrupUser LIKE '%$s%' OR appusrNoHp LIKE '%$s%')";
        }
        
        return $this->db->query("
            SELECT * FROM user 
            WHERE $where
            ORDER BY appusrID DESC
        ");
    }

    /* ============================================================
       GET USER BY ID
       ============================================================ */
    function get($id){
        $id = $this->db->real_escape_string($id);
        $result = $this->db->query("
            SELECT * FROM user WHERE appusrID = '$id'
        ");
        return $result ? $result->fetch_assoc() : null;
    }

    /* ============================================================
       CREATE NEW USER
       ============================================================ */
    function store($data){
        // Validasi input
        if (empty($data['appusrNama']) || empty($data['appusrPassword'])) {
            return [
                'status' => false,
                'error' => "Username dan password wajib diisi!"
            ];
        }
        
        // Validasi panjang password
        if (strlen($data['appusrPassword']) < 4) {
            return [
                'status' => false,
                'error' => "Password minimal 4 karakter!"
            ];
        }
        
        // Validasi username unik
        $username = $this->db->real_escape_string($data['appusrNama']);
        $cek = $this->db->query("
            SELECT appusrID FROM user 
            WHERE appusrNama = '$username'
        ");
        
        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Username <b>$username</b> sudah terdaftar!"
            ];
        }
        
        // Insert user
        $grupUser = $data['appusrGrupUser'] ?? 'user';
        $noHp = $data['appusrNoHp'] ?? null;
        $isEnabled = isset($data['appusrIsEnabled']) ? 1 : 0;
        
        $stmt = $this->db->prepare("
            INSERT INTO user (appusrNama, appusrPassword, appusrGrupUser, appusrNoHp, appusrIsEnabled)
            VALUES (?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "ssssi",
            $data['appusrNama'],
            $data['appusrPassword'],
            $grupUser,
            $noHp,
            $isEnabled
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if (!$result) {
            return [
                'status' => false,
                'error' => "Gagal menyimpan user: " . $this->db->error
            ];
        }
        
        return ['status' => true];
    }

    /* ============================================================
       UPDATE USER
       ============================================================ */
    function update($id, $data){
        // Validasi username unik (kecuali untuk user yang sedang diedit)
        $username = $this->db->real_escape_string($data['appusrNama']);
        $id = $this->db->real_escape_string($id);
        
        $cek = $this->db->query("
            SELECT appusrID FROM user 
            WHERE appusrNama = '$username' 
            AND appusrID != '$id'
        ");
        
        if ($cek->num_rows > 0) {
            return [
                'status' => false,
                'error' => "Username <b>$username</b> sudah digunakan user lain!"
            ];
        }
        
        $grupUser = $data['appusrGrupUser'] ?? 'user';
        $noHp = $data['appusrNoHp'] ?? null;
        $isEnabled = isset($data['appusrIsEnabled']) ? 1 : 0;
        
        $stmt = $this->db->prepare("
            UPDATE user
            SET appusrNama = ?, 
                appusrGrupUser = ?, 
                appusrNoHp = ?, 
                appusrIsEnabled = ?
            WHERE appusrID = ?
        ");
        
        $stmt->bind_param(
            "sssii",
            $data['appusrNama'],
            $grupUser,
            $noHp,
            $isEnabled,
            $id
        );
        
        $result = $stmt->execute();
        $stmt->close();
        
        if (!$result) {
            return [
                'status' => false,
                'error' => "Gagal update user: " . $this->db->error
            ];
        }
        
        return ['status' => true];
    }

    /* ============================================================
       DELETE USER
       ============================================================ */
    function delete($id){
        $id = $this->db->real_escape_string($id);
        return $this->db->query("DELETE FROM user WHERE appusrID = '$id'");
    }

    /* ============================================================
       VERIFY OLD PASSWORD
       ============================================================ */
    function verifyPassword($userid, $oldPassword){
        $userid = $this->db->real_escape_string($userid);
        $oldPassword = $this->db->real_escape_string($oldPassword);
        
        $result = $this->db->query("
            SELECT appusrID FROM user 
            WHERE appusrID = '$userid' 
            AND appusrPassword = '$oldPassword'
        ");
        
        if ($result->num_rows == 0) {
            return [
                'status' => false,
                'error' => "Password lama tidak sesuai!"
            ];
        }
        
        return ['status' => true];
    }

    /* ============================================================
       UPDATE PASSWORD
       ============================================================ */
    function updatePassword($userid, $newPassword){
        $userid = $this->db->real_escape_string($userid);
        $newPassword = $this->db->real_escape_string($newPassword);
        
        $result = $this->db->query("
            UPDATE user 
            SET appusrPassword = '$newPassword'
            WHERE appusrID = '$userid'
        ");
        
        if (!$result) {
            return [
                'status' => false,
                'error' => "Gagal mengubah password: " . $this->db->error
            ];
        }
        
        return ['status' => true];
    }

    /* ============================================================
       TOGGLE USER STATUS (AKTIF/NON-AKTIF)
       ============================================================ */
    function toggleStatus($userid){
        $userid = $this->db->real_escape_string($userid);
        
        $result = $this->db->query("
            UPDATE user 
            SET appusrIsEnabled = IF(appusrIsEnabled = 1, 0, 1)
            WHERE appusrID = '$userid'
        ");
        
        if (!$result) {
            return [
                'status' => false,
                'error' => "Gagal mengubah status: " . $this->db->error
            ];
        }
        
        return ['status' => true];
    }
}
?>