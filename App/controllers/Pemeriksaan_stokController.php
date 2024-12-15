<?php
class Pemeriksaan_stokController extends Controller {

    private $pemeriksaanStokModel;

    public function __construct() {
        $this->pemeriksaanStokModel = $this->model('PemeriksaanStok');
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

    // Menampilkan semua data pemeriksaan stok
    public function index() {
        $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getAllPemeriksaanStok();
        $this->view('pemeriksaan_stok/index', $data);
    }

    // Menampilkan form untuk menambahkan data pemeriksaan stok
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'tanggal_pemeriksaan' => $_POST['tanggal_pemeriksaan'],
                'id_user' => $_POST['id_user'],
                'keterangan' => $_POST['keterangan']
            ];
    
            // Validasi
            if (empty($data['tanggal_pemeriksaan']) || empty($data['id_user'])) {
                $data['error'] = "Semua field wajib diisi.";
                $data['pengguna'] = $this->pemeriksaanStokModel->getAllPengguna();
                $this->view('pemeriksaan_stok/create', $data);
                return;
            }
    
            // Simpan data ke database
            if ($this->pemeriksaanStokModel->createPemeriksaanStok($data)) {
                header('Location: ' . BASE_URL . '/pemeriksaan_stok');
                exit();
            } else {
                $data['error'] = "Gagal menambahkan pemeriksaan stok.";
                $data['pengguna'] = $this->pemeriksaanStokModel->getAllPengguna();
                $this->view('pemeriksaan_stok/create', $data);
            }
        } else {
            // Ambil data pengguna untuk dropdown
            $data = [
                'pengguna' => $this->pemeriksaanStokModel->getAllPengguna()
            ];
            $this->view('pemeriksaan_stok/create', $data);
        }
    }
    

    // Menampilkan form untuk mengedit data pemeriksaan stok
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id_pemeriksaan' => $id,
                'tanggal_pemeriksaan' => $_POST['tanggal_pemeriksaan'],
                'id_user' => $_POST['id_user'],
                'keterangan' => $_POST['keterangan']
            ];
    
            // Validasi
            if (empty($data['tanggal_pemeriksaan']) || empty($data['id_user'])) {
                $data['error'] = "Semua field wajib diisi.";
                $data['pengguna'] = $this->pemeriksaanStokModel->getAllPengguna();
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getPemeriksaanStokById($id);
                $this->view('pemeriksaan_stok/edit', $data);
                return;
            }
    
            // Update data
            if ($this->pemeriksaanStokModel->updatePemeriksaanStok($id, $data)) { // Perbaiki dengan menambahkan $id sebagai parameter
                header('Location: ' . BASE_URL . '/pemeriksaan_stok');
                exit();
            } else {
                $data['error'] = "Gagal mengupdate pemeriksaan stok.";
                $data['pengguna'] = $this->pemeriksaanStokModel->getAllPengguna();
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getPemeriksaanStokById($id);
                $this->view('pemeriksaan_stok/edit', $data);
            }
        } else {
            // Ambil data untuk form
            $data = [
                'pemeriksaan_stok' => $this->pemeriksaanStokModel->getPemeriksaanStokById($id),
                'pengguna' => $this->pemeriksaanStokModel->getAllPengguna()
            ];
            $this->view('pemeriksaan_stok/edit', $data);
        }
    }
    
    

    // Menghapus data pemeriksaan stok
    public function delete($id) {
        $this->pemeriksaanStokModel->deletePemeriksaanStok($id);
        header('Location: ' . BASE_URL . '/pemeriksaan_stok');
        exit();
    }
}
