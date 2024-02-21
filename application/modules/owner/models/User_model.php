<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

  public function checkAllPrivilege($roleid=''){
        $this->db->select('*');
        $this->db->from('admin_privilege');
        $this->db->where('role_id',$roleid);
        $query=$this->db->get();
        if($query->result_id->num_rows!=0)
			{
				$data_user1 = $query->result_array();
				for($v=0; $v<count($data_user1); $v++)
				{
                    $reindex=str_replace(array(' ','&'),'',$data_user1[$v]['module']);
                    if($data_user1[$v]['view']==1 OR $data_user1[$v]['add']== 1 OR  $data_user1[$v]['edit']== 1){
                        $data_user[$reindex]['module']= 1;
                    }else{
                        $data_user[$reindex]['module']= 0;
                    }
                    $data_user[$reindex]['view']= $data_user1[$v]['view'];
                    $data_user[$reindex]['add']= $data_user1[$v]['add'];
                    $data_user[$reindex]['edit']= $data_user1[$v]['edit'];
                    $data_user[$reindex]['delete']= $data_user1[$v]['delete'];
				}
				return $data_user;
			}
			else
			return false;

  }

}

