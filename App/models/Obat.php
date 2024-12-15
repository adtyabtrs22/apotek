<?php
// File: app/models/Obat.php

class Obat extends Model {
    // Mendapatkan semua obat dengan detail
    public function getAllObat() {
        $query = "SELECT obat.*, jenis_obat.jenis_obat, kategori_obat.kategori, satuan.satuan 
                  FROM obat 
                  LEFT JOIN jenis_obat ON obat.id_jenis_obat = jenis_obat.id_jenis_obat 
                  LEFT JOIN kategori_obat ON obat.id_kategori = kategori_obat.id_kategori 
                  LEFT JOIN satuan ON obat.id_satuan = satuan.id_satuan";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan obat berdasarkan ID
    public function getObatById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM obat WHERE id_obat = $id";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    // Membuat obat baru
    public function createObat($data) {
        $nama_obat = $this->db->escapeString($data['nama_obat']);
        $id_jenis_obat = (int)$data['id_jenis_obat'];
        $id_kategori = (int)$data['id_kategori'];
        $id_satuan = (int)$data['id_satuan'];
        $tanggal_kedaluwarsa = $this->db->escapeString($data['tanggal_kedaluwarsa']);
        $stok = (int)$data['stok'];
        $stok_minimal = (int)$data['stok_minimal'];

        $query = "INSERT INTO obat (nama_obat, id_jenis_obat, id_kategori, id_satuan, 
                  tanggal_kedaluwarsa, stok, stok_minimal) 
                  VALUES ('$nama_obat', $id_jenis_obat, $id_kategori, $id_satuan, 
                  '$tanggal_kedaluwarsa', $stok, $stok_minimal)";
        return $this->db->query($query);
    }

    // Memperbarui data obat
    public function updateObat($id, $data) {
        $id = (int)$id;
        $nama_obat = $this->db->escapeString($data['nama_obat']);
        $id_jenis_obat = (int)$data['id_jenis_obat'];
        $id_kategori = (int)$data['id_kategori'];
        $id_satuan = (int)$data['id_satuan'];
        $tanggal_kedaluwarsa = $this->db->escapeString($data['tanggal_kedaluwarsa']);
        $stok = (int)$data['stok'];
        $stok_minimal = (int)$data['stok_minimal'];

        $query = "UPDATE obat SET 
                  nama_obat = '$nama_obat', 
                  id_jenis_obat = $id_jenis_obat, 
                  id_kategori = $id_kategori, 
                  id_satuan = $id_satuan, 
                  tanggal_kedaluwarsa = '$tanggal_kedaluwarsa', 
                  stok = $stok, 
                  stok_minimal = $stok_minimal 
                  WHERE id_obat = $id";
        return $this->db->query($query);
    }

    // Menghapus obat
    public function deleteObat($id) {
        $id = (int)$id;
        $query = "DELETE FROM obat WHERE id_obat = $id";
        return $this->db->query($query);
    }

    // Mendapatkan obat dengan stok rendah
    public function getObatStokRendah() {
        $query = "SELECT * FROM obat WHERE stok < stok_minimal";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan obat yang mendekati kedaluwarsa
    public function getObatKedaluwarsa($days = 30) {
        $today = date('Y-m-d');
        $futureDate = date('Y-m-d', strtotime("+$days days"));
        $query = "SELECT * FROM obat WHERE tanggal_kedaluwarsa BETWEEN '$today' AND '$futureDate'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan obat yang sudah kedaluwarsa
    public function getObatSudahKedaluwarsa() {
        $today = date('Y-m-d');
        $query = "SELECT * FROM obat WHERE tanggal_kedaluwarsa < '$today'";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
