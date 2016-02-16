<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

    public function __construct($table = null) {
        parent::__construct();
    }

    public function get_centername($center){
    	return $this->db->select('*')
        ->from('center')
        ->where('id' , $center)
        ->get()
        ->row();
    }

}
