<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';

class Fees extends REST_Controller {

    public $error = array();
    public $data = array();

    function __construct() {
        parent::__construct();
        $this->token->parent_validate();
        $this->load->library("security");
        $this->load->library('form_validation');
        $this->load->model('parent/Fees_model','model');
        $this->load->helper('common_helper');
    }
    public function feeDetails_get(){
        
        $school_id = $this->token->school_id;
        $student_id = $this->token->student_id;
        $feeDetails = $this->model->feeDetails($school_id,$student_id);

        if($feeDetails){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Record found successfully.";
            $return['data'] = $feeDetails;
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
    public function getFeesAmount_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        // prd($postData);
        $feeDetailAmount = $this->model->getfeesAmount($postData);
        $schoolDetail = $this->model->schoolDetail();
        // prd($feeDetailAmount);
        // lq();
        if($feeDetailAmount['status'] == 'paid'){
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "This month fee is already paid.";
            $return['data'] = $feeDetailAmount['data'];
            $return['data']['school_acc_detail'] = $schoolDetail;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);
        }else if($feeDetailAmount['status'] == 'invalid_session'){
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "Your fee session is expired.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }else if($feeDetailAmount['status'] == 'no_class_fee'){
            $return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No fees is available for this class.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);
        }else{
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Fee pay amount";
            $return['data'] = $feeDetailAmount['data'];
            $return['data']['school_acc_detail'] = $schoolDetail;
            // $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);   
        }
    }
    public function paymentFeesDetails_post()
    {
        $postData = json_decode(file_get_contents('php://input'), true);
        if ($postData == '') {
                $postData = $_POST;
        }
        $paymentDone = $this->model->savePaymentData($postData);
        // prd($paymentDone);
        if($paymentDone){
         	$return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Fee pay has been successfully deposit. Thank You!";
            $return['data'] = $paymentDone;
            // $return['total'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  

        }else{
			$return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "Something went wrong.";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);          
        }
    }
    public function paymentHistory_get()
    {
        $paymentHistory = $this->model->paymentHistory();
        // prd($paymentHistory);
        if($paymentHistory){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Fees payment history.";
            $return['data'] = $paymentHistory;
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_OK);  

        }else{
			$return['success'] = "false";
            $return['title'] = "failed";
            $return['message'] = "No payment history found";
            $return['data'] = '';
            $return['error'] = $this->error;
            $this->response($return, REST_Controller::HTTP_BAD_REQUEST);          
        }
    }
    
    
    public function feesinvoice_get($transactionID='987587542'){
        
        $school_id = $this->token->school_id;
        $this->db->select(
       'sf.*,
        s.school_name as school_name,
        s.phone as phone,
        s.bank_name as bank_name,
        s.sub_acc_number as sub_acc_number,
        s.sort_code as sort_code,
        s.location as school_location,
        s.city as school_city,
        s.state as school_state,
        s.country as school_country,
        s.pincode as school_pincode,
        s.pic as school_pic,
        st.name as schooltype,
        country.name as countryname,
        c.section as student_section,
        c.class as student_class,
        CONCAT(child.childfname," ",child.childmname," ",child.childlname) AS childname,
        child.childgender as childgender,
        child.childdob as childdob,
        child.childemail as childemail,
        child.childgender as studentgender,
        CONCAT(p.fatherfname," ",p.fatherlname) AS fathername,
        p.fatherphone as fatherphone,
        p.fatheremail as fatheremail,
        p.fatheraddress as fatheraddress,
        ft.fee_type as fee_type,
        sessions.academicsession as academicsession,
        sessions.id as academicsessionID,
        terms.termname as termname
       ');
       $this->db->from('student_fees as sf');
       $this->db->join('school as s', ' s.id = sf.school_id','left');
       $this->db->join('country_codes as country', ' country.id = s.country','left');
       $this->db->join('class as c', ' c.id = sf.class_id','left');
       $this->db->join('schooltype as st', ' st.id = c.school_type','left');
       $this->db->join('child as child ', ' child.id = sf.student_id','left');
       $this->db->join('parent as p ', ' p.id = sf.parent_id','left');
       $this->db->join('fee_types as ft', ' ft.id = sf.feeType_id','left');
       $this->db->join('sessions as sessions', 'sessions.id = sf.session_id','left');
       $this->db->join('terms as terms', '(terms.academicsession = sf.session_id And terms.termstart=sessions.sessionstart And terms.termend=sessions.sessionend And terms.schoolId='.$school_id.')','left');
        
       if ($transactionID != '') 
       {
        $this->db->where('sf.transaction_id', $transactionID);
        $this->db->where('sf.is_paid', 'paid');
        $this->db->where('sf.transaction_status', 'successful');
       }

        $query = $this->db->get();
         //echo $this->db->last_query(); exit;
        if ($query->num_rows() == 1) {
           $data['result'] =   json_decode(json_encode($query->row()), true);
           //print_r($data);
           ///exit;
           
            $mpdf = $mpdf = new \Mpdf\Mpdf(['format' => 'Legal']);
            $html = $this->load->view('fees_invoice', $data, true);
            $mpdf->WriteHTML($html);
            $filename = $transactionID.'_'.substr(md5(date('Y-m-d')),-10).'_fees_invoice.pdf';
            $mpdf->Output('img/school/'.$filename, 'F');
            
            if(file_exists("img/school/".$filename)){
            $return['success'] = "true";
            $return['title'] = "success";
            $return['message'] = "Report generated successfully";
            $return['url'] = 'img/school/'.$filename;
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
      
        }
        
    }
    
    
}


