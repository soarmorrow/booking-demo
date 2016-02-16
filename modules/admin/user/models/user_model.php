<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class user_model extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function loadUserRole() {
        if (_is('GR Admin')) {
            $roles = $this->db->select("*")
                    ->get('role');
            return $roles->result();
        } else {
            $roles = $this->db->select("*")
                    ->where('parent_id !=', -1)
                    ->get('role');
            return $roles->result();
        }
    }

    public function loadUserAssignedRole($user_id) {
        $roles = $this->db->select('role_id')
                ->where('user_id', $user_id)
                ->get('user_role')
                ->result();
        $data = array();
        foreach ($roles as $value) {
            array_push($data, $value->role_id);
        }
        return $data;
    }

    public function getAllUsers($type, $perpage, $page, $user_id, $name = '', $email = '', $rc_centers = '0', $role = '0') {
        $this->db->select('u.*,GROUP_CONCAT(DISTINCT rr.name) as role_name,GROUP_CONCAT(DISTINCT c.name) as center_name')
                ->from('user as u')
                ->join('user_role as ur', 'ur.user_id = u.id', "LEFT")
                ->join('role as rr', 'rr.id = ur.role_id', "LEFT")
                ->join('center as c', 'ur.center_id = c.id', "LEFT")
                ->where('u.id !=', $user_id);
        if (_is("RC Admin")) {
            $this->db->where('ur.center_id', $this->session->userdata('origin_centre_id'));
        } else {
            if ($rc_centers != '0') {
                $this->db->where('ur.center_id', $rc_centers);
            }
        }
        if ($role != '0') {
            $this->db->where('ur.role_id', $role);
        }
        if ($email != '') {
            $this->db->like('u.email', $email);
        }
        if ($name != '') {
            $this->db->where('(u.first_name LIKE \'%' . $name . '%\' OR u.last_name LIKE \'%' . $name . '%\' )', NULL, FALSE);
        }
        $this->db->group_by('u.id');
        if ($perpage != 0 || $page != 0) {
            $this->db->limit($perpage, (($page - 1) * $perpage));
        }
        $users = $this->db->get();
        if ($type) {
            return $users->result();
        } else {
            return $users->num_rows();
        }
    }

    public function disableuser($id, $is) {
        $this->db->where('id', $id);
        return $this->db->update('user', array('active' => $is, 'activation_code' => ''));
    }

    public function loadCenters($user_id) {
        if (_ismyrole($user_id, 1)) {
            $center = $this->db->select("*")
                    ->where('is_deleted', 0)
                    ->get('center');
            return $center->result();
        } else {
            $center = $this->db->select("c.*")
                    ->from(IMS_DB_PREFIX . 'center as c')
                    ->where('is_deleted', 0)
                    ->get('user_role as r', 'r.center_id = c.id');
            return $center->result();
        }
    }

    public function addNewUsers($array) {
        $this->db->insert('user', $array);
        return $this->db->insert_id();
    }

    public function updateNewUsers($userarray, $user_id) {
        $mail = $this->checkuniqemail($userarray['email'], $user_id);
        $user = $this->checkuname($userarray['username'], $user_id);
        if ($mail && $user) {
            $this->db->where('id', $user_id)->update('user', $userarray);
            return array('typealert' => "success", 'message' => 'User updated successfully');
        } else {
            if (!$mail && !$user) {
                return array('typealert' => "error", 'message' => 'This username and email already used');
            } else if ($mail) {
                return array('typealert' => "error", 'message' => 'This username already used');
            } else {
                return array('typealert' => "error", 'message' => 'This email already used');
            }
        }
    }

    public function checkuniqemail($email, $user_id) {
        $data = $this->db->select('*')
                ->where('id !=', $user_id)
                ->where('email', $email)
                ->get('user');
        if ($data->num_rows() > 0) {
            return FALSE;
        } else {
            return true;
        }
    }

    function checkuname($username, $user_id) {
        $data = $this->db->select('*')
                ->where('id !=', $user_id)
                ->where('username', $username)
                ->get('user');
        if ($data->num_rows() > 0) {
            return FALSE;
        } else {
            return true;
        }
    }

    public function addNewRolesToUsers($user_id, $userrole) {
        if ($userrole != '') {
            foreach ($userrole as $roleid) {
                $data = array(
                    'user_id' => $user_id,
                    'role_id' => $roleid,
                    'center_id' => $this->session->userdata('origin_centre_id'),
                    'status' => 1
                );
                $this->db->insert('user_role', $data);
            }
        }
    }

    public function updateNewRolesToUsers($user_id, $oldroles, $userrole) {
        $oldrow = array();
        if ($userrole != NULL) {
            foreach ($oldroles as $value) {
                if (!in_array($value, $userrole)) {
                    $this->db->where('user_id', $user_id)
                            ->where('role_id', $value)
                            ->delete('user_role');
                }
            }
            foreach ($userrole as $roleid) {
                if ($oldroles != NULL) {
                    if (!in_array($roleid, $oldroles)) {
                        $data = array(
                            'user_id' => $user_id,
                            'role_id' => $roleid,
                            'center_id' => 0,
                            'status' => 1
                        );
                        $this->db->insert('user_role', $data);
                    }
                } else {
                    $data = array(
                        'user_id' => $user_id,
                        'role_id' => $roleid,
                        'center_id' => 0,
                        'status' => 1
                    );
                    $this->db->insert('user_role', $data);
                }
            }
        } else {
            $this->db->where('user_id', $user_id)
                    ->delete('user_role');
        }
        $roles = $this->db->select('role_id')
                ->where('user_id', $user_id)
                ->get('user_role')
                ->result();
        $data1 = array();
        foreach ($roles as $value) {
            array_push($data1, $value->role_id);
        }
        return $data1;
    }

    public function loadRequestedUser($user_id) {
        $user = $this->db->select("u.*,GROUP_CONCAT(DISTINCT rr.name) as role_name,GROUP_CONCAT(DISTINCT c.name) AS center_name")
                ->where('u.id', $user_id)
                ->from('user as u')
                ->join('user_role ur', 'ur.user_id=u.id')
                ->join('role as rr', 'rr.id = ur.role_id')
                ->join('center c', 'ur.center_id=c.id',"LEFT")
                ->get()
                ->row();
//        if ($user->avatar == '') {
//            $user->avatar = $avatar = 'https://s.gravatar.com/avatar/' . md5($user->email) . '?s=250';
//        }
        return $user;
    }

    public function deleteRequestedUser($user_id) {
        return $this->db->where('id', $user_id)
                        ->delete('user');
    }

}
