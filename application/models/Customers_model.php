<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customers_model extends CI_Model
{

    public $table = 'user';
    public $id = 'email';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    public function getCustomers($arrUserParams = array())
    {
        $this->db->select('*');
        $this->db->from('user c');
        $this->db->where('c.deleted_at IS NULL',NULL);
        return $this->db->get()->result(); 
    }
}