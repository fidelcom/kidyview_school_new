<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {
    
    function detail($id){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $query = $this->emojidb->get('dailyreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function dailyReportExist($report_type,$student_id,$date){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('report_type',$report_type);
        $this->emojidb->where('student_id',$student_id);
        $this->emojidb->where('on_date',$date);
        $query = $this->emojidb->get('dailyreport');
        if($query->num_rows() >= 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }    
    
    function detailMonthly($id){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $query = $this->emojidb->get('monthlyreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function monthlyReportExist($student_id,$month){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('student_id',$student_id);
        $this->emojidb->where('for_month',$month);
        $query = $this->emojidb->get('monthlyreport');
        //echo $this->db->last_query();die;
        if($query->num_rows() >= 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    
    function detailTerm($id){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $query = $this->emojidb->get('termreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function termReportExist($student_id,$term){
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('student_id',$student_id);
        $this->emojidb->where('term_id',$term);
        $query = $this->emojidb->get('termreport');
        //echo $this->db->last_query();die;
        if($query->num_rows() >= 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    
    function termList(){
        $this->db->select("t.id, t.termname, t.formattedtermstart as start_date, t.formattedtermend as end_date");
        $this->db->where('s.schoolId',$this->token->school_id);        
        $this->db->where('s.current_sesion',1);
        $this->db->where('s.status',1);
        $this->db->from('sessions s');
        $this->db->join('terms t','s.id = t.academicsession','LEFT');
        $query = $this->db->get();
        
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            return $data;
        }
    }
    function termList2(){
        $this->db->select("s.*");
        //$this->db->select("s.*,t.id, t.termname, t.formattedtermstart as start_date, t.formattedtermend as end_date");
        $this->db->where('s.schoolId',$this->token->school_id);        
        $this->db->where('s.current_sesion',1);
        $this->db->where('s.status',1);
        $this->db->from('sessions s');
        $this->db->join('terms t','s.id = t.academicsession','LEFT');
        $query = $this->db->get();
        
        //echo $this->db->last_query();die;
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            return $data;
        }
    }
    
    function monthsInSession(){
        $this->db->select('s.*');
        $this->db->where('s.schoolId',$this->token->school_id);        
        $this->db->where('s.current_sesion',1);        
        $this->db->from('sessions s');
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            $tmp1 = strtotime($data->formattedsessionstart);
            $tmp2 = strtotime($data->formattedsessionend);
            $dateStart = (date("Y-m-d",$tmp1));
            $dateEnd = (date("Y-m-d",$tmp2));            
            
            $start    = (new DateTime($dateStart))->modify('first day of this month');
            $end      = (new DateTime($dateEnd))->modify('first day of next month');
            $interval = DateInterval::createFromDateString('1 month');
            $period   = new DatePeriod($start, $interval, $end);
            
            $arrMonths = array();
            foreach ($period as $dt) {
                array_push($arrMonths,$dt->format("Y M"));
            }
            
            return $arrMonths;
        }
    }
    
    
    public function getStudentsCheckInCheckOut($school_id,$studentID,$date) 
    {
        if(empty($school_id) || empty($studentID))
        return false;
        $dataArray = array();
        $this->db->select("*");
        $this->db->where(['sa.school_id'=>$school_id,'sa.student_id'=>$studentID,'date(sa.created_at)'=>$date]);
        $query = $this->db->get('student_attendance as sa');
        //echo $this->db->last_query();die;
        if ($query->num_rows() > 0) {
            $result = (array) $query->row();
           
            if(($result['check_in']=='true' || $result['check_in'] =='1') && ($result['check_out']=='true' || $result['check_out'] =='1') ){
             $dataArray['check_in'] =  $result['check_in'];  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  $result['check_out'];  
             $dataArray['check_out_time'] =  date('h:i a',strtotime($result['updated_at']));
            }
            else if(($result['check_in']=='true' || $result['check_in'] =='1') && ($result['check_out']=='false' || $result['check_out'] =='')){
             $dataArray['check_in'] =  $result['check_in'];  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  "";  
             $dataArray['check_out_time'] = "";   
            }
            else if(($result['check_in']=='false' || $result['check_in'] =='') && ($result['check_out']=='true' || $result['check_out'] =='1')){
             $dataArray['check_in'] =  "";  
             $dataArray['check_in_time'] =  "";
             $dataArray['check_out'] =  $result['check_out'];  
             $dataArray['check_out_time'] =  date('h:i a',strtotime($result['updated_at']));
            }
            else if(($result['check_in']=='false' || $result['check_in'] =='') && ($result['check_out']=='false' || $result['check_out'] =='')){
             $dataArray['check_in'] = "";  
             $dataArray['check_in_time'] =  date('h:i a',strtotime($result['created_at']));
             $dataArray['check_out'] =  "";  
             $dataArray['check_out_time'] = "";   
            }
            return $dataArray;
          
        } else {
            return false;
        }
    }
    
}
