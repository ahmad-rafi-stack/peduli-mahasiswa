<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('M_auth');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login_process() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan Password wajib diisi.');
            redirect('auth');
        }

        $admin = $this->M_auth->verify_login($username, $password);

        if ($admin) {
            $session_data = array(
                'id_admin' => $admin['id_admin'],
                'nama_admin' => $admin['nama_admin'],
                'username' => $admin['username'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);
            redirect('dashboard?status=success&message=Selamat+datang+kembali!');
        } else {
            $this->session->set_flashdata('error', 'Username atau Password salah.');
            redirect('auth');
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth?status=success&message=Berhasil+logout.');
    }
}
