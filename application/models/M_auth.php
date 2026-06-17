<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function verify_login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('tb_admin');

        if ($query->num_rows() == 1) {
            $admin = $query->row_array();
            $stored_hash = $admin['password'];

            // Jika password cocok dengan hash Bcrypt
            if (password_verify($password, $stored_hash)) {
                return $admin;
            } 
            // Jika password cocok dengan hash MD5 (Akun lama sebelum dimigrasi)
            elseif ($stored_hash === md5($password)) {
                // Konversi hash ke Bcrypt baru
                $new_hash = password_hash($password, PASSWORD_BCRYPT);
                $this->db->where('id_admin', $admin['id_admin']);
                $this->db->update('tb_admin', array('password' => $new_hash));

                // Perbarui nilai di array kembalian
                $admin['password'] = $new_hash;
                return $admin;
            }
        }
        return false;
    }
}
