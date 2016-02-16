<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Benefactors
 *
 * @author Lachu
 */
class Benefactors extends Public_Controller {

	//put your code here
	public function __construct() {
		parent::__construct();
		$this->load->library('facebook'); 
		$this->load->model('benefactors_model');
        //$this->load->library('pagination');
	}
	
	public function index($id=1){
		$this->data['benefactor_type']=$this->benefactors_model->getOneWhere(array('id'=>$id  ), 'benefactor_type') ;
		$this->data['benefactors'] = $this->benefactors_model->get_benefactors($id);
		$this->gr_template->build('benefactors', $this->data);
	}


	public function changeType($id=1){
		$this->data['benefactor_type']=$this->benefactors_model->getOneWhere(array('id'=>$id  ), 'benefactor_type') ;
		$this->data['benefactors'] = $this->benefactors_model->get_benefactors($id);
		if($id==1){
			$this->load->view('platinum_list', $this->data);
		}
		else{
			$this->load->view('gold_silver_list', $this->data);
		}
	}
}