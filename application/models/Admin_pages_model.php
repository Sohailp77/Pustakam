<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_pages_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to return system settings
    public function get_admin_pages($arrParams = array()) {

        $this->db->select('am.module_id AS module_id, am.controller AS controller_name, am.function AS function, am.title AS title, am.parent_module_id AS parent_module_id, am.action_type AS action_type');
        $this->db->from('admin_modules am');
        $this->db->where('am.deleted_at IS NULL', NULL, FALSE);

        $sortBy = "am.controller";
        $orderBy = "ASC";

        foreach($arrParams as $strParameter => $strValue){
            switch($strParameter){
                case "MODULEID":
                    $this->db->where('am.module_id', $strValue);
                    break;

                case "PARENTID":
                    $this->db->where('am.parent_module_id', $strValue);
                    break;

                case "SEARCH":
                    if(!empty($strValue)){
                        $this->db->group_start();
                        $this->db->like('am.title', $strValue);
                        $this->db->or_like('am.controller', $strValue);
                        $this->db->or_like('am.function', $strValue);
                        $this->db->group_end();
                    }

                    break;

                case "SORTBY":
                    switch(strtoupper($strValue)){
                        case "TL": // Category Name
                            $sortBy = "am.title";
                            break;

                        case "CO": // Controller name
                            $sortBy = "am.controller";
                            break;

                        case "FU": // Function name
                            $sortBy = "am.function";
                            break;
                    }

                    break;

                case "ORDERBY":
                    if(!empty($strValue)){
                        $orderBy = $strValue;
                    }
            }
        }

        // Order the result
        $this->db->order_by($sortBy, $orderBy);

        // Apply limit
        if(isset($arrParams['START']) && isset($arrParams['LIMIT'])){
            $this->db->limit($arrParams['LIMIT'], $arrParams['START']);
        }

        $objResult = $this->db->get()->result();
        
        return $objResult;
    }

    // Function to insert system variable.
    public function insert_admin_page($arr_insert_params = array()) {
        return $this->db->insert('admin_modules', $arr_insert_params);
    }

    // Function to update system variable.
    public function update_admin_page($int_page_id = 0, $arr_update_params = array()) {
        return $this->db->where('module_id', $int_page_id)->update('admin_modules', $arr_update_params);
    }

    // delete data
    public function delete_admin_page($int_page_id = 0)
    {
        $this->db->where('parent_module_id', $int_page_id)->update('admin_modules', array('deleted_at' => date("Y-m-d")));

        $this->db->where('module_id', $int_page_id)->update('admin_modules', array('deleted_at' => date("Y-m-d")));

        return true;       
    }
}
