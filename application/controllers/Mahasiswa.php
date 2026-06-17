<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mahasiswa extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_mahasiswa');
    }

    public function index() {
        $this->data['mahasiswa_list'] = $this->M_mahasiswa->get_all_mahasiswa();
        
        $this->load->view('templates/header', $this->data);
        $this->load->view('mahasiswa/mahasiswa_list', $this->data);
        $this->load->view('templates/footer', $this->data);
    }

    public function add() {
        $nim = $this->input->post('nim', TRUE);
        $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
        $jenis_kelamin = $this->input->post('jenis_kelamin', TRUE);
        $tempat_lahir = $this->input->post('tempat_lahir', TRUE);
        $tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
        $jurusan = $this->input->post('jurusan', TRUE);
        $semester = $this->input->post('semester', TRUE);
        $alamat = $this->input->post('alamat', TRUE);
        $no_telepon = $this->input->post('no_telepon', TRUE);

        // Economic Data
        $nama_ayah = $this->input->post('nama_ayah', TRUE);
        $nama_ibu = $this->input->post('nama_ibu', TRUE);
        $pekerjaan_ayah = $this->input->post('pekerjaan_ayah', TRUE);
        $pekerjaan_ibu = $this->input->post('pekerjaan_ibu', TRUE);
        $penghasilan_bulanan = intval(str_replace('.', '', $this->input->post('penghasilan_bulanan', TRUE)));
        $jumlah_tanggungan = intval($this->input->post('jumlah_tanggungan', TRUE));
        $status_rumah = $this->input->post('status_rumah', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);

        // Check if NIM already exists
        if ($this->M_mahasiswa->get_mahasiswa_by_nim($nim)) {
            redirect('mahasiswa?status=error&message=NIM+sudah+terdaftar!');
        }

        // Upload Profile Pic
        $foto_filename = NULL;
        if (!empty($_FILES['foto']['name'])) {
            if (!is_dir('uploads')) {
                mkdir('uploads', 0777, true);
            }
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name'] = 'mhs_' . $nim . '_' . time();
            $config['max_size'] = 2048; // 2MB

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto_filename = $upload_data['file_name'];
            } else {
                $error_msg = $this->upload->display_errors('', '');
                redirect('mahasiswa?status=error&message=' . urlencode('Gagal upload foto: ' . $error_msg));
            }
        }

        $data_mhs = array(
            'nim' => $nim,
            'nama_lengkap' => $nama_lengkap,
            'jenis_kelamin' => $jenis_kelamin,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jurusan' => $jurusan,
            'semester' => $semester,
            'alamat' => $alamat,
            'no_telepon' => $no_telepon,
            'foto' => $foto_filename
        );

        $data_eko = array(
            'nama_ayah' => $nama_ayah,
            'nama_ibu' => $nama_ibu,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'penghasilan_bulanan' => $penghasilan_bulanan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'status_rumah' => $status_rumah,
            'keterangan' => $keterangan
        );

        $insert = $this->M_mahasiswa->insert_mahasiswa($data_mhs, $data_eko);

        if ($insert) {
            redirect('mahasiswa?status=success&message=Data+mahasiswa+berhasil+ditambahkan.');
        } else {
            redirect('mahasiswa?status=error&message=Terjadi+kesalahan+database.');
        }
    }

    public function update($id) {
        $nama_lengkap = $this->input->post('nama_lengkap', TRUE);
        $jenis_kelamin = $this->input->post('jenis_kelamin', TRUE);
        $tempat_lahir = $this->input->post('tempat_lahir', TRUE);
        $tanggal_lahir = $this->input->post('tanggal_lahir', TRUE);
        $jurusan = $this->input->post('jurusan', TRUE);
        $semester = $this->input->post('semester', TRUE);
        $alamat = $this->input->post('alamat', TRUE);
        $no_telepon = $this->input->post('no_telepon', TRUE);

        // Economic Data
        $nama_ayah = $this->input->post('nama_ayah', TRUE);
        $nama_ibu = $this->input->post('nama_ibu', TRUE);
        $pekerjaan_ayah = $this->input->post('pekerjaan_ayah', TRUE);
        $pekerjaan_ibu = $this->input->post('pekerjaan_ibu', TRUE);
        $penghasilan_bulanan = intval(str_replace('.', '', $this->input->post('penghasilan_bulanan', TRUE)));
        $jumlah_tanggungan = intval($this->input->post('jumlah_tanggungan', TRUE));
        $status_rumah = $this->input->post('status_rumah', TRUE);
        $keterangan = $this->input->post('keterangan', TRUE);

        $current_student = $this->M_mahasiswa->get_mahasiswa_by_id($id);
        if (!$current_student) {
            redirect('mahasiswa?status=error&message=Data+tidak+ditemukan.');
        }

        // Upload Profile Pic if changed
        $foto_filename = $current_student['foto'];
        if (!empty($_FILES['foto']['name'])) {
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['file_name'] = 'mhs_' . $current_student['nim'] . '_' . time();
            $config['max_size'] = 2048;

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('foto')) {
                // Delete old file
                if (!empty($current_student['foto']) && file_exists('uploads/' . $current_student['foto'])) {
                    unlink('uploads/' . $current_student['foto']);
                }
                $upload_data = $this->upload->data();
                $foto_filename = $upload_data['file_name'];
            } else {
                $error_msg = $this->upload->display_errors('', '');
                redirect('mahasiswa?status=error&message=' . urlencode('Gagal upload foto: ' . $error_msg));
            }
        }

        $data_mhs = array(
            'nama_lengkap' => $nama_lengkap,
            'jenis_kelamin' => $jenis_kelamin,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'jurusan' => $jurusan,
            'semester' => $semester,
            'alamat' => $alamat,
            'no_telepon' => $no_telepon,
            'foto' => $foto_filename
        );

        $data_eko = array(
            'nama_ayah' => $nama_ayah,
            'nama_ibu' => $nama_ibu,
            'pekerjaan_ayah' => $pekerjaan_ayah,
            'pekerjaan_ibu' => $pekerjaan_ibu,
            'penghasilan_bulanan' => $penghasilan_bulanan,
            'jumlah_tanggungan' => $jumlah_tanggungan,
            'status_rumah' => $status_rumah,
            'keterangan' => $keterangan
        );

        $update = $this->M_mahasiswa->update_mahasiswa($id, $data_mhs, $data_eko);

        if ($update) {
            redirect('mahasiswa/detail/' . $id . '?status=success&message=Data+mahasiswa+berhasil+diperbarui.');
        } else {
            redirect('mahasiswa/detail/' . $id . '?status=error&message=Gagal+memperbarui+data.');
        }
    }

    public function delete($id = NULL) {
        // Enforce POST: prevents CSRF bypass via GET links/URL segments
        if ($this->input->method() !== 'post') {
            redirect('mahasiswa?status=error&message=Aksi+tidak+diizinkan.');
        }

        $id = $this->input->post('id_mahasiswa', TRUE) ?: $id;
        $student = $this->M_mahasiswa->get_mahasiswa_by_id($id);
        if ($student) {
            // Delete photo file
            if (!empty($student['foto']) && file_exists('uploads/' . $student['foto'])) {
                @unlink('uploads/' . $student['foto']);
            }
            $this->M_mahasiswa->delete_mahasiswa($id);
            redirect('mahasiswa?status=success&message=Data+mahasiswa+berhasil+dihapus.');
        } else {
            redirect('mahasiswa?status=error&message=Data+tidak+ditemukan.');
        }
    }

    public function detail($id) {
        $student = $this->M_mahasiswa->get_mahasiswa_by_id($id);
        if (!$student) {
            redirect('mahasiswa?status=error&message=Data+tidak+ditemukan.');
        }

        // Fetch student aid history
        $this->db->where('id_mahasiswa', $id);
        $this->db->order_by('tanggal_bantuan', 'DESC');
        $student['bantuan_history'] = $this->db->get('tb_bantuan')->result_array();

        $this->data['student'] = $student;

        $this->load->view('templates/header', $this->data);
        $this->load->view('mahasiswa/mahasiswa_detail', $this->data);
        $this->load->view('templates/footer', $this->data);
    }
}
