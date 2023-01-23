<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_model {
    
	public function checkuser($data)
	{
		$this->db->select('*');
		$this->db->from('customers');
		$this->db->where($data);
		$query = $this->db->get();
		return $query->row_array();
		
	}
	public function get_oldpassword($user_id)
	{
		$this->db->select('password');
		$this->db->from('tbl_user');
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		return $query->row_array();
	}

	public function updateOrderReference($orderReference,$user_id)
	{
		$this->db->set('customer_id', $user_id, FALSE);
		$this->db->where('reference_no', $orderReference);
		return $this->db->update('orders');
	}
}