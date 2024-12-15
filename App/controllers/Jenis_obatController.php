<?php
class Jenis_obatController extends Controller {
    private $jenisObatModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
        $this->jenisObatModel = $this->model('JenisObat');
    }

    public function index() {
        $data['jenis_obat'] = $this->jenisObatModel->getAllJenisObat();
        $this->view('jenis_obat/index', $data);
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['jenis_obat' => trim($_POST['jenis_obat'])];
            if (empty($data['jenis_obat'])) {
                $data['error'] = "Jenis Obat tidak boleh kosong.";
                $this->view('jenis_obat/create', $data);
            } else {
                $this->jenisObatModel->createJenisObat($data);
                header('Location: ' . BASE_URL . '/jenis_obat');
            }
        } else {
            $this->view('jenis_obat/create');
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = ['jenis_obat' => trim($_POST['jenis_obat'])];
            if (empty($data['jenis_obat'])) {
                $data['error'] = "Jenis Obat tidak boleh kosong.";
                $this->view('jenis_obat/edit', ['error' => $data['error'], 'jenis_obat' => $data]);
            } else {
                $this->jenisObatModel->updateJenisObat($id, $data);
                header('Location: ' . BASE_URL . '/jenis_obat');
                exit();
            }
        } else {
            $jenis_obat = $this->jenisObatModel->getJenisObatById($id);
            if ($jenis_obat) {
                $this->view('jenis_obat/edit', ['jenis_obat' => $jenis_obat]);
            } else {
                die("Data Jenis Obat tidak ditemukan.");
            }
        }
    }
    

    public function delete($id) {
        $this->jenisObatModel->deleteJenisObat($id);
        header('Location: ' . BASE_URL . '/jenis_obat');
    }
}
?>