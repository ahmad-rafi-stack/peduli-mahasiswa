<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_mahasiswa extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_all_mahasiswa() {
        $this->db->select('tb_mahasiswa.*, tb_data_ekonomi.penghasilan_bulanan, tb_data_ekonomi.jumlah_tanggungan, tb_data_ekonomi.status_rumah');
        $this->db->from('tb_mahasiswa');
        $this->db->join('tb_data_ekonomi', 'tb_mahasiswa.id_mahasiswa = tb_data_ekonomi.id_mahasiswa', 'left');
        $this->db->order_by('tb_mahasiswa.nim', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_mahasiswa_by_id($id) {
        $this->db->select('tb_mahasiswa.*, tb_data_ekonomi.nama_ayah, tb_data_ekonomi.nama_ibu, tb_data_ekonomi.pekerjaan_ayah, tb_data_ekonomi.pekerjaan_ibu, tb_data_ekonomi.penghasilan_bulanan, tb_data_ekonomi.jumlah_tanggungan, tb_data_ekonomi.status_rumah, tb_data_ekonomi.keterangan as ket_ekonomi');
        $this->db->from('tb_mahasiswa');
        $this->db->join('tb_data_ekonomi', 'tb_mahasiswa.id_mahasiswa = tb_data_ekonomi.id_mahasiswa', 'left');
        $this->db->where('tb_mahasiswa.id_mahasiswa', $id);
        return $this->db->get()->row_array();
    }

    public function get_mahasiswa_by_nim($nim) {
        return $this->db->get_where('tb_mahasiswa', array('nim' => $nim))->row_array();
    }

    public function get_poorest_mahasiswa($limit = 5) {
        $this->db->select('tb_mahasiswa.*, tb_data_ekonomi.penghasilan_bulanan, tb_data_ekonomi.jumlah_tanggungan, tb_data_ekonomi.pekerjaan_ayah');
        $this->db->from('tb_mahasiswa');
        $this->db->join('tb_data_ekonomi', 'tb_mahasiswa.id_mahasiswa = tb_data_ekonomi.id_mahasiswa');
        $this->db->order_by('tb_data_ekonomi.penghasilan_bulanan', 'ASC');
        $this->db->order_by('tb_data_ekonomi.jumlah_tanggungan', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function insert_mahasiswa($data_mhs, $data_eko) {
        $this->db->trans_start();

        // 1. Insert Student Biodata
        $this->db->insert('tb_mahasiswa', $data_mhs);
        $insert_id = $this->db->insert_id();

        // 2. Insert Economic Status linked to insert_id
        $data_eko['id_mahasiswa'] = $insert_id;
        $this->db->insert('tb_data_ekonomi', $data_eko);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function update_mahasiswa($id, $data_mhs, $data_eko) {
        $this->db->trans_start();

        // Update Student
        $this->db->where('id_mahasiswa', $id);
        $this->db->update('tb_mahasiswa', $data_mhs);

        // Update Economic Status
        $this->db->where('id_mahasiswa', $id);
        $this->db->update('tb_data_ekonomi', $data_eko);

        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    public function delete_mahasiswa($id) {
        $this->db->where('id_mahasiswa', $id);
        return $this->db->delete('tb_mahasiswa'); // Will cascade delete tb_data_ekonomi & tb_bantuan
    }

    public function count_all_mahasiswa() {
        return $this->db->count_all('tb_mahasiswa');
    }
}
