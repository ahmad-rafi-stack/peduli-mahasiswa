<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends MY_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function update_profile() {
        $id_admin = $this->session->userdata('id_admin');
        $nama_admin = $this->input->post('nama_admin', TRUE);
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');
        if (empty($nama_admin) || empty($username)) {
            redirect('dashboard?status=error&message=Nama+dan+Username+wajib+diisi.');
        }
        $data = array(
            'nama_admin' => $nama_admin,
            'username' => $username
        );

        if (!empty($password)) {
            $data['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $update = $this->M_admin->update_profile($id_admin, $data);

        if ($update) {
            $this->session->set_userdata('nama_admin', $nama_admin);
            $this->session->set_userdata('username', $username);
            redirect('dashboard?status=success_profile');
        } else {
            redirect('dashboard?status=error_profile');
        }
    }
}
