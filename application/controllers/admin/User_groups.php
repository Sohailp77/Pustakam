<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_groups extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
      redirect('admin/logout');
    }

    $this->load->model('User_groups_model');
    $this->load->model('Common_model');
  }

  // Default function
  public function index()
  {

    $fltrDateFrom = $this->input->get('datefrom');
    $fltrDateTo = $this->input->get('dateto');
    $setAction = $this->input->post('setAction');

    // List the records through data table ajax call.
    if ($setAction == "ListRecord") {

      $fltrDateFrom = $this->input->post('datefrom');
      $fltrDateTo = $this->input->post('dateto');
      // Date filter
      if (empty($fltrDateFrom)) {
        $fltrDateFrom = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1);
        $fltrDateFrom = date("d/m/Y", $fltrDateFrom);
      }

      if (empty($fltrDateTo)) {
        $fltrDateTo = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $fltrDateTo = date("d/m/Y", $fltrDateTo);
      }

      // Convert to database format.
      $arrFltrDateFrom = explode("/", $fltrDateFrom);
      $formattedDateFrom = $arrFltrDateFrom[2] . "-" . $arrFltrDateFrom[1] . "-" . $arrFltrDateFrom[0];

      $arrFltrDateTo = explode("/", $fltrDateTo);
      $formattedDateTo = $arrFltrDateTo[2] . "-" . $arrFltrDateTo[1] . "-" . $arrFltrDateTo[0];


      $draw = $this->input->post('draw');
      $row = $this->input->post('start');
      $rowperpage = $this->input->post('length'); // Rows display per page
      $columnIndex = $this->input->post('order')[0]['column']; // Column index
      $columnName = $this->input->post('columns')[$columnIndex]['data']; // Column name
      $columnSortOrder = $this->input->post('order')[0]['dir']; // asc or desc
      $searchValue = $this->input->post('search')['value']; // Search value

      // get the total records from user group table.
      $totalRecords = $this->db->where('deleted_at IS NULL', NULL, FALSE)->from('admin_usergroups')->count_all_results();

      $arrGroupParams = array();
      $arrGroupParams['SEARCH'] = $searchValue;
      $arrGroupParams['SORTBY'] = $columnName;
      $arrGroupParams['ORDERBY'] = $columnSortOrder;
      $arrUserParams['DATEFROM'] = $formattedDateFrom;
      $arrUserParams['DATETO'] = $formattedDateTo;

      // get the result count with filters and without limit.
      $objUserGroups = $this->User_groups_model->getUserGroups($arrGroupParams);
     
      $intTotalFilterRecs = 0;
      if ($objUserGroups) {
        $intTotalFilterRecs = count($objUserGroups);
      }

      $arrGroupParams['START'] = $row;
      $arrGroupParams['LIMIT'] = $rowperpage;

      $objUserGroups = $this->User_groups_model->getUserGroups($arrGroupParams);

      $arrUserGroups = array();
      $intCount = 0;
      if ($objUserGroups) {
        $update = $this->Common_model->get_moduleId('User_groups', 'update');
        $delete = $this->Common_model->get_moduleId('User_groups', 'delete');
        $permission = $this->Common_model->get_moduleId('User_groups', 'group_permission');

        foreach ($objUserGroups as $objUserGroupInfo) {
          $arrUserGroups[$intCount]['DT'] = htmlentities($objUserGroupInfo->createdDate);
          $arrUserGroups[$intCount]['NM'] = htmlentities($objUserGroupInfo->userGroupName);

          if (in_array($update->module_id, $this->session->permission)) {
            $updateLink = "<a href=\"" . site_url('admin/user_groups/update/' . $objUserGroupInfo->userGroupId) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
          } else {
            $updateLink = "";
          }
          if (in_array($delete->module_id, $this->session->permission)) {
            $deleteLink = "<a href=\"" . site_url('admin/user_groups/delete/' . $objUserGroupInfo->userGroupId) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
          } else {
            $deleteLink = "";
          }
          if (in_array($permission->module_id, $this->session->permission)) {
            $permissionLink = "<a href=\"" . site_url('admin/user_groups/group_permission/' . $objUserGroupInfo->userGroupId) . "\" class=\"px-3 text-danger\" title=\"Permission\"><i class=\"fa fa-key font-size-18\"></i></a>";
          } else {
            $permissionLink = "";
          }

          $arrUserGroups[$intCount]['BN'] = $updateLink . $deleteLink . $permissionLink;

          $intCount++;
        }
      }

      // Response
      $arrResponse = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $intTotalFilterRecs,
        "aaData" => $arrUserGroups
      );

      print(json_encode($arrResponse));
      exit;
    }
    if (empty($fltrDateFrom)) {
      $fltrDateFrom = mktime(0, 0, 0, date("m"), date("d"), date("Y") - 1);
      $fltrDateFrom = date("d/m/Y", $fltrDateFrom);
    }

    if (empty($fltrDateTo)) {
      $fltrDateTo = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
      $fltrDateTo = date("d/m/Y", $fltrDateTo);
    }
    // Pass view params
    $arrViewParams = array();
    $arrViewParams['parentPage'] = "Apps";
    $arrViewParams['pageTitle'] = "User Groups";
    $arrViewParams['pageCode'] = "UG";
    $arrViewParams['fltrDateFrom'] = $fltrDateFrom;
    $arrViewParams['fltrDateTo'] = $fltrDateTo;

    // Function call to display the view contents
    $this->load->adminPages('user_groups/list', $arrViewParams);
  }

  // Function to display add screen
  public function create()
  {
    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Apps" => "", "User Groups" => site_url('user_groups'));
    $arrViewParams['pageTitle'] = "Add User Group";
    $arrViewParams['pageCode'] = "AUG";
    $arrViewParams['action'] = site_url('admin/user_groups/create_action');
    $arrViewParams['txtId'] = set_value('txtId');
    $arrViewParams['txtName'] = set_value('txtName');

    // Function call to display the view contents
    $this->load->adminPages('user_groups/form', $arrViewParams);
  }
  // Function to insert/update user group info
  public function create_action()
  {
    $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arrInsertParams = array(
        "name" => $this->input->post('txtName'),
        "created_date" => date("Y-m-d H:i:s")
      );
      if ($this->User_groups_model->insert($arrInsertParams)) {
        $this->session->set_flashdata('alert', ['message' => 'User group added successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'User group NOT added successfully.', 'type' => 'danger']);
      }

      redirect(site_url('admin/user_groups'));
    } else {
      $this->create();
    }
  }

  // Function to display form with existing details.
  public function update($id = NULL)
  {
    $row = $this->User_groups_model->get_by_id($id);
    if ($row) {
      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Apps" => "", "User Groups" => site_url('user_groups'));
      $arrViewParams['pageTitle'] = "Update User Group";
      $arrViewParams['pageCode'] = "UUG";
      $arrViewParams['action'] = site_url('admin/user_groups/update_action/' . $id);
      $arrViewParams['txtId'] = set_value('txtId', $row->id);
      $arrViewParams['txtName'] = set_value('txtName', $row->name);

      // Function call to display the view contents
      $this->load->adminPages('user_groups/form', $arrViewParams);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
      redirect(site_url('admin/user_groups'));
    }
  }

  // Function to update user group values.
  public function update_action()
  {
    $id = $this->input->post('txtId');
    $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == FALSE) {
      $this->update($id);
    } else {
      $data = array(
        "name" => $this->input->post('txtName'),
      );
      if ($this->User_groups_model->update($id, $data)) {
        $this->session->set_flashdata('alert', ['message' => 'User group updated successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'User group NOT updated successfully.', 'type' => 'danger']);
      }
      redirect(site_url('admin/user_groups'));
    }
  }

  // Function to delete 
  public function delete($id)
  {
    $data = array(
      'deleted_at' => date("Y-m-d H:i:s")
    );
    if ($this->User_groups_model->update($id, $data)) {
      $this->session->set_flashdata('alert', ['message' => 'Delete User group Success', 'type' => 'success']);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Delete User group Failed', 'type' => 'danger']);
    }
    redirect(site_url('admin/user_groups'));
  }
  public function group_permission($id)
  {
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Apps" => "", "User Groups" => site_url('user_groups'));
    $arrViewParams['pageTitle'] = "Group Permissions";
    $arrViewParams['pageCode'] = "GP";
    $arrViewParams['action'] = site_url('admin/user_groups/group_permission_action');
    $arrViewParams['groupId'] = $id;
    $arrViewParams['objParentModules'] = $this->User_groups_model->get_modules();
    $arrViewParams['objSubModules'] =  $this->User_groups_model->get_user_module_names($id);

    // Function call to display the view contents
    $this->load->adminPages('user_groups/permissions', $arrViewParams);
  }
  public function group_permission_action()
  {
    $groupId = $this->input->post('groupId', true);
    $objParentModules = $this->User_groups_model->get_modules();
    $objSubModules = $this->User_groups_model->get_sub_modules();
    $arrDeletePermission = array();
    $arrInsertPermission = array();
    foreach ($objParentModules as $objParentModuleInfo) {
      $chkView = $this->input->post("chk_view_" . $objParentModuleInfo->module_id);
      $chkAdd = $this->input->post("chk_add_" . $objParentModuleInfo->module_id);
      $chkEdit = $this->input->post("chk_edit_" . $objParentModuleInfo->module_id);
      $chkDelete = $this->input->post("chk_delete_" . $objParentModuleInfo->module_id);
      $intCount = 0;
      foreach ($objSubModules as $objSubModuleInfo) {
        if ($objSubModuleInfo->parent_module_id == $objParentModuleInfo->module_id) {
          if (!empty($chkView) && $objSubModuleInfo->action_type == "VW") {

            $arrInsertPermission[$intCount]['usergroups_id_fk'] =  $this->input->post('groupId', TRUE);
            $arrInsertPermission[$intCount]['module_id_fk'] = $objSubModuleInfo->module_id;
            $arrInsertPermission[$intCount]['created_by'] = $this->session->userdata(ADMIN_SESSION_NAME)['userId'];
            $arrInsertPermission[$intCount]['created_date'] = date('Y-m-d H:i:s');
          }
          if (!empty($chkAdd) && $objSubModuleInfo->action_type == "AD") {

            $arrInsertPermission[$intCount]['usergroups_id_fk'] =  $this->input->post('groupId', TRUE);
            $arrInsertPermission[$intCount]['module_id_fk'] = $objSubModuleInfo->module_id;
            $arrInsertPermission[$intCount]['created_by'] = $this->session->userdata(ADMIN_SESSION_NAME)['userId'];
            $arrInsertPermission[$intCount]['created_date'] = date('Y-m-d H:i:s');
          }
          if (!empty($chkEdit) && $objSubModuleInfo->action_type == "ED") {

            $arrInsertPermission[$intCount]['usergroups_id_fk'] = $this->input->post('groupId', TRUE);
            $arrInsertPermission[$intCount]['module_id_fk'] = $objSubModuleInfo->module_id;
            $arrInsertPermission[$intCount]['created_by'] = $this->session->userdata(ADMIN_SESSION_NAME)['userId'];
            $arrInsertPermission[$intCount]['created_date'] = date('Y-m-d H:i:s');
          }
          if (!empty($chkDelete) && $objSubModuleInfo->action_type == "DL") {

            $arrInsertPermission[$intCount]['usergroups_id_fk'] = $this->input->post('groupId', TRUE);
            $arrInsertPermission[$intCount]['module_id_fk'] = $objSubModuleInfo->module_id;
            $arrInsertPermission[$intCount]['created_by'] = $this->session->userdata(ADMIN_SESSION_NAME)['userId'];
            $arrInsertPermission[$intCount]['created_date'] = date('Y-m-d H:i:s');
          }
        }

        $intCount++;
      }
    }
    $this->User_groups_model->delete_permission($groupId);
    if ($this->User_groups_model->insert_permission($arrInsertPermission)) {
      $this->session->set_flashdata('alert', ['message' => 'Group permission updated  Successfully', 'type' => 'success']);
      redirect(site_url('admin/user_groups'));
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Group permission updation Failed', 'type' => 'danger']);
      redirect(site_url('admin/user_groups'));
    }
  }
}
