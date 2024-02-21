<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class MealPlanner extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/mealplanner_model');
        $this->load->helper('common_helper');
    }
    
    public function school_get() {
        $date = $this->input->get('date');
        if($date == '')
        {
            $date = date("Y-m-d");
        }
        $res = $this->mealplanner_model->getSchoolMeal($date);

        if ($res) {
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Success";
            $return['data'] = $res;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "No meal plan available for this date.";
        $return['data'] = json_decode('{ "id": "",
                                        "for_date": "'.$date.'",
                                        "breakfast": [],
                                        "snacks": [],
                                        "meal": []}');
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);
    }
    
    public function home_get() 
    {  
        $date = $this->input->get('date');
        if($date == '')
        {
            $date = date("Y-m-d");
        }
        $res = $this->mealplanner_model->getHomeMeal($date);

        $id             = !empty($res->id) ? $res->id : 0; 
        $school_id      = !empty($res->school_id) ? $res->school_id : 0; 
        $school_type    = !empty($res->school_type) ? $res->school_type : 0; 
        $class_id       = !empty($res->class_id) ? $res->class_id : 0; 
        $student_id     = !empty($res->student_id) ? $res->student_id : 0; 
        $snacks         = !empty($res->snacks) ? 1 : 0; 
        $breakfast      = !empty($res->breakfast) ? 1 : 0; 
        $meal           = !empty($res->meal) ? 1 : 0; 
        $other          = !empty($res->other) ? $res->other : 0; 
        
        $return['success'] = "true";
        $return['title'] = "success";
        $return['message'] = "Success";
        $return['data'] = $res;
        // $return['data'] = json_decode('{ 
        //                                 "id": "'.$id.'",
        //                                 "school_id": "'.$school_id.'",
        //                                 "school_type": "'.$school_type.'",
        //                                 "class_id": "'.$class_id.'",
        //                                 "student_id": "'.$student_id.'",
        //                                 "for_date": "'.$date.'",
        //                                 "breakfast": "'.$breakfast.'",
        //                                 "snacks": "'.$snacks.'",
        //                                 "meal": "'.$meal.'",
        //                                 "other": "'.$other.'" }');
        $return['error'] = $this->error;
        $this->response($return, REST_Controller::HTTP_OK);        
    }
}
