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
        $where = array('e.school_id'=>$school_id,'e.status'=>'1');
        $this->db->select('e.*,c.id as class_id,c.class,c.section,s.subject');
        $this->db->from('exam e');
        $this->db->join('class c','c.id = e.class_id','left');
        $this->db->join('subjects s','s.id = e.subject_id','left');
        $this->db->where($where);
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
                $query = $this->db->get();    
        }else{
                $this->db->select('eq.*,e.name,e.total_marks,e.exam_date,e.exam_time');
                $this->db->from('exam_question eq');
                $this->db->join('exam_questions_obtain_marks qm','qm.question_id = eq.id','left');
                $this->db->join('exam e','e.id = eq.exam_id','left');
                $this->db->where('eq.exam_id',$id);
                $query = $this->db->get();  
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
              // pr($quesValues);
                $optionData = array('option_value'=> json_encode($quesValues) );
              // prd($optionData);
                $this->db->where('id',$insertId);
                $this->db->update('exam_question',$optionData);
                return ($this->db->affected_rows()) ? 1: 0;
        }
        else
        {
            return false;
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
        }
        else
        {
            return array();
        }
    }
    public function updateExam($examData)
    {
        $examData['subject_id'] = $examData['subject_id']['subject_id'];
        
        // prd($examData);
        $this->db->where('id', $examData['id']);
        unset($examData['id']);
        $updated = $this->db->update('exam',$examData);
        return ($this->db->affected_rows()) ? 1: 0;
        // if($this->db->affected_rows() > 0)
        // {
        //     return $this->db->affected_rows();
        // }else{
        //     return 0;
        // }
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
        $this->db->where($where);
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
            // lq();
          // prd($data);
            foreach ($data->questionList as $key => $value) {
                $answerList = $this->answerListData($data->subject_id,$data->exam_id,$data->user_id);
            }
            $data->questionList = array_map(function($v) use($answerList) {
                foreach($answerList as $key=>$value){
                  if($value->question_id == $v->id){
                    $v->option_value = json_decode($v->option_value);
                    $v->answer_value  = json_decode($value->answer_value);
                  }
                }
                return $v;
            },$data->questionList);
            return $data;
        }
        else
        {
            return array();
        }
    }
    public function calculateMarks($postData)
    {
        $ansData = $this->db->where('id',$postData['answer_id'])->get('exam_answer')->row();
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
                $correctAnswer = $ques['answer']; 
                foreach ($ques['answer_value'] as $answer) {
                  $isUserAnswer = $answer['isUserAnswer'];
                  $studentAns = $answer['option']; 
                    if( ($correctAnswer == $studentAns) && ( $answer['isUserAnswer'] == 'true') )
                    {
                            $obtainedTotalMarks += $ques['question_marks'];
                            // multiple question when answer is correct. Marks allocate
                            $questionMarksObtained[$i]['mark_obtain']   = $ques['question_marks'];
                    }else{
                            $obtainedTotalMarks += 0;
                    }
                }
            }else{
                $obtainedTotalMarks += $ques['marks_obtain'];
            }
             $i++;
        }

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
                                    'grade'             => $grade,
                                    'created_by'        => $ansData->school_id
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
        // prd($user_id);
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
}
