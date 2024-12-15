<?php

class SatuanController extends Controller
{
    private $satuanModel;

    public function __construct()
    {
        // Load model Satuan
        $this->satuanModel = $this->model('Satuan');
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

    // Menampilkan daftar satuan
    public function index()
    {
        $data['satuan'] = $this->satuanModel->getAllSatuan();
        $this->view('satuan/index', $data);
    }

    // Form untuk menambah satuan baru
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ambil data dari form
            $data = [
                'satuan' => trim($_POST['satuan']),
            ];

            // Validasi data
            if (empty($data['satuan'])) {
                $data['error'] = 'Nama satuan tidak boleh kosong.';
                $this->view('satuan/create', $data);
                return;
            }

            // Simpan ke database
            if ($this->satuanModel->createSatuan($data)) {
                header('Location: ' . BASE_URL . '/satuan');
            } else {
                $data['error'] = 'Gagal menambahkan satuan.';
                $this->view('satuan/create', $data);
            }
        } else {
            $this->view('satuan/create');
        }
    }

    // Form untuk mengedit satuan
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = ['satuan' => trim($_POST['satuan'])];
            if (empty($data['satuan'])) {
                $data['error'] = 'Nama Satuan tidak boleh kosong.';
                $this->view('satuan/edit', $data);
            } else {
                $this->model('Satuan')->updateSatuan($id, $data);
                header('Location: ' . BASE_URL . '/satuan');
                exit();
            }
        } else {
            $data['satuan'] = $this->model('Satuan')->getSatuanById($id);
            if (!$data['satuan']) {
                die('Data tidak ditemukan!');
            }
            $this->view('satuan/edit', $data);
        }
    }
    

    // Menghapus satuan
    public function delete($id) {
        $satuanModel = $this->model('Satuan');
    
        // Cek apakah data dengan ID yang diberikan ada
        if ($satuanModel->getSatuanById($id)) {
            // Hapus data
            if ($satuanModel->deleteSatuan($id)) {
                header('Location: ' . BASE_URL . '/satuan');
                exit();
            } else {
                die('Gagal menghapus data.');
            }
        } else {
            die('Data tidak ditemukan.');
        }
    }
    
}
