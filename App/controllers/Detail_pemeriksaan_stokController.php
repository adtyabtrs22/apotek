<?php
class Detail_pemeriksaan_stokController extends Controller {
    private $detailPemeriksaanStokModel;
    private $pemeriksaanStokModel;
    private $obatModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/auth/login');
            exit();
        }

        // Memuat model yang diperlukan
        $this->detailPemeriksaanStokModel = $this->model('DetailPemeriksaanStok');
        $this->pemeriksaanStokModel = $this->model('PemeriksaanStok');
        $this->obatModel = $this->model('Obat');

        // Cek otorisasi (admin dan apoteker)
        if (!in_array($_SESSION['jabatan'], ['admin', 'apoteker'])) {
            echo "Anda tidak memiliki hak akses.";
            exit();
        }
    }

    // Menampilkan daftar semua detail pemeriksaan stok
    public function index() {
        $data['detail_pemeriksaan_stok'] = $this->detailPemeriksaanStokModel->getAllDetailPemeriksaanStok();
        $this->view('detail_pemeriksaan_stok/index', $data);
    }

    // Menampilkan form untuk menambahkan detail pemeriksaan stok
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id_pemeriksaan' => (int)$_POST['id_pemeriksaan'],
                'id_obat' => (int)$_POST['id_obat'],
                'stok_tercatat' => (int)$_POST['stok_tercatat'],
                'stok_fisik' => (int)$_POST['stok_fisik'],
                'selisih' => (int)$_POST['stok_fisik'] - (int)$_POST['stok_tercatat']
            ];

            // Validasi
            if (empty($data['id_pemeriksaan']) || empty($data['id_obat']) || $data['stok_tercatat'] < 0 || $data['stok_fisik'] < 0) {
                $data['error'] = "Semua field wajib diisi dan stok harus bernilai positif.";
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getAllPemeriksaanStok();
                $data['obat'] = $this->obatModel->getAllObat();
                $this->view('detail_pemeriksaan_stok/create', $data);
                return;
            }

            // Simpan ke database
            if ($this->detailPemeriksaanStokModel->createDetailPemeriksaanStok($data)) {
                header('Location: ' . BASE_URL . '/detail_pemeriksaan_stok');
                exit();
            } else {
                $data['error'] = "Gagal menambahkan detail pemeriksaan stok.";
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getAllPemeriksaanStok();
                $data['obat'] = $this->obatModel->getAllObat();
                $this->view('detail_pemeriksaan_stok/create', $data);
            }
        } else {
            $data = [
                'pemeriksaan_stok' => $this->pemeriksaanStokModel->getAllPemeriksaanStok(),
                'obat' => $this->obatModel->getAllObat()
            ];
            $this->view('detail_pemeriksaan_stok/create', $data);
        }
    }

    // Menampilkan form untuk mengedit detail pemeriksaan stok
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id_pemeriksaan' => (int)$_POST['id_pemeriksaan'],
                'id_obat' => (int)$_POST['id_obat'],
                'stok_tercatat' => (int)$_POST['stok_tercatat'],
                'stok_fisik' => (int)$_POST['stok_fisik'],
                'selisih' => (int)$_POST['stok_fisik'] - (int)$_POST['stok_tercatat']
            ];

            // Validasi
            if (empty($data['id_pemeriksaan']) || empty($data['id_obat']) || $data['stok_tercatat'] < 0 || $data['stok_fisik'] < 0) {
                $data['error'] = "Semua field wajib diisi dan stok harus bernilai positif.";
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getAllPemeriksaanStok();
                $data['obat'] = $this->obatModel->getAllObat();
                $data['detail_pemeriksaan_stok'] = $this->detailPemeriksaanStokModel->getDetailPemeriksaanStokById($id);
                $this->view('detail_pemeriksaan_stok/edit', $data);
                return;
            }

            // Update data
            if ($this->detailPemeriksaanStokModel->updateDetailPemeriksaanStok($id, $data)) {
                header('Location: ' . BASE_URL . '/detail_pemeriksaan_stok');
                exit();
            } else {
                $data['error'] = "Gagal mengupdate detail pemeriksaan stok.";
                $data['pemeriksaan_stok'] = $this->pemeriksaanStokModel->getAllPemeriksaanStok();
                $data['obat'] = $this->obatModel->getAllObat();
                $data['detail_pemeriksaan_stok'] = $this->detailPemeriksaanStokModel->getDetailPemeriksaanStokById($id);
                $this->view('detail_pemeriksaan_stok/edit', $data);
            }
        } else {
            $data = [
                'detail_pemeriksaan_stok' => $this->detailPemeriksaanStokModel->getDetailPemeriksaanStokById($id),
                'pemeriksaan_stok' => $this->pemeriksaanStokModel->getAllPemeriksaanStok(),
                'obat' => $this->obatModel->getAllObat()
            ];
            $this->view('detail_pemeriksaan_stok/edit', $data);
        }
    }

    // Menghapus detail pemeriksaan stok
    public function delete($id) {
        if ($this->detailPemeriksaanStokModel->deleteDetailPemeriksaanStok($id)) {
            header('Location: ' . BASE_URL . '/detail_pemeriksaan_stok');
            exit();
        } else {
            echo "Gagal menghapus detail pemeriksaan stok.";
        }
    }
}
