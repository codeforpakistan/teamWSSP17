<?php
class getLatLong extends CI_Model{

    public function __construct() {
        parent::__construct();
    }

    function get()
    {
        $query = $this->db->get('complaint');
        return $query;
    }
/*    function get()
    {
        $query = $this->db->get('complaint');
        return $query;
    }*/
	
}