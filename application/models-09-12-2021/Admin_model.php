<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends CI_Model {
    
    
    public function verifyForgetPassword($data)
    {
        $this->db->where('user_id',$data['user_id']);
        $this->db->where('verification_type',$data['verification_type']);
        $this->db->where('verfication_code',$data['verfication_code']);
        $query = $this->db->get("verification");
        //echo $this->db->last_query();die;
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    
    public function updateVerificationStatus($id,$data)
    {
        $this->db->where('id',$id);
        $this->db->update("verification",$data);
        $this->db->query("UPDATE `verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
    }
    
    public function updateUserStatus($userID,$data)
    {
        $this->db->where('user_id',$userID);
        $this->db->update("user",$data);
    }
    
    public function allowedDomain($domain)
    {
        $this->db->where("config_key","domain_allowed_for_registration");
        $this->db->where("config_value",$domain);
        $this->db->where("is_enabled",1);
        $query = $this->db->get("configuration");
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function allowedEmail($email)
    {
        $this->db->where("config_key","email_allowed_for_registration");
        $this->db->where("config_value",$email);
        $this->db->where("is_enabled",1);
        $query = $this->db->get("configuration");
        if($query->num_rows() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function validate($email,$password)
    {
        $this->db->select("`id`,`user_id` , `email`,  `first_name`, `last_name`");
        $this->db->from('admin_user u');
        
        
        $this->db->where('u.status',1);
        $this->db->where('u.email',$email);
        $this->db->where('u.password', $password);
        $query = $this->db->get();
        
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    
    public function addToken($data)
    {
        $this->db->insert('user_token',$data);
    }
    
    public function getDetail($user_id)
    {
        $this->db->select("`user_id`, `email`, `first_name`, `last_name`");
        $this->db->where('user_id',$user_id);
        $query = $this->db->get('user');
        //echo $this->db->last_query();die;
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    
    public function getAdminDetail($user_id)
    {
        $this->db->select("u.user_id, u.email, u.first_name, u.last_name,a.role");
        $this->db->from("user u");
        $this->db->join("admin_user a","u.user_id = a.user_id");//
        $this->db->where('u.user_id',$user_id);
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        if($query->num_rows() == 1)
        {
            $dt= $query->result_array();
            return $dt[0];
        }
        else
        {
            return false;
        }
    }
    
    
    
    public function resetPassword($userID,$password)
    {
        $this->db->where('user_id',$userID);
        return $this->db->update('user',array('password'=> $password));
    }
}
