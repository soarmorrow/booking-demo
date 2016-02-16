<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search_model
 *
 * @author Lachu
 */
class home_model extends MY_Model {

    //put your code here
    public function __construct($table_name = NULL, $primary_key = NULL) {
        parent::__construct($table_name, $primary_key);
    }

    public function searchData($key, $page, $per_page) {
        if ($key != NULL) {
            $count = ($page - 1) * $per_page;
            $query = "SELECT e.id AS event_id,e.name AS event_name,e.image AS event_image,e.start_time AS e_start_time,e.end_time AS e_end_time,e.description AS event_description,e.facilities  AS event_facilities,
            c.id AS center_id,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description
            FROM center AS c LEFT JOIN events AS e ON c.id = e.center_id WHERE 
            MATCH(e.name,e.start_time,e.end_time,e.description,e.facilities) AGAINST('$key') 
            OR MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') 
            ORDER BY (e.added_date) DESC LIMIT $count,$per_page";
            $result = $this->db->query($query);
        } else {
            $result = $this->db->select('e.id AS event_id,e.name AS event_name,e.image AS event_image,e.start_time AS e_start_time,e.end_time AS e_end_time,e.description AS event_description,e.facilities  AS event_facilities,
                c.id AS center_id,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description')
            ->from('events AS e')
            ->join('center AS c', 'e.center_id=c.id')
            ->order_by('added_date', 'DESC')
            ->limit(10)
            ->get();
        }
        return $result->result();
    }

    public function searchCount($key) {
        if ($key != NULL) {
            $query = "SELECT e.id AS event_id
            FROM center AS c LEFT JOIN events AS e ON c.id = e.center_id WHERE 
            MATCH(e.name,e.start_time,e.end_time,e.description,e.facilities) AGAINST('$key') 
            OR MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key')";
            $result = $this->db->query($query);
        } else {
            $result = $this->db->select('*')
            ->order_by('added_date', 'DESC')
            ->limit(10)
            ->get('events');
        }
        return $result->num_rows();
    }

    public function getUpcomingEvents($currentpage = 0) {
        $data = $this->db->select('e.*,c.name AS center_name,c.street_address1,c.state')
        ->from('events AS e')
        ->join('center AS c', 'c.id=e.center_id')
        ->where('start_date > NOW()')
        ->where('published', 1)
        ->where('is_deleted', 0)
        ->order_by('start_date', 'ASC')
        ->limit(3, $currentpage * 3)
        ->get()->result();
        return $data;
    }

    function getmoreEvents($currentpage = 1) {
        $data = $this->db->select('e.*,c.name AS center_name,c.street_address1,c.state')
        ->from('events AS e')
        ->join('center AS c', 'c.id=e.center_id')
        ->where('start_date > NOW()')
        ->where('published', 1)
        ->where('is_deleted', 0)
        ->order_by('start_date', 'ASC')
        ->limit(3, $currentpage * 3)
        ->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getPopularCenters($currentpage = 0) {
        $data = $this->db->select('c.*,COUNT(e.id) AS eventcount')
        ->from('center AS c')
        ->join('events AS e', 'c.id=e.center_id', "LEFT")
        ->group_by('c.id')
        ->where('verified', 1)
        ->where('popularity', 1)
        ->where('is_deleted', 0)
        ->where('deleted_on', '0000-00-00 00:00:00')
        ->order_by('eventcount', 'DESC')
        ->limit(3, $currentpage * 3)
        ->get()->result();
        return $data;
    }

    public function getLatestArticles($currentpage = 0) {
        $data = $this->db->select('b.*,a.path AS event_image')
        ->from('blog AS b')
        ->join('attachment AS a', 'b.id=a.parent_id AND a.parent_type=1 AND a.attachment_type=0', "LEFT")
        ->group_by('b.id')
        ->where('b.status', 1)
        ->order_by('b.timestamp', 'DESC')
        ->limit(4, $currentpage * 4)
        ->get()->result();
        return $data;
    }

    function getmoreCenters($currentpage = 1) {
        $data = $this->db->select('c.*,COUNT(e.id) AS eventcount')
        ->from('center AS c')
        ->join('events AS e', 'c.id=e.center_id', "LEFT")
        ->where('verified', 1)
        ->where('popularity', 1)
        ->where('is_deleted', 0)
        ->group_by('c.id')
        ->order_by('eventcount', 'DESC')
        ->limit(3, $currentpage * 3)
        ->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getPreachers($currentpage = 0) {
        $data = $this->db->select('*')
        ->from('preachers')
        ->where('published', 1)
        ->order_by('timestamp', 'DESC')
        ->limit(4, $currentpage * 4)
        ->get()->result();
        return $data;
    }

    function getmorePreachers($currentpage = 1) {
        $data = $this->db->select('*')
        ->from('preachers')
        ->where('published', 1)
        ->order_by('timestamp', 'ASC')
        ->limit(4, $currentpage * 4)
        ->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function getmoreArticles($currentpage = 1) {
        $data = $this->db->select('b.*,a.path AS event_image')
        ->from('blog AS b')
        ->join('attachment AS a', 'b.id=a.parent_id AND a.parent_type=1 AND a.attachment_type=0', "LEFT")
        ->group_by('b.id')
        ->order_by('b.timestamp', 'DESC')
        ->limit(4, $currentpage * 4)
        ->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    function profile_details($id) {
        return $this->db->select('*')
        ->from('customer')
        ->where('id', $id)
        ->get()
        ->row();
    }

    function update_profile_details($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('customer', $data);
    }

    function checkMailexist($id = NULL, $email) {
        if (isset($id) && $id != NULL) {
            $this->db->where('id !=' . $id);
        }

        return $this->db->select('*')
        ->from('customer')
        ->where('email', $email)
        ->get();
    }

    function checkusernameexist($id, $name) {

        return $this->db->select('*')
        ->from('customer')
        ->where('id !=' . $id)
        ->where('username', $name)
        ->get();
    }

    public function check_activation($id, $code) {
        $data = $this->db->select('*')
        ->from('customer')
        ->where('activation_code', $code)
        ->where('id', $id)
        ->get();
        $update = array('active' => 1, 'activation_code' => NULL);
        if ($data->num_rows() > 0) {
            return $this->db->where('id', $id)
            ->update('customer', $update);
        } else {
            return false;
        }
    }

    public function list_category() {
        return $this->db->select('*')
        ->from('rc_category')
        ->get()
        ->result();
    }

    public function list_type() {
        return $this->db->select('*')
        ->from('rc_type')
        ->order_by('order', 'ASC')
        ->get()
        ->result();
    }

    //get all slider images for home page
    public function getAllImages() {
        return $this->db->select('*')
        ->from('home_slider')
        ->where('priority !=0')
        ->where('published', 1)
        ->order_by('priority', 'ASC')
        ->limit(10)
        ->get()
        ->result();
    }

    //get homeslider image count
    //get all slider images for home page
    public function getAllImagesCount() {
        $count = $this->db->select('count(*) as count')
        ->from('home_slider')
        ->where('published', 1)
        ->where('priority !=0')
        ->limit(10)
        ->get()
        ->row();
        return $count->count;
    }

}

?>
