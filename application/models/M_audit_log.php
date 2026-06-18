<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Audit Log
 * Merekam aktivitas admin (login/logout/tambah/edit/hapus) untuk keperluan
 * pelacakan & akuntabilitas atas data mahasiswa yang sensitif.
 */
class M_audit_log extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Catat satu entri aktivitas.
     *
     * @param string $aksi       Jenis aksi: login, logout, create, update, delete, dll.
     * @param string $modul      Modul terkait: Auth, Mahasiswa, Bantuan, Admin.
     * @param string $deskripsi  Penjelasan aktivitas (bebas).
     * @param array  $admin      (Opsional) Data admin: id_admin, nama_admin, username.
     *                           Jika kosong, diambil dari session yang sedang aktif.
     * @return bool
     */
    public function log($aksi, $modul, $deskripsi = '', $admin = array()) {
        // Ambil info admin dari session bila tidak diberikan secara eksplisit
        if (empty($admin)) {
            $admin = array(
                'id_admin'   => $this->session->userdata('id_admin'),
                'nama_admin' => $this->session->userdata('nama_admin'),
                'username'   => $this->session->userdata('username'),
            );
        }

        $data = array(
            'id_admin'   => isset($admin['id_admin']) ? $admin['id_admin'] : NULL,
            'nama_admin' => isset($admin['nama_admin']) ? $admin['nama_admin'] : NULL,
            'username'   => isset($admin['username']) ? $admin['username'] : NULL,
            'aksi'       => $aksi,
            'modul'      => $modul,
            'deskripsi'  => $deskripsi,
            'ip_address' => $this->input->ip_address(),
            'user_agent' => substr($this->input->user_agent(), 0, 255),
        );

        return (bool) $this->db->insert('tb_audit_log', $data);
    }

    /**
     * Ambil daftar log dengan dukungan filter.
     *
     * @param array $filter ['modul' => ..., 'aksi' => ..., 'tanggal' => 'Y-m-d']
     * @param int   $limit
     * @param int   $offset
     * @return array
     */
    public function get_logs($filter = array(), $limit = 100, $offset = 0) {
        if (!empty($filter['modul'])) {
            $this->db->where('modul', $filter['modul']);
        }
        if (!empty($filter['aksi'])) {
            $this->db->where('aksi', $filter['aksi']);
        }
        if (!empty($filter['tanggal'])) {
            $this->db->where('DATE(created_at)', $filter['tanggal']);
        }

        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('tb_audit_log')->result_array();
    }

    /**
     * Hitung total log (untuk pagination).
     */
    public function count_logs($filter = array()) {
        if (!empty($filter['modul'])) {
            $this->db->where('modul', $filter['modul']);
        }
        if (!empty($filter['aksi'])) {
            $this->db->where('aksi', $filter['aksi']);
        }
        if (!empty($filter['tanggal'])) {
            $this->db->where('DATE(created_at)', $filter['tanggal']);
        }
        return $this->db->count_all_results('tb_audit_log');
    }

    /**
     * Daftar modul unik (untuk dropdown filter).
     */
    public function get_distinct_modules() {
        $this->db->distinct();
        $this->db->select('modul');
        $this->db->order_by('modul', 'ASC');
        return $this->db->get('tb_audit_log')->result_array();
    }
}
