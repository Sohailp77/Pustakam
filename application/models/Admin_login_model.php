<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_login_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Validate admin user login
    public function adminUserLogin($strUserName = "", $strPassword = "") {
        $where = array(
            'username' => $strUserName,
            'password' => sha1($strPassword),
            'status'=>'Y'
        );

        $this->db->select('id, name, username, usertype');
        $this->db->where($where);

        $result = $this->db->get('admin_users')->row();
        return $result;
    }

    // Function to update system variable.
    public function updatePassword($intAdminId = 0, $arrUpdateParams = array()) {
        return $this->db->where('id', $intAdminId)->update('admin_users', $arrUpdateParams);
    }
}
