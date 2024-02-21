<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class MealPlanner extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/mealplanner_model");
    }
    
    public function schoolType_get() {       	
        $res = $this->mealplanner_model->schoolTypeList();        
        $return['success'] = "true";
        $return['message'] = "School Type List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($res, REST_Controller::HTTP_OK);
    }    
    
    public function index_get() {       	
        $res = $this->mealplanner_model->data();        
        $return['success'] = "true";
        $return['message'] = "Home Meal List.";
        $return['error'] = "";
        $return['data'] = $res;
        //$schoolDetail 	= $this->session->all_userdata();
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function detail_get() {       	
        $res = $this->mealplanner_model->detail();        
        $return['success'] = "true";
        $return['message'] = "Home Meal Detail.";
        $return['error'] = "";
        $return['data'] = $res;
        //$schoolDetail 	= $this->session->all_userdata();
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function index_post() {       	
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
            $data = array(
                "school_type"=>$postData['school_type'],
                "from_date"=>$postData['from_date'],
                "to_date"=>$postData['to_date'],
                "school_id"=>$schoolID
            );
            
            $id = $this->mealplanner_model->add($data);
            
            if($id)
            {
                $arrList = $postData['detailList'];
                
                for($i=0; $i < count($arrList);$i++)
                {
                    $arrList[$i]['meal_planner_id'] = $id;
                    $arrList[$i]['school_id'] = $schoolID;
                    $arrList[$i]['school_type'] = $postData['school_type'];
                }
                
                $this->mealplanner_model->addDetail($arrList);
                $return['success'] = "true";
                $return['message'] = "Meal Plan Added Successfuly.";
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
    public function dateRange_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $this->load->helper("team");
        $res = getDaysBetweenDate($postData['from_date'], $postData['to_date']);
        //
        //Remove Holidays from date
        //
        
        $this->response($res, REST_Controller::HTTP_OK);
    }
    
    public function deleteList_post() {
	$postData = json_decode(file_get_contents('php://input'), true);
	if ($postData == '') {
		$postData = $_POST;
	}
	$id = $postData['id'];
	$where=array(
	'id'=>$id
	);
	$tbl_name='meal_planner';
	$result = $this->mealplanner_model->delete($where,$tbl_name);
	if ($result) {
		$return['success'] = "true";
		$return['message'] = "Deleted Successfully.";
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

}
