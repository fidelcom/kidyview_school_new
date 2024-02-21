<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Team_model extends CI_Model 
	{
		public function __construct()
		{
			parent::__construct();
		}
		
		public function insertTeam($data)
		{
			$this->db->insert('team', $data);
			$id = $this->db->insert_id();
			return (isset($id)) ? $id : FALSE;
		}
		
		public function checkTeamName($teamName, $user_id)
		{
			$this->db->where('team_name', $teamName);
			$this->db->where('user_id', $user_id);
			$query = $this->db->get('team');
			if( $query->num_rows() > 0 )
			{
				return $query->row(); 
			}
			else
			{
				return '';
			}
		}
		
		public function insertInvitation($data)
		{
			$this->db->insert('team_invitation', $data);
			$id = $this->db->insert_id();
			return (isset($id)) ? $id : FALSE;
		}
		
		public function insertTeamRole($data)
		{
			$this->db->insert('team_member', $data);
			$id = $this->db->insert_id();
			return (isset($id)) ? $id : FALSE;
		}
		
		public function getTeam($teamId, $user_id)
		{
		    $this->db->select('role as user_role');
			$this->db->where( array('member_id' => $user_id) );
			$query = $this->db->get('team_member');
			$role = $query->row();
		    $userRole = $role->user_role;
		
			$this->db->select('t.team_name, t.sports, t.is_age_group, t.age_group, t.gender, t.level, t.home, t.min_age, t.max_age, t.team_logo, t.time_zone, c.points as avg_rating' );
			$this->db->from('team t');
			$this->db->where( array('t.id' => $teamId, 't.is_active' => 1) );
			$this->db->Join('comments c', 'c.team_id = t.id', 'LEFT');
			$query = $this->db->get();
			
			if( $query->num_rows() > 0 )
			{
				//return $query->row();
				$listrole = array();
			$result = $query->row();
					$listrole['team_name'] = $result->team_name;
					$listrole['sports'] = $result->sports;
					$listrole['is_age_group'] = $result->is_age_group;
					$listrole['age_group'] = $result->age_group;
					$listrole['gender'] = $result->gender;
					$listrole['level'] = $result->level;
					$listrole['home'] = $result->home;
					$listrole['min_age'] = $result->min_age;
					$listrole['mx_age'] = $result->max_age;
					$listrole['team_logo'] = $result->team_logo;
					$listrole['time_zone'] = $result->time_zone;
					$listrole['avg_rating'] = $result->avg_rating;
					$listrole['user_role'] = $userRole;
				
				return $listrole;
				
			}
			return false;
		}
		
		public function getteamDetail($team_id)
		{
			$this->db->select('`t.id`, `t.user_id`, `t.team_name`, `t.sports`, `t.is_age_group`, `t.age_group`, `t.gender`, `t.level`, `t.home`, `t.min_age`, `t.max_age`, `t.team_logo`, `t.time_zone`, `t.is_active`, `t.created_at`, u.email as createdUserEmail');
			$this->db->from('team t');
			$this->db->where('t.id',$team_id);
			$this->db->Join('user u', 'u.id = t.user_id', 'LEFT');
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
	   	
		public function updateTeam($data, $team_id, $user_id)
		{
			$this->db->where('id', $team_id);
			$this->db->where('user_id', $user_id);
			$this->db->update('team', $data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? true: false;
		}
		
		public function updateTeamByAdmin($is_active, $team_id)
		{
			$data = array('is_active' => $is_active);
			$this->db->where('id',$team_id);
			$this->db->update('team',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? true: false;
		}
		
		public function updateMatchByAdmin($is_enabled, $matchID)
		{
			$data = array('is_enabled' => $is_enabled);
			$this->db->where('id',$matchID);
			$this->db->update('event',$data);
			//echo $this->db->last_query(); die;
			return ($this->db->affected_rows()) ? true: false;
		}
		
		public function getTeamLists($user_id)
		{
			$page 	= $_GET['page'];
			$limit 	= $_GET['limit'];
			$offset  = ($page - 1) * $limit;
			
			if($limit!='' && $page!='')
			{
				$this->db->limit($limit, $offset);
			}
			
			$this->db->select('tm.role as user_role, tm.member_id,tm.team_id');
			$this->db->from('team_member tm');
			$this->db->where( array('member_id' => $user_id) );
			$this->db->join('team t', 't.id = tm.team_id', 'LEFT');
			$this->db->where('t.is_active', 1);
			$query = $this->db->get('');
			$role = $query->row();
			
			//echo '<pre>'; echo $this->db->last_query(); die;
			
		    $listrole = $query->result();
			//print_r($listrole); die;
			
			for($i=0; isset($listrole[$i]);$i++)
			{
				$this->db->select('a.id as team_id,a.team_name, a.sports, a.is_age_group, a.age_group, a.gender, a.level, a.home, a.min_age, a.max_age, a.team_logo, a.time_zone, a.user_id as created_user,u.email as created_user_email');
				$this->db->from('team a');
				$this->db->join('user u', 'u.id = a.user_id', 'LEFT');
				$this->db->where( array('a.is_active' => 1,'a.id' => $listrole[$i]->team_id) );
				
				$query1 = $this->db->get();
				//echo $this->db->last_query(); die;
				$result = $query1->row();
				//print_r($result); //die;
				if($result != null)
				{
					$listrole[$i]->team_name = $result->team_name;
					$listrole[$i]->sports = $result->sports;
					$listrole[$i]->is_age_group = $result->is_age_group;
					$listrole[$i]->age_group = $result->age_group;
					$listrole[$i]->gender = $result->gender;
					$listrole[$i]->level = $result->level;
					$listrole[$i]->home = $result->home;
					$listrole[$i]->min_age = $result->min_age;
					$listrole[$i]->mx_age = $result->max_age;
					$listrole[$i]->team_logo = $result->team_logo;
					$listrole[$i]->time_zone = $result->time_zone;
					$listrole[$i]->created_user = $result->created_user;
					$listrole[$i]->created_user_email = $result->created_user_email;
				}
				
			}
			
			//count($listrole); die;
			
			if($listrole)
			{
				return $listrole; 
			}
			else
			{
     			return array();
			}
		}
		
		public function resultcount($user_id)
		{
		    $this->db->select('role as user_role, member_id,team_id');
			$this->db->where( array('member_id' => $user_id) );
			$query = $this->db->get('team_member');
			$role = $query->row(); 
			return $query->num_rows(); 
		}
		
		public function search()
		{
			if(isset($_GET['email']))
			{
				$email = $_GET['email'];
				if($email != "")
				{
					$this->db->where("email LIKE '$email%' ");
					$this->db->select('id');
					$this->db->from('user');
					$query = $this->db->get();
					
					
					if($query->num_rows() == 1)
					{
						$userid = $query->row();
						$user_id = $userid->id;
						$this->db->select('*');
						$this->db->from('team');
						$this->db->where('user_id', $user_id);
						$this->db->where('is_active', 1);
						$query = $this->db->get();
						$result = $query->result();
						return $result;
					}
					else
					{
						return array();
					}
				}
			}
		}
		
		public function resultsearchcount()
		{
			if(isset($_GET['email']))
			{
				$email = $_GET['email'];
				if($email != "")
				{
					$this->db->where("email LIKE '$email%' ");
					$this->db->select('id');
					$this->db->from('user');
					$query = $this->db->get();
					return $query->num_rows();
				}
			}
		}
		
		public function getallOpponentlist($data)
		{
		   	$event_id  = $data['event_id']; 
		   	$userEmail = $data['user_email']; 
		   	$teamId    = $data['team_id']; 
			$user_id   = $this->token->user_details->user_id;
						
			if(isset($event_id))
			{
				if($event_id != "")
				{
					$this->db->Where('e.event_id',$event_id);
					//$this->db->Where('e.created_by',$user_id);
				}
			}
			
			if(isset($userEmail))
			{
				if($userEmail != "")
				{
					$this->db->Where('e.inviteduser_email',$userEmail);
				}
			}
			
			if(isset($teamId))
			{
				if($teamId != "")
				{
					$this->db->Where('e.team_id',$teamId);
				}
			}
			
			$this->db->select('e.id as mainId,e.event_id, e.event_id as id, e.team_id, e.inviteduser_email, e.status, e.created_by, e.is_ratable,e.opponent_address, u.email as created_by_email, t.team_name, a.name, a.date, a.time,a.team_id as created_team_id,t1.team_name as created_team_name,t1.team_logo as created_team_logo,c.points, a.is_enabled');
			$this->db->from('event_request e');
			$this->db->where('e.status !=','Pending');
			$this->db->join('team t', 't.id = e.team_id', 'LEFT');
			$this->db->join('event a', 'a.id = e.event_id', 'LEFT');
			$this->db->join('team t1', 't1.id = a.team_id', 'LEFT');
			$this->db->join('user u', 'u.user_id = e.created_by', 'LEFT');
			$this->db->join('comments c', 'c.event_id = e.event_id', 'LEFT');
			$this->db->distinct('mainId');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if( $query->num_rows() > 0 )
			{
				$results =  $query->result(); 
				for($i=0; isset($results[$i]); $i++)
				{
					$this->db->select('AVG(points) as avg_points');
					$this->db->from('comments');
					$this->db->Where('team_id',$results[$i]->team_id);
					$query1 = $this->db->get();
					$avgresult = $query1->row();
					$results[$i]->avg_rating = $avgresult->avg_points;
					$opponent_count = $query1->num_rows();
					$results[$i]->opponent_count = $opponent_count;
				}
				return $results;	
			}
			else
			{
				return false;
			}
		}
		
		public function getallOpponentlistByAdmin($event_id)
		{
		   	$this->db->Where('e.event_id',$event_id);
			
			$this->db->select('e.event_id, e.team_id, t.user_id, t.team_name, t.sports, t.is_age_group, t.age_group, t.gender, t.level, t.home, t.team_logo, t.time_zone, t.is_active, u.email as createdUserEmail, ag.title as ageGroupTitle, l.title as playLevelTitle, s.name as sportsName');
			$this->db->from('event_request e');
			$this->db->where('e.status !=','Pending');
			$this->db->join('team t', 't.id = e.team_id', 'LEFT');
			$this->db->join('user u', 'u.id = t.user_id', 'LEFT');
			$this->db->join('age_groups ag', 'ag.id = t.age_group', 'LEFT');
			$this->db->join('level l', 'l.id = t.level', 'LEFT');
			$this->db->join('sports s', 's.id = t.sports', 'LEFT');
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if( $query->num_rows() > 0 )
			{
				$results =  $query->result(); 
				return $results;	
			}
			else
			{
				return array();
			}
		}
		
		public function getAllTeam()
		{
			$this->db->select('a.id as team_id, a.is_active, a.team_name, a.sports, s.name as sports_name, a.age_group, ag.title as ageGroup_name, a.gender, a.level, l.title as playlevel_name, a.home, a.min_age, a.max_age, a.team_logo, a.time_zone, a.user_id as created_user,u.email as created_user_email');
			$this->db->from('team a');
			$this->db->join('user u', 'u.id = a.user_id', 'LEFT');
			$this->db->where('a.is_active', 1);
			$this->db->join('sports s', 's.id = a.sports', 'LEFT');
			$this->db->join('age_groups ag', 'ag.id = a.age_group', 'LEFT');
			$this->db->join('level l', 'l.id = a.level', 'LEFT');
			$query = $this->db->get();
			if( $query->num_rows() > 0 )
			{
				return $query->result(); 
			}
			else
			{
				return false;
			}
		}
		public function getAllTeamByAdmin()
		{
			$this->db->select('a.id as team_id, a.is_active, a.team_name, a.sports, s.name as sports_name, a.age_group, ag.title as ageGroup_name, a.gender, a.level, l.title as playlevel_name, a.home, a.min_age, a.max_age, a.team_logo, a.time_zone, a.user_id as created_user,u.email as created_user_email');
			$this->db->from('team a');
			$this->db->join('user u', 'u.id = a.user_id', 'LEFT');
			$this->db->join('sports s', 's.id = a.sports', 'LEFT');
			$this->db->join('age_groups ag', 'ag.id = a.age_group', 'LEFT');
			$this->db->join('level l', 'l.id = a.level', 'LEFT');
			$query = $this->db->get();
			if( $query->num_rows() > 0 )
			{
				return $query->result(); 
			}
			else
			{
				return false;
			}
		}
		
		public function getAllFilteredTeam($keywordSearch)
		{
			$this->db->select('a.id as team_id, a.is_active, a.team_name, a.sports, s.name as sports_name, a.age_group, ag.title as ageGroup_name, a.gender, a.level, l.title as playlevel_name, a.home, a.min_age, a.max_age, a.team_logo, a.time_zone, a.user_id as created_user,u.email as created_user_email');
			$this->db->from('team a');
			$this->db->join('user u', 'u.id = a.user_id', 'LEFT');
			$this->db->join('sports s', 's.id = a.sports', 'LEFT');
			$this->db->join('age_groups ag', 'ag.id = a.age_group', 'LEFT');
			$this->db->join('level l', 'l.id = a.level', 'LEFT');
			$this->db->where("a.team_name LIKE '%$keywordSearch%' ");
			$this->db->or_where("a.gender LIKE '%$keywordSearch%' ");
			$this->db->or_where("a.home LIKE '%$keywordSearch%' ");
			$query = $this->db->get();
			//echo $this->db->last_query(); die;
			if( $query->num_rows() > 0 )
			{
				return $query->result(); 
			}
			else
			{
				return false;
			}
		}
		
		public function getteamInvitationList($team_id)
		{
			$this->db->select('`ti.name`, `ti.email`, `ti.role`, `ti.status`, `u.dob`, `u.first_name`, `u.last_name`, `u.pic`');
			$this->db->from('team_invitation ti');
			$this->db->Where('team_id',$team_id);
			$this->db->join('user u', 'u.email = ti.email', 'LEFT');
			$query = $this->db->get();
			if( $query->num_rows() > 0)
			{
				return $query->result(); 
			}
			else
			{
				return array();
			}
		}
	}
