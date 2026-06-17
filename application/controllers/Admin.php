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

        // Penanganan upload foto profil admin
        if (!empty($_FILES['foto_admin']['name'])) {
            $config['upload_path']   = './uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048; // 2MB
            $config['file_name']     = 'admin_' . $id_admin . '_' . time();

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto_admin')) {
                $upload_data = $this->upload->data();
                $data['foto'] = $upload_data['file_name'];

                // Hapus foto lama jika ada
                $old_admin = $this->M_admin->get_admin_by_id($id_admin);
                if (!empty($old_admin['foto']) && file_exists('./uploads/' . $old_admin['foto'])) {
                    @unlink('./uploads/' . $old_admin['foto']);
                }
            } else {
                $error_msg = $this->upload->display_errors('', '');
                redirect('dashboard?status=error&message=' . urlencode($error_msg));
            }
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
