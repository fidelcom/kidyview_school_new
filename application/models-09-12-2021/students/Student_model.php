<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {
    public function getProfile($id){
        $this->db->select("c.*,s.school_name");
        $this->db->from("child c");
        $this->db->join("school s","c.schoolId = s.id");
        $this->db->where("c.id",$id);
        $this->db->where("c.schoolId",$this->token->school_id);
        $query = $this->db->get();
        if($query->num_rows() == 1)
        {
            return $query->row();
        }
        else
        {
            return false;
        }
    }
    public function updateChildPassword($childid,$data)
		{
			$this->db->where('id',$childid);
			$this->db->update('child',$data);
			if($this->db->affected_rows())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		public function getStudent($queryParameters)
		{
			$this->db->where($queryParameters);
			$this->db->where('status',1);
			$query =  $this->db->get('child');
			if($query->result_id->num_rows==1)
			{
				$data_user = $query->result_array();
				return $data_user[0];
			}
			else
			return false;
		}
		public function verifyStudentForgetPassword($data)
		{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("child_verification");
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function getStudentDetails($id)
		{
			$this->db->select("*");
			$this->db->where('id',$id);
			
			$query = $this->db->get('child');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}

		public function resetPasswordStudent($userID,$password)
		{
			$this->db->where('id',$userID);
			return $this->db->update('child',array('password'=> $password));
		}
		public function updateStudentVerificationStatus($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update("child_verification",$data);
			$this->db->query("UPDATE `verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
		}
   
    public function changePasswordStudent($oldPassword,$newPassword)
    {  
                $userDetail = $this->session->all_userdata();
                $id = $userDetail['student_data']['id'];                    
                $newPassword = array('password'=> $newPassword);
                $this->db->where('id',$id);
                $this->db->update('child',$newPassword);
                
                return ($this->db->affected_rows()) ? 1: 0;
    }
    public function addStudentHobie($id,$data)
    {
        $this->db->insert("student_hobie",$data);
        return $this->db->insert_id();
    }
    public function getStudentHobieList($id){
        $this->db->select("c.*");
        $this->db->from("student_hobie c");
        $this->db->where("c.student_id",$id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    public function delete($where=array(),$tbl_name='')
    {
        $this->db->where($where);
        $query = $this->db->delete($tbl_name);
        return $query;
    }
    public function addStudentQuote($id,$data)
    {
        $this->db->insert("student_quote",$data);
        return $this->db->insert_id();
    }
    public function getStudentQuoteList($id){
        $this->db->select("c.*");
        $this->db->from("student_quote c");
        $this->db->where("c.student_id",$id);
        $query = $this->db->get();
        //echo $this->db->last_query();
        if($query->num_rows() >0)
        {
            return $query->result_array();
        }
        else
        {
            return false;
        }
    }
    public function hobieExist($hobie)
		{
            $data = $this->session->userdata('student_data');
	        $id = $data['id'];
			$this->db->select("id`");
            $this->db->where('hobie_name',$hobie);
            $this->db->where('student_id',$id);
			$query = $this->db->get('student_hobie');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }
        public function quoteExist($hobie)
		{
            $data = $this->session->userdata('student_data');
	        $id = $data['id'];
			$this->db->select("id`");
            $this->db->where('quote_name',$hobie);
            $this->db->where('student_id',$id);
			$query = $this->db->get('student_quote');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }
        public function updateStudentHobie($id,$data)
        {
            $this->db->where("id",$id);
            $this->db->update("student_hobie",$data);
            return $this->db->affected_rows();
        }
        public function updateStudentQuote($id,$data)
        {
            $this->db->where("id",$id);
            $this->db->update("student_quote",$data);
            return $this->db->affected_rows();
        }
        public function getStudentAssignmentList($classID='',$user_id='',$filterbydate='',$subject_id='',$category=''){
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername FROM assignment ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join teacher t on s.teacher=t.id  where ast.class_id='.$classID.' AND ast.id NOT IN(select assignment_id from assignment_submission where user_id='.$user_id.')';
           $curdate=date('Y-m-d');
            if($filterbydate=='new'){
                $sql .= " AND ast.submission_date>='".$curdate."'";
            }elseif($filterbydate=='late'){
                $sql .= " AND ast.submission_date<'".$curdate."'";
            }
            if($subject_id!='') {
				$sql .= ' AND ast.subject_id="'.$subject_id.'"';
				
			}
			if($category!='') {
				$sql .= ' AND ast.category="'.$category.'"';
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

        public function getAssignmentDetails($id=''){
            $sdata = $this->session->userdata('student_data');
		    $sid = $sdata['id'];
            $currdate=date('Y-m-d');
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,group_concat(atch.attachment) as attachment,group_concat(atch.attachment_type) as attachment_type FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join assignment ast on ast.subject_id=s.id left join assignment_attachment atch on ast.id=atch.assignment_id where ast.id='.$id.' group by ast.id';
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
    public function getStudentSubmitAssignmentList($classID='',$user_id=''){
        $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,asu.id as asid,asu.submission_date as datesubmited FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join assignment ast on ast.subject_id=s.id inner join assignment_submission asu on asu.assignment_id=ast.id  where asu.user_id='.$user_id.'';
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            for($v=0; $v<count($data_user); $v++)
            {
                $data_user[$v]['assignment_status']='Submitted';
                $data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
                $data_user[$v]['currdate']= date('Y-m-d');
                $obtainedMarks	= $this->getAssignMarkData($data_user[$v]['asid'],$data_user[$v]['school_id']);
                if(!empty($obtainedMarks) && $data_user[$v]['category']=='graded'){
                    $data_user[$v]['assignment_status']='Graded';
                }elseif(!empty($obtainedMarks) && $data_user[$v]['category']=='non-graded'){
                    $data_user[$v]['assignment_status']='Marks Obtained';
                }
            }
            return $data_user;
            
        }else{
            return array();
        }
    }

    public function getSubmitAssignmentDetails($id=''){
        $currdate=date('Y-m-d');
        $sql='SELECT asu.*,ast.title,ast.school_id,ast.category,ast.total_marks,ast.created  as dateofissue ,ast.submission_date as sdate,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM assignment_submission asu inner join assignment ast on asu.assignment_id=ast.id inner join subjects s on ast.subject_id=s.id inner join class c on c.id=s.class inner join teacher t on s.teacher=t.id left join submission_attachment sa on asu.id=sa.assignment_id where asu.id='.$id.' group by asu.id';
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
        $sql='SELECT asu.*,GROUP_CONCAT(sa.id) as said,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM assignment_submission asu left join submission_attachment sa on asu.id=sa.assignment_id where asu.id='.$id.' group by asu.id';
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
    public function checkExistAssignment($assignment_id='',$user_id='')
		{
            $this->db->select("id`");
            $this->db->where('assignment_id',$assignment_id);
            $this->db->where('user_id',$user_id);
			$query = $this->db->get('assignment_submission');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }
        public function checkAssignmentSubmission($assignment_id='')
		{
            $curdate=date('Y-m-d');
            $this->db->select("id`");
            $this->db->where('id',$assignment_id);
            $this->db->where('submission_date <',$curdate);
			$query = $this->db->get('assignment');
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
        public function getStudentList($classID='',$child_id=''){
            $sql='SELECT ch.id,ch.childphoto,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as childname,GROUP_CONCAT(h.hobie_name) as hobie FROM child ch left join student_hobie h on ch.id=h.student_id where ch.childclass='.$classID.' AND ch.id!='.$child_id.' group by ch.id';
            $query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
            }
        }

        public function getTeacherDetails($teacher_id='',$classID=''){
            $sql='SELECT t.id,t.teacherphone,t.teachergender,t.teacherphoto,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,t.assignclassteacher,GROUP_CONCAT(s.subject) as subject,CONCAT(c.class," " ,c.section) as classname FROM teacher t inner join subjects s on s.teacher= t.id inner join class c on s.class= c.id where t.id='.$teacher_id.' AND s.class='.$classID.' group by t.id';
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
             return $data_user[0];
                
            }else{
                return array();
            }
        }
        public function getStudentDetailsById($child_id='',$classId=''){
            $sql='SELECT ch.id,ch.childgender,ch.childemail,ch.childphoto,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as childname,GROUP_CONCAT(h.hobie_name) as hobie FROM child ch left join student_hobie h on ch.id=h.student_id where ch.id='.$child_id.' group by ch.id';
            $query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user[0];
                
            }else{
                return array();
            }
        }

        public function getClassboardList($action='',$student_id='',$offset,$perpage){
            $sql="SELECT cb.*,CONCAT(c.class,' ' ,c.section) as classname from classboard cb inner join classboard_student cs on cb.id=cs.classboard_id inner join class c on cb.class_id=c.id where cs.student_id='".$student_id."' order by cb.id DESC";
            if($action=='data'){
				$sql .= " limit $offset,$perpage";
			}
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
				if($action=='data'){
				$data_user = $query->result_array();
				for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
				}
			
			 		return $data_user;
				}else{
					return $query->num_rows();

				}
                
            }else{
                return array();
            }
        }
        public function getClassboardPostList($action='',$classboard_id='',$student_id='',$offset='',$perpage=''){
            $sql="select cp.* ,CONCAT(c.class,' ' ,c.section) as classname,CONCAT(t.teacherfname,' ' ,t.teachermname,' ' ,t.teacherlname) as teachername,t.teacherphoto from classboard_post cp inner join classboard cb on cp.classboard_id=cb.id inner join teacher t on cb.teacher_id=t.id inner join class c on cb.class_id=c.id where cp.classboard_id=".$classboard_id." order by cp.id DESC";
			if($action=='data'){
				$sql .= " limit $offset,$perpage";
			}
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
				$data_user = $query->result_array();
				if($action=='data'){
					$data_user = $query->result_array();
					for($v=0; $v<count($data_user); $v++)
					{
						$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
						$data_user[$v]['attachmentData']		= $this->getPostAttachment($data_user[$v]['id']);
						$data_user[$v]['commentData']		= $this->getPostCommentData($data_user[$v]['id'],$student_id);
					}
				
						 return $data_user;
					}else{
						return $query->num_rows();
	
					} 
				}else{
					return array();
				}
        }
        public function getPostAttachment($id) {
			$this->db->select('id,attachment as file,type');
			$this->db->from('classboard_post_attachment');
			$this->db->where('post_id', $id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
				} else {
				return array();
			}
		}
		public function getPostCommentData($id,$student_id) {
            $student_id="ST-".$student_id;
			$this->db->select("cpc.id,cpc.comment,cpc.user_id,cpc.created,CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
			$this->db->from('classboard_post_comment cpc');
			$this->db->join('alluser u','cpc.user_id=u.id','INNER');
			$this->db->where('cpc.post_id', $id);
			$this->db->order_by('cpc.created','DESC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
                $data_user=$query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
                    $data_user[$v]['is_deleted']= 0;
                    if($student_id==$data_user[$v]['user_id']){
					$data_user[$v]['is_deleted']= 1;
                    }
                    $data_user[$v]['created']= time_elapsed_string($data_user[$v]['created']);
                }
                return $data_user;
				} else {
				return array();
			}
        }
        public function getPostCommentDataByCommentId($id,$student_id=''){
            $student_id="ST-".$student_id;
			$this->db->select("cpc.id,cpc.comment,cpc.user_id,cpc.created, CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
			$this->db->from('classboard_post_comment cpc');
			$this->db->join('alluser u','cpc.user_id=u.id','INNER');
			$this->db->where('cpc.id', $id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				$data_user=$query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
                    $data_user[$v]['is_deleted']= 0;
                    if($student_id==$data_user[$v]['user_id']){
					$data_user[$v]['is_deleted']= 1;
                    }
                    $data_user[$v]['created']= time_elapsed_string($data_user[$v]['created']);
                }
                return $data_user[0];
				} else {
				return array();
			}
        }
        public function getAssignmentAttempt($assignment_id='')
		{
            $this->db->select('no_of_attempt');
            $this->db->where('id',$assignment_id);
			$query = $this->db->get('assignment');
			return $query->row('no_of_attempt');
        }
        public function userAttemptCount($assignment_id='',$user_id)
		{
            $this->db->select('*');
            $this->db->where('assignment_id',$assignment_id);
            $this->db->where('user_id',$user_id);
			$query = $this->db->get('assignment_submission_attempt');
			return $query->num_rows();
        }
        public function loginImage()
		{
            $this->db->select("image,bg_image");
            $this->db->where('login_screen','Student Login');
            $query = $this->db->get('login_image');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
        }
        public function getAssignedTeacher($subject_id=''){
            $this->db->select('t.id,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername');
            $this->db->from("teacher t");
            $this->db->join("subjects s","t.id = s.teacher",'INNER');
            $this->db->where("s.id",$subject_id);
            $query = $this->db->get();
            if($query->num_rows() == 1)
            {
                return $query->row();
            }
            else
            {
                return '';
            }
        }
        public function getAssignMarkData($id='',$school_id=''){
			$this->db->select("*");
			$this->db->from('assignment_marks_obtain');
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
