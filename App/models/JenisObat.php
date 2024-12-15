<?php
// File: app/models/JenisObat.php

class JenisObat extends Model {
    // Mendapatkan semua jenis obat
    public function getAllJenisObat() {
        $query = "SELECT * FROM jenis_obat";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan jenis obat berdasarkan ID
    public function getJenisObatById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM jenis_obat WHERE id_jenis_obat = $id";
        $result = $this->db->query($query);
        return $result->fetch_assoc(); // Pastikan menggunakan fetch_assoc()
    }
    

    // Membuat jenis obat baru
    public function createJenisObat($data) {
        $jenis_obat = $this->db->escapeString($data['jenis_obat']);

        $query = "INSERT INTO jenis_obat (jenis_obat) VALUES ('$jenis_obat')";
        return $this->db->query($query);
    }

    // Memperbarui data jenis obat
    public function updateJenisObat($id, $data) {
        $id = (int)$id;
        $jenis_obat = $this->db->escapeString($data['jenis_obat']);

        $query = "UPDATE jenis_obat SET jenis_obat = '$jenis_obat' WHERE id_jenis_obat = $id";
        return $this->db->query($query);
    }

    // Menghapus jenis obat
    public function deleteJenisObat($id) {
        $id = (int)$id;
        $query = "DELETE FROM jenis_obat WHERE id_jenis_obat = $id";
        return $this->db->query($query);
    }
}
?>
