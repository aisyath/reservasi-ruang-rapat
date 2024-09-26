// application/controllers/Cleanup.php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cleanup extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transaksi_model');
    }

    public function delete_expired()
    {
        // Mark expired bookings
        $this->Transaksi_model->mark_expired();
        echo "Expired bookings have been marked.";
    }
}
