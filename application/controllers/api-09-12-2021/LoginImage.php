<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class LoginImage extends REST_Controller {

    public $error = array();
    public $data = array();

    public function __construct() {
        parent::__construct();
        $this->load->model("admin/loginimage_model",'model');
    }
    
    public function index_get() {       	
        $res = $this->model->data();        
        $return['success'] = "true";
        $return['message'] = "Image List.";
        $return['error'] = "";
        $return['data'] = $res;
        $this->response($return, REST_Controller::HTTP_OK);

    }
    public function index_put() {       	
        $postData = json_decode(file_get_contents('php://input'), true);
        $postData = $this->security->xss_clean($postData);
        $this->form_validation->set_data($postData);
        $this->form_validation->set_rules('image', 'Image', 'trim|required');
        $this->form_validation->set_rules('bg_image', 'Image', 'trim|required');
        
        $error = array();
        if ($this->form_validation->run() === False) {
            $error = $this->form_validation->error_array();
            $message = validation_errors();
            $this->response(["success" => "false", 'message'=>$message,'data'=>'',"error" => $error], REST_Controller::HTTP_BAD_REQUEST);
        } 
        else 
        {
            $id = $postData['id'];
            $data = array(
                "image"=>$postData['image'],
                "bg_image"=>$postData['bg_image']
            );
            $res = $this->model->update($id,$data);
            if($res)
            {
                $return['success'] = "true";
                $return['message'] = "Updated Successfuly.";
                $return['error'] = $this->error;
                $return['data'] = $schoolDetail;
                $this->response($return, REST_Controller::HTTP_OK);
            }
            else
            {
                $this->response(["success" => "false", 'message'=>'','data'=>'',"error" => ''], REST_Controller::HTTP_INTERNAL_SERVER_ERROR);
            }
        }               
    }
    
    public function image_post()
    {
        if(isset($_FILES['image']))
        {
                $config['upload_path']          = './asset/images/';
                $config['allowed_types']        = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['encrypt_name']        = true;
                $config['max_size']             = 200000;
                $this->load->library('upload', $config);

                if ( ! $this->upload->do_upload('image'))
                {
                        $error = array('error' => $this->upload->display_errors());
                        //return(false);
                        echo json_encode($error);
                }
                else
                {
                        $data = $this->upload->data();
                        echo json_encode(array("file_name"=>$data['file_name']));
                }
        }
        else
        {
            return false;
        }
    }
    

}
