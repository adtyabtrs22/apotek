<?php
// File: app/models/Supplier.php

class Supplier extends Model {
    // Mendapatkan semua supplier
    public function getAllSupplier() {
        $query = "SELECT * FROM supplier";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan supplier berdasarkan ID
    public function getSupplierById($id) {
        $id = (int)$id;
        $query = "SELECT * FROM supplier WHERE id_supplier = $id LIMIT 1";
        $result = $this->db->query($query);
    
        return $result ? $result->fetch_assoc() : null;
    }
    

    // Membuat supplier baru
    public function createSupplier($data) {
        $nama_supplier = $this->db->escapeString($data['nama_supplier']);
        $alamat_supplier = $this->db->escapeString($data['alamat_supplier']);
        $kontak_supplier = $this->db->escapeString($data['kontak_supplier']);
        $email_supplier = $this->db->escapeString($data['email_supplier']);

        $query = "INSERT INTO supplier (nama_supplier, alamat_supplier, kontak_supplier, email_supplier) 
                  VALUES ('$nama_supplier', '$alamat_supplier', '$kontak_supplier', '$email_supplier')";
        return $this->db->query($query);
    }

    // Memperbarui data supplier
    public function updateSupplier($id, $data) {
        $id = (int)$id;
        $nama_supplier = $this->db->escapeString($data['nama_supplier']);
        $alamat_supplier = $this->db->escapeString($data['alamat_supplier']);
        $kontak_supplier = $this->db->escapeString($data['kontak_supplier']);
        $email_supplier = $this->db->escapeString($data['email_supplier']);

        $query = "UPDATE supplier SET 
                  nama_supplier = '$nama_supplier', 
                  alamat_supplier = '$alamat_supplier', 
                  kontak_supplier = '$kontak_supplier', 
                  email_supplier = '$email_supplier' 
                  WHERE id_supplier = $id";
        return $this->db->query($query);
    }

    // Menghapus supplier
    public function deleteSupplier($id) {
        $id = (int)$id;
        $query = "DELETE FROM supplier WHERE id_supplier = $id";
        return $this->db->query($query);
    }
}
?>
