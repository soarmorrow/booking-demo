<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user extends Admin_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->form_validation->set_error_delimiters('<label class="control-label h5" for="inputError">', '</label>');
        $this->load->library('pagination');
        if (!_can("User")) {
            redirect(site_url("dashboard"));
        }
    }

    function index() {
        $this->data['name'] = $this->input->post('name');
        $this->data['email'] = $this->input->post('email');
        $this->data['role'] = $this->input->post('role');
        if ($this->session->userdata('origin_centre_id') == 0) {
            $this->data['rc_centers'] = $this->input->post('rc_centers');
        } else {
            $this->data['rc_centers'] = $this->session->userdata('origin_centre_id');
        }
        $total = $this->user_model->getAllUsers(FALSE, 0, 0, $this->current_user->id, $this->data['name'], $this->data['email'], $this->data['rc_centers'], $this->data['role']);
        //pagination settings
        $config['base_url'] = site_url('user/index');
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('user_per_page') ? $this->session->userdata('user_per_page') : 10;
        $config["uri_segment"] = 3;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = floor($choice);
        $config['use_page_numbers'] = TRUE;
        //config for bootstrap pagination class integration
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['first_link'] = false;
        $config['last_link'] = false;
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="prev">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $this->data['page'] = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

        $this->data['per_page'] = $config['per_page'];
        $this->data['perpages'] = array(10, 25, 50, 100);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['allroles'] = $this->user_model->loadUserRole();
        $this->data['allcenters'] = $this->user_model->loadCenters($this->current_user->id);
        $this->data['user_id'] = $this->current_user->id;
        if ($this->input->post()) {
            $users = $this->user_model->getAllUsers(TRUE, $config["per_page"], $this->data['page'], $this->current_user->id, $this->data['name'], $this->data['email'], $this->data['rc_centers'], $this->data['role']);
        } else {
            $users = $this->user_model->getAllUsers(TRUE, $config["per_page"], $this->data['page'], $this->current_user->id);
        }
//        debug();
        $this->data['usersarray'] = $users;
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('user'));
        $this->gr_template->title('Goretreat User')->build('user', $this->data);
    }

    function adduser() {
        $roles = $this->user_model->loadUserRole();
        $centers = $this->user_model->loadCenters($this->current_user->id);
        $this->data['roles'] = $roles;
        $this->data['centers'] = $centers;
        $this->data['typealert'] = "";
        $this->data['userpostedarray'] = array(
            'fname' => $this->input->post('fname'),
            'email' => $this->input->post('email'),
            'lname' => $this->input->post('lname'),
            'username' => $this->input->post('username'),
            'phonenumber' => $this->input->post('phonenumber')
        );
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'First Name', 'required|alpha');
            $this->form_validation->set_rules('lname', 'Lat Name', 'required|alpha');
            $this->form_validation->set_rules('email', 'E mail', 'required|valid_email|is_unique[user.email]');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[user.username]|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules('phonenumber', 'Phone Number', 'required');
//            $this->form_validation->set_rules('userrole', 'User Role', 'required');
            if ($this->form_validation->run() == true) {
                if (empty($_FILES['avatar']['name'])) {
                    $avatar = 'https://s.gravatar.com/avatar/' . md5($this->input->post('email')) . '?s=200';
                } else if ($_FILES['avatar']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] = './uploads/image/profile/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('avatar')) {
                        $avatar = '';
                    } else {
                        //Image Resizing
                        $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 300;
                        $config['height'] = 300;

                        $this->load->library('image_lib', $config);

                        if (!$this->image_lib->resize()) {
                            debug($this->image_lib->display_errors('', ''));
                            $avatar = '';
                        } else {
                            $avatar = base_url('uploads/image/profile/' . $this->upload->file_name);
                        }
                    }
//                    $avatar = '';
                }
                $activation_code = md5(random_string('unique', 9));
                $userarray = array(
                    'first_name' => htmlspecialchars($this->input->post('fname')),
                    'last_name' => htmlspecialchars($this->input->post('lname')),
                    'email' => htmlspecialchars($this->input->post('email')),
                    'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                    'username' => htmlspecialchars($this->input->post('username')),
                    'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                    'created_at' => date(DATE_FORMAT),
                    'activation_code' => $activation_code,
                    'avatar' => $avatar
                );
                $user_id = $this->user_model->addNewUsers($userarray);
                $subject = 'You are Registered';
                $message = '<p>Hi ' . $this->input->post('fname') . ',</p>'
                        . '<p>You recently registered in Goretreat.com.</p>'
                        . '<p><a href="' . site_url('system/activate_user/' . $user_id . '/' . $activation_code) . '">Click here to activate your account.</a></p>'
                        . '<p>Alternatively, you can enter the following code:</p>'
                        . '<p>Your Code is : ' . $activation_code . '</p>'
                        . '<p>Thanks,</p>'
                        . '<p>The Goretreat Security Team</p>';
                $this->send_mail($this->input->post('email'), $this->input->post('fname') . ' ' . $this->input->post('lname'), $subject, $message);
                $this->data['typealert'] = "success";
                $this->data['userpostedarray'] = array(
                    'fname' => '',
                    'email' => '',
                    'lname' => '',
                    'username' => '',
                    'phonenumber' => ''
                );
                $this->data['message'] = 'Mail sent to user for activation';
                $this->user_model->addNewRolesToUsers($user_id, $this->input->post('userrole'));
            } else {
                $this->data['message'] = '';
            }
        } else {
            $this->data['message'] = '';
        }
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('user'));
        $this->gr_template->title('Goretreat User')->build('add_user', $this->data);
    }

    public function disable($id, $is) {
        if ($this->user_model->disableuser($id, $is)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function view($user_id) {
        $this->data['user_id'] = $user_id;
        $roles = $this->user_model->loadUserRole();
        $this->data['userdata'] = $this->current_user;
        $this->data['getuserdata'] = $this->user_model->loadRequestedUser($user_id);
        $this->data['roles'] = $roles;
        $this->data['assignedroles'] = $this->user_model->loadUserAssignedRole($user_id);
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('user'));
        $this->gr_template->title('Goretreat User')->build('view_user', $this->data);
    }

    public function edit($user_id) {
        $this->data['message'] = "";
        $this->data['typealert'] = "";
        $this->data['userdata'] = $this->user_model->loadRequestedUser($user_id);
        $roles = $this->user_model->loadUserRole();
        $this->data['roles'] = $roles;
        $this->data['assignedroles'] = $this->user_model->loadUserAssignedRole($user_id);
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'First Name', 'required|alpha');
            $this->form_validation->set_rules('lname', 'Lat Name', 'required|alpha');
            $this->form_validation->set_rules('email', 'E mail', 'required|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]');
            $this->form_validation->set_rules('phonenumber', 'Phone Number', 'required');
            $this->form_validation->set_rules('userrole', 'User Role', 'required');
            if ($this->form_validation->run() == true) {

                if (empty($_FILES['avatar']['name'])) {
                    $avatar = 'https://s.gravatar.com/avatar/' . md5($this->input->post('email')) . '?s=200';
                } else if ($_FILES['avatar']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] = './uploads/image/profile/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('avatar')) {
                        $avatar = '';
                    } else {
                        //Image Resizing
                        $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 300;
                        $config['height'] = 300;

                        $this->load->library('image_lib', $config);

                        if (!$this->image_lib->resize()) {
                            debug($this->image_lib->display_errors('', ''));
                            $avatar = '';
                        } else {
                            $avatar = base_url('uploads/image/profile/' . $this->upload->file_name);
                        }
                    }
                }
                if ($this->input->post('password') != '') {
                    if ($avatar != '') {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                            'updated_at' => date(DATE_FORMAT),
                            'avatar' => $avatar
                        );
                    } else {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                            'updated_at' => date(DATE_FORMAT)
                        );
                    }
                } else {
                    if ($avatar != '') {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'updated_at' => date(DATE_FORMAT),
                            'avatar' => $avatar
                        );
                    } else {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'updated_at' => date(DATE_FORMAT)
                        );
                    }
                }
                $message = $this->user_model->updateNewUsers($userarray, $user_id);
                $this->data['message'] = $message['message'];
                $this->data['typealert'] = $message['typealert'];
                $this->data['userdata'] = $this->user_model->loadRequestedUser($user_id);
                $this->data['assignedroles'] = $this->user_model->updateNewRolesToUsers($user_id, $this->data['assignedroles'], $this->input->post('userrole'));
            } else {
                $this->data['typealert'] = "error";
                $this->data['message'] = "Validation Error";
            }
        }
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('user'));
        $this->gr_template->title('Goretreat User')->build('edit_user', $this->data);
    }

    public function profile() {
        $user_id = $this->session->userdata('user_id');
        $this->data['message'] = "";
        $this->data['typealert'] = "";
        $this->data['userdata'] = $this->user_model->loadRequestedUser($user_id);
        $roles = $this->user_model->loadUserRole();
        $this->data['roles'] = $roles;
        $this->data['assignedroles'] = $this->user_model->loadUserAssignedRole($user_id);
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'First Name', 'required|alpha');
            $this->form_validation->set_rules('lname', 'Lat Name', 'required|alpha');
            $this->form_validation->set_rules('email', 'E mail', 'required|valid_email');
            $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
            $this->form_validation->set_rules('password', 'Password', 'min_length[8]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'matches[password]');
            $this->form_validation->set_rules('phonenumber', 'Phone Number', 'required');
            $this->form_validation->set_rules('userrole', 'User Role', 'required');
            if ($this->form_validation->run() == true) {

                if (empty($_FILES['avatar']['name'])) {
                    $avatar = 'https://s.gravatar.com/avatar/' . md5($this->input->post('email')) . '?s=200';
                } else if ($_FILES['avatar']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] = './uploads/image/profile/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('avatar')) {
                        $avatar = '';
                    } else {
                        //Image Resizing
                        $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                        $config['maintain_ratio'] = FALSE;
                        $config['width'] = 300;
                        $config['height'] = 300;

                        $this->load->library('image_lib', $config);

                        if (!$this->image_lib->resize()) {
                            debug($this->image_lib->display_errors('', ''));
                            $avatar = '';
                        } else {
                            $avatar = base_url('uploads/image/profile/' . $this->upload->file_name);
                        }
                    }
                }
                if ($this->input->post('password') != '') {
                    if ($avatar != '') {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                            'updated_at' => date(DATE_FORMAT),
                            'avatar' => $avatar
                        );
                    } else {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT),
                            'updated_at' => date(DATE_FORMAT)
                        );
                    }
                } else {
                    if ($avatar != '') {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'updated_at' => date(DATE_FORMAT),
                            'avatar' => $avatar
                        );
                    } else {
                        $userarray = array(
                            'first_name' => htmlspecialchars($this->input->post('fname')),
                            'last_name' => htmlspecialchars($this->input->post('lname')),
                            'email' => htmlspecialchars($this->input->post('email')),
                            'contact_number' => htmlspecialchars($this->input->post('phonenumber')),
                            'username' => htmlspecialchars($this->input->post('username')),
                            'updated_at' => date(DATE_FORMAT)
                        );
                    }
                }
                $message = $this->user_model->updateNewUsers($userarray, $user_id);
                $this->data['message'] = $message['message'];
                $this->data['typealert'] = $message['typealert'];
                $this->data['userdata'] = $this->user_model->loadRequestedUser($user_id);
                $this->data['assignedroles'] = $this->user_model->updateNewRolesToUsers($user_id, $this->data['assignedroles'], $this->input->post('userrole'));
            } else {
                $this->data['typealert'] = "error";
                $this->data['message'] = "Validation Error";
            }
        }
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('user'));
        $this->gr_template->title('Goretreat User')->build('edit_user', $this->data);
    }

    public function deleteuser($user_id) {
        $roles = $this->user_model->deleteRequestedUser($user_id);
        if ($roles) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function change_perpage($perpage = "") {
        if (is_numeric($perpage)) {
            $perpage = (int) $perpage;
        } else {
            $perpage = 10;
        }
        $this->session->set_userdata('user_per_page', $perpage);
        exit();
    }

}
