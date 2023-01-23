<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Map extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/logout');
        }

        $this->load->model('Map_model');
        $this->load->model('Common_model');
    }
    // Default function
    public function index($ParentId = 0)
    {
       
        $objMap = $this->Map_model->getMap($arrMapParams);
        $arrMap = array();
        $intCount = 0;
        if ($objMap) {

            $update = $this->Common_model->get_moduleId('Map', 'update');
            $delete = $this->Common_model->get_moduleId('Map', 'delete');

            foreach ($objMap as $objMapInfo) {

                $arrMap[$intCount]['TT'] = htmlentities($objMapInfo->state);
                $arrMap[$intCount]['CD'] = htmlentities($objMapInfo->coords);
                $arrMap[$intCount]['LG'] = htmlentities($objMapInfo->language);
                $arrMap[$intCount]['DS'] = htmlentities($objMapInfo->description);
                $arrMap[$intCount]['ST'] = ($objMapInfo->status == "Y") ? "Active" : "Inactive";

                if (in_array($update->module_id, $this->session->permission)) {
                    $updateLink = "<a href=\"" . site_url('admin/map/update/' . $objMapInfo->mid) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
                } else {
                    $updateLink = "";
                }
                if (in_array($delete->module_id, $this->session->permission)) {
                    $deleteLink = "<a href=\"" . site_url('admin/map/delete/' . $objMapInfo->mid) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
                } else {
                    $deleteLink = "";
                }

                $arrMap[$intCount]['BN'] = "<ul class=\"list-inline mb-0\"> <li class=\"list-inline-item dropdown\">" . $updateLink . "</li>
                     <li class=\"list-inline-item dropdown\">" . $deleteLink . "</li></ul>";

                $intCount++;
            }
        }

        $arrStatus = array(
            "Y" => "Active",
            "N" => "Inactive",
        );

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['parentPage'] = "Catalogue";
        $arrViewParams['pageTitle'] = "Map";
        $arrViewParams['pageCode'] = "MP";
        $arrViewParams['arrStatus'] = $arrStatus;
        $arrViewParams['userStatus'] = $Status;
        $arrViewParams['arrMap']=$arrMap;

        // Function call to display the view contents
        $this->load->adminPages('map/list', $arrViewParams);
    }
    // Function to display add screen
    public function create()
    {
        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Map" => site_url('admin/map'));
        $arrViewParams['pageTitle'] = "Add Map";
        $arrViewParams['pageCode'] = "AM";
        $arrViewParams['action'] = site_url('admin/map/create_action');
        $arrViewParams['mid'] = set_value('mid');
        $arrViewParams['state'] = set_value('state');
        $arrViewParams['coords'] = set_value('coords');
        $arrViewParams['language'] = set_value('language');
        $arrViewParams['description'] = set_value('description');
        $arrViewParams['status'] = set_value('status','Y');

        // Function call to display the view contents
        $this->load->adminPages('map/form', $arrViewParams);
    }
    // Function to insert/update user group info
    public function create_action()
    {
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('coords', 'Map Coordinates', 'trim|required');
        $this->form_validation->set_rules('language', 'Language', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) {

            $arrInsertParams = array(
                "state" => $this->input->post('state'),
                "coords" => $this->input->post('coords'),
                "language" => $this->input->post('language'),
                "description" => $this->input->post('description'),
                "status" => $this->input->post('status'),
            );
            if ($this->Map_model->insert($arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record added successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT added successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/map'));
        } else {
            $this->create();
        }
    }
    // Function to display form with existing details.
    public function update($id = NULL)
    {
        $row = $this->Map_model->get_by_id($id);
        if ($row) {
            // Pass view params
            $arrViewParams = array();
            $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Map" => site_url('admin/map'));
            $arrViewParams['pageTitle'] = "Update Map";
            $arrViewParams['pageCode'] = "UM";
            $arrViewParams['action'] = site_url('admin/map/update_action');
            $arrViewParams['mid'] = set_value('mid', $row->mid);
            $arrViewParams['state'] = set_value('state', $row->state);
            $arrViewParams['coords'] = set_value('coords', $row->coords);
            $arrViewParams['language'] = set_value('language', $row->language);
            $arrViewParams['description'] = set_value('description', $row->description);
            $arrViewParams['status'] = set_value('status', $row->status);
            // Function call to display the view contents
            $this->load->adminPages('map/form', $arrViewParams);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
            redirect(site_url('admin/map'));
        }
    }
    // Function to update user group values.
    public function update_action()
    {
        $mid = $this->input->post('mid');
        $this->form_validation->set_rules('state', 'State', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('coords', 'Map Coordinates', 'trim|required');
        $this->form_validation->set_rules('language', 'Language', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($mid);
        } else {

            $arrInsertParams = array(
                "state" => $this->input->post('state'),
                "coords" => $this->input->post('coords'),
                "language" => $this->input->post('language'),
                "description" => $this->input->post('description'),
                "status" => $this->input->post('status'),
            );
            if ($this->Map_model->update($mid, $arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record updated successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT updated successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/map'));
        }
    }
    
    // Function to delete 
    public function delete($id)
    {
        $data = array(
            'deleted_at' => date("Y-m-d H:i:s")
        );
        if ($this->Map_model->update($id, $data)) {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Success', 'type' => 'success']);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Failed', 'type' => 'danger']);
        }
        redirect(site_url('admin/map'));
    }
}
