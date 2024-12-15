<?php
class DashboardController extends Controller {
    private $obatModel;
    private $userModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Memuat model yang diperlukan
        $this->obatModel = $this->model('Obat');
        $this->userModel = $this->model('User'); // Ubah ke 'User' sesuai nama model

        // Cek otorisasi (admin dan apoteker)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan dashboard utama
    public function index() {
        // Validasi keberadaan session username
        $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Pengguna';

        // Ambil nama_user dari model User
        $nama_user = 'Pengguna';
        if (isset($_SESSION['user_id'])) {
            $user = $this->userModel->getUserById($_SESSION['user_id']); // Panggil metode dari model User
            $nama_user = $user['nama_user'] ?? 'Pengguna';
        }

        $data = [
            'username' => $username,
            'nama_user' => $nama_user,
            'jabatan' => $_SESSION['jabatan'] ?? 'Tidak Diketahui',
            'total_obat' => 0,
            'obat_stok_rendah' => [],
            'obat_mendekati_kedaluwarsa' => [],
            'obat_sudah_kedaluwarsa' => []
        ];

        try {
            // Fetch data dari model
            $data['total_obat'] = count($this->obatModel->getAllObat());
            $data['obat_stok_rendah'] = $this->obatModel->getObatStokRendah();
            $data['obat_mendekati_kedaluwarsa'] = $this->obatModel->getObatKedaluwarsa();
            $data['obat_sudah_kedaluwarsa'] = $this->obatModel->getObatSudahKedaluwarsa();
        } catch (Exception $e) {
            // Log error jika ada
            error_log("Error fetching data for dashboard: " . $e->getMessage());
        }

        $this->view('dashboard/index', $data);
    }
}
?>
