<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of booking_model
 *
 * @author Lachu
 */
class booking_model extends MY_Model {

    //put your code here
    public function __construct($table_name = NULL, $primary_key = NULL) {
        parent::__construct($table_name, $primary_key);
    }

    public function getBookingsEvents($filters,$center=NULL) {
        if (_is("RC Admin")) {
            $this->db->where('e.center_id', $center);
        }

        $this->db->select('e.*,c.name AS center_name, SUM(eo.attend) AS booked')
                ->from('event_orders AS eo')
                ->join('events AS e', 'e.id=eo.event_id', "RIGHT");
        if (!$filters) {
            $this->db->limit(10);
        } else {
            if ($filters['key'] != '') {
                $this->db->like('e.name', $filters['key']);
                $this->db->or_like('c.name', $filters['key']);
//                $this->db->or_having('SUM(eo.attend)', $filters['key']);
            }
            if ($filters['center_id'] != '') {
                $this->db->where('e.center_id', $filters['center_id']);
            }
        }
//            
        $this->db->join('center AS c', 'c.id=e.center_id');
        $data = $this->db->order_by('e.added_date', "DESC")
                ->group_by('e.id')
                ->get()
                ->result();
//        debug($this->db->last_query());
        return $data;
    }

    public function get_veg_meals_count($event_id){
        return $this->db->select('SUM(event_orders.attend) as meals')
                        ->from('event_orders')
                        ->where('event_id', $event_id)
                        ->where('meals', 0)
                        ->get()
                        ->row();
    }

    public function get_non_veg_meals_count($event_id){
        return $this->db->select('SUM(event_orders.attend) as meals')
                        ->from('event_orders')
                        ->where('event_id', $event_id)
                        ->where('meals', 1)
                        ->get()
                        ->row();
    }



    public function getCenters() {
        return $this->db->select('id,name')
                        ->where('is_deleted', 0)
                        ->get('center')
                        ->result();
    }

    public function getBookings($filters) {
        $this->db->select('eo.id,eo.event_id,c.first_name,c.last_name,eo.email,eo.attend,e.name AS event_name,oi.transation_id,g.name AS gateway_name,eo.timestamp');
        $this->db->from('event_orders AS eo')
                ->join('events AS e', 'e.id=eo.event_id')
                ->join("order_items AS oi", "eo.id=oi.order_id")
                ->join('gateway AS g', "g.id=oi.gateway_id")
                ->join("customer AS c", "c.id=eo.customer_id")
                ->group_by("eo.id")
                ->order_by('eo.timestamp', "DESC");
        if (!$filters) {
            $this->db->limit(10);
        }
        $data = $this->db->get()
                ->result();
//        debug($data);
        return $data;
    }

    public function getBookingdata($event_id) {
        $data = $this->db->select('e.*,t.name as event_type,c.id_countries as country_id,c.currency_code as currency_code,c.currrency_symbol as currrency_symbol,c.name as cname')
                ->from(IMS_DB_PREFIX . 'events as e')
                ->join('event_types as t', "t.id=e.type_id")
                ->join('countries as c', "c.id_countries=e.id_country")
                ->where('e.id', $event_id)
                ->get()
                ->row();
        $this->db->select('eo.id,eo.event_id,c.first_name,c.last_name,eo.email,eo.attend,e.name AS event_name,oi.transation_id,g.name AS gateway_name,eo.timestamp');
        $this->db->from('event_orders AS eo')
                ->join('events AS e', 'e.id=eo.event_id')
                ->join("order_items AS oi", "eo.id=oi.order_id")
                ->join('gateway AS g', "g.id=oi.gateway_id")
                ->join("customer AS c", "c.id=eo.customer_id")
                ->where('eo.event_id', $event_id)
                ->group_by("eo.id")
                ->order_by('eo.timestamp', "DESC");
        $order = $this->db->get()
                ->result();
        $returnarray = array("event" => $data, 'order' => $order);
        return $returnarray;
    }

}

?>
