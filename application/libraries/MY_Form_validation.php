<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation {

    public function run($module = '', $group = '') {
        (is_object($module)) AND $this->CI = &$module;
        return parent::run($group);
    }

    public function unique($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($args[1], $value);
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }

        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('unique', '%s already exists.');
            return false;
        }
        return true;
    }

    public function unique_case($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where('LOWER(' . $args[1] . ')', strtolower($value));
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }

        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('unique_case', '%s already exists.');
            return false;
        }
        return true;
    }

    public function unique_archive($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($args[1], $value);
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }
        $CI->db->where('archive', 0);
        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('unique_archive', '%s already exists.');
            return false;
        }
        return true;
    }

    public function unique_is_archive($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($args[1], $value);
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }
        $CI->db->where('is_archive', 0);
        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('unique_is_archive', '%s already exists.');
            return false;
        }
        return true;
    }

    public function id_type_unique_is_archive($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($args[1], $value);
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }
        $CI->db->where('type', 'id_type');
        $CI->db->where('is_archive', 0);
        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('id_type_unique_is_archive', '%s already exists.');
            return false;
        }
        return true;
    }

    public function unique_is_deleted($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($args[1], $value);
        if (isset($args[2]) and isset($args[3])) {
            $CI->db->where($args[2] . " !=", $args[3]);
        }
        $CI->db->where('is_deleted', 0);
        if ($CI->db->get()->row()->cnt > 0) {
            $this->set_message('unique_is_deleted', '%s already exists.');
            return false;
        }
        return true;
    }

    public function is_password_exists($value, $args) {
        $CI = & get_instance();
        $args = explode('.', $args);

        $array = array($args[1] => $value, $args[2] => $args[3]);
        $CI->db->select('count(*) as cnt')->from($args[0])->where($array);
        if ($CI->db->get()->row()->cnt < 1) {
            $this->set_message('is_password_exists', '%s does not match.');
            return false;
        }
        return true;
    }

    public function is_int($value) {
        $values = explode(',', $value);
        foreach ($values as $value) {
            $value = (int) $value;
            if ($value == 0) {
                $this->set_message('is_int', '%s not valid.');
                return false;
            }
        }
        return true;
    }

    public function in($value, $args) {
        $args = explode(',', $args);
        if (!in_array($value, $args)) {
            $this->set_message('in', '%s is invalid.');
            return false;
        }
        return true;
    }

    public function valid_date($year, $args = "") {
        $args = explode(',', $args);
        if ($args and isset($args[0]) and isset($args[1])) {

            $CI = & get_instance();
            $day = $CI->input->post($args[0]);
            $month = $CI->input->post($args[1]);

            if (checkdate($month, $day, $year)) {
                return true;
            }
        } else {
            $date = explode('-', $year);
            if (count($date) == 3) {
                if (checkdate($date[1], $date[2], $date[0])) {
                    return true;
                }
            }
        }
        $this->set_message('valid_date', 'Invalid date.');
        return false;
    }

    public function equals($value, $args) {

        if ($value != $args) {
            $this->set_message('equals', '%s is invalid.');
            return false;
        }
        return true;
    }

    public function password_equals($value, $args) {

        if (md5($value) != $args) {
            $this->set_message('password_equals', '%s is invalid.');
            return false;
        }
        return true;
    }

    public function phone($phone) {
        if (!preg_match("/^([0-9-])+$/i", $phone)) {
            $this->set_message('phone', '%s must contain only number and - character.');
            return false;
        }
        return true;
    }

    public function date_compare($start, $end) {


        $startdate = strtotime($start);
        $end_date = strtotime($end);
        if ($end_date > $startdate) {
            return true;
        } else {
            $this->set_message('end_date', "%s Cannot Be Smaller Than Other!");
            return false;
        }
    }

    public function valid_url($url) {

        $regex = "((https?|ftp)\:\/\/)?"; // SCHEME
        $regex .= "([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?"; // User and Pass
        $regex .= "([a-z0-9-.]*)\.([a-z]{2,3})"; // Host or IP
        $regex .= "(\:[0-9]{2,5})?"; // Port
        $regex .= "(\/([a-z0-9+\$_-]\.?)+)*\/?"; // Path
        $regex .= "(\?[a-z+&\$_.-][a-z0-9;:@&%=+\/\$_.-]*)?"; // GET Query
        $regex .= "(#[a-z_.-][a-z0-9+\$_.-]*)?"; // Anchor
        //    $url = 'http://www.domain.dk/seo/friendly/url';

        if (preg_match("/^$regex$/", trim($url))) {
            return true;
        } else {
            $this->set_message('valid_url', "The %s field must contain valid domain!");
            return false;
        }
    }

    public function alpha_spaces($str) {
        if (!preg_match("/^([a-z ])+$/i", $str)) {
            $this->set_message('alpha_spaces', 'The %s field mustnot contain any numbers');
            return false;
        } else {
            return true;
        }
    }

    public function alpha_space($str) {
        $this->set_message('alpha_space', "The %s field may only contain alphabetical characters and spaces.");
        return (!preg_match("/^([a-z\s])+$/i", $str)) ? FALSE : TRUE;
    }

    function error_array() {
        if (count($this->_error_array) === 0)
            return FALSE;
        else
            return $this->_error_array;
    }

}
