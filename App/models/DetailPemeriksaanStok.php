<?php

class DetailPemeriksaanStok extends Model {

    // Mendapatkan semua data detail pemeriksaan stok
    public function getAllDetailPemeriksaanStok() {
        $query = "SELECT 
                    dps.id_detail_pemeriksaan AS id_detail,
                    ps.tanggal_pemeriksaan,
                    o.nama_obat,
                    dps.stok_tercatat,
                    dps.stok_fisik,
                    (dps.stok_fisik - dps.stok_tercatat) AS selisih
                  FROM detail_pemeriksaan_stok dps
                  JOIN pemeriksaan_stok ps ON dps.id_pemeriksaan = ps.id_pemeriksaan
                  JOIN obat o ON dps.id_obat = o.id_obat";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }
    

    // Mendapatkan detail pemeriksaan stok berdasarkan ID
    public function getDetailPemeriksaanStokById($id) {
        $id = (int)$id;
        $query = "SELECT dps.*, ps.tanggal_pemeriksaan, o.nama_obat 
                  FROM detail_pemeriksaan_stok dps
                  JOIN pemeriksaan_stok ps ON dps.id_pemeriksaan = ps.id_pemeriksaan
                  JOIN obat o ON dps.id_obat = o.id_obat
                  WHERE dps.id_detail_pemeriksaan = $id";
        $result = $this->db->query($query);
        if ($result) {
            return $result->fetch_assoc();
        }
        return null;
    }

    // Menambahkan detail pemeriksaan stok baru
    public function createDetailPemeriksaanStok($data) {
        $id_pemeriksaan = (int)$data['id_pemeriksaan'];
        $id_obat = (int)$data['id_obat'];
        $stok_tercatat = (int)$data['stok_tercatat'];
        $stok_fisik = (int)$data['stok_fisik'];
        $selisih = (int)$data['selisih'];


        $query = "INSERT INTO detail_pemeriksaan_stok (id_pemeriksaan, id_obat, stok_tercatat, stok_fisik, selisih)
                  VALUES ($id_pemeriksaan, $id_obat, $stok_tercatat, $stok_fisik, $selisih)";

        return $this->db->query($query);
    }

    // Memperbarui detail pemeriksaan stok berdasarkan ID
    public function updateDetailPemeriksaanStok($id, $data) {
        $id = (int)$id;
        $id_pemeriksaan = (int)$data['id_pemeriksaan'];
        $id_obat = (int)$data['id_obat'];
        $stok_tercatat = (int)$data['stok_tercatat'];
        $stok_fisik = (int)$data['stok_fisik'];
        $selisih = (int)$data['selisih'];

        $query = "UPDATE detail_pemeriksaan_stok 
                  SET id_pemeriksaan = $id_pemeriksaan,
                      id_obat = $id_obat,
                      stok_tercatat = $stok_tercatat,
                      stok_fisik = $stok_fisik,
                      selisih = $selisih
                  WHERE id_detail_pemeriksaan = $id";

        return $this->db->query($query);
    }

    // Menghapus detail pemeriksaan stok berdasarkan ID
    public function deleteDetailPemeriksaanStok($id) {
        $id = (int)$id;
        $query = "DELETE FROM detail_pemeriksaan_stok WHERE id_detail_pemeriksaan = $id";
        return $this->db->query($query);
    }
}
