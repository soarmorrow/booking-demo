<?php

  class Rc_category_model extends MY_Model {

       function __construct($table_name = NULL, $primary_key = NULL) {
            parent::__construct(IMS_DB_PREFIX . 'rc_category', 'id');
       }

       public function get_categories() {
            return $this->db->select('id,rc_category')->from($this->table_name)->where('status', 1)->get()->result();
       }

       public function add_category($data = array()) {
            if ($this->db->insert($this->table_name, $data))
                 return $this->db->insert_id();
            return 0;
       }

       public function get_category($id) {
            return $this->db->select('*')->from($this->table_name)->where('id', $id)->get()->row();
       }

       public function delete_category($id) {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, array('status' => 0));
       }
       public function update_category($id,$data){
            return $this->db->where('id',$id)->update($this->table_name,$data);
       }
  }
  