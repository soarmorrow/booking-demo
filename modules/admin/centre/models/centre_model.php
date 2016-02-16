<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Centre_model extends MY_Model {

    public function __construct() {
        parent::__construct(IMS_DB_PREFIX . 'center', 'id');
    }

    public function getCentre($offset, $perpage, $sort = NULL, $search = NULL) {

        if (!empty($search) and $search['word'] != '') {
            $search_where = '(';
            foreach ($search['fields'] as $k => $v) {
                if ($k == 0) {
                    $search_where .= $v . " LIKE '%" . $search['word'] . "%'";
                } else {
                    $search_where .= " OR " . $v . " LIKE '%" . $search['word'] . "%'";
                }
            }
            $search_where .= ')';
            $this->db->where($search_where);
        }
        if (!empty($sort)) {
            $this->db->order_by($sort['name'], $sort['type']);
        }


        $query = $this->db->where('archive', 0)->get($this->table_name, $perpage, $offset);

        $result['allCentres'] = $query->result_array();
        $this->db->select('count(*) as cnt')
                ->from($this->table_name);

        if (!empty($search) and $search['word'] != '') {
            $search_where = '(';
            foreach ($search['fields'] as $k => $v) {
                if ($k == 0) {
                    $search_where .= $v . " LIKE '%" . $search['word'] . "%'";
                } else {
                    $search_where .= " OR " . $v . " LIKE '%" . $search['word'] . "%'";
                }
            }
            $search_where .= ')';
            $this->db->where($search_where);
        }

        $result['total'] = $this->db->where('archive', 0)->get()->row()->cnt;
        return($result);
    }

    public function add_center($center = array(), $centerimages = array(), $preacherarray = null) {
        $this->db->insert('center', $center);
        $center_id = $this->db->insert_id();
        if ($centerimages != '') {
            foreach ($centerimages as $value) {
                $array = array(
                    'path' => $value,
                    'center_id' => $center_id,
                    'status' => 1
                );
                $this->db->insert('rc_images', $array);
            }
        }
        if (!empty($preacherarray)) {
            foreach ($preacherarray as $value1) {
                $array1 = array(
                    'preacher_id' => $value1,
                    'center_id' => $center_id
                );
                $this->db->insert('center_preachers', $array1);
            }
        }
        return $center_id;
    }

    public function update_centre($centre_id, $center = array(), $centerimages = array(), $preacherarray = '') {
        $this->db->where('id', $centre_id);
        $data = $this->db->update('center', $center);
        if ($centerimages != '') {
            foreach ($centerimages as $value) {
                $array = array(
                    'path' => $value,
                    'center_id' => $centre_id,
                    'status' => 1
                );
                $this->db->insert('rc_images', $array);
            }
        }
        if ($preacherarray != '') {
            $this->db->where('center_id', $centre_id)
                    ->delete('center_preachers');
            foreach ($preacherarray as $value) {
                $array = array(
                    'preacher_id' => $value,
                    'center_id' => $centre_id
                );
                $this->db->insert('center_preachers', $array);
            }
        }
        return $data;
    }

    public function delete_centre($centre_id, $values) {
        $this->db->where('id', $centre_id);
        return $this->db->update(IMS_DB_PREFIX . 'center', $values);
    }

    public function getCentreList($centre_id = NULL, $filters, $per_page, $page) {
        if (isset($filters['name'])) {
            $this->db->where('R.name LIKE \'%' . $filters['name'] . '%\'');
        }
        if (isset($filters['email'])) {
            $this->db->where('R.email LIKE \'%' . $filters['email'] . '%\'');
        }
        if (isset($filters['reg_no'])) {
            $this->db->where('R.reg_num LIKE \'%' . $filters['reg_no'] . '%\'');
        }
        if (isset($filters['address'])) {
            $this->db->where('(R.street_address1 LIKE \'%' . $filters['address'] . '%\' OR R.street_address2 LIKE \'%' . $filters['address'] . '%\' OR R.city LIKE \'%' . $filters['address'] . '%\'  OR R.state LIKE \'%' . $filters['address'] . '%\' OR R.state LIKE \'%' . $filters['address'] . '%\')');
        }
        if (isset($filters['rc_cat'])) {
            $this->db->where('R.rc_category_id ', (int) $filters['rc_cat']);
        }
        if (isset($filters['rc_type'])) {
            $this->db->where('R.rc_type_id ', (int) $filters['rc_type']);
        }
        if (isset($filters['status'])) {
            $this->db->where('R.verified ', (int) $filters['status']);
        }
        if ($centre_id)
            $this->db->where('id', $centre_id);
        $this->db->select(' R.id, R.name, R.country, R.state, R.city, R.street_address1, R.street_address2, R.zipcode, '
                . 'R.contact, R.email, R.logo, R.description,R.reg_num, R.status, R.verified, R.verified_at, R.popularity, R.logitude,'
                . ' R.lattitude, R.rc_type_id, R.rc_category_id, R.timestamp,T.name as rc_type,C.rc_category as rc_category');
        $this->db->from(IMS_DB_PREFIX . 'center as R');
        $this->db->join('rc_type as T', "T.id=R.rc_type_id");
        $this->db->join('rc_category as C', "C.id=R.rc_category_id");
        $this->db->where('R.status', 1);
        $this->db->where('R.is_deleted', 0);
         $this->db->group_by('id');
        $this->db->order_by('R.timestamp', 'desc');
        $this->db->limit($per_page, (($page - 1) * $per_page));
        $result = $this->db->get()->result();
        return $result;
    }

    public function get_centre_count($filters) {
        if (isset($filters['name'])) {
            $this->db->where('name LIKE \'%' . $filters['name'] . '%\'');
        }
        if (isset($filters['email'])) {
            $this->db->where('email LIKE \'%' . $filters['email'] . '%\'');
        }
        if (isset($filters['reg_no'])) {
            $this->db->where('reg_num LIKE \'%' . $filters['reg_no'] . '%\'');
        }
        if (isset($filters['address'])) {
            $this->db->where('(street_address1 LIKE \'%' . $filters['address'] . '%\' OR street_address2 LIKE \'%' . $filters['address'] . '%\' OR city LIKE \'%' . $filters['address'] . '%\'  OR state LIKE \'%' . $filters['address'] . '%\' OR state LIKE \'%' . $filters['address'] . '%\')');
        }
        if (isset($filters['rc_cat'])) {
            $this->db->where('rc_category_id ', (int) $filters['rc_cat']);
        }
        if (isset($filters['rc_type'])) {
            $this->db->where('rc_type_id ', (int) $filters['rc_type']);
        }
        if (isset($filters['status'])) {
            $this->db->where('verified ', (int) $filters['status']);
        }
        $query = $this->db->select('id')->from('center')->where('status', 1)->where('is_deleted', 0)->get();
        return $query->num_rows();
    }

    function getCenterStatus($center_id) {
        $centerData = $this->db->get_where(IMS_DB_PREFIX . 'center', array('id' => $center_id, 'archive' => 0))->row();
        if (!empty($centerData)) {
            return intval($centerData->status);
        }
        return false;
    }

    function updateCenterStatus($centerId, $prevStatus) {
        $thisStatus = $prevStatus == 1 ? 0 : 1;
        $this->db->where('id', $centerId);
        $this->db->update(IMS_DB_PREFIX . 'center', array('status' => $thisStatus));
        $thisChange = $thisStatus == 0 ? "Activate" : "Suspend";
        return $thisChange;
    }

    public function get_centre($id) {
        return $this->db->select('R.*,T.name as rc_type,C.rc_category as rc_category')
                        ->from(IMS_DB_PREFIX . 'center as R')
                        ->join('rc_type as T', "T.id=R.rc_type_id")
                        ->join('rc_category as C', "C.id=R.rc_category_id")
                        ->where('R.id', $id)
                        ->where('R.is_deleted', 0)
                        ->get()
                        ->row();
    }

    public function get_centre_images($centre_id) {
        return $this->db->select('*')
                        ->where('center_id', $centre_id)
                        ->get('rc_images')
                        ->result();
    }

    public function deletecentersliders($path) {

        $this->db->where('path', $path)
                ->delete('rc_images');
        if ('uploads/images/eventslider/14520608113861.png' != $path) {
            echo unlink('./' . $path);
        } else {
            echo true;
        }
    }

    public function get_review_count($id, $type_id) {
        $count = $this->db->select('count(*) as count')
                ->from('reviews')
                ->where('item_id', $id)
                ->where('type_id', $type_id)
                ->get()
                ->row();
        return $count->count;
    }

    public function get_testimonial($id, $type_id, $per_page, $page) {
        return $this->db->select('reviews.*,customer.first_name,customer.last_name,customer.email ')
                        ->from('reviews')
                        ->join('customer', 'customer.id=reviews.user_id')
                        ->where('item_id', $id)
                        ->where('type_id', $type_id)
                        ->limit($per_page, (($page - 1) * $per_page))
                        ->get()
                        ->result();
    }

    public function update_review($centre_id, $center = array(), $centerimages = array()) {
        $this->db->where('id', $centre_id);
        $data = $this->db->update('reviews', $center);
        return $data;
    }

    public function get_centre_view_count($id, $type_id) {
        $count = $this->db->select('count(*) as count')
                ->from('views')
                ->where('item_id', $id)
                ->where('type_id', $type_id)
                ->get()
                ->row();
        return $count->count;
    }

    function getPreachers() {
        $data = $this->db->select('*')
                ->order_by('timestamp', 'DESC')
                ->get('preachers')
                ->result();
        return $data;
    }

    function get_centre_preachers($centre_id) {
        $data = $this->db->select('preacher_id')
                        ->where('center_id', $centre_id)
                        ->get('center_preachers')->result_array();
        $result = array_column($data, 'preacher_id');
        return $result;
    }

}