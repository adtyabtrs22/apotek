<?php
// File: core/Database.php

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;

    private $conn;
    private $error;

    public function __construct() {
        // Ambil konfigurasi dari config.php
        $this->host = DB_HOST;
        $this->user = DB_USER;
        $this->pass = DB_PASS;
        $this->dbname = DB_NAME;

        // Koneksi ke database
        $this->connectDB();
    }

    private function connectDB() {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            $this->error = "Koneksi gagal: " . $this->conn->connect_error;
            die($this->error);
        }
    }

    // Metode untuk menjalankan query dan mengembalikan hasil
    public function query($query) {
        $result = $this->conn->query($query);
        if (!$result) {
            die("Query Error: " . $this->conn->error);
        }
        return $result;
    }

    // Metode untuk meng-escape string input
    public function escapeString($string) {
        return $this->conn->real_escape_string($string);
    }

    // Metode untuk mendapatkan ID terakhir yang di-insert
    public function getLastId() {
        return $this->conn->insert_id;
    }
}
?>
