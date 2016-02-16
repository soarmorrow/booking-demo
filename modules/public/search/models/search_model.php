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
class search_model extends MY_Model {

    //put your code here
    public function __construct($table_name = NULL, $primary_key = NULL) {
        parent::__construct($table_name, $primary_key);
    }

    public function searchData($key) {

        if ($key != NULL) {
            $query = "SELECT e.id AS event_id,e.name AS event_name,e.image AS event_image,e.start_time AS e_start_time,e.end_time AS e_end_time,e.description AS event_description,e.facilities  AS event_facilities,
            c.id AS center_id,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description
            FROM center AS c LEFT JOIN events AS e ON c.id = e.center_id WHERE 
            MATCH(e.name,e.start_time,e.end_time,e.description,e.facilities) AGAINST('$key') 
            OR MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') 
            ORDER BY (e.added_date) DESC ";
            $result = $this->db->query($query);
        } else {
            $result = $this->db->select('e.id AS event_id,e.name AS event_name,e.image AS event_image,e.start_time AS e_start_time,e.end_time AS e_end_time,e.description AS event_description,e.facilities  AS event_facilities,
                c.id AS center_id,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description')
                    ->from('events AS e')
                    ->join('center AS c', 'e.center_id=c.id')
                    ->order_by('added_date', 'DESC')
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
                    ->from('events')
                    ->order_by('added_date', 'DESC')
                    ->get();
        }
        return $result->num_rows();
    }

    public function search_center($filters, $page) {
        $offset = $page * 4;
        $key = $filters['key'];
        $centre_lang = $filters['centre_lang'];
        $centre = $filters['centre'];
        $result = array();
        $this->db->select('c.id AS center_id,GROUP_CONCAT( DISTINCT (e.id)) AS E_id,GROUP_CONCAT( DISTINCT MONTHNAME(e.start_date)) AS month_name,COUNT(DISTINCT(e.id)) AS count,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description')
                ->from('center AS c')
                ->join('events AS e', 'c.id = e.center_id', 'LEFT')
                ->join('event_preachers AS ep', 'ep.event_id = e.id', 'LEFT')
                ->join('preachers AS p', 'p.id = ep.preacher_id', 'LEFT')
                ->join('languages as lang', 'lang.id=p.language');
        if ($key != NULL) {
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(p.name) AGAINST('$key'))");
        }

        if ($filters['inner_key'] != NULL) {
            $innerkey = $filters['inner_key'];
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$innerkey') OR MATCH(p.name) AGAINST('$innerkey'))");
        }

        if ($filters['centre'] != '') {
            $this->db->where('c.rc_type_id', $filters['centre']);
        }
        if ($filters['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filters['startdate'] . "'");
        }

        if ($filters['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filters['enddate'] . "'");
        }


        if ($centre_lang != '') {
            $this->db->like("p.language", $centre_lang);
        }

        $result = $this->db->where('c.verified', 1)
                ->where("(e.start_date >'" . date('Y-m-d :H:i:s') . "' OR e.start_date is null)", null, null, true)
                ->where('(e.published = 1 OR e.published is null)', null, null, true)
                ->where('c.popularity', 1)
                ->limit(4, $offset)
                ->group_by('c.id')
                ->get();
        return $result;
    }

    public function search_center_count($filters) {
        $key = $filters['key'];
        $centre_lang = $filters['centre_lang'];
        $centre = $filters['centre'];
        $result = array();


        $this->db->select('c.id AS center_id,COUNT(DISTINCT(e.id)) AS count,c.name AS center_name,c.logo AS center_image,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description AS center_description')
                ->from('center AS c')
                ->join('events AS e', 'c.id = e.center_id', 'left')
                ->join('event_preachers AS ep', 'ep.event_id = e.id', 'LEFT')
                ->join('preachers AS p', 'p.id = ep.preacher_id', 'LEFT')
                ->join('languages as lang', 'lang.id=p.language');
        if ($key != NULL) {
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(p.name) AGAINST('$key'))");
        }
        if ($filters['inner_key'] != NULL) {
            $innerkey = $filters['inner_key'];
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$innerkey') OR MATCH(p.name) AGAINST('$innerkey'))");
        }
        if ($filters['centre'] != '') {
            $this->db->where('c.rc_type_id', $filters['centre']);
        }
        if ($filters['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filters['startdate'] . "'");
        }

        if ($filters['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filters['enddate'] . "'");
        }

        if ($centre_lang != '') {
            $this->db->like("p.language", $centre_lang);
        }

        $result = $this->db->where('c.verified', 1)
                ->where("(e.start_date >'" . date('Y-m-d :H:i:s') . "' OR e.start_date is null)", null, null, true)
                ->where('(e.published = 1 OR e.published is null)', null, null, true)
                ->where('c.popularity', 1)
                ->group_by('c.id')
                ->get();
        return $result->num_rows();
    }

    //get all events by centre id
    function get_events($id = null, $filter, $currentpage = 0, $type = null, $month = null) {
        $key = $filter['key'];

        if ($type != null) {
            $this->db->where('e.type_id', $type);
        }
        if ($month != null) {
            $this->db->where('MONTHNAME(e.start_date)', $month);
        }
        if ($id != null) {
            $this->db->where('e.center_id', $id);
        }
        if ($key != NULL) {
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(p.name) AGAINST('$key'))");
        }
        if ($filter['centre'] != '') {
            $this->db->where('c.rc_type_id', $filter['centre']);
        }
        if ($filter['centre_lang'] != '') {
            $this->db->like('UPPER(p.language)', strtoupper($filter['centre_lang']));
        }
        if ($filter['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filter['startdate'] . "'");
        }

        if ($filter['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filter['enddate'] . "'");
        }
        $data = $this->db->select('e.*,c.name as center_name,c.street_address1,c.state')
                        ->from('events AS e')
                        ->join('center AS c', 'c.id=e.center_id')
                        ->join('event_preachers AS ep', 'ep.event_id = e.id', 'left')
                        ->join('preachers AS p', 'p.id = ep.preacher_id', 'left')
                        ->join('languages as lang', 'lang.id=p.language')
                        ->where('c.verified', 1)
                        ->where("e.start_date >'" . date('Y-m-d :H:i:s') . "'")
                        ->where('e.published', 1)
                        ->group_by('e.id')
                        ->limit(3, $currentpage * 3)
                        ->get()->result();
        return $data;
    }

    //get all events Count by centre id
    function get_events_count($id = null, $filter, $currentpage = 0, $type = null, $month = null) {
        $key = $filter['key'];

        if ($type != null) {
            $this->db->where('e.type_id', $type);
        }
        if ($month != null) {
            $this->db->where('MONTHNAME(e.start_date)', $month);
        }
        if ($id != null) {
            $this->db->where('e.center_id', $id);
        }
        if ($key != NULL) {
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(p.name) AGAINST('$key'))");
        }
        if ($filter['centre'] != '') {
            $this->db->where('c.rc_type_id', $filter['centre']);
        }
        if ($filter['centre_lang'] != '') {
            $this->db->like('UPPER(p.language)', strtoupper($filter['centre_lang']));
        }
        if ($filter['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filter['startdate'] . "'");
        }

        if ($filter['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filter['enddate'] . "'");
        }
        $data = $this->db->select('e.*,c.name as center_name,c.street_address1,c.state')
                ->from('events AS e')
                ->join('center AS c', 'c.id=e.center_id')
                ->join('event_preachers AS ep', 'ep.event_id = e.id', 'left')
                ->join('preachers AS p', 'p.id = ep.preacher_id', 'left')
                ->join('languages as lang', 'lang.id=p.language')
                ->where('c.verified', 1)
                ->where("(e.start_date >'" . date('Y-m-d :H:i:s') . "' OR e.start_date is null)", null, null, true)
                ->where('(e.published = 1 OR e.published is null)', null, null, true)
                ->group_by('e.id')
                ->get();
        return $data->num_rows();
    }

    //get all preachers by event id
    public function get_preachers($id, $filter, $currentpage = 0) {
        $key = $filter['key'];
        $centre_lang = $filter['centre_lang'];
        $centre = $filter['centre'];
        $result = array();
        if ($id != null) {
            $this->db->where('events.center_id', $id);
        }
        if ($key != NULL) {
            $this->db->where("(MATCH(center.name,center.country,center.state,center.city,center.street_address1,center.street_address2,center.zipcode,center.description) AGAINST('$key') OR MATCH(preachers.name) AGAINST('$key'))");
        }
        if ($filter['centre'] != '') {
            $this->db->where('center.rc_type_id', $filter['centre']);
        }
        if ($filter['startdate'] != '') {
            $this->db->where("events.start_date >='" . $filter['startdate'] . "'");
        }

        if ($filter['enddate'] != '') {
            $this->db->where("events.end_date <='" . $filter['enddate'] . "'");
        }
        return $this->db->select('preachers.id,preachers.name,preachers.image')
                        ->from('events')
                        ->join('center', 'center.id=events.center_id')
                        ->join('event_preachers ep', 'ep.event_id=events.id')
                        ->join('preachers', 'preachers.id=ep.preacher_id')
                        ->join('languages as lang', 'lang.id=preachers.language')
                        ->where('events.center_id', $id)
                        ->where('center.verified', 1)
                        ->where("(events.start_date >'" . date('Y-m-d :H:i:s') . "' OR events.start_date is null)", null, null, true)
                        ->where('(events.published = 1 OR events.published is null)', null, null, true)
                        ->limit(4, $currentpage * 4)
                        ->get()
                        ->result();
    }

    //get centre details by center id
    public function get_centre($id, $filter) {
        return $this->db->select('center.*')
                        ->from('center')
                        ->join('events', 'center.id=events.center_id', 'LEFT')
                        ->where('center.id', $id)
                        ->where('center.verified', 1)
                        ->where('center.popularity', 1)
                        ->where("(events.start_date >'" . date('Y-m-d :H:i:s') . "' OR events.start_date is null)", null, null, true)
                        ->where('(events.published = 1 OR events.published is null)', null, null, true)
                        ->get()
                        ->row();
    }

    public function get_centre_images($id) {
        return $this->db->select('*')
                        ->from('rc_images')
                        ->where('center_id', $id)
                        ->get()
                        ->result();
    }

    //get all event types
    public function get_all_event_types() {

        return $this->db->select('*')
                        ->from('event_types')
                        ->get()
                        ->result();
    }

    public function getCenterTypes($filters) {
        $key = $filters['key'];
        $centre_lang = $filters['lang'];
        $centre = $filters['cntr'];
        $result = array();

        if ($filters['cntr'] != '') {
            $this->db->where('t.id', $filters['cntr']);
            $result = $this->db->select('t.*')
                    ->from('rc_type AS t')
                    ->order_by('t.order', 'ASC')
                    ->get()
                    ->result();
            return $result;
        } else {
            $this->db->select('t.*')
                    ->from('center AS c')
                    ->join('events AS e', 'c.id = e.center_id')
                    ->join('event_preachers AS ep', 'ep.event_id = e.id')
                    ->join('preachers AS pr', 'ep.preacher_id = pr.id')
                    ->join('languages as lang', 'lang.id=pr.language')
                    ->join('rc_type AS t', 'c.rc_type_id= t.id');
            if ($key != NULL) {
                $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(pr.name) AGAINST('$key'))");
            }
            if ($filters['startdate'] != '') {
                $this->db->where("e.start_date >='" . $filters['startdate'] . "'");
            }

            if ($filters['enddate'] != '') {
                $this->db->where("e.end_date <='" . $filters['enddate'] . "'");
            }

            // if ($filters['lang'] != '') {
            //     $this->db->where("e.end_date <='" . $filters['enddate'] . "'");
            // }

            if ($centre_lang != '') {
                $this->db->where('UPPER(pr.language)', strtoupper($centre_lang));
            }

            $result = $this->db->where('c.verified', 1)
                    ->where('c.popularity', 1)
                    ->where("e.start_date >'" . date('Y-m-d :H:i:s') . "'")
                    ->group_by('c.rc_type_id')
                    ->where('e.published', 1)
                        ->order_by('order', 'ASC')
                    ->get()
                    ->result();
            // debug($this->db->last_query());
            return $result;
        }
    }

    //get all events by month and year
    public function events_group_by_month($id = null, $filter) {
        if ($id != null) {
            $this->db->where('events.center_id', $id);
        }
        $data = $this->db->select('count(*) as count, MONTHNAME(events.start_date) as month, YEAR(events.start_date) as year')
                ->from('events')
                ->join('center', 'center.id=events.center_id')
                ->group_by('month')
                ->where('center.verified', 1)
                ->where("events.start_date >'" . date('Y-m-d :H:i:s') . "'")
                ->where('events.published', 1)
                ->order_by('events.start_date', 'desc')
                ->get()
                ->result();
        return $data;
    }

    public function get_centre_lang($id, $filter) {
        $key = $filter['key'];
        $centre_lang = $filter['centre_lang'];
        $centre = $filter['centre'];
        $result = array();

        if ($id != null) {
            $this->db->where('e.center_id', $id);
        }
        if ($key != NULL) {
            $this->db->where("MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key')");
            $this->db->or_where("MATCH(p.name) AGAINST('$key')");
        }
        if ($filter['centre'] != '') {
            $this->db->where('c.rc_type_id', $filter['centre']);
        }
        if ($filter['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filter['startdate'] . "'");
        }

        if ($filter['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filter['enddate'] . "'");
        }
        $data = $this->db->select('p.*')
                        ->from('events AS e')
                        ->join('center AS c', 'c.id=e.center_id')
                        ->join('event_preachers AS ep', 'ep.event_id = e.id')
                        ->join('preachers AS p', 'p.id = ep.preacher_id')
                        ->join('languages as lang', 'lang.id=p.language')
                        ->where('c.verified', 1)
                        ->where("(e.start_date >'" . date('Y-m-d :H:i:s') . "' OR e.start_date is null)", null, null, true)
                        ->where('(e.published = 1 OR e.published is null)', null, null, true)
                        ->group_by('p.language')
                        ->get()->result();
        return $data;
    }

//return event type name by type id
    public function get_event_type_by_id($id) {
        return $this->db->select('name')
                        ->from('event_types')
                        ->where('id', $id)
                        ->get()
                        ->row();
    }

    //get count of retreats by month name
    public function get_event_count_by_month($month, $center = null) {
        if ($center != null) {
            $this->db->where('center_id', $center);
        }
        return $this->db->select('count(*) as count')
                        ->from('events')
                        ->where('MONTHNAME(events.start_date)', $month)
                        ->get()
                        ->row();
    }

    function getmoreEvents($id = null, $filter = array(), $currentpage = 1, $type = null, $month = null) {
        $key = $filter['key'];

        if ($type != null) {
            $this->db->where('e.type_id', $type);
        }
        if ($month != null) {
            $this->db->where('MONTHNAME(e.start_date)', $month);
        }
        if ($id != null) {
            $this->db->where('e.center_id', $id);
        }
        if ($key != NULL) {
            $this->db->where("(MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key') OR MATCH(p.name) AGAINST('$key'))");
        }
        if ($filter['centre'] != '') {
            $this->db->where('c.rc_type_id', $filter['centre']);
        }
        if ($filter['centre_lang'] != '') {
            $this->db->like('UPPER(p.language)', strtoupper($filter['centre_lang']));
        }
        if ($filter['startdate'] != '') {
            $this->db->where("e.start_date >='" . $filter['startdate'] . "'");
        }

        if ($filter['enddate'] != '') {
            $this->db->where("e.end_date <='" . $filter['enddate'] . "'");
        }
        $data = $this->db->select('e.*,c.name as center_name,c.street_address1,c.state')
                ->from('events AS e')
                ->join('center AS c', 'c.id=e.center_id')
                ->join('event_preachers AS ep', 'ep.event_id = e.id')
                ->join('preachers AS p', 'p.id = ep.preacher_id')
                ->join('languages as lang', 'lang.id=p.language')
                ->where('c.verified', 1)
                ->where("e.start_date >'" . date('Y-m-d :H:i:s') . "'")
                ->where('e.published', 1)
                ->group_by('e.id')
                ->limit(3, $currentpage * 3)
                ->get();
        return $data->result();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMorePreachers($id, $currentpage = 1, $filter = null) {
        if ($filter != null) {
            $key = $filter['key'];
            $centre_lang = $filter['centre_lang'];
            $centre = $filter['centre'];
            $result = array();

            if ($id != null) {
                $this->db->where('events.center_id', $id);
            }
            if ($key != NULL) {
                $this->db->where("MATCH(center.name,center.country,center.state,center.city,center.street_address1,center.street_address2,center.zipcode,center.description) AGAINST('$key')");
                $this->db->or_where("MATCH(preachers.name) AGAINST('$key')");
            }
            if ($filter['centre'] != '') {
                $this->db->where('center.rc_type_id', $filter['centre']);
            }
            if ($filter['startdate'] != '') {
                $this->db->where("events.start_date >='" . $filter['startdate'] . "'");
            }

            if ($filter['enddate'] != '') {
                $this->db->where("events.end_date <='" . $filter['enddate'] . "'");
            }
        }
        $data = $this->db->select('preachers.name,preachers.image')
                ->from('events')
                ->join('center', 'center.id=events.center_id')
                ->join('event_preachers ep', 'ep.event_id=events.id')
                ->join('preachers', 'preachers.id=ep.preacher_id')
                ->join('languages as lang', 'lang.id=preachers.language')
                ->where('events.center_id', $id)
                ->limit(4, $currentpage * 4)
                ->get();
        if ($data->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getRetreatLanguage($filter) {
        $key = $filter['key'];

        if ($filter['lang'] != '') {
            return $this->db->select("languages.*")
                            ->from('languages')
                            ->join('preachers', 'languages.id=preachers.language', 'right')
                            ->where('languages.id', $filter['lang'])
                            ->group_by('languages.id')
                            ->get()->result();
        } else {
            if ($key != NULL) {
                $this->db->where("MATCH(c.name,c.country,c.state,c.city,c.street_address1,c.street_address2,c.zipcode,c.description) AGAINST('$key')");
                $this->db->or_where("MATCH(p.name) AGAINST('$key')");
            }
            if ($filter['cntr'] != '') {
                $this->db->where('c.rc_type_id', $filter['cntr']);
            }
            if ($filter['startdate'] != '') {
                $this->db->where("e.start_date >='" . $filter['startdate'] . "'");
            }

            if ($filter['enddate'] != '') {
                $this->db->where("e.end_date <='" . $filter['enddate'] . "'");
            }
            $result = $this->db->select('languages.*')
                            ->from('events AS e')
                            ->join('center AS c', 'c.id=e.center_id')
                            ->join('event_preachers AS ep', 'ep.event_id = e.id')
                            ->join('preachers AS p', 'p.id = ep.preacher_id')
                            ->join('languages', 'languages.id=p.language', 'right')
                            ->where('c.verified', 1)
                            ->where("e.start_date >'" . date('Y-m-d :H:i:s') . "'")
                            ->where('e.published', 1)
                            ->group_by('UPPER(languages.language)')
                            ->get()->result();
            return $result;
        }
    }

}

?>
