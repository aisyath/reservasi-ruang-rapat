<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kamar extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kamar_model');
        $this->load->database();
        
        // Check if user is logged in
        if (! $this->session->userdata('email')) {
            redirect('Auth/login');
        }
        
        // Check if user has Admin access
        if ($this->session->userdata('akses') !== 'Admin') {
            redirect('Welcome');
        }
    }

    public function read()
    {
        $data['kamar'] = $this->Kamar_model->read();
        $data['error'] = '';
        $data['result'] = $this->db->order_by('id', 'DESC')->get('kamar')->result();
        $this->load->view('admin/kamar/data', $data);
    }

    public function edit($id)
    {
        $data['detail'] = $this->db->get_where('kamar', ['id' => $id])->row();
        $this->load->view('admin/kamar/ubah', $data);
    }
    
    public function do_upload()
    {
        $config['upload_path']   = './images/kamar';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']      = 0;
        $config['max_width']     = 0;
        $config['max_height']    = 0;
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('gambar')) {
            $data['error'] = $this->upload->display_errors();
            $data['kamar'] = $this->Kamar_model->read();
            $data['result'] = $this->db->order_by('id', 'DESC')->get('kamar')->result();
            $this->load->view('admin/kamar/data', $data);
        } else {
            $_data = array('upload_data' => $this->upload->data());
            $data = array(
                'jenis'  => $this->input->post('jenis'),
                'gambar' => $_data['upload_data']['file_name']
            );
            $query = $this->db->insert('kamar', $data);
            
            if ($query) {
                $this->session->set_flashdata('msg', '<p style="color:green;">Berhasil menambahkan data!</p>');
            } else {
                $this->session->set_flashdata('msg', '<p style="color:red;">Gagal menambahkan data!</p>');
            }
            redirect('Kamar/read');
        }
    }

    public function delete($id)
    {
        $_id = $this->db->get_where('kamar', ['id' => $id])->row();
        $query = $this->db->delete('kamar', ['id' => $id]);
        
        if ($query) {
            if ($_id->gambar) {
                unlink("images/kamar/" . $_id->gambar);
            }
            $this->session->set_flashdata('msg', '<p style="color:green;">Berhasil menghapus data!</p>');
        } else {
            $this->session->set_flashdata('msg', '<p style="color:red;">Gagal menghapus data!</p>');
        }
        
        redirect('Kamar/read');
    }

    public function update()
    {
        $id = $this->input->post('id');
        $_image = $this->db->get_where('kamar', ['id' => $id])->row();
        
        $config['upload_path']   = './images/kamar/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']      = 0;
        $config['max_width']     = 0;
        $config['max_height']    = 0;
        
        $this->load->library('upload', $config);
        
        if (!$this->upload->do_upload('gambar')) {
            $data = array(
                'jenis'  => $this->input->post('jenis'),
            );
            $query = $this->db->update('kamar', $data, array('id' => $id));
        } else {
            $_data = array('upload_data' => $this->upload->data());
            $data = array(
                'jenis'  => $this->input->post('jenis'),
                'gambar' => $_data['upload_data']['file_name']
            );
            $query = $this->db->update('kamar', $data, array('id' => $id));
            
            if ($query && $_image->gambar) {
                unlink("images/kamar/" . $_image->gambar);
            }
        }
        
        if ($query) {
            $this->session->set_flashdata('msg', '<p style="color:green;">Berhasil memperbarui data!</p>');
        } else {
            $this->session->set_flashdata('msg', '<p style="color:red;">Gagal memperbarui data!</p>');
        }
        
        redirect('Kamar/read');
    }
}

