<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_mahasiswa');
        $this->load->model('M_bantuan');
    }

    public function index() {
        // 1. Total Mahasiswa
        $this->data['total_mahasiswa'] = $this->M_mahasiswa->count_all_mahasiswa();

        // 2. Total Bantuan Diterima (Nominal)
        $this->data['total_dana_bantuan'] = $this->M_bantuan->get_total_dana_bantuan();

        // 3. Jumlah Bantuan Diterima (Penerima)
        $this->data['penerima_bantuan_count'] = $this->M_bantuan->count_penerima_bantuan();

        // 4. Bantuan Diproses (Pending)
        $this->data['bantuan_pending_count'] = $this->M_bantuan->count_pending_bantuan();

        // 5. Mahasiswa Termiskin (Penghasilan Terendah)
        $this->data['poorest_students'] = $this->M_mahasiswa->get_poorest_mahasiswa(5);

        // 6. Recent Bantuan List
        $this->data['recent_bantuan'] = $this->M_bantuan->get_recent_bantuan(5);

        // Load Views
        $this->load->view('templates/header', $this->data);
        $this->load->view('dashboard/index', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
