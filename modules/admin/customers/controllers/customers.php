<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class customers extends Admin_Controller {

    //put your code here
	function __construct() {
		parent::__construct();
		$this->load->model('customers_model');
		$this->form_validation->set_error_delimiters('<label class="control-label h5" for="inputError">', '</label>');
		$this->load->library('pagination');
		if (!_can("Customer")) {
			redirect(site_url("dashboard"));
		}
	}

	function index() {
		if (_can("Customer")) {
			if ($this->input->post()) {
				$this->form_validation->set_rules('customer', 'Name', 'trim|required|is_unique[benefactors.customer_id]');
				$this->form_validation->set_rules('benefactor','Benefactor Type' , 'required');
				if ($this->form_validation->run() === TRUE) {
					if ($this->customers_model->add_benefactor(array('customer_id' => $this->input->post('customer', TRUE), 'benefactor_type' => $this->input->post('benefactor',TRUE)))) {
						$this->session->set_flashdata('message', array("class" => "success", "message" => "New Benefactor added"));
						redirect(current_url());
					}
				} else {
					$this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add new benefactor"));
					redirect(current_url());
				}
			}
		}
		$this->data['customers'] = $this->customers_model->getcustomers();
		$this->data['benefactors'] = $this->customers_model->getbenefactors();
		$this->gr_template->build('benefactors', $this->data);

	}

	function delete_benefactor($id) {
		echo $this->customers_model->delete_benefactor($id);
	}

	public function update_benefactor() {
		$response = array();
		if ($this->input->post()) {
			$this->form_validation->set_rules('benefactor_type','Benefactor Type' , 'required');
			if ($this->form_validation->run()) {
				$id = $this->input->post('id', TRUE);
				$benefactor = $this->input->post('benefactor_type', TRUE);
				$this->customers_model->update_benefactor_type(array('benefactor_type' => $benefactor),array('id'=>$id));
				$response['code'] = 200;
				$response['message'] = $this->customers_model->getOneWhere(array('id'=>$id), 'benefactors');
				echo json_encode($response);
				exit;
			}else{
				debug(validation_errors());
				$response['code'] = 200;
				$response['message'] = "hello";
				echo json_encode($response);
				exit;
			}

		}
		$response['code'] = 500;
		$response['message'] = "Invalid request";
		echo json_encode($response);
		echo FALSE;
		exit();
	}
}