<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_model extends CI_Model {
    
    public function delete($where=array(),$tbl_name='')
    {
        $this->db->where($where);
        $query = $this->db->delete($tbl_name);
        return $query;
    }
    
        public function getStudentProjectList($classID='',$user_id='',$filterbydate=''){
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join project ast on ast.subject_id=s.id where c.id='.$classID.' AND ast.id NOT IN(select project_id from project_submission where user_id='.$user_id.')';
           $curdate=date('Y-m-d');
            if($filterbydate=='new'){
                $sql .= " AND ast.submission_date>='".$curdate."'";
            }elseif($filterbydate=='late'){
                $sql .= " AND ast.submission_date<'".$curdate."'";
            }
            //echo $sql;
            $query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
                    $data_user[$v]['userAttemptCount']=$this->userAttemptCount($data_user[$v]['id'],$user_id);
					$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
                    if($data_user[$v]['open_submission_date']<=$curdate && $data_user[$v]['open_submission_date']!='NULL'){
                        $data_user[$v]['isAssignmentOpen']=1;
                    }else{
                        $data_user[$v]['isAssignmentOpen']=0;
                    }
                }
                //print_r($data_user);
				return $data_user;
				
            }else{
                return array();
            }
        }

        public function getProjectDetails($id=''){
            $sdata = $this->session->userdata('student_data');
		    $sid = $sdata['id'];
            $currdate=date('Y-m-d');
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,group_concat(atch.attachment) as attachment,group_concat(atch.attachment_type) as attachment_type FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join project ast on ast.subject_id=s.id left join project_attachment atch on ast.id=atch.project_id where ast.id='.$id.' group by ast.id';
            $query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
                    if($data_user[$v]['submission_date']<$currdate){
                        $date1=date_create($currdate);
                        $date2=date_create($data_user[$v]['submission_date']);
                        $diff=date_diff($date1,$date2);
                        $data_user[$v]['latedays']=$diff->format("%a");
                        $data_user[$v]['leftdays']='';
                    }elseif($data_user[$v]['submission_date']>=$currdate){
                        $date1=date_create($data_user[$v]['submission_date']);
                        $date2=date_create($currdate);
                        $diff=date_diff($date1,$date2);
                        $data_user[$v]['leftdays']=$diff->format("%a");
                        $data_user[$v]['latedays']='';
                    }
                    $data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
                    $data_user[$v]['userAttemptCount']=$this->userAttemptCount($data_user[$v]['id'],$sid);
                     if($data_user[$v]['open_submission_date']<=$currdate && $data_user[$v]['open_submission_date']!='NULL'){
                        $data_user[$v]['isAssignmentOpen']=1;
                    }else{
                        $data_user[$v]['isAssignmentOpen']=0;
                    }
                }
				return $data_user[0];
				
            }else{
                return array();
            }
        }

    public function add($data,$tbl_name)
    {
        $this->db->insert($tbl_name,$data);
        return $this->db->insert_id();
    }
    public function getStudentSubmitProjectList($classID='',$user_id=''){
        $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,asu.id as asid,asu.submission_date as datesubmited FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join project ast on ast.subject_id=s.id inner join project_submission asu on asu.project_id=ast.id  where asu.user_id='.$user_id.'';
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            for($v=0; $v<count($data_user); $v++)
            {
                $data_user[$v]['project_status']='Submitted';
                $data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
                $data_user[$v]['currdate']= date('Y-m-d');
                $obtainedMarks	= $this->getAssignMarkData($data_user[$v]['asid'],$data_user[$v]['school_id']);
                //print_r($obtainedMarks);
                if(!empty($obtainedMarks) && $data_user[$v]['category']=='graded'){
                    $data_user[$v]['project_status']='Graded';
                }elseif(!empty($obtainedMarks) && $data_user[$v]['category']=='non-graded'){
                    $data_user[$v]['project_status']='Marks Obtained';
                }
            }
            return $data_user;
            
        }else{
            return array();
        }
    }

    public function getSubmitProjectDetails($id=''){
        $currdate=date('Y-m-d');
        $sql='SELECT asu.*,ast.title,ast.school_id,ast.category,ast.total_marks,ast.created  as dateofissue ,ast.submission_date as sdate,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM project_submission asu inner join project ast on asu.project_id=ast.id inner join subjects s on ast.subject_id=s.id inner join class c on c.id=s.class inner join teacher t on s.teacher=t.id left join project_submission_attachment sa on asu.id=sa.project_id where asu.id='.$id.' group by asu.id';
        $query=$this->db->query($sql);
        
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            
            for($v=0; $v<count($data_user); $v++)
            {
                if($data_user[$v]['submission_date']>$data_user[$v]['sdate']){
                    $date1=date_create($data_user[$v]['sdate']);
                    $date2=date_create($data_user[$v]['submission_date']);
                    $diff=date_diff($date1,$date2);
                    $data_user[$v]['latedays']=$diff->format("%a");
                    $data_user[$v]['leftdays']='';
                }elseif($data_user[$v]['submission_date']<=$data_user[$v]['sdate']){
                    $date1=date_create($currdate);
                    $date2=date_create($data_user[$v]['sdate']);
                    $diff=date_diff($date1,$date2);
                    $data_user[$v]['leftdays']=$diff->format("%a");
                    $data_user[$v]['latedays']='';
                }
                $data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
                $data_user[$v]['dateofissue']= date('Y-m-d',strtotime($data_user[$v]['dateofissue']));
                $data_user[$v]['getAssignMarkData']=$this->getAssignMarkData($data_user[$v]['id'],$data_user[$v]['school_id']);
            }
            return $data_user[0];
            
        }else{
            return array();
        }
    }
    public function editSubmitAtachmentDetails($id=''){
        $sql='SELECT asu.*,GROUP_CONCAT(sa.id) as said,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM project_submission asu left join project_submission_attachment sa on asu.id=sa.project_id where asu.id='.$id.' group by asu.id';
        $query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
    }
    public function update($data,$tbl_name,$where=array())
    {
        $this->db->where($where);
        $this->db->update($tbl_name,$data);
        return $this->db->affected_rows();
    }
    public function checkExistProject($assignment_id='',$user_id='')
		{
            $this->db->select("id`");
            $this->db->where('project_id',$assignment_id);
            $this->db->where('user_id',$user_id);
			$query = $this->db->get('project_submission');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }
        public function checkProjectSubmission($assignment_id='')
		{
            $curdate=date('Y-m-d');
            $this->db->select("id`");
            $this->db->where('id',$assignment_id);
            $this->db->where('submission_date <',$curdate);
			$query = $this->db->get('project');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }

        public function getTeacherList($classID=''){
            $sql='SELECT t.id,t.teacherphoto,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,t.assignclassteacher,GROUP_CONCAT(s.subject) as subject FROM teacher t inner join subjects s on s.teacher= t.id where s.class='.$classID.' group by t.id';
            $query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
                {
                $class_id=$data_user[$v]['assignclassteacher'];
                $classData=$this->assignteacherclass($class_id);
                if(!empty($classData)){
                $data_user[$v]['assignclass']= implode(',',$classData);
                }else{
                $data_user[$v]['assignclass']='';
                }
                
            }
             return $data_user;
                
            }else{
                return array();
            }
        }
        public function assignteacherclass($class_id=''){
                $sql='SELECT CONCAT(c.class," " ,c.section) as classname from class c where id IN ('.$class_id.')';
                $query=$this->db->query($sql);
                $data_class = $query->result_array();
                $classArr=array();
                if(!empty($data_class)){
                    foreach($data_class as $class){
                        $classArr[]=$class['classname'];
                    }
                }
                return $classArr;
        }
        
        public function getProjectAttempt($assignment_id='')
		{
            $this->db->select('no_of_attempt');
            $this->db->where('id',$assignment_id);
			$query = $this->db->get('project');
			return $query->row('no_of_attempt');
        }
        public function userAttemptCount($assignment_id='',$user_id)
		{
            $this->db->select('*');
            $this->db->where('project_id',$assignment_id);
            $this->db->where('user_id',$user_id);
			$query = $this->db->get('project_submission_attempt');
			return $query->num_rows();
        }  
        public function getAssignMarkData($id='',$school_id=''){
			$this->db->select("*");
			$this->db->from('project_marks_obtain');
			$this->db->where('submission_id', $id);
			$this->db->where('school_id', $school_id);
			$query = $this->db->get();
			$result=$query->result_array();
			if ($query->num_rows() > 0) {
				return $result[0];
			}else{
				return array();
			}
		}
}
