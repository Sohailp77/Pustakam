<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Update_password extends CI_Controller
{
    function __construct()
    {
      parent::__construct();

      if(!$this->session->userdata(ADMIN_SESSION_NAME)) {
          redirect('admin/logout');
      }

      $this->load->model('Admin_login_model');
      $this->load->model('Common_model');     
    }

    // Default function
    public function index()
    {
      
      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Profile" => "");
      $arrViewParams['pageTitle'] = "Update Password";
      $arrViewParams['pageCode'] = "UP";

      // Function call to display the view contents
      $this->load->adminPages('update_password', $arrViewParams);
    }

    public function checkOldPassword($oldPassword = ""){

      $flExist = $this->db->where(['id' => $this->session->userdata(ADMIN_SESSION_NAME)['userId'], 'password' => sha1($oldPassword)])->from('admin_users')->count_all_results();
        
        if(!$flExist){
            $this->form_validation->set_message('checkOldPassword', 'Could not verify your old password. Please try again.');
            return false;
        }

        return true;
    }

    // Update password
    public function update()
    {
      // get post values
      $txtNewPassword = $this->input->post('txtNewPassword');

      $this->form_validation->set_rules("txtOldPassword", "Old Password", "trim|required|callback_checkOldPassword[]");
      $this->form_validation->set_rules("txtNewPassword", "New Password", "trim|required");
      $this->form_validation->set_rules("txtConfirmPassword", "Confirm Password", "trim|required|matches[txtNewPassword]");
      $this->form_validation->set_error_delimiters('<p><span class="text-danger">', '</span><p>');

      if($this->form_validation->run() == TRUE) {

          $arrUpdateParams = array(
                          "password" => sha1($txtNewPassword)
                        );

          $this->Admin_login_model->updatePassword($this->session->userdata(ADMIN_SESSION_NAME)['userId'], $arrUpdateParams);

          $this->session->set_flashdata('alert', ['message' => 'Admin password updated successfully.', 'type' => 'success']);
      }

      $this->index();
    }
}
