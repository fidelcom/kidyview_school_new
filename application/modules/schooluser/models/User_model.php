<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

  public function checkAllPrivilege($roleid=''){
        $this->db->select('*');
        $this->db->from('school_privilege');
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

  public function school_access($school_id='',$subscription_id=''){
    $date=date('Y-m-d H:i:s');
    $this->db->select('feature');
    $this->db->from('school_subscription');
    $this->db->where('school_id',$school_id);
    $this->db->where('start_date <=',$date);
    $this->db->where('end_date >=',$date);
    $this->db->where('status','Active');
    $this->db->order_by('id','DESC');
    $query=$this->db->get();
   // echo $this->db->last_query(); die;
    if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            $fetureData = json_decode($data_user[0]['feature'],true);
           
            for($v=0; $v<count($fetureData); $v++)
				{
                $reindex=str_replace(array(' ','&'),'',$fetureData[$v]['module_name']);
                $data_user[0]['feture_data'][$reindex]['module']= $fetureData[$v]['is_enable'];
                //$data_user[0]['feture_data'][$reindex]['module']= 1;   
                }
                //prd($data_user[0]['feture_data']);
             return $data_user[0]['feture_data'];
        }else{
            return array();
        }

}
public function checkParentExist($parentData=array()){
    $date=date('Y-m-d H:i:s');
    $this->db->select('*');
    $this->db->from('parent');
    $this->db->where('schoolId',$parentData['schoolId']);
    if($parentData['fatheremail']!=''){
    $this->db->where('fatheremail',$parentData['fatheremail']);
    }if($parentData['fatherphone']!=''){
    $this->db->or_where('fatherphone',$parentData['fatherphone']);
    }if($parentData['motheremail']!=''){
    $this->db->or_where('motheremail',$parentData['motheremail']);
    }if($parentData['motherphone']!=''){
    $this->db->or_where('motherphone',$parentData['motherphone']);
    }
    $query=$this->db->get();
    if($query->num_rows()>0)
	{
        return $query->row_array();
    }else{
        return array();
    }
}

public function checkChildExist($childData=array()){
    $this->db->select('*');
    $this->db->from('child');
    $this->db->where('schoolId',$childData['schoolId']);
    $this->db->where('parent_id',$childData['parent_id']);
    $this->db->where('childfname',$childData['childfname']);
    $this->db->where('childlname',$childData['childlname']);
    $this->db->where('childdob',$childData['childdob']);
    $query=$this->db->get();
    return $query->num_rows();
}

}

