<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model');
        $this->load->model('Kamar_model');
        $this->load->model('Transaksi_model');
    }

    public function login()
    {
        if ($this->session->userdata('email')) redirect('Welcome'); 
        if ($this->input->post('login')) {
            $login = $this->Auth_model->getuser($this->input->post('email'));
            if ($login != NULL) {
                $data = array(
                    'nama'  => $login->nama,
                    'email' => $login->email,
                    'no'    => $login->no,
                    'akses' => $login->akses,
                    'gambar'=> $login->gambar
                );
                if ($this->input->post('no') == $login->no) {
                    $this->session->set_userdata($data);
                    redirect('Welcome');
                }
            }
            $this->session->set_flashdata('msg', '<p style="color:red;">Invalid Username or Password!</p>');
        }
        $this->load->view('login');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('welcome');
    }

    public function daftar()
    {
        if ($this->input->post('daftar')) {
            $this->Auth_model->register();
            if ($this->db->affected_rows() > 0) {
                $this->session->set_flashdata('msg', '<p style="color:green">Berhasil mendaftar</p>');
            } else {
                $this->session->set_flashdata('msg', '<p style="color:red;">Gagal mendaftar!</p>');
            }
            $this->load->view('login');
        }
    }

    public function booking($id)
    {
        if (! $this->session->userdata('email')) redirect('Auth/login');
        $data['detail'] = $this->db->get_where('kamar', ['id' => $id])->row();
        $this->load->view('user/booking', $data);
    }

    public function do_booking()
    {
        if (! $this->session->userdata('email')) redirect('Auth/login');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $no = $this->input->post('no');
        $tgl_in = $this->input->post('tgl_in');
		$jam_in = $this-> input->post('jam_in');
		$jam_out = $this-> input->post('jam_out');
        $jenis = $this->input->post('jenis');
        $duration = $this->input->post('duration');
        $upload_ktm = $this->input->post('upload_ktm');
        $alasan_booking = $this->input->post('alasan_booking');

        $data = array(
            'nama'   => $nama,
            'email'  => $email,
            'no'     => $no,
            'tgl_in' => $tgl_in,
			'jam_in' => $jam_in,
			'jam_out' => $jam_out,
            'jenis'  => $jenis,
            'duration' => $duration,
            'upload_ktm' => $upload_ktm,
            'alasan_booking' => $alasan_booking,
        );
        $this->Auth_model->input_data($data, 'transaksi');
        $this->session->set_flashdata('msg', '<p style="color:green;">Anda berhasil melakukan pemesanan!</p>');
        redirect('Auth/konfirmasi', $data);
    }

    public function konfirmasi() {
        // Ambil data status pemesanan berdasarkan nama user dari session
        $nama = $this->session->userdata('nama'); // Assuming the user's name is stored in session with key 'nama'
        $this->db->select('transaksi.*, kamar.harga');
        $this->db->from('transaksi');
        $this->db->join('kamar', 'transaksi.jenis = kamar.jenis');
        $this->db->where('transaksi.nama', $nama);
        $query = $this->db->get();
        $trans = $query->result();

        // Ambil data daftar antrian dengan status 'konfirmasi'
        $this->db->select('transaksi.*, kamar.harga');
        $this->db->from('transaksi');
        $this->db->join('kamar', 'transaksi.jenis = kamar.jenis');
        $this->db->where('transaksi.status', 'konfirmasi');
        $antrian_query = $this->db->get();
        $antrian = $antrian_query->result();

        // Kirim data ke view
        $data['trans'] = $trans;
        $data['antrian'] = $antrian;

        // Load view
        $this->load->view('user/konfirmasi', $data);
    }

    // Other methods in the Auth controller.
}

