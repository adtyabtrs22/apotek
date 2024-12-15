<?php
class PemeriksaanStok extends Model {
    // Mendapatkan semua pemeriksaan stok
    public function getAllPemeriksaanStok() {
        $query = "SELECT * FROM pemeriksaan_stok";
        $result = $this->db->query($query);
        // Pastikan result tidak null sebelum fetch_all
        $query = "SELECT ps.*, p.nama_user , p.jabatan
        FROM pemeriksaan_stok ps
        JOIN pengguna p ON ps.id_user = p.id_user";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];

    }

    public function getAllPengguna() {
        $query = "SELECT id_user, nama_user FROM pengguna";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    

    // Mendapatkan pemeriksaan stok berdasarkan ID
    public function getPemeriksaanStokById($id_pemeriksaan) {
        $id_pemeriksaan = (int)$id_pemeriksaan;
        $query = "SELECT * FROM pemeriksaan_stok WHERE id_pemeriksaan = $id_pemeriksaan";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Membuat pemeriksaan stok baru
    // $data expected keys: ['tanggal_pemeriksaan', 'id_user', 'keterangan']
    public function createPemeriksaanStok($data) {
        $tanggal_pemeriksaan = $this->db->escapeString($data['tanggal_pemeriksaan']);
        $id_user = (int)$data['id_user'];
        $keterangan = $this->db->escapeString($data['keterangan']);

        $query = "INSERT INTO pemeriksaan_stok (tanggal_pemeriksaan, id_user, keterangan) 
                  VALUES ('$tanggal_pemeriksaan', $id_user, '$keterangan')";

        return $this->db->query($query);
    }

    // Memperbarui pemeriksaan stok
    // $data expected keys: ['tanggal_pemeriksaan', 'id_user', 'keterangan']
    public function updatePemeriksaanStok($id_pemeriksaan, $data) {
        $id_pemeriksaan = (int)$id_pemeriksaan;
        $tanggal_pemeriksaan = $this->db->escapeString($data['tanggal_pemeriksaan']);
        $id_user = (int)$data['id_user'];
        $keterangan = $this->db->escapeString($data['keterangan']);
    
        $query = "UPDATE pemeriksaan_stok
                  SET tanggal_pemeriksaan = '$tanggal_pemeriksaan',
                      id_user = $id_user,
                      keterangan = '$keterangan'
                  WHERE id_pemeriksaan = $id_pemeriksaan";
        return $this->db->query($query);
    }
    
    

    // Menghapus pemeriksaan stok
    public function deletePemeriksaanStok($id_pemeriksaan) {
        $id_pemeriksaan = (int)$id_pemeriksaan;
        $query = "DELETE FROM pemeriksaan_stok WHERE id_pemeriksaan = $id_pemeriksaan";
        return $this->db->query($query);
    }
}
