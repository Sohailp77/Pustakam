<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Map_model extends CI_Model
{

    public $table = 'map_coords';
    public $id = 'mid';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }
    // Function to return system settings
    public function getMap($arrUserParams = array())
    {

        $this->db->select('*');

        $this->db->from('map_coords');

        $this->db->where('deleted_at IS NULL', NULL, FALSE);

        $sortBy = "mid";
        $orderBy = "ASC";
        foreach ($arrUserParams as $strParam => $paramValue) {
            switch (strtoupper($strParam)) {

                case "ID":

                    if (!empty($paramValue)) {
                        $this->db->where('mid', $paramValue);
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
                        $this->db->like('state', $paramValue);
                        $this->db->group_end();
                    }

                    break;

                case "SORTBY":
                    switch (strtoupper($paramValue)) {

                        case "TT": // User name
                            $sortBy = "state";
                            break;

                        case "CD": // Kitex id
                            $sortBy = "coords";
                            break;

                        case "LG": // Created date.
                            $sortBy = "language";
                            break;
                        case "ST": // Created date.
                            $sortBy = "status";
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
        return $this->db->where('mid', $id)->get($this->table)->row();
    }
    // Function to update user group.
    public function update($id, $arrUpdateParams = array())
    {
        return $this->db->where('mid', $id)->update($this->table, $arrUpdateParams);
    }
}
