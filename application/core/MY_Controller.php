<?php

class MY_Controller extends MX_Controller {

    var $data = array();
    var $language = "english";
    var $required_roles = array();
    var $control_url = '';
    var $current_user = NULL;
    var $module_mapping = array();
    var $default_yearterm = array();

    function __construct() {
        parent::__construct();
        global $current_language;
        $this->load->model('options_model');

        $login_data = $this->options_model->getFavicon();
        if (isset($login_data['value']))
            $this->data['favicon'] = $login_data['value'];

        $options = $this->options_model->getGroupOption();

        if ($this->session->userdata('current_centre_role')) {
            if ((isset($options['language_setting']) && !empty($options['language_setting']))) {
                $this->language = $options['language_setting']['language'];
                $this->lang->load(strtolower(get_class($this)), 'common/' . $this->language);
                $this->lang->load($this->language, 'common/' . $this->language);
            } else {
                $this->lang->load(strtolower(get_class($this)), 'common/' . $this->language);
                $this->lang->load($this->language, 'common/' . $this->language);
            }
            $current_language = $this->language;
        } else {
            $this->lang->load(strtolower(get_class($this)), 'common/' . $this->language);
            $this->lang->load($this->language, 'common/' . $this->language);
        }
        $this->session->set_userdata('fb_app_key', $this->options_model->getOption('fb_app_key'));

        $this->data['js_lang'] = array();
        $this->data['js_lang']['save'] = lang('save');
        $this->data['js_lang']['cancel'] = lang('cancel');
        $this->data['js_lang']['submit'] = lang('submit');
        $this->data['js_lang']['close'] = lang('close');
        $this->data['js_lang']['something_went_wrong'] = lang('something_went_wrong');


        global $date_format_settings;
        $default = array('date_format' => 'Y-m-d', 'time_format' => 'H:i:s', 'timezone' => 'Asia/Kathmandu');
        $date_format_settings = $this->options_model->getOption('date_format_settings', $default);

        date_default_timezone_set($date_format_settings['timezone']);

        /* Checking if the plan has expired. */
        $expiry_date = $options['expiry_date'];
        if (!empty($expiry_date)) {
            if (strtotime($expiry_date['date']) < time()) {
                
            }
        }

        /* Check if the company is suspended */
        $suspended_arr = $options['company_status'];
        if (!empty($suspended_arr)) {
            if ($suspended_arr['status'] == 'Suspended')
                show_error('Company has been suspended. Please contact Admin');
        }

        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: private, must-revalidate, max-age=0,  no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Keep-Alive", "timeout=3, max=4");
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        $this->output->set_header("Url: " . str_replace(site_url() . '/', '', current_url()));

        $this->data['stylesheets'] = array();
        $this->data['javascripts'] = array();

        $this->load_module_assets();

        $this->_flashdata();
    }

    protected function append_stylesheet($stylesheet) {
        $this->data['stylesheets'][] = $stylesheet;
    }

    protected function append_javascript($javascript) {
        $this->data['javascripts'][] = $javascript;
    }

    protected function prepend_javascript($javascript) {
        array_unshift($this->data['javascripts'], $javascript);
    }

    protected function send_mail($to, $to_name, $subject, $message, $cc = array()) {

        $mail_settings = $this->options_model->getOption('mail_settings');
//        $data=Array(
//            'protocol' => 'smtp',
//            'smtp_host' => 'ssl://smtp.googlemail.com',
//            'smtp_port' => 465,
//            'smtp_username' => 'pravi0025@gmail.com',
//            'smtp_password' => 'pravi123456',
//            'from_email'=>'pravi0025@gmail.com',
//            'from_name'=>'Goretreat'
//        );
//        debug(serialize($data));
        if (!isset($mail_settings['protocol']))
            return false;

        $this->load->library('email');
        if ($mail_settings['protocol'] == 'sendmail') {
            $config['protocol'] = 'sendmail';
            $config['mailpath'] =$mail_settings['sendmail_path'];
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE;
        } else if ($mail_settings['protocol'] == 'smtp') {
            $config['protocol'] = 'smtp';
            $config['smtp_host'] = $mail_settings['smtp_host'];
            $config['smtp_port'] = $mail_settings['smtp_port'];
            $config['smtp_user'] = $mail_settings['smtp_username'];
            $config['smtp_pass'] = $mail_settings['smtp_password'];
        } else {
            $config['protocol'] = 'mail';
        }

        $config['charset'] = 'iso-8859-1';
        $config['mailtype'] = 'html';

        $this->email->initialize($config);

        $this->email->from($mail_settings['from_email'], $mail_settings['from_name']);

        $this->email->to($to, $to_name);

        if (!empty($cc))
            $this->email->cc($cc);

        $this->email->subject($subject);

        $this->email->message($message);

        $this->email->set_newline("\r\n");
        $data= $this->email->send();
//        debug($this->email->print_debugger());
        return $data;
    }

    protected function _set_flashdata($message, $type = 'success') {
        $feedback_information = (object) array('message' => $message, 'type' => $type);
        $this->session->set_flashdata('feedback_information', $feedback_information);
    }

    protected function _flashdata() {
        $feedback_information = $this->session->flashdata('feedback_information');
        if (isset($feedback_information->message))
            $this->data['feedback_information'] = '$.jGrowl("' . $feedback_information->message . '",{header:"' . ucfirst($feedback_information->type) . '!",sticky:false,position:"bottom-right"});';
        else
            $this->data['feedback_information'] = false;
    }

    protected function _show_message($message, $type = 'success') {
        $this->data['feedback_information'] = '$.jGrowl("' . $message . '",{header:"' . ucfirst($type) . '!",sticky:false,position:"bottom-right"});';
    }

    //getting per page
    protected function get_per_page($segment = 4, $default_per_page = '') {
        $per_page = $this->uri->segment($segment);
        if ($per_page != 0 && !empty($per_page)) {
            $this->session->set_userdata($this->data['current_controller_method'] . '_perpage', $per_page);
        }

        if ($this->session->userdata($this->data['current_controller_method'] . '_perpage')) {
            $this->data['perpage'] = $this->session->userdata($this->data['current_controller_method'] . '_perpage');
            return $this->data['perpage'];
        } else {
            $this->data['perpage'] = $default_per_page ? $default_per_page : $this->config->item('per_page');
            return $this->data['perpage'];
        }
    }

    protected function sort_by($field_name, $module, $table = null, $default_type = 'asc') {
        $sort = array();
        $sort['name'] = $field_name;
        if (!empty($table)) {
            $sort['table'] = $table;
        }
        if ($this->input->post('change_sort') == 'true') {
            if ($this->session->userdata($module . '_sorting_field') && $this->session->userdata($module . '_sorting_field') == $sort['name']) {

                if ($this->session->userdata($module . '_sorting_type') == 'asc') {
                    $this->session->set_userdata($module . '_sorting_type', 'desc');
                    $sort['type'] = 'desc';
                } else {
                    $this->session->set_userdata($module . '_sorting_type', 'asc');
                    $sort['type'] = 'asc';
                }
            } else {
                $this->session->set_userdata($module . '_sorting_type', 'asc');
                $this->session->set_userdata($module . '_sorting_field', $sort['name']);
                $sort['type'] = $default_type;
            }
        } else {
            $sort['type'] = $this->session->userdata($module . '_sorting_type') ? $this->session->userdata($module . '_sorting_type') : $default_type;
        }

        return $sort;
    }

    //sorting function 
    protected function sort_by_for_task($field_name, $module, $default_column = null, $default_type = 'asc') {

        $sort = array();

        if ($field_name === false AND $this->session->userdata($module . '_sorting_field') === false)
            $sort['name'] = $default_column;
        elseif ($field_name === false AND $this->session->userdata($module . '_sorting_field'))
            $sort['name'] = $this->session->userdata($module . '_sorting_field');
        else
            $sort['name'] = $field_name;

        if ($this->session->userdata($module . '_sorting_field') && $this->session->userdata($module . '_sorting_field') == $sort['name']) {

            if ($field_name !== false) {
                if ($this->session->userdata($module . '_sorting_type') == 'asc') {
                    $this->session->set_userdata($module . '_sorting_type', 'desc');
                    $sort['type'] = 'desc';
                } else {
                    $this->session->set_userdata($module . '_sorting_type', 'asc');
                    $sort['type'] = 'asc';
                }
            } else {
                if ($this->session->userdata($module . '_sorting_type')) {
                    $sort['type'] = $this->session->userdata($module . '_sorting_type');
                } else {
                    $sort['type'] = $default_type;
                    $this->session->set_userdata($module . '_sorting_type', $default_type);
                }
            }
        } else {
            if ($this->session->userdata($module . '_sorting_type')) {
                $sort['type'] = $this->session->userdata($module . '_sorting_type');
            } else {
                $sort['type'] = $default_type;
                $this->session->set_userdata($module . '_sorting_type', $default_type);
            }
            $this->session->set_userdata($module . '_sorting_field', $sort['name']);
        }


        return $sort;
    }

    //for pagination
    protected function paginate($perpage, $total, $base_url, $uri_segment, $class = "") {
        if ($total > $perpage) {
            $this->load->library('pagination');

            $config['base_url'] = site_url($base_url);
            $config['total_rows'] = $total;
            $config['per_page'] = $perpage;
            $config['uri_segment'] = $uri_segment;

            $config['first_link'] = '&lsaquo; First';
            $config['next_link'] = 'Next';
            $config['prev_link'] = 'Prev';
            $config['last_link'] = 'Last &rsaquo;';

            $config['full_tag_open'] = '<ul class="dataTables_paginate paging_full_numbers ' . $class . '" id="da-pagination" style="margin-bottom: 0px;">';
            $config['full_tag_close'] = '</ul>';

            $config['first_tag_open'] = '<li class="first paginate_button">';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="last paginate_button">';
            $config['last_tag_close'] = '</li>';

            $config['cur_tag_open'] = '<li class="paginate_active">';
            $config['cur_tag_close'] = '</li>';
            $config['num_tag_open'] = '<li class="paginate_button">';
            $config['num_tag_close'] = '</li>';

            $config['next_tag_open'] = '<li class="next paginate_button">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="previous paginate_button">';
            $config['prev_tag_close'] = '</li>';

            if (isset($this->data['filter']))
                $_GET['filter'] = $this->data['filter'];

            if (count($_GET) > 0) {
                $config['suffix'] = '?' . http_build_query($_GET, '', "&");
                $config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
            }

            $this->pagination->initialize($config);
            $this->data['pagination'] = $this->pagination->create_links();
        }
        if ($total > 0) {
            $offset = $this->uri->segment($uri_segment);
            $from = $offset + 1;
            $to = ($offset + $perpage > $total) ? $total : $offset + $perpage;
            $this->data['pagination_details'] = $to == 1 ? 'Showing 1 entry' : lang('showing') . ' ' . $from . ' ' . lang('p_to') . ' ' . $to . ' ' . lang('p_of') . ' ' . $total . ' ' . lang('entries');
        }
    }

    protected function download_pdf($html) {
        $this->load->library('tcpdf');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Nicola Asuni');
        $pdf->SetTitle('TCPDF Example 001');
        $pdf->SetSubject('TCPDF Tutorial');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
            require_once(dirname(__FILE__) . '/lang/eng.php');
            $pdf->setLanguageArray($l);
        }

        $pdf->setFontSubsetting(true);

        $pdf->SetFont('dejavusans', '', 14, '', true);

        $pdf->AddPage();

        $pdf->setTextShadow(array('enabled' => true, 'depth_w' => 0.2, 'depth_h' => 0.2, 'color' => array(196, 196, 196), 'opacity' => 1, 'blend_mode' => 'Normal'));

        $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

        $pdf->Output('example_001.pdf', 'I');
    }

    protected function load_module_assets() {

        $module_directory = $this->router->fetch_module();
        foreach (Modules::$locations as $location => $offset) {
            if (file_exists($location . $module_directory)) {
                $module_path = str_replace(FCPATH, '', $location);
                $module_directory_path = $location . $module_directory . '/';
                break;
            }
        }
        $module_asset_base = base_url() . $module_path . $module_directory . '/';

        if (file_exists(FCPATH . $module_path . $module_directory . '/js')) {
            $module_js = opendir(FCPATH . $module_path . $module_directory . '/js');
            while (($file = readdir($module_js)) !== false) {
                if (filetype($module_directory_path . 'js/' . $file) and file_extension($file) == 'js')
                    $this->append_javascript($module_asset_base . 'js/' . $file);
            }
            closedir($module_js);
        }

        if (file_exists(FCPATH . $module_path . $module_directory . '/css')) {
            $module_css = opendir(FCPATH . $module_path . $module_directory . '/css');
            while (($file = readdir($module_css)) !== false) {
                if (filetype($module_directory_path . 'css/' . $file) and file_extension($file) == 'css')
                    $this->append_stylesheet($module_asset_base . 'css/' . $file);
            }
            closedir($module_css);
        }
    }

    protected function SendSMTPMail($to, $to_name, $subject, $message, $cc = array()) {
//        debug(htmlspecialchars($message));
        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => 465,
            'smtp_user' => 'goretreat1@gmail.com',
            'smtp_pass' => 'Mail$2015',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'newline'=>"\r\n",
            'wordwrap'=>TRUE,
            'validation' => TRUE
        );
        $this->load->library('email', $config);
// Set to, from, message, etc.

        $this->email->from('mailatsoarmorrow@gmail.com', 'Goretreat');
        $this->email->to($to,$to_name);

        $this->email->subject($subject);
        $this->email->message($message);

        $result = $this->email->send();
        return $result;
    }

}
