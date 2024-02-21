<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exam_model extends CI_Model {
    
    public function getAllSubjectForClass($dataArray)
    {
        $where = array('schoolId'=>$dataArray['school_id'],'class'=>$dataArray['class_id'],'status'=>1);
        $this->db->select('id as subject_id,subject')->where($where);
        $query = $this->db->get('subjects');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }   
    }
    public function unlockExamRequest($dataArray)
    {
        if( count($dataArray['studentID']) > 0){
            $unlockArr = array();
            $i=0;
            foreach ($dataArray['studentID'] as $value) {
                $unlockArr[$i]['exam_id']       = $dataArray['exam_id'];
                $unlockArr[$i]['school_id']     = $dataArray['school_id'];
                $unlockArr[$i]['class_id']      = $dataArray['class_id'];
                $unlockArr[$i]['subject_id']    = $dataArray['subject_id'];
                $unlockArr[$i]['user_id']       = $value['studentID'];
                $unlockArr[$i]['requested_on']  = date('Y-m-d H:i:s');
            $i++;
            }
            // prd($unlockArr);
           $this->db->insert_batch('exam_unlock',$unlockArr);
           if($this->db->affected_rows() > 0)
                return 1;
            else
                return array();
        }else{
            return false;
        }
    } 
    public function deleteGrade($postData)
    {
        $this->db->where('id',$postData['id'])->delete('exam_grade_system');
        return $this->db->affected_rows() ? 1 : 0 ;
    }
    public function getGrades($postData)
    {
        $where = array('school_id'=>$postData['school_id'],'grade_name!='=>'');
        $this->db->select('*')->where($where);
        $query = $this->db->get('exam_grade_system');
        // lq();
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }      
    }
    public function saveGrades($postData)
    {
           $GradeData = array();
            $i=0;
            foreach ($postData['info'] as  $value) {
                    $GradeData[$i]['school_id']      = $postData['id'];
                    $GradeData[$i]['grade_name']     = $value['grade_name'];
                    $GradeData[$i]['min_percent']    = $value['min_percent'];
                    $GradeData[$i]['max_percent']    = $value['max_percent'];
                    $GradeData[$i]['created_at']    = date('Y-m-d H:i:s');
                $i++;
            }
        // prd($GradeData);
           $this->db->insert_batch('exam_grade_system',$GradeData);
           if($this->db->affected_rows() > 0)
                return 1;
            else
                return array();
    } 
    public function getStudentBySchool($school_id)
    {
        $where = array('schoolId'=>$school_id,'status'=>1);
        $this->db->select('id as studentID,CONCAT(childfname," ",childlname) as stud_name')->where($where);
        $query = $this->db->get('child');
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }   
    } 
    public function examList($school_id)
    {
        $where = array('e.school_id'=>$school_id,'e.status'=>'1','assessment_mode'=>'online');
        $this->db->select('e.*,c.id as class_id,c.class,c.section,s.subject');
        $this->db->from('exam e');
        $this->db->join('class c','c.id = e.class_id','left');
        $this->db->join('subjects s','s.id = e.subject_id','left');
        $this->db->join('sessions si','e.session_id = si.id','left');
        $this->db->where($where);
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->order_by('e.id','desc');
        $query = $this->db->get();
         //lq(); 
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }   
    }
    public function offlineAssessmentList($school_id)
    {
        $where = array('e.school_id'=>$school_id,'e.status'=>'1','assessment_mode'=>'offline');
        $this->db->select('e.*,c.id as class_id,c.class,c.section,s.subject');
        $this->db->from('exam e');
        $this->db->join('class c','c.id = e.class_id','left');
        $this->db->join('subjects s','s.id = e.subject_id','left');
        $this->db->join('sessions si','e.session_id = si.id','left');
        $this->db->where($where);
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->order_by('e.id','desc');
        $query = $this->db->get();
        // lq(); 
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return array();
        }   
    }
    public function details($id)
    {

        $this->db->select('e.*,c.class,c.section,s.subject,sc.school_name');
        $this->db->from('exam e');
        $this->db->join('class c','c.id = e.class_id','left');
        $this->db->join('subjects s','s.id = e.subject_id','left');
        $this->db->join('school sc','sc.id = e.school_id','left');
        $this->db->where('e.id',$id);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return array();
        }
    }
    public function offlineExamDetails($id)
    {
        // if(!empty($student_id))
        // {
        //     $this->db->where('em.student_id',$student_id);
        // }
        $this->db->select('e.*,c.class,c.section,s.subject,sc.school_name,em.user_id as studentID,em.marks_obtained');
        $this->db->from('exam e');
        $this->db->join('class c','c.id = e.class_id','left');
        $this->db->join('subjects s','s.id = e.subject_id','left');
        $this->db->join('school sc','sc.id = e.school_id','left');
        $this->db->join('exam_marks_obtain em','e.id = em.exam_id','left');
        $this->db->where('e.id',$id);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
        {
            return $query->row();
        }
        else
        {
            return array();
        }
    }
    public function offlineExamMarkObtain($postData)
    {
        // prd($postData);
        $total_marks = $postData['examData']['total_marks'];
        $marks_obtain = $postData['marks_obtain'];
        $school_id = $postData['examData']['school_id'];
        $percent = round( ($marks_obtain/$total_marks)*100);
        $grade =  check_grades($school_id,$percent);
        
        // Get session and term  data
        $sessionNterms = get_session_n_terms($school_id,$postData['examData']['exam_date']);
        // prd($sessionNterms);
        $offlineDataArr = array(
            'school_id'       => $school_id,
            'class_id'        => $postData['examData']['class_id'],
            'subject_id'      => $postData['examData']['subject_id'],
            'exam_id'         => $postData['examData']['id'],
            'answer_id'       => 0,
            'user_id'         => $postData['child_id'],
            'marks_obtained'  => $marks_obtain,
            'total_marks'     => $total_marks,
            'percentage'      => $percent,
            'grade'           => $grade,
            'term_name'       => $sessionNterms->termname,
            'term_id'         => $sessionNterms->term_id,
            'session_id'      => $sessionNterms->session_id,
            'created_by'      => $school_id,
            'created_at'      => date('Y-m-d H:i:s'),
        );
        $marksExist = $this->isMarksAlreadyObtained($offlineDataArr);

        if($marksExist > 0)
        {
            $percent = round( ($offlineDataArr['marks_obtained']/$offlineDataArr['total_marks'])*100);
            $grade =  check_grades($school_id,$percent);

            $updateMarks = array('marks_obtained' => $offlineDataArr['marks_obtained'],'percentage' => $percent, 'grade'=> $grade);
            $where = array('exam_id'=> $offlineDataArr['exam_id'], 'user_id' => $offlineDataArr['user_id'], 'term_id'=> $offlineDataArr['term_id']);
            $this->db->where($where);
            $this->db->update("exam_marks_obtain",$updateMarks);

            return ( $this->db->affected_rows() ) ? $this->getStudentsMarksObtain($offlineDataArr['user_id'],$offlineDataArr['exam_id']) : 0;
        
        }else{

            $this->db->insert("exam_marks_obtain",$offlineDataArr);

            return ( $this->db->affected_rows() ) ? $this->getStudentsMarksObtain($offlineDataArr['user_id'],$offlineDataArr['exam_id']) : 0;
        }
    }
    protected function isMarksAlreadyObtained($offlineDataArr)
    {
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $session_id= get_current_session($school_id)->id;
        $where = array('session_id'=> $session_id,'exam_id'=> $offlineDataArr['exam_id'], 'user_id' => $offlineDataArr['user_id'], 'term_id'=> $offlineDataArr['term_id']);
        $this->db->select('*');
        $this->db->from('exam_marks_obtain');
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows() > 0 )
            return $query->num_rows();
        else
            return false;
    }
    private function getStudentsMarksObtain($child_id,$exam_id)
    {
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $session_id= get_current_session($school_id)->id;
        $this->db->select('user_id,total_marks,marks_obtained');
        $this->db->from('exam_marks_obtain');
        // $this->db->join('class c','c.id = e.class_id','left');
        // $this->db->join('subjects s','s.id = e.subject_id','left');
        // $this->db->join('school sc','sc.id = e.school_id','left');
        // $this->db->join('exam_marks_obtain em','e.id = em.exam_id','left');
        $this->db->where(['session_id'=>$session_id,'exam_id'=>$exam_id,'user_id'=>$child_id]);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
        {
            return (array)$query->row();
        }
        else
        {
            return false;
        }
    }
    public function getClassStudents($class_id,$subject_id,$studentID)
    {
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $session_id= get_current_session($school_id)->id;
        $this->db->order_by("c.id",'DESC');
        $this->db->select('c.id as child_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as child,c.childRegisterId,em.marks_obtained');
        $this->db->from('child as c');
        $this->db->join('exam_marks_obtain em','c.id = em.user_id','left');
        $this->db->where(['childclass'=>$class_id,'status'=>1]);
        $this->db->where(['session_id'=>$session_id]);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            return $query->result_array();
        }else{
            return array();
        }
    }
    // public function getStudentsMarksObtain($class_id,$subject_id,$studentID)
    // {
    //     $this->db->order_by("c.id",'DESC');
    //     $this->db->select('c.id as child_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as child,c.childRegisterId,em.marks_obtained');
    //     $this->db->from('child as c');
    //     $this->db->join('exam_marks_obtain em','c.id = em.user_id','left');
    //     $this->db->where(['childclass'=>$class_id,'status'=>1]);
    //     $query = $this->db->get();
    //     if($query->num_rows() > 0)
    //     {
    //         return $query->result_array();
    //     }else{
    //         return array();
    //     }
    // }

    public function addexam($data)
    {
        // prd($data);
        $this->db->insert("exam",$data);
        //return ($this->db->affected_rows()) ? 1: 0;
        if($this->db->affected_rows() == 1)
        {
        return $this->db->insert_id();
        //     return 1;
        }
        else
        {
         return false;
        }
    }
    public function questionList($id)
    {
        $query =  $this->db->select('id,name,exam_date,exam_time,exam_date_time')->where('id',$id)->get('exam');
        if($query->num_rows() > 0)
        {
            $data = $query->row();
            $data->questionList = $this->allQuestionListData($id);
            return $data;
        }
        else
        {
            return array();
        }
    }
     public function allQuestionListData($id)
    {
        $this->db->select('eq.*,e.name,e.total_marks,e.exam_date,e.exam_time');
        $this->db->from('exam_question eq');
        $this->db->join('exam e','e.id = eq.exam_id','left');
        $this->db->where(['eq.exam_id'=>$id]);
        $query = $this->db->get();
        return $query->result();
    }
    public function deleteQuestion($id)
    {
        $this->db->where('id',$id)->delete('exam_question');
        return $this->db->affected_rows() ? 1 : 0 ;
    }
    public function questionDetails($id)
    {
        $this->db->select('eq.*,e.*');
        $this->db->from('exam_question eq');
        $this->db->join('exam e','e.id = eq.exam_id','left');
        $this->db->where('eq.id',$id);
        $query = $this->db->get();
        return $query->row();
    }
    public function questionListData($id,$user_id,$exam_type)
    {
        $num_rows = $this->db->where(['user_id'=>$user_id,'exam_id'=>$id])->get('exam_questions_obtain_marks')->num_rows();
        // prd($num_rows);
        if($num_rows>0){
                if(!empty($exam_type != 'multiple' ))
                {
                    $this->db->where('qm.user_id',$user_id);
                }
                $this->db->select('eq.*,e.name,e.total_marks,e.exam_date,e.exam_time,qm.mark_obtain as question_mark_obtain');
                $this->db->from('exam_question eq');
                $this->db->join('exam_questions_obtain_marks qm','qm.question_id = eq.id','left');
                $this->db->join('exam e','e.id = eq.exam_id','left');
                $this->db->where('eq.exam_id',$id);
                $query = $this->db->group_by('eq.id')->get();    
        }else{
                $this->db->select('eq.*,e.name,e.total_marks,e.exam_date,e.exam_time');
                $this->db->from('exam_question eq');
                $this->db->join('exam_questions_obtain_marks qm','qm.question_id = eq.id','left');
                $this->db->join('exam e','e.id = eq.exam_id','left');
                $this->db->where('eq.exam_id',$id);
                $query = $this->db->group_by('eq.id')->get();  
        }
        return $query->result();
    }
    public function addQuestion($questionData,$optionData)
    {
        $this->db->insert("exam_question",$questionData);
        if($this->db->affected_rows() == 1)
        {
            $insertId =  $this->db->insert_id();
                $quesValues = array();
                $i=0;
                foreach ($optionData as $key => $value) {
                    foreach ($value as $key => $option) {
                        $j = $i+1;
                        $quesValues[$i]['id']   = $insertId.'_'. $j;
                        $quesValues[$i]['option'] = $option;
                        $i++;
                    }
                }
                $answerData  = array('quesValues'=>$quesValues,'question_id'=>$insertId,'questStatus'=>'answer_added');
              // pr($quesValues);
                $optionData = array('option_value'=> json_encode($quesValues) );
              // prd($optionData);
                $this->db->where('id',$insertId);
                $this->db->update('exam_question',$optionData);
                return ($this->db->affected_rows()) ? $answerData : 0;
        }
        else
        {
            return false;
        }
    }
    public function addMultipleAnswers($postData)
    {
        if($postData['questStatus'] == 'answer_added')
        {
           $answers =  $postData['optionAnswers']['values'];
           $ques_id =  $postData['ques_id'];
                $anwersChoices = array();
                 foreach ($answers as  $value) {
                        $anwersChoices[] = $value['option'];
                    }
               $anwersChoices = implode(",", $anwersChoices);
               $updateArr = array(
                        'answer'=> $anwersChoices
               );
                $this->db->where('id',$ques_id);
                $this->db->update('exam_question',$updateArr);         
                return ($this->db->affected_rows()) ? 1: 0;
        }else{
            return 0;
        }
    }
    public function updateQuestion($postData)
    {
        if(!empty($postData['options']))
        {
            $quesValues = array();
                $i=0;
                foreach ($postData['options'] as $key => $value) {
                    foreach ($value as $key => $option) {
                        $j = $i+1;
                        $quesValues[$i]['id']   = $postData['ques_id'].'_'. $j;
                        $quesValues[$i]['option'] = $option;
                        $i++;
                    }
                }
            $optionData =  json_encode($quesValues);
            $updateArr = array(
                        'question' => $postData['question'],
                        'question_marks' => $postData['question_marks'],
                        'question_type' => $postData['question_type'],
                        'option_value' => $optionData,
                        'updated_at' => date('Y-m-d H:i:s')
            );     
        }else{
            $updateArr = array(
                        'question' => $postData['question'],
                        'question_marks' => $postData['question_marks'],
                        'question_type' => $postData['question_type'],
                        'updated_at' => date('Y-m-d H:i:s')
            );
        }
                
               // prd($updateArr);
                $this->db->where('id',$postData['ques_id']);
                $this->db->update('exam_question',$updateArr);
                return ($this->db->affected_rows()) ? 1: 0;
    }
    public function deleteExam($id)
    {
            $status = array('status'=>'0');
            $this->db->where('id',$id);
            $this->db->update('exam',$status);
            return ($this->db->affected_rows()) ? 1: 0;
    }
    public function examAndQuestionMarksCount($id)
    {
        $this->db->select('e.total_marks,e.total_question,SUM(q.question_marks) as question_marks,count(q.exam_id) as question_qty,e.exam_type');
        $this->db->from('exam e');
        $this->db->join('exam_question q','q.exam_id = e.id','left');
        $this->db->where('e.id',$id);
        $query = $this->db->get();
        // lq();
        if($query->num_rows() > 0)
        {
           return $query->row();
            // $data->options = $this->optionList($id);
            // prd($data);
        }
        else
        {
            return array();
        }
    }
    public function optionList($id)
    {
        $this->db->select('e.total_marks,e.total_question,SUM(q.question_marks) as question_marks,count(q.exam_id) as question_qty,e.exam_type');
        $this->db->from('exam_question');
        $this->db->where('exam_id',$id);
        $query = $this->db->get();
        
    }
    public function updateExam($examData)
    {
        if( is_array($examData['subject_id']) )
        {
            $examData['subject_id'] = ($examData['subject_id']['subject_id'] ? $examData['subject_id']['subject_id'] : null);
        }else{
            $examData['subject_id'] = $examData['subject_id'] ? $examData['subject_id'] : null;
        }

        if(!empty($examData['offline_exam_type']) == 'offline')
        {
             $examData['marks_validity_extends'] =  date('Y-m-d', strtotime($examData['last_submission_date']. ' +'.$examData["marks_validity_days"].' days'))." ".date('H:i:s',strtotime($examData['exam_time'])); 
            // $examData['marks_validity_extends'] = $examData['subject_id'] ? $examData['subject_id'] : null;
        }
        // prd($examData);
        
        unset($examData['offline_exam_type']);
        unset($examData['old_submission_date']);
        $this->db->where('id', $examData['id']);
        unset($examData['id']);
        $updated = $this->db->update('exam',$examData);
        return ($this->db->affected_rows()) ? 1: 0;
    }
    public function getExamSubmitted($school_id)
    {
        $where = array('ea.school_id'=>$school_id,'e.status'=>'1','c.status'=>1);
        $this->db->select('ea.id,e.name as exam_name,e.total_question,e.exam_duration,e.exam_category,CONCAT(c.childfname," ",c.childlname) as stud_name,CONCAT(ca.class," ",ca.section) as class,sb.subject,mb.grade,mb.marks_obtained');
        $this->db->from('exam_answer ea');
        $this->db->join('exam_marks_obtain mb','mb.answer_id = ea.id','left');
        $this->db->join('exam e','e.id = ea.exam_id','left');
        $this->db->join('child c','c.id = ea.user_id','left');
        $this->db->join('class ca','ca.id = ea.class_id','left');
        $this->db->join('subjects sb','sb.id = ea.subject_id','left');
        $this->db->join('sessions si','e.session_id = si.id','left');
        $this->db->where($where);
        $this->db->where(array('si.current_sesion'=>1));
        $this->db->order_by('e.id','desc');
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
    public function myExamDetails($id)
    {
        $where = array('ea.id'=>$id,'e.status'=>'1','c.status'=>1);
        $this->db->select('ea.id,e.name as exam_name,e.id as exam_id,e.total_question,e.exam_duration,e.total_marks,e.exam_type,e.exam_category,e.exam_mode,c.id as user_id,CONCAT(c.childfname," ",c.childlname) as stud_name,CONCAT(ca.class," ",ca.section) as class,sb.id as subject_id,sb.subject,mb.marks_obtained,mb.grade,mb.percentage');
        $this->db->from('exam_answer ea');
        $this->db->join('exam e','e.id = ea.exam_id','left');
        $this->db->join('exam_marks_obtain mb','mb.answer_id = ea.id','left');
        $this->db->join('child c','c.id = ea.user_id','left');
        $this->db->join('class ca','ca.id = ea.class_id','left');
        $this->db->join('subjects sb','sb.id = ea.subject_id','left');
        $this->db->where($where);
        $query = $this->db->get();
        if($query->num_rows() > 0)
        {
            $data      =  $query->row();
            $exam_id   = $data->exam_id;
            $user_id   = $data->user_id;
            $exam_type = $data->exam_type;
            $data->questionList = $this->questionListData($exam_id,$user_id,$exam_type);
          //   lq();
          // prd($data);
            foreach ($data->questionList as $key => $value) {
                $answerList = $this->answerListData($data->subject_id,$data->exam_id,$data->user_id);
            }
            $data->questionList = array_map(function($v) use($answerList) {
                $givenAnswer = array();
                foreach($answerList as $key=>$value){

                    if($value->question_id == $v->id){
                        $v->option_value = json_decode($v->option_value);
                        $v->answer_value  = json_decode($value->answer_value);
                        // foreach ($v->answer_value as $val) {
                        //     if($val->isUserAnswer == "true" ){
                        //         $v->answer_value = $val->option;
                        //         // $givenAnswer = implode(",",$givenAnswer);
                        //     }
                        // }
                    }
                }
                return $v;
            },$data->questionList);
            // prd($data->questionList);
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function calculateMarks($postData)
    {
        $ansData = $this->db->select('ea.*,e.exam_date')->from('exam_answer as ea')->join('exam as e','e.id=ea.exam_id','left')->where('ea.id',$postData['answer_id'])->get()->row();
       // Helper function to get current session or terms
        $sessionNterms = get_session_n_terms($ansData->school_id,$ansData->exam_date);
        // prd($sessionNterms);

        $obtainedTotalMarks = 0;
        $questionMarksObtained = array();
        $i=0;
        foreach ($postData['questionList'] as $ques) {
             // Question-wise marks obtained history data
                $questionMarksObtained[$i]['exam_id']       = $ques['exam_id'];
                $questionMarksObtained[$i]['question_id']   = $ques['id'];
                $questionMarksObtained[$i]['user_id']       = $ansData->user_id;
                $questionMarksObtained[$i]['question_mark'] = $ques['question_marks'];
                $questionMarksObtained[$i]['mark_obtain']   = $ques['marks_obtain'];
                $questionMarksObtained[$i]['created_at']    = date('Y-m-d H:i:s');

            if($ques['question_type'] != 'textual')
            {
                // $correctAnswer = explode(",", $ques['answer']); 
             $correctAnswer =  $ques['answer'];
             $checkCounter = 1; 
             foreach($ques['answer_value'] as $answer) {

                  $isUserAnswer = $answer['isUserAnswer'];
                  $studentAns = $answer['option']; 
                  $questionID = explode("_", $answer['id']); 
                  $questionID = $questionID[0]; 
                  $question_id = $ques['id']; 
                
                    $isAnswerCorrect =  (in_array($studentAns, explode(",", $correctAnswer)));
                    if( ($isAnswerCorrect) && ( $answer['isUserAnswer'] == 'true') )
                    {
                         if($checkCounter && ($questionID == $question_id)){
                             $obtainedTotalMarks += $ques['question_marks'];
                            // multiple question when answer is correct. Marks allocate
                            $questionMarksObtained[$i]['mark_obtain']   = $ques['question_marks'];
                         }else{
                            continue;
                         }
                        $checkCounter--;
               
                    }else{
                            $obtainedTotalMarks += 0;
                    }
                }

            }else{
                $obtainedTotalMarks += $ques['marks_obtain'];
            }
             $i++;
        }
                // prd($obtainedTotalMarks);

        $total_marks = $postData['total_marks'];
        $percent = round( ($obtainedTotalMarks/$total_marks)*100);
        $grade =  check_grades($ansData->school_id,$percent);
    
            $marksObtainedArr = array(
                                    'school_id'         => $ansData->school_id,
                                    'class_id'          => $ansData->class_id,
                                    'subject_id'        => $ansData->subject_id,
                                    'exam_id'           => $ansData->exam_id,
                                    'answer_id'         => $postData['answer_id'],
                                    'user_id'           => $ansData->user_id,
                                    'total_marks'       => $total_marks,
                                    'marks_obtained'    => $obtainedTotalMarks,
                                    'percentage'        => $percent,
                                    'term_name'         => $sessionNterms->termname,
                                    'term_id'           => $sessionNterms->term_id,
                                    'session_id'        => $sessionNterms->session_id,
                                    'grade'             => $grade,
                                    'created_by'        => $ansData->school_id,
                                    'created_at'        => date('Y-m-d H:i:s'),
                                    'updated_at'        => date('Y-m-d H:i:s')
                                );
        // prd($questionMarksObtained);
        $this->db->insert("exam_marks_obtain",$marksObtainedArr);
        if($this->db->affected_rows() == 1)
        {
            $this->db->insert_batch('exam_questions_obtain_marks',$questionMarksObtained);
            return ($this->db->affected_rows()) ? 1 : 0;
        }
        else
        {
            return false;
        }

    }
    public function answerListData($subject_id,$exam_id,$user_id)
    {
        $where = array('ea.user_id'=>$user_id,'ea.exam_id'=>$exam_id,'ea.subject_id'=>$subject_id);
        $this->db->select('qa.question_id,qa.answer_value');
        $this->db->from('exam_answer ea');
        $this->db->join('exam_user_question_answer qa','qa.answer_id = ea.id','left');
        $this->db->where($where);
        $query = $this->db->get();
       // lq();
        if($query->num_rows() > 0)
        {
           return $query->result();
        }else{
            return array();
        }
    }
    public function schoolwiseSession($schoolID)
    {
        $where = array('s.schoolId'=>$schoolID,'s.current_sesion'=>1,'s.status'=>1);
        $this->db->select('*');
        $this->db->from('sessions s');
        $this->db->where($where);
        $query = $this->db->get();
       // lq();
        if($query->num_rows() > 0)
        {
           return $query->row();
        }else{
            return array();
        }   
    }
    public function isExamExist($postData)
    {
        // $res = examDateCheckedTerm($postData['school_id'],$postData['exam_date']);
        // prd($res);
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $session_id= get_current_session($school_id)->id;
        $where = array('e.session_id'=>$session_id,'e.subject_id'=>$postData['subject_id'],'e.class_id'=>$postData['class_id'],'e.status'=>'1','e.term_id'=>$postData['term_id'],'e.exam_mode' => $postData['exam_mode']);
        $this->db->select('e.*');
        $this->db->from('exam as e');
        // $this->db->join('exam_marks_obtain as mo','e.id = mo.exam_id','left');
        $this->db->where($where);
        $query = $this->db->get();
       // lq();
        if($query->num_rows() > 0)
        {
           return $query->num_rows();
        }else{
            return false;
        }   
    }
}
