<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class SubscriptionAmount_model extends CI_Model {

    function addFeesSubscription($postData)
    {
        $postData['created_by'] = $postData['school_id'];
        $postData['created_at'] = date('Y-m-d H:i:s');
        // prd($postData);
        $this->db->insert("fee_suscription_amount",$postData);
        if($this->db->affected_rows() == 1)
            return $this->db->insert_id();
        else
            return false;
    }
    function feeSuscriptionList($postData)
    {
        $this->db->select('sa.*,st.name as school_type, CONCAT(c.class, " ",c.section) as class');
        $this->db->from('fee_suscription_amount as sa');
        $this->db->join('schooltype as st', 'st.value = sa.school_type','inner');
        $this->db->join('class as c', 'c.id = sa.class_id','inner');
        $this->db->where([ "sa.school_id"=>$postData['school_id'], 'sa.status'=>'1' ]);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
            return  $query->result();
        else
            return false;
    }
    function subscriptionAmountDelete($postData)
    {
         $this->db->where('id',$postData['id'])->delete('fee_suscription_amount');
         return $this->db->affected_rows() ? 1 : 0 ;
    }
}

