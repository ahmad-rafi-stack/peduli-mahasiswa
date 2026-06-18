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

        // Penanganan upload foto profil admin (Cropped / Base64)
        $cropped_foto = $this->input->post('cropped_foto');
        if (!empty($cropped_foto)) {
            // Bersihkan data URL prefix (data:image/jpeg;base64,)
            if (preg_match('/^data:image\/(\w+);base64,/', $cropped_foto, $type)) {
                $img_data = substr($cropped_foto, strpos($cropped_foto, ',') + 1);
                $img_type = strtolower($type[1]); // jpeg, png, gif

                // Ubah jpeg menjadi jpg demi konsistensi ekstensi
                if ($img_type === 'jpeg') {
                    $img_type = 'jpg';
                }

                if (in_array($img_type, array('jpg', 'jpeg', 'png', 'gif'))) {
                    $img_base64 = base64_decode($img_data, TRUE);
                    
                    // Validasi biner adalah gambar asli (bukan payload terselubung)
                    if ($img_base64 !== FALSE && function_exists('getimagesizefromstring')) {
                        $img_info = @getimagesizefromstring($img_base64);
                        if ($img_info === FALSE || strpos($img_info['mime'], 'image/') !== 0) {
                            redirect('dashboard?status=error&message=' . urlencode('File yang diunggah bukan gambar valid.'));
                        }

                        $file_name = 'admin_' . $id_admin . '_' . time() . '.' . $img_type;
                        $file_path = './uploads/' . $file_name;

                        if (file_put_contents($file_path, $img_base64)) {
                            $data['foto'] = $file_name;

                            // Hapus foto lama jika ada
                            $old_admin = $this->M_admin->get_admin_by_id($id_admin);
                            if (!empty($old_admin['foto']) && file_exists('./uploads/' . $old_admin['foto'])) {
                                @unlink('./uploads/' . $old_admin['foto']);
                            }
                        }
                    }
                }
            }
        } elseif (!empty($_FILES['foto_admin']['name'])) {
            // Fallback: Upload file konvensional jika JavaScript Cropper dinonaktifkan
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

            // Catat aktivitas pembaruan profil (catat khusus bila password ikut diubah)
            $this->M_audit_log->log('update_profile', 'Admin', 'Memperbarui profil admin (username: ' . $username . ')' . (!empty($password) ? ', termasuk password' : ''));

            redirect('dashboard?status=success_profile');
        } else {
            redirect('dashboard?status=error_profile');
        }
    }
}
