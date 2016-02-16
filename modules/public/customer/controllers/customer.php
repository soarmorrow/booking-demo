<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of customer
 *
 * @author lenovo
 */
class customer extends MY_Controller {

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->library('gr_auth', IMS_DB_PREFIX . 'customer');
        $this->load->model('customer_model');
        $this->load->library(array('form_validation'));
        $this->form_validation->set_error_delimiters('', '');

        $this->gr_template
                ->enable_parser(FALSE)
                ->set_theme('admin')
                ->set_layout('login')
                ->set_partial('login_head')
                ->set_partial('login_script');

        $this->data['theme_path'] = 'themes/admin/';

//        $language_setting = $this->options_model->getOption('language_setting');
//        if (isset($language_setting) && !empty($language_setting)) {
//            $this->language = $language_setting['language'];
//            $this->lang->load(strtolower(get_class($this)), $this->language);
////            $this->lang->load($this->language, 'common/' . $this->language);
//        } else {
//            $this->lang->load(strtolower(get_class($this)), $this->language);
//            $this->lang->load($this->language, 'common/' . $this->language);
//        }
    }

    public function index() {
        $this->data['message'] = '';
        $this->data['error'] = '';
        if ($this->gr_auth->logged_in()) {
            if ($this->session->userdata('pay_url')) {
                redirect($this->session->userdata('pay_url'));
            }
            redirect(site_url('user_dashboard'));
        }
//        maintain_ssl($this->config->item("ssl_enabled"));

        $this->load->library('facebook'); // Automatically picks appId and secret from config
        $user = null;
        if ($this->session->userdata('loginfb') == 'true') {
            $user = $this->facebook->getAccessToken();
        }
        if ($user) {
            try {
                $data['user_profile'] = $this->facebook->api('/me?fields=id,name,first_name,last_name,email,link');
                $data['user_profile']['accesstoken'] = $this->facebook->getAccessToken();
                $result = $this->gr_auth->login_with_facebook($data['user_profile']);
                if ($result) {
                    if ($this->session->userdata('pay_url')) {
                        redirect($this->session->userdata('pay_url'));
                    }
                    redirect(site_url('user_dashboard'));
//                    debug($data['user_profile']);
                }
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
//            debug($user);
            // Solves first time login issue. (Issue: #10)
            //$this->facebook->destroySession();
        }
        $this->gr_template->title('Goretreat Login')->build('login', $this->data);
    }

    public function logout() {

        $this->load->library('facebook');

        // Logs off session from website
        $this->facebook->destroySession();
        $this->session->sess_destroy();
//        $logout = $this->gr_auth->logout();
//        $this->clear_all_cached_data();
        // Make sure you destory website session as well.

        redirect('home');
    }

    public function setLoginFb($set = FALSE) {
        if ($set) {
            $this->session->set_userdata('loginfb', $set);
        }
    }

}
