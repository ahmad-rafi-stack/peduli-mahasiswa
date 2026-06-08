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
        
        // Avatar placeholder
        $foto_profil = 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?auto=format&fit=crop&w=150&h=150&q=80';
        
        $this->data['admin'] = $admin;
        $this->data['foto_profil'] = $foto_profil;
        $this->data['pending_bantuan'] = $pending_bantuan;
        $this->data['notif_count'] = count($pending_bantuan);
    }
}
