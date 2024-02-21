<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller {

    public function forgetPasswordTeacher($code)
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
            $dataVerify = array(
                'user_id'=>$codeData[0],
                'verification_type'=>$codeData[1],
                'verfication_code'=>$codeData[2]
            );
            $this->load->model("teachers/Teacher_model","teacher");
            $result = $this->teacher->verifyTeacherForgetPassword($dataVerify);
            
            $currentDatetime = date("Y-m-d H:i:s");
            if($result->status == "Active" && $result->expiry_date > $currentDatetime)
            {
                $userDetail = $this->teacher->getTeacherDetails($codeData[0]);
				//print_r($userDetail); die;
                $data['message'] = 'Welcome,'. $userDetail->teacherfname.' '.$userDetail->teachermname.' '.$userDetail->teacherlname.'..';
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
                        if($this->teacher->resetPasswordTeacher($codeData[0],$this->settings->encryptString($this->input->post("password"))))
                        {
							$data['success'] = TRUE;
                            $data['message'] = "Your password updated successfuly. Please try <a href='".base_url()."teacherlogin'>login</a>.";
                            $this->teacher->updateTeacherVerificationStatus($result->id,array("status"=>"Success","updated_date"=>$currentDatetime));
                        }
                    }
                    
                }           
                $this->load->view('forgetPasswordTeacherForm',$data);
                
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

}
