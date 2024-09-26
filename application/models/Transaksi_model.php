<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

    public function read()
    {
        $query = $this->db->get('transaksi');
        return $query->result();
    }
    
    public function read_by($id)
    {
        $this->db->where('id',$id);
        $query = $this->db->get('transaksi');
        return $query->row() ;
    }

    public function input_data($data,$table){
        $this->db->insert($table,$data);
    }

    public function getAllTrans(){
        return $this->db->get('kamar')->result_array();
    }

    public function mark_expired() {
        $now = date('Y-m-d H:i:s');
        $data = array('status' => 'expired');
        $this->db->where('CONCAT(tgl_in, " ", jam_out) <=', $now);
        $this->db->update('transaksi', $data);
    }
}
