<?php
// File: app/controllers/Kategori_obatController.php

class Kategori_obatController extends Controller {
    private $kategoriObatModel;

    public function __construct() {
        // Memuat model KategoriObat
        $this->kategoriObatModel = $this->model('KategoriObat');

        // Memulai sesi dan memeriksa autentikasi
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Cek otorisasi (hanya admin yang dapat mengakses)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan daftar kategori obat
    public function index() {
        $kategoriObatModel = $this->model('KategoriObat');
        $data['kategori_obat'] = $kategoriObatModel->getAllKategoriObat(); // Mengambil data dari model
        $this->view('kategori_obat/index', $data); // Mengirim data ke view
    }
    

    // Menampilkan halaman untuk menambahkan kategori obat
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Memproses data form
            $data = [
                'kategori' => $_POST['kategori']
            ];

            if ($this->kategoriObatModel->createKategoriObat($data)) {
                header('Location: ' . BASE_URL . '/kategori_obat');
            } else {
                echo "Terjadi kesalahan saat menambahkan kategori.";
            }
        } else {
            // Menampilkan halaman form
            $this->view('kategori_obat/create');
        }
    }

    // Menampilkan halaman untuk mengedit kategori obat
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Tangkap data yang di-submit
            $data = [
                'id_kategori' => $id,
                'kategori' => $_POST['kategori'],
            ];
    
            // Panggil model untuk update data
            if ($this->kategoriObatModel->updateKategoriObat($data)) {
                header('Location: ' . BASE_URL . '/kategori_obat');
                exit();
            } else {
                die('Terjadi kesalahan saat menyimpan data.');
            }
        } else {
            // Tampilkan form edit
            $kategori = $this->kategoriObatModel->getKategoriObatById($id);
            if (!$kategori) {
                die('Data tidak ditemukan!');
            }
            $data['kategori_obat'] = (array)$kategori;
            $this->view('kategori_obat/edit', $data);
        }
    }
    
    

    // Menghapus kategori obat
    public function delete($id) {
        if ($this->kategoriObatModel->deleteKategoriObat($id)) {
            header('Location: ' . BASE_URL . '/kategori_obat');
        } else {
            echo "Terjadi kesalahan saat menghapus kategori.";
        }
    }
}
?>
