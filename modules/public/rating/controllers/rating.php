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
class Rating extends Public_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('facebook'); 
        $this->load->library('gr_auth', IMS_DB_PREFIX . 'customer');
        $this->load->model('rating_model');

        $this->append_stylesheet('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css');
        $this->append_javascript('https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js');
    }

    function index($id){
        $this->data['event_id'] =$id;
        $this->data['current_rating'] = $this->rating_model->getOneWhere(array('event_id' => $id, 'user_id' => $this->gr_auth->customer_user_id()));
        $this->gr_template->build('rating', $this->data);
    }

    function rate_event($id){
        if($this->input->post()){
           $centre_id = $this->rating_model->get_center_by_event_id($id);
           $values = array(
            'user_id'=>$this->gr_auth->customer_user_id(),
            'event_id' =>$id,
            'centre_id'=>$centre_id->id,
            'rating' =>$this->input->post('rate')
            ); 
           $current_rating =   $this->rating_model->getOneWhere(array('event_id' => $id, 'user_id' => $this->gr_auth->customer_user_id()));
           if($current_rating){
            $this->rating_model->updateRow($current_rating->id, array('rating' => $this->input->post('rate')));
        }else{
            $this->rating_model->insertRow($values);
        }

        redirect('rating');
    }


}
public function get_counts($event_id){
    echo $this->rating_model->getRatingCount($event_id,  $this->gr_auth->customer_user_id()
            
            );exit;
}
}