<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {
    private $firebaseApiKey;
    public function __construct()
    {
        parent::__construct();
        $this->firebaseApiKey = 'AAAA-yhUx78:APA91bEfw76JlVWCTr70GIc2kXpzQyrJcIm-3e0P1EH_gLKMBvR3Y4OH4ogdidklZFOQM5sIRjfYduppdefXBl7MVyeHqGZMj31e3nA6zKb_7oS7aSSOXpHU7d2iTj9d0u8PsPXLHYXo';  // Replace with your Firebase server key
    }

    public function getNotification($action="",$teacherID='',$schoolID='',$limit='',$alldata='') {
        $schoolID="A-".$schoolID;
        $this->db->select("n.*,CONCAT(u.fname,' ' ,u.lname) as name,u.user_type");
        $this->db->from('notifications n');
        $this->db->join('alluser u','n.sender_id=u.id','INNER');
        $this->db->where('n.receiver_id', $schoolID);
        if($alldata==''){
        $this->db->where('n.is_read','0');
        }
        $this->db->where('n.is_delete',0);
        $this->db->order_by('n.created_on','DESC');
        if($action=='data'){
        $this->db->limit($limit);
        }
        $query = $this->db->get();
       // echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if($action=='data'){
            $data_data = $query->result_array();
            return $data_data;
            }else{
                return $query->num_rows();
            }
            } else {
            return array();
        }
    }
    public function updateNotification($where,$data)
    {
        $this->db->where($where);
        $this->db->update('notifications',$data);
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
        return $query;
    }

    public function sendPushNotification($deviceToken, $title, $message, $data = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';

        $notification = [
            'title' => $title,
            'body' => $message,
            'sound' => 'default'
        ];

        $fields = [
            'to' => $deviceToken,
            'notification' => $notification,
            'data' => $data  // Additional data you want to send
        ];

        $headers = [
            'Authorization: key=' . $this->firebaseApiKey,
            'Content-Type: application/json'
        ];

        // Initialize curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        
        // Execute curl
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('FCM Send Error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        
        return $result;
    }
}
