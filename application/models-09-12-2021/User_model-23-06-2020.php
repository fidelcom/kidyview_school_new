<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class User_model extends CI_Model
	{
		public function schoolExist($email)
		{
			$this->db->select("id`");
			$this->db->where('email',$email);
			//$this->db->where('is_email_verified',1);
			//$this->db->where('status',1);
			
			$query = $this->db->get('school');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function parentExist($email,$phone)
		{
			$this->db->select("id`");
			$this->db->where('fatheremail',$email);
			$this->db->or_where('fatherphone',$phone);
			
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
		
		public function parentExistInEditCase($email,$phone,$parentID)
		{
			$query = $this->db->query("SELECT id FROM parent WHERE (fatheremail = '$email' OR fatherphone = '$phone') AND id NOT IN($parentID)");
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function teacherExist($email,$phone)
		{
			$this->db->select("id`");
			$this->db->where('teacheremail',$email);
			$this->db->or_where('teacherphone',$phone);
			
			$query = $this->db->get('teacher');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function teacherExistInEditCase($email,$phone,$teacherId)
		{
			$query = $this->db->query("SELECT id FROM teacher WHERE (teacheremail = '$email' OR teacherphone = '$phone') AND id NOT IN($teacherId)");
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function driverExist($email,$phone)
		{
			$this->db->select("id`");
			$this->db->where('driveremail',$email);
			$this->db->or_where('driverphone',$phone);
			
			$query = $this->db->get('driver');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function driverExistInEditCase($email,$phone,$driverId)
		{
			$query = $this->db->query("SELECT id FROM driver WHERE (driveremail = '$email' OR driverphone = '$phone') AND id NOT IN($driverId)");
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getSchool($queryParameters)
		{
			$this->db->where($queryParameters);
			$this->db->where('status',1);
			$this->db->where('is_email_verified',1);
			
			$query =  $this->db->get('school');
			//echo $this->db->last_query(); die;
			if($query->result_id->num_rows==1)
			{
				$data_user = $query->result_array();
				return $data_user[0];
			}
			else
			return false;
		}
		
		public function getAllSchoolsForDashboard()
		{
			//$this->db->where('is_email_verified',1);
			$this->db->order_by('id', 'DESC');
			$this->db->limit('10');
			$query =  $this->db->get('school');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllSchoolsForSchoolMngt()
		{
			//$this->db->where('is_email_verified',1);
			$this->db->order_by('id', 'ASC');
			$query =  $this->db->get('school');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllSchools()
		{
			$this->db->where('is_email_verified',1);
			$this->db->where('status',1);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('school');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllGoalsForSchool()
		{
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('goal_list');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllGiftsForSchool()
		{
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('gifts');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllEventsForSchool($id)
		{
			$this->db->where('school_id', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('events');
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllArticleForSchool($id)
		{
			/* $this->db->where('schoolId', $id);
				$this->db->order_by('id', 'DESC');
				$query =  $this->db->get('article');
				
				if($query->result_id->num_rows!=0)
				{
				$data_user = $query->result_array();
				return $data_user;
				}
				else
			return false; */
			$schoolId = $id;
			
			$this->db->select("t.*");
			$this->db->from("article t");
			$this->db->where("t.schoolId",$schoolId);
			//$this->db->where("t.status",1);
			$this->db->order_by("t.id","DESC");
			
			$row = $this->db->get();
			$data = $row->result();
			if (!empty($data)) {
				for ($i = 0; $i < count($data); $i++) {
					$this->load->helper('common');
					$data[$i]->comments 		= $this->countArticleComment($data[$i]->id);
					$data[$i]->like 			= $this->countArticleLike($data[$i]->id);
					$data[$i]->view 			= $this->countArticleView($data[$i]->id);
				}
				return $data;
				} else {
				return array();
			}
		}
		
		public function getAllTimelineForSchool($id)
		{
			$schoolId = $id;
			
			$this->db->select("t.*");
			$this->db->from("timeline t");
			$this->db->where("t.school_id",$schoolId);
			//$this->db->where("t.status",1);
			$this->db->order_by("t.id","DESC");
			
			$row = $this->db->get();
			$data = $row->result();
			if (!empty($data)) {
				for ($i = 0; $i < count($data); $i++) {
					$this->load->helper('common');
					$data[$i]->created 			= time_elapsed_string($data[$i]->created);
					$data[$i]->attachment 		= $this->getAttachment($data[$i]->id);
					$data[$i]->comment_detail 	= $this->getcommentsDetail($data[$i]->id);
					$data[$i]->comments 		= $this->countComment($data[$i]->id);
					$data[$i]->like 			= $this->countLike($data[$i]->id);
					$isUserLike 				= $this->userLike($data[$i]->id, '', 'teacher', $data[$i]->user_id);
					if ($isUserLike > 0) 
					{
						$data[$i]->is_like = 1;
					} 
					else 
					{
						$data[$i]->is_like = 0;
					}
					if($data[$i]->user_id != '')
					{
						$userDetail = $this->userDetail($data[$i]->user_id);
						if($userDetail != false)
						{
							$data[$i]->create_by = $userDetail->fname." ".$userDetail->lname;                    
							$data[$i]->create_by_photo = base_url()."img/".$data[$i]->user_type."/".$userDetail->photo;
						}
					}else
					{
						$this->db->where("id",$data[$i]->school_id);
						$query1 = $this->db->get("school");
						$schoolDetail = $query1->row();
						$data[$i]->create_by = $schoolDetail->school_name;                    
						$data[$i]->create_by_photo = base_url()."img/".$data[$i]->user_type."/".$schoolDetail->pic;
					}
				}
				return $data;
				} else {
				return array();
			}
		}
		
		public function userDetail($id)
		{
			$this->db->where("id",$id);
			$query = $this->db->get("alluser");
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAttachment($id) {
			$this->db->select('id,attachment as file');
			$this->db->from('timeline_attachment');
			$this->db->where('timeline_id', $id);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'ASC');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
				} else {
				return array();
			}
		}
		
		public function countComment($id) {
			$this->db->select('*');
			$this->db->from('timeline_comment');
			$this->db->where('timeline_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function countAlbumComment($id) {
			$this->db->select('*');
			$this->db->from('album_comment');
			$this->db->where('album_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function countArticleComment($id) {
			$this->db->select('*');
			$this->db->from('article_comment');
			$this->db->where('article_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function getcommentsDetail($id) {
			$data = array();
			$this->db->select('*');
			$this->db->from('timeline_comment');
			$this->db->where('timeline_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->result();
			//echo '<pre>'; print_r($result); die;
			
			for ($i = 0; $i < count($result); $i++) {
				//echo $result[$i]->school_id;
				$data[$i]['comment'] 	= $result[$i]->comment;
				$data[$i]['user_type'] 	= $result[$i]->user_type;
				if($result[$i]->user_id != '')
				{
					$userDetail = $this->userDetail($result[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]['create_by'] = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]['create_by_photo'] = base_url()."img/".$result[$i]->user_type."/".$userDetail->photo;
					}
				}
			}
			return $data;
		}
		
		public function getTimelineAttachmentcommentsDetail($id) {
			$data = array();
			$this->db->select('*');
			$this->db->from('timeline_comment');
			$this->db->where('attachment_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->result();
			//echo '<pre>'; print_r($result); die;
			
			for ($i = 0; $i < count($result); $i++) {
				//echo $result[$i]->school_id;
				$data[$i]['comment_id'] 	= $result[$i]->id;
				$data[$i]['comment'] 	= $result[$i]->comment;
				$data[$i]['user_type'] 	= $result[$i]->user_type;
				if($result[$i]->user_id != '')
				{
					$userDetail = $this->userDetail($result[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]['create_by'] = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]['create_by_photo'] = base_url()."img/".$result[$i]->user_type."/".$userDetail->photo;
					}
				}
			}
			return $data;
		}
		
		public function getAlbumAttachmentcommentsDetail($id) {
			$data = array();
			$this->db->select('*');
			$this->db->from('album_comment');
			$this->db->where('attachment_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->result();
			//echo '<pre>'; print_r($result); die;
			
			for ($i = 0; $i < count($result); $i++) {
				//echo $result[$i]->school_id;
				$data[$i]['comment_id'] 	= $result[$i]->id;
				$data[$i]['comment'] 	= $result[$i]->comment;
				$data[$i]['user_type'] 	= $result[$i]->user_type;
				if($result[$i]->user_id != '')
				{
					$userDetail = $this->userDetail($result[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]['create_by'] = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]['create_by_photo'] = base_url()."img/".$result[$i]->user_type."/".$userDetail->photo;
					}
				}
			}
			return $data;
		}
		
		public function getDiscussionAttachmentcommentsDetail($id) {
			$data = array();
			$this->db->select('*');
			$this->db->from('discussion_comment');
			$this->db->where('discussion_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->result();
			//echo '<pre>'; print_r($result); die;
			
			for ($i = 0; $i < count($result); $i++) {
				//echo $result[$i]->school_id;
				$data[$i]['comment_id'] 	= $result[$i]->id;
				$data[$i]['comment'] 	= $result[$i]->comment;
				$data[$i]['user_type'] 	= $result[$i]->user_type;
				if($result[$i]->user_id != '')
				{
					$userDetail = $this->userDetail($result[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]['create_by'] = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]['create_by_photo'] = base_url()."img/".$result[$i]->user_type."/".$userDetail->photo;
					}
				}
			}
			return $data;
		}
		
		public function getArticleAttachmentcommentsDetail($id) {
			$data = array();
			$this->db->select('*');
			$this->db->from('article_comment');
			$this->db->where('article_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			$result = $query->result();
			//echo '<pre>'; print_r($result); die;
			
			for ($i = 0; $i < count($result); $i++) {
				//echo $result[$i]->school_id;
				$data[$i]['comment_id'] 	= $result[$i]->id;
				$data[$i]['comment'] 	= $result[$i]->comment;
				$data[$i]['user_type'] 	= $result[$i]->user_type;
				if($result[$i]->user_id != '')
				{
					$userDetail = $this->userDetail($result[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]['create_by'] = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]['create_by_photo'] = base_url()."img/".$result[$i]->user_type."/".$userDetail->photo;
					}
				}
			}
			return $data;
		}
		
		public function countLike($id ) {
			$this->db->select('*');
			$this->db->from('timeline_like');
			$this->db->where('timeline_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function countAlbumLike($id ) {
			$this->db->select('*');
			$this->db->from('album_like');
			$this->db->where('album_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function countArticleLike($id ) {
			$this->db->select('*');
			$this->db->from('article_like');
			$this->db->where('article_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function countArticleView($id ) {
			$this->db->select('*');
			$this->db->from('article_view');
			$this->db->where('article_id', $id);
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function userLike($id , $attachId = '') {
			$userType = 'teacher';
			$userId = $this->token->user_id;
			if ($userType == 'parent') {
				$userId = "P-" . $userId;
				} elseif ($userType == 'teacher') {
				$userId = "T-" . $userId;
			}
			$this->db->select('*');
			$this->db->from('timeline_like');
			$this->db->where('timeline_id', $id);
			if($attachId != '')
			{
				$this->db->where('attachment_id', $attachId);
			}
			$this->db->where('user_id', $userId);
			$isLike = $this->db->get();
			
			return $isLike->num_rows();
		}
		
		public function getAllAlbumForSchool($id)
		{
			$schoolId = $id;
			
			$this->db->select("t.*");
			$this->db->from("album t");
			$this->db->where("t.schoolId",$schoolId);
			//$this->db->where("t.status",1);
			$this->db->order_by("t.id","DESC");
			
			$row = $this->db->get();
			$data = $row->result();
			if (!empty($data)) {
				for ($i = 0; $i < count($data); $i++) {
					$this->load->helper('common');
					$data[$i]->attachment_id = $this->getAllAttachmentForAlbum($data[$i]->id);
					$data[$i]->comments 		= $this->countAlbumComment($data[$i]->id);
					$data[$i]->like 			= $this->countAlbumLike($data[$i]->id);
				}
				return $data;
				} else {
				return array();
			}
		}
		
		public function getAllAttachmentForAlbum($id)
		{
			$this->db->select('attachment');
			$this->db->where('albumId', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('album_attachment');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user1 = $query->result_array();
				for($v=0; $v<count($data_user1); $v++)
				{
					$data_user[]= $data_user1[$v]['attachment'];
				}
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllDriverForSchool($id)
		{
			$this->db->where('schoolId', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('driver');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllSessionForSchool($id)
		{
			$this->db->where('schoolId', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('sessions');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllClassForSchool($id)
		{
			$this->db->select('c.*, COUNT(ch.id) as num_child');
			$this->db->from('class c');
			$this->db->join('child ch', 'ch.childclass = c.id', 'LEFT');
			$this->db->where('c.schoolId', $id);
			$this->db->group_by('c.id');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllDiscussionCatForSchool($id)
		{
			$this->db->select('*');
			$this->db->from('discussion_category');
			$this->db->where('school_id', $id);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get();
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		public function discussioncountLike($id ) {
			$this->db->select('*');
			$this->db->from('discussion_like');
			$this->db->where('discussion_id', $id);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		
		public function countDiscussionComment($id) {
			$this->db->select('*');
			$this->db->from('discussion_comment');
			$this->db->where('discussion_id', $id);
			$this->db->where('deleted', 0);
			$this->db->where('status', '1');
			$query = $this->db->get();
			return $query->num_rows();
		}
		public function getDiscussionAttachment($id) {
			$this->db->select('id,attachment as file');
			$this->db->from('discussion_attachment');
			$this->db->where('discussion_id', $id);
			$this->db->where('status', 1);
			$this->db->order_by('id', 'ASC');
			
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
				} else {
				return array();
			}
		}
		
		public function getAllDiscussionForSchool($id)
		{
			$this->db->select("d.*, dt.name as discussion_type_text,dl.total_like");
			$this->db->from("discussion d");
			$this->db->join("(SELECT discussion_id,count(discussion_id) as total_like FROM discussion_like GROUP BY discussion_id) dl","d.id = dl.discussion_id","LEFT");
			$this->db->join("discussion_category dt","d.discussion_type = dt.id","LEFT");
			$this->db->where("d.school_id",$id);
			$this->db->order_by('id','DESC');
			$row = $this->db->get();
			$data = $row->result();
			if (!empty($data)) {
				for ($i = 0; $i < count($data); $i++) {
					$this->load->helper('common');
					$data[$i]->created = time_elapsed_string($data[$i]->created);
					$data[$i]->attachment = $this->getDiscussionAttachment($data[$i]->id);
					$data[$i]->comments = $this->countDiscussionComment($data[$i]->id);
					$data[$i]->like = $this->discussioncountLike($data[$i]->id);
					$userDetail = $this->userDetail($data[$i]->user_id);
					if($userDetail != false)
					{
						$data[$i]->create_by = $userDetail->fname." ".$userDetail->lname;                    
						$data[$i]->create_by_photo = base_url()."img/".$data[$i]->user_type."/".$userDetail->photo;
					}
					
				}
				return $data;
				} else {
				return array();
			}
		}
		
		public function getAllSubjectForSchool($id)
		{
			$this->db->select('s.*,c.class as class_name,c.section,t.teacherfname,t.teachermname,t.teacherlname');
			$this->db->from('subjects s');
			$this->db->join('class c','s.class = c.id','LEFT');
			$this->db->join('teacher t','s.teacher = t.id','LEFT');
			$this->db->where('s.schoolId', $id);
			$this->db->order_by('s.id', 'DESC');
			$query =  $this->db->get();                    
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			{
				return false;
			}
		}
		
		public function getAllTeacherForSchool($id)
		{
			$this->db->where('schoolId', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('teacher');
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllStudentsForSchool($id)
		{
			$this->db->select('c.*, p.fatherfname, p.fatherlname, cc.class, cc.section');
			$this->db->from('child c');
			$this->db->where('c.schoolId', $id);
			$this->db->join('parent p', 'p.id = c.parent_id', 'RIGHT');
			$this->db->join('class cc', 'cc.id = c.childclass', 'RIGHT');
			$this->db->order_by('c.id', 'DESC');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllLearningDevelopmentReportForSchool($id)
		{
			$this->db->where('school_id', $id);
			$this->db->order_by('id', 'ASC');
			$query =  $this->db->get('learning_development_category');
			
			if($query->result_id->num_rows!=0)
			{
				$category = $query->result_array();
				for($v=0; $v<count($category); $v++)
				{
					$questionId[] = $this->getQuestion($category[$v]['id']);
				}
				//print_r($questionId);die;
				for($v=0; $v<count($questionId); $v++)
				{
					$reportsData[] = $this->getlndReportData($questionId[$v]);
				}
				//echo '<pre>'; print_r($reportsData);die;
				for($v=0; $v<count($reportsData); $v++)
				{
					if(count($reportsData[$v])!=0)
					{
						for($i=0; $i<count($reportsData[$v]); $i++)
						{
							$reportData[] = $reportsData[$v][$i];
						}
					}
				}
				//echo '<pre>'; print_r($reportData);die;
				return $reportData;
			}
			else
			return false;
		}
		
		public function getQuestion($categoryId)
		{
			$this->db->select('id');
			$this->db->where('category_id', $categoryId);
			$this->db->order_by('id', 'ASC');
			$query =  $this->db->get('learning_development_question');
			
			if($query->result_id->num_rows!=0)
			{
				$result = $query->row();
				return $result->id;
			}
			else
			return false;
		}
		
		public function getlndReportData($questionId)
		{
			$this->db->select('ldr.*, t.teacherfname, t.teacherlname, s.childfname, s.childmname, s.childlname');
			$this->db->from('learning_development_report ldr');
			$this->db->where('ldr.question_id', $questionId);
			$this->db->join('teacher t', 't.id = ldr.teacher_id', 'LEFT');
			$this->db->join('child s', 's.id = ldr.student_id', 'LEFT');
			$this->db->order_by('ldr.id', 'DESC');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['category_name'] = $this->getCategoryName($data_user[$i]['question_id']);
				}
				//echo '<pre>'; print_r($data_user); die;
				return $data_user;
			}
			else
			return array();
		}
		
		public function getCategoryName($questionId)
		{
			$this->db->select('ldq.*, ldc.name');
			$this->db->from('learning_development_question ldq');
			$this->db->where('ldq.id', $questionId);
			$this->db->join('learning_development_category ldc', 'ldc.id = ldq.category_id', 'LEFT');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user[0]['name'];
			}
			else
			return false;
		}
		
		public function getStudentClass($classId)
		{
			$this->db->select('class, section');
			$this->db->from('class');
			$this->db->where('id', $classId);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->row();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getStudentCategoryName($questionId)
		{
			$this->db->select('category_id');
			$this->db->from('learning_development_question');
			$this->db->where('id', $questionId);
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->row();
				$this->db->select('name');
				$this->db->from('learning_development_category');
				$this->db->where('id', $data_user->category_id);
				$query1 = $this->db->get();
				if($query1->result_id->num_rows!=0)
				{
					$data_user1 = $query1->row();
					return $data_user1->name;
				}
				else
				return false;
			}
			else
			return false;
		}
		
		public function verifySchoolSignup($data)
		{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("verification");
			//echo $this->db->last_query(); die;
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAdminDetails()
		{
			$this->db->select("*");
			$this->db->where('id',1);
			$this->db->where('active',1);
			
			$query = $this->db->get('ics_admin');
			if($query->num_rows() > 0)
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
			$this->db->where('id',$id);
			
			$query = $this->db->get('school');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAllParent($schoolId)
		{
			$this->db->select("*");
			$this->db->where('schoolId',$schoolId);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('parent');
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getAllTeacher($schoolId)
		{
			$this->db->select("*");
			$this->db->where('schoolId',$schoolId);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get('teacher');
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getEventDetails($id)
		{
			$this->db->select("*");
			$this->db->where('id',$id);
			
			$query = $this->db->get('events');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getDriverDetails($id)
		{
			$this->db->select('d.*, s.school_name');
			$this->db->from('driver d');
			$this->db->where('d.id', $id);
			$this->db->join('school s', 'd.schoolId = s.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getSessionDetails($id)
		{
			$this->db->select('s.*, ss.school_name');
			$this->db->from('sessions s');
			$this->db->where('s.id', $id);
			$this->db->join('school ss', 's.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getClassDetails($id)
		{
			$this->db->select('c.*, ss.school_name');
			$this->db->from('class c');
			$this->db->where('c.id', $id);
			$this->db->join('school ss', 'c.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getDiscussionCatDetails($id)
		{
			$this->db->select('*');
			$this->db->from('discussion_category');
			$this->db->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getSubjectDetails($id)
		{
			$this->db->select('s.*, ss.school_name');
			$this->db->from('subjects s');
			$this->db->where('s.id', $id);
			$this->db->join('school ss', 's.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getArticleDetails($id)
		{
			$this->db->select('a.*, ss.school_name');
			$this->db->from('article a');
			$this->db->where('a.id', $id);
			$this->db->join('school ss', 'a.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAlbumDetails($id)
		{
			$this->db->select('a.*, ss.school_name');
			$this->db->from('album a');
			$this->db->where('a.id', $id);
			$this->db->join('school ss', 'a.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getLearningDevelopmentReportDetails($id)
		{
			$this->db->select('ldr.*, t.teacherfname, t.teacherlname, t.teacheremail, s.childfname, s.childmname, s.childlname, s.childclass');
			$this->db->from('learning_development_report ldr');
			$this->db->where('ldr.id', $id);
			$this->db->join('teacher t', 't.id = ldr.teacher_id', 'LEFT');
			$this->db->join('child s', 's.id = ldr.student_id', 'LEFT');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->row();
				//print_r($data_user); die;
				$classsection = $this->getStudentClass($data_user->childclass);
				$data_user->student_class = $classsection->class;
				$data_user->student_section = $classsection->section;
				$data_user->category_Name = $this->getStudentCategoryName($data_user->question_id);
				//echo '<pre>'; print_r($data_user); die;
				return $data_user;
			}
			else
			return array();
		}
		
		public function getDiscussionDetails($id)
		{
			$this->db->select('d.*, ss.school_name, dc.name as category_name');
			$this->db->from('discussion d');
			$this->db->where('d.id', $id);
			$this->db->join('school ss', 'd.school_id = ss.id', 'LEFT');
			$this->db->join('discussion_category dc', 'd.discussion_type = dc.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				$data = $query->row();
				$user_id = $data->user_id;
				$userDetail = $this->userDetail($user_id);
				if($userDetail != false)
				{
					$data->create_by = $userDetail->fname." ".$userDetail->lname;                    
					$data->create_by_photo = base_url()."img/".$data->user_type."/".$userDetail->photo;
				}
				return $data;
			}
			else
			{
				return false;
			}
		}
		
		public function getTimelineDetails($id)
		{
			$this->db->select('*');
			$this->db->from('timeline');
			$this->db->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getGoalDetails($id)
		{
			$this->db->select('*');
			$this->db->from('goal_list');
			$this->db->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getGiftDetails($id)
		{
			$this->db->select('*');
			$this->db->from('gifts');
			$this->db->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAlbumAttachmentDetails($id)
		{
			/* $this->db->select('attachment');
				$this->db->where('albumId', $id);
				$this->db->order_by('id', 'DESC');
				$query =  $this->db->get('album_attachment');
				
				if($query->result_id->num_rows!=0)
				{
				$data_user = $query->result_array();
				return $data_user;
				}
				else
			return array(); */
			$this->db->select('id,attachment');
			$this->db->where('albumId', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('album_attachment');
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				if(! empty($data_user))
				{
					for ($i = 0; $i < count($data_user); $i++) {
						$this->load->helper('common');
						$data_user[$i]['comment_detail'] = $this->getAlbumAttachmentcommentsDetail($data_user[$i]['id']);
					}
				}
				return $data_user;
			}
			else
			return array();
		}
		
		public function getDiscussionAttachmentDetails($id)
		{
			$this->db->select('id,attachment');
			$this->db->where('discussion_id', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('discussion_attachment');
			$data_user = $query->result_array();
			if(! empty($data_user))
			{
				return $data_user;
			}
			else
			return array();
		}
		
		public function getTimelineAttachmentDetails($id)
		{
			$this->db->select('id,attachment');
			$this->db->where('timeline_id', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('timeline_attachment');
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				if(! empty($data_user))
				{
					for ($i = 0; $i < count($data_user); $i++) {
						$this->load->helper('common');
						$data_user[$i]['comment_detail'] = $this->getTimelineAttachmentcommentsDetail($data_user[$i]['id']);
					}
				}
				return $data_user;
			}
			else
			return array();
		}
		
		public function getGuardianDetails($id)
		{
			$this->db->select('*');
			$this->db->where('parent_id', $id);
			$this->db->order_by('id', 'DESC');
			$query =  $this->db->get('parent_guardian');
			
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return array();
		}
		
		public function getParentDetails($id)
		{
			$this->db->select("*");
			$this->db->where('id',$id);
			
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
		
		public function getTeacherDetails($id)
		{
			$this->db->select('t.*, tq.qualification');
			$this->db->from('teacher t');
			$this->db->where('t.id', $id);
			$this->db->join('teacher_qualification tq', 't.id = tq.teacher_id', 'LEFT');
			$query = $this->db->get();
			$teacherResult = $query->result_array();
			
			$teacherResult1 = $teacherResult[0];
			
			$assignclassteacher = $teacherResult1['assignclassteacher'];
			if(! empty($assignclassteacher))
			{
				$classes = explode(",",$assignclassteacher);
				
				for($i=0; $i<count($classes); $i++){
					$this->db->select("*");
					$this->db->where('id',$classes[$i]);
					
					$query = $this->db->get('class');
					$classesResult = $query->result_array();
					
					$classesResult = $classesResult[0];
					
					$class = $classesResult['class'].'-'.$classesResult['section'];
					$teacherResult1['class'][]	=	$class;
				}
			}
			
			for($v=0; $v<count($teacherResult); $v++){
				$qualification = $teacherResult[$v]['qualification'];
				$teacherResult1['qualifications'][]	=	$qualification;
			}
			
			if($query->num_rows() > 0)
			{
				return $teacherResult1;
			}
			else
			{
				return false;
			}
		}
		
		public function getStudentDetails($id)
		{
			/* $this->db->select('t.*, tq.qualification');
				$this->db->from('teacher t');
				$this->db->where('t.id', $id);
				$this->db->join('teacher_qualification tq', 't.id = tq.teacher_id', 'LEFT');
				$query = $this->db->get();
				$teacherResult = $query->result_array();
				
				$teacherResult1 = $teacherResult[0];
				
				$assignclassteacher = $teacherResult1['assignclassteacher'];
				if(! empty($assignclassteacher))
				{
				$classes = explode(",",$assignclassteacher);
				
				for($i=0; $i<count($classes); $i++){
				$this->db->select("*");
				$this->db->where('id',$classes[$i]);
				
				$query = $this->db->get('class');
				$classesResult = $query->result_array();
				
				$classesResult = $classesResult[0];
				
				$class = $classesResult['class'].'-'.$classesResult['section'];
				$teacherResult1['class'][]	=	$class;
				}
				}
				
				for($v=0; $v<count($teacherResult); $v++){
				$qualification = $teacherResult[$v]['qualification'];
				$teacherResult1['qualifications'][]	=	$qualification;
				}
				
				if($query->num_rows() > 0)
				{
				return $teacherResult1;
				}
				else
				{
				return false;
			} */
		}
		
		public function getTeacherQualificationDetails($id)
		{
			$this->db->select("`qualification`, `yearofpassing`, `percentage`, `board`, `certificate`, `teacher_id`, `schoolId`");
			$this->db->where('teacher_id',$id);
			
			$query = $this->db->get('teacher_qualification');
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getTeacherExperienceDetails($id)
		{
			$this->db->select("`schoolname`, `numberofyears`, `designation`, `datefrom`, `dateto`, `employercertificate`, `teacher_id`");
			$this->db->where('teacher_id',$id);
			
			$query = $this->db->get('teacher_workexperiance');
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getSingleChildDetails($id)
		{
			$this->db->select('c.*, cc.class, cc.section');
			$this->db->from('child c');
			$this->db->where('c.id', $id);
			$this->db->join('class cc', 'cc.id = c.childclass', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
			
		}
		
		public function getChildDetails($id)
		{
			$this->db->select('c.*, cc.class, cc.section');
			$this->db->from('child c');
			$this->db->where('c.parent_id', $id);
			$this->db->join('class cc', 'cc.id = c.childclass', 'LEFT');
			$query = $this->db->get();
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function deleteEvent($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('events');
			return $query;
		}
		
		public function deleteGoal($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('goal_list');
			return $query;
		}
		
		public function deleteArticle($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('article');
			return $query;
		}
		
		public function deleteAttachment($name)
		{
			/* $this->db->where('attachment', $name);
				$query = $this->db->delete('album_attachment');
				if (file_exists(base_url().'img/album/'.$name))
				{
				unlink(base_url().'img/album/'.$name);
				}
			return $query; */
			$this->db->select("id");
			$this->db->where('attachment',$name);
			
			$query = $this->db->get('album_attachment');
			$result = $query->row();
			$resultid = $result->id;
			
			
			$this->db->where('attachment', $name);
			$query1 = $this->db->delete('album_attachment');
			
			if($query->row() !=0)
			{
				$this->db->where('attachment_id', $resultid);
				$this->db->delete('album_comment');
			}
			if($query->row() !=0)
			{
				$this->db->where('attachment_id', $resultid);
				$this->db->delete('album_like');
			}
			if (file_exists(base_url().'img/album/'.$name))
			{
				unlink(base_url().'img/album/'.$name);
			}
			return $query1;
		}
		
		public function deleteTimelineComment($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('timeline_comment');
			return $query;
		}
		
		public function deleteAlbumComment($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('album_comment');
			return $query;
		}
		
		public function deleteDiscussionComment($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('discussion_comment');
			return $query;
		}
		
		public function deleteArticleComment($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('article_comment');
			return $query;
		}
		
		public function deleteTimelineAttachment($name)
		{
			$this->db->select("id");
			$this->db->where('attachment',$name);
			
			$query = $this->db->get('timeline_attachment');
			$result = $query->row();
			$resultid = $result->id;
			
			
			$this->db->where('attachment', $name);
			$query1 = $this->db->delete('timeline_attachment');
			
			if($query->row() !=0)
			{
				$this->db->where('attachment_id', $resultid);
				$this->db->delete('timeline_comment');
			}
			if($query->row() !=0)
			{
				$this->db->where('attachment_id', $resultid);
				$this->db->delete('timeline_like');
			}
			if (file_exists(base_url().'img/timeline/'.$name))
			{
				unlink(base_url().'img/timeline/'.$name);
			}
			return $query1;
		}
		
		public function addSchool($data)
		{
			$this->db->insert('school',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function removeProfilePicAdmin($defaultProfilePic)
		{  
			$defaultPic = array('photo'=> $defaultProfilePic);
			$this->db->where('id',1);
			$this->db->update('ics_admin',$defaultPic);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function removeProfilePicSchool($defaultProfilePic, $id)
		{  
			$defaultPic = array('pic'=> $defaultProfilePic);
			$this->db->where('id',$id);
			$this->db->update('school',$defaultPic);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editEvent($data, $schoolId, $eventId)
		{  
			$this->db->where('id',$eventId);
			$this->db->where('school_id',$schoolId);
			$this->db->update('events',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function changePasswordAdmin($oldPassword,$newPassword)
		{  
			$newPassword = array('password'=> $newPassword);
			$this->db->where('password',$oldPassword);
			$this->db->update('ics_admin',$newPassword);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function changePasswordSchool($oldPassword,$newPassword, $id)
		{  
			$newPassword = array('password'=> $newPassword);
			$this->db->where('password',$oldPassword);
			$this->db->where('id',$id);
			$this->db->update('school',$newPassword);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function updateAdminProfile($data)
		{
			$this->db->where('id',1);
			$this->db->update('ics_admin',$data);
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
		
		public function schoolDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('school',$data);
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
		
		public function parentDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('parent',$data);
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
		
		public function driverDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('driver',$data);
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
		
		public function sessionDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('sessions',$data);
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
		
		public function sectionDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('class',$data);
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
		
		public function discussionCatDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('discussion_category',$data);
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
		
		public function discussionAccept($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('discussion',$data);
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
		
		public function discussionDecline($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('discussion',$data);
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
		
		public function giftDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('gifts',$data);
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
		
		public function subjectsDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('subjects',$data);
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
		
		public function timelineDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('timeline',$data);
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
		
		public function teacherDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('teacher',$data);
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
		
		public function albumDisabled($data,$id)
		{
			$this->db->where('id',$id);
			$this->db->update('album',$data);
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
		
		public function updateSchoolProfile($data, $id)
		{
			$this->db->where('id',$id);
			$this->db->update('school',$data);
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
		
		public function addSchoolByAdmin($data)
		{
			$this->db->insert('school',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addParent($data)
		{
			$this->db->insert('parent',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addParentGuardian($data)
		{
			$this->db->insert('parent_guardian',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addTeacher($data)
		{
			$this->db->insert('teacher',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addTeacherEducationalFields($data)
		{
			$this->db->insert('teacher_qualification',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function updateTeacherEducationalFields($data, $teacherId)
		{
			$this->db->insert('teacher_qualification',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function deleteTeacherEducationalFields($teacherId)
		{
			$this->db->select("*");
			$this->db->where('teacher_id',$teacherId);
			
			$query = $this->db->get('teacher_qualification');
			if($query->result_id->num_rows!=0)
			{
				$this->db->where('teacher_id', $teacherId);
				$this->db->delete('teacher_qualification');
			}
			return true;
		}
		
		public function deleteTeacherExperianceFields($teacherId)
		{
			$this->db->select("*");
			$this->db->where('teacher_id',$teacherId);
			
			$query = $this->db->get('teacher_workexperiance');
			if($query->result_id->num_rows!=0)
			{
				$this->db->where('teacher_id', $teacherId);
				$this->db->delete('teacher_workexperiance');
			}
			return true;
		}
		
		public function addTeacherExperianceFields($data)
		{
			$this->db->insert('teacher_workexperiance',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function updateTeacherExperianceFields($data, $teacherId)
		{
			$this->db->insert('teacher_workexperiance',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function editParent($data, $parentID, $schoolId)
		{
			$this->db->where('id',$parentID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('parent',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editTeacher($data, $teacherId, $schoolId)
		{
			$this->db->where('id',$teacherId);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('teacher',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editDriver($data, $driverID, $schoolId)
		{
			$this->db->where('id',$driverID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('driver',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editSession($data, $sessionID, $schoolId)
		{
			$this->db->where('id',$sessionID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('sessions',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editDiscussionCat($data, $discussionCatID, $schoolId)
		{
			$this->db->where('id',$discussionCatID);
			$this->db->where('school_id',$schoolId);
			$this->db->update('discussion_category',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function editClass($data, $classID, $schoolId)
		{
			$classtitle = $data['class'];
			$classsection = $data['section'];
			$this->db->select("*");
			$this->db->where('class',$classtitle);
			$this->db->where('section',$classsection);
			
			$query = $this->db->get('class');
			if($query->num_rows() > 0)
			{
				return 'Already Exists.';
			}
			else
			{
				$this->db->where('id',$classID);
				$this->db->where('schoolId',$schoolId);
				$this->db->update('class',$data);
				//echo $this->db->last_query(); die;
				return ($this->db->affected_rows()) ? 1: 0;
			}
			
		}
		
		public function editSubject($data, $subjectID, $schoolId)
		{
			$this->db->where('id',$subjectID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('subjects',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editArticle($data, $articleID, $schoolId)
		{
			$this->db->where('id',$articleID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('article',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editAlbum($data, $albumID, $schoolId)
		{
			$this->db->where('id',$albumID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('album',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editTimeline($data, $timelineID, $schoolId)
		{
			$this->db->where('id',$timelineID);
			$this->db->where('school_id',$schoolId);
			$this->db->update('timeline',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editGoal($data, $goalID)
		{
			$this->db->where('id',$goalID);
			$this->db->update('goal_list',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editGift($data, $giftID)
		{
			$this->db->where('id',$giftID);
			$this->db->update('gifts',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
			
		}
		
		public function editChild($data, $schoolId, $childID)
		{
			$this->db->where('id',$childID);
			$this->db->where('schoolId',$schoolId);
			$this->db->update('child',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? 1: 0;
		}
		
		public function addChild($data,$child_id)
		{
			$parentID = $data['parent_id'];
			$this->db->insert('child',$data);
			$id = $this->db->insert_id();
			$newid = $child_id . "," . $id;
			$updateArray = array('child_id'=>$newid);
			$this->db->where('id',$parentID);
			$this->db->update('parent',$updateArray);
			return $id;
		}
		
		public function addDriver($data)
		{
			$this->db->insert('driver',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addSession($data)
		{
			$this->db->insert('sessions',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addDiscussionCat($data)
		{
			$this->db->insert('discussion_category',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addClass($data)
		{
			$sections = explode(",",$data['section']);
			foreach($sections as $section){
				$addArr = array(
				
				'schoolId' 			=> $data['schoolId'],
				'academicsession'	=> $data['academicsession'],
				'class'				=> $data['class'],
				'section'			=> $section,
				'status'			=> '1',
				);	
				$this->db->insert('class',$addArr);
				
			}
			$id = $this->db->insert_id();
			return $id;	
		}
		
		public function addSubject($data)
		{
			$this->db->insert('subjects',$data);
			$id = $this->db->insert_id();
			return $id;	
		}
		
		public function addGoal($data)
		{
			$this->db->insert('goal_list',$data);
			$id = $this->db->insert_id();
			return $id;	
		}
		
		public function addEvent($data)
		{
			$this->db->insert('events',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addArticle($data)
		{
			$this->db->insert('article',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addGift($data)
		{
			$this->db->insert('gifts',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addAlbum($data)
		{
			$this->db->insert('album',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addAlbumAttachment($data)
		{
			$this->db->insert('album_attachment',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addTimeline($data)
		{
			$this->db->insert('timeline',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function addTimelineAttachment($data)
		{
			$this->db->insert('timeline_attachment',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function verifyForgetPassword($data)
		{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("verification");
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		public function verifyAdminForgetPassword($data)
		{
			$this->db->where('user_id',1);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("verification");
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function verifySchoolForgetPassword($data)
		{
			$this->db->where('user_id',$data['user_id']);
			$this->db->where('verification_type',$data['verification_type']);
			$this->db->where('verfication_code',$data['verfication_code']);
			$query = $this->db->get("verification");
			if($query->num_rows() == 1)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function getAdminUser($queryParameters)
		{
			$this->db->where('id',1);
			$this->db->where('active',1);
			
			$query =  $this->db->get('ics_admin');
			if($query->result_id->num_rows==1)
			{
				$data_user = $query->result_array();
				return $data_user[0];
			}
			else
			return false;
		}
		
		public function resetPassword($userID,$password)
		{
			$this->db->where('id',$userID);
			return $this->db->update('ics_admin',array('password'=> $password));
		}
		
		public function resetPasswordSchool($userID,$password)
		{
			$this->db->where('id',$userID);
			return $this->db->update('school',array('password'=> $password));
		}
		
		public function updateVerificationStatus($id,$data)
		{
			$this->db->where('id',$id);
			$this->db->update("verification",$data);
			$this->db->query("UPDATE `verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
		}
		
		public function updateUserStatus($userID,$data)
		{
			$this->db->where('id',$userID);
			$this->db->update("user",$data);
		}
		public function updateSchoolStatus($userID,$data)
		{
			$this->db->where('id',$userID);
			$this->db->update("school",$data);
			//echo $this->db->last_query(); die;
		}
        
		public function validate($email,$password)
		{
			$this->db->select("`id`,`user_id` , `email`, phone, `first_name`, `last_name`");
			$this->db->from('user u');
			
			$this->db->where('u.is_email_verified',1);
			$this->db->where('u.status',1);
			$this->db->where('u.email',$email);
			$this->db->where('u.password', $password);
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
		
		public function addToken($data)
		{
			$this->db->insert('user_token',$data);
		}
		
		public function addHoliday($data)
		{
			$this->db->insert('holiday',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function getAllHolidayForSchool($id,$holidaydate='')
		{
			if($holidaydate!=''){
				$holidaydate=$holidaydate;
				}else{
				$holidaydate=date('Y-m-d');
			}
			$this->db->select('h.*,s.academicsession');
			$this->db->from('holiday h');
			$this->db->join('sessions s', 's.id = h.session', 'LEFT');
			$this->db->where('h.school_id', $id);
			$this->db->where('h.for_date', $holidaydate);
			$this->db->group_by('h.id');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['for_date'] = date('d M',strtotime($data_user[$i]['for_date']));
				}
				return $data_user;
			}
			else
			return false;
		}
		
		public function getHolidayDetails($id)
		{
			$this->db->select('h.*');
			$this->db->from('holiday h');
			$this->db->where('h.id', $id);
			//$this->db->join('school ss', 'c.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function editHoliday($data, $holidayID, $schoolId)
		{
			$title = $data['title'];
			$date = $data['for_date'];
			$this->db->select("*");
			$this->db->where('title',$title);
			$this->db->where('for_date',$date);
			
			$query = $this->db->get('holiday');
			//echo $this->db->last_query();die;
			if($query->num_rows() > 0)
			{
				return 'Already Exists.';
			}
			else
			{
				$this->db->where('id',$holidayID);
				$this->db->where('school_id',$schoolId);
				$this->db->update('holiday',$data);
				//echo $this->db->last_query(); die;
				return ($this->db->affected_rows()) ? 1: 0;
			}
			
		}
		
		public function deleteHoliday($id)
		{
			$this->db->where('id', $id);
			$query = $this->db->delete('holiday');
			return $query;
		}
		
		public function getAllHolidayCalendarData($id)
		{
			$this->db->select('h.title,h.for_date as start');
			$this->db->from('holiday h');
			$this->db->where('h.school_id', $id);
			//$this->db->join('school ss', 'c.schoolId = ss.id', 'LEFT');
			$query = $this->db->get();
			//echo $this->db->last_query();
			if($query->num_rows() > 0)
			{
				$data_user =$query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
				}
				return $data_user;
			}
			else
			{
				return false;
			}
		}
		public function getAllCalendarData($id,$calendardate='',$iscalendardata='')
		{
			$data = array();        
			$dataHoliday = $this->holiday_calendar_data($id,$calendardate,$iscalendardata);
			if(!empty($dataHoliday))
			{
				foreach ($dataHoliday as $tmp)
				{
					array_push($data,$tmp);
				}
			}      
			$dataEvent = $this->event_calendar_data($id,$calendardate,$iscalendardata);
			if(!empty($dataEvent))
			{
				foreach ($dataEvent as $tmp)
				{
					array_push($data,$tmp);
				}
				
			}  
			$dataBirthday = $this->studentBirthday_calendar_data($id,$calendardate,$iscalendardata);
			if(!empty($dataBirthday))
			{
				foreach ($dataBirthday as $tmp)
				{
					array_push($data,$tmp);
				}
				
			}     
			return $data;
		}
		public function holiday_calendar_data($school_id='',$calendardate='',$iscalendardata=''){
			if($calendardate!=''){
				$calendardate=$calendardate;
				}else{
				$calendardate=date('Y-m-d');
			}
			$this->db->select("title,for_date as start");
			$this->db->where('school_id',$school_id);
			if($iscalendardata==0){
				$this->db->where('for_date',$calendardate);
			}
			$query = $this->db->get('holiday');
			//echo $this->db->last_query();die;
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Holiday";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
		}
		
		public function event_calendar_data($school_id='',$calendardate='',$iscalendardata=''){
			if($calendardate!=''){
				$calendardate=$calendardate;
				}else{
				$calendardate=date('Y-m-d');
			}
			$this->db->select("title,date as start");
			//$this->db->where('school_id',$this->token->school_id);
			$this->db->where("(FIND_IN_SET(0,visibility)IS TRUE OR visibility = '')"); 
			if($iscalendardata==0){
				$this->db->where('date',$calendardate);
			}
			$query = $this->db->get('events');
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Event";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
		}
		
		
		public function studentBirthday_calendar_data($school_id='',$calendardate,$iscalendardata){  
			if($calendardate!=''){
				//$calendardate= $str1 = substr($calendardate, 4);
				$calendardate = explode('-',$calendardate);
                $calendardate = '-'.$calendardate[1].'-'.$calendardate[2];
				}else{
				$calendardate=date('-m-d');
			}      
			$this->db->select("concat(childfname,childmname,childlname) as title,childdob as start");
			$this->db->where('schoolId',$school_id);
			if($iscalendardata==0){
				
				$this->db->where("childdob like '%$calendardate'");
				
			}
			//$this->db->where('id',28);
			$query = $this->db->get('child');
			//echo $this->db->last_query();  die;          
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0; $i<count($data_user); $i++)
				{
					$data_user[$i]['allday'] = true;
					$data_user[$i]['type'] = "Birthday";
				}
				return $data_user;
			}
			else
			{
				return array();
			}
			
		}
		
		public function addRole($data)
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_role';
            }else{
                $tbl_name='school_role';
            }
			$this->db->insert($tbl_name,$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function getAllRoleForSchool($status='',$isEdit='')
		{

			if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_role';
                $join_tbl_name='admin_privilege';
            }else{
                $tbl_name='school_role';
                $join_tbl_name='school_privilege';
            }
			$this->db->select('*');
			$this->db->from($tbl_name);
			if($status!=''){
				$this->db->where('status',$status);
				if($isEdit!=1){
					$this->db->where('`id` NOT IN (SELECT `role_id` FROM '.$join_tbl_name.' group by role_id)', NULL, FALSE);
				}
				$this->db->order_by('name','DESC');
				}else{
				$this->db->order_by('id','DESC');
			}
			
			$query = $this->db->get();
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function getRoleDetails($id)
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_role';
            }else{
                $tbl_name='school_role';
            }
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->where('id', $id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function editRole($data, $roleID)
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_role';
            }else{
                $tbl_name='school_role';
            }
			$name = $data['name'];
			$this->db->select("*");
			$this->db->where('name',$name);
			$query = $this->db->get($tbl_name);
			//echo $query->num_rows();die;
			if($query->num_rows() > 0)
			{
				return 'Already Exists.';
			}
			else
			{
				$this->db->where('id',$roleID);
				$this->db->update($tbl_name,$data);
				return ($this->db->affected_rows()) ? 1: 0;
			}
			
		}
		
		public function roleDisabled($data,$id)
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_role';
            }else{
                $tbl_name='school_role';
            }
			$this->db->where('id',$id);
			$this->db->update($tbl_name,$data);
			if($this->db->affected_rows())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		public function getAllPermissionModuleForSchool(){
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_permission_module';
            }else{
                $tbl_name='school_permission_module';
            }
			$this->db->select('*');
			$this->db->from($tbl_name);
			$this->db->order_by('order');
			$query = $this->db->get();
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		
		public function addPrivilege($permissionData,$role_id='')
		{
			if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_privilege';
            }else{
                $tbl_name='school_privilege';
            }
			foreach($permissionData as $modulePrivilege){
				$data['module']=$modulePrivilege->module_name;				
				$data['view']=$modulePrivilege->view;
				$data['add']=$modulePrivilege->add;
				$data['edit']=$modulePrivilege->edit;
				$data['delete']=$modulePrivilege->delete;
				$data['role_id']=$role_id;
				$this->db->insert($tbl_name,$data);
				$id = $this->db->insert_id();
			}
			return $id;
		}
		public function getAllPrivilegeForSchool(){
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_privilege';
                $join_tbl_name='admin_role';
            }else{
                $tbl_name='school_privilege';
                $join_tbl_name='school_role';
            }
            
			$query=$this->db->query("SELECT GROUP_CONCAT(DISTINCT sp.module ORDER BY sp.id SEPARATOR'____') as module,GROUP_CONCAT(sp.view ORDER BY sp.id SEPARATOR'____') as view,GROUP_CONCAT(sp.add ORDER BY sp.id SEPARATOR'____') as ad,GROUP_CONCAT(sp.edit ORDER BY sp.id SEPARATOR'____') as edt ,GROUP_CONCAT(sp.delete ORDER BY sp.id SEPARATOR'____') as dlt,sr.id as role_id,sp.id ,sr.name FROM $tbl_name sp inner join $join_tbl_name sr on sp.role_id=sr.id GROUP BY sp.role_id");
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				$privilegeAllData=array();
				$i=0;
				foreach($data_user as $privilegeData){
					$privilegeAllData[$i]['id']=$privilegeData['id'];
					$privilegeAllData[$i]['role_id']=$privilegeData['role_id'];
					$privilegeAllData[$i]['role']=$privilegeData['name'];
					$moduleExp=explode('____',$privilegeData['module']);
					$viewExp=explode('____',$privilegeData['view']);
					$addExp=explode('____',$privilegeData['ad']);
					$editExp=explode('____',$privilegeData['edt']);
					$deleteExp=explode('____',$privilegeData['dlt']);
					for($m=0;$m<count($moduleExp);$m++){
						$privilegeAllData[$i]['moduleData'][$m]=$moduleExp[$m];
						$privilegeAllData[$i]['viewData'][$m]=$viewExp[$m];
						$privilegeAllData[$i]['addData'][$m]=$addExp[$m];
						$privilegeAllData[$i]['editData'][$m]=$editExp[$m];
						$privilegeAllData[$i]['deleteData'][$m]=$deleteExp[$m];
					}
					
					
				$i++;}
				//print_r($privilegeAllData);
				return $privilegeAllData;
			}
			else
			{
				return false;
			}
		}
		
		
		public function getPrivilegeDetails($role_id='')
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_privilege';
            }else{
                $tbl_name='school_privilege';
            }
			$this->db->select('id,module as module_name,view,add,edit,delete,role_id');
			$this->db->from($tbl_name);
			$this->db->where('role_id', $role_id);
			$query = $this->db->get();
			if($query->num_rows() > 0)
			{
				return $query->result_array();
			}
			else
			{
				return false;
			}
		}
		public function editPrivilege($permissionData,$role_id='')
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_privilege';
            }else{
                $tbl_name='school_privilege';
            }
			foreach($permissionData as $modulePrivilege){
				$id=$modulePrivilege->id;
				$data['module']=$modulePrivilege->module_name;				
				$data['view']=$modulePrivilege->view;
				$data['add']=$modulePrivilege->add;
				$data['edit']=$modulePrivilege->edit;
				$data['delete']=$modulePrivilege->delete;
				$this->db->where('id',$id);
				$this->db->update($tbl_name,$data);
			}
			return true;
		}
		
		public function deletePrivilege($id)
		{
            if($this->session->userdata('user_role')=='admin'){
                $tbl_name='admin_privilege';
            }else{
                $tbl_name='school_privilege';
            }
			$this->db->where('role_id', $id);
			$query = $this->db->delete($tbl_name);
			return $query;
		}
		public function subadminExist($email,$phone)
		{
			$this->db->select("id`");
			$this->db->where('name',$email);
			$this->db->or_where('phone',$phone);
			
			$query = $this->db->get('school_subadmin');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function addSubadmin($data)
		{
			$this->db->insert('school_subadmin',$data);
			$id = $this->db->insert_id();
			return $id;
		}
		
		public function getAllSubadminForSchool($schoolId)
		{
			$this->db->select("sa.*,r.name as role");
			$this->db->from('school_subadmin sa');
			$this->db->join('school_role r', 'sa.role_id = r.id', 'LEFT');
			$this->db->where('sa.school_id',$schoolId);
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get();
			if($query->result_id->num_rows!=0)
			{
				$data_user = $query->result_array();
				return $data_user;
			}
			else
			return false;
		}
		public function getSubadminDetails($id=''){
			$this->db->select("*");
			$this->db->where('id',$id);
			$query = $this->db->get('school_subadmin');
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
			
		}
		
		public function subadminExistInEditCase($email,$phone,$subadminID)
		{
			$query = $this->db->query("SELECT id FROM school_subadmin WHERE (email = '$email' OR phone = '$phone') AND id NOT IN($subadminID)");
			if($query->num_rows() > 0)
			{
				return $query->row();
			}
			else
			{
				return false;
			}
		}
		
		public function editSubadmin($data, $subadminID, $schoolId)
		{
			$this->db->where('id',$subadminID);
			$this->db->where('school_id',$schoolId);
			$this->db->update('school_subadmin',$data);
			return true;
			//return ($this->db->affected_rows()) ? 1: 0;
		}
		
		
		public function commonDisabled($data,$id,$tbl_name='')
		{
			$this->db->where('id',$id);
			$this->db->update($tbl_name,$data);
			if($this->db->affected_rows())
			{
				return true;
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
			//echo $this->db->last_query();die;
			return $query;
		}
		public function getSubAdmin($queryParameters)
		{
			$this->db->where($queryParameters);
			$this->db->where('status',1);
			$query =  $this->db->get('school_subadmin');
			if($query->result_id->num_rows==1)
			{
				$data_user = $query->result_array();
				return $data_user[0];
			}
			else
			return false;
		}
	}																																						