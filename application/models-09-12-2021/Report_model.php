<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {
    
    function add($data) {
        $this->db->insert('dailyreport', $data);
        return $this->db->insert_id();
    }
    function update($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('dailyreport', $data);
        return $this->db->affected_rows();
    }
    function detail($id){
        $this->db->where('id',$id);
        $query = $this->db->get('dailyreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function dailyReportExist($report_type,$student_id,$date){
        $this->db->where('report_type',$report_type);
        $this->db->where('student_id',$student_id);
        $this->db->where('on_date',$date);
        $query = $this->db->get('dailyreport');
        if($query->num_rows() >= 1)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }    
    
    function addMonthly($data) {
        $this->db->insert('monthlyreport', $data);
        return $this->db->insert_id();
    }
    function updateMonthly($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('monthlyreport', $data);
        return $this->db->affected_rows();
    }
    function detailMonthly($id){
        $this->db->where('id',$id);
        $query = $this->db->get('monthlyreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function monthlyReportExist($student_id,$month){
        $this->db->where('student_id',$student_id);
        $this->db->where('for_month',$month);
        $query = $this->db->get('monthlyreport');
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
    
    function addTerm($data) {
        $this->db->insert('termreport', $data);
        return $this->db->insert_id();
    }
    function updateTerm($id,$data) {
        $this->db->where('id',$id);
        $this->db->update('termreport', $data);
        return $this->db->affected_rows();
    }
    function detailTerm($id){
        $this->db->where('id',$id);
        $query = $this->db->get('termreport');
        if($query->num_rows() == 1)
        {
            $data = $query->row();
            return $data;
        }
    }
    function termReportExist($student_id,$term){
        $this->db->where('student_id',$student_id);
        $this->db->where('term_id',$term);
        $query = $this->db->get('termreport');
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
        $this->db->from('sessions s');
        $this->db->join('terms t','s.id = t.academicsession','LEFT');
        $query = $this->db->get();
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
}
