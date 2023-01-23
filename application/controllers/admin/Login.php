<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/dashboard');
        }

        $this->load->model('Admin_login_model');
        $this->load->model('Common_model');
    }

    // Default function
    public function index()
    {
        $txtUserName = $this->input->post('txtUserName');
        $txtPassword = $this->input->post('txtPassword');

        $this->form_validation->set_rules("txtUserName", "Username", "trim|required");
        $this->form_validation->set_rules("txtPassword", "Password", "trim|required");
        $this->form_validation->set_error_delimiters('<p><span class="text-danger">', '</span><p>');

        if ($this->form_validation->run() == TRUE) {

			$validUserData = $this->Admin_login_model->adminUserLogin($txtUserName, $txtPassword);

            if (!empty($validUserData)) {
                $sess_data[ADMIN_SESSION_NAME] = array(
                    'userId' => $validUserData->id,
                    'userName' => $validUserData->user_name,
                    'name'  => $validUserData->name,
                    'userType'  => $validUserData->usertype
                );

                $this->session->set_userdata($sess_data);
                redirect('admin/dashboard');

            }else {
                $this->session->set_flashdata('alert', ['message' => 'Incorrect username or password!', 'type' => 'danger']);
                redirect('admin/login');
            }
        }
        else {

            $arrViewParams = array();
            $arrViewParams['pageTitle'] = "Admin Log In";
            $arrViewParams['pageCode'] = "AL";
            
            // Function call to display the view contents
            $this->load->adminPages('login', $arrViewParams);
        }
    }    
}
