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
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
                {
                $data_user[$v]['id']= "ST-".$data_user[$v]['id'];
                }
                return $data_user;
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
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
                {
                $data_user[$v]['id']= "T-".$data_user[$v]['id'];
                }
                return $data_user;
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

    function allData($user,$school_id='') {
        $currentSession = get_current_session($school_id);
        $session_id = isset($currentSession) && $currentSession->id?$currentSession->id:'';
        
        $q = $this->input->get('q');
        if($q != '')
        {
            $query = $this->db->query("SELECT s.* FROM (
                                    (SELECT DISTINCT(reciever) as user_id, max(m.id) as id
                                    FROM `messages` `m` 
                                    WHERE `sender` = '$user' AND `m`.`message` LIKE '%$q%' 
                                    AND m.sender_deleted = 0 AND session_id='$session_id' GROUP BY user_id)
                                    UNION 
                                    (SELECT DISTINCT(sender) as user_id, max(m.id) as id
                                    FROM `messages` `m` 
                                    WHERE `reciever` = '$user' AND `m`.`message` LIKE '%$q%'
                                    AND `m`.`receiver_deleted` = 0 AND session_id='$session_id' GROUP BY user_id))s
                                    GROUP BY s.user_id
                                    ORDER BY id DESC");
        }
        else
        {
            $query = $this->db->query("SELECT s.* FROM (
                                        (SELECT DISTINCT(reciever) as user_id, max(m.id) as id
                                        FROM `messages` `m` 
                                        WHERE `sender` = '$user' 
                                        AND m.sender_deleted = 0 AND session_id='$session_id' GROUP BY user_id)
                                        UNION 
                                        (SELECT DISTINCT(sender) as user_id, max(m.id) as id
                                        FROM `messages` `m` 
                                        WHERE `reciever` = '$user' 
                                        AND `m`.`receiver_deleted` = 0 AND session_id='$session_id' GROUP BY user_id))s
                                        GROUP BY s.user_id
                                        ORDER BY s.id DESC");
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
                if(!empty($dataUser)){
                $dataUser->last_message = $this->lastMessage($user,$dataUser->id);
                array_push($tmpData,$dataUser);  
                }              
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
    public function deleteMessage($id,$user){
        $res = 0;                
        $this->db->where('id',$id);
        $this->db->where('sender',$user);
        $this->db->update('messages',array('sender_deleted'=>1));
        echo $this->db->last_query();
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        $this->db->where('id',$id);
        $this->db->where('reciever',$user);
        $this->db->update('messages',array('receiver_deleted'=>1));
        echo $this->db->last_query();
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        return $res;
    }
    function getConversation($user1,$user2) {        
        $this->db->select("m.*");
        $this->db->from("messages m");
        $this->db->where("((m.sender = '$user1' AND  m.reciever = '$user2' AND m.sender_deleted = 0) OR (m.sender = '$user2' AND  m.reciever = '$user1' AND m.receiver_deleted = 0))");
        $this->db->order_by("m.id");
        $query = $this->db->get();
        //echo $this->db->last_query();die; 
        $data = array();
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            for($i = 0; $i < count($data); $i++)
            {
                $data[$i]->attachments = $this->getAttachment($data[$i]->id);
                $data[$i]->time_elapsed = time_elapsed_string($data[$i]->created_date);
                
                if($data[$i]->sender == $user1)
                {
                    $data[$i]->message_type = 'send';
                }
                elseif($data[$i]->reciever == $user1)
                {
                    $data[$i]->message_type = 'recieved';
                }
            }            
        }
        
        return $data;
    }
    public function getAttachment($id) {
        $this->db->select('id,file_name as file');
        $this->db->from('message_attachment');
        $this->db->where('message_id', $id);
        $this->db->order_by('id', 'ASC');
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
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
    public function deleteConversationMessage($user1,$user2){
        $res = 0;                
        $this->db->where('sender',$user1);
        $this->db->where('reciever',$user2);
        $this->db->update('messages',array('sender_deleted'=>1));
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        $this->db->where('sender',$user2);
        $this->db->where('reciever',$user1);
        $this->db->update('messages',array('receiver_deleted'=>1));
        if($this->db->affected_rows() >= 1)
        {
            $res = 1;
        }
        return $res;
    }
       
}
