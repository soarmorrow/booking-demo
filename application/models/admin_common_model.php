<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_common_model extends MY_Model {

    public function __construct() {
        parent::__construct(IMS_DB_PREFIX . 'user', 'id');
    }

    public function getCurrentUser($user_id) {
        return $this->db->select('u.*')
                        ->from(IMS_DB_PREFIX . 'user as u')
                        ->where('u.id', $user_id)
                        ->get()
                        ->row();
    }

    public function getCurrentCustomer($user_id) {
        return $this->db->select('u.*')
                        ->from(IMS_DB_PREFIX . 'customer as u')
                        ->where('u.id', $user_id)
                        ->get()
                        ->row();
    }

    public function getUserRoles($user_id) {
        return $this->db->select('ur.*,r.name as role, c.name as centre')
                        ->from(IMS_DB_PREFIX . 'user_role as ur')
                        ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                        ->join(IMS_DB_PREFIX . 'centre as c', 'ur.centre_id = c.id')
                        ->where('ur.user_id', $user_id)
                        ->order_by('c.name, role_id')
                        ->get()
                        ->result();
    }

    public function getKeyRoles($user_id) {
        return $this->db->select('ur.*,r.name as role,r.order as role_order')
                        ->from(IMS_DB_PREFIX . 'user_role as ur')
                        ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                        ->where('ur.user_id', $user_id)
                        ->order_by('role_order', 'asc')
                        ->get()
                        ->result();
    }

    public function getYearTerms($role = '') {
        if ($role == 'Teacher') {
            return $this->db->select('*')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('teacher_year_term', 1)
                            ->order_by('id')
                            ->get()
                            ->result();
        } else if ($role == 'Subject Coordinator') {
            return $this->db->select('*')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('sub_coordinator_year_term', 1)
                            ->order_by('id')
                            ->get()
                            ->result();
        } else if ($role == 'Supervisor' || $role == 'Level Coordinator') {

            return $this->db->select('*')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('supervisor_year_term', 1)
                            ->order_by('id')
                            ->get()
                            ->result();
        } else {

            return $this->db->select('*')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->order_by('id')
                            ->get()
                            ->result();
        }
    }

    public function getChildYearTerms($child_id) {
        return $this->db->select('yt.id, yt.year, yt.term')
                        ->from(IMS_DB_PREFIX . 'year_term as yt')
                        ->join(IMS_DB_PREFIX . 'child_class as cc', 'yt.id = cc.year_term_id')
                        ->where('cc.child_id', $child_id)
                        ->order_by('id', 'desc')
                        ->get()
                        ->result();
    }

    public function get_default_id($role = '') {
        if ($role == 'Teacher') {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default_for_teacher', 1)
                            ->get()
                            ->row();
        } else if ($role == 'Subject Coordinator') {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default_for_sub_coordinator', 1)
                            ->get()
                            ->row();
        } else if ($role == 'Supervisor' || $role == 'Level Coordinator') {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default_progress_report_for_supervisor', 1)
                            ->order_by('id')
                            ->get()
                            ->row();
        } else {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default', 1)
                            ->get()
                            ->row();
        }
    }

    public function get_default_progress_id($role = '') {
        if ($role == 'Teacher') {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('progress_report', 1)
                            ->get()
                            ->row();
        } else if ($role == 'Supervisor') {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default_progress_report_for_supervisor', 1)
                            ->get()
                            ->row();
        } else {
            return $this->db->select('id')
                            ->from(IMS_DB_PREFIX . 'year_term')
                            ->where('default', 1)
                            ->get()
                            ->row();
        }
    }

    public function get_max_id() {
        return $this->db->select('max(id) as id')
                        ->from(IMS_DB_PREFIX . 'year_term')
                        ->get()
                        ->row();
    }

    public function getCurrentYearTerm() {
        return year_term($this->db->select('max(id) as current_year_term_id')
                        ->from(IMS_DB_PREFIX . 'year_term')
                        ->get()
                        ->row()->current_year_term_id);
    }

    public function getDefaultYearTermID() {
        return $this->db->select('id')
                        ->from(IMS_DB_PREFIX . 'year_term')
                        ->where('default', 1)
                        ->get()
                        ->row()->id;
    }

    public function getLatestYearTerm() {
        $result = $this->db->select('id,year,term')
                ->from(IMS_DB_PREFIX . 'year_term as yt')
                ->where('id = (SELECT max(id) FROM (`year_term`))')
                ->get()
                ->row();

        return $result;
    }

    public function getDefaultRole($user_id, $centre_id) {
        return $this->db->select('ur.id as r_id,ur.role_id, ur.centre_id, r.name as role, c.name as centre,r.order as role_order')
                        ->from(IMS_DB_PREFIX . 'user_role as ur')
                        ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                        ->join(IMS_DB_PREFIX . 'centre as c', 'ur.centre_id = c.id')
                        ->where('ur.user_id', $user_id)
                        ->where('ur.role_id != ', '')
                        ->order_by('role_order', 'ASC')
                        ->limit(1)
                        ->get()
                        ->row();
    }

    public function getUserRole($user_role_id, $user_id) {
        $data = $this->db->select('ur.id as r_id,ur.role_id, ur.centre_id, r.name as role, c.name as centre, c.logo as logo,r.order as role_order')
                ->from(IMS_DB_PREFIX . 'user_role as ur')
                ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                ->join(IMS_DB_PREFIX . 'centre as c', 'ur.centre_id = c.id')
                ->where('ur.id', $user_role_id)
                ->where('ur.user_id', $user_id)
                ->where('ur.role_id != ', '')
                ->order_by('role_order', 'asc')
                ->get()
                ->row();
        return $data;
    }

    public function getKeyRole($user_role_id, $user_id) {
        return $this->db->select('ur.id as r_id,ur.role_id, ur.centre_id, r.name as role')
                        ->from(IMS_DB_PREFIX . 'user_role as ur')
                        ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                        ->where('ur.id', $user_role_id)
                        ->where('ur.role_id != ', '')
                        ->where('ur.user_id', $user_id)
                        ->get()
                        ->row();
    }

    public function getSingleUserRole($user_id) {
        $data = $this->db->select('*')
                ->from(IMS_DB_PREFIX . 'user_role')
                ->where('user_id', $user_id)
                ->where('role_id !=', '')
                ->order_by('role_id')
                ->get()
                ->result();
        return $data;
    }

    public function getCurrentUserRole($user_id, $center_id, $user_role_id) {
        return $this->db->select('ur.id as r_id,ur.role_id, ur.center_id, r.name as role, c.name as center, c.logo as logo')
                        ->from(IMS_DB_PREFIX . 'user_role as ur')
                        ->join(IMS_DB_PREFIX . 'role as r', 'ur.role_id = r.id')
                        ->join(IMS_DB_PREFIX . 'center as c', 'ur.center_id = c.id')
                        ->where('ur.center_id', $center_id)
                        ->where('ur.role_id', $user_role_id)
                        ->where('ur.user_id', $user_id)
                        ->get()
                        ->row();
    }

    public function getUserPermissions($role_id) {
        if (!_is("GR Admin")) {
            $modules = $this->db->select('m.name')
                    ->from(IMS_DB_PREFIX . 'role_module as rm')
                    ->join(IMS_DB_PREFIX . 'modules as m', 'rm.module_id = m.id')
                    ->where('rm.role_id', $role_id)
                    ->get()
                    ->result();
        } else {
            $modules = $this->db->select('name')->get('modules')->result();
        }

        $permissions = array();
        foreach ($modules as $module) {
            $permissions[] = $module->name;
        }
        return $permissions;
    }

    public function getSupervisorIds($staff_id) {
        $supervisors = $this->db->select('supervisor_id')
                ->from(IMS_DB_PREFIX . 'supervisor_user')
                ->where('user_id', $staff_id)
                ->get()
                ->result();
        return pluck($supervisors, 'supervisor_id');
    }

    public function getLevelCoordinatorsIds($level_id, $yearterm_id) {
        $level_coordinators = $this->db->select('lc_id')
                ->from(IMS_DB_PREFIX . 'lc_level')
                ->where('level_id', $level_id)
                ->where('concat(year,term)', $yearterm_id)
                ->get()
                ->result();
        return pluck($level_coordinators, 'lc_id');
    }

    public function getSubjectCoordinatorsIds($subject_id, $yearterm_id) {
        $subject_coordinators = $this->db->select('sc_id')
                ->from(IMS_DB_PREFIX . 'sc_subject')
                ->where('subject_id', $subject_id)
                ->where('concat(year,term)', $yearterm_id)
                ->get()
                ->result();
        return pluck($subject_coordinators, 'sc_id');
    }

    public function getAllDevices($child_id) {
        return $this->db->select('push_token')
                        ->from(IMS_DB_PREFIX . 'parent_child pc')
                        ->join(IMS_DB_PREFIX . 'push_user_device as d', 'd.parent_id = pc.parent_id')
                        ->where('pc.receive_notification', 1)
                        ->where('d.device_type', 'Android')
                        ->where('d.status', 1)
                        ->where('pc.child_id', $child_id)
                        ->get()
                        ->result();
    }

    public function getDevice($parent_id) {
        return $this->db->select('push_token')
                        ->from(IMS_DB_PREFIX . 'parent_child pc')
                        ->join(IMS_DB_PREFIX . 'push_user_device as d', 'd.parent_id = pc.parent_id')
                        ->where('pc.receive_notification', 1)
                        ->where('d.device_type', 'Android')
                        ->where('d.status', 1)
                        ->where('pc.parent_id', $parent_id)
                        ->get()
                        ->row();
    }

    public function getProgressReportYearTerm() {
        $result = $this->db->select('*')
                ->from(IMS_DB_PREFIX . 'year_term')
                ->where('progress_report', 1)
                ->get()
                ->row();
        if (!empty($result)) {
            return $result->year . $result->term;
        }
    }

    public function getCurriculumYearTerm() {
        $result = $this->db->select('*')
                ->from(IMS_DB_PREFIX . 'year_term')
                ->where('curriculum', 1)
                ->get()
                ->row();
        if (!empty($result)) {
            return $result->year . $result->term;
        }
    }

    public function getRcTypes() {
        return $this->db->select("*")
                        ->from('rc_type')
                        ->where('status', 1)
                        ->order_by('order', 'ASC')
                        ->get()->result();
    }

    public function getRetreatLanguage() {
        return $this->db->select("*")
                        ->from('languages')
                        ->get()->result();
    }

}
