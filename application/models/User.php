<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model {

    
	public function getUser($queryParameters)
	{
            $this->db->where($queryParameters);
            $this->db->where('active',1);
          
            $query =  $this->db->get('ics_admin');
			if($query->result_id->num_rows==1)
            {
                $data_user = $query->result_array();
                return $data_user[0];
            }
            else
		return false;
	}
	
	public function getSubAdminUser($queryParameters)
	{
            $this->db->where($queryParameters);
            $this->db->where('status',1);
            $query =  $this->db->get('admin_subadmin');
			if($query->result_id->num_rows==1)
            {
                $data_user = $query->result_array();
                return $data_user[0];
            }
            else
		return false;
	}
	
	
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */