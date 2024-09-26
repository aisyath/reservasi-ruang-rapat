<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('email')) redirect('Auth/login');
        $this->load->model('Kamar_model');
        $this->load->model('Transaksi_model');
    } 

    public function read() {
        if ($this->session->userdata('akses') != 'Admin') {
            $this->load->view('admin/index');
        } else {
            $data['trans'] = $this->Transaksi_model->read();
            $data['error'] = '';
            $data['result'] = $this->db->where('status', 'Pending')
                                    ->get('transaksi')
                                    ->result();
            $this->load->view('admin/transaksi/data1', $data);
        }
    }

    public function data()
    {
        if ($this->session->userdata('akses') != 'Admin') {
            $this->load->view('admin/index');
        } else {
            $data['trans'] = $this->Transaksi_model->read();
            $data['error'] = '';
            $data['result'] = $this->db->where('status', 'Confirm')
                                    ->get('transaksi')
                                    ->result();
            $data['confirmed_count'] = $this->db->where('status', 'Confirm')->count_all_results('transaksi'); // Add this line to get the confirmed count
            $this->load->view('admin/transaksi/data2', $data);
        }
    }


    public function rejected()
    {
        if ($this->session->userdata('akses') != 'Admin') {
            $this->load->view('admin/index');
        } else {
            $data['trans'] = $this->Transaksi_model->read();
            $data['error'] = '';
            $data['result'] = $this->db->where('status', 'Rejected')
                                       ->get('transaksi')
                                       ->result();
            $data['rejected_count'] = $this->db->where('status', 'Rejected')->count_all_results('transaksi'); // Add this line to get the confirmed count
            $this->load->view('admin/transaksi/data3', $data);
        }
    }
    

    public function add()
    {
        if ($this->session->userdata('akses') != 'Admin') {
            $this->load->view('admin/index');
        } else {
            $data['kamar'] = $this->Kamar_model->read();
            $data['error'] = '';
            $data['result'] = $this->db->order_by('id', 'ASC')
                                       ->get('kamar')
                                       ->result();
            $this->load->view('admin/transaksi/tambah', $data);
        }
    }

    public function tambah()
    {
        if (!$this->session->userdata('email')) redirect('Auth/login');
        $nama = $this->input->post('nama');
        $email = $this->input->post('email');
        $no = $this->input->post('no');
        $tgl_in = $this->input->post('tgl_in');
        $jam_in = $this->input->post('jam_in');
        $jam_out = $this->input->post('jam_out');
        $jenis = $this->input->post('jenis');
        $duration = $this->input->post('duration');
        $alasan_booking = $this->input->post('alasan_booking');
        $upload_ktm = $this->input->post('upload_ktm');
        $status = $this->input->post('status');

        // Set status to Pending by default
        $status = 'Pending';

        $data = array(
            'nama' => $nama,
            'email' => $email,
            'no' => $no,
            'tgl_in' => $tgl_in,
            'jam_in' => $jam_in,
            'jam_out' => $jam_out,
            'jenis' => $jenis,
            'duration' => $duration,
            'alasan_booking' => $alasan_booking,
            'upload_ktm' => $upload_ktm,
            'status' => $status,
        );
        $this->Transaksi_model->input_data($data, 'transaksi');
        $this->session->set_flashdata('msg', '<p style="color:green;">Anda berhasil melakukan transaksi!</p>');
        redirect('Transaksi/read');
    }

    public function edit($id) 
    {
        $this->db->set('status', 'Confirm');
        $this->db->where('id', $id);
        $this->db->update('transaksi');
        redirect('Transaksi/data');
    }

    public function reject($id)
    {
        $this->db->set('status', 'Rejected');
        $this->db->where('id', $id);
        $this->db->update('transaksi');
        redirect('Transaksi/Rejected');
    }
}
