<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Function to return total invested
    public function getTotalCounts() {

    	// Total notifications
    	$this->db->select('COUNT(n.id) AS totNotifications');
        $this->db->from('notifications n');
        $this->db->where('n.deleted_at IS NULL', NULL, FALSE);
        $objTotNotifications = $this->db->get()->row();

        // Total users
    	$this->db->select('COUNT(u.id) AS totUsers');
        $this->db->from('users u');
        $this->db->where('u.deleted_at IS NULL', NULL, FALSE);
        $objTotUsers = $this->db->get()->row();

        // Total replies
    	$this->db->select('COUNT(nr.id) AS totReplies');
        $this->db->from('notification_replies nr');
        $objTotReplies = $this->db->get()->row();

	    $arrReturn = array();

	    // Total notifications
	    if($objTotNotifications && !empty($objTotNotifications->totNotifications)){
	    	$arrReturn['totalNotifications'] = number_format($objTotNotifications->totNotifications);
	    }
	    else{
	    	$arrReturn['totalNotifications'] = 0;
	    }

	    // Total users
	    if($objTotUsers && !empty($objTotUsers->totUsers)){
	    	$arrReturn['totalUsers'] = number_format($objTotUsers->totUsers);
	    }
	    else{
	    	$arrReturn['totalUsers'] = 0;
	    }

		// Total replies
	    if($objTotReplies && !empty($objTotReplies->totReplies)){
	    	$arrReturn['totalReplies'] = number_format($objTotReplies->totReplies);
	    }
	    else{
	    	$arrReturn['totalReplies'] = 0;
	    }

	    return $arrReturn;
    }

    // Function to return latest replies by users
    public function getLatestUserReplies() {

    	// Total notifications
    	$this->db->select('u.kitex_user_id AS userName, n.title notificationTitle, nr.id AS replyId, DATE_FORMAT(nr.reply_date, "%d %b, %Y %h:%i %p") AS replyDate');

        $this->db->from('users u');
        $this->db->join('notification_replies nr', 'nr.user_id = u.id');
        $this->db->join('notifications n', 'n.id = nr.notification_id');

        $this->db->where('u.deleted_at IS NULL', NULL, FALSE);
        $this->db->where('n.deleted_at IS NULL', NULL, FALSE);
        $this->db->order_by('nr.reply_date', 'DESC');
        $this->db->limit(10);
        $objReplies = $this->db->get()->result();

	    return $objReplies;
    }
}
