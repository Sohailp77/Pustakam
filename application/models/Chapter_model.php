<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Chapter_model extends CI_Model
{

    public $table = 'chapter';
    public $id = 'cid';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    public function getChapter($arrUserParams = array())
    {
        $this->db->select('t.*,c.classname as class,m.state as state');
        $this->db->from('chapter t');
        $this->db->join('class c','c.cid=t.class');
        $this->db->join('map_coords m','m.mid=t.state');
        $this->db->where('t.deleted_at IS NULL', NULL, FALSE);
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

    public function insert($arrInsertParams = array())
    {
        return $this->db->insert($this->table, $arrInsertParams);
    }

    function get_by_id($id)
    {
        return $this->db->where('cid', $id)->get($this->table)->row();
    }

    public function update($id, $arrUpdateParams = array())
    {
        return $this->db->where('cid', $id)->update($this->table, $arrUpdateParams);
    }

    function getLastsortOrder()
    {
        return $this->db->select('MAX(sort_order) AS lastSortOrder')->where('deleted_at',NULL)->get($this->table)->row();
    }

    function getListLastsortOrder($cid)
    {
        return $this->db->select('MAX(sort_order) AS lastSortOrder')->where('deleted_at',NULL)->where('cid',$cid)->get('chapter_list')->row();
    } 

    function getChapterList($cid)
    {
        $this->db->select('*,l.image_file as image,l.status as status,l.sort_order as sort_order');
        $this->db->from('chapter_list l');
        $this->db->join('chapter c','c.cid=l.cid');
        $this->db->where('l.deleted_at IS NULL', NULL, FALSE);
        $this->db->where('l.cid',$cid);
        return $this->db->get()->result();
    }

    public function insertChapter($arrInsertParams = array())
    {
        return $this->db->insert("chapter_list", $arrInsertParams);
    }

    public function get_by_id_chapter($lid)
    {
        return $this->db->where('lid', $lid)->get("chapter_list")->row();
    }

    public function updateChapter($lid, $arrUpdateParams = array())
    {
        return $this->db->where('lid', $lid)->update("chapter_list", $arrUpdateParams);
    }

}
