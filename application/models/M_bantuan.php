<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_bantuan extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_bantuan() {
        $this->db->select('tb_bantuan.*, tb_mahasiswa.nim, tb_mahasiswa.nama_lengkap, tb_mahasiswa.jurusan');
        $this->db->from('tb_bantuan');
        $this->db->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_bantuan.id_mahasiswa');
        $this->db->order_by('tb_bantuan.tanggal_bantuan', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_pending_bantuan() {
        $this->db->select('tb_bantuan.*, tb_mahasiswa.nama_lengkap');
        $this->db->from('tb_bantuan');
        $this->db->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_bantuan.id_mahasiswa');
        $this->db->where('tb_bantuan.status', 'Diproses');
        $this->db->order_by('tb_bantuan.tanggal_bantuan', 'ASC');
        return $this->db->get()->result_array();
    }

    public function insert_bantuan($data) {
        return $this->db->insert('tb_bantuan', $data);
    }

    public function update_bantuan($id, $data) {
        $this->db->where('id_bantuan', $id);
        return $this->db->update('tb_bantuan', $data);
    }

    public function delete_bantuan($id) {
        $this->db->where('id_bantuan', $id);
        return $this->db->delete('tb_bantuan');
    }
}
