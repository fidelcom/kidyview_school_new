<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Subscription extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/Subscription_model",'model');
    }              
    public function getSubscriptionList_get() { 
        $res = $this->model->data();        
        $return['success'] = "true";
        $return['message'] = "Subscription List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    } 
    public function getFeatureList_get() {
        $subscription_id=$this->input->get('subscription_id')?$this->input->get('subscription_id'):'';
        $res = $this->model->feature_list($subscription_id);       
        $return['success'] = "true";
        $return['message'] = "Feature List.";
        $return['error'] = "";
        $return['data'] = $res;
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    } 
    public function createSubscription_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        if($postData==''){
            $postData=$_POST;  
        }
        $postData = $this->security->xss_clean($postData);
        print_r($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('validity', 'Validity', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('no_of_student', 'No of student', 'trim|required|numeric');
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $data = array(
                "name"=>$postData['name'],
                "type"=>$postData['type'],
                "validity"=>$postData['validity'],
                "amount"=>$postData['amount'],
                "no_of_student"=>$postData['no_of_student'],
                "description"=>$postData['description'],
                "created_at"=>date('Y-m-d H:i:s')
            );
            $res = $this->model->add($data);
            if($res)
            {
                $featureDataArr=array();
                $i=0;
                foreach(json_decode($_POST['featureData']) as $featureData){
                    $featureDataArr[$i]['subscription_id']=$res;
                    $featureDataArr[$i]['module_id']=$featureData->id;
                    $featureDataArr[$i]['module_name']=$featureData->module_name;
                    $featureDataArr[$i]['is_enable']=$featureData->is_enable;
                $i++;
                }
                if(!empty($featureDataArr)){
                    $this->model->insert_batch($featureDataArr,'subscription_feature');
                }
                $return['success'] = "true";
                $return['message'] = "Added Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = $res;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }               
    }  
    
    public function getSubscriptionDetails_get() { 
        $id=$this->input->get('subscription_id');
        $res = $this->model->detail($id);        
        $return['success'] = "true";
        $return['message'] = "Subscription Details.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    public function delete_get() {
		$id=$this->input->get('subscription_id');
		$where=array(
		'id'=>$id
        );
        $data=array('status'=>'2');
		$delete = $this->model->update($data,$where);
		if ($delete) {
			$return['success'] = "true";
			$return['message'] = "Deleted successfully.";
			$return['data'] = $delete;
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
    public function editSubscription_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        if($postData==''){
            $postData=$_POST;  
        }
        //print_r($postData);die;
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('name', 'Name', 'trim|required');
        $this->form_validation->set_rules('type', 'Type', 'trim|required');
        $this->form_validation->set_rules('validity', 'Validity', 'trim|required');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|required');
        $this->form_validation->set_rules('no_of_student', 'No of student', 'trim|required|numeric');
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $data = array(
                "name"=>$postData['name'],
                "type"=>$postData['type'],
                "validity"=>$postData['validity'],
                "amount"=>$postData['amount'],
                "no_of_student"=>$postData['no_of_student'],
                "description"=>$postData['description'],
                "updated_at"=>date('Y-m-d H:i:s')
            );
            $where=array('id'=>$postData['subscription_id']);
            $res = $this->model->update($data,$where);
            if($res)
            {
                $featureDataArr=array();
                $i=0;
                foreach(json_decode($_POST['featureData']) as $featureData){
                    $featureDataArr[$i]['id']=$featureData->id;
                    $featureDataArr[$i]['module_name']=$featureData->module_name;
                    $featureDataArr[$i]['is_enable']=$featureData->is_enable;
                $i++;
                }
                if(!empty($featureDataArr)){
                    $this->model->update_batch($featureDataArr,'subscription_feature');
                }
                $return['success'] = "true";
                $return['message'] = "Updated Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = $res;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }               
    }  
    public function changeStatus_post() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        if($postData==''){
            $postData=$_POST;  
        }
        $where=array('id'=>$postData['id']);
        $data = array(
            "status"=>$postData['status']
        );
        //print_r($postData);die;
        $res = $this->model->update($data,$where);
        if($res)
        {
            $return['success'] = "true";
            $return['message'] = "Status update Successfuly.";
            $return['error'] = $this->error;
            $return['data'] = $res;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        else
        {
            $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
        }          
    }
    
}
