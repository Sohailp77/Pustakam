<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users_model extends CI_Model
{

    public $table = 'admin_users';
    public $id = 'id';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }
    // Function to return system settings
    public function getUsers($arrUserParams = array())
    {

        $this->db->select('u.id AS userId,u.name AS Name,u.email AS Email,u.phone AS Phone, u.usergroup_id_fk AS userGroupId, u.username AS userName, u.status AS flActive, DATE_FORMAT(u.created_date, "%d %b, %Y %h:%i %p") AS addedDate');

        $this->db->from('admin_users u');

        $this->db->where('u.deleted_at IS NULL', NULL, FALSE);

        $sortBy = "u.id";
        $orderBy = "ASC";
        foreach ($arrUserParams as $strParam => $paramValue) {
            switch (strtoupper($strParam)) {

                case "CHECKUSERNAME":
                    $this->db->where('u.username', $paramValue);

                    break;

                case "USERID":

                    if (!empty($paramValue)) {
                        $this->db->where('u.id', $paramValue);
                    }

                    break;

                case "GROUPID":

                    if (!empty($paramValue)) {
                        $this->db->where('u.usergroup_id_fk', $paramValue);
                    }

                    break;

                case "MULUSERGROUPID":

                    if (count($paramValue) > 0) {

                        $this->db->group_start();

                        $intCnt = 0;
                        foreach ($paramValue as $intGroupId) {

                            if ($intCnt == 0) {
                                $this->db->like('u.usergroup_id_fk', '&&' . $intGroupId . '&&');
                            } else {
                                $this->db->or_like('u.usergroup_id_fk', '&&' . $intGroupId . '&&');
                            }

                            $intCnt++;
                        }

                        $this->db->group_end();
                    }

                    break;

                case "UNIQUEKITEXID":

                    if (!empty($paramValue)) {
                        $this->db->where('u.id <>', $paramValue);
                    }

                    break;

                case "STATUS":

                    if (!empty($paramValue)) {
                        $this->db->where('u.status', $paramValue);
                    }

                    break;

                case "DATEFROM":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(u.created_date, "%Y-%m-%d") >=', $paramValue);
                    }

                    break;

                case "DATETO":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(u.created_date, "%Y-%m-%d") <=', $paramValue);
                    }

                    break;

                case "SEARCH":
                    if (!empty($paramValue)) {
                        $this->db->group_start();
                        $this->db->like('u.username', $paramValue);
                        $this->db->group_end();
                    }

                    break;

                case "SORTBY":
                    switch (strtoupper($paramValue)) {

                        case "UN": // User name
                            $sortBy = "u.username";
                            break;

                        case "ID": // Kitex id
                            $sortBy = "u.id";
                            break;

                        case "AC": // Status
                            $sortBy = "u.status";
                            break;

                        case "CD": // Created date.
                            $sortBy = "u.created_date";
                            break;
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
        if (isset($arrUserParams['START']) && isset($arrUserParams['LIMIT'])) {
            $this->db->limit($arrUserParams['LIMIT'], $arrUserParams['START']);
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
    //Function to get Usergrouplist
    public function getUsergroupList()
    {
        return $this->db->select('id,name')->where('admin_usergroups.deleted_at', NULL)->get('admin_usergroups')->result();
    }
}
