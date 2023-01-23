<?php
defined('BASEPATH') or exit('No direct script access allowed');

class System_settings extends CI_Controller
{
    function __construct()
    {
      parent::__construct();

      if(!$this->session->userdata(ADMIN_SESSION_NAME)) {
          redirect('admin/logout');
      }

      $this->load->model('System_model');
      $this->load->model('Common_model');    
    }

    // Default function
    public function index()
    {

      $objSystemSettings = $this->System_model->getSystemSettings();
      
      // Pass view params
      $arrViewParams = array();
      $arrViewParams['parentPage'] = "Apps";
      $arrViewParams['pageTitle'] = "System Settings";
      $arrViewParams['pageCode'] = "SS";
      $arrViewParams['objSystemSettings'] = $objSystemSettings;

      // Function call to display the view contents
      $this->load->adminPages('system_settings/list', $arrViewParams);
    }

    // Function to display add screen
    public function create()
    {
      
      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Apps" => "", "System Settings" => site_url('system_settings'));
      $arrViewParams['pageTitle'] = "Add System Variable";
      $arrViewParams['pageCode'] = "ASV";
      $arrViewParams['action'] = site_url('admin/system_settings/create_action');
      $arrViewParams['txtCode'] = set_value('txtCode');
      $arrViewParams['txtName'] = set_value('txtName');
      $arrViewParams['txtValue'] = set_value('txtValue');

      // Function call to display the view contents
      $this->load->adminPages('system_settings/form', $arrViewParams);
    }

    public function checkCodeExist($strCode = ""){

        // Params to fetch system variable
        $arrSystemParams = array();
        $arrSystemParams['SYSTEMCODE'] = $strCode;

        $objSystemVar = $this->System_model->getSystemSettings($arrSystemParams);
        
        if($objSystemVar){
            $this->form_validation->set_message('checkCodeExist', 'The Code field must contain a unique value.');
            return false;
        }

        return true;
    }

    // Function to insert/update system variable info
    public function create_action($id = NULL)
    {
        $this->form_validation->set_rules('txtCode', 'Code', 'trim|required|max_length[5]|min_length[5]|callback_checkCodeExist[]');
        $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('txtValue', 'Value', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) {

            $arrInsertParams = array(
                                  "code" => $this->input->post('txtCode'),
                                  "name" => $this->input->post('txtName'),
                                  "value" => $this->input->post('txtValue'),
                                  "created_at" => date("Y-m-d H:i:s")
                                );

            if($this->System_model->insertSystemVariable($arrInsertParams)){
              $this->session->set_flashdata('alert', ['message' => 'System variable added successfully.', 'type' => 'success']);
            }
            else{
              $this->session->set_flashdata('alert', ['message' => 'System variable NOT added successfully.', 'type' => 'danger']);
            }

            redirect(site_url('admin/system_settings'));          
        }
        else{
          $this->create();
        }
    }

    // Function to display form with existing details.
    public function update($id = NULL)
    {
      // Params to fetch system variable
      $arrSystemParams = array();
      $arrSystemParams['SYSTEMID'] = $id;

      $objSystemVar = $this->System_model->getSystemSettings($arrSystemParams);

      if($objSystemVar) {

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Apps" => "", "System Settings" => site_url('system_settings'));
        $arrViewParams['pageTitle'] = "Update System Variable";
        $arrViewParams['pageCode'] = "USV";
        $arrViewParams['action'] = site_url('admin/system_settings/update_action/' . $id);
        $arrViewParams['txtCode'] = set_value('txtCode', $objSystemVar[0]->systemCode);
        $arrViewParams['txtName'] = set_value('txtName', $objSystemVar[0]->systemName);
        $arrViewParams['txtValue'] = set_value('txtValue', $objSystemVar[0]->systemValue);

        // Function call to display the view contents
        $this->load->adminPages('system_settings/form', $arrViewParams);          
      }
      else{
          $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
          redirect(site_url('system_settings'));
      }
    }

    // Function to update system variable values.
    public function update_action($id = NULL)
    {

      // Params to fetch system variable
      $arrSystemParams = array();
      $arrSystemParams['SYSTEMID'] = $id;

      $objSystemVar = $this->System_model->getSystemSettings($arrSystemParams);

      if(!isset($id) || !is_numeric($id) || $id < 0 || !isset($objSystemVar[0])){
        redirect('system_settings');
      }

      $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
      $this->form_validation->set_rules('txtValue', 'Value', 'trim|required');

      $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

      if ($this->form_validation->run() == TRUE) {

          $systemValue = $this->input->post('txtValue');

          $arrUpdateParams = array(
                                "name" => $this->input->post('txtName'),
                                "value" => $systemValue
                              );

          if($this->System_model->updateSystemVariable($id, $arrUpdateParams)){
            $this->session->set_flashdata('alert', ['message' => 'System variable updated successfully.', 'type' => 'success']);

            // Send email notification on contract address update.
            if($objSystemVar[0]->systemCode == "TRCAD" && ($objSystemVar[0]->systemValue != $systemValue)){

              // Params to fetch system variable
              $arrSystemParams = array();
              $arrSystemParams['SYSTEMCODE'] = 'CUEML';
              $arrSystemParams['FLDEVELOPER'] = true;

              $objSystemVarEmail = $this->System_model->getSystemSettings($arrSystemParams);

              $arrMailData = array();
              $arrMailData['oldAddress'] = $objSystemVar[0]->systemValue;
              $arrMailData['newAddress'] = $systemValue;

              $strEmailTo = $objSystemVarEmail[0]->systemValue;

              $strEmailHTML = $this->load->view('email/email_header', '', true);
              $strEmailHTML .= $this->load->view('email/contract_update_email', $arrMailData, true);
              $strEmailHTML .= $this->load->view('email/email_footer', '', true);

              // Send email to Vendor
              $mailSubject = "Tron Pay | Contract address updated";
              $mail = Send_mail($strEmailTo, $mailSubject, $strEmailHTML);
            }
          }
          else{
            $this->session->set_flashdata('alert', ['message' => 'System variable NOT updated successfully.', 'type' => 'danger']);
          }

          redirect(site_url('admin/system_settings'));          
      }
      else{
        $this->update($id);
      }
    }

    // Function to delete system variable.
    public function delete($id = NULL)
    {

      // Params to fetch system variable
      $arrSystemParams = array();
      $arrSystemParams['SYSTEMID'] = $id;

      $objSystemVar = $this->System_model->getSystemSettings($arrSystemParams);

      if($objSystemVar) {
          $this->System_model->deleteSystemVariable($id);
          $this->session->set_flashdata('alert', ['message' => 'System variable deleted successfully.', 'type' => 'success']);
      } else {
          $this->session->set_flashdata('alert', ['message' => 'System variable NOT deleted successfully!', 'type' => 'danger']);
      }

      redirect(site_url('admin/system_settings'));
    }
}
