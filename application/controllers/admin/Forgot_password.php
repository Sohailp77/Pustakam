<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forgot_password extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    // Default function
    public function index()
    {
        $intAdminUserId = 1;
        $objAdminEmail = $this->db->select('email')->where('id', $intAdminUserId)->get('admin_user')->row();

        if($objAdminEmail && !empty($objAdminEmail->email)){

            $forgotCode = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $forgotKey = substr(str_shuffle($forgotCode), 0, 6);
            $forgotKey = sha1($forgotKey);

            $resetLink = site_url() . "reset_password?k=" . $forgotKey;

            $arrMailData = array();
            $arrMailData['resetePwdLink'] = $resetLink;

            $strEmail = $objAdminEmail->email;

            $strEmailHTML = $this->load->view('email/email_header', '', true);
            $strEmailHTML .= $this->load->view('email/password_restet_email', $arrMailData, true);
            $strEmailHTML .= $this->load->view('email/email_footer', '', true);

            // Send email to Vendor
            $mailSubject = "BEYOUTIK | Reset Password";
            $mail = Send_mail($strEmail, $mailSubject, $strEmailHTML);

            // Update key in database.
            $this->db->where('id', $intAdminUserId)->update('admin_user', array('forgot_key' => $forgotKey));

            $this->session->set_flashdata('alert', ['message' => 'Reset password link has been sent to your email successfully.', 'type' => 'success']);
        }
        else{
            $this->session->set_flashdata('alert', ['message' => 'Could not complete your request. Please try again later!', 'type' => 'danger']);
        }

        redirect(base_url('admin/login'));
    }

    // Default function
    public function reset()
    {

        $this->load->model('Admin_login_model');

        // Validate for forgot key parameter
        $forgotKey = $this->input->get('k');
        $flExist = $this->db->select('id')->where('forgot_key', $forgotKey)->from('admin_user')->count_all_results();

        if($flExist){

            $txtNewPassword = $this->input->post('txtPassword');

            $this->form_validation->set_rules("txtPassword", "New Password", "trim|required");
            $this->form_validation->set_rules("txtConfirmPassword", "Confirm Password", "trim|required|matches[txtPassword]");
            $this->form_validation->set_error_delimiters('<p><span class="text-danger">', '</span><p>');

            if($this->form_validation->run() == TRUE) {

                $arrUpdateParams = array(
                                "password" => sha1($txtNewPassword),
                                "forgot_key" => NULL
                              );

                $this->Admin_login_model->updatePassword(1, $arrUpdateParams);

                $this->session->set_flashdata('alert', ['message' => 'Admin password updated successfully.', 'type' => 'success']);
                redirect('login');
            }
            else {

                $arrViewParams = array();
                $arrViewParams['pageTitle'] = "Reset Password";
                $arrViewParams['pageCode'] = "RP";
                
                // Function call to display the view contents
                $this->load->adminPages('reset_password', $arrViewParams);
            }
        }
        else{
            redirect('login');
        }
    }
}
