<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of relation_model
 *
 * @author soarmorrow
 */
class relation_model extends MY_Model {

    //put your code here 

    public function __construct() {
        parent::__construct();
    }

    public function loadAllModules() {
        return $this->db->select('*')
                        ->get('modules')
                        ->result();
    }

    public function loadAllRoles() {
        if (_is("RC Admin")) {
            return $this->db->select('*')
                            ->where('name !=', 'GR Admin')
                            ->where('name !=', 'Users')
                            ->get('role')
                            ->result();
        } else {
            return $this->db->select('*')
                            ->where('name !=', 'Users')
                            ->get('role')
                            ->result();
        }
    }

    public function loadAllowedModules($role_id) {
        return $this->db->select('module_id')
                        ->where('role_id', $role_id)
                        ->distinct()
                        ->get('role_allowed_module')
                        ->result_array();
    }

    public function loadAllGRModules() {
        return $this->db->select('id AS module_id')
                        ->get('modules')
                        ->result_array();
    }

    public function loadassignedModules($role_id) {
        return $this->db->select('module_id')
                        ->where('role_id', $role_id)
                        ->distinct()
                        ->get('role_module')
                        ->result_array();
    }

    public function loadassignedUsers($role_id,$center_id=0) {
        return $this->db->select('user_id')
                        ->where('role_id', $role_id)
                        ->where('(center_id ='.$center_id.' OR center_id=0)')
                        ->distinct()
                        ->get('user_role')
                        ->result_array();
    }

    public function loadAllUsers($user_id, $center_id = 0) {
        if ($center_id == 0) {
            
        } else {
            $users = $this->db->select('u.*')
                    ->from('user as u')
                    ->join('user_role as ur', 'ur.user_id=u.id')
                    ->where('ur.center_id', $center_id)
                    ->distinct('ur.user_id')
                    ->get()
                    ->result();

            return $users;
        }
    }
    public function loadAllUsersresultarray($user_id, $center_id = 0) {
        if ($center_id == 0) {
            return;
        } else {
            $users = $this->db->select('u.*')
                    ->from('user as u')
                    ->join('user_role as ur', 'ur.user_id=u.id')
                    ->where('ur.center_id', $center_id)
                    ->distinct('ur.user_id')
                    ->get()
                    ->result_array();

            return $users;
        }
    }

    public function loadAllUsersarray($user_id, $center_id = 0) {
        if ($center_id == 0) {
            
        } else {
            $query = "SELECT * FROM user WHERE id NOT IN(SELECT user_id AS id FROM user_role WHERE center_id=$center_id)";
            $users = $this->db->query($query)
                    ->result_array();

            return $users;
        }
    }

    public function loadtotalUsers($user_id, $center_id = 0) {
//            return $users;
        $users1 = $this->db->select('v.*')
                ->from('user v')
//                ->distinct('ur.user_id')
                ->where("v.id NOT IN (SELECT u.id FROM user u LEFT JOIN user_role as ur ON(ur.user_id=u.id) WHERE ur.center_id=$center_id)")
                ->get()
                ->result();
        return $users1;
    }

    public function loadAllCenters() {
        return $this->db->select('*')
                        ->distinct()
                        ->get('center')
                        ->result();
    }

    public function addRoleModule($role_id, $module_id) {
        if ($role_id != '' && $module_id != '') {
            $result = $this->db->select('*')
                    ->where('role_id', $role_id)
                    ->where('module_id', $module_id)
                    ->get('role_module');
            if ($result->num_rows() == 0) {
                $data = array('role_id' => $role_id, 'module_id' => $module_id, 'status' => 1);
                if (_is("GR Admin")) {
                    $this->insertRow($data, 'role_allowed_module');
                }
                if ($this->insertRow($data, 'role_module') > 0) {
                    return 'true';
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function removeRoleModule($role_id, $module_id) {
        if ($role_id != '' && $module_id != '') {
            $result = $this->db->select('*')
                    ->where('role_id', $role_id)
                    ->where('module_id', $module_id)
                    ->get('role_module');
            if ($result->num_rows() != 0) {
                if (_is("GR Admin")) {
//                    $this->db->where('role_id', $role_id)
//                        ->where('module_id', $module_id)
//                        ->delete('role_allowed_module');
                }
                $result = $this->db->where('role_id', $role_id)
                        ->where('module_id', $module_id)
                        ->delete('role_module');
                if ($result) {
                    return 'true';
                } else {
                    return FALSE;
                }
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function addUserRole($role_id, $user_id, $center_id = 0) {
        if ($role_id != '' && $user_id != '') {
            if($role_id==1){
                $center_id=0;
            }
            $result = $this->db->select('*')
                    ->where('role_id', $role_id)
                    ->where('user_id', $user_id)
                    ->where('center_id', $center_id)
                    ->get('user_role');
            if ($result->num_rows() == 0) {
                $data = array('role_id' => $role_id, 'center_id' => $center_id, 'user_id' => $user_id, 'status' => 1);
                if ($this->insertRow($data, 'user_role') > 0) {
                    return 'true';
                } else {
                    return "Failed to insert";
                }
            } else {
                return "This role already added";
            }
        } else {
            return "something went wrong please refresh";
        }
    }

    public function removeUserRole($role_id, $user_id, $center_id) {
        if ($role_id != '' && $user_id != '') {
            if($role_id==1){
                $center_id=0;
            }
            $result = $this->db->select('*')
                    ->where('role_id', $role_id)
                    ->where('user_id', $user_id)
                    ->where('center_id', $center_id)
                    ->get('user_role');
            if ($result->num_rows() != 0) {
                $result = $this->db->where('role_id', $role_id)
                        ->where('user_id', $user_id)
                        ->where('center_id', $center_id)
                        ->delete('user_role');
                if ($result) {
                    return 'true';
                } else {
                    return "Failed to insert";
                }
            } else {
                return "No Data found";
            }
        } else {
            return "something went wrong please refresh";
        }
    }

    public function adduserToRole($userid, $role_id, $center_id) {
        $array = array(
            'user_id' => $userid,
            'role_id' => $role_id,
            'center_id' => $center_id,
            'status' => 1
        );
        $this->db->where('user_id', $userid);
        $this->db->where('role_id', $role_id);
        $this->db->where('center_id', $center_id);
        $data = $this->db->get('user_role');
        if ($data->num_rows() == 0) {
            return $this->db->insert('user_role', $array);
        }
        return;
    }
    public function delete_role($id){
        return $this->db->where('id', $id)
                ->delete('role');
    }
    
    public function update_role($id,$array){
        return $this->db->where('id', $id)
                ->update('role',$array);
    }
    public function add_role($array){
        return $this->db->insert('role', $array);
    }
    public function get_all_roles(){
        return $this->db->select('*')
                ->get('role')
                ->result();
    }

}
