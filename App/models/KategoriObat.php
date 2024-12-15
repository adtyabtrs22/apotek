<?php
// File: app/models/KategoriObat.php

class KategoriObat extends Model {
    // Mendapatkan semua kategori obat
    public function getAllKategoriObat() {
        $query = "SELECT id_kategori, kategori FROM kategori_obat"; // Sesuaikan nama tabel dan kolom
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC); // Mengembalikan array
        }
        return []; // Mengembalikan array kosong jika tidak ada data
    }
    

    // Mendapatkan kategori obat berdasarkan ID
    public function getKategoriObatById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM kategori_obat WHERE id_kategori = $id";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }
    

    // Membuat kategori obat baru
    public function createKategoriObat($data) {
        $kategori = $this->db->escapeString($data['kategori']);

        $query = "INSERT INTO kategori_obat (kategori) VALUES ('$kategori')";
        return $this->db->query($query);
    }

    // Memperbarui data kategori obat
    public function updateKategoriObat($data) {
        $id_kategori = (int)$data['id_kategori'];
        $kategori = $this->db->escapeString($data['kategori']);
    
        $query = "UPDATE kategori_obat SET kategori = '$kategori' WHERE id_kategori = $id_kategori";
        return $this->db->query($query);
    }
    

    // Menghapus kategori obat
    public function deleteKategoriObat($id) {
        $id = (int)$id;
        $query = "DELETE FROM kategori_obat WHERE id_kategori = $id";
        return $this->db->query($query);
    }
}
?>
