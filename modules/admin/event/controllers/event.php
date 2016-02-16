<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of event
 *
 * @author Lachu
 */
class event extends Admin_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model(array('event_model', 'promo_code_model', 'centre/centre_model'));
        $this->load->library('pagination');
    }

    function index() {
        if (!_can("Event")) {
            redirect(site_url("dashboard"));
        }
        $filters = array();
        if ($this->input->post()) {
            $filters['content'] = $this->input->post('content');
            $filters['start'] = $this->input->post('start');
            $filters['end'] = $this->input->post('end');
            $filters['status'] = $this->input->post('status');
            if ($filters['status'] == '1') {
                $filters['published'] = TRUE;
                $filters['unpublished'] = false;
            } else if ($filters['status'] == '0') {
                $filters['unpublished'] = TRUE;
                $filters['published'] = FALSE;
            }

            $this->session->set_userdata($filters);
        } else {
            if (!$this->uri->segment(2)) {
                $session_items = array(
                    'content' => '',
                    'start' => '',
                    'end' => '',
                    'status' => '',
                    'published' => '',
                    'unpublished' => ''
                    );
                $this->session->unset_userdata($session_items);
            } else {
                $filters['content'] = $this->session->userdata('content');
                $filters['start'] = $this->session->userdata('start');
                $filters['end'] = $this->session->userdata('end');
                $filters['status'] = $this->session->userdata('status');
                $filters['published'] = $this->session->userdata('published');
                $filters['unpublished'] = $this->session->userdata('unpublished');
            }
        }
//        debug($this->session->userdata);
        $total = $this->event_model->get_event_count($filters, $this->current_user->id);
        //pagination settings
        $config['base_url'] = site_url('event/index');
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('centre_per_page') ? $this->session->userdata('centre_per_page') : 10;
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
        // debug($this->data['pagination']);
        $this->data['filters'] = $filters;
        $this->data['events'] = $this->event_model->getevents($this->current_user->id, $this->data['per_page'], $this->data['page'], $filters);
        $this->gr_template->build('events_view', $this->data);
    }

    function addnew() {
        if (!_can("Event")) {
            redirect(site_url("dashboard"));
        }
        $this->data['preacherarray'] = array();
        $this->data['accomodation'] = array();
        $this->data['lat'] = $this->data['long'] = 0;
        if ($this->input->post()) {
            $this->data['preacherarray'] = $this->input->post('preachers', TRUE);
            $this->data['long'] = $this->input->post('longitude', TRUE);
            $this->data['lat'] = $this->input->post('latitude', TRUE);
            if ($this->_validate_event()) {
                if (empty($_FILES['logo']['name'])) {
                    $logo = '';
                } else if ($_FILES['logo']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] = './uploads/image/event_logo/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB
                    if (!file_exists('./uploads/image/event_logo')) {
                        if (!mkdir('./uploads/image/event_logo/', 0755, TRUE)) {
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
                        $config['width'] = 300;
                        $config['height'] = 300;

                        $this->load->library('image_lib', $config);

                        if (!$this->image_lib->resize()) {
//                        debug($this->image_lib->display_errors('', ''));
                            $logo = 'uploads/images/eventslider/14520608113861.png';
                        } else {
                            $logo = 'uploads/image/event_logo/' . $this->upload->file_name;
                        }
                    }
                }


                if (_is("RC Admin")) {
                    $center = $this->session->userdata('current_centre_role')->center_id;
                } else {
                    $center = $this->input->post('center_id', TRUE);
                }
                $event = array(
                    'name' => $this->input->post('ename', TRUE),
                    'address' => $this->input->post('address', TRUE),
                    'center_id' => $center,
                    'start_date' => date(DATE_FORMAT, strtotime($this->input->post('startdate', TRUE))),
                    'end_date' => date(DATE_FORMAT, strtotime($this->input->post('enddate', TRUE))),
                    'description' => $this->input->post('description', TRUE),
                    'status' => 1,
                    'attendance_fee' => null,
                    'image' => $logo,
                    'type_id' => $this->input->post('etype', TRUE),
                    'total_seats' => $this->input->post('total_seats', TRUE),
                    'available_seats' => 0,
                    'booked_seats' => 0,
                    'longitude' => $this->input->post('longitude', TRUE),
                    'lattitude' => $this->input->post('latitude', TRUE),
                    'create_id' => $this->current_user->id,
                    'update_id' => $this->current_user->id,
                    'published' => 0,
                    'id_country' => $this->input->post('country', TRUE),
                    'start_time' => $this->input->post('starttime'),
                    'end_time' => $this->input->post('endtime')
                    );

$accomodation = $this->input->post('accomodation');
$this->data['accomodation'] = $accomodation;
$eventimages = $this->input->post('eventimages');
if ($this->event_model->add_event($event, $eventimages, $this->data['preacherarray'], $accomodation)) {
    $this->session->set_flashdata('message', 'New Event added');
    $this->data['typealert'] = "success";
    $this->data['message'] = "New centre added";
    redirect(current_url());
} else {
    $this->data['typealert'] = "error";
    $this->data['message'] = "Failed to add new centre";
}
} else {
    $this->data['accomodation'] = $this->input->post('accomodation');
                // debug(validation_errors());
}
}
$this->data['accommodation'] = $this->event_model->loadAccomodation();
$this->data['centers'] = $this->event_model->loadCenters($this->current_user->id);
$this->data['country'] = $this->event_model->loadcountry();
$this->data['eventtypes'] = $this->event_model->geteventtypes();
$this->data['preacherslist'] = $this->event_model->getPreachers();
$this->gr_template->build('add_event', $this->data);
}

public function view($id) {
    if (!_can("Event")) {
        redirect(site_url("dashboard"));
    }
    $this->data['views'] = $this->centre_model->get_centre_view_count($id, 2);
    $this->data['event_id'] = $event_id = $id;
    $this->data['event'] = $this->event_model->get_event($event_id);
    $this->data['images'] = $this->event_model->get_event_images($event_id);
    $this->gr_template->build('view_event', $this->data);
}

private function _validate_event($check_name = TRUE, $check_email = TRUE) {
    $this->form_validation->set_rules('ename', 'Event Name', "trim|required");
    $this->form_validation->set_rules('address', 'Address', 'trim');
    $this->form_validation->set_rules('preachers', 'Preachers', 'required');
    if (!_is("RC Admin")) {
        $this->form_validation->set_rules('center_id', 'Center', 'required');
    }
    $this->form_validation->set_rules('startdate', 'Start Date', 'trim|required');
    $this->form_validation->set_rules('enddate', 'End Date', 'trim|required|callback_compareDates');
    $this->form_validation->set_rules('starttime', 'Start Time', 'trim|required');
    $this->form_validation->set_rules('endtime', 'End Time', 'trim|required|callback_compareTimes');
//        $this->form_validation->set_rules('att_fee', 'Attendance fee ', 'trim|required');
//        $this->form_validation->set_rules('published_seats', 'Total seats', 'trim|callback_compareSeats');
    $this->form_validation->set_rules('total_seats', 'Total seats', 'trim|required');
    $this->form_validation->set_rules('accomodationtypelist', 'Total seats', 'trim|callback_compareSeats');
    $this->form_validation->set_rules('etype', 'Event type', 'required');
    $this->form_validation->set_rules('description', ' ', 'trim');
    return $this->form_validation->run($this) == TRUE;
}

function compareDates() {
    $start = strtotime($this->input->post('startdate'));
    $end = strtotime($this->input->post('enddate'));
    if ($start > $end) {
        $this->form_validation->set_message('compareDates', 'Your start date must be earlier than your end date');
        return false;
    }
}

function compareSeats() {
    $total = $this->input->post('total_seats');
    $available = $this->input->post('published_seats', TRUE);
    $accomodation = $this->input->post('accomodation');
    $sum = 0;
    $j = 0;
    foreach ($accomodation['seats'] AS $seats) {
        if ($seats == '') {
            $this->form_validation->set_message('compareSeats', 'Seats for the accomodation type required');
            return false;
        }
        if ($accomodation['type'][$j] == '') {
            $this->form_validation->set_message('compareSeats', 'Accomodation type required');
            return false;
        }
        if ($accomodation['rate'][$j] == '') {
            $this->form_validation->set_message('compareSeats', 'Accomodation type require price for adults required');
            return false;
        }
        if ($accomodation['child'][$j] == '') {
            $this->form_validation->set_message('compareSeats', 'Accomodation type require price for kids required');
            return false;
        }
        $sum = $sum + intval($seats);
        $j++;
    }
    if ($sum > $total) {
        $this->form_validation->set_message('compareSeats', 'Your available seat must not be greater than total seats');
        return false;
    }
}

function compareTimes() {
    $start = strtotime($this->input->post('starttime'));
    $end = strtotime($this->input->post('endtime'));
    if ($start > $end) {
        $this->form_validation->set_message('compareTimes', 'Your start time must be earlier than your end time');
        return false;
    }
}

function delete_event($id) {
    echo $this->event_model->delete($id, $this->current_user->id);
}

public function change_perpage($perpage = "") {
    if (is_numeric($perpage)) {
        $perpage = (int) $perpage;
    } else {
        $perpage = 10;
    }
    $this->session->set_userdata('centre_per_page', $perpage);
    exit();
}

public function verify($id = 0, $verify = 0) {
    if ((int) $verify === 1) {
        $data = array("published" => 1, "published_at" => mdate('Y-m-d H:i:s', now()));
    } else {
        $data = array("published" => 0);
    }
    if ($this->event_model->update_event_status((int) $id, $data)) {
        echo TRUE;
        exit();
    }
    echo FALSE;
    exit();
}

public function verify_preacher($id = 0, $verify = 0) {
    if ((int) $verify === 1) {
        $data = array("published" => 1);
    } else {
        $data = array("published" => 0);
    }
    if ($this->event_model->update_preacher_status((int) $id, $data)) {
        echo TRUE;
        exit();
    }
    echo FALSE;
    exit();
}

public function update($id) {
    if (!_can("Event")) {
        redirect(site_url("dashboard"));
    }
    $this->data['event_id'] = $event_id = $id;
    $this->data['preacherarray'] = $this->event_model->get_event_preachers($event_id);
    $this->data['accomodation'] = $this->event_model->loadAddedAccomodation($id);
    if ($this->input->post()) {
        if ($this->_validate_event()) {
            $this->data['preacherarray'] = $this->input->post('preachers', TRUE);
            if (empty($_FILES['logo']['name'])) {
                $logo = '';
            } else if ($_FILES['logo']['error'] == 0) {
                    //upload and update the file
                $config['upload_path'] = './uploads/image/event_logo/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB
                if (!file_exists('./uploads/image/event_logo')) {
                    if (!mkdir('./uploads/image/event_logo/', 0755, TRUE)) {
                            //echo 'false';
                    }
                }
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo')) {
                    $logo = '';
                } else {
                        //Image Resizing
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 300;
                    $config['height'] = 300;

                    $this->load->library('image_lib', $config);

                    if (!$this->image_lib->resize()) {
//                        debug($this->image_lib->display_errors('', ''));
                        $logo = '';
                    } else {
                        $logo = 'uploads/image/event_logo/' . $this->upload->file_name;
                    }
                }
            }
//                debug(date(DATE_FORMAT,  strtotime($this->input->post('startdate', TRUE))));

            if (_is("Event admin")) {
                $center = $this->session->userdata('current_centre_role')->center_id;
//            $center=
            } else {
                $center = $this->input->post('center_id', TRUE);
            }
            $event = array(
                'name' => $this->input->post('ename', TRUE),
                'address' => $this->input->post('address', TRUE),
                'center_id' => $center,
                'start_date' => date(DATE_FORMAT, strtotime($this->input->post('startdate', TRUE))),
                'end_date' => date(DATE_FORMAT, strtotime($this->input->post('enddate', TRUE))),
                'description' => $this->input->post('description', TRUE),
                'attendance_fee' => $this->input->post('att_fee', TRUE),
                'type_id' => $this->input->post('etype', TRUE),
                'total_seats' => $this->input->post('total_seats', TRUE),
//                    'available_seats' => $this->input->post('total_seats', TRUE),
                'longitude' => $this->input->post('longitude', TRUE),
                'lattitude' => $this->input->post('latitude', TRUE),
                'update_id' => $this->current_user->id,
                'id_country' => $this->input->post('country', TRUE),
                'start_time' => $this->input->post('starttime', TRUE),
                'end_time' => $this->input->post('endtime', TRUE)
                );
if ($logo != '') {
    $event['image'] = $logo;
}
$this->data['accomodation'] = $this->input->post('accomodation');
$eventimages = $this->input->post('eventimages');
if ($this->event_model->update_event($event, $event_id, $eventimages, $this->current_user->id, $this->data['preacherarray'], $this->data['accomodation'])) {
    $this->session->set_flashdata('message', 'Event updated successfully');
    $this->data['typealert'] = "success";
    $this->data['message'] = "Event updated successfully";
    redirect(current_url());
} else {
    $this->data['typealert'] = "error";
    $this->data['message'] = "Failed to update event";
}
} else {
    $this->data['accomodation'] = $this->input->post('accomodation');
}
}
$this->data['accommodation'] = $this->event_model->loadAccomodation();
$this->data['event'] = $this->event_model->get_event($event_id);
$this->data['centers'] = $this->event_model->loadCenters($this->current_user->id);
$this->data['country'] = $this->event_model->loadcountry();
$this->data['eventtypes'] = $this->event_model->geteventtypes();
$this->data['preacherslist'] = $this->event_model->getPreachers();
$this->gr_template->build('update_event', $this->data);
}

public function eventtypes() {
    if (_can("Event")) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('typename', 'Name', 'trim|required|is_unique[event_types.name]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->event_model->add_type(array('name' => $this->input->post('typename', TRUE), 'status' => 1))) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New Event type added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add event Type"));
                redirect(current_url());
            }
        }
    }
    $this->data['eventtypes'] = $this->event_model->geteventtypes();
    $this->gr_template->build('event_types', $this->data);
}

public function update_type() {
    if ($this->input->post()) {
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $this->form_validation->set_rules('name', "name", "trim|required");
        $this->form_validation->set_rules('id', "name", "trim|required|numeric");
        if ($this->form_validation->run() !== FALSE) {
            echo $this->event_model->update_event_type($id, array('name' => $name));
            exit();
        }
    }
    echo FALSE;
    exit();
}

function delete_type($type_id) {
    if ($this->event_model->delete_type($type_id)) {
        echo TRUE;
    } else {
        echo FALSE;
    }
    exit();
}

function promocode() {
    if ($this->input->post('event_idup')) {
        if (isset($_FILES['file']) && $_FILES['file']['error'] != 4) {
            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            if ($ext == 'xls' || $ext == "xlsx") {
                $this->load->library('excel');
                    //Here i used microsoft excel 2007
                $inputFileType = PHPExcel_IOFactory::identify($_FILES['file']['tmp_name']);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    //Set to read only
                $objReader->setReadDataOnly(true);
                    //Load excel file
                    $objPHPExcel = $objReader->load($_FILES['file']['tmp_name']); // error in this line
                    $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

                    //loop from first data untill last data
                    $i = 2;
                    $loop = true;
                    $arraydata = array();
                    if ($this->input->post("countryup") < 0) {
                        $ip = $this->input->ip_address();
                        $c_id = $this->promo_code_model->get_by_ip($ip);
                        if (!$c_id) {
                            $c_id = 98;
                        }
                    } else {
                        $c_id = $this->input->post("countryup");
                    }
                    $event_id = $this->input->post('event_idup');
                    $userid = $this->current_user->id;
                    while ($loop) {
                        $code = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
                        $desc = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
                        $value = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
                        $n = $objWorksheet->getCellByColumnAndRow(3, $i)->getFormattedValue();
                        $date = strtotime("1899-12-30 + $n days");
                        $dateTime = date(DATE_FORMAT, $date);
                        if ($code == '') {
                            $loop = false;
                            break;
                        }
                        if ($this->promo_code_model->checkuniquepromo($code, $event_id)) {
                            $array = array(
                                'promo_code' => $code,
                                'description' => $desc,
                                'value' => $value,
                                'type' => $c_id,
                                'expire_time' => $dateTime,
                                'status' => 1,
                                'timestamp' => date(DATE_FORMAT)
                                );

//                        debug($array);
                            $promo_id = $this->promo_code_model->insertpromocode($array);
                            $array1 = array(
                                'promo_id' => $promo_id,
                                'event_id' => $event_id,
                                'assigned_by' => $this->current_user->id
                                );
                            $this->promo_code_model->eventpromo($array1);
                        }
                        $i++;
                    }
                }
                $this->session->set_flashdata('message', array("class" => "success", "message" => "Subscribers added successfully"));
            }
            $this->session->set_flashdata('message', array("class" => "success", "message" => "Promo code added successfully"));
            redirect(current_url());
        }
        $events = $this->promo_code_model->getallEvents($this->current_user->id);
        $this->data['events'] = $events->result();
        if ($events->num_rows() > 0) {
            $this->data['event_id'] = $this->data['events'][0]->id;
        }
        $this->data['create_promo_form'] = FALSE;
        $filters = array('promo_key' => '', 'event_id' => '');
        if ($this->input->post('key') != '' || $this->input->post('eventid') != '') {
            $filters['promo_key'] = $this->input->post('key');
            $filters['event_id'] = $this->input->post('eventid');
            $this->session->set_userdata($filters);
        } else if ($this->input->post()) {
            $this->data['event_id'] = $this->input->post('event_id');
            $this->form_validation->set_rules('promo_code', 'Promo code ', 'trim|callback_compareMycode');
            $this->form_validation->set_rules('promo_value', 'Promo Value', 'trim|required');
            $this->form_validation->set_rules('country', 'Select Type', 'trim|required');
            $this->form_validation->set_rules('expdate', 'Expiry Date', 'trim|required');
            if (!$this->form_validation->run($this)) {
                $this->data['create_promo_form'] = TRUE;
            } else {
                $promo_code = $this->input->post('promo_code');
//                $generatecode = $this->input->post('generatecode');
                $event_id = $this->input->post('event_id');
//                if ($generatecode != NULL) {
//                    
//                }
                $promo_value = $this->input->post('promo_value');
                $country = $this->input->post('country');
                $expdate = date(DATE_FORMAT, strtotime($this->input->post('expdate')));
                $array = array(
                    'promo_code' => $promo_code,
                    'description' => $this->input->post('description'),
                    'value' => $promo_value,
                    'type' => $country,
                    'expire_time' => $expdate,
                    'status' => 1,
                    'timestamp' => date(DATE_FORMAT, time())
                    );
                $promo_id = $this->promo_code_model->insertpromocode($array);
                $array1 = array(
                    'promo_id' => $promo_id,
                    'event_id' => $event_id,
                    'assigned_by' => $this->current_user->id
                    );
                $this->promo_code_model->eventpromo($array1);
                $this->data['create_promo_form'] = FALSE;
            }
        } else {
            if (!$this->uri->segment(3)) {
                $session_items = array(
                    'promo_key' => '',
                    'event_id' => ''
                    );
                $this->session->unset_userdata($session_items);
            } else {
                $filters['promo_key'] = $this->session->userdata('promo_key');
                $filters['event_id'] = $this->session->userdata('promo_key');
            }
        }
        $total = $this->promo_code_model->get_promo_count($filters);

        //pagination settings
        $config['base_url'] = site_url('event/promocode');
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('promo_per_page') ? $this->session->userdata('promo_per_page') : 10;
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
        $filters['page'] = $this->data['page'];
        $filters['per_page'] = $config['per_page'];
        $this->data['perpages'] = array(10, 25, 50, 100);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['filters'] = $filters;

        $this->data['country'] = $this->event_model->loadcountry();
        $this->data['promocode'] = $this->promo_code_model->getEventsPromocode($this->current_user->id, 0, $filters);
        $this->gr_template->build('promo_code', $this->data);
    }

    function generateautocode($event_id = null) {
        if ($event_id != NULL) {
            $promo_code = $this->promo_code_model->getuniqueramdomcode($event_id);
            echo $promo_code;
        }
    }

    function change_promo_perpage($perpage = "") {
        if (is_numeric($perpage)) {
            $perpage = (int) $perpage;
        } else {
            $perpage = 10;
        }
        $this->session->set_userdata('promo_per_page', $perpage);
        exit();
    }

    function generateautocodecrowd() {
        $promo_code = $this->promo_code_model->getuniqueramdomcodecrowd();
        return $promo_code;
    }

    function compareMycode() {
        $promo_code = $this->input->post('promo_code');
//        $generatecode = $this->input->post('generatecode');
        if ($promo_code == '') {
            $this->form_validation->set_message('compareMycode', "Promo code required");
            return false;
        } else if ($promo_code != '') {
            $event_id = $this->input->post('event_id');
            if (!$this->promo_code_model->checkuniquepromo($promo_code, $event_id)) {
                $this->form_validation->set_message('compareMycode', "Unique Promo code required");
                return false;
            }
        }
    }

    public function promocrowd() {
        $this->data['create_promo_form'] = FALSE;
        if ($this->input->post()) {
            $this->data['event_id'] = $this->input->post('event_id');
            $this->form_validation->set_rules('promo_low', 'Range Low ', 'trim|required');
            $this->form_validation->set_rules('promo_high', 'Range High ', 'trim|required');
            $this->form_validation->set_rules('promo_value', 'Promo Value', 'trim|required');
            $this->form_validation->set_rules('expdate', 'Expiry Date', 'trim|required');
            if (!$this->form_validation->run($this)) {
                $this->data['create_promo_form'] = TRUE;
            } else {
                $promo_value = $this->input->post('promo_value', TRUE);
                $expdate = date(DATE_FORMAT, strtotime($this->input->post('expdate', TRUE)));
                $array = array(
                    'low' => $this->input->post('promo_low', TRUE),
                    'high' => $this->input->post('promo_high', TRUE),
                    'value' => $promo_value,
                    'expire_time' => $expdate
                    );
                $this->promo_code_model->insertpromorangecode($array);
                $promo_code = $this->generateautocodecrowd();
                $promoarray = array(
                    'promo_code' => $promo_code,
                    'description' => $array['low'] . '-' . $array['high'],
                    'value' => $promo_value,
                    'type' => 0,
                    'expire_time' => $expdate,
                    'status' => 1,
                    'flag' => 1,
                    'timestamp' => date(DATE_FORMAT, time())
                    );
                $promo_id = $this->promo_code_model->insertpromocode($promoarray);
                $this->data['create_promo_form'] = FALSE;
            }
        }
        $this->data['promocode'] = $this->promo_code_model->getEventsPromoRangecode($this->current_user->id);
        $this->gr_template->build('promo_crowd', $this->data);
    }

    function delete_promo($id) {
        $array = array('is_deleted' => 1);
        if ($this->promo_code_model->deletepromo($id, $array)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    function delete_promo_crowd($id = null) {
        if ($this->promo_code_model->deletepromo_crowd($id)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    public function loadchangeeventpromo() {
        $event_id = $this->input->post('event_id');
        $eventscode = $this->promo_code_model->getEventsPromocode($this->current_user->id, 0, $event_id);
        $this->load->view("changeeventpromo", array('eventscode' => $eventscode));
    }

    function importcrowdfunding() {

        //load library excel
        $this->load->library('excel');
        //Here i used microsoft excel 2007
        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        //Set to read only
        $objReader->setReadDataOnly(true);
        //Load excel file
        $objPHPExcel = $objReader->load($_FILES['file']['tmp_name']); // error in this line
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
//        $sheetindex = 0;
//        $sheetlooper = true;
        //loop from first data untill last data
//        while ($sheetlooper) {
//            try {
//                $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheetindex);
//            } catch (Exception $e) {
//                $sheetlooper = false;
//            }
////                print_r($sheetindex);
//            $sheetindex++;
        //loop from first data untill last data
        $i = 2;
        $loop = true;
        while ($loop) {
            $name = $objWorksheet->getCellByColumnAndRow(0, $i)->getValue();
            $email = $objWorksheet->getCellByColumnAndRow(1, $i)->getValue();
            $value = $objWorksheet->getCellByColumnAndRow(2, $i)->getValue();
            $insert = array(
                'name' => $name,
                'email' => $email,
                'value' => $value
                );
//            debug($insert);
            if ($email == '' || $value = '' || $name = "") {
                $loop = false;
                break;
            }
            $this->promo_code_model->insertCrowd($insert);
            $i++;
        }
        echo 'true';
    }

    public function uploadfiles() {
        if (empty($_FILES['file']['name'])) {

        } else if ($_FILES['file']['error'] == 0) {
            $filetype = NULL;
            //upload and update the file
            $config['upload_path'] = './uploads/images/eventslider/';
            $config['max_size'] = '102428800';
            $type = $_FILES['file']['type'];
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
            //$config['max_size']	= '100';// in KB
            if (!file_exists('./uploads/images/eventslider')) {
                if (!mkdir('./uploads/images/eventslider/', 0755, TRUE)) {
                    //echo 'false';
                }
            }
            $microtime = microtime(TRUE) * 10000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_my_upload('file', $microtime)) {

            } else {
                echo json_encode(array('type' => $filetype, 'path' => 'uploads/images/eventslider/' . $this->upload->file_name));
                /* Image Resizing code */
            }
        }
    }

    public function get_item_images($event_id) {
        $eventmages = $this->event_model->get_event_images($event_id);
        foreach ($eventmages as $file) { //get an array which has the names of all the files and loop through it 
            $obj['name'] = basename($file->image); //get the filename in array
            $obj['path'] = base_url($file->image);
            $obj['image_id'] = $file->id;
            $obj['size'] = filesize("./" . $file->image); //get the flesize in array
            $result[] = $obj; // copy it to another array
        }
        echo json_encode($result);
    }

    public function deletefiles() {
        echo $this->event_model->deleteeventgallery($this->input->post('path'));
    }

    public function preachers() {
        $this->data['preachers'] = array();
        if (_is("GR Admin")) {
            $this->data['preachers'] = $this->event_model->getPreachers();
        } else if (_is("RC Admin") || _is("Event Admin")) {
            $center_id = $this->session->userdata('current_centre_role')->center_id;
            $this->data['preachers'] = $this->event_model->getRCPreachers($center_id);
        }
        $this->gr_template->build('preachers_view', $this->data);
    }

    function delete_preachers($id) {
        echo $this->event_model->deletePreachers($id);
    }

    function preacher_add() {
        $this->data['typealert'] = "";
        $this->data['userpostedarray'] = array(
            'fname' => $this->input->post('fname'),
            'language' => ($this->input->post('language')) ? implode(',', $this->input->post('language')) : '',
            'status' => $this->input->post('preacher_status'),
            'areas_of_expertise' => ($this->input->post('expertise')) ? implode(',', $this->input->post('expertise')) : '',
            'address' => $this->input->post('address'),
            'description' => $this->input->post('description')
            );
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'Name', 'trim|required');
            $this->form_validation->set_rules('language', 'Language', 'required');
            $this->form_validation->set_rules('preacher_status', 'Preacher Status', 'trim|required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('expertise', 'Area of expertise', 'required');
            if ($this->form_validation->run() == true) {
//                if ($_FILES['avatar']['name'] == '') {
//                    $avatar = 'https://s.gravatar.com/avatar/' . md5($this->input->post('email')) . '?s=200';
//                } else if ($_FILES['avatar']['error'] == 0) {
//                    //upload and update the file
//                    $config['upload_path'] = './uploads/image/profile/';
//                    $config['allowed_types'] = 'gif|jpg|png';
//                    $config['overwrite'] = false;
//                    $config['remove_spaces'] = true;
//                    //$config['max_size']	= '100';// in KB
//                    if (!file_exists('./uploads/image/profile')) {
//                        if (!mkdir('./uploads/image/profile/', 0755, TRUE)) {
//                            //echo 'false';
//                        }
//                    }
//                    $this->load->library('upload', $config);
//
//                    if (!$this->upload->do_upload('avatar')) {
//                        $avatar = '';
//                    } else {
//                        //Image Resizing
//                        $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
//                        $config['maintain_ratio'] = FALSE;
//                        $config['width'] = 300;
//                        $config['height'] = 300;
//                        $this->load->library('image_lib', $config);
//
//                        if (!$this->image_lib->resize()) {
//                            $avatar = '';
//                        } else {
//                            $avatar = 'uploads/image/profile/' . $this->upload->file_name;
//                        }
//                    }
////                    $avatar = '';
//                }

                if ($_POST['uploadImage'] == '') {
                    $avatar = '';
                } else {

                    //upload and update the file
                    $config['upload_path'] = './uploads/image/homeslider/';

                    $avatar = '';
                    $image = $this->input->post('uploadImage');
                    if ($image != '') {
                        $imageContent = file_get_contents($image);
                        $file = $config['upload_path'] . uniqid() . '.png';
                        $success = file_put_contents($file, $imageContent);
                        $avatar = $success ? $file : '';
                    }

//                    $avatar = '';
                }


                $preacharray = array(
                    'name' => htmlspecialchars($this->input->post('fname')) . " " . htmlspecialchars($this->input->post('lname')),
                    'description' => htmlspecialchars($this->input->post('description')),
                    'address' => htmlspecialchars($this->input->post('address')),
                    'language' => ($this->input->post('language')) ? implode(',', $this->input->post('language')) : '',
                    'status' => htmlspecialchars($this->input->post('preacher_status')),
                    'areas_of_expertise' => ($this->input->post('expertise')) ? implode(',', $this->input->post('expertise')) : '',
                    'timestamp' => date(DATE_FORMAT),
                    'image' => $avatar
                    );
                $user_id = $this->event_model->addNewPreacher($preacharray);
                if (_is("RC Admin") || _is("Event Admin")) {
                    $center_id = $this->session->userdata('current_centre_role')->center_id;
                    $array = array(
                        'center_id' => $center_id,
                        'preacher_id' => $user_id
                        );
                    $this->event_model->insertRow($array, 'center_preachers');
                }

                $this->data['typealert'] = "success";
                $this->data['userpostedarray'] = array(
                    'fname' => '',
                    'description' => '',
                    'address' => '',
                    'language' => '',
                    'status' => '',
                    'area_of_expertise' => ''
                    );
                $this->data['message'] = '';
//                redirect(site_url('event/preachers'));
            } else {
                $this->data['message'] = '';
            }
        } else {
            $this->data['message'] = '';
        }
        $this->data['languages'] = $this->event_model->getAll('languages');
        $this->data['status'] = $this->event_model->getAll('preachers_status');
        $this->data['expertise'] = $this->event_model->getAll('area_of_expertise');
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('event'));
        $this->gr_template->build('preachers_add', $this->data);
    }

    function preacher_edit($id) {

        // debug($this->data['details']);
        $this->data['typealert'] = "";
        // debug($this->input->post('language'));
        $this->data['userpostedarray'] = array(
            'fname' => $this->input->post('fname'),
            'language' => ($this->input->post('language')) ? implode(',', $this->input->post('language')) : '',
            'status' => $this->input->post('preacher_status'),
            'areas_of_expertise' => ($this->input->post('expertise')) ? implode(',', $this->input->post('expertise')) : '',
            'address' => $this->input->post('address'),
            'description' => $this->input->post('description')
            );
        if ($this->input->post()) {
            $this->form_validation->set_rules('fname', 'Name', 'trim|required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('expertise', 'Area of expertise', 'required');
            $this->form_validation->set_rules('email', 'E mail', 'trim');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('phonenumber', 'Phone number', 'trim');
            $this->form_validation->set_rules('language', 'Language', 'required');
            $this->form_validation->set_rules('preacher_status', 'Preacher Status', 'trim|required');
            if ($this->form_validation->run() == true) {
//                if (!isset($_FILES['avatar']['name'])) {
//                    // $avatar = 'https://s.gravatar.com/avatar/' . md5($this->input->post('email')) . '?s=200';
//                    $avatar = $this->data['details']->image;
//                } else if ($_FILES['avatar']['error'] == 0) {
//                    //upload and update the file
//                    $config['upload_path'] = './uploads/image/profile/';
//                    $config['allowed_types'] = 'gif|jpg|png';
//                    $config['overwrite'] = false;
//                    $config['remove_spaces'] = true;
//                    //$config['max_size']   = '100';// in KB
//                    if (!file_exists('./uploads/image/profile')) {
//                        if (!mkdir('./uploads/image/profile/', 0755, TRUE)) {
//                            //echo 'false';
//                        }
//                    }
//                    $this->load->library('upload', $config);
//
//                    if (!$this->upload->do_upload('avatar')) {
//                        $avatar = '';
//                    } else {
//                        //Image Resizing
//                        $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
//                        $config['maintain_ratio'] = FALSE;
//                        $config['width'] = 300;
//                        $config['height'] = 300;
//                        $this->load->library('image_lib', $config);
//
//                        if (!$this->image_lib->resize()) {
//                            $avatar = '';
//                        } else {
//                            $avatar = 'uploads/image/profile/' . $this->upload->file_name;
//                        }
//                    }
////                    $avatar = '';
//                }


                if ($_POST['uploadImage'] == '') {
                    $avatar = '';
                } else {

                    //upload and update the file
                    $config['upload_path'] = './uploads/image/homeslider/';

                    $avatar = '';
                    $image = $this->input->post('uploadImage');
                    if ($image != '') {
                        $imageContent = file_get_contents($image);
                        $file = $config['upload_path'] . uniqid() . '.png';
                        $success = file_put_contents($file, $imageContent);
                        $avatar = $success ? $file : '';
                    }

//                    $avatar = '';
                }


                $preacharray = array(
                    'name' => htmlspecialchars($this->input->post('fname')) . " " . htmlspecialchars($this->input->post('lname')),
                    'description' => htmlspecialchars($this->input->post('description')),
                    'address' => htmlspecialchars($this->input->post('address')),
                    'language' => ($this->input->post('language')) ? implode(',', $this->input->post('language')) : '',
                    'status' => $this->input->post('preacher_status'),
                    'areas_of_expertise' => ($this->input->post('expertise')) ? implode(',', $this->input->post('expertise')) : '',
                    'timestamp' => date(DATE_FORMAT)
                    );
                if (isset($avatar) && $avatar != '') {
                    $preacharray['image'] = $avatar;
                }
                $user_id = $this->event_model->updatePreacher($preacharray, array('id' => $id));

                $this->data['typealert'] = "success";
                $this->data['userpostedarray'] = array(
                    'fname' => '',
                    'email' => '',
                    'lname' => '',
                    'address' => '',
                    'status' => '',
                    'language' => '',
                    'areas_of_expertise' => '',
                    'description' => '',
                    'username' => '',
                    'phonenumber' => ''
                    );
                $this->data['message'] = '';
//                redirect(site_url('event/preachers'));
            } else {
                $this->data['message'] = '';
            }
        } else {
            $this->data['message'] = '';
        }
        $this->data['details'] = $this->event_model->get_preacher_details($id);
        $this->data['languages'] = $this->event_model->getAll('languages');
        $this->data['status'] = $this->event_model->getAll('preachers_status');
        $this->data['expertise'] = $this->event_model->getAll('area_of_expertise');
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('event'));
        $this->gr_template->build('preacher_edit', $this->data);
    }

    function accomodation() {
        if (_can("Event")) {
            if ($this->input->post()) {
                $this->form_validation->set_rules('accomodation', 'Accomodation type', 'trim|required');
//                $this->form_validation->set_rules('rate','Rate' , 'required');
//                $this->form_validation->set_rules('currency', 'Currency', 'required');
                if ($this->form_validation->run() === TRUE) {
                    if ($this->event_model->add_accomodation(array('accomodation_type' => $this->input->post('accomodation', TRUE)))) {
                        $this->session->set_flashdata('message', array("class" => "success", "message" => "Accomodation added"));
                        redirect(current_url());
                    }
                } else {
                    $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add Accomodation"));
                    redirect(current_url());
                }
            }
        }
        $this->data['accomodations'] = $this->event_model->getAllAccomodation();
        $this->data['currencies'] = $this->event_model->getAll('countries');
        $this->gr_template->build('accomodation', $this->data);
    }

    function delete_accomodation($id) {
        echo $this->event_model->delete_accomodation($id);
    }

    public function update_accomodation() {
        $response = array();
        if ($this->input->post()) {
            $this->form_validation->set_rules('accomodation', 'Accomodation type', 'trim|required');
            $this->form_validation->set_rules('rate', 'Rate', 'required');
            $this->form_validation->set_rules('currency', 'Currency', 'required');
            if ($this->form_validation->run() === TRUE) {
                $id = $this->input->post('id', TRUE);
                $accomodation = $this->input->post('accomodation', TRUE);
                $rate = $this->input->post('rate', true);
                $currency = $this->input->post('currency', true);
                $this->event_model->update_accomodation(array('accomodation_type' => $accomodation, 'rate' => $rate, 'currency' => $currency), array('id' => $id));
                $response['code'] = 200;
                $response['message'] = $this->event_model->getOneWhere(array('id' => $id), 'accomodation');
                die(json_encode($response));
            }
        }
        $response['code'] = 500;
        $response['message'] = "Invalid request";
        echo json_encode($response);
        echo FALSE;
        exit();
    }

    public function testimonial() {
        $total = $this->centre_model->event_model->get_event_count(NULL, $this->current_user->id);
        //pagination settings
        $config['base_url'] = site_url('event/testimonial');
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('centre_per_page') ? $this->session->userdata('centre_per_page') : 10;
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
        $events = $this->event_model->getevents($this->current_user->id, $this->data['per_page'], $this->data['page'], NULL);
        foreach ($events as $value) {
            $value->count = $this->centre_model->get_review_count($value->id, 1);
        }
        $this->data['events'] = $events;
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('centre'));
        $this->gr_template->title('Testimonial')->build('testimonial', $this->data);
    }

    public function testimonial_view($id) {
        $total = $this->centre_model->get_review_count($id, 1);
        //pagination settings
        $config['base_url'] = site_url('event/testimonial_view/' . $id);
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('centre_per_page') ? $this->session->userdata('centre_per_page') : 10;
        $config["uri_segment"] = 4;
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
        $this->data['page'] = ($this->uri->segment(4)) ? $this->uri->segment(4) : 1;
        $this->data['centre'] = $this->centre_model->get_centre($id);
        $this->data['per_page'] = $config['per_page'];
        $this->data['perpages'] = array(10, 25, 50, 100);
        $this->data['event'] = $this->event_model->get_event($id);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['testimonial'] = $this->centre_model->get_testimonial($id, 1, $config["per_page"], $this->data['page']);
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('centre'));
        $this->gr_template->title('Testimonial')->build('testimonial_view', $this->data);
    }

    public function testimonial_verify($id = 0, $verify = 0) {
        if ((int) $verify === 1) {
            $data = array("status" => 1, "verified_at" => mdate('Y-m-d H:i:s', now()));
        } else {
            $data = array("verified" => 0);
        }
        if ($this->centre_model->update_review((int) $id, $data)) {
            echo TRUE;
            exit();
        }
        echo FALSE;
        exit();
    }

    //languages
    public function languages() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('language', 'Language', 'trim|required|is_unique[languages.id]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->event_model->insertRow(array('language' => $this->input->post('language')), 'languages', true)) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New Language added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add new Language"));
                redirect(current_url());
            }
        }
        $this->data['languages'] = $this->event_model->getAll('languages');
        $this->gr_template->build('languages', $this->data);
    }

    //language deletion
    function delete_language($id) {
        echo $this->event_model->deleteRow($id, 'id', 'languages');
    }

    //preacher status
    public function preachers_status() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('status', 'Status', 'trim|required|is_unique[preachers_status.id]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->event_model->insertRow(array('status' => $this->input->post('status')), 'preachers_status', true)) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New Preacher Status added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add new Preacher Status"));
                redirect(current_url());
            }
        }
        $this->data['status'] = $this->event_model->getAll('preachers_status');
        $this->gr_template->build('preachers_status', $this->data);
    }

    //language deletion
    function delete_status($id) {
        echo $this->event_model->deleteRow($id, 'id', 'preachers_status');
    }

    //preacher status
    public function area_of_expertise() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('area_of_expertise', 'area_of_expertise', 'trim|required|is_unique[area_of_expertise.id]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->event_model->insertRow(array('area_of_expertise' => $this->input->post('area_of_expertise')), 'area_of_expertise', true)) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New area of expertise added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add new area of expertise"));
                redirect(current_url());
            }
        }
        $this->data['area_of_expertise'] = $this->event_model->getAll('area_of_expertise');
        $this->gr_template->build('area_of_expertise', $this->data);
    }

    //language deletion
    function delete_area_of_expertise($id) {
        echo $this->event_model->deleteRow($id, 'id', 'area_of_expertise');
    }

    public function add_existing_preacher() {
        $this->data['preachers'] = array();
        $center_id = $this->session->userdata('current_centre_role')->center_id;
        $this->data['preachers'] = $this->event_model->getExistingPreachers($center_id);
        $this->gr_template->build('existing_preachers', $this->data);
    }

    function add_preacher_to_center($id){
        $center_id = $this->session->userdata('current_centre_role')->center_id;
        $array=array(
            'center_id'=>$center_id,
            'preacher_id'=>$id,
            'status'=>0
            );
        if($this->event_model->insertRow($array,'center_preachers')){
            echo "1";
        }else{
            echo "Failed";
        }
    }

    function approve_existing_preachers(){
        $this->data['approve'] = $this->event_model->approve_preacher();
        $this->gr_template->build('approve_preachers', $this->data);
    }
    function verify_existing_preacher($id){
        $array=array(
            'status'=>1
            );
        if($this->event_model->updateWhere(array('id'=>$id),$array,'center_preachers')){
            echo "1";
        }else{
            echo "Failed";
        }
    }

}

?>
