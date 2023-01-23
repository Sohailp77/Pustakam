<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home_model extends CI_Model
{
     function __construct()
     {
          parent::__construct();
     }

     function getMapCoords()
     {
          $this->db->select('*');
          $this->db->from('map_coords');
          $this->db->where('deleted_at IS NULL',NULL);
          return $this->db->get()->result(); 
     }

     function getState($mid)
     {
          return $this->db->where('mid', $mid)->get("map_coords")->row();
     }

     function insertUser($arrInsertParams)
     {
          return $this->db->insert("user", $arrInsertParams);
     }

     function loginUser($email, $password)
     {
          $this->db->select('*');
          $this->db->from('user');
          $this->db->where('email',$email);
          $this->db->where('password',$password);
          return $this->db->get()->row(); 
     }

     function getChapterExists($mid)
     {
          $this->db->select('*');
          $this->db->from('chapter');
          $this->db->where('state',$mid);
          $this->db->where('status','Y');
          $this->db->where('deleted_at IS NULL',NULL);
          return $this->db->get()->result(); 
     }

     function getClass($mid)
     {
          $this->db->select('c.cid as cid,c.classname as classname');
          $this->db->from('chapter t');
          $this->db->join('class c','c.cid=t.class');
          $this->db->where('t.state',$mid);
          $this->db->where('t.status','Y');
          $this->db->where('t.deleted_at IS NULL',NULL);
          $this->db->group_by('c.classname');
          $this->db->order_by('c.sort_order','ASC');
          return $this->db->get()->result(); 
     }

     function getChapter($mid,$cid)
     {
          $this->db->select('*');
          $this->db->from('chapter');
          $this->db->where('state',$mid);
          $this->db->where('class',$cid);
          $this->db->where('status','Y');
          $this->db->where('deleted_at IS NULL',NULL);
          $this->db->order_by('sort_order','ASC');
          return $this->db->get()->result(); 
     }

     function getChapterById($cid)
     {
          $this->db->select('t.*,c.classname as classname,m.state as state,m.language as language,t.state as mid');
          $this->db->from('chapter t');
          $this->db->join('class c','c.cid=t.class');
          $this->db->join('map_coords m','m.mid=t.state');
          $this->db->where('t.cid',$cid);
          return $this->db->get()->row();
     }

     function getPayment($email,$cdate,$mid,$cid)
     {
          $this->db->select('*');
          $this->db->from('payments');
          $this->db->where('customer',$email);
          $this->db->where('expire_date>=',$cdate);
          $this->db->where('state',$mid);
          $this->db->where('classname',$cid);
          return $this->db->get()->row();
     }

     function getChapterImages($cid)
     {
          $this->db->select('*');
          $this->db->from('chapter_list');
          $this->db->where('cid',$cid);
          $this->db->where('status','Y');
          $this->db->where('deleted_at IS NULL',NULL);
          $this->db->order_by('sort_order','ASC');
          return $this->db->get()->result();
     }

     function getLanguageMenu()
     {
          $this->db->select('*,m.state as state');
          $this->db->from('map_coords m');
          $this->db->join('chapter c','c.state=m.mid');
          $this->db->where('m.status','Y');
          $this->db->where('m.deleted_at IS NULL',NULL);
          $this->db->group_by('m.state');
          return $this->db->get()->result(); 
     }


}