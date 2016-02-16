<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author Lachu
 */
class search extends Public_Controller {

    public $data;

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('facebook');
        $this->load->model(['centre_public/centre_public_model', 'event_public/event_public_model','rating/rating_model']);
        $this->load->model('search_model');
        $this->load->library('pagination');
    }

    public function index() {
        if ($this->input->get()) {
            # code...
            $key=$this->input->get('search_keyword');
            if($key!=''){
                $this->setFilterInnerKey($key);
                redirect(site_url('search'));
            }
        }
        $filter = array('lang' => null, 'inner_key' => NULL, 'cntr' => null, 'key' => NULL, 'centre' => NULL, 'centre_lang' => null, 'month' => null, 'startdate' => null, 'enddate' => null);
        if ($this->input->post()) {
            if ($this->input->post('query')) {
                $filter['key'] = trim($this->input->post('query'));
            } else {
                if ($this->session->userdata('key')) {
                    $filter['key'] = $this->session->userdata('key');
                }
                if ($this->session->userdata('inner_key')) {
                    $filter['inner_key'] = $this->session->userdata('inner_key');
                }
            }
            if ($this->input->post('centre')) {
                $filter['centre'] = $this->input->post('centre');
                $filter['cntr'] = $filter['centre'];
            } else if ($this->session->userdata('centre')) {
                $filter['centre'] = $this->session->userdata('centre');
                $filter['cntr'] = $this->session->userdata('cntr');
            }
            if ($this->input->post('centre_lang')) {
                $filter['centre_lang'] = $this->input->post('centre_lang');
                $filter['lang'] = $filter['centre_lang'];
            } else if ($this->session->userdata('centre_lang')) {
                $filter['centre_lang'] = $this->session->userdata('centre_lang');
                $filter['lang'] = $this->session->userdata('lang');
            }
            if ($this->input->post('startdate')) {
                $st = strtotime(str_replace('/', '-', $this->input->post('startdate')));
                $filter['startdate'] = date('Y-m-d H:i:s', $st);
                $filter['month'] = "For " . date('F', $st);
            }

            if ($this->input->post('enddate')) {
                $filter['enddate'] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->post('enddate'))));
            }
        } else {
            $filter = $this->session->userdata('filter');
            $filter['key'] = (isset($filter['key'])) ? $filter['key'] : NULL;
            $filter['startdate'] = (isset($filter['startdate'])) ? $filter['startdate'] : NULL;
            $filter['enddate'] = (isset($filter['enddate'])) ? $filter['enddate'] : NULL;
            $filter['centre'] = (isset($filter['centre'])) ? $filter['centre'] : NULL;
            $filter['centre_lang'] = (isset($filter['centre_lang'])) ? $filter['centre_lang'] : NULL;
            $filter['month'] = (isset($filter['month'])) ? $filter['month'] : NULL;
            $filter['lang'] = (isset($filter['lang'])) ? $filter['lang'] : NULL;
            $filter['cntr'] = (isset($filter['cntr'])) ? $filter['cntr'] : NULL;
            $filter['inner_key'] = (isset($filter['inner_key'])) ? $filter['inner_key'] : NULL;
        }
        
        $this->data['total'] = $this->search_model->search_center_count($filter);
        $this->data['filters'] = $filter;
        $this->session->set_userdata('filter', $filter);
        $dataresult = $this->search_model->search_center($filter, 0);
        $results = $dataresult->result();
        $resdata=array();
        foreach ($results as $result) {
            $result->rate = $this->centre_public_model->rate_of_the_centre($result->center_id);
            $result->liked = $this->centre_public_model->getOneWhere(array('user_id'=>$this->gr_auth->customer_user_id(),'type_id'=>2,'item_id'=>$result->center_id),'likes');
            $result->likes=$this->centre_public_model->get_likes_count_by_item_id($result->center_id,2);
            $result->reviews=$this->centre_public_model->get_reviews_count_by_item_id($result->center_id,2);
            $resdata[]=$result;
        }

        $this->data['results'] = $resdata;

        $this->data['loaded'] = $dataresult->num_rows();
        $this->data['searchtype'] = $this->search_model->getCenterTypes($filter);
        $this->data['searchlanguage'] = $this->search_model->getRetreatLanguage($filter);
        // debug($this->db->last_query());
        $this->gr_template->build('listing_page', $this->data);
    }

    function setFilter() {
        $filter = $this->session->userdata('filter');
        $filter['centre_lang'] = $this->input->post('lang');
        $filter['centre'] = $this->input->post('type');
        $this->session->set_userdata('filter', $filter);
    }

    function setFilterInnerKey($innerKey='') {
        $filter = $this->session->userdata('filter');
        if($innerKey==''){
            $filter['inner_key'] = $this->input->post('inner_key');
        }else{
            $filter['inner_key'] =$innerKey;
        }
        $this->session->set_userdata('filter', $filter);
        echo true;
//        debug($filter);
    }

    function loadmore($pagenum) {
        if (!$this->input->is_ajax_request()) {
            show_error("no direct access allowed", 404);
        }

        $filter = $this->session->userdata('filter');
        $total = $this->search_model->search_center_count($filter);
        $dataresult = $this->search_model->search_center($filter, $pagenum);
        if ($dataresult->num_rows() != 0) {
            $count = ($pagenum * 4) + $dataresult->num_rows();
        } else {
            $count = $total;
        }

        $more = 'false';
        if ($total > $count) {
            $more = 'true';
        }
        $results = $dataresult->result();
        $resdata=array();
        foreach ($results as $result) {
            $result->rate = $this->centre_public_model->rate_of_the_centre($result->center_id);
            $result->liked = $this->centre_public_model->getOneWhere(array('user_id'=>$this->gr_auth->customer_user_id(),'type_id'=>2,'item_id'=>$result->center_id),'likes');
            $result->likes=$this->centre_public_model->get_likes_count_by_item_id($result->center_id,2);
            $result->reviews=$this->centre_public_model->get_reviews_count_by_item_id($result->center_id,2);
            $resdata[]=$result;
        }

        $this->data['results'] = $resdata;
        $data = array('count' => $count, 'more' => $more, 'view' => $this->load->view('listing_more', array('results' => $this->data['results'], 'filters' => $filter), true));
        echo json_encode($data);
    }

    function events($id) {
        $filter = array('key' => NULL, 'centre' => NULL, 'centre_lang' => null, 'month' => null, 'startdate' => null, 'enddate' => null);
        if ($this->input->post()) {
            if ($this->input->post('query')) {
                $filter['key'] = trim($this->input->post('query'));
            } else if ($this->session->userdata('key')) {
                $filter['key'] = $this->session->userdata('key');
            }
            if ($this->input->post('centre')) {
                $filter['centre'] = $this->input->post('centre');
            }
            if ($this->input->post('centre_lang')) {
                $filter['centre_lang'] = $this->input->post('centre_lang');
            }
            if ($this->input->post('startdate')) {
                $st = strtotime(str_replace('/', '-', $this->input->post('startdate')));
                $filter['startdate'] = date('Y-m-d H:i:s', $st);
                $filter['month'] = "For " . date('F', $st);
            }

            if ($this->input->post('enddate')) {
                $filter['enddate'] = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->input->post('enddate'))));
            }
        } else {
            $filter = $this->session->userdata('filter');
            if (!isset($filter['key']) && !isset($filter['centre']) && !isset($filter['centre_lang'])) {
                $filter = array('key' => NULL, 'centre' => NULL, 'centre_lang' => null, 'month' => null, 'startdate' => null, 'enddate' => null);
            }
        }

        $events = $this->search_model->get_events($id, $filter);
        $this->data['total'] = $this->search_model->get_events_count($id, $filter);
        if ($this->gr_auth->customer_user_id()) {
            $this->data['user_id'] = $this->gr_auth->customer_user_id();
        }
        else{
            $this->data['user_id'] = 0;
        }
        $ip = $_SERVER['REMOTE_ADDR'];
        $rows=$this->event_public_model->get_views_by_ip($ip,$id,2);
        if($rows == 0){
            
            $value=array('item_id'=>$id,
                'ip_address'=>$ip,
                'type_id'=>2
                );

            $table='views';
            $this->event_public_model->insertRow($value,'views',true);

        }
        $this->data['review_count']=$this->centre_public_model->get_reviews_count_by_item_id($id,2);
        $this->data['liked'] = $this->centre_public_model->getOneWhere(array('user_id'=>$this->gr_auth->customer_user_id(),'type_id'=>2,'item_id'=>$id),'likes');
        $this->data['likes']=$this->centre_public_model->get_likes_count_by_item_id($id,2);
        $this->data['preachers'] = $this->search_model->get_preachers($id, $filter);
        $this->data['centre_lang'] = $this->search_model->get_centre_lang($id, $filter);
        $this->data['events'] = $events;
        $this->data['reviews'] = $this->event_public_model->getAllReviews_centre($id,2);
        $this->data['rate'] = $this->centre_public_model->rate_of_the_centre($id);
        $this->data['id'] = $id;
        $this->data['centre'] = $this->search_model->get_centre($id, $filter);
        $this->data['rc_images'] = $this->search_model->get_centre_images($id);
        $this->data['types'] = $this->search_model->get_all_event_types($filter);
        $this->data['dates'] = $this->search_model->events_group_by_month($id, $filter);
        // debug($events);
        $this->gr_template->build('centre_page', $this->data);
    }

    function getMoreEvents($id, $currentpage = 0) {
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
        } else {
            $type = null;
        }
        if ($this->input->post('month')) {
            $month = $this->input->post('month');
        } else {
            $month = null;
        }
        $filter = $this->session->userdata('filter');
        $data['events'] = $this->search_model->get_events($id, $filter, $currentpage, $type, $month);
        $type = $this->search_model->get_event_type_by_id($type);
        $count = $this->search_model->get_event_count_by_month($month, $id);
        $data['id'] = $id;
        $list = $this->load->view('more_events', $data, true);
        if (!$list) {
            $status = false;
        } else {
            $status = true;
        }
        $type = $this->input->post('type');
        $month = $this->input->post('month');

        $status = $this->search_model->getmoreEvents(null, $filter, $currentpage + 1, $type, $month);
        $datalist = array('status' => $status, 'data' => $list);
        echo json_encode($datalist);
    }

    public function getMorePreachers($id, $currentpage = 0) {
        $filter = $this->session->userdata('filter');
        $data['preachers'] = $this->event_public_model->get_preachers($id, $currentpage, $filter);
        $list = $this->load->view('more_preachers', $data, true);
        if (!$list) {
            $status = false;
        } else {
            $status = true;
        }
        $status = $this->event_public_model->getMorePreachers($currentpage + 1);
        $datalist = array('status' => $status, 'data' => $list);
        echo json_encode($datalist);
    }

    function clearsearch() {
        $this->session->unset_userdata('filter');
        redirect(site_url('search'));
    }

    public function like($id){
        $user_id = $this->gr_auth->customer_user_id();
        $like=array(
            'type_id'=>2,
            'user_id'=>$this->gr_auth->customer_user_id(),
            'item_id'=>$id,
            'status'=>1
            );
        $count=$this->centre_public_model->get_likes_count($id,$this->gr_auth->customer_user_id(),2);
        if($count){
            $response['code'] = 300;
            $response['status'] = false;
            $response['message'] = "You have already liked this page ";
        }
        else{
            if ($user_id!=0) {
                $this->centre_public_model->insertRow($like, 'likes', true);
                $response['code'] = 200;
                $response['status'] = true;
                $response['message'] = "You have liked successfully";
            }
            else{
                $response['code'] = 300;
                $response['status'] = false;
                $response['message'] = "Please login to like this page";

            }
        }

        echo json_encode($response);
        exit;

    }

    public function review($id){
        $this->form_validation->set_rules('review','Review','required');
        $response = array();
        $user_id = $this->gr_auth->customer_user_id();
        $centre_id = $this->rating_model->get_center_by_event_id($id);
        if($this->form_validation->run()){
            if ($this->input->post()) {
                $rate = $this->input->post('rate',TRUE);
                $review = $this->input->post('review', TRUE);
                if($user_id!=0){
                    $value=array(
                        'type_id'=>2,
                        'user_id'=>$user_id,
                        'item_id'=>$id,
                        'comment'=>$review
                        );
                    if($review!=""){
                     $this->event_public_model->insertRow($value,'reviews');   
                 }
                 
                 $response['code'] = 200;
                 $response['message'] = "commented successfully";
                 die(json_encode($response));
             }
             else{
                $response['code'] = 300;
                $response['message'] = "Please login to post your review"; 
                die(json_encode($response)); 
            }
        }
    }
    $response['code'] = 500;
    $response['message'] = "Invalid request";
    echo json_encode($response);
    echo FALSE;
    exit();
}

public function get_counts($id){
    echo $this->centre_public_model->get_reviews_count_by_item_id($id,1);exit;
}

}

?>
