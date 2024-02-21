<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class SchoolSignup extends CI_Controller {

    
    public $schoolNotifyEmail = "";
    public $subscriptionNotifyEmail = "";
    public $fromEmail = "";
    public $schoolBaseLink = "";
  
    public function __construct() {

        parent::__construct();
        
      
       if($_SERVER['HTTP_HOST']=="www.chawtechsolutions.ch" || $_SERVER['HTTP_HOST']=="chawtechsolutions.ch") 
       {
          $this->fromEmail = "info@chawtechsolutions.com"; 
          $this->schoolNotifyEmail = "fashionista.4india@gmail.com";
          $this->subscriptionNotifyEmail = ""; 
          $this->schoolBaseLink = "https://chawtechsolutions.ch/kidyview"; 
          
       }
       else 
       { 
		 //$this->fromEmail = "admin@kidyview.com";
		 $this->fromEmail = "hello@kidyview.com"; 
         $this->schoolNotifyEmail = "hello@kidyview.com";
         $this->subscriptionNotifyEmail = "";  
         $this->schoolBaseLink = "https://kidyview.com/school";  
       }
        

    }

	public function index() {
		$pay=$this->addSchool();
		$data['paymentMessage']= 'Your subscription has been successfully added for signin on Kidyview. Please check your email to verify your email address.';
		$this->load->view('signup/paymentsuccess',$data);
	}
	public function updateFreeSubscription() {
		$pay=$this->updateSubscription();
		$data['paymentMessage']= 'Your subscription payment has been successfully.';
		if($this->session->userdata('user_role')=='school'){
		$this->session->set_flashdata('msg',$data['paymentMessage']);
		redirect('schooluser#!/subscribe');
		}else{
		$this->load->view('signup/paymentsuccess',$data);
		}
	}
    public function payment() {
	//echo '<pre/>';
	//print_r($this->session->all_userdata());die;
		$this->load->library('payment');
		//print_r($_POST);die;
        if($_POST['submit']){
			$subscriptionData=$this->subscriptionDetail($_POST['subscription_id']);
                        $currencyData = $this->getcurrency($_POST['hidden_currencycode']);
                       
				$refrence_num = 'tx_'.time();
				$redirect_url = base_url('SchoolSignup/paymentSuccess');
	                        $amount =  ($subscriptionData['amount']>0) ? $subscriptionData['amount']/$currencyData['currency_rate'] : $subscriptionData['amount'];
				if($this->session->userdata('user_role')=='school' OR (isset($_POST['hidden_school_id']) && $_POST['hidden_school_id']!='')){
					if(isset($_POST['hidden_school_id']) && $_POST['hidden_school_id']!=''){
					$getSchool=get_school($_POST['hidden_school_id']);
					$email =  $getSchool['email'];
					$name =   $getSchool['fname'].' '.$getSchool['lname'];
					$phone =  $getSchool['phone'];
					$sessionArray=array(
						'school_id'		=> $_POST['hidden_school_id'],
						'subscription_id'	=> $subscriptionData['id'],
                                                'currency_id'           => isset($_POST['hidden_currencycode']) ? $_POST['hidden_currencycode'] : ''
					);
					
					}else{
					$email =  $this->session->userdata('user_data')['email'];
					$name =   $this->session->userdata('user_data')['fname'].' '.$this->session->userdata('user_data')['lname'];
					$phone =   $this->session->userdata('user_data')['phone'];
						$sessionArray=array(
							'subscription_id'		=> $subscriptionData['id'],
                                                        'currency_id'           => isset($_POST['hidden_currencycode']) ? $_POST['hidden_currencycode'] : ''
						);
					}
					
					
				}else{
					$email =  $_POST['hidden_school_email'];
					$name =  $_POST['hidden_school_name'];
                    $countrycode =  $_POST['hidden_countrycode'];
					$phone =  $_POST['hidden_school_phone'];
					$bank_name =  $_POST['hidden_bank_name'];
					$account_number =  $_POST['hidden_account_number'];
					$sort_code =  $_POST['hidden_sort_code'];
					$password =  md5($_POST['hidden_school_password']);
					$sessionArray=array(
                        'country' 				=> $countrycode,
                        'currency_id' 				=> $currencyData['id'],
						'email' 				=> $email,
						'subscription_id'		=> $subscriptionData['id'],
						'school_name' 			=> $name,
						'phone' 				=> $phone,
						'bank_name' 			=> $bank_name,
						'account_number' 		=> $account_number,
						'sort_code' 			=> $sort_code,
						'password' 				=> $password,
						'status'				=>1,
                                                'created_date'                            =>date("Y-m-d H:i:s")
					);
					
				}
				
				$this->session->set_userdata('formdata',$sessionArray);
                                if($subscriptionData['type']=='Paid'){
				$postData = array(
					'tx_ref' 				=> $refrence_num,
					'amount' 				=> $amount,
					'currency' 				=> strtoupper($currencyData['currency_code']),
					"redirect_url"			=> $redirect_url,
					"payment_options" 		=> 'card',
					"meta"					=> array('Your Plan'=>$subscriptionData['name'],'School Name'=>$name),
					"customer"				=> array('email'=>$email,'phonenumber'=>$phone,'name'=>$name),
					//"subaccounts"			=> array('id'=>'RS_2ED60382E4DBA45C3820FC708A00D0A1','transaction_charge_type'=>'flat_subaccount','transaction_charge'=>'400'),
					"customizations"		=> array('title'=>'KidyView Plan Fee','description'=>'Plan subscription fee','logo'=>'https://chawtechsolutions.ch/kidyview/img/small_logo.png'),
				);
				$response = $this->payment->paymentProcess($postData);
				if($response->status == 'success')
				{
					return redirect($response->data->link);
				}else{
					echo "error".$response->status;
				}
			}else if($subscriptionData['type']=='Free'){
				if($this->session->userdata('user_role')=='school'){
					redirect('SchoolSignup/updateFreeSubscription');
				}else{
					redirect('SchoolSignup');
				}
			}
        }

    }
    
    public function paymentSuccess()
    {
	$data=array();
	$paymentData=array();
        $status = $this->input->get('status');
        $transaction_id = $this->input->get('transaction_id');
        $currencyID = $this->session->userdata('formdata')['currency_id'];
        $currencyData = $this->getcurrency($currencyID);
		
	if($status == 'successful' && !empty($transaction_id))
	{
            if (isset($_GET['tx_ref'])) {
                $ref = $_GET['tx_ref'];
				$transaction_id=$_GET['transaction_id'];
                $amount = ""; //Correct Amount from Server
                $currency = ""; //Correct Currency from Server
				$this->load->library('payment');
				$paymentresponse = $this->payment->payment_verify($transaction_id);
				//print_r($paymentresponse);die;
                if($paymentresponse['status']=='success'){
				
				if($this->session->userdata('user_role')=='school'){
					$payData=$this->updateSubscription();
				}else{ 
					$payData=$this->addSchool();
				}
					$payData=explode('____',$payData);
					$paymentData['transaction_id'] = $paymentresponse['data']['id'];
					$paymentData['user_id'] = "S-".$payData[0];
					$paymentData['plan_id'] = $payData[1];
					$paymentData['tx_ref'] = $paymentresponse['data']['tx_ref'];
					$paymentData['amount'] = $paymentresponse['data']['amount'];
					$paymentData['currency'] = $paymentresponse['data']['currency'];
                                        $paymentData['currency_rate'] = $currencyData['currency_rate'];
                                        $paymentData['currency_log'] = serialize($currencyData);
					$paymentData['payment_type'] = "School Subscription";
					$paymentData['payment_date'] = date('Y-m-d H:i:s');
					$paymentData['last_date'] = date('Y-m-d H:i:s');
					$paymentData['status'] = $paymentresponse['data']['status'];
					$this->db->insert('payment',$paymentData);
				}
            }
			if($this->session->userdata('user_role')=='school'){
				redirect('schooluser#!/subscribe');
			}
                        elseif(isset($this->session->userdata('formdata')['school_id']) && $this->session->userdata('formdata')['school_id']!=''){
				echo "zxc";die; 
				$data['paymentMessage']= 'Your subscription payment has been successfully.';
				 $this->load->view('signup/paymentsuccess',$data);
			}
                        else{
			$data['paymentMessage']= 'Your subscription payment has been success for signin on Kidyview. Please check your email to verify your email address.';
			$this->load->view('signup/paymentsuccess',$data);
			//die;
			}
                        
                        if(isset($this->session->userdata('formdata')['subscription_id']))
                        $this->session->unset_userdata('formdata')['subscription_id'];
                        
                        if(isset($this->session->userdata('formdata')['school_id']))
                        $this->session->unset_userdata('formdata')['school_id'];
			
		}else{
			$data['paymentMessage']= 'Your subscription payment has been failed. Please try again.';
			$this->session->set_flashdata('error',$data['paymentMessage']);
		}
	}
	protected function addSchool(){
			$formdata=$this->session->userdata('formdata');
			//print_r($formdata);die;
			if(!empty($formdata)){
                        //unset($formdata['currency_id']);    
			$this->db->insert('school',$formdata);
			if($this->db->affected_rows()==1){
			$schoolData=array();
			$last_id=$this->db->insert_id();
			$schoolData['school_id']=$last_id;
			$schoolData['email']=$this->session->userdata('formdata')['email'];
			$schoolData['fname']=$this->session->userdata('formdata')['school_name'];
			$schoolData['password']=$this->session->userdata('formdata')['password'];
			$schoolData['status']=1;
			$this->db->insert('school_admin',$schoolData);
			$this->load->helper('team');
			$verificationKey = generateString(15);
			$currentDateTime = date("Y-m-d H:i:s");
			$datetime = new DateTime($currentDateTime);
			$datetime->modify('+6 month');
			$expieryDateTime = $datetime->format('Y-m-d H:i:s');
			$verificationCode = $last_id . "#Signup#" . $verificationKey;
			$dt['encryptedCode'] = $this->settings->encryptString($verificationCode);

			$dataVerifiction = array(
			"user_id" => $last_id,
			"verification_type" => "Signup",
			"verfication_code" => $verificationKey,
			"status" => "Active",
			"retry_count" => 0,
			"expiry_date" => $expieryDateTime,
			"created_date" => $currentDateTime,
			);
			$this->db->insert("verification", $dataVerifiction);
			$message = $this->load->view('signupMailTemplate', $dt, true);
			$mailResponse = $this->sendMail($this->session->userdata('formdata')['email'], "KidyView School Registration", $message);
			$subscriptionData=$this->subscriptionDetail($this->session->userdata('formdata')['subscription_id']);
                        
                        ################# Send Notification Email To Admin For New School Registration  ###################
                        $notifyContent= "";
                        $loginLink = $this->schoolBaseLink.'/index.php/schoolLogin';
                        $notifyContent  ='<h3>Hello KidyView Admin,</h3>';
                        $notifyContent .= '<p>New user has registered on your website</p>';
                        $notifyContent .= '<p>Name : '.$schoolData['fname'].'</p>';
                        $notifyContent .= '<p>Email address : '.$schoolData['email'].'</p>';
                        $notifyContent .= '<p>Please Login to view more details : <a href="'.$loginLink.'">'.$loginLink.'</a></p>';
                        $notifymailResponse = $this->sendMail($this->schoolNotifyEmail, "KidyView School Registration", $notifyContent);
                        ################# Send Notification Email To Admin For New School Registration ###################
                        
                         $currencyID = $this->session->userdata('formdata')['currency_id'];
                         $currencyData = $this->getcurrency($currencyID);
                         $currency = $currencyData['currency_code'];
                         $currency_rate = $currencyData['currency_rate'];
                         $newAmount = ($subscriptionData['amount']>0) ? $subscriptionData['amount']/$currency_rate : $subscriptionData['amount'];
                        
			if($subscriptionData['validity']='Quarterly'){
			$month='+3 month';
			$days='90';
			}
			if($subscriptionData['validity']='Monthly'){
			$month='+1 month';
			$days='30';
			}
			if($subscriptionData['validity']='Yearly'){
			$month='+12 month';
			$days='365';
			}
			$datetime = new DateTime($currentDateTime);
			$datetime->modify($month);
			$endTime = $datetime->format('Y-m-d H:i:s');
			$subscriptionArr=array();
				$subscriptionArr=array(
					'school_id'=>$last_id,
					'subscription_id'=>$subscriptionData['id'],
					'name'=>$subscriptionData['name'],
					'type'=>$subscriptionData['type'],
					'validity'=>$subscriptionData['validity'],
					'no_of_student'=>$subscriptionData['no_of_student'],
					'days'=>$days,
					//'currency'=>$subscriptionData['currency'],
					//'amount'=>$subscriptionData['amount'],
                                        'currency'=>$currency,
					'amount'=>$newAmount,
					'description'=>$subscriptionData['description'],
					'feature'=>json_encode($subscriptionData['featureData']),
					'start_date'=>$currentDateTime,
					'end_date'=>$endTime,
                                        'created_date' => $currentDateTime,
					'status'=>'Active'
				);
				$this->db->insert('school_subscription',$subscriptionArr);
				
			}
		}else{
			redirect('schoollogin/signup');
		}
		@$this->session->unset_userdata('formdata')['email'];
		@$this->session->unset_userdata('formdata')['subscription_id'];
		@$this->session->unset_userdata('formdata')['school_name'];
		@$this->session->unset_userdata('formdata')['bank_name'];
		@$this->session->unset_userdata('formdata')['account_number'];
		@$this->session->unset_userdata('formdata')['sort_code'];
		@$this->session->unset_userdata('formdata')['phone'];
		@$this->session->unset_userdata('formdata')['password'];
		@$this->session->unset_userdata('formdata')['status'];
		return $last_id.'____'.$subscriptionData['id'];
	}
	function updateSubscription(){
			$formdata=$this->session->userdata('formdata');
			if(!empty($formdata)){
			$school_id=$this->session->userdata('user_data')['school_id']?$this->session->userdata('user_data')['school_id']:$this->session->userdata('formdata')['school_id'];
			$subscription_id=$this->session->userdata('formdata')['subscription_id'];
                        $this->db->limit(1);		
			$this->db->where("school_id",$school_id);	
			$this->db->order_by("id",'DESC');		
			$this->db->where("status",'Active');
			$query = $this->db->get("school_subscription");
		
			if($query->num_rows() > 0)
			{
			$result=$query->result_array();		
			$updateArr=array('status'=>'Expire');
			$this->db->where('id',$result[0]['id']);
			$this->db->update('school_subscription',$updateArr);
			}
			else
			{
			//return array();
			}
			$subscriptionData=$this->subscriptionDetail($subscription_id);
			
		
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
                         $currencyID = $this->session->userdata('formdata')['currency_id'];
                         $currencyData = $this->getcurrency($currencyID);
                         $currency = $currencyData['currency_code'];
                         $currency_rate = $currencyData['currency_rate'];
                         $newAmount = ($subscriptionData['amount']>0) ? $subscriptionData['amount']/$currency_rate : $subscriptionData['amount'];
                        
				$subscriptionArr=array(
					'school_id'=>$school_id,
					'subscription_id'=>$subscriptionData['id'],
					'name'=>$subscriptionData['name'],
					'type'=>$subscriptionData['type'],
					'validity'=>$subscriptionData['validity'],
                                        'no_of_student'=>$subscriptionData['no_of_student'],
					'days'=>$days,
					//'currency'=>$subscriptionData['currency'],
					//'amount'=>$subscriptionData['amount'],
                                        'currency'=>$currency,
					'amount'=>$newAmount,
					'description'=>$subscriptionData['description'],
					'feature'=>json_encode($subscriptionData['featureData']),
					'start_date'=>$currentDateTime,
					'end_date'=>$endTime,
                                        'created_date' => $currentDateTime,
					'status'=>'Active'
				);
				$this->db->insert('school_subscription',$subscriptionArr);
				$schoolArr=array('subscription_id'=>$subscriptionData['id']);
				$this->db->where('id',$school_id);
				$this->db->update('school',$schoolArr);
		
		}else{
			redirect('schooluser');
		}
		if($this->session->userdata('user_role')=='school'){
		$data['is_logged_in'] = true;
		$data['user_role'] =  $this->session->userdata('user_role');
		$data['user_data'] =  get_school($school_id);
        $this->session->set_userdata($data);
		}
		return $school_id.'____'.$subscriptionData['id'];
	}
	
    public function subscriptionDetail($id='')
    {
        $this->db->where("id",$id);
        $this->db->order_by("type");
        $query = $this->db->get("subscription");
        if($query->num_rows() > 0)
        {
            $data=$query->result_array();
            for($i=0;$i<count($data);$i++){
            $featureData=$this->feature_list($data[$i]['id']);
            $data[$i]['featureData']=$featureData;
            }
            return $data[0];
        }
        else
        {
            return array();
        }
    }
    public function feature_list($subscription_id=''){
        $this->db->where("subscription_id",$subscription_id);
        //$this->db->where("is_enable","1");
        $query = $this->db->get("subscription_feature");  
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }
	private function sendMail($to, $subject, $message) {
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$this->fromEmail.'' . "\r\n";
        return mail($to, $subject, $message, $headers);
    }
    
    public function getcurrency($currencyID)
    {
          $curData = array(); 
          $this->db->select("*");
          $this->db->where('id',$currencyID);
          $query = $this->db->get('admin_currency'); 
           
        if($query->num_rows() > 0) 
        {
         $curData  = json_decode(json_encode($query->row()), true); 
        }
        return $curData;
    }

}

