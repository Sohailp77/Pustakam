<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    function __construct()
    {
      parent::__construct();

      if(!$this->session->userdata(ADMIN_SESSION_NAME)) {
          redirect('admin/logout');
      }

      $this->load->model('Admin_dashboard_model');
      $this->load->model('Common_model');
    }

    // Default function
    public function index()
    {

      $arrTotalCounts = array();

      $arrViewParams = array();
      $arrViewParams['parentPage'] = "Menu";
      $arrViewParams['pageTitle'] = "Admin Dashboard";
      $arrViewParams['pageCode'] = "AD";
      
      // Function call to display the view contents
      $this->load->adminPages('dashboard', $arrViewParams);
    }
}
