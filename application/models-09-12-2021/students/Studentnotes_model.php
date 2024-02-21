<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Studentnotes_model extends CI_Model {
    
    
    public function studentdata($studentID)
     {
        $dataQuery = "select * from child where id='".$studentID."'";  
        $query = $this->db->query($dataQuery);  
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
           return  $query->row();
                         
         }
        else
        {
            return false;
        }
             
     }
    
    
    public function studentlessonlist($schoolID,$class_id)
     {
        $dataQuery = "select 
         ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,'-',s.subject_code) as subjectname
         from  lesson_note as ln 
         left join terms as t on t.id = ln.term 
         left join subjects as s on s.id = ln.subject 
         where FIND_IN_SET($class_id, ln.classlist) And ln.schoolId='".$schoolID."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithclass = '1'  And ln.status = '1'";  
        
        $query = $this->db->query($dataQuery);  
        //echo $this->db->last_query();die();
        if($query->num_rows() > 0) 
        {
           return  $query->result_array();
                         
         }
        else
        {
            return false;
        }
             
     }
    
    
    public function viewdetailsharednote($schoolID,$noteid)
    {
        $this->db->select('ln.*,t.termname as termname, CONCAT(s.subject,"-",s.subject_code) as subjectname');
        $this->db->from('lesson_note ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
        $this->db->join('subjects as s', 's.id = ln.subject', 'LEFT');
        $this->db->where('ln.schoolId', $schoolID);
        $this->db->where('ln.id', $noteid);
       
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0)
        {
           $data  = $query->row();
            return $data;
        }
        else
        {
            return false;
        }  
    }
    
    public function addcomment($dataArray) 
    {
      $this->db->insert('lesson_note_comment',$dataArray);
      $id = $this->db->insert_id();
      return $id;  
    }
    
    
    public function commentlist($schoolID,$noteid,$student_id)
    {
        $this->db->select('lnc.*,ln.topic as topic');
        $this->db->from('lesson_note_comment lnc');
        $this->db->join('lesson_note as ln', 'ln.id = lnc.noteid', 'LEFT');
        $this->db->where('lnc.schoolId', $schoolID);
        $this->db->where('lnc.noteid', $noteid);
        $this->db->where('lnc.commentId', $student_id);
        $this->db->where('lnc.commentFrom', 'student');
       $this->db->order_by("lnc.id", "desc");
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0)
        {
           $data  = $query->result_array();
            return $data;
        }
        else
        {
            return false;
        }  
    }
     
}


?>