<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    public function getSubjectList($schoolID,$classID)
    {
        $this->db->where("class",$classID);
        $this->db->where("schoolId",$schoolID);
        $this->db->where("status",1);
        $this->db->order_by("id",'DESC');
        $query = $this->db->get("subjects");
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }

    public function getAllToDoDataList($student_id='',$schoolID='',$classID='')
		{
			$data = array();        
			$dataAssignment = $this->assignment_data($student_id,$schoolID,$classID);
            if(!empty($dataAssignment))
			{
				foreach ($dataAssignment as $tmp)
				{
					array_push($data,$tmp);
				}
			}           
			return $data;
        }
        
    public function assignment_data($student_id,$schoolID,$classID){
        $currdate=date('Y-m-d');
        $user_id="ST-".$student_id;
        $sql="SELECT ast.id,ast.title,ast.no_of_attempt,ast.submission_date,ast.open_submission_date,ast.created as createdDate,s.subject FROM (select * from assignment WHERE id NOT IN (select to_do_id from to_do_remove_data where user_id='$user_id' AND type='Assignment')) ast inner join subjects s on ast.subject_id=s.id WHERE ast.status=1 AND s.class='$classID' AND ast.id NOT IN (select assignment_id from assignment_submission WHERE user_id='$student_id') ORDER BY ast.submission_date";
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            //print_r($data_user);die;
            for($v=0; $v<count($data_user); $v++)
            {
                $data_user[$v]['createdDate']= date('Y-m-d',strtotime($data_user[$v]['createdDate']));
                $data_user[$v]['type'] = "Assignment";
                if($data_user[$v]['open_submission_date']<=$currdate && $data_user[$v]['open_submission_date']!='NULL'){
                    $data_user[$v]['isAssignmentOpen']=1;
                }else{
                    $data_user[$v]['isAssignmentOpen']=0;
                }
            }
            return $data_user;
            
        }else{
            return array();
        }
    }
    public function getSubjectDetails($subject_id,$classID){
        $sql="SELECT s.id,s.subject,s.image,s.description,s.schoolId,CONCAT(t.teacherfname,' ' ,t.teachermname,' ' ,t.teacherlname) as teachername FROM subjects s LEFT JOIN teacher t on s.teacher=t.id where s.id='$subject_id'";
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->row();
            $data_user->assignments = $this->getAssignment($data_user->id,$data_user->schoolId);
            return $data_user;
            
        }else{
            return array();
        }
    }
    public function getAssignment($subject_id,$schoolID) {
        $this->db->select('id,title,created');
        $this->db->from('assignment');
        $this->db->where('subject_id', $subject_id);
        $this->db->where('school_id', $schoolID);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data_user = $query->result_array();
            for($v=0; $v<count($data_user); $v++)
            {
                $data_user[$v]['created']= date('Y-m-d',strtotime($data_user[$v]['created']));
            }
            return $data_user;
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
    public function countRemoveToDoDaTA($student_id)
    {
             $user_id="ST-".$student_id;
            $this->db->select('*');
			$this->db->from('to_do_remove_data');
			$this->db->where('user_id', $user_id);
			$query = $this->db->get();
			return $query->num_rows();
    }
   
}
