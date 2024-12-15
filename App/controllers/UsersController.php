<?php
// File: app/controllers/UserController.php

class UsersController extends Controller {
    private $userModel;

    public function __construct() {
        // Mulai session dan cek autentikasi
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Cek otorisasi (admin saja)
        if ($_SESSION['jabatan'] !== 'admin') {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }

        // Memuat model User
        $this->userModel = $this->model('User');
    }

    // Menampilkan daftar semua pengguna
    public function index() {
        $data['users'] = $this->userModel->getAllUsers();
        $this->view('users/index', $data);
    }

    // Menampilkan form untuk membuat pengguna baru
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $this->userModel->createUser($_POST);
            header('Location: ' . BASE_URL . '/users');
            exit();
        } else {
            $this->view('users/create');
        }
    }

    // Menampilkan form untuk mengedit pengguna
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani data yang di-submit
            $this->userModel->updateUser($id, $_POST);
            header('Location: ' . BASE_URL . '/users');
            exit();
        } else {
            // Ambil data pengguna yang akan diedit
            $data['user'] = $this->userModel->getUserById($id);
            if (!$data['user']) {
                // Jika pengguna tidak ditemukan, redirect atau tampilkan pesan error
                header('Location: ' . BASE_URL . '/users');
                exit();
            }
            $this->view('users/edit', $data);
        }
    }
    

    // Menghapus pengguna
    public function delete($id) {
        $this->userModel->deleteUser($id);
        header('Location: ' . BASE_URL . '/users');
        exit();
    }
}
?>
