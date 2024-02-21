<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report_model extends CI_Model {
    
    function add($data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('dailyreport', $data);
        return $this->emojidb->insert_id();
    }
    function update($id,$data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $this->emojidb->update('dailyreport', $data);
        return $this->emojidb->affected_rows();
    }
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
    
    function addMonthly($data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('monthlyreport', $data);
        return $this->emojidb->insert_id();
    }
    function updateMonthly($id,$data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $this->emojidb->update('monthlyreport', $data);
        return $this->emojidb->affected_rows();
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
    
    function addTerm($data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('termreport', $data);
        return $this->emojidb->insert_id();
    }
    function updateTerm($id,$data) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id',$id);
        $this->emojidb->update('termreport', $data);
        return $this->emojidb->affected_rows();
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
