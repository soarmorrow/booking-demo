<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of benefactors model
 *
 * @author Lachu
 */
class Benefactors_model extends MY_Model {

    public $data;

    //put your code here
    public function __construct() {
		parent::__construct();
	}
	
	public function get_benefactors($id) {
		$result = $this->db->select('b.*,c.first_name,c.email,c.contact_number,c.address,c.district,c.state,c.country,c.pincode,c.avatar')
		->from('benefactors as b')
		->join('customer as c','c.id=b.customer_id')
		->where('b.benefactor_type',$id)
		->get()
		->result();
		return $result;
	}
}