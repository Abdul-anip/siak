<?php

class User {

    private $db;

    function __construct($koneksi){
        $this->db = $koneksi;
    }

    // LOGIN VALIDATION
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

    // REGISTER NEW USER
    function register($username, $password){
        $stmt = $this->db->prepare("
            INSERT INTO user (appusrNama, appusrPassword, appusrGrupUser, appusrIsEnabled)
            VALUES (?, ?, 'user', 1)
        ");
        $stmt->bind_param("ss", $username, $password);
        return $stmt->execute();
    }
}
?>
