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
    public function getTeacherSubjectClass($teacher_id=''){
			
        $sql='SELECT c.id,CONCAT(c.class," " ,c.section) as classname from class c left join subjects s on c.id=s.class left join sessions sess on c.schoolId=sess.schoolId where s.teacher="'.$teacher_id.'" AND sess.current_sesion= 1 group by c.id';
        //echo $sql;die;
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
         return $data_user;
            
        }else{
            return array();
        }
    }
    
    public function getAllClassForSchool($schoolId,$teacher_id,$isShared) 
    {
        
       /* $where = array('c.schoolId' => $id, 'c.status' => 1, 's.current_sesion' => 1);
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
            return false;*/
            if($isShared==1){
                $sql='SELECT c.id,CONCAT(c.class," " ,c.section) as classname from class c left join subjects s on c.id=s.class left join sessions sess on c.schoolId=sess.schoolId where sess.current_sesion= 1 group by c.id';
            }else{
                $sql='SELECT c.id,CONCAT(c.class," " ,c.section) as classname from class c left join subjects s on c.id=s.class left join sessions sess on c.schoolId=sess.schoolId where s.teacher="'.$teacher_id.'" AND sess.current_sesion= 1 group by c.id';   
            }
            //echo $sql;die;
            $query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
            }
    }
    
    
    public function getsubject($class_id,$teacher_id,$isShared) 
    {
       /* $where = array('s.schoolId' => $schoolID, 's.status' => 1);
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
        */
        if($isShared==1){
            $sql='select s.subject,s.subject_code,s.id from subjects s where s.class="'.$class_id.'"';
        }else{
            
            $sql='select s.subject,s.subject_code,s.id from subjects s where s.class="'.$class_id.'" AND s.teacher="'.$teacher_id.'"';
        }
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
         return $data_user;
            
        }else{
            return array();
        }
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
        $where = array('ln.teacherid' => $teacherid,'ln.schoolId' => $schoolID,'si.current_sesion'=>1);
        $this->db->select(
        'ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,"-",s.subject_code) as subjectname,  
         ');
        $this->db->from('lesson_note as ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
        $this->db->join('subjects as s', 's.id = ln.subject', 'LEFT');
        $this->db->join('sessions as si', 'ln.session_id = si.id', 'LEFT');
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
         left join sessions si ON ln.session_id=si.id 
         where FIND_IN_SET($teacherid, ln.teacherlist) And ln.schoolId='".$schoolID."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithteacher = '1'  And ln.status = '1' AND si.current_sesion=1";  
        
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
                //$datas[$i]->created_date= date('Y-m-d',strtotime($datas[$i]->created_date));
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
        $this->db->join('sessions si','ln.session_id = si.id','left');
        $this->db->where($where);
        $this->db->where(array('si.current_sesion'=>1));
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
            //$row->created_date= date('Y-m-d',strtotime($row->created_date));
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