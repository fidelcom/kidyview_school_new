<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Scheduler extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/scheduler_model");
    }
    
    public function schoolType_get() {       	
        $res = $this->scheduler_model->schoolTypeList();  
        $return['success'] = "true";
        $return['message'] = "School Type List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }    
    
    public function index_get() {       	
        $res = $this->scheduler_model->data();        
         // prd($res);
        $return['success'] = "true";
        $return['message'] = "Scheduler List.";
        $return['error'] = "";
        $return['data'] = $res;
        //$schoolDetail 	= $this->session->all_userdata();
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function details_post() { 

            $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $scheduleID = $postData['scheduleID'];
            $result = $this->scheduler_model->detail($scheduleID);  
           // prd($result);
            if ($result) {
                $return['success'] = "true";
                $return['message'] = "Class Schedule found.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Not found.";
                $return['error'] = $this->error;
                $return['data'] = '';
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
        $return['success'] = "true";
        $return['message'] = "Class Schedule Detail.";
        $return['error'] = "";
        $return['data'] = $res;
        //$schoolDetail 	= $this->session->all_userdata();
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function index_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
      // prd($postData);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('school_type', 'School Type', 'trim|required');
        $this->form_validation->set_rules('no_periods', 'No periods', 'trim|required');
        // $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');
        // $this->form_validation->set_rules('end_time', 'End Time', 'trim|required');
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        }
        else
        {
            $schoolDetail 	= $this->session->all_userdata();
            if($this->session->userdata('user_role')=='admin' || $this->session->userdata('user_role')=='schoolsubadmin'){
                $schoolID 	= $schoolDetail['user_data']['school_id']; 
            }elseif($this->session->userdata('user_role')=='school'){
                $schoolID 	= $schoolDetail['user_data']['id'];
            }

             $data = array(
                "school_type"=>$postData['school_type'],
                "no_periods"=>$postData['no_periods'],
                "school_id"=>$postData['school_id'],
                "created_at"=>date('Y-m-d H:i:s')
            );
             $id = $this->scheduler_model->add($data);
             // prd($id);
             if($id == 'exist'){
                $return['success'] = "true";
                $return['message'] = "School type have already schedule. Please check.";
                $return['error'] = $this->error;
                $return['data'] = $id;
                $this->response($return, REST_Controller::HTTP_OK);
             }else if($id)
             {
                $arrList = $postData['scheduleTime'];
                for($i=0; $i < count($arrList);$i++)
                {
                    unset($arrList[$i]['start_level']);
                    unset($arrList[$i]['end_level']);
                    // unset($arrList[$i]['lecture_name']);
                   
                    $arrList[$i]['schedule_id']  = $id;
                    $arrList[$i]['school_id']    = $postData['school_id'];
                    $arrList[$i]['start_time']   = $arrList[$i]['start_time'];
                    $arrList[$i]['end_time']     = $arrList[$i]['end_time'];
                    $arrList[$i]['name']         = $arrList[$i]['name'];
                }
                // prd($arrList);
                $this->scheduler_model->addDetail($arrList);
                $return['success'] = "true";
                $return['message'] = "Schedule Added Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = '';
                $this->response($return, REST_Controller::HTTP_OK);
             }
             else
             {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
             }
        }               
    }
    public function index_put() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('school_type', 'School Type', 'trim|required');
        $this->form_validation->set_rules('from_date', 'From Date', 'trim|required');
        $this->form_validation->set_rules('to_date', 'To Date', 'trim|required');
        
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $schoolDetail 	= $this->session->all_userdata();
            if($this->session->userdata('user_role')=='admin' || $this->session->userdata('user_role')=='schoolsubadmin'){
                $schoolID 	= $schoolDetail['user_data']['school_id']; 
            }elseif($this->session->userdata('user_role')=='school'){
                $schoolID 	= $schoolDetail['user_data']['id'];
            }
            $arrList = $postData['detailList'];
                
            if(count($arrList) > 0)
            {
                $arrList = $postData['detailList'];
                
                foreach($arrList as $detail)
                {
                    $this->db->where('id',$detail['id']);
                    $tmp = array(
                        "breakfast"=>$detail['breakfast'],
                        "snacks"=>$detail['snacks'],
                        "meal"=>$detail['meal']
                    );
                    $this->db->update('meal_planner_detail',$tmp);
                }
                
                
                $return['success'] = "true";
                $return['message'] = "Meal Plan Updated Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = '';
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }               
    }
    public function deleteSchedule_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            $id = $postData['id'];
            $result = $this->scheduler_model->deleteSchedule($id);
            //print_r($result); die;
            if ($result) {
                $return['success'] = "True";
                $return['message'] = "Schedule deleted successfully.";
                $return['data'] = $result;
                $return['error'] = $this->error;
                
                $this->response($return, REST_Controller::HTTP_OK);
                } else {
                $return['success'] = "false";
                $return['message'] = "Something went wrong.";
                $return['error'] = $this->error;
                $return['data'] = $result;
                
                $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
            }
    }
    public function editSchedule_post()
    {
         $postData = json_decode(file_get_contents('php://input'), true);
            if ($postData == '') {
                $postData = $_POST;
            }
            // prd($postData);
            $schoolDetail   = $this->session->all_userdata();
            if($this->session->userdata('user_role')=='admin' || $this->session->userdata('user_role')=='schoolsubadmin'){
                $schoolID   = $schoolDetail['user_data']['school_id']; 
            }elseif($this->session->userdata('user_role')=='school'){
                $schoolID   = $schoolDetail['user_data']['id'];
            }

             $arrList = $postData['updatedTime'];
             $schedule_id = $postData['schedule_id'];
             $updateArr = [];
                for($i=0; $i < count($arrList);$i++)
                {
                     unset($arrList[$i]['start_time']);
                     unset($arrList[$i]['end_time']);

                    // $updateArr[$i]['schedule_id']  = $schedule_id;
                    // $updateArr[$i]['school_id']    = $schoolID;
                    $updateArr[$i]['period_id']   = $arrList[$i]['period_id'];
                    $updateArr[$i]['start_time']   = $arrList[$i]['startTime'];
                    $updateArr[$i]['end_time']     = $arrList[$i]['endTime'];
                    $updateArr[$i]['name']         = $arrList[$i]['name'];
                }
                // prd($updateArr);
                 $result = $this->scheduler_model->updateSchedule($updateArr);
                if ($result) {
                    $return['success'] = "True";
                    $return['message'] = "Schedule Updated successfully.";
                    $return['data'] = $result;
                    $return['error'] = $this->error;
                    $this->response($return, REST_Controller::HTTP_OK);
                } else {
                    $return['success'] = "false";
                    $return['message'] = "Something went wrong.";
                    $return['error'] = $this->error;
                    $return['data'] = $result;
                    $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
                }
     }
    public function dateRange_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->load->helper("team");
        $res = getDaysBetweenDate($postData['from_date'], $postData['to_date']);
        //
        //Remove Holidays from date
        //
        
        $this->response($res, REST_Controller::HTTP_OK);
    }

}
