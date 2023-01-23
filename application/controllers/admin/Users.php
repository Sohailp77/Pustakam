<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
  function __construct()
  {
    parent::__construct();

    if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
      redirect('admin/logout');
    }

    $this->load->model('Users_model');
    $this->load->model('User_groups_model');
    $this->load->model('Common_model');
  }

  // Default function
  public function index()
  {

    // get filter values
    $userGroupId = $this->input->get('group');
    $userStatus = $this->input->get('status');
    $fltrDateFrom = $this->input->get('datefrom');
    $fltrDateTo = $this->input->get('dateto');

    $setAction = $this->input->post('setAction');

    // Get all user groups
    $objUserGroups = $this->User_groups_model->getUserGroups();

    // List the records through data table ajax call.
    if($setAction == "ListRecord"){

      $userGroupId = $this->input->post('group');
      $userStatus = $this->input->post('status');
      $fltrDateFrom = $this->input->post('datefrom');
      $fltrDateTo = $this->input->post('dateto');

      // Get all percentage for history based on date.
      // Date filter
      if(empty($fltrDateFrom)){
          $fltrDateFrom = mktime(0, 0, 0, date("m"), date("d"), date("Y")-1);
          $fltrDateFrom = date("d/m/Y", $fltrDateFrom);
      }

      if(empty($fltrDateTo)){
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
      $totalRecords = $this->db->where('deleted_at IS NULL', NULL, FALSE)->from('admin_users')->count_all_results();

      $arrUserParams = array();
      $arrUserParams['SEARCH'] = $searchValue;
      $arrUserParams['SORTBY'] = $columnName;
      $arrUserParams['ORDERBY'] = $columnSortOrder;
      $arrUserParams['GROUPID'] = $userGroupId;
      $arrUserParams['STATUS'] = $userStatus;
      $arrUserParams['DATEFROM'] = $formattedDateFrom;
      $arrUserParams['DATETO'] = $formattedDateTo;

      // get the result count with filters and without limit.
      $objUsers = $this->Users_model->getUsers($arrUserParams);

      $intTotalFilterRecs = 0;
      if($objUsers){
        $intTotalFilterRecs = count($objUsers);
      }

      $arrUserParams['START'] = $row;
      $arrUserParams['LIMIT'] = $rowperpage;

      $objUsers = $this->Users_model->getUsers($arrUserParams);

      $arrUsers = array();
      $intCount = 0;
      if($objUsers){

        // Create user group array to get multiple user group name
        $arrUserGroups = array();
        if($objUserGroups){
          foreach($objUserGroups as $objUserGroupInfo){
            $arrUserGroups[$objUserGroupInfo->userGroupId] = $objUserGroupInfo->userGroupName;
          }
        } 

        $update = $this->Common_model->get_moduleId('Users', 'update');
        $delete = $this->Common_model->get_moduleId('Users', 'delete');
        
        foreach($objUsers as $objUserInfo){

          // Create string with multiple user group name
          $strUserGroups = "";
          if(!empty($objUserInfo->userGroupId)){
            $arrGroupIds = explode("&&", $objUserInfo->userGroupId);

            foreach($arrGroupIds as $userGroupId){
              if(isset($arrUserGroups[$userGroupId])){
                
                if(!empty($strUserGroups)){
                  $strUserGroups .= ", ";
                }

                $strUserGroups .= $arrUserGroups[$userGroupId];
              }
            }
          }

          $arrUsers[$intCount]['ID'] = htmlentities($objUserInfo->userId);
          $arrUsers[$intCount]['NM'] = htmlentities($objUserInfo->Name);
          $arrUsers[$intCount]['EM'] = htmlentities($objUserInfo->Email);
          $arrUsers[$intCount]['PH'] = htmlentities($objUserInfo->Phone);
          $arrUsers[$intCount]['UN'] = htmlentities($objUserInfo->userName);
          $arrUsers[$intCount]['GN'] = htmlentities($strUserGroups);
          $arrUsers[$intCount]['AC'] = ($objUserInfo->flActive == "Y") ? "Active" : "Inactive";
          $arrUsers[$intCount]['CD'] = htmlentities($objUserInfo->addedDate);


          if (in_array($update->module_id, $this->session->permission)) {
            $updateLink = "<a href=\"" . site_url('admin/users/update/' . $objUserInfo->userId) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
          } else {
            $updateLink = "";
          }
          if (in_array($delete->module_id, $this->session->permission)) {
            $deleteLink = "<a href=\"" . site_url('admin/users/delete/' . $objUserInfo->userId) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
          } else {
            $deleteLink = "";
          }

          $arrUsers[$intCount]['BN'] = $updateLink . $deleteLink;

          $intCount++;
        }
      }

      // Response
      $arrResponse = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $intTotalFilterRecs,
        "aaData" => $arrUsers
      );

      print(json_encode($arrResponse));
      exit;
    }

    $arrStatus = array(
                  "Y" => "Active",
                  "N" => "Inactive",
                );

    if(empty($fltrDateFrom)){
        $fltrDateFrom = mktime(0, 0, 0, date("m"), date("d"), date("Y")-1);
        $fltrDateFrom = date("d/m/Y", $fltrDateFrom);
    }

    if(empty($fltrDateTo)){
        $fltrDateTo = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        $fltrDateTo = date("d/m/Y", $fltrDateTo);
    }
    
    // Pass view params
    $arrViewParams = array();
    $arrViewParams['parentPage'] = "Apps";
    $arrViewParams['pageTitle'] = "Users";
    $arrViewParams['pageCode'] = "US";
    $arrViewParams['objUserGroups'] = $objUserGroups;
    $arrViewParams['arrStatus'] = $arrStatus;
    $arrViewParams['userGroupId'] = $userGroupId;
    $arrViewParams['userStatus'] = $userStatus;
    $arrViewParams['fltrDateFrom'] = $fltrDateFrom;
    $arrViewParams['fltrDateTo'] = $fltrDateTo;

    // Function call to display the view contents
    $this->load->adminPages('users/list', $arrViewParams);
  }

  // Function to display add screen
  public function create()
  {
    // Pass view params
    $arrViewParams = array();
    $arrViewParams['arrParentPage'] = array("Apps" => "", "Users" => site_url('admin/users'));
    $arrViewParams['pageTitle'] = "Add User";
    $arrViewParams['pageCode'] = "AUG";
    $arrViewParams['action'] = site_url('admin/users/create_action');
    $arrViewParams['txtId'] = set_value('txtId');
    $arrViewParams['txtName'] = set_value('txtName');
    $arrViewParams['txtEmail'] = set_value('txtEmail');
    $arrViewParams['txtPhone'] = set_value('txtPhone');
    $arrViewParams['txtUsername'] = set_value('txtUsername');
    $arrViewParams['txtPassword'] = set_value('txtPassword');
    $arrViewParams['txtConPassword'] = set_value('txtConPassword');
    $arrViewParams['selUserGroup'] = set_value('selUserGroup');
    $arrViewParams['selStatus'] = set_value('selStatus');
    $arrViewParams['userGroupList'] = $this->Users_model->getUsergroupList();

    // Function call to display the view contents
    $this->load->adminPages('users/form', $arrViewParams);
  }
  // Function to insert/update user group info
  public function create_action()
  {
    $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtPhone', 'Phone', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtUsername', 'Username', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|min_length[4]|max_length[40]');
    $this->form_validation->set_rules('txtConPassword', 'Confirm Password', 'trim|required|matches[txtPassword]');
    $this->form_validation->set_rules('selUserGroup', 'Usergroup', 'trim|required|max_length[255]');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == TRUE) {

      $arrInsertParams = array(
        "name" => $this->input->post('txtName'),
        "email" => $this->input->post('txtEmail'),
        "phone" => $this->input->post('txtPhone'),
        "username" => $this->input->post('txtUsername'),
        "password" => sha1($this->input->post('txtPassword')),
        "usergroup_id_fk" => $this->input->post('selUserGroup'),
        "status" => $this->input->post('selStatus'),
        "created_date" => date("Y-m-d H:i:s")
      );
      if ($this->Users_model->insert($arrInsertParams)) {
        $this->session->set_flashdata('alert', ['message' => 'User added successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'User NOT added successfully.', 'type' => 'danger']);
      }
      redirect(site_url('admin/users'));
    } else {
      $this->create();
    }
  }

  // Function to display form with existing details.
  public function update($id = NULL)
  {
    $row = $this->Users_model->get_by_id($id);
    if ($row) {
      // Pass view params
      $arrViewParams = array();
      $arrViewParams['arrParentPage'] = array("Apps" => "", "Users" => site_url('admin/users'));
      $arrViewParams['pageTitle'] = "Update User";
      $arrViewParams['pageCode'] = "UU";
      $arrViewParams['action'] = site_url('admin/users/update_action/' . $id);
      $arrViewParams['txtId'] = set_value('txtId', $row->id);
      $arrViewParams['txtName'] = set_value('txtName', $row->name);
      $arrViewParams['txtEmail'] = set_value('txtEmail', $row->email);
      $arrViewParams['txtPhone'] = set_value('txtPhone', $row->phone);
      $arrViewParams['txtUsername'] = set_value('txtUsername', $row->username);
      $arrViewParams['txtPassword'] = set_value('txtPassword', sha1($row->password));
      $arrViewParams['txtConPassword'] = set_value('txtConPassword', sha1($row->password));
      $arrViewParams['selUserGroup'] = set_value('selUserGroup', $row->usergroup_id_fk);
      $arrViewParams['selStatus'] = set_value('selStatus', $row->status);
      $arrViewParams['userGroupList'] = $this->Users_model->getUsergroupList();

      // Function call to display the view contents
      $this->load->adminPages('users/form', $arrViewParams);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
      redirect(site_url('admin/users'));
    }
  }

  // Function to update user group values.
  public function update_action()
  {
    $id = $this->input->post('txtId');
    $this->form_validation->set_rules('txtName', 'Name', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtEmail', 'Email', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtPhone', 'Phone', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtUsername', 'Username', 'trim|required|max_length[255]');
    $this->form_validation->set_rules('txtPassword', 'Password', 'trim|required|min_length[4]|max_length[40]');
    $this->form_validation->set_rules('txtConPassword', 'Confirm Password', 'trim|required|matches[txtPassword]');
    $this->form_validation->set_rules('selUserGroup', 'Usergroup', 'trim|required|max_length[255]');

    $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

    if ($this->form_validation->run() == FALSE) {
      $this->update($id);
    } else {
       $data = array(
        "name" => $this->input->post('txtName'),
        "email" => $this->input->post('txtEmail'),
        "phone" => $this->input->post('txtPhone'),
        "username" => $this->input->post('txtUsername'),
        "password" => sha1($this->input->post('txtPassword')),
        "usergroup_id_fk" => $this->input->post('selUserGroup'),
        "status" => $this->input->post('selStatus'),
        
      );
      if ($this->Users_model->update($id, $data)) {
        $this->session->set_flashdata('alert', ['message' => 'User updated successfully.', 'type' => 'success']);
      } else {
        $this->session->set_flashdata('alert', ['message' => 'User NOT updated successfully.', 'type' => 'danger']);
      }
      redirect(site_url('admin/users'));
    }
  }

  // Function to delete 
  public function delete($id)
  {
    $data = array(
      'deleted_at' => date("Y-m-d H:i:s")
    );
    if ($this->Users_model->update($id, $data)) {
      $this->session->set_flashdata('alert', ['message' => 'Delete User Success', 'type' => 'success']);
    } else {
      $this->session->set_flashdata('alert', ['message' => 'Delete User Failed', 'type' => 'danger']);
    }
    redirect(site_url('admin/users'));
  }
}
