<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {

	function __construct() {
		parent::__construct();
	}

	// Function to create view for admin login page
	public function adminPages($viewFileName = "", $arrViewParams = array()){

		// Get header content
		$strHeader = $this->view('admin/modules/header', $arrViewParams, TRUE);

		// Get body content
		$strBody = $this->view('admin/' . $viewFileName, $arrViewParams, TRUE);

		// Get footer content
		$strFooter = $this->view('admin/modules/footer', $arrViewParams, TRUE);

		// Print all contents
		print($strHeader . $strBody . $strFooter);
	}

	// Function to create view for front end pages
	public function frontend_pages($viewFileName = "", $arrViewParams = array(), $header_file = "header"){

		// Get header content
		$strHeader = $this->view('frontend/modules/' . $header_file, $arrViewParams, TRUE);

		// Get body content
		$strBody = $this->view('frontend/' . $viewFileName, $arrViewParams, TRUE);

		// Get footer content
		$strFooter = $this->view('frontend/modules/footer', $arrViewParams, TRUE);

		// Print all contents
		print($strHeader . $strBody . $strFooter);
	}


}