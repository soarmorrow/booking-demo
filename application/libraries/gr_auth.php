<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gr_auth {

    private $_user_id = null;
    private $CI = NULL;
    private $store_salt = true;
    private $_system = true;
    private $_customer_user_id = null;
    private $salt_length = 5;
    private $_error = '';
    private $_login_hash = '';
    private $_table_name = NULL;

    /**
     * @param $tablename
     * @param bool $system
     */
    public function __construct($tablename) {
        $this->_table_name = $tablename;

        $this->CI = &get_instance();

        $this->CI->load->helper('cookie');
        if ($tablename === 'customer') {
            $this->_system = false;
            $this->_login_hash = $this->CI->session->userdata('login_hash_customer');
        } else {
            $this->_login_hash = $this->CI->session->userdata('login_hash_user');
        }

        if (md5($this->_table_name) == $this->_login_hash) {

            $session_user_id = $session_customer_user_id = NULL;

            if ($this->_system) {
                $session_user_id = $this->CI->session->userdata('user_id');
            } else {
                $session_customer_user_id = $this->CI->session->userdata('customer_user_id');
            }

            $user = $this->CI->db->get_where($this->_table_name, array('id' => ($session_user_id) ? $session_user_id : $session_customer_user_id, 'active' => 1));

            if ($user->num_rows() === 1) {
                $this->_user_id = ($this->_system) ? $session_user_id : null;
                $this->_customer_user_id = ($this->_system) ? null : $session_customer_user_id;
            }

            if (!$this->logged_in() && get_cookie('identity') && get_cookie('remember_code'))
                $this->login_remembered_user();
        }
    }

    /**
     * Set login mode to system mode or parent's portal
     * @param null $mode
     */
    public function set_login_mode($mode = null) {
        if (strcmp($mode, 'system') != 0) {
            $this->_system = false;
        }
    }

    /**
     * Identify the login mode
     * @return bool
     */
    public function get_login_mode() {
        return $this->_system;
    }

    public function login($identity, $pass_word, $remember = FALSE) {
        $password = $pass_word;
        if (empty($identity) || empty($password)) {
            $this->_error = 'Invalid Username/password.';
            return FALSE;
        }

        $query = $this->CI->db->select('*')
                ->from($this->_table_name)
                ->where('username', $identity)
                ->or_where('email', $identity)
                ->limit(1)
                ->get();

        if ($this->is_time_locked_out($identity)) {
            $this->_error = 'Login timeout';

            return FALSE;
        }

        if ($query->num_rows() === 1) {
            $user = $query->row();

            if (password_verify($password, $user->password)) {
                if ($user->active == 0) {
                    $this->_error = 'Your account has not been activated.  Please retrieve the confirmation email that is sent to your registered email address.  Activate your account by following the instruction given in the confirmation email.';
                    return FALSE;
                }
                $querycenter = $this->CI->db->select('center_id')
                        ->from('user_role')
                        ->where('user_id', $user->id)
                        ->limit(1)
                        ->get();
                if ($querycenter->num_rows() === 1) {
                    $usercenter = $querycenter->row();
                    $center_id = $usercenter->center_id;
                } else {
                    $center_id = null;
                }
                $this->set_session($user->id);
                $this->CI->session->set_userdata(array('origin_centre_id' => $center_id));

                if ($this->_system) {
                    $this->_user_id = $user->id;
                } else {
                    $this->_customer_user_id = $user->id;
                }

                $this->clear_login_attempts($identity);

                if ($remember) {
                    $this->remember_user($user->id, $identity, $user->password);
                }
                return TRUE;
            } else {
                $this->_error = "Invalid Username/Password";
                return FALSE;
            }
        }

        $this->increase_login_attempts($identity);

        $this->_error = 'Invalid Username/password.';
        return FALSE;
    }

    public function forgot_password($identity) {

        if (empty($identity)) {
            $this->_error = 'Invalid Username/Email.';
            return FALSE;
        }
        $query = $this->CI->db->select('*')
                ->from($this->_table_name)
                ->where('username', $identity)
                ->or_where('email', $identity)
                ->limit(1)
                ->get();

        if ($query->num_rows() === 1) {
            $user = $query->row();

            if ($user->active == 0) {
                $this->_error = 'Account is inactive. Please contact Administrator for more details.';
                return FALSE;
            }

            $forgotten_password_code = md5(random_string('unique', 9));
            $user->forgotten_password_code = $forgotten_password_code;

            return $this->CI->db->update($this->_table_name, array('forgotten_password_code' => $forgotten_password_code, 'forgotten_password_time' => time()), array('id' => $user->id)) ? $user : FALSE;
        }

        $this->_error = 'Invalid Username/Email.';
        return FALSE;
    }

    public function password_forgotten_user($user_id) {

        if (empty($user_id)) {
            $this->_error = 'Invalid Request.';
            return FALSE;
        }

        $query = $this->CI->db->select('*')
                ->from($this->_table_name)
                ->where('id', $user_id)
                ->limit(1)
                ->get();

        if ($query->num_rows() === 1) {
            $user = $query->row();
            if ($user->active == 0) {
                $this->_error = 'Account is inactive. Please contact Administrator for more details.';
                return FALSE;
            } else if ($user->forgotten_password_time + 900 < time()) {
                $this->_error = 'Reset time Exceded.';
                return FALSE;
            } else
                return $user;
        }

        $this->_error = 'Invalid Request.';
        return FALSE;
    }

    public function reset_password($user_id, $password) {
        $update = array(
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'forgotten_password_code' => '',
            'forgotten_password_time' => 0
        );
        return $this->CI->db->update($this->_table_name, $update, array('id' => $user_id));
    }

    public function set_session($user_id) {
        if ($this->_system) {
            $this->CI->session->set_userdata(array('user_id' => $user_id));
            $this->CI->session->set_userdata(array('login_hash_user' => md5($this->_table_name)));
        } else {
            $this->CI->session->set_userdata(array('customer_user_id' => $user_id));
            $this->CI->session->set_userdata(array('login_hash_customer' => md5($this->_table_name)));
        }
    }

    public function logout() {

        if ($this->_system) {
            $this->CI->session->unset_userdata('user_id');
            $this->_user_id = null;
        } else {
            $this->CI->session->unset_userdata('customer_user_id');
            $this->_customer_user_id = null;
        }
        if (get_cookie('remember_code')) {
            delete_cookie('identity');
            delete_cookie('remember_code');
        }

        //$this->CI->session->sess_destroy();
    }

    public function logged_in() {
//        var_dump($this->_system);
        return ($this->_system) ? !is_null($this->_user_id) : !is_null($this->_customer_user_id);
    }
    
    public function is_admin_logged() {
        return ($this->_system) ? !is_null($this->_user_id) : FALSE;
    }

    public function customer_logged_in() {
//        var_dump($this->_system);
        return ($this->_system) ? !is_null($this->_user_id) : !is_null($this->_customer_user_id);
    }

    public function user_id() {
        return $this->_user_id;
    }

    /**
     * Get parent_id
     * @return null
     */
    public function customer_user_id() {

        return $this->_customer_user_id;
    }

    public function hash_password($password, $salt = false) {

        if (empty($password))
            return FALSE;

        if ($this->store_salt && $salt) {
            return sha1($password . $salt);
        } else {
            $salt = substr(md5(uniqid(rand(), true)), 0, $this->salt_length);
            return $salt . substr(sha1($salt . $password), 0, -$this->salt_length);
        }
    }

    public function remember_user($id, $identity, $password) {

        if (!$id)
            return FALSE;

        $salt = sha1($password);

        $this->CI->db->update($this->_table_name, array('remember_code' => $salt), array('id' => $id));

        if ($this->CI->db->affected_rows() > -1) {
            $expire = (60 * 60 * 24 * 30);

            set_cookie(array(
                'name' => 'identity',
                'value' => $identity,
                'expire' => $expire
            ));

            set_cookie(array(
                'name' => 'remember_code',
                'value' => $salt,
                'expire' => $expire
            ));
            return TRUE;
        }
        return FALSE;
    }

    public function login_remembered_user() {

        if (!get_cookie('identity') || !get_cookie('remember_code'))
            return FALSE;

        $query = $this->CI->db->select('id, password')
                ->where('username', get_cookie('identity'))
                ->or_where('email', get_cookie('identity'))
                ->where('remember_code', get_cookie('remember_code'))
                ->limit(1)
                ->get($this->_table_name);

        if ($query->num_rows() == 1) {
            $user = $query->row();

            $this->set_session($user->id);

            $this->remember_user($user->id, get_cookie('identity'), $user->password);

            return TRUE;
        }

        return FALSE;
    }

    public function is_time_locked_out($identity) {

        return $this->is_max_login_attempts_exceeded($identity) && $this->get_last_attempt_time($identity) > (time() - 60);
    }

    public function is_max_login_attempts_exceeded($identity) {
        $max_attempts = 6;
        if ($max_attempts > 0) {
            $attempts = $this->get_attempts_num($identity);
            return $attempts >= $max_attempts;
        }
    }

    function get_attempts_num($identity) {
        $ip_address = $this->CI->input->ip_address();

        $this->CI->db->select('1', FALSE)->where('ip_address', $ip_address);
        if (strlen($identity) > 0)
            $this->CI->db->or_where('login', $identity);

        $qres = $this->CI->db->get(IMS_DB_PREFIX . 'login_attempts');
        return $qres->num_rows();
    }

    public function get_last_attempt_time($identity) {
        $ip_address = $this->CI->input->ip_address();

        $this->CI->db->select_max('time')->where('ip_address', $ip_address);
        if (strlen($identity) > 0)
            $this->CI->db->or_where('login', $identity);
        $qres = $this->CI->db->get(IMS_DB_PREFIX . 'login_attempts', 1);

        if ($qres->num_rows() > 0) {
            return $qres->row()->time;
        }
    }

    public function increase_login_attempts($identity) {
        $ip_address = $this->CI->input->ip_address();
        return $this->CI->db->insert(IMS_DB_PREFIX . 'login_attempts', array('ip_address' => $ip_address, 'login' => $identity, 'time' => time()));
    }

    public function clear_login_attempts($identity, $expire_period = 900) {

        $ip_address = $this->CI->input->ip_address();

        $this->CI->db->where(array('ip_address' => $ip_address, 'login' => $identity))->or_where('time <', time() - $expire_period, FALSE);

        return $this->CI->db->delete(IMS_DB_PREFIX . 'login_attempts');
    }

    public function error() {
        return $this->_error;
    }

    public function activate($user_id, $activation_code) {

        $query = $this->CI->db->select('active')
                        ->where('id', $user_id)
                        ->where('activation_code', $activation_code)
                        ->limit(1)->get($this->_table_name);


        if ($query->num_rows() == 1) {
            $this->set_session($user_id);
            $this->_user_id = $user_id;

            return $this->CI->db->where('id', $user_id)->update($this->_table_name, array('active' => 1, 'activated_at' => date(DATE_FORMAT)));
        }
        return false;
    }

    function check_center_status() {

        $userId = $this->_user_id;

        $roleDetails = $this->CI->db->get_where(IMS_DB_PREFIX . 'user_role', array('user_id' => $userId))->row();

        if ($roleDetails->role_id == 1) {
            return 1;
        } else {
            $centerStatus = $this->CI->db->select('b.status')
                            ->from(IMS_DB_PREFIX . 'user as a')
                            ->join(IMS_DB_PREFIX . 'user_role as r', 'r.user_id = a.id')
                            ->join(IMS_DB_PREFIX . 'center as b', 'b.id = r.center_id')
                            ->where('a.id', $userId)->get()->row();
            return $centerStatus ? $centerStatus->status : false;
        }
    }

    public function direct_login($identity, $pass_word, $remember = FALSE) {
        $password = $pass_word;
        if (empty($identity) || empty($password)) {
            $this->_error = 'Invalid Username/password.';
            return FALSE;
        }

        $query = $this->CI->db->select('*')
                ->from($this->_table_name)
                ->where('username', $identity)
                ->or_where('email', $identity)
                ->limit(1)
                ->get();

        if ($this->is_time_locked_out($identity)) {
            $this->_error = 'Login timeout';

            return FALSE;
        }

        if ($query->num_rows() === 1) {
            $user = $query->row();

            if ($password == $user->password) {
                if ($user->active == 0) {
                    $this->_error = 'Please retrieve the email that was sent to your registered email address and click on the link to activate this login account. Thank you.';
                    return FALSE;
                }

                $this->set_session($user->id);

                $this->_user_id = $user->id;

                $this->clear_login_attempts($identity);

                if ($remember) {
                    $this->remember_user($user->id, $identity, $user->password);
                }
                return TRUE;
            }
        }

        $this->increase_login_attempts($identity);

        $this->_error = 'Invalid Username/password.';
        return FALSE;
    }

    public function getuserFromId($user_id, $code) {
        if ($code != NULL) {
            return $this->CI->db->get_where('user', array('id' => $user_id, 'activation_code' => $code))->row();
        } else {
            return array();
        }
    }

    public function login_with_facebook($array) {
        if (empty($array)) {
            $this->_error = 'Login Failed.';
            return FALSE;
        }
        $this->system = false;
        $this->CI->session->set_userdata(array('origin_centre_id' => null));
        $checkuser = $this->CI->db->select('*')
                ->from('customer')
                ->or_where('email', $array['email'])
                ->limit(1)
                ->get();
        if ($checkuser->num_rows() === 1) {
            $user = $checkuser->row();
            if ($user->active == 0) {
                $this->_error = 'Your account has not been activated.  Please retrieve the confirmation email that is sent to your registered email address.  Activate your account by following the instruction given in the confirmation email.';
                return FALSE;
            }
            $this->set_session($user->id);
            $this->_customer_user_id = $user->id;
            $this->_user_id = $user->id;
            return TRUE;
        } else {
            $arrayinsert = array(
                'first_name' => $array['first_name'],
                'last_name' => $array['last_name'],
                'email' => $array['email'],
                'username' => $array['email'],
                'password' => $array['accesstoken'],
                'active' => 1,
                'activated_at' => date(DATE_FORMAT),
                'avatar' => 'http://graph.facebook.com/' . $array['id'] . '/picture?type=large',
                'created_at' => date(DATE_FORMAT)
            );
            $this->CI->db->insert('customer', $arrayinsert);
            $user_id = $this->CI->db->insert_id();
            $this->set_session($user_id);
            $this->_customer_user_id = $user_id;
            $this->_user_id = $user->id;
            return TRUE;
        }

        $this->_error = 'Invalid Username/password.';
        return FALSE;
    }

    public function login_with_google($userData) {
        if (empty($userData)) {
            $this->_error = 'Login Failed.';
            return FALSE;
        }
        $this->system = false;
        $this->CI->session->set_userdata(array('origin_centre_id' => null));
        $checkuser = $this->CI->db->select('*')
                ->from('customer')
                ->or_where('email', $userData->email)
                ->limit(1)
                ->get();
        if ($checkuser->num_rows() === 1) {
            $user = $checkuser->row();
            if ($user->active == 0) {
                $this->_error = 'Your account has not been activated.  Please retrieve the confirmation email that is sent to your registered email address.  Activate your account by following the instruction given in the confirmation email.';
                return FALSE;
            }
            $arrayinsert = array(
                'first_name' => $userData->givenName,
                'last_name' => $userData->familyName,
                'email' => $userData->email
            );
            $this->CI->db->where('id', $user->id);
            $this->CI->db->update('customer', $arrayinsert);
            $this->set_session($user->id);
            $this->_customer_user_id = $user->id;
            $this->_user_id = $user->id;
            return TRUE;
        } else {
            $arrayinsert = array(
                'first_name' => $userData->givenName,
                'last_name' => $userData->familyName,
                'email' => $userData->email,
                'username' => $userData->email,
                'password' => md5($userData->email),
                'active' => 1,
                'activated_at' => date(DATE_FORMAT),
                'avatar' => $userData->picture,
                'created_at' => date(DATE_FORMAT),
            );
            $this->CI->db->insert('customer', $arrayinsert);
            $user_id = $this->CI->db->insert_id();
            $this->set_session($user_id);
            $this->_customer_user_id = $user_id;
            $this->_user_id = $user->id;
            return TRUE;
        }
    }

    public function login_with_linkedin($userData) {
        if (empty($userData)) {
            $this->_error = 'Login Failed.';
            return FALSE;
        }
        $this->system = false;
        $this->CI->session->set_userdata(array('origin_centre_id' => null));
        $checkuser = $this->CI->db->select('*')
                ->from('customer')
                ->or_where('email', $userData->emailAddress)
                ->limit(1)
                ->get();
        if ($checkuser->num_rows() === 1) {
            $user = $checkuser->row();
            if ($user->active == 0) {
                $this->_error = 'Your account has not been activated.  Please retrieve the confirmation email that is sent to your registered email address.  Activate your account by following the instruction given in the confirmation email.';
                return FALSE;
            }
            $arrayinsert = array(
                'first_name' => $userData->firstName,
                'last_name' => $userData->lastName,
                'email' => $userData->emailAddress
            );
            $this->CI->db->where('id', $user->id);
            $this->CI->db->update('customer', $arrayinsert);
            $this->set_session($user->id);
            $this->_customer_user_id = $user->id;
            $this->_user_id = $user->id;
            return TRUE;
        } else {
            $arrayinsert = array(
                'first_name' => $userData->firstName,
                'last_name' => $userData->lastName,
                'email' => $userData->emailAddress,
                'username' => $userData->firstName,
                'password' => md5($userData->emailAddress),
                'active' => 1,
                'activated_at' => date(DATE_FORMAT),
                'avatar' => "",
                'created_at' => date(DATE_FORMAT),
            );
            $this->CI->db->insert('customer', $arrayinsert);
            $user_id = $this->CI->db->insert_id();
            $this->set_session($user_id);
            $this->_customer_user_id = $user_id;
            $this->_user_id = $user_id;
            return TRUE;
        }
    }

    public function login_with_twitter($userData) {
        if (empty($userData)) {
            $this->_error = 'Login Failed.';
            return FALSE;
        }
        $this->system = false;
        $this->CI->session->set_userdata(array('origin_centre_id' => null));
        $checkuser = $this->CI->db->select('*')
                ->from('customer')
                ->or_where('email', $userData->email)
                ->limit(1)
                ->get();
        if ($checkuser->num_rows() === 1) {
            $user = $checkuser->row();
            if ($user->active == 0) {
                $this->_error = 'Your account has not been activated.  Please retrieve the confirmation email that is sent to your registered email address.  Activate your account by following the instruction given in the confirmation email.';
                return FALSE;
            }
//            $arrayinsert = array(
//                'first_name' => $userData->givenName,
//                'last_name' => $userData->familyName,
//                'email' => $userData->email
//            );
//            $this->CI->db->where('id', $user->id);
//            $this->CI->db->update('customer', $arrayinsert);
            $this->set_session($user->id);
            $this->_customer_user_id = $user->id;
            $this->_user_id = $user->id;
            return TRUE;
        } else {
            $namelist = explode(" ", $userData->name);
            $arrayinsert = array(
                'first_name' => $namelist[0],
                'last_name' => ($namelist[1]) ? $namelist[1] : '',
                'email' => $userData->email,
                'username' => $userData->email,
                'password' => md5($userData->email),
                'active' => 1,
                'activated_at' => date(DATE_FORMAT),
                'avatar' => $userData->profile_image_url,
                'created_at' => date(DATE_FORMAT),
            );
            $this->CI->db->insert('customer', $arrayinsert);
            $user_id = $this->CI->db->insert_id();
            $this->set_session($user_id);
            $this->_customer_user_id = $user_id;
            $this->_user_id = $user->id;
            return TRUE;
        }
    }

}
