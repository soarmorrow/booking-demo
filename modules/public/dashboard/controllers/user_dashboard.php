<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user_dashboard
 *
 * @author lenovo
 */
class user_dashboard extends Public_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
		$this->load->library('facebook'); 
        $this->load->library('gr_auth', IMS_DB_PREFIX . 'customer');
        $this->load->model(['user_home_model','event_public/event_public_model','rating/rating_model']);
    }

    function index() {
        redirect(site_url('user_dashboard/mybookings'));
    }

    public function mybookings($id='') {
        $customer_id = $this->gr_auth->customer_user_id();
        $this->data['resultarray'] = $this->user_home_model->getMyBookings($customer_id);
        $this->data['user_id'] = $customer_id;
        $this->gr_template->build('bookings', $this->data);
    }

    public function get_event_reviews($id=''){
        $this->data['reviews'] = $this->event_public_model->getAllReviews($id, 1);
         $this->load->view('ratings',$this->data);
    }

    function cancelbooking($id = '') {
        $customer_id = $this->gr_auth->customer_user_id();
        $transact = $this->user_home_model->getTransaction($id, $customer_id);
        if ($transact) {
            $this->user_home_model->refundTransaction($transact);
        }
        echo 'true';
    }
      public function review($id) {
        $response = array();
        $user_id = $this->gr_auth->customer_user_id();
        $centre_id = $this->rating_model->get_center_by_event_id($id);
        if ($this->input->post()) {
            $rate = $this->input->post('rate', TRUE);
            $review = $this->input->post('review', TRUE);
            if ($user_id != 0) {
                $value = array(
                    'type_id' => 1,
                    'user_id' => $user_id,
                    'item_id' => $id,
                    'comment' => $review
                );
                if ($review != "") {
                    $this->event_public_model->insertRow($value, 'reviews');
                }

                $count = $this->event_public_model->getOneWhere(array('user_id' => $user_id, 'event_id' => $id), 'rating');
                if ($count) {
                    $where = array('user_id' => $user_id, 'event_id' => $id);
                    $data = array('rating' => $rate);
                    $this->event_public_model->updateWhere($where, $data, 'rating');
                } else {
                    $value = array('user_id' => $user_id,
                        'event_id' => $id,
                        'centre_id' => $centre_id->id,
                        'rating' => $rate
                    );
                    $this->event_public_model->insertRow($value, 'rating');
                }

                $response['code'] = 200;
                $response['message'] = "commented successfully";
                die(json_encode($response));
            } else {
                $response['code'] = 300;
                $response['message'] = "Please login to post your review";
                die(json_encode($response));
            }
        }

        $response['code'] = 500;
        $response['message'] = "Invalid request";
        echo json_encode($response);
        echo FALSE;
        exit();
    }
    
}
