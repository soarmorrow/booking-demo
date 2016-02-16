<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Public_Controller extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('gr_auth', IMS_DB_PREFIX . 'customer');
        $this->load->model(array('admin_common_model'));
        $this->data['current_user'] = $this->current_user = $this->admin_common_model->getCurrentCustomer($this->gr_auth->customer_user_id());
        $this->data['searchtype'] = $this->admin_common_model->getRcTypes();
        $this->data['searchlanguage'] = $this->admin_common_model->getRetreatLanguage();
        $this->gr_template
                ->enable_parser(FALSE)
                ->set_theme('user')
                ->set_layout('default')
                ->title("User's Portal")
                ->set_partial('head')
                ->set_partial('homeslider')
                ->set_partial('header')
                ->set_partial('footerbanner')
                ->set_partial('footer');
        $this->data['theme_path'] = 'themes/user/';
        $currency = $this->session->userdata('country_selected');
        if ($currency) {
            $this->data['currency_id'] = $currency;
        } else {
            $this->data['currency_id'] = 98;

            $this->session->set_userdata(array('country' => $this->data['currency_id'], 'country_selected' => $this->data['currency_id']));
        }
    }

}
