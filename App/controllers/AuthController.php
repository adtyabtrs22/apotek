<?php
// File: app/controllers/AuthController.php

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        // Memuat model User
        $this->userModel = $this->model('User');
    }

    // Menampilkan halaman login dan menangani proses login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil data dari form
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Validasi input
            if (empty($username) || empty($password)) {
                $data['error'] = "Username dan Password harus diisi.";
                $this->view('auth/login', $data);
                return;
            }

            // Cari pengguna berdasarkan username
            $user = $this->userModel->getUserByUsername($username);

            // Cek apakah pengguna ditemukan dan password cocok
            if ($user && password_verify($password, $user->password)) {
                // Mulai session
                session_start();
                $_SESSION['user_id'] = $user->id_user;
                $_SESSION['jabatan'] = $user->jabatan;
                $_SESSION['nama_user'] = $user->nama_user;

                // Redirect ke dashboard
                header('Location: ' . BASE_URL . '/dashboard');
                exit();
            } else {
                $data['error'] = "Username atau Password salah.";
                $this->view('auth/login', $data);
            }
        } else {
            // Tampilkan form login
            $this->view('auth/login');
        }
    }

    // Menangani proses logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();

        // Redirect ke halaman login
        header('Location: ' . BASE_URL . '/auth/login');
        exit();
    }
}
?>
