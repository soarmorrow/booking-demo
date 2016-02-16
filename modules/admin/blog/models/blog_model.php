<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of blog_model
 *
 * @author Lachu
 */
class blog_model extends MY_Model {

    //put your code here
    //put your code here 

    public function __construct() {
        parent::__construct();
    }

    public function loadblogs($userid, $perpage, $page, $count, $content = "") {
        $this->db->select('*');
        $data = array();
        if (_is("GR Admin")) {
            $this->db->select('b.*,u.username as username,u.first_name as first_name,u.last_name as last_name')
            ->from("blog as b")
            ->join("user as u", 'u.id=b.user_id');
            if ($content != NULL) {
                $this->db->like('b.title', $content);
                $this->db->or_like('b.content', $content);
                $this->db->or_like('b.author', $content);
            }
            $this->db->order_by("b.timestamp","DESC");
            if ($perpage != 0 || $page != 0) {
                $this->db->limit($perpage, (($page - 1) * $perpage));
            }
            $data = $this->db->get();
        } else if (_can("Blog")) {
            $this->db->select('b.*,u.username as username,u.first_name as first_name,u.last_name as last_name')
            ->from("blog as b")
            ->join("user as u", 'u.id=b.user_id');
            if ($content != NULL) {
                $this->db->like('b.title', $content);
                $this->db->or_like('b.content', $content);
                $this->db->or_like('b.author', $content);
            }
            $this->db->where('user_id', $userid);
            $this->db->order_by("b.timestamp","DESC");
            if ($perpage != 0 || $page != 0) {
                $this->db->limit($perpage, (($page - 1) * $perpage));
            }
            $data = $this->db->get();
        }
        if ($count) {
            return $data->num_rows();
        }
        return $data->result();
    }

    public function loadsingleblog($userid, $blog_id) {
        $data = null;
        if (_is("GR Admin")) {
            $this->db->select('*');
            $data = $this->db->where('id', $blog_id)
            ->get('blog')->row();
        } else if (_can("Blog")) {
            $this->db->select('*');
            $data = $this->db->where('user_id', $userid)
            ->where('id', $blog_id)
            ->get('blog')->row();
        }
        return $data;
    }

    public function loadblogimages($blog_id) {
        $this->db->select('*');
        $data = $this->db->where('parent_id', $blog_id)
        ->where('parent_type', 1)
        ->get('attachment')->result();
        return $data;
    }

    public function editstatus($blog_id, $is) {
        $this->db->where('id', $blog_id);
        return $this->db->update('blog', array('status' => $is));
    }

    public function deleteblog($blog_id) {
        $result = $this->db->where('parent_id', $blog_id)
        ->get('attachment')
        ->result();
        $this->db->where('parent_id', $blog_id)
        ->where('parent_type', 1)
        ->delete('attachment');
        $this->db->where('id', $blog_id)
        ->delete('blog');
        foreach ($result as $value) {
            if (file_exists('./' . $value->path)) {
                if('uploads/images/eventslider/14520608113861.png'!= $value->path){            
                    unlink('./' . $value->path);
                }
            }
        }
        return true;
    }

    public function add_to_blog($userpostedarray, $user_id) {
        $array = array(
            'title' => $userpostedarray['title'],
            'author' => $userpostedarray['author'],
            'content' => $userpostedarray['content'],
            'user_id' => $user_id,
            'slug' => strtolower(str_replace(' ', '', $userpostedarray['title']) . "_" . date('Y_M_d_H_i_s')),
            'status' => 0
            );
        $this->db->insert('blog', $array);
        $id = $this->db->insert_id();
        if ($userpostedarray['images']) {
            foreach ($userpostedarray['images'] as $images) {
                if($images!='uploads/images/eventslider/14520608113861.png'){
                    $imageitem = array(
                        'parent_type' => 1,
                        'parent_id' => $id,
                        'path' => $images,
                        'attachment_type' => 0,
                        'status' => 0
                        );
                    $this->db->insert('attachment', $imageitem);
                }
            }
        }

$i=0;
        if ($userpostedarray['videos']) {
            foreach ($userpostedarray['videos'] as $videos) {
                $i++;
                $videoitem = array(
                    'parent_type' => 1,
                    'parent_id' => $id,
                    'path' => $videos,
                    'attachment_type' => 1,
                    'status' => 0
                    );
                $this->db->insert('attachment', $videoitem);
            }
        }

        if(empty($userpostedarray['images']) && $i==0){
            $imageitem = array(
                'parent_type' => 1,
                'parent_id' => $id,
                'path' => 'uploads/images/eventslider/14520608113861.png',
                'attachment_type' => 0,
                'status' => 0
                );
            $this->db->insert('attachment', $imageitem);
        }

        if ($id != NULL) {
            return TRUE;
        } else {
            return FALSE;
        }
//        ;
    }

    public function deleteblogfiles($path , $id) {
         if('uploads/images/eventslider/14520608113861.png'!=$path || $id!=null){
            $this->db->where('path', $path)
            ->where('parent_id', $id)
            ->where('parent_type',1)
            ->delete('attachment');
            echo unlink('./' . $path);
        }else{
            echo true;
        }
    }

public function update_current_blog($blog_id, $userpostedarray, $user_id) {
    $array = array(
        'title' => $userpostedarray['title'],
        'author' => $userpostedarray['author'],
        'content' => $userpostedarray['content'],
        'user_id' => $user_id,
        'slug' => strtolower(str_replace(' ', '', $userpostedarray['title']) . "_" . date('Y_M_d_H_i_s'))
        );
    $update = $this->db->where('id', $blog_id)
    ->update('blog', $array);


    $i=0;
    if ($userpostedarray['videos']) {
        $i++;
        foreach ($userpostedarray['videos'] as $videos) {
            $videoitem = array(
                'parent_type' => 1,
                'parent_id' => $blog_id,
                'path' => $videos,
                'attachment_type' => 1,
                'status' => 0
                );
            $this->db->insert('attachment', $videoitem);
        }
    }

    if ($userpostedarray['images']) {
        foreach ($userpostedarray['images'] as $images) {
            if($i>0 && $images=='uploads/images/eventslider/14520608113861.png'){
                continue;
            }
            $imageitem = array(
                'parent_type' => 1,
                'parent_id' => $blog_id,
                'path' => $images,
                'attachment_type' => 0,
                'status' => 0
                );
            $this->db->insert('attachment', $imageitem);
        }
    }
    return $update;
}

}

?>
