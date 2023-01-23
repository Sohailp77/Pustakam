<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Payment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        if (!$this->session->userdata(ADMIN_SESSION_NAME)) {
            redirect('admin/logout');
        }

        $this->load->model('Payment_model');
        $this->load->model('Common_model');
    }
    // Default function
    public function index($ParentId = 0)
    {
       
        $objPayment = $this->Payment_model->getPayment($arrPaymentParams);
        $arrPayment = array();
        $intCount = 0;
        if ($objPayment) {

            $update = $this->Common_model->get_moduleId('Payment', 'update');
            $delete = $this->Common_model->get_moduleId('Payment', 'delete');

            foreach ($objPayment as $objPaymentInfo) {

                $arrPayment[$intCount]['CT'] = htmlentities($objPaymentInfo->customer_name).'-'.htmlentities($objPaymentInfo->customer);
                $arrPayment[$intCount]['ST'] = htmlentities($objPaymentInfo->state);
                $arrPayment[$intCount]['CL'] = htmlentities($objPaymentInfo->class);
                $arrPayment[$intCount]['PD'] = htmlentities($objPaymentInfo->payment_date);
                $arrPayment[$intCount]['ED'] = htmlentities($objPaymentInfo->expire_date);
                $arrPayment[$intCount]['AM'] = htmlentities($objPaymentInfo->amount);
                $arrPayment[$intCount]['TD'] = htmlentities($objPaymentInfo->transaction_id);
                $arrPayment[$intCount]['CD'] = htmlentities($objPaymentInfo->created_date);

                if (in_array($update->module_id, $this->session->permission)) {
                    $updateLink = "<a href=\"" . site_url('admin/Payment/update/' . $objPaymentInfo->pid) . "\" class=\"px-3 text-primary\" title=\"Edit\"><i class=\"uil uil-pen font-size-18\"></i></a>";
                } else {
                    $updateLink = "";
                }
                if (in_array($delete->module_id, $this->session->permission)) {
                    $deleteLink = "<a href=\"" . site_url('admin/Payment/delete/' . $objPaymentInfo->pid) . "\" onclick=\"javascript: return confirm('Are you sure?')\" class=\"px-3 text-danger\" title=\"Delete\"><i class=\"uil uil-trash-alt font-size-18\"></i></a>";
                } else {
                    $deleteLink = "";
                }

                $arrPayment[$intCount]['BN'] = "<ul class=\"list-inline mb-0\"> <li class=\"list-inline-item dropdown\">" . $updateLink . "</li>
                     <li class=\"list-inline-item dropdown\">" . $deleteLink . "</li></ul>";

                $intCount++;
            }
        }

        // Pass view params
        $arrViewParams = array();
        $arrViewParams['parentPage'] = "Catalogue";
        $arrViewParams['pageTitle'] = "Payment";
        $arrViewParams['pageCode'] = "PT";
        $arrViewParams['arrPayment']=$arrPayment;

        // Function call to display the view contents
        $this->load->adminPages('payment/list', $arrViewParams);
    }
    // Function to display add screen
    public function create()
    {
        // Pass view params
        $arrViewParams = array();
        $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Payment" => site_url('admin/payment'));
        $arrViewParams['pageTitle'] = "Add Payment";
        $arrViewParams['pageCode'] = "AM";
        $arrViewParams['action'] = site_url('admin/payment/create_action');
        $arrViewParams['pid'] = set_value('pid');
        $arrViewParams['customer'] = set_value('customer');
        $arrViewParams['state'] = set_value('state');
        $arrViewParams['classname'] = set_value('classname');
        $arrViewParams['payment_date'] = set_value('payment_date');
        $arrViewParams['expire_date'] = set_value('expire_date');
        $arrViewParams['amount'] = set_value('amount');  
        $arrViewParams['transaction_id'] = set_value('transaction_id');

        $arrViewParams['arrClass']=$this->Payment_model->getClass();
        $arrViewParams['arrState']=$this->Payment_model->getState();
        $arrViewParams['arrUser']=$this->Payment_model->getUser();

        $this->load->adminPages('payment/form', $arrViewParams);
    }
    // Function to insert/update user group info
    public function create_action()
    {
        $this->form_validation->set_rules('customer', 'Customer', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('classname', 'Class', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
        $this->form_validation->set_rules('expire_date', 'Expiry Date', 'trim|required');
        $this->form_validation->set_rules('amount', 'Payment Amount', 'trim|required');
        $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required');


        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == TRUE) {

            $arrInsertParams = array(
                "customer" => $this->input->post('customer'),
                "state" => $this->input->post('state'),
                "classname" => $this->input->post('classname'),
                "payment_date" => $this->input->post('payment_date'),
                "expire_date" => $this->input->post('expire_date'),
                "amount" => $this->input->post('amount'),
                "transaction_id" => $this->input->post('transaction_id'),
                "created_date" => date('Y-m-d H:i:s'),
            );
            if ($this->Payment_model->insert($arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record added successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT added successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/payment'));
        } else {
            $this->create();
        }
    }
    // Function to display form with existing details.
    public function update($id = NULL)
    {
        $row = $this->Payment_model->get_by_id($id);
        if ($row) {
            // Pass view params

            $payment_date = date('d-m-Y',strtotime($row->payment_date));
            $expire_date = date('d-m-Y',strtotime($row->expire_date));

            $arrViewParams = array();
            $arrViewParams['arrParentPage'] = array("Catalogue" => "", "Payment" => site_url('admin/payment'));
            $arrViewParams['pageTitle'] = "Update Payment";
            $arrViewParams['pageCode'] = "UM";
            $arrViewParams['action'] = site_url('admin/payment/update_action');
            $arrViewParams['pid'] = set_value('pid',$row->pid);
            $arrViewParams['customer'] = set_value('customer',$row->customer);
            $arrViewParams['state'] = set_value('state',$row->state);
            $arrViewParams['classname'] = set_value('classname',$row->classname);
            $arrViewParams['payment_date'] = set_value('payment_date',$payment_date);
            $arrViewParams['expire_date'] = set_value('expire_date',$expire_date);
            $arrViewParams['amount'] = set_value('amount',$row->amount);  
            $arrViewParams['transaction_id'] = set_value('transaction_id',$row->transaction_id);

            $arrViewParams['arrClass']=$this->Payment_model->getClass();
            $arrViewParams['arrState']=$this->Payment_model->getState();
            $arrViewParams['arrUser']=$this->Payment_model->getUser();

            $this->load->adminPages('payment/form', $arrViewParams);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Record Not Found', 'type' => 'danger']);
            redirect(site_url('admin/payment'));
        }
    }
    // Function to update user group values.
    public function update_action()
    {
        $pid = $this->input->post('pid');
        $this->form_validation->set_rules('customer', 'Customer', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('classname', 'Class', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('payment_date', 'Payment Date', 'trim|required');
        $this->form_validation->set_rules('expire_date', 'Expiry Date', 'trim|required');
        $this->form_validation->set_rules('amount', 'Payment Amount', 'trim|required');
        $this->form_validation->set_rules('transaction_id', 'Transaction ID', 'trim|required');

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->update($pid);
        } else {

            $arrInsertParams = array(
                "customer" => $this->input->post('customer'),
                "state" => $this->input->post('state'),
                "classname" => $this->input->post('classname'),
                "payment_date" => $this->input->post('payment_date'),
                "expire_date" => $this->input->post('expire_date'),
                "amount" => $this->input->post('amount'),
                "transaction_id" => $this->input->post('transaction_id'),
                "created_date" => date('Y-m-d H:i:s'),
            );

            if ($this->Payment_model->update($pid, $arrInsertParams)) {
                $this->session->set_flashdata('alert', ['message' => 'Record updated successfully.', 'type' => 'success']);
            } else {
                $this->session->set_flashdata('alert', ['message' => 'Record NOT updated successfully.', 'type' => 'danger']);
            }
            redirect(site_url('admin/payment'));
        }
    }
    
    // Function to delete 
    public function delete($id)
    {
        $data = array(
            'deleted_at' => date("Y-m-d H:i:s")
        );
        if ($this->Payment_model->update($id, $data)) {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Success', 'type' => 'success']);
        } else {
            $this->session->set_flashdata('alert', ['message' => 'Delete Record Failed', 'type' => 'danger']);
        }
        redirect(site_url('admin/payment'));
    }
}
