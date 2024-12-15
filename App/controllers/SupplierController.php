<?php
// File: app/controllers/SupplierController.php

class SupplierController extends Controller {
    private $supplierModel;

    public function __construct() {
        // Mulai session dan cek autentikasi
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Memuat model Supplier
        $this->supplierModel = $this->model('Supplier');

        // Cek otorisasi (admin dan apoteker)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan daftar semua supplier
    public function index() {
        $data['supplier'] = $this->supplierModel->getAllSupplier();
        $this->view('supplier/index', $data);
    }

    // Menampilkan form untuk membuat supplier baru
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $this->supplierModel->createSupplier($_POST);
            header('Location: ' . BASE_URL . '/supplier');
            exit();
        } else {
            $this->view('supplier/create');
        }
    }

    // Menampilkan form untuk mengedit supplier
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani update data supplier
            $this->supplierModel->updateSupplier($id, $_POST);
            header('Location: ' . BASE_URL . '/supplier');
            exit();
        } else {
            // Ambil data supplier berdasarkan ID
            $data['supplier'] = $this->supplierModel->getSupplierById($id);
    
            // Debugging jika data tidak muncul
            if (!$data['supplier']) {
                die('Data supplier tidak ditemukan.');
            }
    
            $this->view('supplier/edit', $data);
        }
    }
    

    // Menghapus supplier
    public function delete($id) {
        $this->supplierModel->deleteSupplier($id);
        header('Location: ' . BASE_URL . '/supplier');
        exit();
    }
}
?>
