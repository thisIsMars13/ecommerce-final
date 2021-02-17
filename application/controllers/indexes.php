<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    class Indexes extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
        }
        
        public function index()
        {
            $this->load->view('landing_page');
        }

        public function logoff()
        {
            $this->session->sess_destroy();
            redirect(base_url());
        }
    }
?>