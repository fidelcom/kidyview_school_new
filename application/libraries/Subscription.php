<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subscription {
    public function __construct()
    {
           $this->CI =& get_instance();
    }
    
    public function check_subscription($school_id,$subscription_id)
    {
		$curr_date=strtotime(date('Y-m-d H:i:s'));
		$this->CI->db->select("id,type,end_date");
		$this->CI->db->where('school_id', $school_id);
		//$this->CI->db->where('subscription_id', $subscription_id);
		$this->CI->db->where('status','Active');
		$this->CI->db->order_by('id','DESC');
		$this->CI->db->limit(1);
		$data=$this->CI->db->get('school_subscription');
		//echo $this->CI->db->last_query();die;
		$result=$data->row_array();
		if(!empty($result)){
			$endDate=strtotime($result['end_date']);
			if($endDate<=$curr_date){
				$where=array('id'=>$result['id']);
				$updateData=array('status'=>'Expire');
				$this->CI->db->where($where);
				$this->CI->db->update('school_subscription',$updateData);
				$this->CI->db->select("*");
		$this->CI->db->where('type','Free');
		$this->CI->db->where('status','1');
		$this->CI->db->limit(1);
		$query=$this->CI->db->get('subscription');
		$subscriptionData =$query->row_array();
		$featureData=$this->feature_list($subscriptionData['id']);
		$subscriptionData['featureData']=$featureData;
		if($subscriptionData['validity']=='Quarterly'){
			$month='+3 month';
			$days='90';
			}
			if($subscriptionData['validity']=='Monthly'){
			$month='+1 month';
			$days='30';
			}
			if($subscriptionData['validity']=='Yearly'){
			$month='+12 month';
			$days='365';
			}
			$currentDateTime = date("Y-m-d H:i:s");
			$datetime = new DateTime($currentDateTime);
			$datetime->modify($month);
			$endTime = $datetime->format('Y-m-d H:i:s');
		$subscriptionArr=array(
			'school_id'=>$school_id,
			'subscription_id'=>$subscriptionData['id'],
			'name'=>$subscriptionData['name'],
			'type'=>$subscriptionData['type'],
			'validity'=>$subscriptionData['validity'],
			'days'=>$days,
			'currency'=>$subscriptionData['currency'],
			'amount'=>$subscriptionData['amount'],
			'description'=>$subscriptionData['description'],
			'feature'=>json_encode($subscriptionData['featureData']),
			'start_date'=>$currentDateTime,
			'end_date'=>$endTime,
			'status'=>'Active'
		);
		$this->CI->db->insert('school_subscription',$subscriptionArr);
		$schoolArr=array('subscription_id'=>$subscriptionData['id']);
		$this->CI->db->where('id',$school_id);
		$this->CI->db->update('school',$schoolArr);
		$datas['is_logged_in'] = true;
		$datas['user_role'] =  $this->CI->session->userdata('user_role');
		$datas['user_data'] =  get_school($school_id);
		$this->CI->session->set_userdata($datas);
		return 2;	
					
			}else{
				return 1;
			}
		}else{
			$this->CI->db->select("*");
		$this->CI->db->where('type','Free');
		$this->CI->db->where('status','1');
		$this->CI->db->limit(1);
		$query=$this->CI->db->get('subscription');
		$subscriptionData =$query->row_array();
		$featureData=$this->feature_list($subscriptionData['id']);
		$subscriptionData['featureData']=$featureData;
		if($subscriptionData['validity']=='Quarterly'){
			$month='+3 month';
			$days='90';
			}
			if($subscriptionData['validity']=='Monthly'){
			$month='+1 month';
			$days='30';
			}
			if($subscriptionData['validity']=='Yearly'){
			$month='+12 month';
			$days='365';
			}
			$currentDateTime = date("Y-m-d H:i:s");
			$datetime = new DateTime($currentDateTime);
			$datetime->modify($month);
			$endTime = $datetime->format('Y-m-d H:i:s');
		$subscriptionArr=array(
			'school_id'=>$school_id,
			'subscription_id'=>$subscriptionData['id'],
			'name'=>$subscriptionData['name'],
			'type'=>$subscriptionData['type'],
			'validity'=>$subscriptionData['validity'],
			'days'=>$days,
			'currency'=>$subscriptionData['currency'],
			'amount'=>$subscriptionData['amount'],
			'description'=>$subscriptionData['description'],
			'feature'=>json_encode($subscriptionData['featureData']),
			'start_date'=>$currentDateTime,
			'end_date'=>$endTime,
			'status'=>'Active'
		);
		$this->CI->db->insert('school_subscription',$subscriptionArr);
		$schoolArr=array('subscription_id'=>$subscriptionData['id']);
		$this->CI->db->where('id',$school_id);
		$this->CI->db->update('school',$schoolArr);
		$datas['is_logged_in'] = true;
		$datas['user_role'] =  $this->CI->session->userdata('user_role');
		$datas['user_data'] =  get_school($school_id);
		$this->CI->session->set_userdata($datas);
		return 2;
		}
    }
	public function add_subscription($school_id){
		$this->CI->db->select("*");
		$this->CI->db->where('type','Free');
		$this->CI->db->where('status','1');
		$this->CI->db->limit(1);
		$query=$this->CI->db->get('subscription');
		$subscriptionData =$query->row_array();
		$featureData=$this->feature_list($subscriptionData['id']);
		$subscriptionData['featureData']=$featureData;
		if($subscriptionData['validity']=='Quarterly'){
			$month='+3 month';
			$days='90';
			}
			if($subscriptionData['validity']=='Monthly'){
			$month='+1 month';
			$days='30';
			}
			if($subscriptionData['validity']=='Yearly'){
			$month='+12 month';
			$days='365';
			}
			$currentDateTime = date("Y-m-d H:i:s");
			$datetime = new DateTime($currentDateTime);
			$datetime->modify($month);
			$endTime = $datetime->format('Y-m-d H:i:s');
		$subscriptionArr=array(
			'school_id'=>$school_id,
			'subscription_id'=>$subscriptionData['id'],
			'name'=>$subscriptionData['name'],
			'type'=>$subscriptionData['type'],
			'validity'=>$subscriptionData['validity'],
			'days'=>$days,
			'currency'=>$subscriptionData['currency'],
			'amount'=>$subscriptionData['amount'],
			'description'=>$subscriptionData['description'],
			'feature'=>json_encode($subscriptionData['featureData']),
			'start_date'=>$currentDateTime,
			'end_date'=>$endTime,
			'status'=>'Active'
		);
		$this->CI->db->insert('school_subscription',$subscriptionArr);
		$schoolArr=array('subscription_id'=>$subscriptionData['id']);
		$this->CI->db->where('id',$school_id);
		$this->CI->db->update('school',$schoolArr);
		$datas['is_logged_in'] = true;
		$datas['user_role'] =  $this->CI->session->userdata('user_role');
		$datas['user_data'] =  get_school($school_id);
		$this->CI->session->set_userdata($datas);
		return 2;
	}
	 public function feature_list($subscription_id=''){
        $this->CI->db->where("subscription_id",$subscription_id);
        $query = $this->CI->db->get("subscription_feature");  
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
  
}



