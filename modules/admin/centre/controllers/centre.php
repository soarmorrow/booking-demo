<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Centre extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model(array('centre_model', 'rc_type_model', 'rc_category_model'));
        $this->breadcrumb->append_crumb(lang('centre'), site_url('centre'));
        $this->load->library('pagination');
        if (!_can("Center")) {
            redirect(site_url("dashboard"));
        }
    }

    function index($offset = 0) {
        $filters = array();
        if (!$this->uri->segment(2)) {
            $session_items = array(
                'centre_search_name' => '',
                'centre_search_email' => '',
                'centre_search_reg_no' => '',
                'centre_search_address' => '',
                'centre_search_rc_type' => '',
                'centre_search_rc_cat' => '',
                'centre_search_status' => ''
                );
            $this->session->unset_userdata($session_items);
        }
        //if search form is submitted save filters in session
        if ($this->input->post()) {
            if ($this->input->post('name')) {
                $this->session->set_userdata('centre_search_name', $this->input->post('name', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_name');
            }
            if ($this->input->post('email')) {
                $this->session->set_userdata('centre_search_email', $this->input->post('email', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_email');
            }
            if ($this->input->post('reg_no')) {
                $this->session->set_userdata('centre_search_reg_no', $this->input->post('reg_no', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_reg_no');
            }
            if ($this->input->post('address')) {
                $this->session->set_userdata('centre_search_address', $this->input->post('address', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_address');
            }
            if ($this->input->post('rc_type')) {
                $this->session->set_userdata('centre_search_rc_type', $this->input->post('rc_type', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_rc_type');
            }
            if ($this->input->post('rc_cat')) {
                $this->session->set_userdata('centre_search_rc_cat', $this->input->post('rc_cat', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_rc_cat');
            }
            if ($this->input->post('status') != NULL) {
                $this->session->set_userdata('centre_search_status', $this->input->post('status', TRUE));
            } else {
                $this->session->unset_userdata('centre_search_status');
            }
        }

//set filters 
        if ($this->session->userdata('centre_search_name')) {
            $filters['name'] = $this->session->userdata('centre_search_name');
        }
        if ($this->session->userdata('centre_search_email')) {
            $filters['email'] = $this->session->userdata('centre_search_email');
        }
        if ($this->session->userdata('centre_search_reg_no')) {
            $filters['reg_no'] = $this->session->userdata('centre_search_reg_no');
        }
        if ($this->session->userdata('centre_search_address')) {
            $filters['address'] = $this->session->userdata('centre_search_address');
        }
        if ($this->session->userdata('centre_search_rc_type')) {
            $filters['rc_type'] = $this->session->userdata('centre_search_rc_type');
        }
        if ($this->session->userdata('centre_search_rc_cat')) {
            $filters['rc_cat'] = $this->session->userdata('centre_search_rc_cat');
        }
        if ($this->session->userdata('centre_search_status') != NULL) {
            $filters['status'] = $this->session->userdata('centre_search_status');
        }
        $this->data['rctypes'] = $this->rc_type_model->get_types();
        $this->data['rccats'] = $this->rc_category_model->get_categories();
        $total = $this->centre_model->get_centre_count($filters);
        //pagination settings
        $config['base_url'] = site_url('centre/index');
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
        $this->data['filters'] = $filters;
        $this->data['centers'] = $this->centre_model->getCentreList(NULL, $filters, $config["per_page"], $this->data['page']);
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('centre'));
        $this->gr_template->title('Goretreat Centers')->build('centre', $this->data);
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

    function add() {
        $this->data['preacherarray'] = array();
        $this->data['typealert'] = "";
        $this->data['message'] = "";
        $this->data['rctypes'] = $this->rc_type_model->get_types();
        $this->data['rccats'] = $this->rc_category_model->get_categories();
        $this->data['preacherslist'] = $this->centre_model->getPreachers();
        if ($this->input->post()) {
            $this->data['preacherarray'] = $this->input->post('preachers', TRUE);
            if ($this->_validate_centre()) {
                if (empty($_FILES['logo']['name'])) {
                    $logo = '';
                } else if ($_FILES['logo']['error'] == 0) {
                    //upload and update the file
                    $config['upload_path'] = './uploads/image/center_logo/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['overwrite'] = false;
                    $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB
                    if (!file_exists('./uploads/image/center_logo')) {
                        if (!mkdir('./uploads/image/center_logo/', 0755, TRUE)) {
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
                            $logo = 'uploads/images/eventslider/14520608113861.png';
                        } else {
                            $logo = 'uploads/image/center_logo/' . $this->upload->file_name;
                        }
                    }
                }
                $center = array('name' => $this->input->post('cname', TRUE),
                    'country' => $this->input->post('country', TRUE),
                    'state' => $this->input->post('state', TRUE),
                    'city' => $this->input->post('city', TRUE),
                    'street_address1' => $this->input->post('street_address1', TRUE),
                    'street_address2' => $this->input->post('street_address2', TRUE),
                    'zipcode' => $this->input->post('zipcode', TRUE),
                    'contact' => $this->input->post('phonenumber', TRUE),
                    'email' => $this->input->post('email', TRUE),
                    'logo' => $logo,
                    'reg_num' => $this->input->post('reg_no', TRUE),
                    'description' => $this->input->post('description', TRUE),
                    'key_preacher' => $this->input->post('key_person', TRUE),
                    'website' => $this->input->post('website', TRUE),
                    'established' => $this->input->post('established', TRUE),
                    'facility' => $this->input->post('facility', TRUE),
                    'status' => 1,
                    'verified' => 0,
                    'logitude' => $this->input->post('longitude', TRUE),
                    'lattitude' => $this->input->post('latitude', TRUE),
                    'rc_type_id' => $this->input->post('rctype', TRUE),
                    'rc_category_id' => $this->input->post('rc_cat', TRUE)
                    );
$centerimages = $this->input->post('centerimages');
if ($this->centre_model->add_center($center, $centerimages, $this->data['preacherarray'])) {
    $this->session->set_flashdata('message', 'New centre added');
    $this->data['typealert'] = "success";
    $this->data['message'] = "New centre added";
    redirect(current_url());
} else {
    $this->data['typealert'] = "error";
    $this->data['message'] = "Failed to add new centre";
}
}
}
$this->gr_template->title('Goretreat Centers')->build('new_centre', $this->data);
}

private function _validate_centre($check_name = TRUE, $check_email = TRUE) {
    if ($check_name) {
        $this->form_validation->set_rules('cname', 'Name', "trim|required|is_unique[" . IMS_DB_PREFIX . "center.name]");
    } else {
        $this->form_validation->set_rules('cname', 'Name', "trim|required");
    }
    if ($check_email) {
        $this->form_validation->set_rules('email', 'email', "trim|valid_email|is_unique[" . IMS_DB_PREFIX . "center.email]");
    } else {
        $this->form_validation->set_rules('email', 'email', "trim|valid_email");
    }
    $this->form_validation->set_rules('street_address1', 'Address line 1', 'trim|required');
    $this->form_validation->set_rules('street_address2', 'Address line 2', 'trim');
    $this->form_validation->set_rules('city', 'City', 'trim');
    $this->form_validation->set_rules('state', 'State', 'trim|required');
    $this->form_validation->set_rules('country', 'Country ', 'trim|required');
    $this->form_validation->set_rules('facility', 'Facilities ', 'trim|required');
    $this->form_validation->set_rules('zipcode', 'Zipcode', 'trim|required|numeric');
    $this->form_validation->set_rules('key_person', 'Key Contact Person', 'trim');
    $this->form_validation->set_rules('established', 'Established year', 'trim');
    $this->form_validation->set_rules('website', 'Website', 'trim');
    $this->form_validation->set_rules('latitude', 'Location in map', 'trim|required');
    $this->form_validation->set_rules('longitude', 'Location in map', 'trim|required');
    $this->form_validation->set_rules('phonenumber', 'Contact number ', 'trim');
    $this->form_validation->set_rules('reg_no', ' ', 'trim');
    $this->form_validation->set_rules('rctype', 'Center type', 'required');
    $this->form_validation->set_rules('rc_cat', 'Center category', 'required');
    $this->form_validation->set_rules('description', ' ', 'trim');
    return $this->form_validation->run($this) == TRUE;
}

function update($id) {
    $this->data['typealert'] = "";
    $this->data['message'] = "";
    $this->data['centre_id'] = $centre_id = $id;
    $this->data['rctypes'] = $this->rc_type_model->get_types();
    $this->data['rccats'] = $this->rc_category_model->get_categories();
    $this->data['centre'] = $centre = $this->centre_model->get_centre($centre_id);
    $this->data['preacherarray'] = $this->centre_model->get_centre_preachers($centre_id);
    if ($this->input->post()) {
        $check_name = TRUE;
        $check_email = TRUE;
        if (strtolower($centre->name) === strtolower($this->input->post('cname', TRUE))) {
            $check_name = FALSE;
        }
        if (strtolower($centre->email) === strtolower($this->input->post('email', TRUE))) {
            $check_email = FALSE;
        }
        if ($this->_validate_centre($check_name, $check_email)) {
            $this->data['preacherarray'] = $this->input->post('preachers', TRUE);
            if (empty($_FILES['logo']['name'])) {
                $logo = base_url('uploads/image/center_logo/gdfg.png');
            } else if ($_FILES['logo']['error'] == 0) {
                    //upload and update the file
                $config['upload_path'] = './uploads/image/center_logo/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['overwrite'] = false;
                $config['remove_spaces'] = true;
                    //$config['max_size']	= '100';// in KB

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('logo')) {
                    $logo = 'uploads/image/center_logo/gdfg.png';
                } else {
                        //Image Resizing
                    $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                    $config['maintain_ratio'] = FALSE;
                    $config['width'] = 300;
                    $config['height'] = 300;

                    $this->load->library('image_lib', $config);

                    if (!$this->image_lib->resize()) {
                        $logo = 'uploads/image/center_logo/gdfg.png';
                    } else {
                        $logo ='uploads/image/center_logo/' . $this->upload->file_name;
                    }
                }
            }
            $center = array('name' => $this->input->post('cname', TRUE),
                'country' => $this->input->post('country', TRUE),
                'state' => $this->input->post('state', TRUE),
                'city' => $this->input->post('city', TRUE),
                'street_address1' => $this->input->post('street_address1', TRUE),
                'street_address2' => $this->input->post('street_address2', TRUE),
                'zipcode' => $this->input->post('zipcode', TRUE),
                'contact' => $this->input->post('phonenumber', TRUE),
                'email' => $this->input->post('email', TRUE),
                'logo' => $logo,
                'reg_num' => $this->input->post('reg_no', TRUE),
                'description' => $this->input->post('description', TRUE),
                'facility' => $this->input->post('facility', TRUE),
                'status' => 1,
                'verified' => 0,
                'logitude' => $this->input->post('longitude', TRUE),
                'lattitude' => $this->input->post('latitude', TRUE),
                'rc_type_id' => $this->input->post('rctype', TRUE),
                'rc_category_id' => $this->input->post('rc_cat', TRUE)
                );
$centerimages = $this->input->post('centerimages');
if ($this->centre_model->update_centre($centre_id, $center, $centerimages, $this->data['preacherarray'])) {
    $this->session->set_flashdata('message', 'Centre details updated');
    $this->data['typealert'] = "success";
    $this->data['message'] = "Centre details updated";
    redirect(current_url());
} else {
    $this->data['typealert'] = "error";
    $this->data['message'] = "Failed to update centre";
}
}
}

$this->data['preacherslist'] = $this->centre_model->getPreachers();
$this->gr_template->title('Goretreat Centers')->build('update_centre', $this->data);
}

function update_category() {
    if ($this->input->post()) {
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $this->form_validation->set_rules('name', "name", "trim|required");
        $this->form_validation->set_rules('id', "name", "trim|required|numeric");
        if ($this->form_validation->run() !== FALSE) {
            echo $this->rc_category_model->update_category($id, array('rc_category' => $name));
            exit();
        }
    }
    echo FALSE;
    exit();
}

function update_type() {
    if ($this->input->post()) {
        $id = $this->input->post('id', TRUE);
        $name = $this->input->post('name', TRUE);
        $this->form_validation->set_rules('name', "name", "trim|required");
        $this->form_validation->set_rules('id', "name", "trim|required|numeric");
        if ($this->form_validation->run() !== FALSE) {
            echo $this->rc_type_model->update_type($id, array('name' => $name));
            exit();
        }
    }
    echo FALSE;
    exit();
}

function view($id) {
    $this->data['views'] =  $this->centre_model->get_centre_view_count($id,2);
    $this->data['centre_id'] = $centre_id = $id;
    $this->data['centre'] = $this->centre_model->get_centre($centre_id);
    $this->data['images'] = $this->centre_model->get_centre_images($centre_id);
    $this->gr_template->title('Goretreat View Centre')->build('view_centre', $this->data);
}

public function get_item_images($centre_id) {
    $blogimages = $this->centre_model->get_centre_images($centre_id);
        foreach ($blogimages as $file) { //get an array which has the names of all the files and loop through it 
            $obj['name'] = basename($file->path); //get the filename in array
            $obj['path'] = base_url($file->path);
            $obj['image_id'] = $file->id;
            $obj['size'] = filesize("./" . $file->path); //get the flesize in array
            $result[] = $obj; // copy it to another array
        }
//        header('Content-Type: application/json');
        echo json_encode($result);
    }

    function rctypes() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('typename', 'Name', 'trim|required|is_unique[rc_type.name]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->rc_type_model->add_type(array('name' => $this->input->post('typename', TRUE), 'status' => 1, 'parent_id' => 1, 'order' => 1))) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New centre type added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add centre Type"));
                redirect(current_url());
            }
        }
        $this->data['rctypes'] = $this->rc_type_model->get_types();
        $this->gr_template->title('Goretreat View Types')->build('view_types', $this->data);
    }

    function view_type($id) {
        $this->data['type_id'] = $type_id = $id;
        $this->data['centre_type'] = $this->rc_type_model->get_type($type_id);
        $this->gr_template->title('Goretreat View Type')->build('view_type', $this->data);
    }

    function categories() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('catname', 'Name', 'trim|required|is_unique[rc_category.rc_category]');
            if ($this->form_validation->run() === TRUE) {
                if ($this->rc_category_model->add_category(array('rc_category' => $this->input->post('catname', TRUE), 'order' => 1, 'parent_id' => 1, 'status' => 1))) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New category added"));
                    redirect(current_url());
                }
            } else {
                $this->session->set_flashdata('message', array("class" => "error", "message" => "Failed to add centre Category"));
                redirect(current_url());
            }
        }
        $this->data['rccats'] = $this->rc_category_model->get_categories();
        $this->gr_template->title('Goretreat View Categories')->build('view_categories', $this->data);
    }

    function view_category($id) {
        $this->data['cat_id'] = $cat_id = $id;
        $this->data['centre_cat'] = $this->rc_category_model->get_category($cat_id);
        $this->gr_template->title('Goretreat View Type')->build('view_category', $this->data);
    }

    function delete_centre($centre_id) {
        $time = mdate("%y-%m-%d %H:%i:%s", now());
        $values = array("is_deleted" => 1, "deleted_on" => $time);
        if ($this->centre_model->update_centre($centre_id, $values)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    function delete_type($type_id) {
        if ($this->rc_type_model->delete_type($type_id)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    function delete_category($category_id) {
        if ($this->rc_category_model->delete_category($category_id)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    public function verify($id = 0, $verify = 0) {
        if ((int) $verify === 1) {
            $data = array("verified" => 1, "verified_at" => mdate('Y-m-d H:i:s', now()));
        } else {
            $data = array("verified" => 0);
        }
        if ($this->centre_model->update_centre((int) $id, $data)) {
            echo TRUE;
            exit();
        }
        echo FALSE;
        exit();
    }

    public function popularity_verify($id = 0, $verify = 0) {
        if ((int) $verify === 1) {
            $data = array("popularity" => 1, "upgraded_at" => mdate('Y-m-d H:i:s', now()));
        } else {
            $data = array("popularity" => 0);
        }
        if ($this->centre_model->update_centre((int) $id, $data)) {
            echo TRUE;
            exit();
        }
        echo FALSE;
        exit();
    }

    public function uploadfiles() {
        if (empty($_FILES['file']['name'])) {

        } else if ($_FILES['file']['error'] == 0) {
            $filetype = NULL;
            //upload and update the file
            $config['upload_path'] = './uploads/images/centreslider/';
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
            if (!file_exists('./uploads/images/centreslider')) {
                if (!mkdir('./uploads/images/centreslider/', 0755, TRUE)) {
                    //echo 'false';
                }
            }
            $microtime = microtime(TRUE) * 10000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_my_upload('file', $microtime)) {

            } else {
                echo json_encode(array('type' => $filetype, 'path' => 'uploads/images/centreslider/' . $this->upload->file_name));
                /* Image Resizing code */
            }
        }
    }

    public function deletefiles() {
        echo $this->centre_model->deletecentersliders($this->input->post('path'));
    }

    public function testimonial(){

        $this->data['rctypes'] = $this->rc_type_model->get_types();
        $this->data['rccats'] = $this->rc_category_model->get_categories();
        $total = $this->centre_model->get_centre_count(NULL);
        //pagination settings
        $config['base_url'] = site_url('centre/testimonial');
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
        $centers = $this->centre_model->getCentreList(NULL, NULL, $config["per_page"], $this->data['page']);
        foreach ($centers as $value) {
            $value->count = $this->centre_model->get_review_count($value->id,2);
        }
        $this->data['centers'] = $centers;
        $this->breadcrumb->append_crumb(lang('GoretreatUser'), site_url('centre'));
        $this->gr_template->title('Testimonial')->build('testimonial', $this->data);

    }

    public function testimonial_view($id){
        $total = $this->centre_model->get_review_count($id,2);
        //pagination settings
        $config['base_url'] = site_url('centre/testimonial_view/'.$id);
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
        $this->data['pagination'] = $this->pagination->create_links();
        $this->data['testimonial'] = $this->centre_model->get_testimonial($id,2,$config["per_page"], $this->data['page']);
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

}
