<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model_app extends CI_Model {

    public function teacherExist($email) {
        $this->db->select("id`");
        $this->db->where('teacheremail', $email);

        $query = $this->db->get('teacher');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getSchool($queryParameters) {
        $this->db->where($queryParameters);
        $this->db->where('status', 1);
        $this->db->where('is_email_verified', 1);

        $query = $this->db->get('school');
        //echo $this->db->last_query(); die;
        if ($query->result_id->num_rows == 1) {
            $data_user = $query->result_array();
            return $data_user[0];
        } else
            return false;
    }

    public function getCountryList() {
        $this->db->select('name,dial_code');
        $query = $this->db->get('country');
        //echo $this->db->last_query(); die;
        if ($query) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllEventsForSchool($id) {
        $this->db->where('school_id', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('events');
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllSessionForSchool($id) {
        $this->db->where('schoolId', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('sessions');
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllClassForSchool($id) {
        $this->db->where('schoolId', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('class');
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getonlyClassForSchool($id) {
        $this->db->select('id,class');
        $this->db->from('class');
        $this->db->where('schoolId', $id);
        $this->db->group_by('class');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getonlySectionForSchool($className) {
        $this->db->select('id,section');
        $this->db->from('class');
        $this->db->where('class', $className);
        $this->db->group_by('section');
        $this->db->order_by('id', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllSubjectForSchool($id) {
        $this->db->where('schoolId', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('subjects');
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllTeacherForSchool($id) {
        $this->db->where('schoolId', $id);
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get('teacher');
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getAllStudentsForSchool($id) {
        $this->db->select('c.*, p.fatherfname, p.fatherlname');
        $this->db->from('child c');
        $this->db->where('c.schoolId', $id);
        $this->db->join('parent p', 'p.id = c.parent_id', 'RIGHT');
        $query = $this->db->get();
        //echo $this->db->last_query(); die;

        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function verifySchoolSignup($data) {
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('verification_type', $data['verification_type']);
        $this->db->where('verfication_code', $data['verfication_code']);
        $query = $this->db->get("verification");
        //echo $this->db->last_query(); die;
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getAdminDetails() {
        $this->db->select("*");
        $this->db->where('id', 1);
        $this->db->where('active', 1);

        $query = $this->db->get('ics_admin');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getSchoolDetails($id) {
        $this->db->select("*");
        $this->db->where('id', $id);

        $query = $this->db->get('school');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getAllParent($schoolId) {
        $this->db->select("*");
        $this->db->where('schoolId', $schoolId);

        $query = $this->db->get('parent');
        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function getEventDetails($id) {
        $this->db->select("*");
        $this->db->where('id', $id);

        $query = $this->db->get('events');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getDriverDetails($id) {
        $this->db->select('d.*, s.school_name');
        $this->db->from('driver d');
        $this->db->where('d.id', $id);
        $this->db->join('school s', 'd.schoolId = s.id', 'LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getSessionDetails($id) {
        $this->db->select('s.*, ss.school_name');
        $this->db->from('sessions s');
        $this->db->where('s.id', $id);
        $this->db->join('school ss', 's.schoolId = ss.id', 'LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getClassDetails($id) {
        $this->db->select('c.*, ss.school_name');
        $this->db->from('class c');
        $this->db->where('c.id', $id);
        $this->db->join('school ss', 'c.schoolId = ss.id', 'LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getSubjectDetails($id) {
        $this->db->select('s.*, ss.school_name');
        $this->db->from('subjects s');
        $this->db->where('s.id', $id);
        $this->db->join('school ss', 's.schoolId = ss.id', 'LEFT');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getParentDetails($id) {
        $this->db->select("*");
        $this->db->where('id', $id);

        $query = $this->db->get('parent');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getSingleChildDetails($id) {
        $this->db->select("*");
        $this->db->where('id', $id);

        $query = $this->db->get('child');
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getChildDetails($id) {
        $this->db->select("*");
        $this->db->where('parent_id', $id);

        $query = $this->db->get('child');
        if ($query->result_id->num_rows != 0) {
            $data_user = $query->result_array();
            return $data_user;
        } else
            return false;
    }

    public function deleteEvent($id) {
        $this->db->where('id', $id);
        $query = $this->db->delete('events');
        return $query;
    }

    public function addSchool($data) {
        $this->db->insert('school', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function removeProfilePicAdmin($defaultProfilePic) {
        $defaultPic = array('photo' => $defaultProfilePic);
        $this->db->where('id', 1);
        $this->db->update('ics_admin', $defaultPic);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function removeProfilePicSchool($defaultProfilePic, $id) {
        $defaultPic = array('pic' => $defaultProfilePic);
        $this->db->where('id', $id);
        $this->db->update('school', $defaultPic);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function editEvent($data, $schoolId, $eventId) {
        $this->db->where('id', $eventId);
        $this->db->where('school_id', $schoolId);
        $this->db->update('events', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function changePasswordAdmin($oldPassword, $newPassword) {
        $newPassword = array('password' => $newPassword);
        $this->db->where('password', $oldPassword);
        $this->db->update('ics_admin', $newPassword);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function changePasswordSchool($oldPassword, $newPassword, $id) {
        $newPassword = array('password' => $newPassword);
        $this->db->where('password', $oldPassword);
        $this->db->where('id', $id);
        $this->db->update('school', $newPassword);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function updateAdminProfile($data) {
        $this->db->where('id', 1);
        $this->db->update('ics_admin', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function schoolDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('school', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function parentDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('parent', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function driverDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('driver', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function sessionDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('sessions', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function sectionDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('class', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function subjectsDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('subjects', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function teacherDisabled($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('teacher', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function updateSchoolProfile($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('school', $data);
        //echo $this->db->last_query(); die;
        if ($this->db->affected_rows()) {
            return true;
        } else {
            return false;
        }
    }

    public function addSchoolByAdmin($data) {
        $this->db->insert('school', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addParent($data) {
        $this->db->insert('parent', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addTeacher($data) {
        $this->db->insert('teacher', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addTeacherEducationalFields($data) {
        $this->db->insert('teacher_qualification', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addTeacherExperianceFields($data) {
        $this->db->insert('teacher_workexperiance', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function editParent($data, $parentID, $schoolId) {
        $this->db->where('id', $parentID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('parent', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function editDriver($data, $driverID, $schoolId) {
        $this->db->where('id', $driverID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('driver', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function editSession($data, $sessionID, $schoolId) {
        $this->db->where('id', $sessionID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('sessions', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function editClass($data, $classID, $schoolId) {
        $classtitle = $data['class'];
        $classsection = $data['section'];
        $this->db->select("*");
        $this->db->where('class', $classtitle);
        $this->db->where('section', $classsection);

        $query = $this->db->get('class');
        if ($query->num_rows() > 0) {
            return 'Already Exists.';
        } else {
            $this->db->where('id', $classID);
            $this->db->where('schoolId', $schoolId);
            $this->db->update('class', $data);
            //echo $this->db->last_query(); die;
            return ($this->db->affected_rows()) ? 1 : 0;
        }
    }

    public function editSubject($data, $subjectID, $schoolId) {
        $this->db->where('id', $subjectID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('subjects', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function editChild($data, $schoolId, $childID) {
        $this->db->where('id', $childID);
        $this->db->where('schoolId', $schoolId);
        $this->db->update('child', $data);
        //echo $this->db->last_query(); die;
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function addChild($data, $child_id) {
        $parentID = $data['parent_id'];
        $this->db->insert('child', $data);
        $id = $this->db->insert_id();
        $newid = $child_id . "," . $id;
        $updateArray = array('child_id' => $newid);
        $this->db->where('id', $parentID);
        $this->db->update('parent', $updateArray);
        return $id;
    }

    public function addDriver($data) {
        $this->db->insert('driver', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addSession($data) {
        $this->db->insert('sessions', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addClass($data) {
        $sections = explode(",", $data['section']);
        foreach ($sections as $section) {
            $addArr = array(
                'schoolId' => $data['schoolId'],
                'academicsession' => $data['academicsession'],
                'class' => $data['class'],
                'section' => $section,
                'status' => '1',
            );
            $this->db->insert('class', $addArr);
        }
        $id = $this->db->insert_id();
        return $id;
    }

    public function addSubject($data) {
        $this->db->insert('subjects', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function addEvent($data) {
        $this->db->insert('events', $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function verifyForgetPassword($data) {
        $this->db->where('user_id', $data['user_id']);
        $this->db->where('verification_type', $data['verification_type']);
        $this->db->where('verfication_code', $data['verfication_code']);
        $query = $this->db->get("verification");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function verifyAdminForgetPassword($data) {
        $this->db->where('user_id', 1);
        $this->db->where('verification_type', $data['verification_type']);
        $this->db->where('verfication_code', $data['verfication_code']);
        $query = $this->db->get("verification");
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getAdminUser($queryParameters) {
        $this->db->where('id', 1);
        $this->db->where('active', 1);

        $query = $this->db->get('ics_admin');
        if ($query->result_id->num_rows == 1) {
            $data_user = $query->result_array();
            return $data_user[0];
        } else
            return false;
    }

    public function resetPassword($userID, $password) {
        $this->db->where('id', $userID);
        return $this->db->update('ics_admin', array('password' => $password));
    }

    public function updateVerificationStatus($id, $data) {
        $this->db->where('id', $id);
        $this->db->update("verification", $data);
        $this->db->query("UPDATE `verification` SET `retry_count`=`retry_count`+1 WHERE id=$id;");
    }

    public function updateUserStatus($userID, $data) {
        $this->db->where('id', $userID);
        $this->db->update("user", $data);
    }

    public function updateSchoolStatus($userID, $data) {
        $this->db->where('id', $userID);
        $this->db->update("school", $data);
        //echo $this->db->last_query(); die;
    }

    public function validate($email, $phn) {
        if (!empty($email)) {
            $this->db->from('teacher u');
            $this->db->where('u.status', 1);
            $this->db->where('u.teacheremail', $email);
            $query = $this->db->get();
        } else {
            $this->db->select("*");
            $this->db->from('teacher u');
            $this->db->where('u.status', 1);
            $this->db->where('u.teacherphone', $phn);
            $query = $this->db->get();
        }

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function addToken($data) {
        $this->db->insert('user_token', $data);
    }

    public function editTeacher($data, $teacherID) {
        $this->db->where('id', $teacherID);
        $this->db->update('teacher', $data);
        return ($this->db->affected_rows()) ? 1 : 0;
    }

    public function isotpvalid($otp, $user_id) {
        $this->db->select('u.*,s.school_name,s.pic as school_pic');
        $this->db->from('teacher u');
        $this->db->join('school s', 's.id=u.schoolId','left');

        $this->db->where(array('u.otp' => $otp, 'u.id' => $user_id, 'u.status' => 1));
        $this->db->limit(1);

        $this->db->order_by('u.id', 'desc');
        $query = $this->db->get();

        //echo $this->db->last_query(); die;

        if ($query->num_rows() > 0) {
            $user = $query->row();
            return $user;
        }

        return false;
    }

    public function getpasteventsList($schoolId) {
        $data_user1 = array();
        $cd = date('Y-m-d');
        $this->db->select('*');
        $this->db->where(array('school_id' => $schoolId));
        $query = $this->db->get('events');
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("m/d/Y");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = substr($data_user[$i]['date'], 4, 11);
                $data_user[$i]['date'] = date('m/d/Y', strtotime($strDate));
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
                return '';
            }
        } else
            return false;
    }

    public function getupcomingeventsList($schoolId) {
        $data_user2 = array();
        $cd = date('Y-m-d');
        $this->db->select('*');
        $this->db->where(array('school_id' => $schoolId));
        $query = $this->db->get('events');
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("m/d/Y");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = substr($data_user[$i]['date'], 4, 11);
                $data_user[$i]['date'] = date('m/d/Y', strtotime($strDate));
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
                return '';
            }
        } else
            return false;
    }

}
