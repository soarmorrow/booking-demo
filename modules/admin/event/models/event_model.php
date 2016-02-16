<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of event_model
 *
 * @author Lachu
 */
class event_model extends MY_Model {

    //put your code here
    public function __construct() {
        parent::__construct();
    }

    public function getevents($user_id, $perpage = 10, $page = 1, $filters) {
        $this->db->select('*');
        if (!_is("GR Admin")) {
            $this->db->where('create_id', $user_id);
        }
        if (isset($filters['status']) && $filters['status'] != "") {
            $this->db->where('published', (int) $filters['status']);
        }
        if (isset($filters['start']) && $filters['start'] != "") {
            $this->db->where("start_date >='" . date(DATE_FORMAT, strtotime($filters['start'])) . "'");
        }
        if (isset($filters['end']) && $filters['end'] != "") {
            $this->db->where("end_date <='" . date(DATE_FORMAT, strtotime($filters['end'])) . "'");
        }
        if (isset($filters['content']) && $filters['content'] != "") {
            $this->db->where("(`name` LIKE '%" . $filters['content'] . "%' OR `description` LIKE '%" . $filters['content'] . "%' OR `address` LIKE '%" . $filters['content'] . "%')");
        }
        $this->db->limit($perpage, (($page - 1) * $perpage));
        $this->db->order_by('start_date', 'asc');

        $result = $this->db->get('events')
        ->result();
        return $result;
    }

    public function get_preacher_details($id){
        $result = $this->db->select('*')
        ->from('preachers')
        ->where('id' , $id)
        ->get()
        ->row();
        return $result;
    }

    public function updatePreacher($values, $where){
        return $this->db->update('preachers', $values, $where);
    }

    public function geteventtypes() {
        $result = $this->db->select('*')
        ->get('event_types')
        ->result();
        return $result;
    }

    public function loadcountry() {
        $result = $this->db->select('*')
        ->get('countries')
        ->result();
        return $result;
    }

    function loadAccomodation() {
        $result = $this->db->select('*')
        ->get('accomodation')
        ->result();
        return $result;
    }

    public function loadCenters($user_id) {
        if (_ismyrole($user_id, 1)) {
            $center = $this->db->select("*")
            ->where('is_deleted', 0)
            ->get('center');
            return $center->result();
        } else {
            $center = $this->db->select("c.*")
            ->from(IMS_DB_PREFIX . 'center as c')
            ->where('is_deleted', 0)
            ->get('user_role as r', 'r.center_id = c.id');
            return $center->result();
        }
    }

    public function add_event($event, $eventimages, $preacherarray = null, $accomodation = null) {
        $data = $this->db->insert('events', $event);
        $event_id = $this->db->insert_id();
        $total = 0;
        if (!empty($accomodation['type'])) {
            $j = 0;
            foreach ($accomodation['type'] as $value) {
                $array = array(
                    'event_id' => $event_id,
                    'type' => $value,
                    'adult' => $accomodation['rate'][$j],
                    'child' => $accomodation['child'][$j],
                    'seats' => $accomodation['seats'][$j],
                    'status' => 1
                    );
                $total = $total + $accomodation['seats'][$j];
                $this->db->insert('event_accommodation', $array);
                $j++;
            }
        }
        $this->updateWhere(array('id' => $event_id), array('available_seats'=>$total), 'events');

        if ($eventimages != '') {
            foreach ($eventimages as $value) {
                $array = array(
                    'image' => $value,
                    'event_id' => $event_id,
                    'status' => 1
                    );
                $this->db->insert('event_images', $array);
            }
        }
        if (!empty($preacherarray)) {
            foreach ($preacherarray as $value1) {
                $array1 = array(
                    'preacher_id' => $value1,
                    'event_id' => $event_id
                    );
                $this->db->insert('event_preachers', $array1);
            }
        }
        return $data;
    }

    public function update_event($event, $event_id, $eventimages, $update_id, $preacherarray, $accomodation = null) {
        if (!_is("GR Admin")) {
            $result = $this->db->select("*")
            ->where('create_id', $update_id)
            ->get('events');
            if ($result->num_rows() == 0) {
                return FALSE;
            }
        }
        $ea = $this->db->where('event_id', $event_id)
        ->get('event_accommodation')->result();

        foreach ($ea as $value) {
            if (!in_array($value->id, $accomodation['id'])) {
                $this->db->where('id', $value->id)
                ->delete('event_accommodation');
            }
        }

        $total = 0;
        if (!empty($accomodation['type'])) {
            $j = 0;
            foreach ($accomodation['type'] as $value) {
                $array = array(
                    'event_id' => $event_id,
                    'type' => $value,
                    'adult' => $accomodation['rate'][$j],
                    'child' => $accomodation['child'][$j],
                    'seats' => $accomodation['seats'][$j],
                    'status' => 1
                    );
                $total = $total + $accomodation['seats'][$j];
                if ($accomodation['id'][$j] != 0) {
                    $this->db->where('id', $accomodation['id'][$j])
                    ->update('event_accommodation', $array);
                } else {
                    $this->db->insert('event_accommodation', $array);
                }
                $j++;
            }
        }
        $this->updateWhere(array('id' => $event_id), array('available_seats' => $total), 'events');
        
        $this->db->where('id', $event_id);
        $data = $this->db->update('events', $event);
        if ($eventimages != '') {
            foreach ($eventimages as $value) {
                $array = array(
                    'image' => $value,
                    'event_id' => $event_id,
                    'status' => 1
                    );
                $this->db->insert('event_images', $array);
            }
        }

        if ($preacherarray != '') {
            $this->db->where('event_id', $event_id)
            ->delete('event_preachers');
            foreach ($preacherarray as $value) {
                $array = array(
                    'preacher_id' => $value,
                    'event_id' => $event_id
                    );
                $this->db->insert('event_preachers', $array);
            }
        }
        return $data;
    }

    public function get_event_count($filters, $user_id) {
        $this->db->select('id');
        if (!_is("GR Admin")) {
            $this->db->where('create_id', $user_id);
        }

        if (isset($filters['content']) && $filters['content'] != "") {
            $this->db->where("(`name` LIKE '%" . $filters['content'] . "%' OR `description` LIKE '%" . $filters['content'] . "%' OR `address` LIKE '%" . $filters['content'] . "%')");
        }
        if (isset($filters['status'])) {
            $this->db->where('published', (int) $filters['status']);
        }
        if (isset($filters['start']) && $filters['start'] != '') {
            $this->db->where('start_date', date(DATE_FORMAT, strtotime($filters['start'])));
        }
        if (isset($filters['end']) && $filters['end'] != '') {
            $this->db->where('end_date', date(DATE_FORMAT, strtotime($filters['end'])));
        }
        $result = $this->db->get('events');
        return $result->num_rows();
    }

    public function delete($id, $user_id) {
        $this->db->where('id', $id);
        if (!_is("GR Admin")) {
            $this->db->where('create_id', $user_id);
        }
        return $this->db->delete('events');
    }

    public function update_event_status($id, $data = array()) {
        $this->db->where('id', $id);
        return $this->db->update('events', $data);
    }

    public function update_preacher_status($id, $data = array()) {
        $this->db->where('id', $id);
        return $this->db->update('preachers', $data);
    }

    public function get_event($event_id) {
        return $this->db->select('e.*,t.name as event_type,c.id_countries as country_id,c.currency_code as currency_code,c.currrency_symbol as currrency_symbol,c.name as cname')
        ->from(IMS_DB_PREFIX . 'events as e')
        ->join('event_types as t', "t.id=e.type_id")
        ->join('countries as c', "c.id_countries=e.id_country")
        ->where('e.id', $event_id)
        ->get()
        ->row();
    }

    public function add_type($array) {
        if ($this->db->insert('event_types', $array))
            return $this->db->insert_id();
        return 0;
    }

    public function update_event_type($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('event_types', $data);
    }

    public function delete_type($type_id) {
        return $this->db->where("id", $type_id)
        ->delete('event_types');
    }

    public function get_event_images($event_id) {
        return $this->db->select('*')
        ->where('event_id', $event_id)
        ->get('event_images')
        ->result();
    }

    public function deleteeventgallery($path) {
        $this->db->where('image', $path)
        ->delete('event_images');
        if ('uploads/images/eventslider/14520608113861.png' != $path) {
            echo unlink('./' . $path);
        } else {
            echo true;
        }
    }

    function getPreachers() {
        $data = $this->db->select('*')
        ->order_by('timestamp', 'DESC')
        ->get('preachers')
        ->result();
        return $data;
    }

    function getRCPreachers($center_id){
        $data = $this->db->select('p.*')
        ->from('preachers AS p')
        ->join('center_preachers AS cp','p.id=cp.preacher_id')
        ->where('cp.center_id',$center_id)
        ->where('cp.status',1)
        ->group_by('p.id')
        ->order_by('p.timestamp', 'DESC')
        ->get()
        ->result();
        return $data;
    }

    function deletePreachers($id) {
        return $this->db->where('id', $id)
        ->delete('preachers');
    }

    function addNewPreacher($userarray) {
        $this->db->insert('preachers', $userarray);
        return $this->db->insert_id();
    }

    function get_event_preachers($event_id) {
        $data = $this->db->select('preacher_id')
        ->where('event_id', $event_id)
        ->get('event_preachers')->result_array();
        $result = array_column($data, 'preacher_id');
        return $result;
    }

    public function add_accomodation($array) {
        if ($this->db->insert('accomodation', $array))
            return $this->db->insert_id();
        return 0;
    }

    public function delete_accomodation($id) {
        return $this->db->where("id", $id)
        ->delete('accomodation');
    }

    public function update_accomodation($value, $where) {
        return $this->db->update('accomodation', $value, $where);
    }

    //return all accomodation details
    public function getAllAccomodation() {
        return $this->db->select('accomodation.*,countries.currency_code,countries.name')
        ->from('accomodation')
        ->join('countries', 'countries.id_countries=accomodation.currency')
        ->get()
        ->result();
    }

    function loadAddedAccomodation($id) {
        $data = $this->db->select('*')
        ->where('event_id', $id)
        ->get('event_accommodation')->result();
        $array = array();
        $k = 0;
        foreach ($data as $row) {
            $array['type'][$k] = $row->type;
            $array['event_id'][$k] = $row->event_id;
            $array['rate'][$k] = $row->adult;
            $array['child'][$k] = $row->child;
            $array['seats'][$k] = $row->seats;
            $array['id'][$k] = $row->id;
            $k++;
        }
        return $array;
    }

    
function getExistingPreachers($center_id){
        return $this->db->select('p.*')
        ->from('preachers AS p')
        ->where('p.id NOT IN (select preacher_id from center_preachers where center_id = '.$center_id.')')
        ->group_by('p.id')
        ->order_by('p.timestamp', 'DESC')
        ->get()
        ->result();
    }

    function approve_preacher(){
        $data = $this->db->select('cp.id,p.name as preachername, c.name as centername')
        ->from('preachers AS p')
        ->join('center_preachers AS cp','p.id=cp.preacher_id')
        ->join('center AS c','c.id=cp.center_id')
        ->where('cp.status',0)
        ->order_by('cp.timestamp', 'DESC')
        ->get()
        ->result();
        return $data;
    }

}

?>
