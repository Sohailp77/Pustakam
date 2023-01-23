<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Default function
    public function index()
    {
        $user_data = $this->session->all_userdata();
        foreach ($user_data as $key => $value) {
            $this->session->unset_userdata($key);
        }
        $this->session->unset_userdata('nav');
        $this->session->unset_userdata('permissions');
        $this->session->sess_destroy();
        redirect(base_url('admin/login'));
    }    
}
