<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent:: __construct();
		$this->load->model('Kamar_model');
		$this->load->model('Pengguna_model');
		$this->load->model('Transaksi_model');
	} 
	public function index()
	{
		if (! $this->session->userdata('email')) redirect('Auth/login');
		if ($this->session->userdata('akses')=='Admin') {
			$this->load->view('admin/index');
		}else{
			$data['kamar']=$this->Kamar_model->read();
			$data['error'] = '';
	        $data['result'] = $this->db->order_by('id','DESC')
	                                    ->get('kamar')
	                                    ->result();
	        $data['trans']=$this->Transaksi_model->read();
			$data['error'] = '';
	        $data['trans'] = $this->db->order_by('id','DESC')
	                                    ->get('transaksi')
	                                    ->result();
			$this->load->view('user/index', $data);
		}
	}
}
