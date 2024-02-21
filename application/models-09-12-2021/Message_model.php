<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Message_model extends CI_Model {

    function usersbckp($user_id){

        $this->db->select("au.*");

        $this->db->from("alluser au");

        $this->db->order_by("au.fname");

        $this->db->where("au.id !=",$user_id);

        

        if(isset($_GET['name']))

        {

            if($_GET['name'] != '')

            {

                $name = $_GET['name'];

                $this->db->where("au.fname like '$name%'");

            }

        }

        

        if(isset($_GET['user_type']))

        {

            if($_GET['user_type'] != '')

            {

                $user_type = $_GET['user_type'];

                $this->db->where("user_type",$user_type);

            }

        }

        $this->db->where("au.school_id",$this->token->school_id);        

        

       // $this->db->limit(25);

        $query = $this->db->get();

        if($query->num_rows () > 0)

        {

            return $query->result();

        }

        else

        {

            return array();

        }                

    }
    function users($user_id){
        $user_id=$this->token->user_id;
        if(isset($_GET['user_type']) && $_GET['user_type']=='Student'){
            $sql='SELECT assignclassteacher FROM teacher where id='.$user_id.'';
            $query=$this->db->query($sql);
            $data_user = $query->row();
            $class_id=$data_user->assignclassteacher;
            $sql='SELECT ch.id,ch.childfname as fname,ch.childmname as mname,ch.childlname as lname from child ch where ch.childclass IN ('.$class_id.') AND status=1';
            if(isset($_GET['name']))

            {

            if($_GET['name'] != '')

            {
                $name = $_GET['name'];
                $sql .= " AND ch.childfname like '$name%'";
            }

            }
            // /echo $sql;die;
            $query=$this->db->query($sql);
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
        }elseif(isset($_GET['user_type']) && $_GET['user_type']=='Teacher'){
           
            $sql="SELECT id,teacherfname as fname,teachermname as mname,teacherlname as lname FROM teacher where schoolId=".$this->token->school_id." AND id !=$user_id AND status=1";
            if(isset($_GET['name']))

            {

            if($_GET['name'] != '')

            {
                $name = $_GET['name'];
                $sql .= " AND teacherfname like '$name%'";
            }

            }
            $query=$this->db->query($sql);
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
        elseif(isset($_GET['user_type']) && $_GET['user_type']=='School Admin'){
           
            $sql="SELECT id,school_name as fname FROM school where id=".$this->token->school_id." AND status=1";
            if(isset($_GET['name']))

            {

            if($_GET['name'] != '')

            {
                $name = $_GET['name'];
                $sql .= " AND school_name like '$name%'";
            }

            }
            $query=$this->db->query($sql);
            if($query->num_rows () > 0)
            {
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
                {
                $data_user[$v]['id']= "S-".$data_user[$v]['id'];
                $data_user[$v]['lname']= "";
    
                }
                return $data_user;
            }
            else
            {
                return array();
            }     

        }
        elseif(isset($_GET['user_type']) && $_GET['user_type']=='Parent'){
            $sql='SELECT assignclassteacher FROM teacher where id='.$user_id.'';
            $query=$this->db->query($sql);
            $data_user = $query->row();
            $class_id=$data_user->assignclassteacher;
            $sql='SELECT ch.parent_id from child ch where ch.childclass IN ('.$class_id.') AND status=1';
            
            $query=$this->db->query($sql);
            if($query->num_rows () > 0)
            {
                $data_user = $query->result_array();
                $studetidArr=array();
                for($v=0; $v<count($data_user); $v++)
                {
                array_push($studetidArr,$data_user[$v]['parent_id']);
                }
            $studetidArr=array_unique($studetidArr);
            $studetidArr=implode(',',$studetidArr);
            $sql="SELECT id,fatherfname as fname,fatherlname as lname FROM parent where id IN ($studetidArr) AND schoolId=".$this->token->school_id." AND status=1";
            if(isset($_GET['name']))

            {

            if($_GET['name'] != '')

            {
                $name = $_GET['name'];
                $sql .= " AND fatherfname like '$name%'";
            }

            }
            $query=$this->db->query($sql);
            if($query->num_rows () > 0)
            {
                $data_user = $query->result_array();
                for($v=0; $v<count($data_user); $v++)
                {
                $data_user[$v]['id']= "P-".$data_user[$v]['id'];
                }
                return $data_user;
            }
            else
            {
                return array();
            } 
            }
            else
            {
                return array();
            }     
        }
    }

    function getParent(){

        

    }

    

    function addMessage($data) {

        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('messages', $data);

        return $this->emojidb->insert_id();

    }

    function addAttachment($data) {

        $this->db->insert('message_attachment', $data);

        return $this->db->insert_id();

    }

    

    function allData($user) {

        $q = $this->input->get('q');

//        if($q != '')
//
//        {
//
//            $query = $this->db->query("SELECT s.* FROM (
//
//                                    (SELECT (reciever) as user_id, max(`m`.`id`) as id
//
//                                    FROM `messages` `m` 
//
//                                    WHERE `sender` = '$user' AND `m`.`message` LIKE '%$q%' 
//
//                                    AND m.sender_deleted = 0 GROUP BY reciever)
//
//                                    UNION 
//
//                                    (SELECT (sender) as user_id,max(`m`.`id`) as id
//
//                                    FROM `messages` `m` 
//
//                                    WHERE `reciever` = '$user' AND `m`.`message` LIKE '%$q%'
//
//                                    AND `m`.`receiver_deleted` = 0 GROUP BY sender))s
//
//                                    GROUP BY s.user_id
//
//                                    ORDER BY id DESC");
//
//        }
//
//        else
//
//        {
//
//            $query = $this->db->query("SELECT s.* FROM (
//
//                                        (SELECT (reciever) as user_id, max(`m`.`id`) as id
//
//                                        FROM `messages` `m` 
//
//                                        WHERE `sender` = '$user' 
//
//                                        AND m.sender_deleted = 0 GROUP BY reciever)
//
//                                        UNION 
//
//                                        (SELECT (sender) as user_id,max(`m`.`id`) as id
//
//                                        FROM `messages` `m` 
//
//                                        WHERE `reciever` = '$user' 
//
//                                        AND `m`.`receiver_deleted` = 0 GROUP BY sender))s
//
//                                        GROUP BY s.user_id
//
//                                        ORDER BY id DESC");
//
//        }

        $query = $this->db->query("SELECT s.* FROM (

                                        (SELECT (reciever) as user_id, max(`m`.`id`) as id

                                        FROM `messages` `m` 

                                        WHERE `sender` = '$user' 

                                        AND m.sender_deleted = 0 GROUP BY reciever)

                                        UNION 

                                        (SELECT (sender) as user_id,max(`m`.`id`) as id

                                        FROM `messages` `m` 

                                        WHERE `reciever` = '$user' 

                                        AND `m`.`receiver_deleted` = 0 GROUP BY sender))s

                                        GROUP BY s.user_id

                                        ORDER BY id DESC");

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

                if($query2->num_rows() > 0)

                {

                    $dataUser = $query2->row();

                    $dataUser->last_message = $this->lastMessage($user,$dataUser->id);

                    array_push($tmpData,$dataUser);  

                }

            }
            
            
            ########## Filter Searching Data ###########
            $tmpData = json_decode(json_encode($tmpData),true);  
            if($q != '') 
           {
            $k=0;   
            $text = strtolower($q);
            $searchArray = array();
            for($i=0;$i<count($tmpData);$i++) {
                if ((strpos(strtolower($tmpData[$i]['fname']),$text) !== false) || (strpos(strtolower($tmpData[$i]['lname']),$text) !== false)) {    
                    $searchArray[$k] = $tmpData[$i];
                    $k++;
                }    
            }
            $tmpData = $searchArray;
            }
           ########### End Filter Data #################

                        

            return $tmpData;

        }

        else

        {

            return array();

        }

    }

    

    function lastMessage($user1,$user2){

        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("m.*");

        $this->emojidb->from("messages m");

        $this->emojidb->where("((m.sender = '$user1' AND  m.reciever = '$user2' AND m.sender_deleted = 0) OR (m.sender = '$user2' AND  m.reciever = '$user1' AND m.receiver_deleted = 0))");

        $q = $this->input->get('q');

//        if($q !='')
//
//        {
//
//            $this->emojidb->where("m.message LIKE '%$q%'");
//
//        }

        $this->emojidb->order_by("m.id","DESC");

        $query = $this->emojidb->get();

        

        $data = array();

        if($query->num_rows() > 0)

        {

            $data = $query->row();

            $data->time_elapsed = time_elapsed_string($data->created_date);

        }

        return $data;

    }

    

    function allDataCount(){

        $schoolId = $this->token->school_id; 

        $this->db->select("count(d.id) as total");

        $this->db->from("discussion d");

        $this->db->where("d.school_id",$schoolId);

        $this->db->where("d.status",1);    

        

        if(isset($_GET['detail'])) 

        {

            if($_GET['detail'] != '')

            {

                $this->db->where("d.detail",$_GET['detail']);

            }

        }

        

        if(isset($_GET['discussion_type'])) 

        {

            if($_GET['discussion_type'] != '')

            {

                $this->db->where("d.discussion_type",$_GET['discussion_type']);

            }

        }

        

        $query = $this->db->get();

        return $query->row()->total;

    }

    

    function getConversation($user1,$user2) {        

        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("m.*");

        $this->emojidb->from("messages m");

        $this->emojidb->where("((m.sender = '$user1' AND  m.reciever = '$user2') OR (m.sender = '$user2' AND  m.reciever = '$user1'))");

        $this->emojidb->order_by("m.id","DESC");

        $query = $this->emojidb->get();

        

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

    

    public function deleteMessage($id,$user){

        $res = 0;                

        $this->db->where('id',$id);

        $this->db->where('sender',$user);

        $this->db->update('messages',array('sender_deleted'=>1));

        if($this->db->affected_rows() >= 1)

        {

            $res = 1;

        }

        

        $this->db->where('id',$id);

        $this->db->where('reciever',$user);

        $this->db->update('messages',array('receiver_deleted'=>1));

        if($this->db->affected_rows() >= 1)

        {

            $res = 1;

        }

        

        return $res;

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

