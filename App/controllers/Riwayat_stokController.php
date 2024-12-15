<?php

class Riwayat_stokController extends Controller {
    private $riwayatStokModel;

    public function __construct() {
        $this->riwayatStokModel = $this->model('RiwayatStok');
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan semua riwayat stok
    public function index() {
        $data['riwayat_stok'] = $this->riwayatStokModel->getAllRiwayatStok();
        $this->view('riwayat_stok/index', $data);
    }

    // Menampilkan form create
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id_obat' => $_POST['id_obat'],
                'tanggal' => $_POST['tanggal'],
                'jenis_transaksi' => $_POST['jenis_transaksi'],
                'jumlah' => $_POST['jumlah'],
                'stok_akhir' => $_POST['stok_akhir']
            ];
    
            // Validasi
            if (empty($data['id_obat']) || empty($data['tanggal']) || empty($data['jenis_transaksi']) || empty($data['jumlah']) || empty($data['stok_akhir'])) {
                $data['error'] = "Semua field harus diisi.";
                $data['nama_obat'] = $this->riwayatStokModel->getAllObat();
                $data['jenis_transaksi'] = ['Pengadaan', 'Distribusi', 'Pemeriksaan'];
                $this->view('riwayat_stok/create', $data);
                return;
            }
    
            // Simpan data
            if ($this->riwayatStokModel->createRiwayatStok($data)) {
                header('Location: ' . BASE_URL . '/riwayat_stok');
                exit();
            }
        } else {
            $data = [
                'nama_obat' => $this->riwayatStokModel->getAllObat(),
                'jenis_transaksi' => ['Pengadaan', 'Distribusi', 'Pemeriksaan']
            ];
            $this->view('riwayat_stok/create', $data);
        }
    }
    
    
    // Menampilkan form edit
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $data = [
                'id_obat' => $_POST['id_obat'],
                'tanggal' => $_POST['tanggal'],
                'jenis_transaksi' => $_POST['jenis_transaksi'],
                'jumlah' => $_POST['jumlah'],
                'stok_akhir' => $_POST['stok_akhir']
            ];

            // Validasi data
            if (empty($data['id_obat']) || empty($data['tanggal']) || empty($data['jenis_transaksi']) || empty($data['jumlah']) || empty($data['stok_akhir'])) {
                $data['error'] = "Semua field harus diisi.";
                $data['riwayat_stok'] = $this->riwayatStokModel->getRiwayatStokById($id);
                $data['nama_obat'] = $this->riwayatStokModel->getAllObat();
                $data['jenis_transaksi'] = ['Pengadaan', 'Distribusi', 'Pemeriksaan'];
                $this->view('riwayat_stok/edit', $data);
                return;
            }

            // Update data ke database
            if ($this->riwayatStokModel->updateRiwayatStok($id, $data)) {
                header('Location: ' . BASE_URL . '/riwayat_stok');
                exit();
            } else {
                $data['error'] = "Gagal mengupdate riwayat stok.";
                $data['riwayat_stok'] = $this->riwayatStokModel->getRiwayatStokById($id);
                $data['nama_obat'] = $this->riwayatStokModel->getAllObat();
                $data['jenis_transaksi'] = ['Pengadaan', 'Distribusi', 'Pemeriksaan'];
                $this->view('riwayat_stok/edit', $data);
            }
        } else {
            // Ambil data berdasarkan ID untuk edit
            $data['riwayat_stok'] = $this->riwayatStokModel->getRiwayatStokById($id);
            $data['nama_obat'] = $this->riwayatStokModel->getAllObat();
            $data['jenis_transaksi'] = ['Pengadaan', 'Distribusi', 'Pemeriksaan'];
            $this->view('riwayat_stok/edit', $data);
        }
    }

    // Menghapus riwayat stok
    public function delete($id) {
        if ($this->riwayatStokModel->deleteRiwayatStok($id)) {
            header('Location: ' . BASE_URL . '/riwayat_stok');
            exit();
        } else {
            $data['error'] = "Gagal menghapus riwayat stok.";
            $this->view('riwayat_stok/index', $data);
        }
    }
}
