<?php
// File: app/models/Satuan.php

class Satuan extends Model {
    // Mendapatkan semua satuan
    public function getAllSatuan() {
        $query = "SELECT * FROM satuan";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan satuan berdasarkan ID
    public function getSatuanById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM satuan WHERE id_satuan = $id LIMIT 1";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }
    

    // Membuat satuan baru
    public function createSatuan($data) {
        $satuan = $this->db->escapeString($data['satuan']);

        $query = "INSERT INTO satuan (satuan) VALUES ('$satuan')";
        return $this->db->query($query);
    }

    // Memperbarui data satuan
    public function updateSatuan($id, $data) {
        $id = (int)$id;
        $satuan = $this->db->escapeString($data['satuan']);

        $query = "UPDATE satuan SET satuan = '$satuan' WHERE id_satuan = $id";
        return $this->db->query($query);
    }

    // Menghapus satuan
    public function deleteSatuan($id) {
        $id = (int)$id; // Sanitasi input
        $query = "DELETE FROM satuan WHERE id_satuan = $id";
        return $this->db->query($query);
    }
    
}
?>
