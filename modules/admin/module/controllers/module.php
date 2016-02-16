<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of module
 *
 * @author soarmorrow
 */
class module extends Admin_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('module_model');
        $this->form_validation->set_error_delimiters('<label class="control-label h5" for="inputError">', '</label>');
        if (!_can("Module")) {
            redirect(site_url("dashboard"));
        }
    }

    function index() {
        $this->gr_template->build('module', $this->data);
    }
}
