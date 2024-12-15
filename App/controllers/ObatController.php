<?php
// File: app/controllers/ObatController.php

class ObatController extends Controller {
    private $obatModel;
    private $jenisObatModel;
    private $kategoriObatModel;
    private $satuanModel;

    public function __construct() {
        // Mulai session dan cek autentikasi
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Memuat model-model yang diperlukan
        $this->obatModel = $this->model('Obat');
        $this->jenisObatModel = $this->model('JenisObat');
        $this->kategoriObatModel = $this->model('KategoriObat');
        $this->satuanModel = $this->model('Satuan');

        // Cek otorisasi (admin dan apoteker)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan daftar semua obat
    public function index() {
        $data['obat'] = $this->obatModel->getAllObat();
        $this->view('obat/index', $data);
    }

    // Menampilkan form untuk membuat obat baru
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $this->obatModel->createObat($_POST);
            header('Location: ' . BASE_URL . '/obat');
            exit();
        } else {
            // Ambil data referensi untuk form
            $data['jenis_obat'] = $this->jenisObatModel->getAllJenisObat();
            $data['kategori_obat'] = $this->kategoriObatModel->getAllKategoriObat();
            $data['satuan'] = $this->satuanModel->getAllSatuan();
            $this->view('obat/create', $data);
        }
    }

    // Menampilkan form untuk mengedit obat
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $this->obatModel->updateObat($id, $_POST);
            header('Location: ' . BASE_URL . '/obat');
            exit();
        } else {
            // Ambil data obat yang akan diedit
            $data['obat'] = $this->obatModel->getObatById($id);
            $data['jenis_obat'] = $this->jenisObatModel->getAllJenisObat();
            $data['kategori_obat'] = $this->kategoriObatModel->getAllKategoriObat();
            $data['satuan'] = $this->satuanModel->getAllSatuan();
            $this->view('obat/edit', $data);
        }
    }

    // Menghapus obat
    public function delete($id) {
        $this->obatModel->deleteObat($id);
        header('Location: ' . BASE_URL . '/obat');
        exit();
    }
}
?>
