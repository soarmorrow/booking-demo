<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Description of preachers
 *
 * @author lenovo
 */
class Preachers extends Public_Controller {
	public $data;
    //put your code here
	public function __construct() {
		parent::__construct();
		$this->load->library('facebook'); 
        // Automatically picks appId and secret from config
		$this->load->model(['preachers_model','centre_public/centre_public_model','event_public/event_public_model']);
        //$this->load->library('pagination');
	}
	
	
	public function index() {
		$this->data['languages'] = $this->preachers_model->getAll('languages');
		$this->data['status'] = $this->preachers_model->getAll('preachers_status');
		$this->data['expertise'] = $this->preachers_model->getAll('area_of_expertise');
		$this->data['preachers'] = $this->preachers_model->getPreachers();
		$this->gr_template->build('preachers', $this->data);
	}

	function getMorePreachers($currentpage = 0) {
		if($this->input->post('role')){
			$role=$this->input->post('role');
		}else{
			$role=null;
		}	
		if($this->input->post('language')){
			$language=$this->input->post('language');
		}else{
			$language=null;
		}	
		if($this->input->post('field')){
			$field=$this->input->post('field');
		}else{
			$field=null;
		}			
		$data['preachers'] = $this->preachers_model->getPreachers($currentpage,$role,$language,$field);
		
		$list = $this->load->view('more_preachers', $data, true);
		if (!$list) {
			$status = false;
		} else {
			$status = true;
		}
		$status = $this->preachers_model->getmorePreachers($currentpage + 1);
		$datalist = array('status' => $status, 'data' => $list);
		echo json_encode($datalist);
	}
	
	public function preachers_profile($id){
		$ip = $_SERVER['REMOTE_ADDR'];
		$rows=$this->event_public_model->get_views_by_ip($ip,$id,3);
		if($rows == 0){

			$value=array('item_id'=>$id,
				'ip_address'=>$ip,
				'type_id'=>3
				);

			$table='views';
			$this->event_public_model->insertRow($value,'views',true);

		}
		$this->data['body_class'] = 'pic-body';
		$this->data['id'] = $id;
		$this->data['liked'] = $this->centre_public_model->getOneWhere(array('user_id'=>$this->gr_auth->customer_user_id(),'type_id'=>3,'item_id'=>$id),'likes');
		$this->data['likes']=$this->centre_public_model->get_likes_count_by_item_id($id,3);
		$this->data['preacher'] = $this->preachers_model->get_preacher_details_by_id($id);
		$preacher_meta = new stdClass();
		$preacher_meta->title = $this->data['preacher']->name;
		$preacher_meta->content = $this->data['preacher']->description;
		$preacher_meta->path = $this->data['preacher']->image;
		$preacher_meta->timestamp = $this->data['preacher']->timestamp;
		$this->data['meta'] = $preacher_meta;
		$this->data['associated_centres'] = $this->preachers_model->associated_centres($id);
		$this->data['program_schedule'] = $this->preachers_model->program_schedule($id);
		$this->data['count'] = $this->preachers_model->associated_centres_count($id);
		$this->gr_template->build('preachers_profile', $this->data);
	}
	
	function getPschedule($id){
		$this->data['program_schedule'] = $this->preachers_model->program_schedule($id);
		$this->load->view('program_schedule', array('program_schedule'=>$this->data['program_schedule']));
		
	}

	public function like($id){
		$user_id = $this->gr_auth->customer_user_id();
		$like=array(
			'type_id'=>3,
			'user_id'=>$this->gr_auth->customer_user_id(),
			'item_id'=>$id,
			'status'=>1
			);
		$count=$this->centre_public_model->get_likes_count($id,$this->gr_auth->customer_user_id(),3);
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

}