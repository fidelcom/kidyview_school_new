<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Profile extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/parent_model','model');
        $this->load->helper('common_helper');
    }
            
    public function index_get(){
        $data = array('student_detail'=>array(),'paret_detail'=>array(),'guardian_detail'=>array());
        $data['student_detail'] = $this->model->childDetail($this->token->student_id);
        $data['paret_detail'] = $this->model->parentDetail($this->token->parent_id);
        $data['guardian_detail'] = $this->model->guardianDetail($this->token->parent_id);
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Profile detail.";
        $return['data'] = $data;
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
        
    }                       
    public function childlist_get(){      
        $this->load->library('user_agent');
        $platform = $this->agent->platform();
        if ($platform == "Unknown Platform") {
            if ($this->agent->is_browser()) {
                $platform = $this->agent->browser();
            } elseif ($this->agent->is_robot()) {
                $platform = $this->agent->robot();
            } elseif ($this->agent->is_mobile()) {
                $platform = $this->agent->mobile();
            }
        }

        
        $currentDateTime = date("Y-m-d H:i:s");
        $datetime = new DateTime($currentDateTime);
        $datetime->modify('+6 month');
        $expieryDateTime = $datetime->format('Y-m-d H:i:s');

        $childList = $this->model->childList($this->token->user_id);
        for($i =0; $i < count($childList);$i++)
        {
            $userToken = "";
            $userTokenStr = $this->token->user_id . "#" . $expieryDateTime . "#" . $platform. "#" . $childList[$i]->id . "#" . $this->token->school_id . "#Parent". "#" . $childList[$i]->childclass;
            $userToken = $this->settings->encryptString($userTokenStr);
            $childList[$i]->token = $userToken;
            unset($childList[$i]->password);
        }

        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "successfully login";
        $return['error'] = (object) $this->error;
        $return['data'] = $childList;

        $this->response($return, REST_Controller::HTTP_OK);                        
    } 
    
    public function fatherImage_post()
    {   
        if(!isset($_FILES['image']))
        {
            $this->response(array('status'=>'error','message'=>'Please upload image.'), REST_Controller::HTTP_OK);
        }
        else
        {
            $data = $this->upload_files('img/parent', $_FILES['image']);
            
            $this->db->where('id', $this->token->user_id);
            $this->db->update('parent', array('fatherphoto'=>$data['file_name']));  
            if($this->db->affected_rows() > 0)
            {
                $this->response(array('status'=>'success','message'=>'Profile image updated.'), REST_Controller::HTTP_OK);  
            }
            else
            {
                $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
            }
        }
    }
    public function motherImage_post()
    {   
        if(!isset($_FILES['image']))
        {
            $this->response(array('status'=>'error','message'=>'Please upload image.'), REST_Controller::HTTP_OK);
        }
        else
        {
            $data = $this->upload_files('img/parent', $_FILES['image']);
            
            $this->db->where('id', $this->token->user_id);
            $this->db->update('parent', array('motherphoto'=>$data['file_name']));  
            if($this->db->affected_rows() > 0)
            {
                $this->response(array('status'=>'success','message'=>'Profile image updated.'), REST_Controller::HTTP_OK);  
            }
            else
            {
                $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
            }
        }
    }
    public function emergencyImage_post()
    {   
        if(!isset($_FILES['image']))
        {
            $this->response(array('status'=>'error','message'=>'Please upload image.'), REST_Controller::HTTP_OK);
        }
        else
        {
            $data = $this->upload_files('img/parent', $_FILES['image']);
            
            $this->db->where('id', $this->token->user_id);
            $this->db->update('parent', array('emergencyphoto'=>$data['file_name']));  
            if($this->db->affected_rows() > 0)
            {
                $this->response(array('status'=>'success','message'=>'Profile image updated.'), REST_Controller::HTTP_OK);  
            }
            else
            {
                $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
            }
        }
    }
    
    public function emergency_post()
    {    
        $postData = json_decode(file_get_contents('php://input'), true);
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('emergencyfname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('emergencylname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('emergencyemail', 'Email', 'trim|required');
        $this->form_validation->set_rules('emergencyphone', 'Phone', 'trim|required');
        
        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
                
        $this->db->where('id', $this->token->user_id);
        $this->db->update('parent', array(
                                            'emergencyfname'=>$postData['emergencyfname'],
                                            'emergencylname'=>$postData['emergencylname'],
                                            'emergencyemail'=>$postData['emergencyemail'],
                                            'emergencyphone'=>$postData['emergencyphone'],
                                        )
                        );  
        if($this->db->affected_rows() > 0)
        {
            $this->response(array('status'=>'success','message'=>'Energency contact detail updated.'), REST_Controller::HTTP_OK);  
        }
        else
        {
            $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
        }        
    }
    
    
    public function addGuardian_post()
    {    
        $postData = $_POST;
                                               
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('photo', 'Photo', 'trim');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');
                        
        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        if(isset($_FILES['photo']))
        {
            $dataImage = $this->upload_files2('img/parent', $_FILES['photo']);
            $postData['photo'] = $dataImage['file_name'];
        }
        else
        {
            if(!isset($postData['photo']))
            {
                $postData['photo'] = '';
            }
        }

        $dataGuardian = array(
                                'parent_id'=>$this->token->user_id,
                                'school_id'=>$this->token->school_id,
                                'fname'=>$postData['fname'],
                                'lname'=>$postData['lname'],
                                'email'=>$postData['email'],
                                'phone'=>$postData['phone'],
                                'address'=>$postData['address'],
                                'city'=>$postData['city'],
                                'state'=>$postData['state'],
                                'country'=>$postData['country'],
                                'pincode'=>$postData['pincode'],
                                'photo'=>$postData['photo'],
                                'relation'=>$postData['relation'],
                                'created_date'=>date("Y-m-d"),
                                'created_by'=>"P-".$this->token->user_id,
                            );
        
        $this->db->insert('parent_guardian', $dataGuardian);  
        if($this->db->affected_rows() > 0)
        {
            $this->response(array('status'=>'success','message'=>'Guardian detail added.'), REST_Controller::HTTP_OK);  
        }
        else
        {
            $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
        }        
    }
    
    public function updateGuardian_post()
    {    
        $postData = $_POST;
                                       
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('id', 'ID', 'trim|required');
        $this->form_validation->set_rules('fname', 'First Name', 'trim|required');
        $this->form_validation->set_rules('lname', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('city', 'City', 'trim|required');
        $this->form_validation->set_rules('state', 'State', 'trim|required');
        $this->form_validation->set_rules('country', 'Country', 'trim|required');
        $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required');
        $this->form_validation->set_rules('photo', 'Photo', 'trim');
        $this->form_validation->set_rules('relation', 'Relation', 'trim|required');
        
        if ($this->form_validation->run() === false) {
            $this->error = $this->form_validation->error_array();
            $message = validation_errors();
            $return['success'] = "false";
            $return['title'] = "error";
            $return['message'] = "$message";
            $return['error'] = $this->error;
            $return['data'] = (object) $this->data;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
        
        $id = $postData['id'];
        $dataGuardian = array(
                                'parent_id'=>$this->token->user_id,
                                'school_id'=>$this->token->school_id,
                                'fname'=>$postData['fname'],
                                'lname'=>$postData['lname'],
                                'email'=>$postData['email'],
                                'phone'=>$postData['phone'],
                                'address'=>$postData['address'],
                                'city'=>$postData['city'],
                                'state'=>$postData['state'],
                                'country'=>$postData['country'],
                                'pincode'=>$postData['pincode'],
                                'relation'=>$postData['relation'],
                                'updated_date'=>date("Y-m-d"),
                                'updated_by'=>"P-".$this->token->user_id,
                            );
        
        if(isset($_FILES['photo']))
        {
            $dataImage = $this->upload_files2('img/parent', $_FILES['photo']);
            $dataGuardian['photo'] = $dataImage['file_name'];
        }               
        
        $this->db->where('id', $id);  
        $this->db->update('parent_guardian', $dataGuardian);  
        if($this->db->affected_rows() > 0)
        {
            $this->response(array('status'=>'success','message'=>'Guardian detail updated.'), REST_Controller::HTTP_OK);  
        }
        else
        {
            $this->response(array('status'=>'error','message'=>'Some error happen.'), REST_Controller::HTTP_OK);  
        }        
    }
    
    private function upload_files($path, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'encrypt_name'  => true,
            'allowed_types' => 'jpg|JPG|jpeg|JPWG|png|PNG'
        );

        $this->load->library('upload', $config);

        $images;        
            
        $fileName = date("YmdHis") .'-'. str_replace(' ','-',$files['name']);            

        $config['file_name'] = $fileName;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('image')) {
            $images =$this->upload->data();
        } else {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        }
        
        return $images;
    }
    
    private function upload_files2($path, $files)
    {
        $config = array(
            'upload_path'   => $path,
            'encrypt_name'  => true,
            'allowed_types' => 'jpg|JPG|jpeg|JPWG|png|PNG'
        );

        $this->load->library('upload', $config);

        $images;        
            
        $fileName = date("YmdHis") .'-'. str_replace(' ','-',$files['name']);            

        $config['file_name'] = $fileName;

        $this->upload->initialize($config);

        if ($this->upload->do_upload('photo')) {
            $images =$this->upload->data();
        } else {
            $error = array('error' => $this->upload->display_errors());
            return $error;
        }
        
        return $images;
    }
    
}
