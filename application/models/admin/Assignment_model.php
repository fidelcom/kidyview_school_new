<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Assignment_model extends CI_Model
	{
		public function updateVerificationStatus($id, $data) {
			$this->db->where('id', $id);
			$this->db->update("verification", $data);
			$this->db->query("UPDATE `verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
		}		
	
		public function validate($email, $phn) {
			if (!empty($email)) {
				$this->db->from('teacher u');
				$this->db->where('u.status', 1);
				$this->db->where('u.teacheremail', $email);
				$query = $this->db->get();
			} else {
				$this->db->select("*");
				$this->db->from('teacher u');
				$this->db->where('u.status', 1);
				$this->db->where('u.teacherphone', $phn);
				$query = $this->db->get();
			}
	
			if ($query->num_rows() == 1) {
				return $query->row();
			} else {
				return false;
			}
		}
	
		public function addToken($data) {
			$this->db->insert('user_token', $data);
		}
	
		public function editTeacher($data, $teacherID) {
			$this->db->where('id', $teacherID);
			$this->db->update('teacher', $data);
			return ($this->db->affected_rows()) ? 1 : 0;
		}
	
		public function isotpvalid($otp, $user_id) {
			$this->db->select('*');
			$this->db->from('teacher u');
	
			$this->db->where(array('u.otp' => $otp, 'u.id' => $user_id, 'u.status' => 1));
			$this->db->limit(1);
	
			$this->db->order_by('u.id', 'desc');
			$query = $this->db->get();
	
			//echo $this->db->last_query(); die;
	
			if ($query->num_rows() > 0) {
				$user = $query->row();
				return $user;
			}
	
			return false;
		}
	
		public function getStudentList($teacher_id=''){
			$this->db->select("assignclassteacher");
			$this->db->from('teacher');
			$this->db->where('id',$teacher_id);
			$query = $this->db->get();
			$teacherdata=$query->row();
			$classid='NULL';
			if(!empty($teacherdata) && $teacherdata->assignclassteacher!=''){
				$classid=$teacherdata->assignclassteacher;
			}
            $sql='SELECT ch.id,ch.childphoto,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as childname,GROUP_CONCAT(h.hobie_name) as hobie,CONCAT(c.class," " ,c.section) as classname FROM child ch inner join (select id,class,section from class where id in ('.$classid.')) c on ch.childclass=c.id left join student_hobie h on ch.id=h.student_id  group by ch.id';
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
            }
		}
		
		public function getStudentDetailsById($child_id=''){
            $sql='SELECT ch.id,ch.childphoto,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as childname,GROUP_CONCAT(h.hobie_name) as hobie,CONCAT(c.class," " ,c.section) as classname FROM child ch left join class c on ch.childclass=c.id left join student_hobie h on ch.id=h.student_id where ch.id='.$child_id.' group by ch.id';
            $query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
				$data_user = $query->result_array();
				for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['parentData']= $this->getParentData($child_id);
				}
             	return $data_user[0];
                
            }else{
                return array();
            }
		}
		public function getParentData($child_id=''){
			$this->db->select("id,CONCAT(fatherfname,' ',fatherlname) as fname,fatheremail,CONCAT(motherfname,' ',motherlname) as mname,motheremail");
			$where = "FIND_IN_SET('".$child_id."', child_id)";
			$this->db->where($where);
			$query = $this->db->get('parent');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function getTeacherClass($teacher_id='',$school_id=''){
			$this->db->select("assignclassteacher");
			$this->db->from('teacher');
			$this->db->where('id',$teacher_id);
			$query = $this->db->get();
			$teacherdata=$query->row();
			$classid='NULL';
			if(!empty($teacherdata) && $teacherdata->assignclassteacher!=''){
				$classid=$teacherdata->assignclassteacher;
			}
            $sql='select c.id,CONCAT(c.class," " ,c.section) as classname,s.school_name from class c inner join school s on c.schoolId=s.id where c.id IN ('.$classid.') AND schoolId='.$school_id.'';
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
			}
		}
		public function getStudentByClass($teacher_id='',$class_id=''){
			$this->db->select("assignclassteacher");
			$this->db->from('teacher');
			$this->db->where('id',$teacher_id);
			$query = $this->db->get();
			$teacherdata=$query->row();
			$classid='NULL';
			if(!empty($teacherdata) && $teacherdata->assignclassteacher!=''){
				$classid=$teacherdata->assignclassteacher;
			}
			if($class_id){
				$classid=$class_id;
			}
            $sql='SELECT ch.id,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as childname FROM child ch inner join (select id,class,section from class where id in ('.$classid.')) c on ch.childclass=c.id group by ch.id';
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
            }
		}
		public function classboardExist($name='',$classboard_id='')
		{
            $data = $this->session->userdata('teacher_data');
	        $id = $data['id'];
			$this->db->select("id`");
            $this->db->where('name',$name);
			$this->db->where('teacher_id',$id);
			if($classboard_id!=''){
				$this->db->where_not_in('id',$classboard_id);
			}
			$query = $this->db->get('classboard');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function add($data,$tbl_name)
		{
		$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
		}

		public function getClassboardList($action='',$teacher_id='',$offset,$perpage){
            $sql="SELECT cb.*,CONCAT(c.class,' ' ,c.section) as classname,s.school_name  from classboard cb inner join class c on cb.class_id=c.id inner join school s on c.schoolId=s.id where cb.teacher_id='".$teacher_id."' order by cb.id DESC";
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
		public function getClassboardDetails($classboardid=''){
            $sql="SELECT cb.*,GROUP_CONCAT(cs.student_id) as stid from classboard cb inner join classboard_student cs on cb.id=cs.classboard_id where cb.id=".$classboardid." group by cb.id";
			$query=$this->db->query($sql);
			//echo $sql;
            if($query->num_rows() > 0)
            {
				$data_user = $query->result_array();
             return $data_user[0];
                
            }else{
                return array();
            }
		}
		public function update($data,$tbl_name,$where=array())
		{
			$this->db->where($where);
			$this->db->update($tbl_name,$data);
			return true;
		}
		public function delete($where=array(),$tbl_name='')
		{
			$this->db->where($where);
			$query = $this->db->delete($tbl_name);
			return $query;
		}
		public function getClassboardPostList($action='',$classboard_id='',$teacher_id='',$offset='',$perpage=''){
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
						$data_user[$v]['commentData']		= $this->getPostCommentData($data_user[$v]['id']);
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
		public function getPostCommentData($id) {
			$this->db->select("cpc.id,cpc.comment,cpc.created,CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
			$this->db->from('classboard_post_comment cpc');
			$this->db->join('alluser u','cpc.user_id=u.id','INNER');
			$this->db->where('cpc.post_id', $id);
			$this->db->order_by('cpc.created','DESC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
				} else {
				return array();
			}
		}
		public function getPostCommentDataByCommentId($id) {
			$this->db->select("cpc.id,cpc.comment,cpc.created, CONCAT(u.fname, ' ', u.lname) AS uname,u.photo,u.user_type");
			$this->db->from('classboard_post_comment cpc');
			$this->db->join('alluser u','cpc.user_id=u.id','INNER');
			$this->db->where('cpc.id', $id);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->row();
				} else {
				return array();
			}
		}
		public function getAssignmentList($schoolId='',$filterbydate='',$class_id='',$subject_id='',$category=''){
			
			$sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject  FROM assignment ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join sessions si ON ast.session_id=si.id where ast.status=1 AND si.current_sesion=1';	
			if($class_id!='') {
			$sql .= ' AND ast.class_id="'.$class_id.'"';
			}
			if($subject_id!='') {
				$sql .= ' AND ast.subject_id="'.$subject_id.'"';
				
			}else{
				$sql .= ' AND ast.subject_id IN (select id from subjects  where schoolId="'.$schoolId.'")';
			}
			if($category!='') {
				$sql .= ' AND ast.category="'.$category.'"';
			}
			$sql .= ' ORDER BY ast.id DESC';
		   $query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
				}
				return $data_user;
				
            }else{
                return array();
            }
		}
		public function getAssignmentDetails($id=''){
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,group_concat(atch.attachment) as attachment,group_concat(atch.attachment_type) as attachment_type,group_concat(atch.id) as attachid FROM assignment ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join assignment_attachment atch on ast.id=atch.assignment_id where ast.id='.$id.' group by ast.id';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
				}
				return $data_user[0];
				
            }else{
                return array();
            }
		}
		public function getSchoolSubject($class_id='',$school_id=''){
			
            $sql='select s.subject,s.id from subjects s where s.class="'.$class_id.'" AND s.schoolId="'.$school_id.'"';
			$query=$this->db->query($sql);
            if($query->num_rows() > 0)
            {
                $data_user = $query->result_array();
             return $data_user;
                
            }else{
                return array();
			}
		}
		public function getSchoolSubjectClass($schoolId=''){
			
            $sql='SELECT c.id,CONCAT(c.class," " ,c.section) as classname from class c where c.schoolId="'.$schoolId.'" AND c.status=1 group by c.id';
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
		public function getStudentSubmitedAssignmentList($schoolID='',$class_id='',$subject_id='',$category=''){
			$sql='SELECT ast.title,ast.category,ast.class_id,ast.subject_id,ast.submission_date,asu.id as asid,asu.submission_date as datesubmited,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname from assignment ast inner join assignment_submission asu on ast.id =asu.assignment_id left join class c on ast.class_id =c.id left join subjects s on ast.subject_id =s.id left join child ch on asu.user_id =ch.id left join sessions si ON ast.session_id=si.id where ast.status=1 AND si.current_sesion=1';
			if($class_id!='') {
				$sql .= ' AND ast.class_id="'.$class_id.'"';
				}
				if($subject_id!='') {
					$sql .= ' AND ast.subject_id="'.$subject_id.'"';
					
				}else{
					// $sql .= ' AND ast.subject_id IN (select id from subjects  where teacher="'.$teacher_id.'")';
				}
				if($category!='') {
					$sql .= ' AND ast.category="'.$category.'"';
				}
				$sql .= '  ORDER BY asu.id DESC';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['assignment_status']='Submitted';
					$data_user[$v]['latedays']=0;
					if($data_user[$v]['submission_date']<$data_user[$v]['datesubmited']){
						$date1=date_create($data_user[$v]['datesubmited']);
						$date2=date_create($data_user[$v]['submission_date']);
						$diff=date_diff($date1,$date2);
						$data_user[$v]['latedays']=$diff->format("%a");
					}	
					$obtainedMarks	= $this->getAssignMarkData($data_user[$v]['asid'],$schoolID);
					if(!empty($obtainedMarks) && $data_user[$v]['category']=='graded'){
						$data_user[$v]['assignment_status']='Graded';
					}elseif(!empty($obtainedMarks) && $data_user[$v]['category']=='non-graded'){
						$data_user[$v]['assignment_status']='Marks Assigned';
					}

				}
				return $data_user;
			prd($data_user);	
			}else{
				return array();
			}
		}

		public function getSubmitedAssignmentDetails($id=''){
			$currdate=date('Y-m-d');
			$sql='SELECT asu.*,ast.school_id,ast.class_id,ast.subject_id,ast.category,ast.total_marks,ast.title,ast.created  as dateofissue ,ast.submission_date as sdate,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM assignment_submission asu left join assignment ast on asu.assignment_id=ast.id left join submission_attachment sa on asu.id=sa.assignment_id left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join child ch on ch.id=asu.user_id where asu.id='.$id.' group by asu.id';
			//echo $sql;die;
			$query=$this->db->query($sql);
			
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				
				for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
					$data_user[$v]['getAssignMarkData']=$this->getAssignMarkData($data_user[$v]['id'],$data_user[$v]['school_id']);
				}
				
				return $data_user[0];
				
			}else{
				return array();
			}
		}
		public function getTeacher($queryParameters)
		{
			$this->db->where($queryParameters);
			$this->db->where('status',1);
			$query =  $this->db->get('teacher');
			if($query->result_id->num_rows==1)
			{
				$data_user = $query->result_array();
				return $data_user[0];
			}
			else
			return false;
		}
		public function verifyTeacherForgetPassword($data)
		{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("teacher_verification");
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function getSchoolDetails($id)
		{
			$this->db->select("*");
			$this->db->where('school_id',$id);
			
			$query = $this->db->get('school_admin');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function resetPasswordTeacher($userID,$password)
		{
			$this->db->where('id',$userID);
			return $this->db->update('teacher',array('password'=> $password));
		}
		public function updateTeacherVerificationStatus($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update("teacher_verification",$data);
			$this->db->query("UPDATE `teacher_verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
		}
		public function changePasswordTeacher($oldPassword,$newPassword)
		{  
					$userDetail = $this->session->all_userdata();
					$id = $userDetail['teacher_data']['id'];                    
					$newPassword = array('password'=> $newPassword);
					$this->db->where('id',$id);
					$this->db->update('teacher',$newPassword);
					return ($this->db->affected_rows()) ? 1: 0;
		}
		public function loginImage()
		{
            $this->db->select("image`");
            $this->db->where('login_screen','Teacher Login');
            $query = $this->db->get('login_image');
			if($query->num_rows() > 0)
			{
				return $query->row('image');
			}
			else
			{
				return false;
			}
		}
		public function getTeacherProfileDetails($teacher_id=''){
            $sql='SELECT t.id,t.teacheremail,t.teacherphone,t.teacherphoto,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,t.assignclassteacher,GROUP_CONCAT(s.subject) as subject FROM teacher t left join subjects s on s.teacher= t.id where t.id='.$teacher_id.' group by t.id';
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
		public function getStudentByClassId($class_id='')
		{
            $this->db->select("id`,childemail");
            $this->db->where('childclass',$class_id);
            $query = $this->db->get('child');
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return array();
			}
		}
		public function assignAssignmentMarks($postData,$tbl_name){
			$this->db->select("*");
			$this->db->from($tbl_name);
			$this->db->where('submission_id', $postData['submission_id']);
			$this->db->where('school_id', $postData['school_id']);
			$query = $this->db->get();
			if ($query->num_rows() ==0) {
				unset($postData['category']);
				unset($postData['updated_by']);
				unset($postData['updated_at']);
				$this->db->insert($tbl_name,$postData);
				return ($this->db->affected_rows()) ? 1: 0;
			}else{
				unset($postData['category']);
				unset($postData['created_by']);
				unset($postData['created_at']);
				$this->db->where('submission_id',$postData['submission_id']);
				$this->db->where('school_id',$postData['school_id']);
				$this->db->update($tbl_name,$postData);
				return ($this->db->affected_rows()) ? 1: 0;
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