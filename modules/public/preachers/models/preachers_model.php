<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of preacher_model
 *
 * @author Lachu
 */
class preachers_model extends MY_Model {

    //put your code here
	public function __construct($table_name = NULL, $primary_key = NULL) {
		parent::__construct($table_name, $primary_key);
	}

	function getPreachers($currentpage = 0, $role=null, $language=null, $field=null) {
		if($role != null){
			$this->db->where('status' , $role);
		}
		if($language != null){
			$this->db->like('language' , $language);
		}
		if($field != null){
			$this->db->like('areas_of_expertise' , $field);
		}
		$data = $this->db->select('*')
		->from('preachers')
        ->where('published', 1)
        ->order_by('timestamp', 'ASC')
        ->limit(8, $currentpage * 8)
        ->get()->result();
        return $data;
    }

    function getmorePreachers($currentpage = 1) {
      $data = $this->db->select('*')
      ->from('preachers')
      ->where('published', 1)
      ->order_by('timestamp', 'ASC')
      ->limit(8, $currentpage * 8)
      ->get();
      if ($data->num_rows() > 0) {
         return true;
     } else {
         return false;
     }
 }

	//give all the preacher details used in blog page
 function get_all_preachers(){
    return $this->db->select('*')
    ->from('preachers')
    ->where('published', 1)
    ->limit(6)
    ->get()
    ->result();
}

    //get preacher details
public function get_preacher_details_by_id($id){
   return $this->db->select('*')
   ->from('preachers')
   ->where('id', $id)
   ->get()
   ->row();
}

    // //get the associated preachers
    // public function get_associated_preachers($id,$where){
    // 	return $this->db->select('*')
    // 				->from('preachers')
    // 				->where($where)
    // 				->limit(3)
    // 				->get()
    // 				->result();
    // }

public function program_schedule($id){
   return $this->db->select('*')
   ->from('events')
   ->join('event_preachers ep', 'ep.event_id=events.id' )
   ->where('ep.preacher_id', $id)
   ->group_by('events.id')
   ->get()
   ->result();
}

public function associated_centres($id){
   return $this->db->select('c.*,rt.name as type_name')
   ->from('event_preachers as ep')
   ->join('events as e', 'ep.event_id=e.id' )
   ->join('center as c', 'c.id=e.center_id')
   ->join('rc_type as rt', 'rt.id=c.rc_type_id')
   ->where('ep.preacher_id', $id)
   ->where('c.is_deleted', 0)
   ->group_by('c.id')
   ->get()
   ->result();
}

public function associated_centres_count($id){
    $count= $this->db->select('count(*) as count')
    ->from('event_preachers as ep')
    ->join('events as e', 'ep.event_id=e.id' )
    ->join('center as c', 'c.id=e.center_id')
    ->join('rc_type as rt', 'rt.id=c.rc_type_id')
    ->where('ep.preacher_id', $id)
    ->where('c.is_deleted', 0)
    ->group_by('c.id')
    ->get();
    if($count->num_rows()>0){
        $c=$count->row();
        return $c->count;
    }
    return 0;
}

}