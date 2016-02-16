<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rate_model
 *
 * @author lenovo
 */
class Rating_model extends MY_Model {

    //put your code here
    public function __construct() {
        parent::__construct('rating', 'id');
    }

    public function getRatingCount($event_id, $user_id){
    	if ($user_id) {
    		$this->db->where('user_id', $user_id);
    	}

    	$result = $this->db->select('rating')
    	->from($this->table_name)
    	->where('event_id', $event_id)
    	->get()
    	->row();

    	return ($result)?$result->rating:0;
    }

    //get centre id by event id
    public function get_center_by_event_id($id){
        return $this->db->select('center.id')
        ->from('center')
        ->join('events','events.center_id=center.id')
        ->where('events.id',$id)
        ->get()
        ->row();
    }
}