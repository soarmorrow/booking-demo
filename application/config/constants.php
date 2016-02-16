<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

//*****************************************************************
//			APPLICATION FLAGS
//*****************************************************************
define('USE_NUMBRIC_THRESHOLD', TRUE);
define('USE_ATTENDANCE_MONTHLY_REPORT', FALSE);
define('USE_PORTFOLIO_LOCKED_ON_GENERAL_REMARK', TRUE);
define('USE_PORTFOLIO_LOCKED_ON_APPROVED', TRUE);


//*****************************************************************
//			APPLICATION CONSTANTS
//*****************************************************************

define('DEFAULT_STAFF_MODULE', 'setting');

/*
 * Roles
 */
define('ROLE_SUBJECT_COORDINATOR', 4);
define('ROLE_TEACHER', 2);
define('ROLE_SUPERVISOR', 3);
define('ROLE_SUPERADMIN', 1);
define('ROLE_TECHNICAL_SPECIALIST', 6);
define('ROLE_ASSESSOR', 7);
define('ROLE_PERSONAL', 9);
define('ROLE_SUPERVISORY', 10);

/*
 * Level definition
 */

define('LEVEL_SUPERADMIN', 3);
define('LEVEL_ADMIN_SUPERVISOR', 2);
define('LEVEL_TEACHER', 1);
define('LEVEL_SUBJECT_COORDINATOR', 0);


/*
 * States of child actor
 */
define('CHILD_STATE_CURRENT', 0);
define('CHILD_STATE_WITHDRAWN', 1);
define('CHILD_STATE_GRADUATED', 2);

/*
 * Actors
 */
define('ACTOR_STAFF', 1);
define('ACTOR_PARENT', 0);

/*
 * Subject
 */
define ('SUBJECT_GENERAL_DEVELOPMENT', 1);

/*
 * Companies
 */
define ('COMPANY_BE', 5);
define ('COMPANY_BEC', 6);
define ('COMPANY_BBC', 10);
define ('COMPANY_BCC', 8);
define ('COMPANY_BDC', 12);

define('TABLE_ROW_HEADER', 'class="table_row_header"');
define('TABLE_BORDER_RIGHT_85', '<table border="1" cellpadding="2" cellspacing="1"  width = "87%">');
define('TABLE_BORDER_RIGHT', '<table id="mytable">');//'<table border="1" cellpadding="2" cellspacing="1"  width = "87%">');
define('TABLE_RIGHT', '<table border="0" cellpadding="2" cellspacing="1" width = "85%">');
define('TABLE_FULL', '<table border="0" cellpadding="2" cellspacing="1"  width = "100%">');
define('TABLE_FULL_RED', '<table border="0" cellpadding="2" cellspacing="1"  width = "100%"  style="background-color: rgb(238, 170, 170);">');
define('TABLE_BORDER_FULL', '<table border="1" cellpadding="2" cellspacing="1"  width = "100%">');
define('TABLE_LEGEND', '<table cellspacing="0" cellpadding="6" border="0" width="85%">');

define('CURRICULUM_TABLE_STYLE', '<table id="mytable">');
define('CURRICULUM_TABLE_STYLE2', '<table border="0" cellpadding="2" cellspacing="1" >');

define('INPUT_FIT_CELL', 'width:90%');
define('SELECTBOX_FIT_CELL', 'style = "width: 100%"');
define('PORTFOLIO_IMAGE_COLUMN', 3);
define('PORTFOLIO_VIDEO_COLUMN', 3);

/*
 * Dynamic Fields
 */
define('CHECK_BOX',1);
define('DATE',2);
define('EMAIL',3);
define('NUMBER',4);
define('RADIO',5);
define('DROP_DOWN',6);
define('TEXT_FIELD',7);
define('TEXT_AREA',8);
define('URL',9);
define('YES_NO',10);

/*
 * Relation types
 */
define('RELATION_FATHER', 1);
define('RELATION_MOTHER', 2);

/*
 * Rubric
 */
define('RUBRIC_THRESHOLD', 4);
define('RUBRIC_MAXIMUM', 4);

//FCK Editor config
define('ROOT_DIR', FCPATH);
define("FCK_ROOT",ROOT_DIR. "/FCKeditor/fckeditor.php");
define("DOWNLOAD_ROOT",ROOT_DIR);
define("MAILER_ROOT",ROOT_DIR."/phpMailer/class.phpmailer.php");

/*
* Backup config
*/
define('FULL_BACKUP', 1);
define('TABLE_BACKUP', 2);
define('BACKUP_TO_ZIP', TRUE);

define('FORMAT_DATE', 'd M Y');
define('DATE_FORMAT', 'Y-m-d H:i:s');

/*
* Backup config
*/
define('MASTER_FREE', TRUE); //this constant will determine whether master admin can see subjects across all centres or only his/her


//*****************************************************************
/* End of file constants.php */
/* Location: ./application/config/constants.php */
