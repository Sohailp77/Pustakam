<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();

        // if($this->session->userdata("PAGECONTROLLER")) {

        //     $strController = $this->router->fetch_class();
        //     if($this->session->userdata("PAGECONTROLLER") != $strController){
        //         $this->session->unset_userdata('PAGECONTROLLER');
        //     }
        // }
        if ($this->session->userdata(ADMIN_SESSION_NAME) && $this->session->userdata(ADMIN_SESSION_NAME)['userType'] != 'superadmin') {
            $this->userid = $this->session->userdata(ADMIN_SESSION_NAME)['userId'];

            $strController = $this->router->fetch_class();
            $strFunction = $this->router->fetch_method();

            $allModules = $this->get_all_modules_name($this->userid);

            $this->session->set_userdata('nav', $allModules);

            $Module = $this->get_moduleId($strController, $strFunction); 

            $Permission = $this->get_userPermissions($this->userid);


        } else if ($this->session->userdata(ADMIN_SESSION_NAME) && $this->session->userdata(ADMIN_SESSION_NAME)['userType'] == 'superadmin') {
            $allModules = $this->get_allModules();
            
            $this->session->set_userdata('nav', $allModules);
            $Permission = $this->get_AllmoduleId();

            $this->session->set_userdata('permission', $Permission);
        }
    }
    //Function to get all modules name
    function get_allModules()
    {
        $this->db->select('am.controller');
        $this->db->from('admin_modules am');
        $this->db->group_by('am.controller');
        $query = $this->db->get();
        $Modules = array();
        if ($query->result()) {
            foreach ($query->result() as $ModulesId) {
                $Modules[] = $ModulesId->controller;
            }
            return $Modules;
        } else {
            return FALSE;
        }
    }
    //Function to get all modules name
    function get_all_modules_name($userid = NULL)
    {
        $this->db->select('am.controller');
        $this->db->from('admin_users au');
        $this->db->join('admin_permissions ap', 'ap.usergroups_id_fk = au.usergroup_id_fk','LEFT');
        $this->db->join('admin_modules am', 'am.module_id = ap.module_id_fk','LEFT');
        if ($userid) {
            $this->db->where(array('au.id' => $userid));
        }
        $this->db->group_by('am.controller');
        $query = $this->db->get();
        $Modules = array();
        if ($query->result()) {
            foreach ($query->result() as $ModulesId) {
                $Modules[] = $ModulesId->controller;
            }
            return $Modules;
        } else {
            return FALSE;
        }
    }
    //Function to get module id
    public function get_AllmoduleId()
    {
        $this->db->select('module_id');
        $this->db->from('admin_modules');
        $query = $this->db->get();

        $ModulesIds = array();
        if ($query->result()) {
            foreach ($query->result() as $ModulesId) {
                $ModulesIds[] = $ModulesId->module_id;
            }
            return $ModulesIds;
        } else {
            return FALSE;
        }
    }
    //Function to get module id
    public function get_moduleId($controller, $function)
    {
        $this->db->select('module_id');
        $this->db->from('admin_modules');
        $this->db->where(array('controller' => $controller, 'function' => $function));
        return $this->db->get()->row();
    }
    //Function to get module id
    public function get_userPermissions($userid)
    {
        $this->db->select('ap.module_id_fk');
        $this->db->from('admin_users au');
        $this->db->join('admin_permissions ap', 'ap.usergroups_id_fk = au.usergroup_id_fk');
        $this->db->where(array('au.id' => $userid));
        $query = $this->db->get();

        $ModulesIds = array();
        if ($query->result()) {
            foreach ($query->result() as $ModulesId) {
                $ModulesIds[] = $ModulesId->module_id_fk;
            }
            return $ModulesIds;
        } else {
            return FALSE;
        }
    }
    //Function to get all sub modules of a parent module
    public function getSubModules($parent_id)
    {
        $this->db->select('module_id,action_type');
        $this->db->from('admin_modules');
        $this->db->where('parent_module_id', $parent_id);
        $this->db->where('deleted_at', null);
        $this->db->order_by('title', 'ASC');
        $query = $this->db->get();
        
        $Permissions = array();
        if ($query->result()) {
            foreach ($query->result() as $Permissions_) {
                $Permissions[$Permissions_->module_id] = $Permissions_->action_type;
            }
            return $Permissions;
        } else {
            return FALSE;
        }
    }



    // Function to return array with record status values
    public function get_status()
    {
        return array(
                    "Y" => "Active",
                    "N" => "Inactive"
                );
    }

    // Function to return array with yes / no values
    public function get_yes_no()
    {
        return array(
                    "Y" => "Yes",
                    "N" => "No"
                );
    }


    // Function to return array with permission action type
    public function get_action_type()
    {
        return array(
                    "VW" => "View",
                    "AD" => "Add",
                    "ED" => "Edit",
                    "DL" => "Delete",
                );
    }



}
