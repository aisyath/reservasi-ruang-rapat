<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function getuser($email)
    {
        $this->db->where('email', $email);
        return $this->db->get('pengguna')->row();
    }

    public function register()
    {
        $data = array (
            'nama' => $this->input->post('nama'),
            'email' => $this->input->post('mail'),
            'no' => $this->input->post('telp'),
            'akses' => $this->input->post('akses')
        );
        $this->db->insert('pengguna', $data);
    }

    public function input_data($data, $table)
    {
        
        $this->db->insert($table, $data);
    }
}
?>
