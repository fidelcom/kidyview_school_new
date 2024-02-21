<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Message_model extends CI_Model {
    public function getUser($userType='',$classId='',$userId=''){
        if($userType=='student'){
            $this->db->select('ch.id,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as name');
            $this->db->from("child ch");
            $this->db->where("ch.childclass =",$classId);
            $this->db->where_not_in("ch.id",$userId);
            $this->db->where("ch.status",1);
            $this->db->order_by("ch.childfname");       
            $query = $this->db->get();
            if($query->num_rows () > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }     
        }elseif($userType=='teacher'){
           
            $query = $this->db->query("SELECT u.* FROM ((SELECT t.id,CONCAT(t.teacherfname,' '  ,t.teachermname,' ' ,t.teacherlname) as name FROM teacher t inner join subjects s on t.id=s.teacher where s.class='$classId' AND t.status=1 ) UNION (SELECT t.id,CONCAT(t.teacherfname,' ' ,t.teachermname,' ' ,t.teacherlname) as name FROM teacher t  where FIND_IN_SET('$classId',t.assignclassteacher) AND t.status=1 )) u
                GROUP BY u.id ORDER BY u.id DESC"); 
            if($query->num_rows () > 0)
            {
                return $query->result_array();
            }
            else
            {
                return array();
            }     

        }         
    } 

    public function add($data,$tbl_name){
        $this->db->insert($tbl_name,$data);
        return $this->db->insert_id();
    }      
    public function getMessageList($schoolID='',$user_id=''){
        //$sql='SELECT ast.*,CONCAT(c.class," " ,c.section) as classname,s.subject ,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername,asu.id as asid,asu.submission_date as datesubmited FROM class c inner join subjects s on c.id=s.class inner join teacher t on s.teacher=t.id inner join assignment ast on ast.subject_id=s.id inner join assignment_submission asu on asu.assignment_id=ast.id  where asu.user_id='.$user_id.'';
       $sql="SELECT m.id,m.message,m.created_date,CONCAT(u1.fname,' ' ,u1.lname) as sname, u1.photo as sphoto,u1.user_type as sutype, CONCAT(u2.fname,' ' ,u2.lname) as rname,u2.photo as rphoto,u2.user_type as rutype FROM messages m inner join alluser u1 on m.sender=u1.id inner join alluser u2 on m.reciever=u2.id where (m.sender='".$user_id."' OR m.reciever='".$user_id."')";
        $query=$this->db->query($sql);
        if($query->num_rows() > 0)
        {
            $data_user = $query->result_array();
            for($v=0; $v<count($data_user); $v++)
            {
               $data_user[$v]['created']= get_time_ago(strtotime($data_user[$v]['created_date']));
            }
            return $data_user;
            
        }else{
            return array();
        }
    }
    function allData($user) {
        $q = $this->input->get('q');
        if($q != '')
        {
            $query = $this->db->query("SELECT s.* FROM (
                                    (SELECT DISTINCT(reciever) as user_id, `m`.`id`
                                    FROM `messages` `m` 
                                    WHERE `sender` = '$user' AND `m`.`message` LIKE '%$q%' 
                                    AND m.sender_deleted = 0)
                                    UNION 
                                    (SELECT DISTINCT(sender) as user_id,`m`.`id` 
                                    FROM `messages` `m` 
                                    WHERE `reciever` = '$user' AND `m`.`message` LIKE '%$q%'
                                    AND `m`.`receiver_deleted` = 0))s
                                    GROUP BY s.user_id
                                    ORDER BY id DESC");
        }
        else
        {
            $query = $this->db->query("SELECT s.* FROM (
                                        (SELECT DISTINCT(reciever) as user_id, `m`.`id`
                                        FROM `messages` `m` 
                                        WHERE `sender` = '$user' 
                                        AND m.sender_deleted = 0 )
                                        UNION 
                                        (SELECT DISTINCT(sender) as user_id,`m`.`id` 
                                        FROM `messages` `m` 
                                        WHERE `reciever` = '$user' 
                                        AND `m`.`receiver_deleted` = 0))s
                                        GROUP BY s.user_id
                                        ORDER BY id DESC");
        }
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            $tmpData = array();                        
            for($i=0; $i < count($data); $i++)
            {
                $this->db->select("au.*");
                $this->db->from("alluser au");
                $this->db->where("au.id",$data[$i]->user_id);
                $query2 = $this->db->get();
                $dataUser = $query2->row();
                $dataUser->last_message = $this->lastMessage($user,$dataUser->id);
                array_push($tmpData,$dataUser);                
            }       
                        
            return $tmpData;
        }
        else
        {
            return array();
        }
    }
    
    function lastMessage($user1,$user2){
        $this->db->select("m.*");
        $this->db->from("messages m");
        $this->db->where("((m.sender = '$user1' AND  m.reciever = '$user2' AND m.sender_deleted = 0) OR (m.sender = '$user2' AND  m.reciever = '$user1' AND m.receiver_deleted = 0))");
        $q = $this->input->get('q');
        if($q !='')
        {
            $this->db->where("m.message LIKE '%$q%'");
        }
        $this->db->order_by("m.id","DESC");
        $query = $this->db->get();
        $data = $query->row();
        $data->time_elapsed = time_elapsed_string($data->created_date);
        return $data;
    }
    public function deleteMessage($id){
        $res = 0;                
        $this->db->where('id',$id);
        $this->db->update('messages',array('sender_deleted'=>1));
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        $this->db->where('id',$id);
        $this->db->update('messages',array('receiver_deleted'=>1));
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        return $res;
    }
       
}
