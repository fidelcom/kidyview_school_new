<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
class Transferstudent extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        if($this->session->userdata('user_role')=='school' OR $this->session->userdata('user_role')=='schoolsubadmin'){
          $this->token->validate();
        }
        $this->load->model("schools/transferstudent_model",'model');
    }
    
    public function getAllAcademicSession_get() {  	
        $postData = json_decode(file_get_contents('php://input'), true);
     if ($postData == '') {
        $postData = $_POST=$_GET;
     }
      $school_id = $postData['school_id'];
      $is_new = $postData['is_new'];
      $result = $this->model->getAllAcademicSession($school_id,$is_new);

        	if($result) {
            
            $return['success'] = "true";            
            $return['data'] = $result;
            $return['error'] = $this->error;
            
            $this->response($return, REST_Controller::HTTP_OK);
          
          	}else{
            $return['success'] = "false";
            $return['message'] = "No record found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
         }
    }
    public function getAllClass_get() {  	
      $postData = json_decode(file_get_contents('php://input'), true);
      if ($postData == '') {
          $postData = $_POST=$_GET;
      }
    $school_id = $postData['school_id'];

    $result = $this->model->getAllClass($school_id);

        if($result) {
          
          $return['success'] = "true";            
          $return['data'] = $result;
          $return['error'] = $this->error;
          
          $this->response($return, REST_Controller::HTTP_OK);
        
          }else{
          $return['success'] = "false";
          $return['message'] = "No record found.";
          $return['error'] = $this->error;
          $return['data'] = '';
          
          $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
       }
  }
  public function getAllClassChild_get() {  	
    $postData = json_decode(file_get_contents('php://input'), true);
    if ($postData == '') {
        $postData = $_POST=$_GET;
    }
  $school_id = $postData['school_id'];
  $session_id = $postData['session_id'];
  $class_id = $postData['class_id'];
  $result = $this->model->getAllClassChild($school_id,$session_id,$class_id);

      if($result) {
        
        $return['success'] = "true";            
        $return['data'] = $result;
        $return['error'] = $this->error;
        
        $this->response($return, REST_Controller::HTTP_OK);
      
        }else{
        $return['success'] = "false";
        $return['message'] = "No record found.";
        $return['error'] = $this->error;
        $return['data'] = '';
        
        $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
     }
}
public function transferChild_post() {  	
  $postData = json_decode(file_get_contents('php://input'), true);
  if ($postData == '') {
      $postData = $_POST;
  }
  $result=0;
  if(!empty($postData['child'])){
      foreach($postData['child'] as $child){
        $whereNewChildClassArr = array(
          'schoolId' => $postData['school_id'],
          'id' => $child['id']          
        );
        if($postData['is_outside']==1){
          $whereNewChildArr = array(
            'id' => $child['id']          
          );
          $updateNewChildArr = array(
            'status' => 0 ,
            'is_outside' => 1     
          );
        $result = $this->model->update($updateNewChildArr,'child',$whereNewChildArr);
        }else{
        $updateNewChildClassArr = array(
          'class_session_id' => $postData['to_session'],
          'childclass' => $postData['to_class'],
          'updated_date'=> date('Y-m-d H:i:s'),
          'updated_by' =>'School'           
        );
        $this->model->update($updateNewChildClassArr,'child',$whereNewChildClassArr);
        
        $whereOldChildClassArr = array(
          'school_id' => $postData['school_id'],
          'child_id' => $child['id'],
          //'session_id' => $postData['from_session'],
          //'class_id' => $postData['from_class']        
        );
        $updateOldChildClassArr = array(
          'is_current_session' => '0',
          'updated_date'=> date('Y-m-d H:i:s')         
        );
        $this->model->update($updateOldChildClassArr,'child_class',$whereOldChildClassArr);
        $childClassArr = array(
          'school_id' => $postData['school_id'],
          'child_id' => $child['id'],
          'session_id' => $postData['to_session'],
          'class_id' => $postData['to_class'],
          'created_date'=> date('Y-m-d H:i:s')              
        );
        $result=$this->model->add($childClassArr,'child_class');
      }
  }
}
    if($result) {
      $return['success'] = "true";            
      $return['message'] = "Student transfer successfully.";
      $return['error'] = $this->error;
      $this->response($return, REST_Controller::HTTP_OK);
      }else{
      $return['success'] = "false";
      $return['message'] = "No record found.";
      $return['error'] = $this->error;
      $return['data'] = '';
      
      $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
   }
}
}
