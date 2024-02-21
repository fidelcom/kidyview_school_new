<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Result extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/Parentresult_model','model');
        // $this->load->model('studentAttendance_model','smodel');
        // $this->load->model('admin/result_model','admin_model');
        $this->load->helper('common_helper');
    }


    public function terms_get(){
        $school_id = $this->token->school_id;
        $terms = $this->model->termsList($school_id);
        if($terms){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['data'] = $terms;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else{
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No term found.";
            $return['data'] = '';
            $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);   
        }
    }
    
    public function studentTermsResult_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
         if ($postData == '') {
                $postData = $_POST;
        }
        $postData['student_id'] = $this->token->student_id;
        // $postData['student_id'] = 57;
// prd($postData);        
        $studentResult = $this->model->getStudentsTermsResult($postData);
       
        if (count($studentResult) > 0) {
            $return['success'] = "true";
            $return['message'] = "Student Result.";
            $return['GrandResult'] = $studentResult['grandResult'];
            $return['data'] = $studentResult['result'];
            $return['error'] = $this->error;

            $this->response($return, REST_Controller::HTTP_OK);
            } else {
            $return['success'] = "false";
            $return['message'] = "No result found.";
            $return['error'] = $this->error;
            $return['data'] ='';

            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    
    
   public  function getTermData($termListData,$termid) {
       
       
        $termArray = array();
        if(!empty($termListData)) {
           $k=0; 
           for($t=0;$t<count($termListData);$t++)   {  
               if($termListData[$t]->term_id == $termid){
                $termArray[$k] = $termListData[$t];
                $k++;
                
               }
           }
        }
        
       return $termArray; 
    }
    
    public function marksheetpdf_get() {
        
        //$school_id = 20;
        //$student_id = 57;
        error_reporting(0);
        $school_id = $this->token->school_id;
        $student_id = $this->token->student_id;
        $result = $this->model->getStudentResult($school_id, $student_id);
        
        //print_r($result);
        //exit;
        
        $data['result'] = $result;
        if ($result) {
            //$this->load->view('marksheet', $data, true);
            $mpdf = $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
            $html = $this->load->view('marksheet', $data, true);
            $mpdf->WriteHTML($html);
            $filename = $student_id.substr(md5(date('Y-m-d')),-10).'_reportcard.pdf';
            $mpdf->Output('img/child/'.$filename, 'F');
            //$this->load->view('marksheet', $data, true);
            //$mpdf->Output(); // opens in browser
            //$mpdf->Output('marksheet.pdf', 'D'); // it downloads the file into the user system, with give name
            
           if(file_exists("img/child/".$filename)){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Report generated successfully";
            $return['url'] = 'img/child/'.$filename;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
           }
           else {
            $return['success'] = "false";
            $return['message'] = "Error in report generation";
            $return['error'] = $this->error;
            $return['url'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);    
               
           }
            
        } else {
            $return['success'] = "false";
            $return['message'] = "No Result result found.";
            $return['error'] = $this->error;
            $return['data'] = '';
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }
    }

}