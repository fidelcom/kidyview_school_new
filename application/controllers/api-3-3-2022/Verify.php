<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {
    
    
    public function forgetPassword($code)
    {
        $decryptedCode = $this->settings->decryptString($code);
        $autoload['helper'] = array('url');
		if($decryptedCode == false)
        {
            echo "Invalid link.";
        }
        else
        {
            $codeData = explode("#",$decryptedCode);
			//print_r($codeData); die;
            $dataVerify = array(
                'verification_type'=>$codeData[0],
                'verfication_code'=>$codeData[1]
            );
            $this->load->model("user_model","user");
            
            $result = $this->user->verifyAdminForgetPassword($dataVerify);
            
            $currentDatetime = date("Y-m-d H:i:s");
            if($result->status == "Active" && $result->expiry_date > $currentDatetime)
            {
                $userDetail = $this->user->getAdminUser(1);
				//print_r($userDetail); die;
                $data['message'] = 'Welcome,'. $userDetail['full_Name'].'..';
                $data['success'] = False;
                
                if($this->input->post("submit")!="")
                {
                    $_POST = $this->security->xss_clean($_POST);
                    $this->form_validation->set_data($_POST);

                    $this->form_validation->set_rules('password', 'Password', 'trim|required');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
                    
                    $error = array();
                    if ($this->form_validation->run() === False) {
                        $data['error'] = $this->form_validation->error_array();                        
                    }
                    else
                    {
                        if($this->user->resetPassword(1,$this->input->post("password")))
                        {
                            $data['success'] = TRUE;
                            $data['message'] = "Your password updated successfuly. Please try <a href='".base_url()."administrator'>login</a>.";
                            $this->user->updateVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                        }
                    }
                    
                }
                                prd($data);
                $this->load->view('forgetPasswordForm',$data);
                
            }
            elseif ($result->status == "Active" && $result->expiry_date <= $currentDatetime) 
            {
                $this->load->view('mesageTemplate',array("message"=>"Verification failed, please try again."));
            }
            elseif ($result->status == "Success") 
            {
                $this->load->view('mesageTemplate',array("message"=>"This link is already used, please try again."));
            }
            
        
        }
        
        
    }
	
	public function forgetPasswordSchool($code)
    {
        $decryptedCode = $this->settings->decryptString($code);
        $autoload['helper'] = array('url');
		if($decryptedCode == false)
        {
            echo "Invalid link.";
        }
        else
        {
            $codeData = explode("#",$decryptedCode);
            $data['school_id'] =  $codeData[0];
            // prd($codeData);
			//print_r($codeData); die;
            $dataVerify = array(
                'user_id'=>$codeData[0],
                'verification_type'=>$codeData[1],
                'verfication_code'=>$codeData[2]
            );
            $this->load->model("user_model","user");
            
            $result = $this->user->verifySchoolForgetPassword($dataVerify);
            
            $currentDatetime = date("Y-m-d H:i:s");
            if($result->status == "Active" && $result->expiry_date > $currentDatetime)
            {
                $userDetail = $this->user->getSchoolDetails($codeData[0]);
				//print_r($userDetail); die;
                $data['message'] = 'Welcome,'. $userDetail->school_name.'..';
                $data['success'] = False;
                
                if($this->input->post("submit")!="")
                {
                    $_POST = $this->security->xss_clean($_POST);
                    $this->form_validation->set_data($_POST);

                    $this->form_validation->set_rules('password', 'Password', 'trim|required');
                    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
                    
                    $error = array();
                    if ($this->form_validation->run() === False) {
                        $data['error'] = $this->form_validation->error_array();                        
                    }
                    else
                    {
                        if($this->user->resetPasswordSchool($codeData[0],$this->input->post("password")))
                        {
                            $this->user->resetPasswordSchoolAdmin($codeData[0],$this->input->post("password"));
							
							$data['success'] = TRUE;
                            $data['message'] = "Your password updated successfuly. Please try <a href='".base_url()."schoollogin'>login</a>.";
                            $this->user->updateVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                        }
                    }
                    
                }
                  // prd($data);              
                $this->load->view('forgetPasswordForm',$data);
                
            }
            elseif ($result->status == "Active" && $result->expiry_date <= $currentDatetime) 
            {
                $this->load->view('mesageTemplate',array("message"=>"Verification failed, please try again."));
            }
            elseif ($result->status == "Success") 
            {
                $this->load->view('mesageTemplate',array("message"=>"This link is already used, please try again."));
            }
            
        
        }
        
        
    }
	
	public function signup($code)
    {
        $decryptedCode = $this->settings->decryptString($code);
        //echo $decryptedCode; die;
		if($decryptedCode == false)
        {
            echo "Invalid link.";
        }
        else
        {
            $codeData = explode("#",$decryptedCode);
			//print_r($codeData); die;
            $dataVerify = array(
                'user_id'=>$codeData[0],
                'verification_type'=>$codeData[1],
                'verfication_code'=>$codeData[2]
            );
			//print_r($dataVerify); die;
            $this->load->model("user_model","user");
            $result = $this->user->verifySchoolSignup($dataVerify);
            $currentDatetime = date("Y-m-d H:i:s");
            if($result->status == "Active" && $result->expiry_date > $currentDatetime)
            {
                $this->user->updateVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                $this->user->updateSchoolStatus($dataVerify['user_id'],array('is_email_verified'=>1));
                $this->user->updateSchoolStatusExtraInfo($dataVerify['user_id'],array('is_email_verified'=>1));
                $this->load->view('mesageTemplate',array("message"=>"Verification successful."));
                
            }
            elseif ($result->status == "Active" && $result->expiry_date <= $currentDatetime) 
            {
                $this->user->updateVerificationStatus($result->id,array("status"=>"Failed","updated_date"=>$currentDatetime));
                $this->load->view('mesageTemplate',array("message"=>"Verification failed, need to sign up again."));
            }
            elseif ($result->status == "Success") 
            {
                $this->user->updateVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                $this->load->view('mesageTemplate',array("message"=>"Already verified."));
            }
        }
    }
   public function passwordReset()
   {
    // echo $this->input->post("password"); die;
        if( empty($this->input->post("password")) && empty($this->input->post("confirm_password")) )
        {
            $this->session->set_flashdata('error','Password does not matched.');    
        
        }else{
         
            $school_id =  $this->input->post("school_id");
            $this->db->where('school_id', $school_id);
            $this->db->update('school_admin', array('password' => md5($this->input->post("password")) , 'is_email_verified' => '1' ));
            $this->session->set_flashdata('success','Password has been updated successfuly.');

                // if($this->user->resetPassword(1,$this->input->post("password")))
                // {
                //     $data['success'] = TRUE;
                //     $data['message'] = "Your password updated successfuly. Please try <a href='".base_url()."administrator'>login</a>.";
                //     $this->user->updateVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                // }
        }
    }
}
