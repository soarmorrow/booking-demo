<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog
 *
 * @author Lachu
 */
class blog extends Admin_Controller {

    //put your code here
    function __construct() {
        parent::__construct();
        $this->load->model('blog_model');
        $this->load->library('pagination');
        if (!_can("Blog")) {
            redirect(site_url("dashboard"));
        }
    }

    public function index() {
        if ($this->input->post()) {
            $content = htmlspecialchars($this->input->post("content"), ENT_QUOTES);
            $total = $this->blog_model->loadblogs($this->current_user->id, 0, 0, TRUE, $content);
            $this->session->set_userdata("content", $content);
        } else {
            if (!$this->uri->segment(2)) {
                $session_items = array(
                    'content' => ''
                );
                $this->session->unset_userdata($session_items);
                $total = $this->blog_model->loadblogs($this->current_user->id, 0, 0, TRUE);
            } else {
                $content = $this->session->userdata('content');
                $total = $this->blog_model->loadblogs($this->current_user->id, 0, 0, TRUE, $content);
            }
        }
        $config['base_url'] = site_url('blog/index');
        $config['total_rows'] = $total;
        $config['per_page'] = $this->session->userdata('blog_per_page') ? $this->session->userdata('blog_per_page') : 10;
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


        if (isset($content)) {
            $this->data['content'] = $content;
            $this->data['blogs'] = $this->blog_model->loadblogs($this->current_user->id, $config["per_page"], $this->data['page'], FALSE, $content);
        } else {
            $this->data['content'] = NULL;
            $this->data['blogs'] = $this->blog_model->loadblogs($this->current_user->id, $config["per_page"], $this->data['page'], FALSE);
        }
        $this->data['per_page'] = $config['per_page'];
        $this->data['perpages'] = array(10, 25, 50, 100);
        $this->data['pagination'] = $this->pagination->create_links();
        $this->gr_template->build('blog_admin', $this->data);
    }

    public function delete_blog($blog_id) {
        echo $this->blog_model->deleteblog($blog_id);
    }

    public function view($blog_id) {
        $this->data['blog'] = $this->blog_model->loadsingleblog($this->current_user->id, $blog_id);
        $this->data['images'] = $this->blog_model->loadblogimages($blog_id);
        $this->gr_template->build('blog_view', $this->data);
    }

    public function get_item_images($blog_id) {
        $blogimages = $this->blog_model->loadblogimages($blog_id);
        foreach ($blogimages as $file) { //get an array which has the names of all the files and loop through it 
            $obj['name'] = basename($file->path); //get the filename in array
            $obj['path'] = base_url($file->path);
            $obj['blog_id'] = $file->id;
            $obj['attachment_type'] = $file->attachment_type;
            $obj['size'] = filesize("./" . $file->path); //get the flesize in array
            $result[] = $obj; // copy it to another array
        }
//        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function update($blog_id) {
        if ($this->input->post()) {
            $this->data['userpostedarray'] = array(
                'title' => $this->input->post('title'),
                'author' => $this->input->post('author'),
                'content' => $this->input->post('content'),
                'images' => $this->input->post('blogimages'),
                'videos' => $this->input->post('blogvideos')
            );
            $this->form_validation->set_rules('title', 'Title', 'required');
            $this->form_validation->set_rules('author', 'Author', 'required');
            $this->form_validation->set_rules('content', 'Content', 'required');
            if ($this->form_validation->run() == true) {
                if ($this->blog_model->update_current_blog($blog_id, $this->data['userpostedarray'], $this->current_user->id)) {
                    $this->data['message'] = "Updated Successfully";
                }
            } else {
                $this->data['message'] = 'Failed to Update';
            }
        }

        $this->data['blog'] = $this->blog_model->loadsingleblog($this->current_user->id, $blog_id);
        $this->gr_template->build('blog_update', $this->data);
    }

    public function togglepublish($blog_id, $is) {
        echo $this->blog_model->editstatus($blog_id, $is);
    }

    public function uploadfiles() {
        if (empty($_FILES['file']['name'])) {
            
        } else if ($_FILES['file']['error'] == 0) {
            $filetype = NULL;
            //upload and update the file
            $config['upload_path'] = './uploads/files/blog/';
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
                case 'video/avi':
                case 'video/flv':
                case 'video/wmv':
                case 'video/mp4':
                case 'video/3gp': {
                        $filetype = 1;
                        $config['allowed_types'] = '3gp|mp4|flv|wmv|avi';
                        break;
                    }
            }
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
            //$config['max_size']	= '100';// in KB
            if (!file_exists('./uploads/files/blog')) {
                if (!mkdir('./uploads/files/blog/', 0755, TRUE)) {
                    //echo 'false';
                }
            }
            $microtime = microtime(TRUE) * 10000;
            $this->load->library('upload', $config);

            if (!$this->upload->do_my_upload('file', $microtime)) {
                
            } else {
                echo json_encode(array('type' => $filetype, 'path' => 'uploads/files/blog/' . $this->upload->file_name));
                /* Image Resizing code */

//                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
//                $config['maintain_ratio'] = FALSE;
//                $config['width'] = 200;
//                $config['height'] = 200;
//
//                $this->load->library('image_lib', $config);
//
//                if (!$this->image_lib->resize()) {
//                    debug($this->image_lib->display_errors('', ''));
//                    $avatar = '';
//                } else {
//                    $avatar = base_url('uploads/image/profile/' . $this->upload->file_name);
//                }
            }
        }
    }

    public function deletefiles($id=NULL) {
        echo $this->blog_model->deleteblogfiles($this->input->post('path'),$id);
    }

    public function addnew() {
        $this->data['userpostedarray'] = array(
            'title' => $this->input->post('title'),
            'author' => $this->input->post('author'),
            'content' => $this->input->post('content'),
            'images' => $this->input->post('blogimages'),
            'videos' => $this->input->post('blogvideos')
        ); 
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Title', 'trim|required');
            $this->form_validation->set_rules('author', 'Author', 'trim|required');
            $this->form_validation->set_rules('content', 'Content', 'trim|required');
            if ($this->form_validation->run() == true) {
                $add = $this->blog_model->add_to_blog($this->data['userpostedarray'], $this->current_user->id);
                if ($add) {
                    $this->data['message'] = "New blog added Successfully";
                }
                $this->data['userpostedarray'] = array(
                    'title' => NULL,
                    'author' => NULL,
                    'content' => NULL,
                    'images' => NULL,
                    'videos' => NULL
                );
            } else {
                $this->data['message'] = '';
            }
        }
        $this->gr_template->build('blog_add', $this->data);
    }

    public function change_perpage($perpage = "") {
        if (is_numeric($perpage)) {
            $perpage = (int) $perpage;
        } else {
            $perpage = 10;
        }
        $this->session->set_userdata('blog_per_page', $perpage);
        exit();
    }

}

?>
