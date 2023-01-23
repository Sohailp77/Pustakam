<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Standard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/logout');
        }

        $this->load->model('Standard_model');
        $this->load->model('Common_model');
    }
    // Default function
    public function index()
    {

      $objStandard = $this->Standard_model->getStandard($arrUserParams);

      $arrStandard = array();
      $intCount = 0;
      if ($objStandard) {

          $update = $this->Common_model->get_moduleId('Standard', 'update');
          $delete = $this->Common_model->get_moduleId('Standard', 'delete');

          foreach ($objStandard as $objUserInfo) {

              $arrStandard[$intCount]['CN'] = htmlentities($objUserInfo->classname);
              $arrStandard[$intCount]['ST'] = ($objUserInfo->status == "Y") ? "Active" : "Inactive";
              $arrStandard[$intCount]['SO'] = htmlentities($objUserInfo->sort_order);

              if (in_array($update->module_id, $this->session->permission)) {
                  $updateLink = "<a href=\"" . site_url('admin/standard/update/' . $objUserInfo->cid) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
              } else {
                  $updateLink = "";
              }
              if (in_array($delete->module_id, $this->session->permission)) {
                  $deleteLink = "<a href=\"" . site_url('admin/standard/delete/' . $objUserInfo->cid) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
              } else {
                  $deleteLink = "";
              }

              $arrStandard[$intCount]['BN'] = $updateLink . $deleteLink;

              $intCount++;
          }
      }

         



        // Pass view params
        $arrViewParams = array();
        $arrViewParams['parentPage'] = "Catalogue";
        $arrViewParams['pageTitle'] = "Standard";
        $arrViewParams['pageCode'] = "STD";
        $arrViewParams['arrStandard']=$arrStandard;

        // Function call to display the view contents
        $this->load->adminPages('standard/list', $arrViewParams);
    }
    // Function to display add screen
    public function create()
    {
        $sortOrder = $this->Standard_model->getLastsortOrder();

        $Nxtsort = $sortOrder->lastSortOrder ? $sortOrder->lastSortOrder + 1 : '1';
        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Standard" => site_url('admin/standard'));
        $arrViewParams['pageTitle'] = "Add Standard";
        $arrViewParams['pageCode'] = "AC";
        $arrViewParams['action'] = site_url('admin/standard/create_action');
        $arrViewParams['cid'] = set_value('cid');
        $arrViewParams['classname'] = set_value('classname');
        $arrViewParams['status'] = set_value('status','Y');
        $arrViewParams['sort_order'] = set_value('sort_order', $Nxtsort);

        // Function call to display the view contents
        $this->load->adminPages('standard/form', $arrViewParams);
    }
    public function create_action()
    {
        $this->form_validation->set_rules('classname', 'Class Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) {

            // Get next product id
            $obj_last_standard = $this->db->select('cid')->order_by('cid', 'desc')->get('class')->row();

            $latest_standard_id = 0;
            if ($obj_last_standard) {
                $latest_standard_id = $obj_last_standard->cid;
            }

            $latest_standard_id++;

            $arrInsertParams = array(
                "classname" => $this->input->post('classname'),
                "status" =>  $this->input->post('status'),
                "sort_order" => $this->input->post('sort_order'),
            );
            if ($this->Standard_model->insert($arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record added successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT added successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/standard'));
        } else {
            $this->create();
        }
    }
    // Function to display form with existing details.
    public function update($id = NULL)
    {
        $row = $this->Standard_model->get_by_id($id);
        if ($row) {
            // Pass view params
            $arrViewParams = array();
            $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Standard" => site_url('admin/standard'));
            $arrViewParams['pageTitle'] = "Update Standard";
            $arrViewParams['pageCode'] = "US";
            $arrViewParams['action'] = site_url('admin/standard/update_action');
            $arrViewParams['cid'] = set_value('cid', $row->cid);
            $arrViewParams['classname'] = set_value('classname', $row->classname);
            $arrViewParams['status'] = set_value('status',$row->status);
            $arrViewParams['sort_order'] = set_value('sort_order', $row->sort_order);

            // Function call to display the view contents
            $this->load->adminPages('standard/form', $arrViewParams);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
            redirect(site_url('admin/standard'));
        }
    }
    public function update_action()
    {
        $this->form_validation->set_rules('classname', 'Class Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('sort_order', 'Sort Order', 'trim|required');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        $id = $this->input->post('cid');
        if ($this->form_validation->run() == TRUE) {
            

            $arrInsertParams = array(
                "classname" => $this->input->post('classname'),
                "sort_order" => $this->input->post('sort_order'),
                "status" => $this->input->post('status'),
            );
            if ($this->Standard_model->update($id, $arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record updated successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT updated successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/standard'));
        } else {
            $this->update();
        }
    }
    // Function to delete 
    public function delete($id)
    {
        $data = array(
            'deleted_at' => date("Y-m-d H:i:s")
        );
        if ($this->Standard_model->update($id, $data)) {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Success', 'type' => 'success']);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Failed', 'type' => 'danger']);
        }
        redirect(site_url('admin/standard'));
    }
    
}
