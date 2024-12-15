<?php
// File: app/models/User.php

class User extends Model {
    // Mendapatkan pengguna berdasarkan username
    public function getUserByUsername($username) {
        $username = $this->db->escapeString($username);
        $query = "SELECT * FROM pengguna WHERE username = '$username'";
        $result = $this->db->query($query);
        return $result->fetch_object();
    }

    // Mendapatkan pengguna berdasarkan ID
    public function getUserById($id_user) {
        $id_user = (int)$id_user;
        $query = "SELECT id_user, nama_user, jabatan, username, email FROM pengguna WHERE id_user = $id_user LIMIT 1";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_assoc(); // Pastikan array berisi semua kolom
        }
        return null;
    }
    

    // Mendapatkan semua pengguna
    public function getAllUsers() {
        $query = "SELECT * FROM pengguna";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Membuat pengguna baru
    public function createUser($data) {
        $nama_user = $this->db->escapeString($data['nama_user']);
        $jabatan = $this->db->escapeString($data['jabatan']);
        $username = $this->db->escapeString($data['username']);
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $email = $this->db->escapeString($data['email']);

        $query = "INSERT INTO pengguna (nama_user, jabatan, username, password, email) 
                  VALUES ('$nama_user', '$jabatan', '$username', '$password', '$email')";
        return $this->db->query($query);
    }

    // Memperbarui data pengguna
    public function updateUser($id, $data) {
        $id = (int)$id;
        $nama_user = $this->db->escapeString($data['nama_user']);
        $jabatan = $this->db->escapeString($data['jabatan']);
        $username = $this->db->escapeString($data['username']);
        $email = $this->db->escapeString($data['email']);

        if (!empty($data['password'])) {
            $password = password_hash($data['password'], PASSWORD_BCRYPT);
            $query = "UPDATE pengguna SET nama_user = '$nama_user', jabatan = '$jabatan', 
                      username = '$username', password = '$password', email = '$email' 
                      WHERE id_user = $id";
        } else {
            $query = "UPDATE pengguna SET nama_user = '$nama_user', jabatan = '$jabatan', 
                      username = '$username', email = '$email' 
                      WHERE id_user = $id";
        }

        return $this->db->query($query);
    }

    // Menghapus pengguna
    public function deleteUser($id) {
        $id = (int)$id;
        $query = "DELETE FROM pengguna WHERE id_user = $id";
        return $this->db->query($query);
    }

    // Mendapatkan pengguna berdasarkan peran
    public function getUsersByRole($roles = []) {
        $roles = array_map([$this->db, 'escapeString'], $roles);
        $roles = "'" . implode("','", $roles) . "'";
        $query = "SELECT * FROM pengguna WHERE jabatan IN ($roles)";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
?>
