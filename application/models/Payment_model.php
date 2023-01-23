<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Payment_model extends CI_Model
{

    public $table = 'payments';
    public $id = 'pid';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    public function getPayment($arrUserParams = array())
    {
        $this->db->select('p.*,c.classname as class,m.state as state,u.name as customer_name');
        $this->db->from('payments p');
        $this->db->join('user u','u.email=p.customer');
        $this->db->join('class c','c.cid=p.classname');
        $this->db->join('map_coords m','m.mid=p.state');
        $this->db->order_by('p.created_date','DESC');
        return $this->db->get()->result();
    }

    public function getClass()
    {
        $this->db->select('*');
        $this->db->from('class');
        $this->db->where('deleted_at IS NULL', NULL, FALSE);
        $this->db->where('status','Y');
        $this->db->order_by('sort_order','ASC');
        return $this->db->get()->result();
    }

    public function getState()
    {
        $this->db->select('*');
        $this->db->from('map_coords');
        $this->db->where('deleted_at IS NULL', NULL, FALSE);
        $this->db->where('status','Y');
        return $this->db->get()->result();
    }

    public function getUser()
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('deleted_at IS NULL', NULL, FALSE);
        return $this->db->get()->result();
    }

    public function insert($arrInsertParams = array())
    {
        return $this->db->insert($this->table, $arrInsertParams);
    }

    function get_by_id($id)
    {
        return $this->db->where('pid', $id)->get($this->table)->row();
    }

    public function update($id, $arrUpdateParams = array())
    {
        return $this->db->where('pid', $id)->update($this->table, $arrUpdateParams);
    }

    
}
