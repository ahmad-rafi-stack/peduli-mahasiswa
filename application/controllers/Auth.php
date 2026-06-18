<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    // Konfigurasi brute-force protection
    private $max_attempts   = 5;   // Maksimum percobaan gagal sebelum lockout
    private $lockout_window = 900;  // Jendela waktu penghitungan (detik) = 15 menit
    private $lockout_time   = 900;  // Durasi kunci akun/IP setelah tercapai (detik) = 15 menit

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('M_auth');
        $this->load->model('M_audit_log');
    }

    public function index() {
        if ($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }
        $this->load->view('auth/login');
    }

    public function login_process() {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password', TRUE);

        if (empty($username) || empty($password)) {
            $this->session->set_flashdata('error', 'Username dan Password wajib diisi.');
            redirect('auth');
        }

        // Brute-force protection: kunci jika IP terlalu banyak percobaan gagal
        if ($this->_is_locked_out()) {
            $remaining = $this->_remaining_lockout();
            $this->session->set_flashdata('error', 'Terlalu banyak percobaan login gagal. Coba lagi dalam ' . ceil($remaining / 60) . ' menit.');
            redirect('auth');
        }

        $admin = $this->M_auth->verify_login($username, $password);

        if ($admin) {
            // Bersihkan jejak percobaan gagal setelah login berhasil
            $this->_reset_attempts();

            // Cegah session fixation: regenerasi ID session pasca-login
            $this->session->sess_regenerate(TRUE);

            $session_data = array(
                'id_admin' => $admin['id_admin'],
                'nama_admin' => $admin['nama_admin'],
                'username' => $admin['username'],
                'logged_in' => TRUE
            );
            $this->session->set_userdata($session_data);

            // Catat aktivitas login berhasil
            $this->M_audit_log->log('login', 'Auth', 'Login berhasil', array(
                'id_admin'   => $admin['id_admin'],
                'nama_admin' => $admin['nama_admin'],
                'username'   => $admin['username'],
            ));

            redirect('dashboard?status=success&message=Selamat+datang+kembali!');
        } else {
            $this->_record_attempt();
            $attempts_left = $this->_attempts_left();
            $msg = 'Username atau Password salah.';
            if ($attempts_left > 0 && $attempts_left <= 2) {
                $msg .= ' Sisa percobaan: ' . $attempts_left . '.';
            }

            // Catat upaya login gagal (tanpa id_admin karena belum terverifikasi)
            $this->M_audit_log->log('login_gagal', 'Auth', 'Upaya login gagal untuk username: ' . $username, array(
                'id_admin'   => NULL,
                'nama_admin' => NULL,
                'username'   => $username,
            ));

            $this->session->set_flashdata('error', $msg);
            redirect('auth');
        }
    }

    public function logout() {
        // Catat aktivitas logout sebelum session dihancurkan
        $this->M_audit_log->log('logout', 'Auth', 'Logout');

        $this->session->sess_destroy();
        redirect('auth?status=success&message=Berhasil+logout.');
    }

    /**
     * Mendapatkan kunci unik per-IP untuk penghitungan percobaan login.
     * Mengandalkan IP klien; aman dari manipulasi cookie/session.
     */
    private function _attempt_key() {
        return 'login_attempts_' . md5($this->input->ip_address());
    }

    private function _is_locked_out() {
        $key = $this->_attempt_key() . '_lock';
        $locked_at = $this->session->tempdata($key);
        if ($locked_at !== NULL) {
            return TRUE; // masih dalam masa kunci (tempdata auto-expire)
        }
        return FALSE;
    }

    private function _remaining_lockout() {
        // tempdata di CI3 tidak menyediakan TTL tersisa; kembalikan nilai default.
        return $this->lockout_time;
    }

    private function _record_attempt() {
        $key = $this->_attempt_key();
        $attempts = (int) $this->session->tempdata($key);
        $attempts++;

        if ($attempts >= $this->max_attempts) {
            // Kunci IP selama lockout_time
            $this->session->set_tempdata($key . '_lock', time(), $this->lockout_time);
            $this->session->unset_tempdata($key);
        } else {
            // Pertahankan penghitungan selama jendela waktu
            $this->session->set_tempdata($key, $attempts, $this->lockout_window);
        }
    }

    private function _reset_attempts() {
        $key = $this->_attempt_key();
        $this->session->unset_tempdata($key);
        $this->session->unset_tempdata($key . '_lock');
    }

    private function _attempts_left() {
        $attempts = (int) $this->session->tempdata($this->_attempt_key());
        return max(0, $this->max_attempts - $attempts);
    }
}
