<?php
// File: app/controllers/NotifikasiController.php

class NotifikasiController extends Controller {
    private $obatModel;

    public function __construct() {
        // Mulai session dan cek autentikasi
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Memuat model Obat
        $this->obatModel = $this->model('Obat');

        // Cek otorisasi (admin dan apoteker)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan halaman notifikasi
    public function index() {
        $data['obat_stok_rendah'] = $this->obatModel->getObatStokRendah();
        $data['obat_mendekati_kedaluwarsa'] = $this->obatModel->getObatKedaluwarsa();
        $data['obat_sudah_kedaluwarsa'] = $this->obatModel->getObatSudahKedaluwarsa();
        $this->view('notifikasi/index', $data);
    }
}
?>
