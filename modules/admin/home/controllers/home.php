<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends My_Controller {

    function __construct() {

        parent::__construct();
    }

    function index() {
        redirect(site_url('system'));
    }

}
