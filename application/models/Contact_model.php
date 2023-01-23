<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_model extends CI_Model
{

    public $table = 'contact';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }
    // Function to return system settings
    public function getContact($arrGroupParams = array())
    {

        $this->db->select('*,DATE_FORMAT(ct.created_date, "%d %b, %Y %h:%i %p") AS created_date');
        $this->db->from('contact ct');

        $sortBy = "ct.id";
        $orderBy = "DESC";
        foreach ($arrGroupParams as $strParam => $paramValue) {
            switch (strtoupper($strParam)) {
               
                case "SEARCH":
                    if (!empty($paramValue)) {
                        $this->db->group_start();
                        $this->db->like('ct.name', $paramValue);
                        $this->db->group_end();
                    }

                    break;

                case "SORTBY":
                    switch (strtoupper($paramValue)) {
                        case "NM":
                            $sortBy = "ct.name";
                            break;
                        case "EM":
                            $sortBy = "ct.email";
                            break;
                        case "SB":
                            $sortBy = "ct.subject";
                            break;
                    }

                    break;
                case "DATEFROM":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(ct.created_date, "%Y-%m-%d") >=', $paramValue);
                    }

                    break;

                case "DATETO":

                    if (!empty($paramValue)) {
                        $this->db->where('DATE_FORMAT(ct.created_date, "%Y-%m-%d") <=', $paramValue);
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
   
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
   
}
