<?php

if (!function_exists('dateFormat')) {

    function dateFormat($date = '') {
        global $date_format_settings;
        if (strtotime($date) === false) {
            return $date;
        } else {
            return $date == '' ? '' : date($date_format_settings['date_format'], strtotime($date));
        }
    }

}

if (!function_exists('payment_date_format')) {

    function payment_date_format($date = '') {
        global $payment_date_format_settings;
        return $date == '' ? '' : date($payment_date_format_settings['date_format'], strtotime($date));
    }

}

if (!function_exists('timeFormat')) {

    function timeFormat($time = '') {
        global $date_format_settings;
        return $time == '' ? '' : date($date_format_settings['time_format'], strtotime($time));
    }

}

if (!function_exists('datetimeFormat')) {

    function datetimeFormat($datetime = '') {
        global $date_format_settings;
        if (strtotime($datetime) === false) { //$datetime == '2037-01-01 00:00:00' OR $datetime == '0000-00-00 00:00:00'
            return $datetime;
        } else {
            return $datetime == '' ? '' : date($date_format_settings['date_format'] . ' ' . $date_format_settings['time_format'], strtotime($datetime));
        }
    }

}

if (!function_exists('cch_datetimeFormat')) {

    function cch_datetimeFormat($datetime = '') {
        global $date_format_settings;
        if (strtotime($datetime) === false OR strtotime($datetime) < 0) { //$datetime == '2037-01-01 00:00:00' OR $datetime == '0000-00-00 00:00:00'
            return $datetime;
        } else {
            return $datetime == '' ? '' : date($date_format_settings['date_format'] . ' ' . 'H:i', strtotime($datetime));
        }
    }

}

if (!function_exists('cch_dateFormat')) {

    function cch_dateFormat($datetime = '') {
        global $date_format_settings;
        if (strtotime($datetime) === false OR strtotime($datetime) < 0) { //$datetime == '2037-01-01 00:00:00' OR $datetime == '0000-00-00 00:00:00'
            return $datetime;
        } else {
            return $datetime == '' ? '' : date($date_format_settings['date_format'], strtotime($datetime));
        }
    }

}

if (!function_exists('datepicker_format')) {

    function datepicker_format() {

        global $date_format_settings;
        switch ($date_format_settings['date_format']) {
            case 'm/d/Y':
                return 'mm/dd/yy';
                break;

            case 'd M Y':
                return 'dd M yy';
                break;

            case 'F j, Y':
                return "MM d, yy";
                break;

            default:
                return 'yy-mm-dd';
                break;
        }
    }

}

if (!function_exists('payment_datepicker_format')) {

    function payment_datepicker_format() {
        global $payment_date_format_settings;
        switch ($payment_date_format_settings['date_format']) {
            case 'm/d/Y':
                return 'mm/dd/yy';
                break;

            case 'd M Y':
                return 'dd M yy';
                break;

            case 'F j, Y':
                return "MM d, yy";
                break;

            default:
                return 'yy-mm-dd';
                break;
        }
    }

}

if (!function_exists('timepicker_format')) {

    function timepicker_format() {

        global $date_format_settings;
        switch ($date_format_settings['time_format']) {
            case 'H:i:s':
                return 'H:i:s';
                break;

            case 'g:i A':
                return "g:i A";
                break;

            case 'G:i':
                return 'G:i';
                break;
            default:
                return 'H:i:s';
                break;
        }
    }

}

if (!function_exists('mysqlDateFormat')) {

    function mysqlDateFormat($date = '') {
        return $date == '' ? '' : date('Y-m-d', strtotime($date));
    }

}

if (!function_exists('mysqlTimeFormat')) {

    function mysqlTimeFormat($time = '') {
        return $time == '' ? '' : date('H:i:s', strtotime($time));
    }

}

if (!function_exists('mysqlDateTimeFormat')) {

    function mysqlDateTimeFormat($datetime = '') {
        if (strtotime($datetime) === false) {
            return $datetime;
        } else {
            return $datetime == '' ? '' : date('Y-m-d H:i:s', strtotime($datetime));
        }
    }

}

function date_time_zone() {

    $list = DateTimeZone::listAbbreviations();
    $idents = DateTimeZone::listIdentifiers();

    $data = $offset = $added = array();
    foreach ($list as $abbr => $info) {
        foreach ($info as $zone) {
            if (!empty($zone['timezone_id']) AND ! in_array($zone['timezone_id'], $added) AND in_array($zone['timezone_id'], $idents)) {
                $z = new DateTimeZone($zone['timezone_id']);
                $c = new DateTime(null, $z);
                $zone['time'] = $c->format('H:i a');
                $data[] = $zone;
                $offset[] = $z->getOffset($c);
                $added[] = $zone['timezone_id'];
            }
        }
    }
    array_multisort($offset, SORT_ASC, $data);
    $options = array();
    foreach ($data as $key => $row) {
        $options[$row['timezone_id']] = $row['time'] . ' - ' . formatOffset($row['offset']) . ' ' . $row['timezone_id'];
    }
    return $options;
}

function formatOffset($offset) {
    $hours = $offset / 3600;
    $remainder = $offset % 3600;
    $sign = $hours > 0 ? '+' : '-';
    $hour = (int) abs($hours);
    $minutes = (int) abs($remainder / 60);

    if ($hour == 0 AND $minutes == 0) {
        $sign = ' ';
    }
    return 'GMT' . $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) . ':' . str_pad($minutes, 2, '0');
}

if (!function_exists('month_start_end')) {

    function month_start_end($month, $year) {
        $month_start = $year . '-' . $month . '-01';
        $next_month_start = date('Y-m-d', strtotime('+1 month', strtotime($month_start)));
        $month_last = date('Y-m-d', strtotime('-1 day', strtotime($next_month_start)));

        $return = new stdClass();
        $return->start = $month_start;
        $return->end = $month_last;

        return $return;
    }

}

if (!function_exists('valid_date')) {

    function valid_date($date) {
        if (false === strtotime($date)) {
            return false;
        } else {
            list($year, $month, $day) = explode('-', date('Y-m-d', strtotime($date)));
            if (false === checkdate($month, $day, $year)) {
                return false;
            }
        }
        return true;
    }

}