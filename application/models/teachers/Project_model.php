<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Project_model extends CI_Model
	{
		
		public function add($data,$tbl_name)
		{
		$this->db->insert($tbl_name,$data);
		return $this->db->insert_id();
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
		public function getProjectList($teacher_id='',$filterbydate='',$class_id='',$subject_id='',$category='',$school_id=''){
			$currentSession = get_current_session($school_id);
        	$session_id = isset($currentSession) && $currentSession->id?$currentSession->id:'';
			$sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject  FROM project ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id where ast.status=1';	
		   if($class_id!='') {
			$sql .= ' AND ast.class_id="'.$class_id.'"';
			}
			if($subject_id!='') {
				$sql .= ' AND ast.subject_id="'.$subject_id.'"';
				
			}else{
				$sql .= ' AND ast.subject_id IN (select id from subjects  where teacher="'.$teacher_id.'")';
			}
			if($category!='') {
				$sql .= ' AND ast.category="'.$category.'"';
			}
			$sql .= ' AND ast.session_id="'.$session_id.'"';
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
		public function getProjectDetails($id=''){
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,group_concat(atch.attachment) as attachment,group_concat(atch.attachment_type) as attachment_type,group_concat(atch.id) as attachid FROM project ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join project_attachment atch on ast.id=atch.project_id where ast.id='.$id.' group by ast.id';
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
		public function getStudentSubmitedProjectList($schoolID='',$teacher_id='',$class_id='',$subject_id='',$category=''){
			$currentSession = get_current_session($schoolID);
        	$session_id = isset($currentSession) && $currentSession->id?$currentSession->id:'';
			$sql='SELECT ast.title,ast.category,ast.submission_date,asu.id as asid,asu.submission_date as datesubmited,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname from project ast inner join project_submission asu on ast.id =asu.project_id left join class c on ast.class_id =c.id left join subjects s on ast.subject_id =s.id left join child ch on asu.user_id =ch.id where ast.status=1';
				if($class_id!='') {
				$sql .= ' AND ast.class_id="'.$class_id.'"';
				}
				if($subject_id!='') {
					$sql .= ' AND ast.subject_id="'.$subject_id.'"';
					
				}else{
					$sql .= ' AND ast.subject_id IN (select id from subjects  where teacher="'.$teacher_id.'")';
				}
				if($category!='') {
					$sql .= ' AND ast.category="'.$category.'"';
				}
				$sql .= ' AND ast.session_id="'.$session_id.'"';
				$sql .= '  ORDER BY asu.id DESC';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($v=0; $v<count($data_user); $v++)
				{
					$data_user[$v]['latedays']=0;
					$data_user[$v]['project_status']='Submitted';
					if($data_user[$v]['submission_date']<$data_user[$v]['datesubmited']){
						$date1=date_create($data_user[$v]['datesubmited']);
						$date2=date_create($data_user[$v]['submission_date']);
						$diff=date_diff($date1,$date2);
						$data_user[$v]['latedays']=$diff->format("%a");
					}	
					$obtainedMarks	= $this->getAssignMarkData($data_user[$v]['asid'],$schoolID);
					if(!empty($obtainedMarks) && $data_user[$v]['category']=='graded'){
						$data_user[$v]['project_status']='Graded';
					}elseif(!empty($obtainedMarks) && $data_user[$v]['category']=='non-graded'){
						$data_user[$v]['project_status']='Marks Assigned';
					}	
				}
				return $data_user;
				
			}else{
				return array();
			}
		}

		public function getSubmitedProjectDetails($id=''){
			$currdate=date('Y-m-d');
			$sql='SELECT asu.*,ast.school_id,ast.class_id,ast.subject_id,ast.category,ast.total_marks,ast.title,ast.created  as dateofissue ,ast.submission_date as sdate,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM project_submission asu left join project ast on asu.project_id=ast.id left join project_submission_attachment sa on asu.id=sa.project_id left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join child ch on ch.id=asu.user_id where asu.id='.$id.' group by asu.id';
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
		public function assignProjectMarks($postData,$tbl_name){
			$this->db->select("*");
			$this->db->from($tbl_name);
			$this->db->where('submission_id', $postData['submission_id']);
			$this->db->where('school_id', $postData['school_id']);
			$query = $this->db->get();
			if ($query->num_rows() ==0) {
				unset($postData['title']);
				unset($postData['category']);
				unset($postData['updated_by']);
				unset($postData['updated_at']);
				unset($postData['submission_date']);
				$this->db->insert($tbl_name,$postData);
				return ($this->db->affected_rows()) ? 1: 0;
			}else{
				unset($postData['title']);
				unset($postData['category']);
				unset($postData['created_by']);
				unset($postData['created_at']);
				unset($postData['submission_date']);
				$this->db->where('submission_id',$postData['submission_id']);
				$this->db->where('school_id',$postData['school_id']);
				$this->db->update($tbl_name,$postData);
				return ($this->db->affected_rows()) ? 1: 0;
			}
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
		public function getStudentDetails($id)
		{
			$this->db->select("*");
			$this->db->where('id',$id);
			
			$query = $this->db->get('child');
			if($query->num_rows() > 0)
			{
				$result=$query->result_array();
				return $result;
			}
			else
			{
				return array();
			}
		}
}		