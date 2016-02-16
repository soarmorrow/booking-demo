<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('dashboard_model'));
	}

	function index() {
		if (_is("RC Admin")) {
			$center = $this->session->userdata('current_centre_role')->center_id;
			$this->data['center_name'] = $this->dashboard_model->get_centername($center);
			$this->gr_template->build('rc_dashboard', $this->data);
		} else 
		// if (_is('GR Admin')) {
			$this->gr_template->build('dashboard', $this->data);
		// }
	}

}
