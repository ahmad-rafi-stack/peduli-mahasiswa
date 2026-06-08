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
        $this->data['total_mahasiswa'] = $this->db->count_all('tb_mahasiswa');

        // 2. Total Bantuan Diterima (Nominal)
        $this->db->select_sum('jumlah_bantuan');
        $this->db->where('status', 'Diterima');
        $res = $this->db->get('tb_bantuan')->row_array();
        $this->data['total_dana_bantuan'] = isset($res['jumlah_bantuan']) ? $res['jumlah_bantuan'] : 0;

        // 3. Jumlah Bantuan Diterima (Penerima)
        $this->db->where('status', 'Diterima');
        $this->data['penerima_bantuan_count'] = $this->db->count_all_results('tb_bantuan');

        // 4. Bantuan Diproses (Pending)
        $this->db->where('status', 'Diproses');
        $this->data['bantuan_pending_count'] = $this->db->count_all_results('tb_bantuan');

        // 5. Mahasiswa Termiskin (Penghasilan Terendah)
        $this->data['poorest_students'] = $this->M_mahasiswa->get_poorest_mahasiswa(5);

        // 6. Recent Bantuan List
        $this->data['recent_bantuan'] = $this->M_bantuan->get_all_bantuan();
        // Limit to 5 recent bantuan
        $this->data['recent_bantuan'] = array_slice($this->data['recent_bantuan'], 0, 5);

        // Load Views
        $this->load->view('templates/header', $this->data);
        $this->load->view('dashboard/index', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
