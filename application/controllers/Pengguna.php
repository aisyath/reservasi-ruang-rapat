<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('Pengguna_model');
		if (! $this->session->userdata('email')) redirect('Auth/login');
		if ($this->session->userdata('akses')=='Admin') {
			// redirect('Welcome');
		}else{
			redirect('Welcome');
		}
	}

	public function read()
	{

		$data['user']=$this->Pengguna_model->read();
		$data['error'] = '';
        $data['result'] = $this->db->order_by('id','DESC')
                                    ->get('pengguna')
                                    ->result();
		$this->load->view('admin/pengguna/data', $data);
	}

	public function edit($id)
	{

        $data['detail'] = $this->db->get_where('pengguna',['id' => $id])->row();
		$this->load->view('admin/pengguna/ubah', $data);

	}
	
	public function do_upload()
    {
	    $config['upload_path']          = './images/pengguna';
	    $config['allowed_types']        = 'jpg|png';
	    $config['max_size']             = 0;
	    $config['max_width']            = 0;
	    $config['max_height']           = 0;
	    $this->load->library('upload', $config);
	    if (!$this->upload->do_upload('gambar')){
	            $error = array('error' => $this->upload->display_errors());
	            $this->load->view('admin/pengguna/data', $error);
	    }else{
	        $_data = array('upload_data' => $this->upload->data());
	         $data = array(
	            'nama'=> $this->input->post('nama'),
	            'email'=> $this->input->post('email'),
	            'no'=> $this->input->post('no'),
	            'akses'=> $this->input->post('akses'),
	            'gambar' => $_data['upload_data']['file_name']
	            );
	        $query = $this->db->insert('pengguna',$data);
	        if($query){
	            $this->session->set_flashdata('msg', '<p style="color:green;">Berhasil menambahkan data!</p>');
	            redirect('Pengguna/read');
	        }else{
	            $this->session->set_flashdata('msg', '<p style="color:red;">Gagal menambahkan data!</p>');
	        }
	    }
	}

	public function delete($id){
	    $_id = $this->db->get_where('pengguna',['id' => $id])->row();
	    $query = $this->db->delete('pengguna',['id'=>$id]);
	    if($query){
	        unlink("images/pengguna/".$_id->gambar);
	    }
	    redirect('Pengguna/read');
	}

	public function update()
	{
	    $id = $this->input->post('id');
        $_image = $this->db->get_where('pengguna',['id' => $id])->row();
        $config['upload_path']          = './images/pengguna/';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('gambar')){
            $data = array(
             'nama'=> $this->input->post('nama'),
             'email'=> $this->input->post('email'),
             'no'=> $this->input->post('no'),
             'akses'=> $this->input->post('akses')
            );
            $query = $this->db->update('pengguna', $data, array('id' => $id));
        }
        else{
            $_data = array('upload_data' => $this->upload->data());
             $data = array(
                'nama'=> $this->input->post('nama'),
	            'email'=> $this->input->post('email'),
	            'no'=> $this->input->post('no'),
	            'akses'=> $this->input->post('akses'),
                'gambar' => $_data['upload_data']['file_name']
                );
            $query = $this->db->update('pengguna', $data, array('id' => $id));
            if($query){
                unlink("images/pengguna/".$_image->gambar);
            }
        } redirect('Pengguna/read');
	        
	    
	}
	
}
