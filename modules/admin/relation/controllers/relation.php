<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relation
 *
 * @author soarmorrow
 */
class relation extends Admin_Controller {

    //put your code here

    function __construct() {
        parent::__construct();
        $this->load->model('relation_model');
        if (!_can("Relation")) {
            redirect(site_url("dashboard"));
        }
    }

    function index() {
        $this->data['modules'] = $this->relation_model->loadAllModules();
//        debug($this->data['modules']);
        $roles = $this->relation_model->loadAllRoles();
        $arrayrole = array();
        foreach ($roles as $row) {

            $allowedmodules = $this->relation_model->loadAllowedModules($row->id);
//            debug($allowedmodules);
            $assignedModules = $this->relation_model->loadassignedModules($row->id);
            $role = array('role_name' => $row->name, 'id' => $row->id, 'allowedmodules' => $allowedmodules, 'assignedModules' => $assignedModules);
            array_push($arrayrole, $role);
        }
        $this->data['roles'] = $arrayrole;
        $this->gr_template->build('relation', $this->data);
    }

    function usermodule() {
        $roles = $this->relation_model->loadAllRoles();
        if (_is("GR Admin")) {
            $this->data['centers'] = $this->relation_model->loadAllCenters();
            $this->data['center_id'] = $this->data['centers'][0]->id;
        } else {
            $currentcenter_role=$this->session->userdata('current_centre_role');
            $this->data['center_id'] = $currentcenter_role->center_id;
            $this->data['users'] = $this->relation_model->loadAllUsers($this->current_user->id, $this->data['center_id']);
        }
        $this->data['alertify_error'] = "";
        $this->data['alertify_success'] = "";
        $this->data['allusers'] = $this->relation_model->loadtotalUsers($this->current_user->id, $this->data['center_id']);
        if ($this->input->post('center_id')) {
            if ($this->input->post('userid')) {
                if ($this->input->post('role_id')) {
                    $role_id = $this->input->post('role_id');
                    $this->data['alertify_success'] = "Role Added";
                } else {
                    $role_id = NULL;
                    $this->data['alertify_success'] = "User Added";
                }
                if ($this->relation_model->adduserToRole($this->input->post('userid'), $role_id, $this->input->post('center_id'))) {
                    
                } else {
                    $this->data['alertify_success'] = '';
                    $this->data['alertify_error'] = "Failed to add";
                }
            } else {
                $this->data['center_id'] = $this->input->post('center_id');
                $this->data['allusers'] = $this->relation_model->loadtotalUsers($this->current_user->id, $this->data['center_id']);
                $this->data['users'] = $this->relation_model->loadAllUsers($this->current_user->id, $this->input->post('center_id'));
                $this->data['alertify_error'] = "Select User and Role to add";
            }
            $this->data['center_id'] = $this->input->post('center_id');
            $this->data['allusers'] = $this->relation_model->loadtotalUsers($this->current_user->id, $this->data['center_id']);
            $this->data['users'] = $this->relation_model->loadAllUsers($this->current_user->id, $this->input->post('center_id'));
        } else {
            $this->data['users'] = $this->relation_model->loadAllUsers($this->current_user->id, $this->data['center_id']);
        }
//        debug($this->data['users']);
        $arrayrole = array();
        foreach ($roles as $row) {
            $aasignedusers = $this->relation_model->loadassignedUsers($row->id, $this->data['center_id']);
            $role = array('role_name' => $row->name, 'id' => $row->id, 'assignedusers' => $aasignedusers);
            array_push($arrayrole, $role);
        }
        $this->data['my_id'] = $this->current_user->id;
        $this->data['roles'] = $arrayrole;
        $this->gr_template->build('user_role', $this->data);
    }

    function checkrolemodule() {
        if ($this->input->post()) {
            $status = $this->relation_model->addRoleModule($this->input->post('role_id'), $this->input->post('module_id'));
            echo $status;
        } else {
            echo FALSE;
        }
    }

    function uncheckrolemodule() {
        if ($this->input->post()) {
            $status = $this->relation_model->removeRoleModule($this->input->post('role_id'), $this->input->post('module_id'));
            echo $status;
        } else {
            echo FALSE;
        }
    }

    function checkuserrole() {
        if ($this->input->post()) {
            $status = $this->relation_model->addUserRole($this->input->post('role_id'), $this->input->post('user_id'), $this->input->post('center_id'));
            echo $status;
        } else {
            echo 'Failed to add user role';
        }
    }

    function uncheckuserrole() {
        if ($this->input->post()) {
            $status = $this->relation_model->removeUserRole($this->input->post('role_id'), $this->input->post('user_id'), $this->input->post('center_id'));
            echo $status;
        } else {
            echo 'Failed to add user role';
        }
    }

    function loadchangecenter() {
        if ($this->input->post()) {
            if ($this->input->post('center_id')) {
                $usersticked = $this->relation_model->loadAllUsersresultarray($this->current_user->id, $this->input->post('center_id'));
                $users = $this->relation_model->loadAllUsersarray($this->current_user->id, $this->input->post('center_id'));
            }
            $center_id = $this->input->post('center_id');
            $roles = $this->relation_model->loadAllRoles();
            $arrayrole = array();
            foreach ($roles as $row) {
                $aasignedusers = $this->relation_model->loadassignedUsers($row->id, $center_id);
                $role = array('role_name' => $row->name, 'id' => $row->id, 'assignedusers' => $aasignedusers);
                array_push($arrayrole, $role);
            }
            echo json_encode(array('users' => $users, 'ticked' => $usersticked, 'roles' => $arrayrole));
        }
    }

    function loadchangeadduser() {

        if ($this->input->post()) {
            if ($this->input->post('center_id')) {
                $users = $this->relation_model->loadAllUsersarray($this->current_user->id, $this->input->post('center_id'));
            }
            echo json_encode(array('users' => $users));
        }
    }

    function addrole() {
//        if (_can("Relation")) {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            if ($this->form_validation->run() === TRUE) {
                if ($this->relation_model->add_role(array('name' => $this->input->post('name', TRUE), 'status' => 1, 'locked' => 1, 'order' => 10, "parent_id" => 1))) {
                    $this->session->set_flashdata('message', array("class" => "success", "message" => "New role added"));
                    redirect(current_url());
                }
            }
        }
//        }
        $this->data['roles'] = $this->relation_model->get_all_roles();
        $this->gr_template->build('roles', $this->data);
    }

    function delete_role($id) {
        if ($this->relation_model->delete_role($id)) {
            echo TRUE;
        } else {
            echo FALSE;
        }
        exit();
    }

    function update_role() {
        if ($this->input->post()) {
            $id = $this->input->post('id', TRUE);
            $name = $this->input->post('name', TRUE);
            $this->form_validation->set_rules('name', "name", "trim|required");
            $this->form_validation->set_rules('id', "name", "trim|required|numeric");
            if ($this->form_validation->run() !== FALSE) {
                echo $this->relation_model->update_role($id, array('name' => $name));
                exit();
            }
        }
        echo FALSE;
        exit();
    }

}
