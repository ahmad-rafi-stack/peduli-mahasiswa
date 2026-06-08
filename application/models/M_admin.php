<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_admin extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_admin_by_id($id) {
        return $this->db->get_where('tb_admin', array('id_admin' => $id))->row_array();
    }

    public function update_profile($id, $data) {
        $this->db->where('id_admin', $id);
        return $this->db->update('tb_admin', $data);
    }
}
