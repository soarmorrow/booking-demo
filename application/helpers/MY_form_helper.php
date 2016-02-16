<?php

function _get_select_array($items, $display = 'name', $value = 'id', $add_default_item = false) {
    $select_array = array();

    if ($add_default_item) {
        $select_array[0] = lang('---Please select an item---');
    }

    foreach ($items as $index => $item) {
        $select_array[$item[$value]] = $item[$display];
    }

    return $select_array;
}

function get_image_tag($img_src, $w = '', $h = '') {
    $tag = '';

    $tag = '<img src="' . $img_src . '" ' . (!empty($w) ? 'width="' . $w : '"') . ' ' . (!empty($h) ? 'height="' . $h : '"') . '/>';

    return $tag;
}

function format_strong($text) {
    return '<strong>' . $text . '</strong>';
}

function make_link($title, $function) {
    return '<a href="javascript:void(0)" onclick=' . $function . '>' . $title . '</a>';
}

?>