<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fees_model extends CI_Model {
    
    public function feeDetails($school_id,$student_id)
    {
        $currentDate = date('Y-m-d');
        //$student_id=72;
        $sql='SELECT is_paid,class_id,fee_start_date,fee_end_date,transaction_status FROM `student_fees` WHERE `school_id` = "'.$school_id.'" AND `student_id` = "'.$student_id.'" AND `is_paid`= "paid" AND  "'.$currentDate.'" BETWEEN `fee_start_date` AND `fee_end_date` ';   

        $query=$this->db->query($sql);
           if($query->num_rows() > 0)
           {
                $feeDetail = $query->row_array();
                //print_r();
                $feeDetail['is_paid']           = ( $feeDetail['is_paid'] == 'paid') ? true : false; 
                $feeDetail['transaction_status']           =  $feeDetail['transaction_status']; 
                $feeDetail['class_id']          = $feeDetail['class_id']; 
                $feeDetail['fee_start_date']    = $feeDetail['fee_start_date']; 
                $feeDetail['fee_end_date']      = $feeDetail['fee_end_date']; 
                // $feeDetail = $query->result_array();
                $fee_types        = $this->getFeeTypes($school_id);
                $currentSession   = get_current_session($school_id);
               
           }else{
                $fee_types = $this->getFeeTypes($school_id);
                $feeDetail = array('is_paid'=>'false');
                $currentSession   = get_current_session($school_id);
            }
        return array('fee_types'=> $fee_types, 'feeDetails' => $feeDetail,'currentSession' => $currentSession);
    }
    protected function getFeeTypes($school_id)
    {
        $where = array('status'=>'1');
        $this->db->select('id,fee_type');
        $this->db->from('fee_types');
        $this->db->where($where);
        $query =  $this->db->get();
        return  ($query->num_rows() > 0) ? $query->result_array() : array();
    }
    public function getfeesAmount($postData)
    {
        $school_id = $this->token->school_id;
        $student_id = $this->token->student_id;
            
        $currentSession = $this->get_current_session_Details($school_id);
        // prd($currentSession);
        $sessionStartMonth = date('m',strtotime($currentSession['sessionstart']));
        $sessionEndYear  = date('Y',strtotime($currentSession['sessionend']));
        $currentMonth      = date('m');
        $currentYear      = date('Y');

       if( $currentYear <= $sessionEndYear )
        {
            $feeDetails = $this->studentfeeDetails($student_id,$school_id);
            // lq();
            // prd($feeDetails);
            if( $feeDetails == 'no_record_found' )
            {
                $refrence_num = 'tx_'.time();
                  // Get student already deposite fee details
                $feeTypeData = get_feeType($postData['fee_type'], $school_id);
             
                // Get fee month value based on fee type.  
                $feeTypeValue = feeType($feeTypeData['fee_type']);

                // Get class-wise fee from school-wise
                $classFees        = $this->getClassFees( $postData['class_id'], $school_id, $postData['session_id']);
                if(empty($classFees)){
                    return array('status' => 'no_class_fee', 'data'=> '');
                }
                // prd($classFees);
                $class_fee_amount = !empty($classFees['fee_amount']) ? $classFees['fee_amount']:0;


                $totalFees = ($class_fee_amount * $feeTypeValue);
                $myFees    = ($totalFees > 0 ) ? $totalFees : 0;
                return array('status' => false, 'data'=> array('fees'=>$myFees,'transaction_ref'=>$refrence_num,'currency'=>'₦') );
            
            }else{
            
                return array('status' => 'paid', 'data'=> $feeDetails);
            }
        }else{
            return array('status' => 'invalid_session', 'data'=> '');
        }
    }
    public function getClassFees($class_id, $school_id, $session_id)
    {
        $where = array('class_id'=>$class_id, 'school_id'=>$school_id, 'session_id' => $session_id);
        $this->db->select('*');
        $this->db->from('fees');
        $this->db->where($where);
        $query =  $this->db->get();
        $feesData = $query->num_rows();
        // prd($feesData);
        return  ($feesData > 0) ? $query->row_array() : array();
    }
    public function studentfeeDetails($student_id,$school_id)
    {
        $currentDate = date('Y-m');
        
        $sql='SELECT is_paid,fee_start_date,fee_end_date FROM `student_fees` WHERE `school_id` = "'.$school_id.'" AND `student_id` = "'.$student_id.'" AND  "'.$currentDate.'" BETWEEN DATE_FORMAT(fee_start_date, "%Y-%m") AND DATE_FORMAT(fee_end_date, "%Y-%m") AND is_paid="paid" ';   
        
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
           return $query->result_array();
        }else{
            return 'no_record_found';
        }

    }
    public function get_current_session_Details($school_id)
    {
         $where = array('schoolId'=>$school_id,'status'=>1,'current_sesion'=>1);
        $ci = &get_instance();
        $ci->load->database();
        $ci->db->select('*');
        $ci->db->from('sessions');
        $ci->db->where($where);
        $query = $ci->db->get();
        return $query->row_array();
    }
    public function savePaymentData($postData)
    {
        $fee_start_date = '';
        $fee_end_date   = '';

         $student_id = $this->token->student_id;
         $parent_id  = $this->token->parent_id;
         $school_id  = $this->token->school_id;
         $userData = $this->userDetails($student_id);
         $currentSession   = get_current_session($school_id);
        // prd($currentSession);
        
          if( $postData['feeType_id'] == 1)
            {
                $fee_start_date = date('Y-m-01');
                $fee_end_date = date('Y-m-t');
            }
            if( $postData['feeType_id'] == 2)
            {
                $fee_start_date = date('Y-m-01');
                $fee_end_date   = date('Y-m-t', strtotime('+3 months'));
            }
            if( $postData['feeType_id'] == 3)
            {
                $fee_start_date = date('Y-m-01');
                $fee_end_date   = date('Y-m-t', strtotime('+11 months'));
            }
          
            $paymentArr = array(
                'transaction_id'        => $postData['transaction_id'],
                'tx_ref'                => $postData['reference_num'],
                'amount'                => $postData['amount'],
                'transaction_status'    => $postData['status'],
                'student_id'            => $student_id,
                'parent_id'             => $parent_id,
                'school_id'             => $school_id,
                'feeType_id'            => $postData['feeType_id'],
                'class_id'              => $userData['childclass'],
                'session_id'            => $currentSession->id,
                'fee_start_date'        => $fee_start_date,
                'fee_end_date'          => $fee_end_date,
                'currency'              => $postData['fees_currency'],
                'is_paid'               => 'paid',
                'paid_time'             => date('H:i:s'),
                'created_at'            => date('Y-m-d H:i'),
                'created_by'            => $parent_id,
            );

        if($postData['status'] == 'successful')
        {
           $this->db->insert('student_fees',$paymentArr);
           return $insert_id = $this->db->insert_id();
           // if($insert_id > 0)
           // {
           //   $this->
           // }
       
        }else{
            $paymentArr['is_paid'] = 'unpaid';
            $paymentArr['transaction_status'] = 'unsuccessful';
            $this->db->insert('student_fees',$paymentArr);
            return $this->db->insert_id();
        }
    }
    public function userDetails($student_id)
    {
        $where = array('status'=>1, 'id'=>$student_id);
       return $this->db->where($where)->get('child')->row_array();
    }
    public function paymentHistory()
    {
        //$student_id = $this->token->student_id;
        $student_id = $this->token->student_id;
        $parent_id  = $this->token->parent_id;
        $school_id  = $this->token->school_id;

        $where = array('student_id'=>$student_id, 'parent_id'=>$parent_id, 'school_id' => $school_id,'is_paid'=>'paid');
        $result = $this->db->where($where)->order_by('created_at','desc')->get('student_fees')->result_array();
        //echo $this->db->last_query();die;
        $finalData = array();
        $i=0;
        foreach ($result as  $value) {
            $finalData[$i] = $value;
            $finalData[$i]['fee_start_date'] = date('m-d-Y', strtotime($value['fee_start_date']));
            $finalData[$i]['fee_end_date']   = date('m-d-Y', strtotime($value['fee_end_date']));
            $finalData[$i]['created_at']   = date('m-d-Y h:i:s A', strtotime($value['created_at']));

            $i++;
            // prd($finalData);
        }
        return (count($finalData) > 0 ) ? $finalData : array();
    }
    
    
    public function schoolDetail()
    {
        $school_id  = $this->token->school_id;
        $schoolData = "";   
        $selectData = "SELECT 
            s.school_name as school_name,
            s.bank_name as bank_name,
            s.account_number as account_number,
            s.sub_acc_number as sub_acc_number,
            s.sort_code as sort_code,
            ac.currency_name as currency_name,
            ac.currency_code as currency_code,
            ac.currency_symbol as currency_symbol,
            ac.currency_rate as currency_rate
            FROM `school` as s 
            left join admin_currency as ac on ac.id = s.currency_id
            where s.id = '".$school_id."'";
        $query = $this->db->query($selectData);
        if ($query->num_rows() > 0) {
        $schoolData  = json_decode(json_encode($query->row()), true);
        }
        return $schoolData;
    }
    
    
}