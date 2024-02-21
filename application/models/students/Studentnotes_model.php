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
         left join sessions si ON ln.session_id=si.id
         where FIND_IN_SET($class_id, ln.classlist) And ln.schoolId='".$schoolID."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithclass = '1'  And ln.status = '1' AND si.current_sesion=1";  
        
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
           $data->created_date= date('Y-m-d',strtotime($data->created_date));
			//$data_user[$v]['attachmentData']		= $this->getPostAttachment($data_user[$v]['id']);
		   $data->commentData=$this->getLessonCommentData($data->id);
           $data->attachmentData=$this->getLessonAttachmentData($data->id); 
           return $data;
        }
        else
        {
            return false;
        }  
    }
    public function getLessonAttachmentData($id) {
        $this->db->select("*");
        $this->db->from('lesson_note_attachment');
        $this->db->where('noteid', $id);
        $this->db->order_by('id','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas=$query->result();
            return $datas;
        } else {
        return array();
        }
    }
    public function getLessonCommentData($id) {
        $data = $this->session->userdata('student_data');
        $studentid = "ST-".$data['id'];
        $this->db->select("cpc.id,cpc.user_id,cpc.comment,cpc.created_date,cpc.commentFrom as usertype,CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
        $this->db->from('lesson_note_comment cpc');
        $this->db->join('alluser u','cpc.user_id=u.id','INNER');
        $this->db->where('cpc.commentFrom!=', 'Teacher');
        $this->db->where('cpc.noteid', $id);
        $this->db->order_by('cpc.created_date','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas=$query->result();
            for($i=0;$i<count($datas);$i++){
                $datas[$i]->is_delete=0;
                $datas[$i]->created_date= date('Y-m-d',strtotime($datas[$i]->created_date));
                if($studentid==$datas[$i]->user_id){
                    $datas[$i]->is_delete=1;
                }
             }
        return $datas;
        } else {
        return array();
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
    public function getLessionCommentDataByCommentId($id) {
        $data = $this->session->userdata('student_data');
        $studentid = "ST-".$data['id'];
        $this->db->select("cpc.id,cpc.user_id,cpc.comment,cpc.created_date,cpc.commentFrom as usertype, CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
        $this->db->from('lesson_note_comment cpc');
        $this->db->join('alluser u','cpc.user_id=u.id','INNER');
        $this->db->where('cpc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row=$query->row();
            $row->created_date= date('Y-m-d',strtotime($row->created_date));
            $row->is_delete=0;
            if($studentid==$row->user_id){
                $row->is_delete=1;
            }
            return $row;
        } else {
            return array();
        }
    }
    public function add($data,$tbl_name)
	{
		$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
    }
    public function delete($where=array(),$tbl_name='')
    {
        $this->db->where($where);
        $query = $this->db->delete($tbl_name);
        return $query;
    }
     
}


?>