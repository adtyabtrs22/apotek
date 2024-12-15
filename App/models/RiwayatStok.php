<?php
class RiwayatStok extends Model {
    // Mendapatkan semua riwayat stok (termasuk nama obat)
    public function getAllRiwayatStok() {
        $query = "SELECT rs.*, o.nama_obat 
                  FROM riwayat_stok rs
                  JOIN obat o ON rs.id_obat = o.id_obat
                  ORDER BY rs.tanggal DESC"; // Urutkan berdasarkan tanggal
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan semua obat untuk dropdown
    public function getAllObat() {
        $query = "SELECT id_obat, nama_obat FROM obat ORDER BY nama_obat ASC";
        $result = $this->db->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Mendapatkan riwayat stok berdasarkan ID
    public function getRiwayatStokById($id) {
        $id = (int)$id;
        $query = "SELECT rs.*, o.nama_obat 
                  FROM riwayat_stok rs
                  JOIN obat o ON rs.id_obat = o.id_obat
                  WHERE rs.id_riwayat = $id";
        $result = $this->db->query($query);
        return $result->fetch_assoc();
    }

    // Membuat riwayat stok baru
    public function createRiwayatStok($data) {
        $id_obat = (int)$data['id_obat'];
        $tanggal = $this->db->escapeString($data['tanggal']);
        $jenis_transaksi = $this->db->escapeString($data['jenis_transaksi']);
        $jumlah = (int)$data['jumlah'];
        $stok_akhir = (int)$data['stok_akhir'];
    
        $query = "INSERT INTO riwayat_stok (id_obat, tanggal, jenis_transaksi, jumlah, stok_akhir)
                  VALUES ($id_obat, '$tanggal', '$jenis_transaksi', $jumlah, $stok_akhir)";
        return $this->db->query($query);
    }
    
    
    

    // Memperbarui riwayat stok
    public function updateRiwayatStok($id, $data) {
        $id = (int)$id;
        $id_obat = (int)$data['id_obat'];
        $tanggal = $this->db->escapeString($data['tanggal']);
        $jenis_transaksi = $this->db->escapeString($data['jenis_transaksi']);
        $jumlah = (int)$data['jumlah'];
        $stok_akhir = (int)$data['stok_akhir'];

        $query = "UPDATE riwayat_stok 
                  SET id_obat = $id_obat, 
                      tanggal = '$tanggal',
                      jenis_transaksi = '$jenis_transaksi',
                      jumlah = $jumlah,
                      stok_akhir = $stok_akhir
                  WHERE id_riwayat = $id";
        return $this->db->query($query);
    }

    // Menghapus riwayat stok berdasarkan ID
    public function deleteRiwayatStok($id) {
        $id = (int)$id;
        $query = "DELETE FROM riwayat_stok WHERE id_riwayat = $id";
        return $this->db->query($query);
    }
}
?>
