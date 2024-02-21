<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
class Lessonnote_model extends CI_Model
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
            for($i=0;$i<count($data);$i++){
                if($data[$i]->status==0){
                    $data[$i]->status='Not Approved';
                   }
                   if($data[$i]->status==1){
                    $data[$i]->status='Approved';
                   }  
            }
            //echo $this->db->last_query();
            return $data;
        } else {
            return array();
        }
    }
    function allDataCount(){
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $where = array('ln.teacherid' => $teacher_id,'ln.schoolId' => $schoolId);
        $this->db->select("count(ln.id) as total");
        $this->db->from('lesson_note as ln');
        $this->db->join('terms as t', 't.id = ln.term', 'LEFT');
        $this->db->join('subjects as s', 's.id = ln.subject', 'LEFT');
        $this->db->where($where);
        //$this->db->group_by('ln.id');            
        $query = $this->db->get();
        //echo $this->db->last_query();die;
        return $query->row()->total;
    }


    function allSharedData() {
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        
        $dataQuery = "select 
         ln.*,
         t.termname as 	termname,
         CONCAT(s.subject,'-',s.subject_code) as subjectname
         from  lesson_note as ln 
         left join terms as t on t.id = ln.term 
         left join subjects as s on s.id = ln.subject 
         where FIND_IN_SET($teacher_id, ln.teacherlist) And ln.schoolId='".$schoolId."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithteacher = '1'  And ln.status = '1'";  
        
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
            $dataQuery .= " limit $offset , $limit";
        }
       // echo $dataQuery;die;
        $query = $this->db->query($dataQuery);
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            for($i=0;$i<count($data);$i++){
                if($data[$i]['status']==0){
                    $data[$i]['status']='Not Approved';
                   }
                   if($data[$i]['status']==1){
                    $data[$i]['status']='Approved';
                   }  
            }
            return $data;
        } else {
            return array();
        }
    }
    function allSharedDataCount(){
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $dataQuery = "select 
         count(ln.id) as total
         from  lesson_note as ln 
         left join terms as t on t.id = ln.term 
         left join subjects as s on s.id = ln.subject 
         where FIND_IN_SET($teacher_id, ln.teacherlist) And ln.schoolId='".$schoolId."' And ln.fromdate<='".date('Y-m-d')."' And ln.todate>='".date('Y-m-d')."'  And ln.sharewithteacher = '1'  And ln.status = '1'";  
        
        $query = $this->db->query($dataQuery);
        return $query->row()->total;
    }
    
     
     public function getDetail($noteid)
    {
        $schoolID = $this->token->school_id; 
        $user_id = $this->token->user_id;
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
           if($data->status==0){
            $data->status='Not Approved';
           }
           if($data->status==1){
            $data->status='Approved';
           }  
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
                //$is_image = file_exists('img/teacher/'.$datas[$i]->photo);
                if($datas[$i]->user_type=='Teacher' && file_exists('img/teacher/'.$datas[$i]->photo)){
                    $datas[$i]->photoUrl= base_url().'img/teacher/'.$datas[$i]->photo;
                }elseif($datas[$i]->user_type=='School' && file_exists('img/school/'.$datas[$i]->photo)){
                    $datas[$i]->photoUrl= base_url().'img/school/'.$datas[$i]->photo;
                }elseif($datas[$i]->user_type=='Student' && file_exists('img/child/'.$datas[$i]->photo)){
                    $datas[$i]->photoUrl= base_url().'img/child/'.$datas[$i]->photo;
                }else{
                    $datas[$i]->photoUrl= base_url().'img/noImage.png';
                }
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