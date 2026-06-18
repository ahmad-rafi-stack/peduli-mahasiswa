<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bantuan extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_bantuan');
        $this->load->model('M_mahasiswa');
    }

    public function index() {
        $this->data['bantuan_list'] = $this->M_bantuan->get_all_bantuan();
        $this->data['mahasiswa_list'] = $this->M_mahasiswa->get_all_mahasiswa();

        $this->load->view('templates/header', $this->data);
        $this->load->view('bantuan/bantuan_list', $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function add() {
        $id_mahasiswa = $this->input->post('id_mahasiswa', TRUE);
        $jenis_bantuan = $this->input->post('jenis_bantuan', TRUE);
        $jumlah_bantuan = intval(str_replace('.', '', $this->input->post('jumlah_bantuan', TRUE)));
        $tanggal_bantuan = $this->input->post('tanggal_bantuan', TRUE);
        $status = $this->input->post('status', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);

        if (empty($id_mahasiswa) || empty($jenis_bantuan) || empty($jumlah_bantuan) || empty($tanggal_bantuan)) {
            redirect('bantuan?status=error&message=Semua+kolom+wajib+diisi.');
        }

        $data = array(
            'id_mahasiswa' => $id_mahasiswa,
            'jenis_bantuan' => $jenis_bantuan,
            'jumlah_bantuan' => $jumlah_bantuan,
            'tanggal_bantuan' => $tanggal_bantuan,
            'status' => $status,
            'keterangan' => $keterangan
        );

        $insert = $this->M_bantuan->insert_bantuan($data);

        if ($insert) {
            $this->M_audit_log->log('create', 'Bantuan', 'Menambahkan bantuan "' . $jenis_bantuan . '" (Rp ' . number_format($jumlah_bantuan, 0, ',', '.') . ') untuk mahasiswa ID ' . $id_mahasiswa);
            redirect('bantuan?status=success&message=Data+bantuan+berhasil+ditambahkan.');
        } else {
            redirect('bantuan?status=error&message=Terjadi+kesalahan+saat+menambah+data.');
        }
    }

    public function update_status($id = NULL, $status = NULL) {
        // Enforce POST: prevents CSRF bypass via GET links/URL segments
        if ($this->input->method() !== 'post') {
            redirect('bantuan?status=error&message=Aksi+tidak+diizinkan.');
        }

        // Allow status from POST body (form) for safety, fallback to segment
        $status = $this->input->post('status', TRUE) ?: $status;
        $id     = $this->input->post('id_bantuan', TRUE) ?: $id;

        if (!in_array($status, array('Diproses', 'Diterima', 'Ditolak'))) {
            redirect('bantuan?status=error&message=Status+tidak+valid.');
        }

        $data = array('status' => $status);
        $update = $this->M_bantuan->update_bantuan($id, $data);

        if ($update) {
            $this->M_audit_log->log('update_status', 'Bantuan', 'Mengubah status bantuan ID ' . $id . ' menjadi "' . $status . '"');
            redirect('bantuan?status=success&message=Status+bantuan+berhasil+diperbarui.');
        } else {
            redirect('bantuan?status=error&message=Gagal+memperbarui+status.');
        }
    }

    public function update($id) {
        $jenis_bantuan = $this->input->post('jenis_bantuan', TRUE);
        $jumlah_bantuan = intval(str_replace('.', '', $this->input->post('jumlah_bantuan', TRUE)));
        $tanggal_bantuan = $this->input->post('tanggal_bantuan', TRUE);
        $status = $this->input->post('status', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);

        $data = array(
            'jenis_bantuan' => $jenis_bantuan,
            'jumlah_bantuan' => $jumlah_bantuan,
            'tanggal_bantuan' => $tanggal_bantuan,
            'status' => $status,
            'keterangan' => $keterangan
        );

        $update = $this->M_bantuan->update_bantuan($id, $data);

        if ($update) {
            $this->M_audit_log->log('update', 'Bantuan', 'Memperbarui bantuan ID ' . $id . ' ("' . $jenis_bantuan . '", Rp ' . number_format($jumlah_bantuan, 0, ',', '.') . ', status: ' . $status . ')');
            redirect('bantuan?status=success&message=Data+bantuan+berhasil+diperbarui.');
        } else {
            redirect('bantuan?status=error&message=Gagal+memperbarui+data.');
        }
    }

    public function delete($id = NULL) {
        // Enforce POST: prevents CSRF bypass via GET links/URL segments
        if ($this->input->method() !== 'post') {
            redirect('bantuan?status=error&message=Aksi+tidak+diizinkan.');
        }

        $id = $this->input->post('id_bantuan', TRUE) ?: $id;
        $delete = $this->M_bantuan->delete_bantuan($id);
        if ($delete) {
            $this->M_audit_log->log('delete', 'Bantuan', 'Menghapus bantuan ID ' . $id);
            redirect('bantuan?status=success&message=Data+bantuan+berhasil+dihapus.');
        } else {
            redirect('bantuan?status=error&message=Gagal+menghapus+data.');
        }
    }
}
