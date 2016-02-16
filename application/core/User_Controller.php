<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('gr_auth', IMS_DB_PREFIX . 'customer');
        if (!$this->gr_auth->customer_logged_in()) {
            if ($this->input->is_ajax_request()) {
                echo "<script type='text/javascript'>$(function(){window.location='" . site_url('customer') . "';});</script>";
                exit;
            } else {
                redirect(site_url('customer'));
            }
        }
        $this->gr_template
                ->enable_parser(FALSE)
                ->set_theme('user')
                ->set_layout('default')
                ->title("User's Portal")
                ->set_partial('head');
        $this->data['theme_path'] = 'themes/user/';
    }

}
