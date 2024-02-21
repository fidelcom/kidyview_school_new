<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class StudentFees_model extends CI_Model {

    public function getStudentsFeesDetails($postData)
    {
       $school_id = $this->token->school_id;
     // prd($postData); 
        
        $sql='SELECT c.id as student_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) AS student,c.childphoto, CONCAT(cs.class," ",cs.section) as class
                FROM `child` AS c LEFT JOIN class AS cs ON cs.id = c.childclass WHERE c.status = 1 AND c.childclass= "'.$postData['class_id'].'" ';   
        
        $query = $this->db->query($sql);
           if($query->num_rows() > 0)
           {
                $classStudentFees = $query->result();

                  foreach ($classStudentFees as  $value) {
                    
                        $postData['student_id'] = $value->student_id;
                        $studentFeesData = $this->isFeesPaidOrNot($postData);
                     
                        $classStudentFees = array_map(function($v) use($studentFeesData) {

                            foreach($studentFeesData as $data){

                                if($data->student_id == $v->student_id )
                                  $v->feeDetail = $data;
                            }
                            return $v;
                        },$classStudentFees);
                }
           }else{

                $classStudentFees = false;
            }
            if( !empty($classStudentFees) ){
                $studentFinalFee =array();
                $i=0;
                foreach ($classStudentFees as  $value) {
                    // prd($value);
                        if( isset($value->feeDetail) )
                        {
                            $studentFinalFee[$i] = $value;
                        }else{
                            $value->feeDetail = (object)[];
                            $studentFinalFee[$i] = $value;
                        }
                    $i++;
                }    
            }else{
                $studentFinalFee = false;     

            }
            return !empty($studentFinalFee) ? $studentFinalFee : array();     
    }
    private function isFeesPaidOrNot($postData)
    {
       $currentDate = date('Y-m-d');
       $school_id = $this->token->school_id;
        
        $sql = 'SELECT student_id,class_id,is_paid,amount,currency,fee_start_date,fee_end_date FROM `student_fees` WHERE `school_id` = "'.$school_id.'" AND `student_id` = "'.$postData['student_id'].'" AND `class_id` = "'.$postData['class_id'].'" AND  "'.$currentDate.'" BETWEEN `fee_start_date` AND `fee_end_date` ';  
            
            $query = $this->db->query($sql);
            $feeDetail = $query->result();
            return count($feeDetail) ? $feeDetail : array();
    }
    function implode_string($data, $str_starter = "'", $str_ender = "'", $str_seperator = ",") {
        if (isset($data) && $data) {
            if (is_array($data)) {
                foreach ($data as $value) {
                    $str[] = $str_starter . addslashes($value) . $str_ender . $str_seperator;
                }
                return (isset($str) && $str) ? implode($str_seperator, $str) :  null;
            }
            return $str_starter . $data . $str_ender;
        }
    }
    public function parentFCMID($postData)
    {
        $currentDate = date('Y-m-d');
      
        $impIDs = "'" . implode( "','", $postData['student_ids'] ) . "'";
      
        $sql = "SELECT `c`.`parent_id`,concat(c.childfname,' ',c.childmname,' ',c.childlname) as childname FROM `child` as `c` WHERE `c`.`status` = 1 AND `c`.`id` IN($impIDs) ORDER BY `c`.`id` DESC ";  
        // $sql = "SELECT `c`.`parent_id` FROM `child` as `c` INNER JOIN `student_fees` as `sf` ON `c`.`id` = `sf`.`student_id` WHERE `c`.`status` = 1 AND  `sf`.`is_paid` = 'paid' AND `sf`.`transaction_status` = 'successfull' AND  '".$currentDate."' BETWEEN `sf`.`fee_start_date` AND `sf`.`fee_end_date` AND `c`.`id` IN($impIDs) ORDER BY `c`.`id` DESC ";  

        $query = $this->db->query($sql);
        $parentIds = $query->result_array();
      
        // $where = array('c.status'=>1);
        // $this->db->select('c.parent_id');
        // $this->db->from('child as c');
        // $this->db->join('student_fees as sf', 'c.id = sf.student_id' , 'inner');
        // $this->db->where($where);
        // $this->db->where_in('c.id', $postData['student_ids']);
        // $this->db->order_by('c.id','desc');
        // $query =  $this->db->get();
        // $parentIds =  $query->result_array();
          // prd($parentIds); 
        $parentFCMIDs = array();
        foreach ( $parentIds as $value) {
            $parentData =  $this->getParentFCM($value['parent_id']);
            $parentData['childname']=$value['childname'];
            //print_r($parentData);die;
            $parentFCMIDs[]=$parentData;
        }
        return (count($parentFCMIDs) > 0) ? $parentFCMIDs : array();
    }
    public function getParentFCM($parent_id)
    {
            $where = array('user_type'=>'Parent', 'user_id' => $parent_id);
            $this->db->select('user_id,fcm_key');
            $this->db->from('user_token');
            $this->db->where($where);
            $this->db->order_by('id','desc');
            $query =  $this->db->get();
            return $query->row_array();
    }
}
