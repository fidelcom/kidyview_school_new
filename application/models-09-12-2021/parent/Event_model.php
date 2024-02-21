<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Event_model extends CI_Model {    
    public function getpasteventsList($schoolId) {        
        $data_user1 = array();
        $cd = date('Y-m-d');
        $this->db->select('*');
        $this->db->where(array('school_id' => $schoolId));
        $student_id = $this->token->student_id;
        $this->db->where("((find_in_set($student_id,child_id) AND 1) OR child_id = 0)");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get('events');
        //echo $this->db->last_query();die;
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("Y-m-d");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = $data_user[$i]['date'];
                $data_user[$i]['date'] = date('Y-m-d', strtotime($strDate));
                $today = strtotime($date1);
                $db_date = strtotime($data_user[$i]['date']);
                if ($db_date < $today) {
                    $data_user[$i]['eventkey'] = 'Past';
                } else {
                    $data_user[$i]['eventkey'] = 'Upcoming';
                }
            }
            for ($i = 0; $i < count($data_user); $i++) {
                $eventKey = $data_user[$i]['eventkey'];
                if ($eventKey == 'Past') {
                    $data_user1[] = $data_user[$i];
                }
            }
            if (!empty($data_user1)) {
                return $data_user1;
            } else {
                return array();
            }
        } else
            return false;
    }

    public function getupcomingeventsList($schoolId) {
        $data_user2 = array();
        $cd = date('Y-m-d');
        $this->db->select('*');
        $this->db->where(array('school_id' => $schoolId));
        $student_id = $this->token->student_id;
        $this->db->where("((find_in_set($student_id,child_id) AND 1) OR (child_id = 0 AND (find_in_set('1',visibility) AND 1)))");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get('events');
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("Y-m-d");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = $data_user[$i]['date'];
                
                $data_user[$i]['date'] = date('Y-m-d', strtotime($strDate));
                $today = strtotime($date1);
                $db_date = strtotime($data_user[$i]['date']);
                if ($db_date < $today) {
                    $data_user[$i]['eventkey'] = 'Past';
                } else {
                    $data_user[$i]['eventkey'] = 'Upcoming';
                }
            }
            for ($i = 0; $i < count($data_user); $i++) {
                $eventKey = $data_user[$i]['eventkey'];
                if ($eventKey == 'Upcoming') {
                    $data_user2[] = $data_user[$i];
                }
            }
            if (!empty($data_user2)) {
                return $data_user2;
            } else {
                return array();
            }
        } else
            return false;
    }
    
    public function getEventById($event_id = '') {
        $this->db->select("events.*,school.school_name,teacher.teacherfname,teacher.teachermname,teacher.teacherlname,class.class,class.section");
        $this->db->from('events');
        $this->db->join('school', 'events.school_id=school.id', 'LEFT');
        $this->db->join('teacher', 'events.teacher_id=teacher.id', 'LEFT');
        $this->db->join('class', 'events.class_id=class.id', 'LEFT');
        
        $this->db->where('events.id', $event_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $dataEvent = $query->result();
            $studentData = $dataEvent[0]->child_id;
            $studentDataExp = explode(',', $studentData);
            for ($i = 0; $i < count($dataEvent); $i++) {                
                $strDate = $dataEvent[$i]->date;
                $dataEvent[$i]->date = date('Y-m-d', strtotime($strDate));
            }
            $studentT = array();
            for ($j = 0; $j < count($studentDataExp); $j++) {
                $student = $this->getStudentListById($studentDataExp[$j]);
                if (!empty($student)) {
                    $studentT[] = $student->childfname . ' ' . $student->childmname . ' ' . $student->childlname;
                }
            }
            $dataEvent[0]->studentname = implode(',', $studentT);
            return $dataEvent;
        } else {
            return false;
        }
    }
    
    public function getStudentListById($student_id = '') {
        $this->db->select("id,childfname,childmname,childlname");
        $this->db->from('child');
        $this->db->where('id', $student_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }
}
