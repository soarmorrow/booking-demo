<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_home_model
 *
 * @author lenovo
 */
class user_home_model extends MY_Model {

    //put your code here
    public function __construct($table_name = NULL, $primary_key = NULL) {
        parent::__construct($table_name, $primary_key);
    }

    public function getMyBookings($customer_id) {
        $result = $this->db->select('eo.*,e.start_date,e.id AS event_id,e.end_date,e.name AS event_name,rc.name AS center_name,rc.id AS centre_id')
                        ->join('events AS e', 'e.id=eo.event_id')
                        ->join('center AS rc', 'rc.id=e.center_id')
                        ->where('customer_id', $customer_id)
                        ->get('event_orders AS eo')
                        ->result();
        return $result;
    }

    public function getTransaction($id, $customer_id) {
        $eo = $this->db->select('*')
                ->where('customer_id', $customer_id)
                ->where('id', $id)
                ->limit(1)
                ->get('event_orders');
        if ($eo->num_rows() === 1) {
            return $eo->row();
        }
    }

    public function refundTransaction($transact) {
            $from = "USD";
            $from_c=$this->db->select('*')->where('currency_code', $from)->get('countries')->row();
        $money = $this->db->select('e.attendance_fee,c.currency_code,e.id_country')
                        ->from('events AS e')
                        ->join('countries AS c', 'c.id_countries=e.id_country')
                        ->where('e.id', $transact->event_id)
                        ->get()->row();
        $wallet1 = $this->db->select('cw.*,c.currency_code')
                ->from('customer_wallet AS cw')
                ->join('countries AS c', 'c.id_countries=cw.country_id')
                ->where('customer_id', $transact->customer_id)
                ->where('status', 1)
                ->limit(1)
                ->get();
        if ($wallet1->num_rows() === 1) {
            $wallet = $wallet1->row();
            $to = $wallet->currency_code;
            if ($from != $to) {
                $content = file_get_contents("http://query.yahooapis.com/v1/public/yql?q=select%20*%20from%20yahoo.finance.xchange%20where%20pair%20in%20%28%22" . $from . $to . "%22%29&format=json&env=store://datatables.org/alltableswithkeys");
                $data = json_decode($content);
                $rate = $data->query->results->rate->Rate;
                $total = $wallet->balance + ($rate * $money->attendance_fee * $transact->attend);
                $delete = $this->db->where('id', $transact->id)
                        ->delete('event_orders');
                if ($delete) {
                    return $this->db->where('id', $wallet->id)
                                    ->update('customer_wallet', array('balance' => $total));
                }
            } else {
                $total = $wallet->balance +  ($money->attendance_fee * $transact->attend);
                $delete = $this->db->where('id', $transact->id)
                        ->delete('event_orders');
                if ($delete) {
                    return $this->db->where('id', $wallet->id)
                                    ->update('customer_wallet', array('balance' => $total));
                }
            }
        } else {
            $array = array(
                'customer_id' => $transact->customer_id,
                'balance' => $money->attendance_fee * $transact->attend,
                'country_id' => $from_c->id_countries,
                'status' => 1
            );
            $delete = $this->db->where('id', $transact->id)
                    ->delete('event_orders');
            if ($delete) {
                return $this->db->insert('customer_wallet', $array);
            }
        }
//$content
    }

}
