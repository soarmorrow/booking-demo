<?php

function css_tag($src) {
    if (is_array($src) and ! empty($src)) {
        $css_tags = '';
        foreach ($src as $s) {
            $href = strpos($s, 'http') === 0 ? $s : base_url($s);
            $attr = array('href' => $href, 'rel' => 'stylesheet');
            $css_tags .= "\n" . html_tag('link', $attr);
        }
        return $css_tags;
    } else {
        $href = strpos($src, 'http') === 0 ? $src : base_url($src);
        $attr = array('href' => $href, 'rel' => 'stylesheet');
        return html_tag('link', $attr);
    }
}

function js_tag($src, $content = '') {
    if (is_array($src) and ! empty($src)) {
        $js_tags = '';
        foreach ($src as $s) {
            $href = strpos($s, 'http') === 0 ? $s : base_url($s);
            $attr = array('src' => $href, 'type' => 'text/javascript');
            $js_tags .= "\n" . html_tag('script', $attr, '');
        }
        return $js_tags;
    } else {
        $href = strpos($src, 'http') === 0 ? $src : base_url($src);
        $attr = array('src' => $href, 'type' => 'text/javascript');
        return html_tag('script', $attr, $content);
    }
}

function html_tag($tag, $attr = array(), $content = false) {
    $has_content = (bool) ($content !== false and $content !== null);
    $html = '<' . $tag;

    if (empty($attr)) {
        $html .= '';
    } else {
        if (is_array($attr)) {
            foreach ($attr as $att => $val)
                $html .= ' ' . $att . '="' . $val . '"';
        } else {
            $html .= $attr;
        }
    }
    $html .= $has_content ? '>' : ' />';
    $html .= $has_content ? $content . '</' . $tag . '>' : '';

    return $html;
}

function short_description($description, $charnum) {
    if (strlen($description) <= $charnum + 4)
        return $description;

    return substr($description, 0, $charnum) . '....';
}

function show_file_name($file_name, $charnum) {
    if (strlen($file_name) <= $charnum + 7)
        return $file_name;
    else
        return substr($file_name, 0, $charnum) . '.......' . file_extension($file_name);
}

function show_status($status) {
    if ($status == 1) {
        $row = '<td style="color:green"> Active </td>';
    } else {
        $row = '<td style="color:red"> Inactive </td>';
    }
    return $row;
}

function file_extension($file_name) {
    return end(explode('.', $file_name));
}

function file_path($path, $filename, $default, $default_path = '') {
    if ($filename != '' and file_exists($path . $filename) and substr($filename, -1) != '/')
        return base_url() . $path . rawurlencode_album_item($filename);
    elseif ($default_path != '')
        return base_url() . $default_path . $default;
    else
        return base_url() . $path . $default;
}

function rawurlencode_album_item($filename) {
    $pieces = explode('/', $filename);
    if (count($pieces) > 1) {
        foreach ($pieces as $key => &$piece) {
            $piece = rawurlencode($piece);
        }
        return implode('/', $pieces);
    } else {
        return rawurlencode($filename);
    }
}

function delete_file($path, $filename) {
    if ($filename != '' and file_exists($path . $filename))
        unlink($path . $filename);
}

function is_admin($role) {
    if ($role == 'Center Admin' || $role == 'admin')
        return true;
    else
        return false;
}

function _is($role_name) {
    global $_current_centre_role;
    return $_current_centre_role->role == $role_name;
}

function _ismyrole($userid, $id) {
    global $_current_centre_role;
    $CI = & get_instance();
    $data = $CI->db->select('*')
            ->from(IMS_DB_PREFIX . 'user_role as ur')
            ->join(IMS_DB_PREFIX . 'role as r', 'r.id = ur.role_id')
            ->where('ur.user_id', $userid)
            ->where('ur.role_id', $id)
            ->get();
    if ($data->num_rows() > 0) {
        return TRUE;
    }
    return in_array($_current_centre_role->role, array('GR Admin', 'Finance Admin', 'Content Editor', 'Newsletter Admin',));
}

function _can($permission) {
    global $_permissions;
    return in_array($permission, $_permissions);
}

function year_term($year_term_id) {
    return array(
        'year' => substr($year_term_id, 0, 4),
        'term' => substr($year_term_id, 4)
    );
}

function pluck($objects, $name) {
    $array = array();
    if (is_array($objects) and ! empty($objects)) {
        foreach ($objects as $object) {
            $array[] = $object->$name;
        }
    }
    return $array;
}

function time_elapsed_string1($ptime) {
    $etime = time() - strtotime($ptime);
    if ($etime < 1) {
        return '0 seconds ago';
    } else {
        
    }

    $a = array(
        12 * 30 * 24 * 60 * 60 => 'year',
        30 * 24 * 60 * 60 => 'month',
        24 * 60 * 60 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            $r = round($d);
            return $r . ' ' . $str . ($r > 1 ? 's' : '') . ' ago';
        }
    }
}

function time_elapsed_string($date) {
    if (empty($date)) {
        return "No date provided";
    }

    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

    $now = time();
    $unix_date = strtotime($date);

    if (empty($unix_date)) {
        return "Bad date";
    }

    // is it future date or past date
    if ($now > $unix_date) {
        $difference = $now - $unix_date;
        $tense = "ago";
    } else {
        $difference = $unix_date - $now;
        $tense = "from now";
    }

    for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
        $difference /= $lengths[$j];
    }

    $difference = round($difference);

    if ($difference != 1) {
        $periods[$j].= "s";
    }

    return "$difference $periods[$j] {$tense}";
}

function progress_stat($dataz, $total_level) {

    $datas = array();
    foreach ($dataz as $data) {
        if ($data > 0) {
            $datas[] = $data;
        }
    }

    if (empty($datas) OR $total_level < 1)
        return false;

    $N = count($datas);

    $stat = array();

    if ($N > 0) {
        $stat['min'] = min($datas);
        $stat['max'] = max($datas);
        $x = array(10, 50, 90);
        for ($i = 0; $i < 3; $i++) {
            $n = round($x[$i] * $N / 100);
            if ($n <= 0) {
                $stat[$x[$i]] = $datas[0] * 100 / $total_level;
            } else {
                $sum = 0;
                for ($j = 0; $j < $n; $j++) {
                    $sum += $datas[$j];
                }
                $avg = $sum / $n;
                $stat[$x[$i]] = $avg * 100 / $total_level;
            }
        }
    }
    return $stat;
}

function calculate_leave_hours($start_date, $start_time, $end_date, $end_time, $work_profile) {
    $leave = array(
        'from' => $start_date . ' ' . $start_time,
        'to' => $end_date . ' ' . $end_time
    );

    $net_leave = 0;

    $work_plans = array();

    for ($to_date = strtotime($leave['to']), $i = 0, $x = strtotime($leave['from']); $x <= $to_date; $i++, $x = strtotime($leave['from'] . "+$i minute")) {
        $day = date('Y-m-d H:i:s', $x);
        $week_type = even_or_odd($work_profile->profile_start_date, $work_profile->start_as, $day);
        $week_index = date('N', $x);

        if (isset($work_profile->time[$week_type][$week_index])) {
            $current_work_plan = $work_profile->time[$week_type][$week_index];
            if (falls_in_interval($day, $current_work_plan) AND strtotime($leave['from']) != strtotime($day)) {
                $net_leave++;
            }
        }
    }

    $net_leave = $net_leave / 60;
    return $net_leave;
}

function even_or_odd($profile_start_date, $start_as, $date) {
    $psdw = abs(date("W", strtotime($profile_start_date)));
    $dw = abs(date("W", strtotime($date)));
    if (($psdw % 2 == 0 AND $start_as % 2 == 0) OR ( $psdw % 2 == 1 AND $start_as % 2 == 1)) { //both odd or even 
        return ($dw % 2 == 0) ? 2 : 1;
    } else {
        return ($dw % 2 == 0) ? 1 : 2;
    }
}

function in_between($needle, $haystack) {
    list($m1, $m2) = $haystack;
    return ( strtotime($needle) > strtotime($m1) AND strtotime($needle) <= strtotime($m2) );
}

function diff($x2, $x1) {
    return strtotime($x2) - strtotime($x1);
}

function falls_in_interval($minute, $interval) {

    $day = date('Y-m-d', strtotime($minute));
    foreach ($interval as $key => &$value) {
        $value = $day . ' ' . $value;
    }

    if (in_between($minute, array($interval['start_1'], $interval['end_1'])) OR in_between($minute, array($interval['start_2'], $interval['end_2']))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function leave_days($leave_hours, $awh = 9) {
    return floor($leave_hours / $awh);
}

function leave_hours($leave_hours, $awh = 9) {
    return $leave_hours % $awh;
}

function leave_status($status) {
    switch ($status) {
        case 0:
            $style = 'color: blue';
            $value = 'Pending';
            break;

        case 1:
            $style = 'color: green';
            $value = 'Accepted';
            break;

        case 2:
            $style = 'color: red';
            $value = 'Rejected';
            break;
        case 3:
            $style = 'color: voilet';
            $value = 'Revoked';
            break;
    }
}

function centre_admin($centre_id) {
    $CI = & get_instance();

    $result = $CI->db->select('*')
                    ->from(IMS_DB_PREFIX . 'user_role as ur')
                    ->join(IMS_DB_PREFIX . 'user as u', 'u.id = ur.user_id', 'left')
                    ->where('ur.role_id', 2)
                    ->where('ur.centre_id', $centre_id)
                    ->get()->row();

    return $result;
}

function event_attend($attend) {
    $res = '';
    switch ($attend) {
        case 1 :
            $res = 'Yes';
            break;
        case 2 :
            $res = 'No';
            break;
        case 3 :
            $res = 'May Be';
            break;
        default :
            $res = '';
            break;
    }
    return $res;
}

function is_leave_taken($leave_type_id) {

    $CI = & get_instance();

    $CI->db->select('lt.id')
            ->from(IMS_DB_PREFIX . 'leave_types as lt')
            ->join(IMS_DB_PREFIX . 'leave_requests as lr', 'lr.leave_type_id = lt.id')
            ->where('lt.id', $leave_type_id);

    return $CI->db->get()->num_rows() > 0;
}

function get_parents($child_id) {
    $CI = & get_instance();

    return $CI->db->select('*')
                    ->from(IMS_DB_PREFIX . 'parent_child as pc')
                    ->join(IMS_DB_PREFIX . 'parent as p', 'p.id = pc.parent_id')
                    ->where('pc.child_id', $child_id)
                    ->get()->result();
}

function generateRandomString($length = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function count_serialize($serial_obj) {
    $unserialized_obj = @unserialize($serial_obj);
    return ($unserialized_obj !== false) ? count($unserialized_obj) : 0;
}

if (!function_exists('age')) {

    function age($dob) {
        $firstTime = strtotime($dob);
        $lastTime = time();


        $time_diff = $lastTime - $firstTime;
        if ($time_diff < 0) {
            return false;
        }

        $difference = $time_diff;

        $time = new stdClass();

        $years = abs(floor($difference / 31536000));
        $months = abs(floor(($difference - ($years * 31536000)) / 2592000));
        $days = abs(floor(($difference - ($years * 31536000)) / 86400));
        $hours = abs(floor(($difference - ($years * 31536000) - ($days * 86400)) / 3600));
        $mins = abs(floor(($difference - ($years * 31536000) - ($days * 86400) - ($hours * 3600)) / 60)); #floor($difference / 60);

        $time->years = $years;
        $time->months = $months;
        $time->days = $days;
        $time->hours = $hours;
        $time->mins = $mins;
        return $time->years . ' Years ' . $time->months . ' Months';
    }

}
if (!function_exists('get_age')) {

    function get_age($dob) {
        $firstTime = strtotime($dob);
        $lastTime = time();


        $time_diff = $lastTime - $firstTime;
        if ($time_diff < 0) {
            return false;
        }
        $difference = $time_diff;
        $time = new stdClass();
        $years = abs(floor($difference / 31536000));
        $months = abs(floor(($difference - ($years * 31536000)) / 2592000));
        $time->years = $years;
        $time->months = $months;
        return $time;
    }

}

if (!function_exists('sum_array')) {

    function sum_array($array1, $array2) {
        if (count($array1) != count($array2))
            return false;
        $sum = array();
        foreach ($array1 as $key => $value) {
            $sum[$key] = $array1[$key] + $array2[$key];
        }
        return $sum;
    }

}


if (!function_exists('get_tag')) {

    function get_tag($tag_id) {
        if (empty($tag_id)) {
            return "";
        } else {
            $CI = & get_instance();
            $result = $CI->db->select('name')
                            ->from(IMS_DB_PREFIX . 'tag')
                            ->where('id', $tag_id)
                            ->get()->row();


            return $result->name;
        }
    }

}

if (!function_exists('get_relation')) {

    function get_relation($relation_id) {
        if (empty($relation_id)) {
            return "Undefined";
        } else {
            $CI = & get_instance();
            $result = $CI->db->select('name')
                            ->from(IMS_DB_PREFIX . 'variables')
                            ->where('id', $relation_id)
                            ->get()->row();

            return $result->name ? $result->name : 'Undefined';
        }
    }

}

if (!function_exists('get_tag_item')) {

    function get_tag_item($tag_item_id) {
        if (empty($tag_item_id)) {
            return "";
        } else {
            $CI = & get_instance();
            $result = $CI->db->select('name')
                            ->from(IMS_DB_PREFIX . 'tag_item')
                            ->where('id', $tag_item_id)
                            ->get()->row();

            return isset($result->name) ? $result->name : '';
        }
    }

}


if (!function_exists('break_into_half')) {

    function break_into_half($single_array, $po = false) {

        if ($po) {
            $po_legend = new stdClass();
            $po_legend->short_name = lang('po');
            $po_legend->name = lang('po_desc');
            array_unshift($single_array, $po_legend);
        }

        $length = count($single_array);
        $half_length = ceil($length / 2);
        $double_array = array();
        $double_array[] = array_slice($single_array, 0, $half_length);
        $double_array[] = array_slice($single_array, $half_length);
        return $double_array;
    }

}

if (!function_exists('format_money')) {

    function format_money($money, $currency = '', $precision = 2) {
        return round($money, $precision) . ' ' . $currency;
    }

}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

/**
 * Get the file name hash to prevent duplicate image
 * @param string $file_name 
 * @return The hashed string.
 */
if (!function_exists('get_file_name_hash')) {

    function get_file_name_hash($length = 8) {
        return time() . get_random_string($length);
    }

}

/**
 * Generate a random string.
 * @param string $length 
 * @return string
 */
if (!function_exists('get_random_string')) {

    function get_random_string($length = 42) {
        // We'll check if the user has OpenSSL installed with PHP. If they do
        // we'll use a better method of getting a random string. Otherwise, we'll
        // fallback to a reasonably reliable method.
        if (function_exists('openssl_random_pseudo_bytes')) {
            // We generate twice as many bytes here because we want to ensure we have
            // enough after we base64 encode it to get the length we need because we
            // take out the "/", "+", and "=" characters.
            $bytes = openssl_random_pseudo_bytes($length * 2);

            // We want to stop execution if the key fails because, well, that is bad.
            if ($bytes === false) {
                throw new \RuntimeException('Unable to generate random string.');
            }
            return substr(str_replace(array('/', '+', '='), '', base64_encode($bytes)), 0, $length);
        }
        $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

}

function closetags($html) {
    preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
    $openedtags = $result[1];
    preg_match_all('#</([a-z]+)>#iU', $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            $html .= '</' . $openedtags[$i] . '>';
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}

function remoteFileExists($url) {
    $file_headers = @get_headers($url);
    if ($file_headers[0] != 'HTTP/1.1 404 Not Found') {
        return true;
    } else {
        return false;
    }
}

function sub_str($a, $x, $y = null) {
    if ($y === NULL) {
        $y = self::len($a);
    }
    return mb_substr($a, $x, $y, 'UTF-8');
}
