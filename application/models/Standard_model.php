<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Standard_model extends CI_Model
{

    public $table = 'class';
    public $id = 'cid';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }
      // Function to return system settings
      public function getStandard($arrUserParams = array())
      {
  
          $this->db->select('*');
          $this->db->from('class');
          $this->db->where('deleted_at IS NULL', NULL, FALSE);
  
          $sortBy = "cid";
          $orderBy = "ASC";
          foreach ($arrUserParams as $strParam => $paramValue) {
              switch (strtoupper($strParam)) {
  
                  case "ID":
  
                      if (!empty($paramValue)) {
                          $this->db->where('cid', $paramValue);
                      }
  
                      break;

                  case "STATUS":
  
                      if (!empty($paramValue)) {
                          $this->db->where('status', $paramValue);
                      }
  
                      break;
  
                  case "SEARCH":
                      if (!empty($paramValue)) {
                          $this->db->group_start();
                          $this->db->like('classname', $paramValue);
                          $this->db->group_end();
                      }
  
                      break;
  
                  case "SORTBY":
                      switch (strtoupper($paramValue)) {
  
                          case "CN": // User name
                              $sortBy = "classname";
                              break;
  
                          case "ST": // Kitex id
                              $sortBy = "status";
                              break;

                          case "SO": // Sort Order.
                              $sortBy = "sort_order";
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
        return $this->db->where('cid', $id)->get($this->table)->row();
    }
    // Function to update user group.
    public function update($id, $arrUpdateParams = array())
    {
        return $this->db->where('cid', $id)->update($this->table, $arrUpdateParams);
    }
    //Function to get last sort order
    function getLastsortOrder()
    {
        return $this->db->select('MAX(sort_order) AS lastSortOrder')->where('deleted_at',NULL)->get($this->table)->row();
    }
}