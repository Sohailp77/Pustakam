<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/logout');
        }

        $this->load->model('Customers_model');
        $this->load->model('Common_model');
        $this->load->model('System_model');
        
    }
    // Default function
    public function index()
    {
     // get filter values
     $fltrDateFrom = $this->input->get('datefrom');
     $fltrDateTo = $this->input->get('dateto');

     $setAction = $this->input->post('setAction');

     $objCustomers = $this->db->select('email,name')->where('deleted_at IS NULL' , NULL, FALSE)->get('user')->result();

     // List the records through data table ajax call.
     if ($setAction == "ListRecord") {

         $fltrDateFrom = $this->input->post('datefrom');
         $fltrDateTo = $this->input->post('dateto');

         // Get all percentage for history based on date.
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
         $totalRecords = $this->db->where('deleted_at IS NULL', NULL, FALSE)->from('user')->count_all_results();

         $arrUserParams = array();
         $arrUserParams['SEARCH'] = $searchValue;
         $arrUserParams['SORTBY'] = $columnName;
         $arrUserParams['ORDERBY'] = $columnSortOrder;
         $arrUserParams['DATEFROM'] = $formattedDateFrom;
         $arrUserParams['DATETO'] = $formattedDateTo;

         // get the result count with filters and without limit.
         $objCustomers = $this->Customers_model->getCustomers($arrUserParams);
        

         $intTotalFilterRecs = 0;
         if ($objCustomers) {
             $intTotalFilterRecs = count($objCustomers);
         }

         $arrUserParams['START'] = $row;
         $arrUserParams['LIMIT'] = $rowperpage;

         $objCustomers = $this->Customers_model->getCustomers($arrUserParams);

         $arrUsers = array();
         $intCount = 0;
         if ($objCustomers) {

             
             foreach ($objCustomers as $objCustomerInfo) {

                 $arrUsers[$intCount]['AD'] = htmlentities($objCustomerInfo->created_at);

                 $arrUsers[$intCount]['NM'] = htmlentities($objCustomerInfo->name);
                 $arrUsers[$intCount]['EM'] = htmlentities($objCustomerInfo->email);
                 $arrUsers[$intCount]['PH'] = htmlentities($objCustomerInfo->mobile);

                 $updateLink = "<a href=\"" . site_url('admin/payments?customer=' . $objCustomerInfo->email) . "\" class=\"px-3 text-primary\" title=\"Update Status\">View Orders</a>";
                
                 $arrUsers[$intCount]['BN'] = $updateLink;

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
     $arrViewParams['parentPage'] = "Catalogue";
     $arrViewParams['pageTitle'] = "Customers";
     $arrViewParams['pageCode'] = "CS";
     $arrViewParams['userStatus'] = $Status;
     $arrViewParams['arrCustomers'] = $objCustomers;
     $arrViewParams['fltrDateFrom'] = $fltrDateFrom;
     $arrViewParams['fltrDateTo'] = $fltrDateTo;

     // Function call to display the view contents
     $this->load->adminPages('customers/list', $arrViewParams);
 }
}