<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Audit_log extends MY_Controller {

    public function __construct() {
        parent::__construct();
        // M_audit_log sudah di-load otomatis di MY_Controller
        $this->load->helper('form');
    }

    /**
     * Menampilkan daftar aktivitas admin dengan filter (modul/aksi/tanggal).
     */
    public function index() {
        // Kumpulkan filter dari GET
        $filter = array(
            'modul'   => $this->input->get('modul', TRUE),
            'aksi'    => $this->input->get('aksi', TRUE),
            'tanggal' => $this->input->get('tanggal', TRUE),
        );

        // Pagination sederhana berbasis halaman
        $per_page = 25;
        $page = (int) $this->input->get('page', TRUE);
        $page = ($page > 0) ? $page : 1;
        $offset = ($page - 1) * $per_page;

        $total = $this->M_audit_log->count_logs($filter);
        $this->data['logs']          = $this->M_audit_log->get_logs($filter, $per_page, $offset);
        $this->data['total']         = $total;
        $this->data['page']          = $page;
        $this->data['per_page']      = $per_page;
        $this->data['total_pages']   = ($per_page > 0) ? (int) ceil($total / $per_page) : 1;
        $this->data['filter']        = $filter;
        $this->data['modules']       = $this->M_audit_log->get_distinct_modules();

        $this->load->view('templates/header', $this->data);
        $this->load->view('audit_log/audit_log_list', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
