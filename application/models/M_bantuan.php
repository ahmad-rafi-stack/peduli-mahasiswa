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

    public function get_total_dana_bantuan() {
        $this->db->select_sum('jumlah_bantuan');
        $this->db->where('status', 'Diterima');
        $res = $this->db->get('tb_bantuan')->row_array();
        return isset($res['jumlah_bantuan']) ? (float)$res['jumlah_bantuan'] : 0;
    }

    public function count_penerima_bantuan() {
        $this->db->where('status', 'Diterima');
        return $this->db->count_all_results('tb_bantuan');
    }

    public function count_pending_bantuan() {
        $this->db->where('status', 'Diproses');
        return $this->db->count_all_results('tb_bantuan');
    }

    public function get_recent_bantuan($limit) {
        $this->db->select('tb_bantuan.*, tb_mahasiswa.nim, tb_mahasiswa.nama_lengkap, tb_mahasiswa.jurusan');
        $this->db->from('tb_bantuan');
        $this->db->join('tb_mahasiswa', 'tb_mahasiswa.id_mahasiswa = tb_bantuan.id_mahasiswa');
        $this->db->order_by('tb_bantuan.tanggal_bantuan', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
}
