<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription_model extends CI_Model {
    public function data($school_id,$subscription_id)
    {		$subscriptionArray=array();		
			$this->db->limit(1);		
			$this->db->where("school_id",$school_id);		
			$this->db->where("subscription_id",$subscription_id);		
			$this->db->where("status",'Active');
			$this->db->order_by("id",'DESC');		
			$this->db->where("status",'Active');
			$query = $this->db->get("school_subscription");
			
        if($query->num_rows() > 0)
        {
            $result=$query->result_array();			
			$result=$result[0];	
            $result['id']=$result['subscription_id'];
            $result['feature']=json_decode($result['feature']);
			array_push($subscriptionArray,$result);
        }
       		
		/*if(!empty($subscriptionArray)){		
		$this->db->where_not_in("id",$subscriptionArray[0]['subscription_id']);		
		}*/		
		$this->db->where("status",'1');        
		$query = $this->db->get("subscription"); 
		if($query->num_rows() > 0) {            
			$result=$query->result_array();			
			for($i=0;$i<count($result);$i++){	
             $featureData=$this->feature_list($result[$i]['id']);
             $result[$i]['feature']=$featureData;			
			array_push($subscriptionArray,$result[$i]);			
			}
			
		}	
		return $subscriptionArray;
    }
    public function feature_list($subscription_id=''){
        if($subscription_id!=''){
            $this->db->where("subscription_id",$subscription_id);
            $query = $this->db->get("subscription_feature");  
        }else{ 
            $query = $this->db->get("school_permission_module");
        }
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
    public function detail($id='')
    {
        $this->db->where("id",$id);
        $query = $this->db->get("subscription");
        if($query->num_rows() > 0)
        {
            $data=$query->result_array();
            $featureData=$this->feature_list($id);
            $data[0]['featureData']=$featureData;
            return $data[0];
        }
        else
        {
            return array();
        }
    }
    public function add($data)
    {
        $this->db->insert("subscription",$data);
        if($this->db->affected_rows() == 1)
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    public function update_batch($data,$tbl_name,$where=array())
    {
        
        $this->db->update_batch($tbl_name,$data,'id');
        return true;
    }
    public function insert_batch($data,$table_name='')
    {
        $this->db->insert_batch($table_name,$data);
        if($this->db->affected_rows())
        {
            return $this->db->insert_id();
        }
        else
        {
            return false;
        }
    }
    public function update($data,$where)
    {
        $this->db->where($where);
        $this->db->update("subscription",$data);
        if($this->db->affected_rows() == 1)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function delete($where=array())
    {
        $this->db->where($where);
        $query = $this->db->delete("subscription");
        return $query;
    }
    
}
