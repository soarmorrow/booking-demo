<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
  |--------------------------------------------------------------------------
  | Active template
  |--------------------------------------------------------------------------
  |
  | The $template['active_template'] setting lets you choose which template
  | group to make active.  By default there is only one group (the
  | "default" group).
  |
 */
$template['active_template'] = 'default';

/*
  |--------------------------------------------------------------------------
  | Explaination of template group variables
  |--------------------------------------------------------------------------
  |
  | ['template'] The filename of your master template file in the Views folder.
  |   Typically this file will contain a full XHTML skeleton that outputs your
  |   full template or region per region. Include the file extension if other
  |   than ".php"
  | ['regions'] Places within the template where your content may land.
  |   You may also include default markup, wrappers and attributes here
  |   (though not recommended). Region keys must be translatable into variables
  |   (no spaces or dashes, etc)
  | ['parser'] The parser class/library to use for the parse_view() method
  |   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
  |   Smarty Parser that works perfectly with Template
  | ['parse_template'] FALSE (default) to treat master template as a View. TRUE
  |   to user parser (see above) on the master template
  |
  | Region information can be extended by setting the following variables:
  | ['content'] Must be an array! Use to set default region content
  | ['name'] A string to identify the region beyond what it is defined by its key.
  | ['wrapper'] An HTML element to wrap the region contents in. (We
  |   recommend doing this in your template file.)
  | ['attributes'] Multidimensional array defining HTML attributes of the
  |   wrapper. (We recommend doing this in your template file.)
  |
  | Example:
  | $template['default']['regions'] = array(
  |    'header' => array(
  |       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
  |       'name' => 'Page Header',
  |       'wrapper' => '<div>',
  |       'attributes' => array('id' => 'header', 'class' => 'clearfix')
  |    )
  | );
  |
 */

/*
  |--------------------------------------------------------------------------
  | Default Template Configuration (adjust this or create your own)
  |--------------------------------------------------------------------------
 */

$template['default']['template'] = 'master_template';
$template['default']['regions'] = array(
    'logo',
    'breadcrumb',
    'menutop',
    'header',
    'content',
    'footer',
);
$template['default']['parser'] = 'parser';
$template['default']['parser_method'] = 'parse';
$template['default']['parse_template'] = FALSE;


// Template for main:
$template['admincp']['template'] = 'admincp_template';
// Template for admin:
$template['admin']['template'] = 'admin_master_template';
$template['admin']['regions'] = array(
    'logo',
    'breadcrumb',
    'menutop',
    'header',
    'leftcontent',
    'rightcontent',
    'footer',
);
$template['admin']['parser'] = 'parser';
$template['admin']['parser_method'] = 'parse';
$template['admin']['parse_template'] = FALSE;


// Template for report:
$template['empty_report']['template'] = 'empty_report';
$template['empty_report']['regions'] = array(
    'content',
);
$template['empty_report']['parser'] = 'parser';
$template['empty_report']['parser_method'] = 'parse';
$template['empty_report']['parse_template'] = FALSE;

// Template for login:
$template['login']['template'] = 'login_template';
$template['login']['regions'] = array(
    'content',
);
$template['login']['parser'] = 'parser';
$template['login']['parser_method'] = 'parse';
$template['login']['parse_template'] = FALSE;
//template ajax

$template['ajax_result_template']['template'] = 'ajax_result_template';
$template['ajax_result_template']['regions'] = array(
    'content',
);
$template['ajax_result_template']['parser'] = 'parser';
$template['ajax_result_template']['parser_method'] = 'parse';
$template['ajax_result_template']['parse_template'] = FALSE;
/* End of file template.php */
/* Location: ./system/application/config/template.php */