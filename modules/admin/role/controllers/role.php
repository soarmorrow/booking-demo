<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of role
 *
 * @author soarmorrow
 */
class role  extends Admin_Controller{
    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('role_model');
        $this->form_validation->set_error_delimiters('<label class="control-label h5" for="inputError">', '</label>');
        if (!_can("Role")) {
            redirect(site_url("dashboard"));
        }
    }

    function index() {
        $modules=$this->role_model->getRoleModules($this->current_user->id);
        $this->data['modules']=$modules;
        $this->gr_template->build('role', $this->data);
    }
}
