<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of module_model
 *
 * @author soarmorrow
 */
class role_model extends MY_Model{
    //put your code here
    
    public function __construct() {
        parent::__construct();
    }
    public function getRoleModules($id) {
        $roles=$this->db->select('*')
                ->get('role')
                ->result();
        $returnarray=array();
        foreach ($roles as $array){
        $modules=$this->db->select('m.*')
                ->from('modules m')
                ->join('role_module rm','rm.module_id=m.id')
                ->where('rm.role_id',$array->id)
                ->distinct('m.id')
                ->get('role')
                ->result();
            array_push($returnarray, array('roles'=>$array,'module'=>$modules));
        }
        return $returnarray;
//        debug($returnarray);
    }
}
