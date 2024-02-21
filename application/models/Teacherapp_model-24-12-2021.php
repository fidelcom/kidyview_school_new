<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Teacherapp_model extends CI_Model {

    public function getclassListBySchoolId($school_id = '') {
        $this->db->select("id,class,section");
        $this->db->from('class');
        $this->db->where('schoolId', $school_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getStudentListByClassId($class_id = '') {
        $this->db->select("id,childfname,childmname,childlname,childphoto");
        $this->db->from('child');        
        $this->db->where('childclass', $class_id);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function studentList() {
        $this->db->select("id,childfname,childmname,childlname,childphoto");
        $this->db->from('child');
        if(isset($_GET['classId']))
        {
            if($_GET['classId'] != '')
            {
                $class_id = $_GET['classId'];
                $this->db->where('childclass', $class_id);
            }
        }
        if(isset($_GET['name']))
        {
            if($_GET['name'] != '')
            {
                $name = $_GET['name'];
                $this->db->where("childfname LIKE '$name%'");
            }
        }
        
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
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

    public function getEventById($event_id = '') {
        $this->db->select("events.*,school.school_name,teacher.teacherfname,teacher.teachermname,teacher.teacherlname,class.class,class.section");
        $this->db->from('events');
        $this->db->join('school', 'events.school_id=school.id', 'LEFT');
        $this->db->join('teacher', 'events.teacher_id=teacher.id', 'LEFT');
        $this->db->join('class', 'events.class_id=class.id', 'LEFT');
        //$this->db->join('child','events.child_id=child.id','LEFT');
        $this->db->where('events.id', $event_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $dataEvent = $query->result();
            $studentData = $dataEvent[0]->child_id;
            $studentDataExp = explode(',', $studentData);
            for ($i = 0; $i < count($dataEvent); $i++) {
                //$strDate = substr($dataEvent[$i]->date,4,11);
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

    public function viewTeacherProfileById($teacher_id = '') {
        $this->db->select("*");
        $this->db->from('teacher');
        $this->db->where('id', $teacher_id);
        $query = $this->db->get();
        $teacherworkExperience = array();
        $teacherqualification = array();
        if ($query->num_rows() > 0) {
            $teacherData = $query->result();
            $schoolTypeData = $teacherData[0]->schoolType;
            $schoolTypeExp = explode(',', $schoolTypeData);
            $classData = $teacherData[0]->assignclassteacher;
            $classDataExp = explode(',', $classData);

            if (!empty($teacherData)) {
                foreach ($teacherData as $teacher) {
                    $teacherId = $teacher->id;

                    $teacherSubject = $this->teacherSubjects($teacherId);
                    //print_r($teacherSubject);die;
                    if($teacherSubject)
                    {
                        $teacherSubject = array_column($teacherSubject, 'subject');
                        $teacherSubject = implode(",",$teacherSubject);

                        $teacherData[0]->subjectteacher = $teacherSubject;

                    }else{
                        $teacherData[0]->subjectteacher = '';

                    }

               // prd($teacherSubject);

                    $workexpData = $this->teacherWorkExprience($teacherId);
                    if (!empty($workexpData)) {
                        foreach ($workexpData as $work) {
                            $teacherworkExperience[] = $work;
                        }
                    }
                    $teacher->workExperienceData = $teacherworkExperience;

                    $workqualificationData = $this->teacherQualification($teacherId);
                    if (!empty($workqualificationData)) {
                        foreach ($workqualificationData as $qualification) {
                            $teacherqualification[] = $qualification;
                        }
                    }
                    $schoolT = array();
                    $classT = array();
                    $teacher->qualificationData = $teacherqualification;
                    for ($i = 0; $i < count($schoolTypeExp); $i++) {
                        $school_type = $this->schooltype($schoolTypeExp[$i]);
                        $schoolT[] = $school_type;
                    }
                    for ($j = 0; $j < count($classDataExp); $j++) {
                        $class = $this->getclass($classDataExp[$j]);
                        if (!empty($class)) {
                            $classT[] = $class->class . '-' . $class->section;
                        }
                    }

                    $teacher->schoolname = implode(',', $schoolT);
                    $teacher->classname = implode(',', $classT);
                }
            }
            // prd($teacher);
            return $teacher;
        } else {
            return false;
        }
    }

    public function teacherSubjects($teacherId = '') {
        $where = array('teacher'=> $teacherId, 'status'=>1);
        $this->db->select("id as subject_id, subject");
        $this->db->from('subjects');
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    public function teacherWorkExprience($teacher_id = '') {
        $this->db->select("*");
        $this->db->from('teacher_workexperiance');
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function teacherQualification($teacher_id = '') {
        $this->db->select("*");
        $this->db->from('teacher_qualification');
        $this->db->where('teacher_id', $teacher_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function articleList($school_id = '', $user_id = '', $usertype = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("*");
        $this->emojidb->from('article');
        $this->emojidb->where('status', '1');
        $this->emojidb->where('schoolId', $school_id);
        $this->emojidb->order_by('id', 'DESC');
        $query = $this->emojidb->get();
        if ($query->num_rows() > 0) {
            $dataArticle = $query->result();
            for ($i = 0; $i < count($dataArticle); $i++) {
                $dataArticle[$i]->created_time = date('d M,Y', strtotime($dataArticle[$i]->created_time));
                $dataArticle[$i]->comments = $this->countArticleComment($dataArticle[$i]->id);
                $dataArticle[$i]->like = $this->countArticleLike($dataArticle[$i]->id);
                $dataArticle[$i]->view = $this->countArticleView($dataArticle[$i]->id);
                $islikeArr = array();
                $islikeArr['article_id'] = $dataArticle[$i]->id;
                $islikeArr['user_id'] = $user_id;
                $islikeArr['user_type'] = $usertype;
                $dataArticle[$i]->is_like = $this->isUserLike($islikeArr);
            }
            return $dataArticle;
        } else {
            return false;
        }
    }

    public function viewArticleDetails($article_id = '', $user_id = '', $usertype = '') {
        $viewData = array(
            'article_id'=>$article_id,
            'schoolId'=>$this->token->school_id,
            'user_id'=>$user_id,
            'user_type'=>$usertype,
            'created_time'=>date("Y-m-d H:i:s")
        );
        
        $this->inserArticleView($viewData);        
        
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select("*");
        $this->emojidb->from('article');
        $this->emojidb->where('id', $article_id);
        $query = $this->emojidb->get();
        if ($query->num_rows() > 0) {
            $dataArticle = $query->result();
            $commentArray = array();
            for ($i = 0; $i < count($dataArticle); $i++) {
                $dataArticle[$i]->created_time = date('d M,Y', strtotime($dataArticle[$i]->created_time));
                $dataArticle[$i]->comments = $this->countArticleComment($dataArticle[$i]->id);
                $dataArticle[$i]->like = $this->countArticleLike($dataArticle[$i]->id);
                $dataArticle[$i]->view = $this->countArticleView($dataArticle[$i]->id);
                $commentData = $this->getCommentByArticleId($dataArticle[$i]->id);
                $dataArticle[0]->commentList = $commentData;
                $islikeArr = array();
                $islikeArr['article_id'] = $dataArticle[$i]->id;
                $islikeArr['user_id'] = $user_id;
                $islikeArr['user_type'] = $usertype;
                $dataArticle[$i]->is_like = $this->isUserLike($islikeArr);
            }

            return $dataArticle;
        } else {
            return false;
        }
    }

    public function createEvent($eventData = array()) {
        $this->db->insert('events', $eventData);
        return true;
    }

    public function saveTeacherPersonalDetail($teacherData = array(), $id = '') {
        $this->db->where('id', $id);
        $this->db->update('teacher', $teacherData);
        return true;
    }

    public function saveTeacherProfessionalDetail($workeExpData = array(), $id = '') {
        $this->db->where('id', $id);
        $this->db->update('teacher_workexperiance', $workeExpData);
        return true;
    }

    public function addTeacherProfessionalData($workeExpData = array()) {
        $this->db->insert('teacher_workexperiance', $workeExpData);
        return true;
    }

    public function saveTeacherProfessionalExperienceDetail($workeExpData = array(), $id = '') {
        $this->db->where('id', $id);
        $this->db->update('teacher_qualification', $workeExpData);
        return true;
    }

    public function addTeacherProfessionalExperienceData($workeExpData = array()) {
        $this->db->insert('teacher_qualification', $workeExpData);
        return true;
    }

    public function getpasteventsList($schoolId) {
        $data_user1 = array();
        $cd = date('Y-m-d');
        $this->db->select('*');
        $this->db->where(array('school_id' => $schoolId));
        $this->db->where("((FIND_IN_SET('0', visibility) AND 1) OR visibility = '' )");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get('events');
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("Y-m-d");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = $data_user[$i]['date'];
                //$strDate = substr($data_user[$i]['date'],4,11);
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
        $this->db->where("((FIND_IN_SET('0', visibility) AND 1) OR visibility = '' )");
        $this->db->order_by("id", "DESC");
        $query = $this->db->get('events');
        if ($query) {
            $data_user = $query->result_array();
            $date1 = date("Y-m-d");
            for ($i = 0; $i < count($data_user); $i++) {
                $strDate = $data_user[$i]['date'];
                //$strDate = substr($data_user[$i]['date'],4,11);
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

    public function getCommonList($table_name = '') {
        $this->db->select('*');
        $this->db->from($table_name);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getSchoolTypeClassList($schoolType) {
        $this->db->select('t.assignclassteacher');
        $this->db->from('teacher t');
        $this->db->where('t.id', $this->token->user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $classList = $query->row()->assignclassteacher;
            //echo $classList;die;
            $this->db->select("id, class, section");
            $this->db->from("class");
            $this->db->where("FIND_IN_SET(id,'$classList') AND 1");
            $this->db->where('school_type', $schoolType);
            $this->db->where('status', 1);
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                $data =  $query->result();            
                return $data;
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
        /*
        $this->db->select('id,class,section');
        $this->db->from('class');
        $this->db->where('school_type', $schoolType);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
        */
    }
    public function getClassList($schoolId = '', $table_name = '') {
        $this->db->select('id,class,section');
        $this->db->from($table_name);
        $this->db->where('schoolId', $schoolId);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function getSubjectList($schoolId = '', $table_name = '') {
        $this->db->select('id,subject');
        $this->db->from($table_name);
        $this->db->where('schoolId', $schoolId);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    public function inserArticleComment($commentData = array()) {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('article_comment', $commentData);
        return true;
    }

    public function inserArticleLike($likeData = array()) {
        $this->db->insert('article_like', $likeData);
        return true;
    }
    public function inserArticleView($viewData = array()) {
        $this->db->where('article_id',$viewData['article_id']);
        $this->db->where('schoolId',$this->token->school_id);
        $this->db->where('user_id',$viewData['user_id']);
        $this->db->where('user_type',$viewData['user_type']);
        $query = $this->db->get("article_view");
        
        if($query->num_rows() == 0)
        {
            $this->db->insert('article_view', $viewData);
        }
        return true;
    }

    public function countArticleComment($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_comment');
        $this->db->where('article_id', $article_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countArticleLike($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_like');
        $this->db->where('article_id', $article_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countArticleView($article_id = '') {
        $this->db->select('*');
        $this->db->from('article_view');
        $this->db->where('article_id', $article_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function schooltype($value = '') {
        $this->db->select('name');
        $this->db->from('schooltype');
        $this->db->where('value', $value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('name');
        } else {
            return false;
        }
    }

    public function getclass($id) {
        $this->db->select('class,section');
        $this->db->from('class');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return false;
        }
    }

    public function getCommentByArticleId($articleId = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select('c.comment,c.id as cid,au.id as uid,au.fname,au.lname,au.photo');
        $this->emojidb->from('article_comment c');
        $this->emojidb->join('alluser au', 'c.user_id=au.id', 'LEFT');
        $this->emojidb->where('article_id', $articleId);
        $query = $this->emojidb->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return array();
        }
    }

    public function isUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('article_like');
        $this->db->where('article_id', $likeData['article_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function deleteUserLike($likeData = array()) {
        $this->db->where('article_id', $likeData['article_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('article_like');
        return true;
    }

    function insertArticleViewUser($viewData = array()) {
        $this->db->insert('article_view', $viewData);
        return true;
    }

    public function isUserView($viewData = array()) {
        $this->db->select('*');
        $this->db->from('article_view');
        $this->db->where('article_id', $viewData['article_id']);
        $this->db->where('user_id', $viewData['user_id']);
        $this->db->where('user_type', $viewData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }
    
    function addNewAlbum($albumData = array(), $tbl_name = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert($tbl_name, $albumData);
        return $this->emojidb->insert_id();
    }

    function addAlbum($albumData = array(), $tbl_name = '') {
        $this->db->insert($tbl_name, $albumData);
        return $this->db->insert_id();
    }

    function getAlbumDataList($schoolId = '', $teacher_id = '') {
        
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $query = "select * from album where album.schoolId='" . $schoolId . "' AND status=1 ORDER BY id DESC";
        $row = $this->emojidb->query($query);
        $albumdata = $row->result();
        if (!empty($albumdata)) {
            for ($i = 0; $i < count($albumdata); $i++) {
                $albumdata[$i]->attachment_type = $this->album_attachment_type($albumdata[$i]->id);
                $albumdata[$i]->attachment = $this->album_attachment($albumdata[$i]->id);
                $albumdata[$i]->comments = $this->countAlbumComment($albumdata[$i]->id);
                $albumdata[$i]->like = $this->countAlbumLike($albumdata[$i]->id);
                $isUserLike = $this->userAlbumLike($albumdata[$i]->id, '', 'teacher', $teacher_id);
                $albumdata[$i]->created_at = $albumdata[$i]->created_at;
                if ($isUserLike > 0) {
                    $albumdata[$i]->is_like = 1;
                } else {
                    $albumdata[$i]->is_like = 0;
                }
            }
            return $albumdata;
        } else {
            return array();
        }
    }

    public function album_attachment($album_id = '') {
        $this->db->select('attachment,attachment_type');
        $this->db->from('album_attachment');
        $this->db->where('albumId', $album_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('attachment');
        } else {
            return '';
        }
    }
    public function album_attachment_type($album_id = '') {
        $this->db->select('attachment_type');
        $this->db->from('album_attachment');
        $this->db->where('albumId', $album_id);
        $this->db->where('status', 1);
        $this->db->order_by('id', 'ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row('attachment_type');
        } else {
            return '';
        }
}

    public function countAlbumComment($album_id = '') {
        $this->db->select('*');
        $this->db->from('album_comment');
        $this->db->where('album_id', $album_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAlbumLike($album_id = '') {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $album_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function userAlbumLike($albumId = '', $attachId = '', $userType = '', $userId = '') {
        if ($userType == 'parent') {
            $userId = "P-" . $userId;
        } elseif ($userType == 'teacher') {
            $userId = "T-" . $userId;
        }
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $albumId);
        if($attachId != '')
        {
            $this->db->where('attachment_id', $attachId);
        }
        $this->db->where('user_id', $userId);
        $isLike = $this->db->get();
        
        return $isLike->num_rows();
    }

    function getAttachmentByAlbumId($albumId = '', $userType = '', $userId = '') {
        $query = "select id,title,description,teacher_id from album where id='" . $albumId . "'";
        $row = $this->db->query($query);
        $albumDetaildata = $row->result();
        if (!empty($albumDetaildata)) {
            $query1 = "select * from album_attachment where albumId='" . $albumDetaildata[0]->id . "'";
            $row1 = $this->db->query($query1);
            $albumDetaildata1 = $row1->result();
            $albumDetaildata[0]->albumAttachmentData = $albumDetaildata1;
            if (!empty($albumDetaildata)) {
                for ($i = 0; $i < count($albumDetaildata); $i++) {
                    for ($j = 0; $j < count($albumDetaildata[$i]->albumAttachmentData); $j++) {
                        $albumDetaildata[$i]->albumAttachmentData[$j]->comments = $this->countAlbumAttachmentComment($albumDetaildata[$i]->albumAttachmentData[$j]->id);
                        $albumDetaildata[$i]->albumAttachmentData[$j]->like = $this->countAlbumAttachmentLike($albumDetaildata[$i]->albumAttachmentData[$j]->id);
                        $isUserLike = $this->userAlbumLike($albumId, $albumDetaildata[$i]->albumAttachmentData[$j]->id, $userType, $userId);
                        if ($isUserLike > 0) {
                            $albumDetaildata[$i]->albumAttachmentData[$j]->is_like = 1;
                        } else {
                            $albumDetaildata[$i]->albumAttachmentData[$j]->is_like = 0;
                        }
                    }
                }
                return $albumDetaildata;
            } else {
                return array();
            }
        } else {
            return array();
        }
    }

    public function countAlbumAttachmentComment($attachment_id = '') {
        $this->db->select('*');
        $this->db->from('album_comment');
        $this->db->where('attachment_id', $attachment_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function countAlbumAttachmentLike($attachment_id = '') {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('attachment_id', $attachment_id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function updateAlbumData($albumData = array(), $album_id = '') {
        
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->where('id', $album_id);
        $this->emojidb->update('album', $albumData);
        return true;
    }

    public function deleteAttachmentById($attachment_id = '') {
        $this->db->where('id', $attachment_id);
        $this->db->delete('album_attachment');
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteEventById($event_id = '') {
        $this->db->where('id', $event_id);
        $this->db->delete('events');
        if ($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function getThoughtOfTheDay($school_id = '', $parent_id = '') {
        $this->db->select('td.description,td.author_name');
        $this->db->from('thought_of_day as td');
        //$this->db->join('school as s', 's.id=td.school_id','left');
        $this->db->where('td.status', '1');
        $this->db->where('td.school_id', $this->token->school_id);
        $query = $this->db->get();
        $data=$query->result_array();
        return $data?$data[0]:array();
    }
    public function getSchool($school_id = '') {
        $this->db->select('s.school_name,s.pic as school_pic');
        $this->db->from('school as s');
        $this->db->where('id', $this->token->school_id);
        $query = $this->db->get();
        $data=$query->result_array();
        return $data[0];
    }

    public function updateEvent($eventData = array(), $event_id = '') {
        $this->db->where('id', $event_id);
        $this->db->update('events', $eventData);
        return true;
    }

    public function insertAlbumComment($commentData = array()) {
        
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->insert('album_comment', $commentData);
        return true;
    }

    public function insertAlbumLike($commentData = array()) {
        $this->db->insert('album_like', $commentData);
        return true;
    }

    public function insertTeacherContact($commentData = array()) {
        $this->db->insert('all_contact_form', $commentData);
        return true;
    }

    public function getAttachmentDetail($albumId = '', $attachId = '', $schoolId = '', $userid = '', $userType = '') {

        if ($userType == 'parent') {
            $userid = "P-" . $userid;
        } elseif ($userType == 'teacher') {
            $userid = "T-" . $userid;
        }

        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('album_id', $albumId);
        $this->db->where('attachment_id', $attachId);
        $this->db->where('user_id', $userid);
        $this->db->where('schoolId', $schoolId);
        $this->db->where('user_type', $userType);
        $isLike = $this->db->get();
        $isUserLike = $isLike->num_rows();

        $this->db->select('t1.*,t2.title,t2.description');
        $this->db->from('album_attachment t1');
        $this->db->join('album t2', 't1.albumId=t2.id', 'LEFT');
        $this->db->where('t1.id', $attachId);
        $attachDetail = $this->db->get();
        $attachDetails = $attachDetail->row();
        if ($attachDetails) {
            $attachDetails->comments = $this->countAlbumAttachmentComment($attachId);
            $attachDetails->likes = $this->countAlbumAttachmentLike($attachId);
            if ($isUserLike > 0) {
                $attachDetails->is_like = 1;
            } else {
                $attachDetails->is_like = 0;
            }
        }
        return $attachDetails;
    }

    public function getAttachmentComments($albumId = '', $attachId = '') {
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $this->emojidb->select('al.*,au.fname,au.lname,au.photo');
        $this->emojidb->from('album_comment al');
        $this->emojidb->join('alluser au', 'al.user_id=au.id', 'LEFT');
        $this->emojidb->where('album_id', $albumId);
        $this->emojidb->where('attachment_id', $attachId);
        $comment = $this->emojidb->get();
        $comment_row = $comment->result_array();
        return $comment_row;
    }

    public function isAlbumUserLike($likeData = array()) {
        $this->db->select('*');
        $this->db->from('album_like');
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('album_id', $likeData['album_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function deleteAlbumUserLike($likeData = array()) {
        $this->db->where('album_id', $likeData['album_id']);
        $this->db->where('attachment_id', $likeData['attachment_id']);
        $this->db->where('user_id', $likeData['user_id']);
        $this->db->where('user_type', $likeData['user_type']);
        $this->db->delete('album_like');
        return true;
    }
    
    public function getSchoolMeal($school_type,$date){
        $this->db->select("id,for_date,breakfast,snacks,meal");
        $this->db->where('school_type',$school_type);
        $this->db->where('school_id',$this->token->school_id);
        $this->db->where('for_date',$date);
        $query = $this->db->get('meal_planner_detail');
        
        if($query->num_rows() > 0)
        {
            $data =  $query->row();
            $data->breakfast = array($data->breakfast,"Other");
            $data->snacks = array($data->snacks,"Other");
            $data->meal = array($data->meal,"Other");
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function getMySchoolMeal($student_id){

        $currentDate = date('Y-m-d');
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $where = array('for_date' => $currentDate);
        $this->emojidb->select("*");
        $this->emojidb->where('student_id',$student_id);
        $this->emojidb->where($where);
        $query = $this->emojidb->get('school_meal');
        // lq();
        if($query->num_rows() > 0)
        {
            $res =  $query->row();                        
            return $res;
        }else{
            return array();
        }
    
        // $this->db->select("name");
        // $this->db->where('school_id',$schoolId);
        // $query = $this->db->get('home_meal');
        // // lq();
        // if($query->num_rows() > 0)
        // {
        //     $res =  $query->result();
        //     $data = array();
        //     foreach ($res as $meal)
        //     {
        //         array_push($data,$meal->name);
        //     }
            
        //     return $data;
        // }
        // else
        // {
        //     return array();
        // }
    }
    public function getHomeMeal($student_id){

        $currentDate = date('Y-m-d');
        $this->emojidb = $this->load->database('emojidb', TRUE);
        $where = array('for_date' => $currentDate);
        $this->emojidb->select("*");
        $this->emojidb->where('student_id',$student_id);
        $this->emojidb->where($where);
        $query = $this->emojidb->get('home_meal_report');
        // lq();
        if($query->num_rows() > 0)
        {
            $res =  $query->row();                        
            return $res;
        }else{
            return array();
        }
    
        // $this->db->select("name");
        // $this->db->where('school_id',$schoolId);
        // $query = $this->db->get('home_meal');
        // // lq();
        // if($query->num_rows() > 0)
        // {
        //     $res =  $query->result();
        //     $data = array();
        //     foreach ($res as $meal)
        //     {
        //         array_push($data,$meal->name);
        //     }
            
        //     return $data;
        // }
        // else
        // {
        //     return array();
        // }
    }
    public function saveSchoolMeal($data){
        $this->db->where("student_id",$data['student_id']);
        $this->db->where("for_date",$data['for_date']);
        $query = $this->db->get("school_meal");
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            $formData = array(
                "school_id"=>$data['schoolId'],
                "class_id"=>$data['classId'],
                "for_date"=>$data['for_date'],
                "student_id"=>$data['student_id'],
                "breakfast"=>$data['breakfast'],
                "snacks"=>$data['snacks'],
                "meal"=>$data['meal'],
                "breakfast_other"=>$data['breakfast_other'],
                "snack_other"=>$data['snacks_other'],
                "meal_other"=>$data['meal_other'],
            );
            $this->emojidb = $this->load->database('emojidb', TRUE);
            $this->emojidb->insert("school_meal",$formData);
            if($this->emojidb->affected_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }                      
    }
    
    
    public function saveSchoolMealForAll($data){
        if(empty($data)) {
          return false;  
        }
        $chiildList = array(); 
        $this->db->select("id");
        $this->db->where('childclass',$data['classId']);
        $this->db->where('schoolId',$data['schoolId']);
        $this->db->where('status',1);
        $query = $this->db->get('child');
        
        if($query->num_rows() > 0){
           $chiildList = json_decode(json_encode($query->result()), true);
        }
        
        if(count($chiildList)>0)
        {
            $addcount=0;
            for($i=0;$i<count($chiildList);$i++) 
            {
              $this->db->where("student_id",$chiildList[$i]['id']);
              $this->db->where("school_id",$data['schoolId']);
              $this->db->where("for_date",$data['for_date']);
              $query = $this->db->get("school_meal");
              if($query->num_rows() == 0) 
              { 
                $formData = array(
                "school_id"=>$data['schoolId'],
                "class_id"=>$data['classId'],
                "for_date"=>$data['for_date'],
                "student_id"=>$chiildList[$i]['id'],
                "breakfast"=>$data['breakfast'],
                "snacks"=>$data['snacks'],
                "meal"=>$data['meal'],
                "breakfast_other"=>$data['breakfast_other'],
                "snack_other"=>$data['snacks_other'],
                "meal_other"=>$data['meal_other'],
                "is_all"=>'1',    
             );

                $this->emojidb = $this->load->database('emojidb', TRUE);
                $this->emojidb->insert("school_meal",$formData);
                $addcount++;
               }
            }
            if($addcount>0) 
            return true;
            else
            return false;    
        }
        else {
         return false;   
        }                      
    }
    
    public function saveHomeMeal($data){
        //print_r($data);die;
        $this->db->where("student_id",$data['student_id']);
        $this->db->where("for_date",$data['for_date']);
        $query = $this->db->get("home_meal_report");
        if($query->num_rows() > 0)
        {
            return false;
        }
        else
        {
            $formData = array(
                "school_id"=>$data['schoolId'],
                "class_id"=>$data['classId'],
                "for_date"=>$data['for_date'],
                "student_id"=>$data['student_id'],
                "breakfast"=>$data['breakfast'],
                "snacks"=>$data['snacks'],
                "meal"=>$data['meal'],
                "other"=>$data['other']
            );

            $this->emojidb = $this->load->database('emojidb', TRUE);
            $this->emojidb->insert("home_meal_report",$formData);

            if($this->emojidb->affected_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        
    }
    public function getAssignedClass(){    
        $this->db->select('t.assignclassteacher');
        $this->db->from('teacher t');
        $this->db->where('t.id', $this->token->user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $classList = $query->row()->assignclassteacher;
            //echo $classList;die;
            $this->db->select("id, class, section");
            $this->db->from("class");
            $this->db->where("FIND_IN_SET(id,'$classList') AND 1");
            $query = $this->db->get();
            if($query->num_rows() > 0)
            {
                $data =  $query->result();            
                return $data;
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
    public function learningDevelopmentCategory($class_id)
    {
        $this->db->select("id,name");
        $this->db->where('class_id',$class_id);
        $this->db->where('school_id',$this->token->school_id);
        $query = $this->db->get('learning_development_category');
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    public function learningDevelopmentQuestion($category_id)
    {
        $this->db->select("id,question,options,option_type");
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('learning_development_question');
        
        if($query->num_rows() > 0)
        {
            $data = $query->result();
            
            for($i=0; $i < count($data); $i++)
            {
                $data[$i]->options = json_decode($data[$i]->options);
                array_push($data[$i]->options,"Other");
            }
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function learningDevelopmentInfo($category_id)
    {
        $this->db->select("title,detail");
        $this->db->where('category_id',$category_id);
        $query = $this->db->get('learning_development_info');
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function saveLearningDevelopment($data)
    {
        $this->db->select("*");
        $this->db->from("learning_development_report ldr");        
        $this->db->where("question_id",$data['question_id']);
        $this->db->where("student_id",$data['student_id']);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            $where=array(
                "question_id"=>$data['question_id'],
                "student_id"=>$data['student_id']
            );
            $formData = array(
                "answer"=>$data['answer'],
                "other_answer"=>$data['other_answer'],
                "created_date"=>date("Y-m-d")
            );
            $this->db->where($where);
            $this->db->update('learning_development_report',$formData);
            return true;
        }else{
            $formData = array(
                "question_id"=>$data['question_id'],
                "student_id"=>$data['student_id'],
                "teacher_id"=>$this->token->user_id,
                "answer"=>$data['answer'],
                "other_answer"=>$data['other_answer'],
                "created_date"=>date("Y-m-d")
            );

            $this->db->insert("learning_development_report",$formData);
            if($this->db->affected_rows() > 0)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    
    public function learningDevelopmentAnswer($data)
    {
        $this->db->select("ldr.answer,ldr.other_answer");
        $this->db->from("learning_development_report ldr");        
        $this->db->where("question_id",$data['question_id']);
        $this->db->where("student_id",$data['student_id']);
        $this->db->order_by('id',"DESC");
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
    public function learningDevelopmentList()
    {
        $this->db->select("ldr.*,ldq.question, ldq.options,ldq.option_type, ldq.category_id,ldc.name as category_name, c.childfname, c.childmname, c.childlname");
        $this->db->from("learning_development_report ldr");
        $this->db->join("learning_development_question ldq","ldr.question_id = ldq.id","LEFT");
        $this->db->join("child c","ldr.student_id = c.id","LEFT");
        $this->db->join("learning_development_category ldc","ldq.category_id = ldc.id","LEFT");
        $this->db->where("teacher_id",$this->token->user_id);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }
    }
    
    public function checkMeal($schoolId,$chiildId)
    {
    $this->db->where("student_id",$chiildId);
    $this->db->where("school_id",$schoolId);
    $this->db->where("for_date",date('Y-m-d'));
    $query = $this->db->get("school_meal");
    //echo $this->db->last_query(); exit;
    if($query->num_rows() > 0){
        $data  = $query->row();
        return $data->is_all;
    }
    else {
    return '0';      
    }
    }

}
