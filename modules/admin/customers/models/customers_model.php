<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customers_model
 *
 * @author Lachu
 */
class customers_model extends MY_Model {

    //put your code here
	public function __construct() {
		parent::__construct();
	}

	public function getbenefactors() {
		$result = $this->db->select('b.*,c.first_name,c.email,c.contact_number')
		->from('benefactors as b')
		->join('customer as c','c.id=b.customer_id')
		->get()
		->result();
		return $result;
	}

	public function add_benefactor($array) {
        if ($this->db->insert('benefactors', $array))
            return $this->db->insert_id();
        return 0;
    }

    public function getcustomers(){
    	return $this->db->select('*')
    	->from('customer')
    	->where('active',1)
    	->get()
    	->result();
    }
    public function delete_benefactor($id) {
        $this->db->where('id', $id);
        return $this->db->delete('benefactors');
    }

    public function update_benefactor_type($value,$where){
    	return $this->db->update('benefactors',$value,$where);
    }

}