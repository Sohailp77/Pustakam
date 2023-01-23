<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_pages extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
      redirect('admin/logout');
    }

    $this->load->model('Admin_pages_model');
    $this->load->model('Common_model');
  }

  // Default function
  public function index()
  {

    $setAction = $this->input->post('setAction');

    // List the records through data table ajax call.
    if ($setAction == "ListRecord") {

      $draw = $this->input->post('draw');
      $row = $this->input->post('start');
      $rowperpage = $this->input->post('length'); // Rows display per page
      $columnIndex = $this->input->post('order')[0]['column']; // Column index
      $columnName = $this->input->post('columns')[$columnIndex]['data']; // Column name
      $columnSortOrder = $this->input->post('order')[0]['dir']; // asc or desc
      $searchValue = $this->input->post('search')['value']; // Search value

      // get the total records from user group table.
      $totalRecords = $this->db->where('parent_module_id', 0)->where('deleted_at IS NULL', NULL, FALSE)->from('admin_modules')->count_all_results();

      $arr_page_params = array();
      $arr_page_params['SEARCH'] = $searchValue;
      $arr_page_params['SORTBY'] = $columnName;
      $arr_page_params['ORDERBY'] = $columnSortOrder;
      $arr_page_params['PARENTID'] = 0;

      // get the result count with filters and without limit.
      $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

      $total_pages = 0;
      if ($obj_admin_pages) {
        $total_pages = count($obj_admin_pages);
      }

      $arr_page_params['START'] = $row;
      $arr_page_params['LIMIT'] = $rowperpage;

      $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

      $arr_admin_pages = array();
      $intCount = 0;
      if ($obj_admin_pages) {

        foreach ($obj_admin_pages as $obj_page_info) {

          $str_sub_url = site_url("admin/admin_pages/sub_items/" . $obj_page_info->module_id);

          $arr_admin_pages[$intCount]['CO'] = htmlentities($obj_page_info->controller_name);

          $arr_admin_pages[$intCount]['TL'] = "<a href=\"" . $str_sub_url . "\">" . htmlentities($obj_page_info->title) . "</a>";

          $updateLink = "<a href=\"" . site_url('admin/admin_pages/update/' . $obj_page_info->module_id) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
          
          $deleteLink = "<a href=\"" . site_url('admin/admin_pages/delete/' . $obj_page_info->module_id) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";

          $arr_admin_pages[$intCount]['BN'] = $updateLink . $deleteLink;

          $intCount++;
        }
      }

      // Response
      $arrResponse = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $total_pages,
        "aaData" => $arr_admin_pages
      );

      print(json_encode($arrResponse));
      exit;
    }

    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Menu" => "");
    $arrViewParams['pageTitle'] = "Admin Pages";
    $arrViewParams['pageCode'] = "ADP";

    // Function call to display the view contents
    $this->load->adminPages('admin_pages/list', $arrViewParams);
  }

  // Function to display add screen
  public function create()
  {

    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Menu" => "", "Admin Pages" => site_url('admin/admin_pages'));
    $arrViewParams['pageTitle'] = "Add Admin Page";
    $arrViewParams['pageCode'] = "AAP";
    $arrViewParams['action'] = site_url('admin/admin_pages/create_action');
    $arrViewParams['txt_name'] = set_value('txt_name');
    $arrViewParams['txt_controller'] = set_value('txt_controller');

    // Function call to display the view contents
    $this->load->adminPages('admin_pages/form', $arrViewParams);
  }

  // Function to insert filter category info
  public function create_action()
  {
    $this->form_validation->set_rules('txt_name', 'Title', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_controller', 'Controller', 'trim|required|max_length[255]');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arr_insert_params = array(
        "title" => $this->input->post('txt_name'),
        "controller" => $this->input->post('txt_controller'),
        "parent_module_id" => 0
      );

      if ($this->Admin_pages_model->insert_admin_page($arr_insert_params)) {
        $this->session->set_flashdata('alert', ['message' => 'Admin page added successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'Admin page NOT added successfully.', 'type' => 'danger']);
      }

      redirect(site_url('admin/admin_pages'));
    } else {
      $this->create();
    }
  }

  // Function to display form with existing details.
  public function update($id = NULL)
  {
    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if ($obj_admin_pages) {

      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Menu" => "", "Admin Page" => site_url('admin/admin_pages'));
      $arrViewParams['pageTitle'] = "Update Admin Page";
      $arrViewParams['pageCode'] = "UAP";
      $arrViewParams['action'] = site_url('admin/admin_pages/update_action/' . $id);
      $arrViewParams['txt_name'] = set_value('txt_name', $obj_admin_pages[0]->title);
      $arrViewParams['txt_controller'] = set_value('txt_controller', $obj_admin_pages[0]->controller_name);

      // Function call to display the view contents
      $this->load->adminPages('admin_pages/form', $arrViewParams);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
      redirect(site_url('admin/admin_pages'));
    }
  }

  // Function to update system variable values.
  public function update_action($id = NULL)
  {

    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if (!isset($id) || !is_numeric($id) || $id < 0 || !isset($obj_admin_pages[0])) {
      redirect('admin/admin_pages');
    }

    $this->form_validation->set_rules('txt_name', 'Title', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_controller', 'Controller', 'trim|required|max_length[255]');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arr_update_params = array(
        "title" => $this->input->post('txt_name'),
        "controller" => $this->input->post('txt_controller')
      );

      if ($this->Admin_pages_model->update_admin_page($id, $arr_update_params)) {
        $this->session->set_flashdata('alert', ['message' => 'Admin page updated successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'Admin page NOT updated successfully.', 'type' => 'danger']);
      }

      redirect(site_url('admin/admin_pages'));
    } else {
      $this->update($id);
    }
  }

  // Function to delete system variable.
  public function delete($id = NULL)
  {

    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if ($obj_admin_pages) {
      $this->Admin_pages_model->delete_admin_page($id);
      $this->session->set_flashdata('alert', ['message' => 'Admin page deleted successfully.', 'type' => 'success']);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Admin page NOT deleted successfully!', 'type' => 'danger']);
    }

    redirect(site_url('admin/admin_pages'));
  }

  // Filter item listing function
  public function sub_items($module_id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    // Get action type as array.
    $arr_action_type = $this->Common_model->get_action_type();

    $setAction = $this->input->post('setAction');

    // get the total records from user group table.
    $totalRecords = $this->db->where('parent_module_id', $module_id)->where('deleted_at IS NULL', NULL, FALSE)->from('admin_modules')->count_all_results();

    // List the records through data table ajax call.
    if ($setAction == "ListRecord") {

      $draw = $this->input->post('draw');
      $row = $this->input->post('start');
      $rowperpage = $this->input->post('length'); // Rows display per page
      $columnIndex = $this->input->post('order')[0]['column']; // Column index
      $columnName = $this->input->post('columns')[$columnIndex]['data']; // Column name
      $columnSortOrder = $this->input->post('order')[0]['dir']; // asc or desc
      $searchValue = $this->input->post('search')['value']; // Search value

      $arr_page_params = array();
      $arr_page_params['SEARCH'] = $searchValue;
      $arr_page_params['SORTBY'] = $columnName;
      $arr_page_params['ORDERBY'] = $columnSortOrder;
      $arr_page_params['PARENTID'] = $module_id;

      // get the result count with filters and without limit.
      $obj_page_items = $this->Admin_pages_model->get_admin_pages($arr_page_params);

      $total_items = 0;
      if ($obj_page_items) {
        $total_items = count($obj_page_items);
      }

      $arr_page_params['START'] = $row;
      $arr_page_params['LIMIT'] = $rowperpage;

      $obj_page_items = $this->Admin_pages_model->get_admin_pages($arr_page_params);

      $arr_admin_pages = array();
      $intCount = 0;
      if ($obj_page_items) {

        foreach ($obj_page_items as $obj_page_item_info) {

          $arr_admin_pages[$intCount]['TL'] = htmlentities($obj_page_item_info->title);
          $arr_admin_pages[$intCount]['CO'] = htmlentities($obj_page_item_info->controller_name);
          $arr_admin_pages[$intCount]['FU'] = htmlentities($obj_page_item_info->function);
          $arr_admin_pages[$intCount]['AT'] = (isset($arr_action_type[$obj_page_item_info->action_type])) ? $arr_action_type[$obj_page_item_info->action_type] : "";

          $updateLink = "<a href=\"" . site_url('admin/admin_pages/update_item/' . $module_id . "/" . $obj_page_item_info->module_id) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
         
          $deleteLink = "<a href=\"" . site_url('admin/admin_pages/delete_item/' . $module_id . "/" . $obj_page_item_info->module_id) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";

          $arr_admin_pages[$intCount]['BN'] = $updateLink . $deleteLink;

          $intCount++;
        }
      }

      // Response
      $arrResponse = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $total_items,
        "aaData" => $arr_admin_pages
      );

      print(json_encode($arrResponse));
      exit;
    }

    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Menu" => "", "Admin Pages" => site_url('admin/admin_pages'));

    $arrViewParams['pageTitle'] = "Admin Sub Pages";
    $arrViewParams['pageCode'] = "ASP";
    $arrViewParams['parent_id'] = $module_id;
    $arrViewParams['total_records'] = $totalRecords;

    // Function call to display the view contents
    $this->load->adminPages('admin_pages/item_list', $arrViewParams);
  }

  // Function to display add screen
  public function create_item($module_id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Menu" => "", "Admin Pages" => site_url('admin/admin_pages'), "Admin Sub Pages" => site_url('admin/admin_pages/sub_items/' . $module_id));
    $arrViewParams['pageTitle'] = "Add Sub Page";
    $arrViewParams['pageCode'] = "AASP";
    $arrViewParams['action'] = site_url('admin/admin_pages/create_item_action/' . $module_id);
    $arrViewParams['txt_name'] = set_value('txt_name');
    $arrViewParams['txt_controller'] = set_value('txt_controller');
    $arrViewParams['txt_function'] = set_value('txt_function');
    $arrViewParams['lst_action_type'] = set_value('lst_action_type');
    $arrViewParams['module_id'] = $module_id;
    $arrViewParams['arr_action_types'] = $this->Common_model->get_action_type();

    // Function call to display the view contents
    $this->load->adminPages('admin_pages/item_form', $arrViewParams);
  }

  // Function to insert filter category info
  public function create_item_action($module_id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    $this->form_validation->set_rules('txt_name', 'Title', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_controller', 'Controller', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_function', 'Function', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('lst_action_type', 'Action Type', 'trim|required');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arr_insert_params = array(
        "parent_module_id" => $module_id,
        "title" => $this->input->post('txt_name'),
        "controller" => $this->input->post('txt_controller'),
        "function" => $this->input->post('txt_function'),
        "action_type" => $this->input->post('lst_action_type')
      );

      if ($this->Admin_pages_model->insert_admin_page($arr_insert_params)) {
        $this->session->set_flashdata('alert', ['message' => 'Sub page added successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'Sub page NOT added successfully.', 'type' => 'danger']);
      }

      redirect(site_url('admin/admin_pages/sub_items/' . $module_id));
    } else {
      $this->create_item();
    }
  }

  // Function to display form with existing details.
  public function update_item($module_id = 0, $id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if ($obj_admin_pages) {

      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Menu" => "", "Admin Pages" => site_url('admin/admin_pages'), "Admin Sub Pages" => site_url('admin/admin_pages/sub_items/' . $module_id));
      $arrViewParams['pageTitle'] = "Update Sub Page";
      $arrViewParams['pageCode'] = "USP";
      $arrViewParams['action'] = site_url('admin/admin_pages/update_item_action/' . $module_id . "/" . $id);
      $arrViewParams['txt_name'] = set_value('txt_name', $obj_admin_pages[0]->title);
      $arrViewParams['txt_controller'] = set_value('txt_controller', $obj_admin_pages[0]->controller_name);
      $arrViewParams['txt_function'] = set_value('txt_function', $obj_admin_pages[0]->function);
      $arrViewParams['lst_action_type'] = set_value('lst_action_type', $obj_admin_pages[0]->action_type);
      $arrViewParams['module_id'] = $module_id;
      $arrViewParams['arr_action_types'] = $this->Common_model->get_action_type();

      // Function call to display the view contents
      $this->load->adminPages('admin_pages/item_form', $arrViewParams);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
      redirect(site_url('admin/admin_pages/sub_items/' . $module_id));
    }
  }

  // Function to update system variable values.
  public function update_item_action($module_id = 0, $id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if (!isset($id) || !is_numeric($id) || $id < 0 || !isset($obj_admin_pages[0])) {
      redirect('admin/admin_pages');
    }

    $this->form_validation->set_rules('txt_name', 'Title', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_controller', 'Controller', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txt_function', 'Function', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('lst_action_type', 'Action Type', 'trim|required');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arr_update_params = array(
        "title" => $this->input->post('txt_name'),
        "controller" => $this->input->post('txt_controller'),
        "function" => $this->input->post('txt_function'),
        "action_type" => $this->input->post('lst_action_type')
      );

      if ($this->Admin_pages_model->update_admin_page($id, $arr_update_params)) {
        $this->session->set_flashdata('alert', ['message' => 'Sub page updated successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'Sub page NOT updated successfully.', 'type' => 'danger']);
      }

      redirect(site_url('admin/admin_pages/sub_items/' . $module_id));
    } else {
      $this->update_item($id);
    }
  }

  // Function to delete system variable.
  public function delete_item($module_id = 0, $id = 0)
  {

    if ($module_id <= 0 || !is_numeric($module_id)) {
      redirect(site_url('admin/admin_pages'));
    }

    // Params to fetch system variable
    $arr_page_params = array();
    $arr_page_params['MODULEID'] = $id;

    $obj_admin_pages = $this->Admin_pages_model->get_admin_pages($arr_page_params);

    if ($obj_admin_pages) {
      $this->Admin_pages_model->delete_admin_page($id);
      $this->session->set_flashdata('alert', ['message' => 'Sub page deleted successfully.', 'type' => 'success']);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Sub page NOT deleted successfully!', 'type' => 'danger']);
    }

    redirect(site_url('admin/admin_pages/sub_items/' . $module_id));
  }
}
