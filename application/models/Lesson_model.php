<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Lesson_model extends CI_Model
{

    function allData() {
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $where = array('ln.teacherid' => $teacher_id,'ln.schoolId' => $schoolId);
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
        
        if (isset($_GET['page'])) 
        {
            $page = $_GET['page'];
            $limit = 10;
            if(isset($_GET['limit']))
            {
                $limit = $_GET['limit'];
            }
            $offset = ($page - 1) * $limit;

            $this->db->limit($limit, $offset);
        }
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            $data = $query->result();
            for ($i = 0; $i < count($data); $i++) {
                $this->load->helper('common');
                $data[$i]->created = time_elapsed_string($data[$i]->created);
                $data[$i]->attachment = $this->getAttachment($data[$i]->id);                                
            }
            return $data;
        } else {
            return array();
        }
    }
    function allDataCount(){
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $where = array('ln.teacherid' => $teacher_id,'ln.schoolId' => $schoolId);
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
        return $query->row()->total;
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
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
        {
           $data  = $query->row();
           $data->attachmentData=$this->getLessonAttachmentData($data->id);
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
     
     
     public function viewdetailsharednote($schoolID,$noteid,$user_id)
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
		   $data->commentData=$this->getLessonCommentData($data->id,$user_id);
           $data->attachmentData=$this->getLessonAttachmentData($data->id);
           return $data;
        }
        else
        {
            return false;
        }  
    } 
    public function getLessonCommentData($id,$user_id) {
        $teacherid = $user_id;
        $this->db->select("cpc.id,cpc.user_id,cpc.comment,cpc.created_date,cpc.commentFrom as usertype,CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
        $this->db->from('lesson_note_comment cpc');
        $this->db->join('alluser u','cpc.user_id=u.id','INNER');
        $this->db->where('cpc.noteid', $id);
        $this->db->order_by('cpc.created_date','DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $datas=$query->result();
            for($i=0;$i<count($datas);$i++){
                $datas[$i]->is_delete=0;
                $datas[$i]->created_date= date('Y-m-d',strtotime($datas[$i]->created_date));
                if($teacherid==$datas[$i]->user_id){
                    $datas[$i]->is_delete=1;
                }
             }
        return $datas;
        } else {
        return array();
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

    public function getLessionCommentDataByCommentId($id,$user_id) {
        //$data = $this->session->userdata('teacher_data');
        $teacherid = $user_id;
        $this->db->select("cpc.id,cpc.user_id,cpc.comment,cpc.created_date,cpc.commentFrom as usertype, CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
        $this->db->from('lesson_note_comment cpc');
        $this->db->join('alluser u','cpc.user_id=u.id','INNER');
        $this->db->where('cpc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row=$query->row();
            $row->created_date= date('Y-m-d',strtotime($row->created_date));
            $row->is_delete=0;
            if($teacherid==$row->user_id){
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