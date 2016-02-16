<?php

  class Rc_type_model extends MY_Model {

       function __construct($table_name = NULL, $primary_key = NULL) {
            parent::__construct(IMS_DB_PREFIX . 'rc_type', 'id');
       }

       public function get_types() {
            return $this->db->select('id,name')->from($this->table_name)->where('status', 1)->get()->result();
       }

       public function get_type($id) {
            return $this->db->select('*')->from($this->table_name)->where('id', $id)->get()->row();
       }

       public function add_type($data = array()) {
            if ($this->db->insert($this->table_name, $data))
                 return $this->db->insert_id();
            return 0;
       }

       public function update_type($id, $data) {
            return $this->db->where('id', $id)->update($this->table_name, $data);
       }

       public function delete_type($id) {
            $this->db->where('id', $id);
            return $this->db->update($this->table_name, array('status' => 0));
       }

  }
  