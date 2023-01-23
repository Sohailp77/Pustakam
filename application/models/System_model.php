<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class System_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to return system settings
    public function getSystemSettings($arrParams = array()) {

        $this->db->select('ss.id AS systemId, ss.code AS systemCode, ss.name AS systemName, ss.value AS systemValue');
        $this->db->from('system_settings ss');
        $this->db->where('ss.deleted_at IS NULL', NULL, FALSE);

        if(isset($arrParams['FLDEVELOPER']) && $arrParams['FLDEVELOPER']){
            $this->db->where('ss.fl_developer_var', "Y");
        }
        else{
            $this->db->where('ss.fl_developer_var', "N");
        }

        foreach($arrParams as $strParameter => $strValue){
            switch($strParameter){
                case "SYSTEMID":
                    $this->db->where('ss.id', $strValue);
                    break;

                case "SYSTEMCODE":
                    $this->db->where('ss.code', $strValue);
                    break;

                case "MULTIPLECODES":
                    $this->db->where_in('ss.code', $strValue);
                    break;
            }
        }

        $this->db->order_by('ss.id', 'ASC');
        $objResult = $this->db->get()->result();
        
        return $objResult;
    }

    // Function to insert system variable.
    public function insertSystemVariable($arrInsertParams = array()) {
        return $this->db->insert('system_settings', $arrInsertParams);
    }

    // Function to update system variable.
    public function updateSystemVariable($intSystemVarId = 0, $arrUpdateParams = array()) {
        return $this->db->where('id', $intSystemVarId)->update('system_settings', $arrUpdateParams);
    }

    // delete data
    public function deleteSystemVariable($intSystemVarId = 0)
    {
        return $this->db->where('id', $intSystemVarId)->update('system_settings', array('deleted_at' => date("Y-m-d")));        
    }
}
