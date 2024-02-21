<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Lesson_model extends CI_Model
{

    public function getAllSubjectForSchool($id)
    {
        $this->db->select('s.*,c.class as class_name,c.section,t.teacherfname,t.teachermname,t.teacherlname');
        $this->db->from('subjects s');
        $this->db->join('class c','s.class = c.id','LEFT');
        $this->db->join('teacher t','s.teacher = t.id','LEFT');
        $this->db->where('s.schoolId', $id);
        $this->db->order_by('s.id', 'DESC');
        $query =  $this->db->get();                    

        if($query->num_rows() > 0) 
        {
                $data_user = $query->result_array();
                return $data_user;
        }
        else
        {
                return false;
        }
    }
    
    
    public function getAllTermForSchool($id) 
    {
        $this->db->select('t.*, s.academicsession as sessionName');
        $this->db->from('terms t');
        $this->db->join('sessions s', 's.id = t.academicsession', 'LEFT');
        $this->db->where('t.schoolId', $id);
        $this->db->order_by('t.id', 'DESC');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
         if($query->num_rows() > 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    
    public function gettermdates($schoolID,$term) 
    {
        $this->db->select('t.*');
        $this->db->from('terms t');
        $this->db->where('t.schoolId', $schoolID);
        $this->db->where('t.id', $term);
       
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0)
        {
           $data  = $query->row();
           $data->termStartDate = date('d-m-Y',strtotime($data->termstart));
           $data->termEndDate = date('d-m-Y',strtotime($data->termend));
            return $data;
        }
        else
        {
            return false;
        }
    }
    
    
    public function getAllClassForSchool($id) 
    {
        
        $where = array('c.schoolId' => $id, 'c.status' => 1, 's.current_sesion' => 1);
        $this->db->select('c.*,s.sessionstart,s.sessionend');
        $this->db->from('class c');
        $this->db->join('teacher t', 't.id = c.classteacher', 'LEFT');
        $this->db->join('sessions s', 's.schoolId = c.schoolId', 'LEFT');
        $this->db->where($where);
        $this->db->group_by('c.id');
        $query = $this->db->get();
        // lq();
        //echo $this->db->last_query(); die;
         if($query->num_rows() > 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    
    public function getsubject($schoolID) 
    {
        $where = array('s.schoolId' => $schoolID, 's.status' => 1);
        $this->db->select('s.*');
        $this->db->from('subjects s');
        $this->db->where($where);
        $this->db->group_by('s.id');
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    public function getteacher($schoolID,$teacherid) 
    {
        $where = array('t.id!=' => $teacherid,'t.schoolId' => $schoolID, 't.status' => 1);
        $this->db->select('t.id, CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as teacher');
        $this->db->from('teacher t');
        $this->db->where($where);
        $this->db->group_by('t.id');
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    public function addnote($dataArray) 
    {
      $this->db->insert('lesson_note',$dataArray);
      $id = $this->db->insert_id();
      return $id;  
        
    }
    
    public function lessonnotelist($schoolID,$teacherid) 
    {
        $where = array('ln.teacherid' => $teacherid,'ln.schoolId' => $schoolID);
        $this->db->select(
        'ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,"-",s.subject_code) as subjectname,  
         ');
        $this->db->from('lesson_note as ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
        $this->db->join('subjects as s', 's.id = ln.subject', 'LEFT');
        $this->db->where($where);
        $this->db->group_by('ln.id');
        
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    
    public function getnotesdata($schoolID,$noteid)
    {
      $this->db->select('ln.*,t.termstart as termstart,t.termend as termend');
        $this->db->from('lesson_note ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
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
    
    
     public function updatenote($dataArr,$noteid)
     {
        $this->db->where('id',$noteid); 
        $this->db->update('lesson_note',$dataArr);
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
        return true;
        }
        else
        {
        return false;
        }   
         
     }   

     public function sharedlessonlist($schoolID,$teacherid)
     {
        $dataQuery = "select 
         ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,'-',s.subject_code) as subjectname
         from  lesson_note as ln 
         left join terms as t on t.id = ln.term 
         left join subjects as s on s.id = ln.subject 
         where FIND_IN_SET($teacherid, ln.teacherlist) And ln.schoolId='".$schoolID."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithteacher = '1'  And ln.status = '1'";  
        
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
    
    
    public function alllessonnotelist($schoolID) 
    {
        $where = array('ln.schoolId' => $schoolID);
        $this->db->select(
        'ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,"-",s.subject_code) as subjectname,  
         ');
        $this->db->from('lesson_note as ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
        $this->db->join('subjects as s', 's.id = ln.subject', 'LEFT');
        $this->db->where($where);
        $this->db->group_by('ln.id');
        
        $query = $this->db->get();
        //echo $this->db->last_query(); die;
        if($query->num_rows() > 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }
    
    
    public function notedisabled($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('lesson_note',$data);
        //echo $this->db->last_query(); die;
        if($this->db->affected_rows())
        {
                return true;
        }
        else
        {
                return false;
        }
 }
    
}               