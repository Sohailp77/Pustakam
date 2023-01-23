<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_groups_model extends CI_Model
{

    public $table = 'admin_usergroups';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }
    // Function to return system settings
    public function getUserGroups($arrGroupParams = array())
    {

        $this->db->select('ug.id AS userGroupId, ug.name AS userGroupName, DATE_FORMAT(ug.created_date, "%d %b, %Y %h:%i %p") AS createdDate');
        $this->db->from('admin_usergroups ug');
        $this->db->where('ug.deleted_at IS NULL', NULL, FALSE);

        $sortBy = "ug.name";
        $orderBy = "ASC";
        foreach ($arrGroupParams as $strParam => $paramValue) {
            switch (strtoupper($strParam)) {
                case "GROUPID":

                    if (!empty($paramValue)) {
                        $this->db->where('ug.id', $paramValue);
                    }

                    break;

                case "UNIQUEKITEXID":

                    if (!empty($paramValue)) {
                        $this->db->where('ug.id <>', $paramValue);
                    }

                    break;

                case "SEARCH":
                    if (!empty($paramValue)) {
                        $this->db->group_start();
                        $this->db->like('ug.name', $paramValue);
                        $this->db->group_end();
                    }

                    break;

                case "SORTBY":
                    switch (strtoupper($paramValue)) {
                        case "NM":
                            $sortBy = "ug.name";
                            break;
                    }

                    break;
                case "DATEFROM":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(ug.created_date, "%Y-%m-%d") >=', $paramValue);
                    }

                    break;

                case "DATETO":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(ug.created_date, "%Y-%m-%d") <=', $paramValue);
                    }

                    break;

                case "ORDERBY":
                    if (!empty($paramValue)) {
                        $orderBy = $paramValue;
                    }
            }
        }

        // Order the result
        $this->db->order_by($sortBy, $orderBy);

        // Apply limit
        if (isset($arrGroupParams['START']) && isset($arrGroupParams['LIMIT'])) {
            $this->db->limit($arrGroupParams['LIMIT'], $arrGroupParams['START']);
        }

        $objResult = $this->db->get()->result();

        return $objResult;
    }
    // Function to insert system variable.
    public function insert($arrInsertParams = array())
    {
        return $this->db->insert($this->table, $arrInsertParams);
    }
    //get by id
    function get_by_id($id)
    {
        return $this->db->where('id', $id)->get($this->table)->row();
    }
    // Function to update user group.
    public function update($id, $arrUpdateParams = array())
    {
        return $this->db->where('id', $id)->update($this->table, $arrUpdateParams);
    }
    //Function to get all parent modules
    public function get_modules()
    {
        $this->db->select('*');
        $this->db->from('admin_modules');
        $this->db->where('parent_module_id', '0');
        $this->db->where('deleted_at', null);
        $this->db->order_by('controller', 'ASC');
        return $this->db->get()->result();
    }
    //Function to get all sub modules
    function get_user_module_names($group_id)
    {
        $this->db->select('admin_modules.*');
        $this->db->from('admin_modules');
        $this->db->join("admin_permissions", "admin_permissions.module_id_fk = admin_modules.module_id", "inner");
        $this->db->order_by('admin_modules.title', 'ASC');
        $this->db->where('parent_module_id!=', '0');
        $this->db->where('deleted_at', null);
        $this->db->where('admin_permissions.usergroups_id_fk', $group_id);
        return $this->db->get()->result();
    }
    //Function to get all sub modules
    public function get_sub_modules()
    {
        $this->db->select('*');
        $this->db->from('admin_modules');
        $this->db->where('parent_module_id!=', '0');
        $this->db->where('deleted_at', null);
        $this->db->order_by('title', 'ASC');
        return $this->db->get()->result();
    }
    //Delete permissions assigned
    function delete_permission($groupId)
    {
        $this->db->where('usergroups_id_fk', $groupId);
        $this->db->delete('admin_permissions');
    }
    //Insert permissions
    function insert_permission($data)
    {
        return $this->db->insert_batch('admin_permissions', $data);
    }
}
