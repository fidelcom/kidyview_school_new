<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Project_model extends CI_Model
	{
		
		public function add($data,$tbl_name)
		{
			$this->db->insert($tbl_name,$data);
			return $this->db->insert_id();
		}
		function addProjectAssignment($data) {
        	$this->db->insert('project', $data);
        	return $this->db->insert_id();
    	}
    	function addAttachment($data) {
        	$this->db->insert('project_attachment', $data);
        	return $this->db->insert_id();
    	}
    	function updateProjectAssignment($id,$data) {
        	$this->db->where('id',$id);
        	$this->db->update('project', $data);
    	}
    	public function getSubjectList()
	    {
	        $this->db->select('s.*,c.class as class_name,c.section,t.teacherfname,t.teachermname,t.teacherlname');
	        $this->db->from('subjects s');
	        $this->db->join('class c','s.class = c.id','LEFT');
	        $this->db->join('teacher t','s.teacher = t.id','LEFT');
	        $this->db->where('s.schoolId', $this->token->school_id);
	        $this->db->where('s.teacher', $this->token->user_id);
	        $this->db->order_by('s.id', 'DESC');
	        $query =  $this->db->get();                    

	        if($query->result_id->num_rows!=0)
	        {
	                $data_user = $query->result_array();
	                return $data_user;
	        }
	        else
	        {
	            return array();
	        }
	    }
	    function allData() {
        $schoolId = $this->token->school_id; 
        $teacher_id = $this->token->user_id;
        $session_id= get_current_session($schoolId)->id;
        $this->db->select("p.*");
        $this->db->from("project p");
		$this->db->where("p.school_id",$schoolId);
		$this->db->where("p.session_id",$session_id);
        $this->db->where("p.status",1);
        $this->db->order_by("p.id","DESC");
        
        if(isset($_GET['subject_id']))
        {
            if($_GET['subject_id'] != '')
            {
                $this->db->where('subject_id',$_GET['subject_id']);
            }
        }
        
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
        $session_id= get_current_session($schoolId)->id;
        $this->db->select("count(p.id) as total");
        $this->db->from("project p");
        $this->db->where("p.school_id",$schoolId);
        $this->db->where("p.status",1);
        $this->db->where("p.session_id",$session_id);
        if(isset($_GET['subject_id']))
        {
            if($_GET['subject_id'] != '')
            {
                $this->db->where('subject_id',$_GET['subject_id']);
            }
        }
                        
        $query = $this->db->get();
        return $query->row()->total;
    }
    public function getAttachment($id) {
        $this->db->select('id,attachment as file');
        $this->db->from('project_attachment');
        $this->db->where('project_id', $id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
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
		public function getProjectList($school_id='',$filterbydate='',$class_id='',$subject_id='',$category=''){
           $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject  FROM project ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join sessions si ON ast.session_id=si.id where ast.status=1 AND si.current_sesion=1';	
		   if($class_id!='') {
			$sql .= ' AND ast.class_id="'.$class_id.'"';
			}
			if($subject_id!='') {
				$sql .= ' AND ast.subject_id="'.$subject_id.'"';
				
			}else{
				$sql .= ' AND ast.school_id="'.$school_id.'"';
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
		public function getProjectDetails($id='',$school_id=''){
            $sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,group_concat(atch.attachment) as attachment,group_concat(atch.attachment_type) as attachment_type,group_concat(atch.id) as attachid FROM project ast left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join project_attachment atch on ast.id=atch.project_id where ast.id='.$id.' AND ast.school_id='.$school_id.' group by ast.id';
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
		public function getSchoolClass($school_id=''){
			
            $sql='SELECT c.id,CONCAT(c.class," " ,c.section) as classname from class c inner join subjects s on c.id=s.class where c.schoolId="'.$school_id.'" group by c.id';
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
		public function getStudentSubmitedProjectList($schoolID='',$class_id='',$subject_id='',$category=''){
			$sql='SELECT ast.title,ast.category,ast.submission_date,asu.id as asid,asu.submission_date as datesubmited,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname from project ast inner join project_submission asu on ast.id =asu.project_id left join class c on ast.class_id =c.id left join subjects s on ast.subject_id =s.id left join child ch on asu.user_id =ch.id left join sessions si ON ast.session_id=si.id where ast.status=1 AND si.current_sesion=1';
				if($class_id!='') {
				$sql .= ' AND ast.class_id="'.$class_id.'"';
				}
				if($subject_id!='') {
					$sql .= ' AND ast.subject_id="'.$subject_id.'"';
					
				}else{
					$sql .= ' AND ast.school_id="'.$schoolID.'"';
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

		public function getSubmitedProjectDetails($id='',$school_id=''){
			$currdate=date('Y-m-d');
			$sql='SELECT asu.*,ast.school_id,ast.class_id,ast.subject_id,ast.category,ast.total_marks,ast.title,ast.created  as dateofissue ,ast.submission_date as sdate,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname,GROUP_CONCAT(sa.attachment) as saattachment,GROUP_CONCAT(sa.attachment_type) as saattachmenttype FROM project_submission asu left join project ast on asu.project_id=ast.id left join project_submission_attachment sa on asu.id=sa.project_id left join class c on ast.class_id=c.id left join subjects s on ast.subject_id=s.id left join child ch on ch.id=asu.user_id where asu.id='.$id.' AND ast.school_id='.$school_id.' group by asu.id';
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