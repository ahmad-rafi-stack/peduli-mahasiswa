<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    protected $data = array();

    public function __construct() {
        parent::__construct();
        
        $this->load->library('session');
        $this->load->helper('url');
        
        // Check session login
        if (!$this->session->userdata('logged_in')) {
            $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
            redirect('auth');
        }
        
        $this->load->model('M_admin');
        $this->load->model('M_bantuan');
        
        $admin_id = $this->session->userdata('id_admin');
        $admin = $this->M_admin->get_admin_by_id($admin_id);
        
        if (!$admin) {
            $this->session->sess_destroy();
            redirect('auth');
        }
        
        // Fetch notifications (Pending bantuan requests)
        $pending_bantuan = $this->M_bantuan->get_pending_bantuan();
        
        // Avatar placeholder (SVG inline berbasis inisial, tanpa request eksternal) / foto database
        if (!empty($admin['foto']) && file_exists(FCPATH . 'uploads/' . $admin['foto'])) {
            $foto_profil = base_url('uploads/' . $admin['foto']);
        } else {
            // Bangun inisial dari nama admin (hindari request ke pihak ketiga / kebocoran IP)
            $inisial = '?';
            if (!empty($admin['nama_admin'])) {
                $kata = preg_split('/\s+/', trim($admin['nama_admin']));
                $inisial = strtoupper(substr($kata[0], 0, 1));
                if (count($kata) > 1) {
                    $inisial .= strtoupper(substr(end($kata), 0, 1));
                }
            }
            $inisial = htmlspecialchars($inisial, ENT_QUOTES, 'UTF-8');
            $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150">'
                 . '<rect width="150" height="150" fill="#2563eb"/>'
                 . '<text x="50%" y="50%" dy=".1em" fill="#ffffff" font-family="Arial,Helvetica,sans-serif" '
                 . 'font-size="64" font-weight="bold" text-anchor="middle" dominant-baseline="middle">'
                 . $inisial . '</text></svg>';
            $foto_profil = 'data:image/svg+xml;charset=UTF-8,' . rawurlencode($svg);
        }
        
        $this->data['admin'] = $admin;
        $this->data['foto_profil'] = $foto_profil;
        $this->data['pending_bantuan'] = $pending_bantuan;
        $this->data['notif_count'] = count($pending_bantuan);
    }
}
