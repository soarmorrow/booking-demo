<?php

class promo_code_model extends MY_Model {

    function __construct($table_name = NULL, $primary_key = NULL) {
        parent::__construct($table_name, $primary_key);
    }

    public function getallEvents($user_id) {
        $this->db->select('*');
        if (!_is("GR Admin")) {
            $this->db->where('create_id', $user_id);
        }
        $result = $this->db->get('events');
        return $result;
    }

    public function getEventsPromocode($user_id, $flag, $array = array()) {
        $result = array();
        $this->db->select('p.*,c.currency_code,c.currrency_symbol,e.name as event_name')
                ->from('promo_code as p')
                ->join('promotion_event_relation as pr', "pr.promo_id=p.id")
                ->join('events AS e', 'pr.event_id=e.id')
                ->join('countries as c', "c.id_countries=p.type", "LEFT");
        if (!empty($array)) {
            if ($array['event_id'] != '') {
                $this->db->where('pr.event_id', $array['event_id']);
            }
            if ($array['promo_key'] != '') {
                $this->db->where("(`e`.`name`  LIKE '%" . $array['promo_key'] . "%' OR  UPPER(p.promo_code)  LIKE '%UPPER(" . $array['promo_key'] . ")%' OR  `p`.`expire_time`  LIKE '%" . $array['promo_key'] . "%' OR  `p`.`value`  LIKE '%" . $array['promo_key'] . "%')");
            }
        }
        $this->db->where('p.is_deleted', 0)
                ->where('p.flag', $flag)
                ->where('p.expire_time > CURDATE() - 1')
                ->order_by('p.expire_time', "DESC");
        $this->db->limit($array['per_page'], ($array['page'] - 1) * $array['per_page']);
        $result = $this->db->get()
                ->result();
        return $result;
    }

    public function getEventsPromoRangecode($user_id) {
        $result = $this->db->select('p.*')
                ->from('promo_range_crowd as p')
//                    ->where('p.expire_time > CURDATE() - 1')
                ->get()
                ->result();
        return $result;
    }

    public function deletepromo($id, $array) {
        return $this->db->where('id', $id)
                        ->update('promo_code', $array);
    }

    public function deletepromo_crowd($id) {
        $data = $this->db->select('p.*')
                ->from('promo_code AS p')
                ->join('promo_range_crowd AS pr', "p.description=CONCAT(pr.low,'-',pr.high)")
                ->where('pr.id', $id)
                ->get()
                ->row();
        $this->db->where('id', $id)
                ->delete('promo_range_crowd');
        return $this->db->where('id', $data->id)
                        ->delete('promo_code');
    }

    public function checkuniquepromo($promo_code, $event_id = NULL) {
        if ($event_id == NULL) {
            $result = $this->db->select('*')
                    ->from('promo_code as p')
                    ->where('p.promo_code', $promo_code)
                    ->where('p.flag', 1)
                    ->get();
        } else {
            $result = $this->db->select('*')
                    ->from('promo_code as p')
                    ->join('promotion_event_relation as pr', "pr.promo_id=p.id")
                    ->where('p.promo_code', $promo_code)
                    ->where('pr.event_id', $event_id)
                    ->get();
        }
        if ($result->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function getuniqueramdomcode($event_id) {
        while (true) {
            $string = strtoupper(random_string('alpha', 6));
            if ($this->checkuniquepromo($string, $event_id)) {
                return $string;
            }
        }
    }

    public function getuniqueramdomcodecrowd() {
        while (true) {
            $string = strtoupper(random_string('alpha', 8));
            if ($this->checkuniquepromo($string)) {
                return $string;
            }
        }
    }

    public function insertpromocode($array) {
        $this->db->insert('promo_code', $array);
        return $this->db->insert_id();
    }

    function insertpromorangecode($array) {
        $this->db->insert('promo_range_crowd', $array);
        return $this->db->insert_id();
    }

    public function eventpromo($array) {
        return $this->db->insert('promotion_event_relation', $array);
    }

    public function insertCrowd($insert) {
        $query = "SELECT * FROM (`promo_range_crowd`) WHERE `low` <= " . $insert['value'] . " AND `high` >= " . $insert['value'];
        $result = $this->db->query($query);
        if ($result->num_rows() > 0) {
            $data = $result->result();
            $result1 = $this->db->select('*')
                    ->where('description', $data[0]->low . '-' . $data[0]->high)
                    ->get('promo_code');
            if ($result1->num_rows() == 0) {
                $row = array(
                    'promo_code' => $this->getuniqueramdomcodecrowd(),
                    'description' => $data[0]->low . '-' . $data[0]->high,
                    'value' => $data[0]->value,
                    'type' => 0,
                    'flag' => 1,
                    'expire_time' => $data[0]->expire_time,
                    'status' => 1,
                    'timestamp' => date(DATE_FORMAT, time())
                );
                $this->db->insert('promo_code', $row);
            }
            $crowd_users = $this->db->select('*')
                    ->where('email', $insert['email'])
                    ->get('crowd_users');
            if ($crowd_users->num_rows() == 0) {
                $this->db->insert('crowd_users', $insert);
            } else {
                $this->db->where('email', $insert['email'])
                        ->update('crowd_users', array('value' => $insert['value']));
            }
        }
    }

    public function get_promo_count($filters) {
        $this->db->select('p.*,c.currency_code,c.currrency_symbol,e.name as event_name')
                ->from('promo_code as p')
                ->join('promotion_event_relation as pr', "pr.promo_id=p.id")
                ->join('events AS e', 'pr.event_id=e.id')
                ->join('countries as c', "c.id_countries=p.type", "LEFT");
        if (!empty($filters)) {
            if ($filters['promo_key'] != '') {
                $this->db->where("(`e`.`name`  LIKE '%" . $filters['promo_key'] . "%' OR  UPPER(p.promo_code)  LIKE '%UPPER(" . $filters['promo_key'] . ")%' OR  `p`.`expire_time`  LIKE '%" . $filters['promo_key'] . "%' OR  `p`.`value`  LIKE '%" . $filters['promo_key'] . "%')");
//                $this->db->or_like('UPPER(p.promo_code)', "UPPER(".$filters['promo_key'].")");
//                $this->db->or_like('p.expire_time', $filters['promo_key']);
//                $this->db->or_like('p.value', $filters['promo_key']);
            }
            if ($filters['event_id'] != '') {
                $this->db->where('pr.event_id', $filters['event_id']);
            }
        }
        $result = $this->db->where('p.is_deleted', 0)
                ->where('p.flag', 0)
                ->where('p.expire_time > CURDATE() - 1')
                ->order_by('p.expire_time', "DESC")
                ->get();
        return $result->num_rows();
    }

    public function get_by_ip($ip) {
        // Unsigned long representation of ip address
        $ulip = sprintf("%u", ip2long($ip));
        $query = $this->db->select('c.currency_name,c.currency_code,c.id_countries')
                ->from('ref_iptocountry AS r')
                ->join('countries AS c', 'c.iso_alpha2=r.country_code')
                ->where('r.ip_from <=' . $ulip)
                ->where('r.ip_to >=' . $ulip)
                ->get();
        if ($row = $query->row()) {
            return $row->id_countries;
        }
        return FALSE;
    }
//    public function upload_promo($arraydata,$event_id,$userid) {
//        $this->db->select();
//    }
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
