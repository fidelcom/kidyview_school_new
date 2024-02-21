<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class LearningAndDevelopment extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
            $this->token->validate();
        }
        $this->load->model("admin/learningAndDevelopment_model");
    }
    
    public function index_get() {       	
        $res = $this->learningAndDevelopment_model->data();        
        $return['success'] = "true";
        $return['message'] = "Learning And Development.";
        $return['error'] = "";
        $return['data'] = $res;
        
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function detail_get() {       	
        $res = $this->learningAndDevelopment_model->detail();        
        $return['success'] = "true";
        $return['message'] = "Home Meal Detail.";
        $return['error'] = "";
        $return['data'] = $res;
        //$schoolDetail 	= $this->session->all_userdata();
        $this->response($res, REST_Controller::HTTP_OK);
    }
    public function index_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        //print_r($postData);die;
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        
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
            $dataLDC = array("name"=>$postData['name'],"school_id"=>$schoolID,"class_id"=>$postData['class_id']);
            $this->db->insert("learning_development_category",$dataLDC);
            $id  = $this->db->insert_id();
            if(isset($postData['detail']))
            {
                $dataLDQ = array("category_id"=>$id,"question"=>$postData['detail']['question'],"options"=> json_encode($postData['detail']['options']));
                $this->db->insert("learning_development_question",$dataLDQ);
            }
            
            if(isset($postData['info']))
            {
                foreach ($postData['info'] as $info)
                {                    
                    $dataInfo = array("title"=>$info['title'],"detail"=> $info['detail'],"category_id"=>$id);
                    $this->db->insert("learning_development_info",$dataInfo);                    
                }
            }
              
            $return['success'] = "true";
            $return['message'] = "Learning And Development Added Successfuly.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_OK);            
        }               
    }
    public function index_put() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('class_id', 'Class', 'trim|required');
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $dataLDC = array("name"=>$postData['name'],"class_id"=>$postData['class_id']);
            $this->db->where("id",$postData['id']);
            $this->db->update("learning_development_category",$dataLDC);
            
            $dataLDQ = array("question"=>$postData['detail']['question'],"options"=> json_encode($postData['detail']['options']));
            $this->db->where("id",$postData['detail']['id']);
            $this->db->update("learning_development_question",$dataLDQ);
            
            if(isset($postData['info']))
            {
                $this->db->where("category_id",$postData['id']);
                $this->db->delete("learning_development_info");
                foreach ($postData['info'] as $info)
                {                    
                    $dataInfo = array("title"=>$info['title'],"detail"=> $info['detail'],"category_id"=>$postData['id']);
                    $this->db->insert("learning_development_info",$dataInfo);                    
                }
            }              
                                                           
            $return['success'] = "true";
            $return['message'] = "Learning And Development Updated Successfuly.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_OK);
            
        }               
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
	$tbl_name=' learning_development_category';
	$result = $this->learningAndDevelopment_model->delete($where,$tbl_name);
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
