<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author Lachu
 */
class home extends Public_Controller {

    public $data;

    //put your code here
    public function __construct() {
        parent::__construct();
        $this->load->model('home_model');
        $this->load->library('pagination');
        $this->load->library('facebook');
    }

    public function index() {

        $this->data['message'] = '';
        $this->data['error'] = '';
        if ($this->gr_auth->logged_in()) {
            if ($this->session->userdata('pay_url')) {
                $payurl = $this->session->userdata('pay_url');
                $this->session->unset_userdata('pay_url');
                redirect($payurl);
            }
//            redirect(site_url('user_dashboard'));
        }
        $this->load->library('facebook');
        // Automatically picks appId and secret from config

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
                        $payurl = $this->session->userdata('pay_url');
                        $this->session->unset_userdata('pay_url');
                        redirect($payurl);
                    }
                    if ($this->session->userdata('loginsuccess') != 'success') {
                        $this->session->set_userdata(array('loginsuccess' => 'success'));
                        redirect(site_url('home'));
                    }
                }
            } catch (FacebookApiException $e) {
                $user = null;
            }
        } else {
            // Solves first time login issue. (Issue: #10)
            // $this->facebook->destroySession();
        }
        $this->data['events'] = $this->home_model->getUpcomingEvents();
        $this->data['centers'] = $this->home_model->getPopularCenters();
        $this->data['preachers'] = $this->home_model->getPreachers();
        $this->data['articles'] = $this->home_model->getLatestArticles();
        $this->data['images'] = $this->home_model->getAllImages();
        $this->data['count'] = $this->home_model->getAllImagesCount();
        $this->gr_template->build('indexpage', $this->data);
    }

    public function sign_up() {
        if (!$this->gr_auth->customer_logged_in()) {

        } else {
            $current = $this->session->userdata('pay_url');
            if ($current) {
                redirect($current);
            } else {
                redirect(site_url());
            }
        }
        $id = null;

        $this->form_validation->set_rules(array(
            array('field' => 'first_name',
                'label' => 'First Name',
                'rules' => 'trim|required|alpha_dash'),
            array('field' => 'last_name',
                'label' => 'Last Name',
                'rules' => 'trim|required|alpha_dash'),
            array('field' => 'email',
                'label' => 'Email',
                'rules' => "trim|required|valid_email|callback_useremail_check[$id]"),
            array('field' => 'password',
                'label' => 'password',
                'rules' => 'trim|required|callback_password_requirements'),
            array('field' => 'confirm_password',
                'label' => 'Confirm Password',
                'rules' => 'trim|required|matches[password]'),
            array('field' => 'address',
                'label' => 'Address',
                'rules' => 'trim|required'),
            array('field' => 'district',
                'label' => 'Suburb/District',
                'rules' => 'trim|required'),
            array('field' => 'pincode',
                'label' => 'Pincode',
                'rules' => 'trim|required'),
            array('field' => 'country',
                'label' => 'Country',
                'rules' => 'trim|required'),
            array('field' => 'state',
                'label' => 'State',
                'rules' => 'trim|required'),
            array('field' => 'sms_updates',
                'label' => 'SMS Updates',
                'rules' => 'trim'),
            array('field' => 'newsletter',
                'label' => 'Newsletter',
                'rules' => 'trim'),
            array('field' => 'agreement',
                'label' => 'Agreement',
                'rules' => 'trim')
            ));

if ($this->input->post('sms_updates')) {
    $this->form_validation->set_rules('phone', 'Mobile Phone', 'trim|required');
} else {
    $this->form_validation->set_rules('phone', 'Mobile Phone', 'trim');
}



if ($this->input->post()) {
            //$password=md5($this->input->post('password'));
    $password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
    if ($this->form_validation->run($this) != FALSE) {
        $activation_code = md5(random_string('unique', 9));
        $phonenumber = $this->input->post('phonecode') . " " . $this->input->post('phone');
        $values = array(
            'first_name' => $this->input->post('first_name'),
            'last_name' => $this->input->post('last_name'),
            'email' => $this->input->post('email'),
            'contact_number' => $phonenumber,
            'address' => $this->input->post('address'),
            'district' => $this->input->post('district'),
            'pincode' => $this->input->post('pincode'),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'active' => 0,
            'password' => $password,
            'username' => $this->input->post('email'),
            'activation_code' => $activation_code
            );
        if ($this->input->post('agreement')) {
            $c_id = $this->home_model->insertRow($values, 'customer', true);
            if ($this->input->post('newsletter')) {
                $subscribe = array(
                    'email' => $this->input->post('email'),
                    'status' => 1,
                    'verification_code' => md5(random_string('unique', 9)),
                    'verification_time' => date('y:m:d H:i:s'));
                $this->home_model->insertRow($subscribe, 'subscribers', true);
            }
            $subject = 'Goretreat Registration Confirmation';
            $message = '<p>Hi ' . ucfirst($values['first_name']) . ',</p>'
            . '<p>You have registered successfully in Goretreat ' . ' on ' . date('l, F j, Y') . ' at ' . date('g:ia') . '.</p>'
            . '<p><a href="' . site_url('home/activate_account/' . $c_id . '/' . $activation_code) . '">Click here to activate your account.</a></p>'
            . '<p>Thanks,</p>'
            . '<p>The Goretreat Team</p>';
                    // debug($message);
            $this->send_mail($values['email'], $values['first_name'] . ' ' . $values['last_name'], $subject, $message);
            redirect(site_url('home/email_send'));
        } else {
            $this->data['error'] = 'Please accept terms and conditions';
                    //redirect(site_url('home/sign_up'));
        }
    } else {

        $this->form_validation->set_message('agreement', 'Please accept Terms and conditions');
    }
}
$this->gr_template->build('sign_up', $this->data);
}

public function password_requirements(){
    $password = $this->input->post('password');
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number    = preg_match('@[0-9]@', $password);

    if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
        $this->form_validation->set_message('password_requirements', 'Password must contain 8 characters including atleast a number, an uppercase and a lowercase letters');
        return false;
    }
    else{
        return true;
    }
}

public function sign_in() {

    if (!$this->gr_auth->customer_logged_in()) {

    } else {
        $current = $this->session->userdata('pay_url');
        if ($current) {
            redirect($current);
        } else {
            redirect(site_url());
        }
    }
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
                    $payurl = $this->session->userdata('pay_url');
                    $this->session->unset_userdata('pay_url');
                    redirect($payurl);
                }
                if ($this->session->userdata('loginsuccess') != 'success') {
                    $this->session->set_userdata(array('loginsuccess' => 'success'));
                    redirect(site_url('home'));
                }
            }
        } catch (FacebookApiException $e) {
            $user = null;
        }
    }
    $this->form_validation->set_rules(array(
        array('field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'trim|required'),
        array('field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required')));


    if ($this->input->post()) {
        if ($this->form_validation->run()) {
            $password = $this->input->post('password');
                // if ($this->input->post('agreement')) {
            if ($this->gr_auth->login($this->input->post('user_name'), $password)) {
                redirect(site_url('home'));
            } else {
                $this->data['error'] = $this->gr_auth->error();
            }
            if ($this->gr_auth->login($this->input->post('user_name'), $password)) {
                redirect(site_url('home'));
            } else {
                $this->data['error'] = $this->gr_auth->error();
            }
                // } else {
                //     $this->data['error'] = 'Please accept terms and conditions';
                // redirect(site_url('home/sign_in'));
                // }
        }
    }
    $this->gr_template->build('sign_in', $this->data);
}

function email_send() {
    $this->gr_template->build('email_sent', $this->data);
}

public function forgot_password($user_id = 0, $code = 0) {
    if ($this->gr_auth->logged_in())
        redirect(site_url('home'));

    if ($user_id == 0) {

        $this->data['message'] = '';

        if ($this->input->post()) {
            $this->form_validation->set_rules('identity', 'Username/Email', 'required');

            if ($this->form_validation->run() == true) {

                if ($customer = $this->gr_auth->forgot_password($this->input->post('identity'))) {

                    $subject = 'You have requested for a new Goretreat password';

                    $message = '<p>Hi ' . $customer->first_name . ',</p>'
                    . '<p>You recently asked to reset your Goretreat password.</p>'
                    . '<p><a href="' . site_url('home/forgot_password/' . $customer->id . '/' . $customer->forgotten_password_code) . '">Click here to change your password.</a></p>'
                    . '<p>Alternatively, you can enter the following password reset code:</p>'
                    . '<p>If you didn\'t request a new password, inform the centre immediately.</p>'
                    . '<p>Thanks,</p>'
                    . '<p>The Goretreat Security Team</p>';
                        // debug($message);
                    $this->send_mail($customer->email, $customer->first_name . ' ' . $customer->last_name, $subject, $message);


                    redirect('home/email_send');
                } else {
                    $this->data['message'] = '<p style="margin: 10px;">' . $this->gr_auth->error() . '</p>';
                }
            } else {
                $this->data['message'] = validation_errors();
            }
        }

        $this->gr_template->build('forgot_password', $this->data);
    } else {

        $this->data['message'] = '';

        $this->data['user'] = $this->gr_auth->password_forgotten_user($user_id);

        if (!$this->data['user']) {
            $this->data['message'] = '<p style="margin: 10px;">' . $this->gr_auth->error() . '</p>';
        } else {
            if ($this->input->post() or $code !== 0) {
                $this->data['code'] = $this->input->post('code') ? $this->input->post('code') : $code;



                if ($this->data['user']->forgotten_password_code == $this->data['code']) {
                    $this->gr_auth->set_session($this->data['user']->id);
                    redirect('home/change_pass_page');
                } else {
                    $this->data['message'] = '<p style="margin: 10px;">Invalid Request.</p>';
                }
            }
        }

        $this->gr_template->build('forgot_password_step_two', $this->data);
    }
}

public function change_pass_page() {
    $this->gr_template->build('change_pass_page', $this->data);
}

public function change_pass() {


    $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[8]');
    $this->form_validation->set_rules('confirm_password', 'Confirm password', 'trim|required|matches[password]');
    $this->data['user'] = $this->home_model->getOneWhere(array('id' => $this->gr_auth->customer_user_id()), 'customer');
    if ($this->form_validation->run() == true) {
        if ($this->gr_auth->reset_password($this->gr_auth->customer_user_id(), $this->input->post('password'))) {

            $subject = 'Goretreat password reset';

            $message = '<p>Hi ' . $this->data['user']->first_name . ',</p>'
            . '<p>Your Goretreat password was reset using the email address ' . $this->data['user']->email . ' on ' . date('l, F j, Y') . ' at ' . date('g:ia') . '.</p>'
            . '<p>If you did this, you can safely disregard this email.</p>'
            . '<p>If you didn\'t do this, let us know immediately.</p>'
            . '<p>Thanks,</p>'
            . '<p>The Goretreat Security Team</p>';

            $this->send_mail($this->data['user']->email, $this->data['user']->first_name . ' ' . $this->data['user']->last_name, $subject, $message);
                // 
            if ($this->session->userdata('profile_edit') != 1) {
                $this->session->unset_userdata('profile_edit');
                $this->gr_auth->logout($this->data['user']->id);
                redirect(site_url('home'));
            } else {
                $this->session->unset_userdata('profile_edit');
                redirect('home/profile/' . $this->data['user']->id);
            }
        }
    } else {

        $this->gr_template->build('change_pass_page', $this->data);
    }
}

public function getMoreEvents($currentpage = 0) {
    $data['events'] = $this->home_model->getUpcomingEvents($currentpage);
    $list = $this->load->view('getmoreevents', $data, true);
    if (!$list) {
        $status = false;
    } else {
        $status = true;
    }
    $status = $this->home_model->getmoreEvents($currentpage + 1);
    $datalist = array('status' => $status, 'data' => $list);
    echo json_encode($datalist);
}

function getMorePreachers($currentpage = 0) {
    $data['preachers'] = $this->home_model->getPreachers($currentpage);
    $list = $this->load->view('getmorepreachers', $data, true);
    if (!$list) {
        $status = false;
    } else {
        $status = true;
    }
    $status = $this->home_model->getmorePreachers($currentpage + 1);
    $datalist = array('status' => $status, 'data' => $list);
    echo json_encode($datalist);
}

public function getMoreCenters($currentpage = 0) {
    $data['centers'] = $this->home_model->getPopularCenters($currentpage);
    $list = $this->load->view('getmorecenters', $data, true);
    if (!$list) {
        $status = false;
    } else {
        $status = true;
    }
    $status = $this->home_model->getmoreCenters($currentpage + 1);
    $datalist = array('status' => $status, 'data' => $list);
    echo json_encode($datalist);
}

public function getMoreArticles($currentpage = 0) {
    $data['articles'] = $this->home_model->getLatestArticles($currentpage);
    $list = $this->load->view('getmorearticles', $data, true);
    if (!$list) {
        $status = false;
    } else {
        $status = true;
    }
    $status = $this->home_model->getmoreArticles($currentpage + 1);
    $datalist = array('status' => $status, 'data' => $list);
    echo json_encode($datalist);
}

//    public function googleLogin() {
//        $this->load->library('googleplus');
//        if (isset($_GET['code'])) {
//
//            $this->googleplus->client->authenticate();
//
//            $this->session->userdata('token') = $this->googleplus->client->getAccessToken();
//
//            $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//
//            header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
//        }
//        if ($_SESSION['token']) {
//
//            $this->googleplus->client->setAccessToken($this->session->userdata('token'));
//        }
//        if ($this->googleplus->client->getAccessToken()) {
//
//            $this->googleplus->people->get('115414977082318263605');
//
//            $activities = $this->googleplus->activities->listActivities('115414977082318263605', 'private');
//
//            print 'Your Activities: <pre>' . print_r($activities, true) . '</pre>';
//
//            // We're not done yet. Remember to update the cached access token.
//            // Remember to replace $_SESSION with a real database or memcached.
//
//            $_SESSION['token'] = $this->googleplus->client->getAccessToken();
//        } else {
//
//            $authUrl = $this->googleplus->client->createAuthUrl();
//
//            print "<a href='$authUrl'>Connect Me!</a>";
//        }
//    }

public function profile($id) {
    $this->data['details'] = $this->home_model->profile_details($id);
    $this->gr_template->build('profile', $this->data);
}

function change_pass_profile() {
    $this->session->set_userdata('profile_edit', true);
    redirect('home/change_pass_page');
}

public function useremail_check($email, $id) {
    $data = $this->home_model->checkMailexist($id, $email);
    if ($data->num_rows() > 0) {
        $this->form_validation->set_message('useremail_check', 'A user with this email is already registered with GoRetreat');
        return FALSE;
    } else {
        return TRUE;
    }
}

public function username_check($user, $id) {
    $data = $this->home_model->checkusernameexist($id, $user);
    if ($data->num_rows() > 0) {
        $this->form_validation->set_message('username_check', 'Username already used');
        return FALSE;
    } else {
        return TRUE;
    }
}

//formvalidation function for validate first namehaving character and space
public function alpha_dash_space($str) {
    if (preg_match("/^([-a-z_ ])+$/i", $str)) {
        return TRUE;
    } else {
        $this->form_validation->set_message('alpha_dash_space', 'First Name contains only alpha caracters');
        return FALSE;
    }
}

public function profile_update($id) {
    if ($this->input->post()) {
        $this->form_validation->set_rules('first_name', 'FirstName', 'required|callback_alpha_dash_space');
        $this->form_validation->set_rules('last_name', 'LastName', 'required');
        $this->form_validation->set_rules('phone', 'Mob. No:', 'required|numeric|min_length[10]');
        $this->form_validation->set_rules('username', 'UserName', "callback_username_check[$id]|required");
        $this->form_validation->set_rules('email', 'Email', "trim|required|valid_email|callback_useremail_check[$id]");
        if ($this->form_validation->run($this) != FALSE) {
                // $path=$this->input->post('oldAvatar');
            $data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'email' => $this->input->post('email'),
                'contact_number' => $this->input->post('phone'),
                'username' => $this->input->post('username')
                );
            if (empty($_FILES['newAvatar']['name'])) {

            } else if ($_FILES['newAvatar']['error'] == 0) {
                $filetype = NULL;
                    //upload and update the file
                $config['upload_path'] = './uploads/files/profile/';
                $config['max_size'] = '102428800';
                $type = $_FILES['newAvatar']['type'];
                switch ($type) {
                    case 'image/gif':
                    case 'image/jpg':
                    case 'image/png':
                    case 'image/jpeg': {
                        $filetype = 0;
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        break;
                    }
                }
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                    //$config['max_size']   = '100';// in KB
                if (!file_exists('./uploads/files/profile')) {
                    if (!mkdir('./uploads/files/profile/', 0755, TRUE)) {
                            //echo 'false';
                    }
                }
                $microtime = microtime(TRUE) * 10000;
                $this->load->library('upload', $config);

                if (!$this->upload->do_my_upload('newAvatar', $microtime)) {

                } else {
                    $data['avatar'] = 'uploads/files/profile/' . $this->upload->file_name;
                }
            }

            $this->data['update_details'] = $this->home_model->update_profile_details($id, $data);
        }
        $array = $this->form_validation->error_array();
        if (!$array) {
            $status = 'true';
        } else {
            $status = 'false';
        }
        $result = array('error' => $array, 'status' => $status);
        if ($this->input->is_ajax_request()) {
            echo json_encode($result);
            exit;
        }

        $this->data['details'] = $this->home_model->profile_details($id);
        $this->gr_template->build('profile', $this->data);
    } else {
        redirect('home/profile/' . $id);
    }
}

public function activate_account($id = 0, $code = NULL) {
    $check = $this->home_model->check_activation($id, $code);
    if ($check) {
        $this->gr_template->build('account_activated', $this->data);
    } else {
        $this->gr_template->build('activation_failed', $this->data);
    }
}

public function centre_list() {
    $this->data['category'] = $this->home_model->list_category();
    $this->data['type'] = $this->home_model->list_type();
    $this->form_validation->set_rules(array(
        array('field' => 'centre_name',
            'label' => 'Centre Name',
            'rules' => 'trim|required'),
        array('field' => 'place',
            'label' => 'Place',
            'rules' => 'trim|required'),
        array('field' => 'address1',
            'label' => 'Address1',
            'rules' => 'trim|required'),
        array('field' => 'address2',
            'label' => 'Address2',
            'rules' => 'trim|required'),
        array('field' => 'country',
            'label' => 'Country',
            'rules' => 'trim|required'),
        array('field' => 'state',
            'label' => 'State',
            'rules' => 'trim'),
        array('field' => 'contact',
            'label' => 'Key contact Person',
            'rules' => 'trim|required'),
        array('field' => 'phone',
            'label' => 'Phone Number',
            'rules' => 'trim|required|max_length[20]'),
        array('field' => 'description',
            'label' => 'Description',
            'rules' => 'trim|required'),
        array('field' => 'category',
            'label' => 'Category',
            'rules' => 'trim|required'),
        array('field' => 'type',
            'label' => 'Retreat type',
            'rules' => 'trim|required'),
        array('field' => 'zipcode',
            'label' => 'Zipcode',
            'rules' => 'trim|required'),
        array('field' => 'centre_name',
            'label' => 'Centre Name',
            'rules' => 'trim|required'),
        array('field' => 'website',
            'label' => 'Website',
            'rules' => 'trim'),
        array('field' => 'established',
            'label' => 'Established',
            'rules' => 'trim'),
        array('field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email')
        ));
if ($this->input->post()) {
    if ($this->form_validation->run()) {
        if (empty($_FILES['logo']['name'])) {
            $logo = '';
        } else if ($_FILES['logo']['error'] == 0) {
                    //upload and update the file
            $config['upload_path'] = './uploads/image/center_logo/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
                    //$config['max_size']   = '100';// in KB
            if (!file_exists('./uploads/image/center_logo')) {
                if (!mkdir('./uploads/image/center_logo/', 0755, TRUE)) {
                            //echo 'false';
                }
            }
            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('logo')) {
                $logo = 'uploads/images/eventslider/14520608113861.png';
            } else {
                        //Image Resizing
                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 200;
                $config['height'] = 200;

                $this->load->library('image_lib', $config);

                if (!$this->image_lib->resize()) {
                    $logo = 'uploads/images/eventslider/14520608113861.png';
                } else {
                    $logo = 'uploads/image/center_logo/' . $this->upload->file_name;
                }
            }
        }
                // debug($logo);
        $values = array(
            'name' => $this->input->post('centre_name'),
            'city' => $this->input->post('place'),
            'street_address1' => $this->input->post('address1'),
            'street_address2' => $this->input->post('address2'),
            'country' => $this->input->post('country'),
            'state' => $this->input->post('state'),
            'contact' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'zipcode' => $this->input->post('zipcode'),
            'logo' => $logo,
            'established' => $this->input->post('established'),
            'key_person' => $this->input->post('contact'),
            'website' => $this->input->post('website'),
            'rc_type_id' => $this->input->post('type'),
            'description' => $this->input->post('description'),
            'status' => 1,
            'verified' => 0,
            'rc_category_id' => $this->input->post('category')
            );
        if ($this->gr_auth->logged_in()) {
            $centre = $this->home_model->insertRow($values, 'center', true);
            $this->session->set_flashdata('message', array("class" => "success", "message" => "New centre added and will be published after verification"));
            redirect('home/centre_list');
        } else {
            $this->session->set_userdata('insert_list', $values);
            $this->session->set_userdata('pay_url', site_url('home/centre_list'));
            redirect('home/sign_in');
        }
    }
} else {

    $values = $this->session->userdata('insert_list');
    if ($values) {
        $centre = $this->home_model->insertRow($values, 'center', true);
        $this->session->unset_userdata('insert_list');
        $this->session->set_flashdata('message', array("class" => "success", "message" => "New centre added and will be published after verification"));
        redirect('home/centre_list');
    }
}
$this->gr_template->build('centre_list', $this->data);
}

function selectLanguage() {
    $id = intval($this->input->post('country'));
    $this->session->set_userdata(array('country_selected' => $id));
    echo json_encode(array("status" => 'true'));
}

function about_us() {
    $this->gr_template->build('about_us', $this->data);
}

function help() {
    $this->gr_template->build('help', $this->data);
}

function privacy() {
    $this->gr_template->build('privacy', $this->data);
}

function terms() {
    $this->gr_template->build('terms', $this->data);
}

    /*
     * Get country phone code by country id
     */

    public function get_phone_code() {
        $name = $this->input->get('name');
        if (empty($name)) {
            echo 'Error';
            exit;
        }

        $country = $this->home_model->getOneWhere(array('name' => $name), 'countries');

        if ($country) {
            echo $country->phone_code;
        } else {
            echo '-';
        }
        exit;
    }

}

?>
