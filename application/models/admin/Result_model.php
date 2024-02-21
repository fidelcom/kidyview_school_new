<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Result_model extends CI_Model {
   
    public function getStudentExamDetails($student_id,$school_id,$session_id='')
    {
      if($session_id==''){
      $session_id= get_current_session($school_id)->id;
      }
    	$where = array('child_class.session_id'=>$session_id,'c.schoolId'=>$school_id,'c.id'=>$student_id,'c.status'=>1);
    	$this->db->select('c.id as studentID,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as stud_name,c.childphoto,c.schoolId,p.id as parent_id,CONCAT(p.fatherfname," ",p.fatherlname) as father_name,CONCAT(p.motherfname," ",p.motherlname) as mother_name,c.childclass as class_id,CONCAT(cs.class," ",cs.section) as class,t.id as teacher_id,CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as teacher_name,r.overall_total_marks,r.overall_marks_obtain,r.overall_grade,r.overall_percent');
      $this->db->from('child as c');
      $this->db->join('child_class','c.id=child_class.child_id','left');
      $this->db->join('result as r','c.id=r.student_id','left');
      $this->db->join('parent as p','c.parent_id=p.id','left');
    	$this->db->join('class as cs','c.childclass=cs.id','left');
    	$this->db->join('teacher as t',' cs.classteacher=t.id','left');
      $this->db->where($where);
    	$query = $this->db->get();
        $getStudentsActivityTermsResult =$this->getStudentsActivityTermsResult($student_id,$school_id,$session_id,'');
        $getStudentsActivityFinalResult =$this->getStudentsActivityTermsResult($student_id,$school_id,$session_id,'all_terms');
        $dataArray['termsList'] = orderByTermsList($school_id,$session_id);
        $dataArray['getStudentsActivityTermsResult'] = $getStudentsActivityTermsResult;
        $dataArray['getStudentsActivityFinalResult'] = $getStudentsActivityFinalResult;
      if($query->num_rows() > 0)
      {
              $studentResultDetails = $query->result_array();
              $studentTermsResult = $this->subjectwiseTermData($student_id,$school_id,$session_id);

                // prd($studentTermsResult);
                
                $studentResultDetails = array_map(function($v) use($studentTermsResult) {
                    foreach($studentTermsResult as $term){
                
                        if($term->student_id == $v['studentID']){
                          $v['termListData'][] = $term;
                        }
                    }
                    return $v;
                },$studentResultDetails);
              //$getStudentsActivityTermsResult =$this->getStudentsActivityTermsResult($student_id,$school_id,$session_id,'');
             // $getStudentsActivityFinalResult =$this->getStudentsActivityTermsResult($student_id,$school_id,$session_id,'all_terms');
              
              $dataArray['studentsList'] = $studentResultDetails;
              /*$dataArray = array(
                'termsList'=>orderByTermsList($school_id,$session_id),
                'studentsList'=>$studentResultDetails,
                'getStudentsActivityTermsResult'=>$getStudentsActivityTermsResult,
                'getStudentsActivityFinalResult'=>$getStudentsActivityFinalResult
              );*/
                // prd($dataArray);
            return $dataArray;
      }else{
              return $dataArray;
      }
    }
    public function subjectwiseTermData($student_id,$school_id,$session_id='')
    {
        if($session_id==''){
        $session_id= get_current_session($school_id)->id;
        }
        $where = array('rs.student_id'=>$student_id,'rs.session_id'=>$session_id);
        $this->db->select('rs.*,s.subject');
        $this->db->from('result_term_subject_data as rs');
        $this->db->join('subjects as s','s.id=rs.subject_id','inner');
        $this->db->where($where);
        $query = $this->db->get();
        $subjectTermData = $query->result();
       
        $finalTermResult = array();
        $totalAssementMarks = 0;
        $obtainAssementMarks = 0;
        $finalPercent = 0;
        $finalGrade ='';

        foreach ($subjectTermData as $key => $value) {
        	$totalAssementMarks  =  ($value->total_exam_marks)+($value->total_test_marks)+($value->total_assignment_marks)+($value->total_project_marks);
        	$obtainAssementMarks =  ($value->obtain_exam_marks)+($value->obtain_test_marks)+($value->obtain_assignment_marks)+($value->obtain_project_marks);
        	
        	$finalPercent           = round( ($obtainAssementMarks/$totalAssementMarks)*100);
            $finalGrade             =  check_grades($school_id,$finalPercent);
           
            $updateDataArr = array(
            				'total_assessment_marks'  => $totalAssementMarks,
            				'obtain_assessment_marks' => $obtainAssementMarks,
            				'assessment_percent' =>$finalPercent,
            				'assessment_grade' => $finalGrade
            );

        	$this->db->where(['id'=>$value->id,'subject_id'=>$value->subject_id]);
        	$this->db->update('result_term_subject_data',$updateDataArr);
        }
        	// prd($subjectTermData); 
        return $subjectTermData ? $subjectTermData : array();
    }
  	public function getStudentResult($postData)
  	{
     // print_r($postData);die;
      $school_id = $postData['school_id'];
      if(!empty($postData['class_id']))
      {
        $this->db->where('child_class.class_id',$postData['class_id']);
      }
      if( !empty($postData['sessionID']) )
        {
            // $this->db->where(array('cc.id'=>$postData['classID'],'cc.status'=>1));
            $this->db->where('child_class.session_id',$postData['sessionID']);
        }
   		$where = array('c.schoolId'=>$postData['school_id'],'c.status'=>1);
    	$this->db->select('c.id as studentID,c.class_session_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as stud_name,c.childphoto,c.schoolId,p.id as parent_id,CONCAT(p.fatherfname," ",p.fatherlname) as father_name,CONCAT(p.motherfname," ",p.motherlname) as mother_name,c.childclass as class_id,CONCAT(cs.class," ",cs.section) as class,t.id as teacher_id,CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as teacher_name,r.overall_total_marks,r.overall_marks_obtain,r.overall_grade,child_class.session_id,r.id');
      $this->db->from('child as c');
      $this->db->join('child_class','c.id=child_class.child_id','left');
      $this->db->join('result as r','child_class.class_id=r.class_id AND child_class.child_id = r.student_id AND child_class.session_id = r.session_id' ,'left');
      //$this->db->join('result as r1','child_class.class_id = r1.class_id','left');
      $this->db->join('parent as p',' c.parent_id=p.id','left');
    	//$this->db->join('class as cs','cs.id = c.childclass','left');
      $this->db->join('class cs','child_class.class_id=cs.id','left');
      $this->db->join('teacher as t','cs.classteacher=t.id','left');
      $this->db->where($where);
      $this->db->group_by('c.id');
      $query = $this->db->get();
    //echo $this->db->last_query();die;
    	if($query->num_rows() > 0)
      {
              $students =  $query->result();
              //print_r($students);
              foreach ($students as  $value) {
                $studentTermsResult = $this->get_total_terms_wise_result($value->studentID,$postData['sessionID']);
               //print_r($studentTermsResult);die;
                $students = array_map(function($v) use($studentTermsResult) {
                    foreach($studentTermsResult as $term){
                  
                        if($term->student_id == $v->studentID){
                          $v->termListData[] = $term;
                        }
                    }
                    return $v;
                },$students);
              }
              $dataArray = array(
                'termsList'=>orderByTermsList($school_id,$postData['sessionID']),
                'studentsList'=>$students
              );
              return $dataArray;
// prd($dataArray);
      }else{
              return array();
      }
   }
   public function calculateSubjectTermResult($student_id,$school_id,$session_id)
   {
      if($session_id==''){
        $session_id= get_current_session($school_id)->id;
      }
      $this->db->select('is_approved,reason,term_id,student_id,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
      $this->db->from('result_term_subject_data');
      $this->db->where('student_id',$student_id);
      $this->db->where('session_id',$session_id);
      $this->db->group_by('term_id');
      $query  = $this->db->get();
      $result = $query->result_array();
       //echo $this->db->last_query();die;
      $finalDataArr = array();
      $i=0;
      foreach ($result as  $value) {
        $finalPercent=0;
        if($value['totalTermAssesment']>0){
        $finalPercent           = round( ($value['totalObtainAssesment'] / $value['totalTermAssesment'])*100);
        }
        $finalGrade             =  check_grades($school_id,$finalPercent);

        $finalDataArr[$i]        = $value;
        $finalDataArr[$i]['grade'] = $finalGrade;
        $i++;
      }

      //prd($finalDataArr);
      return $finalDataArr ? $finalDataArr : array();
   }
   public function getSubjectGrandsResult($student_id,$school_id,$session_id='')
   {
    if($session_id==''){
      $session_id= get_current_session($school_id)->id;
    }
      $myClassRank=0;
      $this->db->select('term_id,student_id,subject_id,sb.subject,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
      $this->db->from('result_term_subject_data');
      $this->db->join('subjects as sb' ,'sb.id=result_term_subject_data.subject_id','inner');
      $this->db->where('session_id',$session_id);
       $this->db->where(['student_id' => $student_id, 'is_approved' => 'approved' ]);
      $this->db->group_by('subject_id');
      $query  = $this->db->get();
      $result = $query->result_array();
      if(!empty($result)){
      $myClassRank = getStudentClassRank($student_id,$session_id);
      }
      $finalDataArr = array();
      $i=0;
      foreach ($result as  $value) {
        $finalPercent=0;
        if($value['totalTermAssesment']>0){
        $finalPercent           = round( ($value['totalObtainAssesment']/$value['totalTermAssesment'])*100);
        }
        $finalGrade             =  check_grades($school_id,$finalPercent);

        $finalDataArr[$i]        = $value;
        $finalDataArr[$i]['grade'] = $finalGrade;
        $i++;
      }

      // Query merge for grand total
      $this->db->select('term_id,student_id,SUM(total_exam_marks) AS grandExam,
                        SUM(obtain_exam_marks) AS grandObtainExam,
                        SUM(total_test_marks) AS grandTest,
                        SUM(obtain_test_marks) AS grandTestObtain,
                        SUM(total_assignment_marks) AS grandAssign,
                        SUM(obtain_assignment_marks) AS grandAssignObtain,
                        SUM(total_project_marks) AS grandProject,
                        SUM(obtain_project_marks) AS grandProjObtain,
                        SUM(total_assessment_marks) AS grandAssesment,
                        SUM(obtain_assessment_marks) AS grandObtainAssesment');
      $this->db->from('result_term_subject_data');
       $this->db->where(['student_id' => $student_id, 'is_approved' => 'approved' ]);
      $this->db->where('session_id',$session_id);
      $query  = $this->db->get();
      $grandTotal = (array)$query->row();
      $finalPercent=0;
      if($grandTotal['grandAssesment']>0){
      $finalPercent           = round( ($grandTotal['grandObtainAssesment']/$grandTotal['grandAssesment'])*100);
      }
      $finalGrade             =  check_grades($school_id,$finalPercent);
      $grandTotal['grade'] = $finalGrade;
      $grandTotal['myClassRank'] = $myClassRank;
      $res = $this->updateFinalResultMarks($grandTotal,$finalPercent,$finalGrade,$session_id); 
      // prd($res);
      
      $finalDataArr = ['finalDataArr'=>$finalDataArr,'grandTotal' => $grandTotal];
      // prd($finalDataArr);
      return $finalDataArr ? $finalDataArr : array();

   }
   protected function updateFinalResultMarks($grandTotal,$finalPercent,$finalGrade,$session_id='')
   {
     if($session_id==''){
    $userDetail = $this->session->all_userdata();
    $school_id = $userDetail['user_data']['id']; 
    $session_id= get_current_session($school_id)->id;
    }
    $where = array('student_id'=> $grandTotal['student_id'],'session_id'=> $session_id);
    $updateData = array(
        'overall_total_marks'  => $grandTotal['grandAssesment'],
        'overall_marks_obtain' => $grandTotal['grandObtainAssesment'],
        'overall_grade'        => $finalGrade,
        'overall_percent'      => $finalPercent
    );
    // prd($updateData);
      $this->db->where($where);
      $this->db->update('result',$updateData);
      $this->db->affected_rows() ? $this->db->affected_rows() : false;
   }
   protected function get_total_terms_wise_result($student_id,$session_id)
   {
     if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
     }
      $where = array('student_id'=>$student_id,'td.session_id'=> $session_id);
      $this->db->select('td.id as resultTermID,SUM(td.total_term_marks) as totalTermMarks,SUM(td.obtain_term_marks) as obtainTermMarks,td.term_id,td.term_name,td.student_id');
      $this->db->from('result_term_data as td');
      // $this->db->join('result as r','r.id=td.result_id','inner');
      $this->db->where($where);
      $this->db->group_by(['student_id','term_id']);
      
      return $result = $this->db->get()->result();
      //echo $this->db->last_query();die;
      //prd($result);
   } 
   protected function get_total_terms_result($student_id)
   {
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
      $where = array('student_id'=>$student_id,'session_id'=>$session_id);
      $this->db->select('id as resultTermID,SUM(total_term_marks) as totalTermMarks,SUM(obtain_term_marks) as obtainTermMarks,term_id,term_name,student_id');
      $this->db->from('result_term_data');
      $this->db->where($where);
      $this->db->group_by(['student_id','term_id']);
      return $result = $this->db->get()->result();
      // prd($result);
   } 
   public function calculateStudentsResult($school_id,$currentSessionID='')
   {
     //echo $currentSessionID;die;
     if($currentSessionID==''){
      $currentSession   = get_current_session($school_id);
      $currentSessionID = $currentSession->id;
     }
     
      $where = array('c.schoolId'=>$school_id,'c.status'=>1,'child_class.session_id'=>$currentSessionID);

      $this->db->select('c.id as studentID,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as stud_name,c.childphoto,c.schoolId,p.id as parent_id,CONCAT(p.fatherfname," ",p.fatherlname) as father_name,CONCAT(p.motherfname," ",p.motherlname) as mother_name,child_class.class_id,CONCAT(cs.class," ",cs.section) as class,t.id as teacher_id,CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as teacher_name,ss.id as session_id,ss.academicsession,child_class.session_id');
      $this->db->from('child as c');
      $this->db->join('child_class','c.id = child_class.child_id','left');
      $this->db->join('parent as p','c.parent_id=p.id','left');
      //$this->db->join('class cs','cs.id = child_class.class_id','left');
      $this->db->join('class cs','child_class.class_id=cs.id','left');
      $this->db->join('teacher as t',' cs.classteacher=t.id','left');
      $this->db->join('sessions as ss',' child_class.session_id=ss.id','left');
      $this->db->where($where);
      $this->db->group_by('c.id');
      $query = $this->db->get();
      //echo $this->db->last_query();die;

      if($query->num_rows() > 0)
        {
            $students =  $query->result();
            
            //prd($students);
            foreach ($students as  $value) {
              // Calculate term-wise exam-marks only for Graded Exam 
              $value->studentTermsResult = $this->getStudentsTermsResult($value->studentID,$value->schoolId,$value->session_id);
              $value->studentSubjectTermsResult = $this->getStudentsSubjectTermsResult($value->studentID,$value->schoolId,$value->session_id);
            }
            $this->creatStudentActivityResult($students,$currentSessionID,$school_id);
              
           return $this->createStudentsResult($students);
        }
        else
        {
            return array();
        }
   }
   private function createStudentsResult($studentData)
   {
     //prd($studentData);
       if(count($studentData) >0 )
       {
          $resultArr = array();
          $termResultArr = array();
          $termSubjectResultArr = array();
          $grandTotalTermMarks=0;
          $grandTotalTermObtainedMarks=0;
          $index=0;
          $j=0;
          $k=0;
          foreach($studentData as $value) {
           		
           		    $resultArr[$j]['student_id'] = $value->studentID;
                  $resultArr[$j]['parent_id'] = $value->parent_id;
                  $resultArr[$j]['parent_name'] = !empty($value->father_name) ? $value->father_name : $value->mother_name;
                  $resultArr[$j]['class_id'] = $value->class_id;
                  $resultArr[$j]['school_id'] = $value->schoolId;
                  $resultArr[$j]['session_id'] = $value->session_id;
                  $resultArr[$j]['academicsession'] = $value->academicsession;
                  $resultArr[$j]['created_at'] = date('Y-m-d H:i:s');
                    if(empty($value->studentTermsResult))
                    {
                       		 
                    }else{
                             
                          foreach ($value->studentTermsResult as  $marks) {
                             
                                $termResultArr[$index]['session_id']          		  =   $value->session_id;
                                $termResultArr[$index]['term_id']             		  =   $marks['term_id'];
                                $termResultArr[$index]['term_name']           		  =   !empty($marks['term_name']) ? $marks['term_name'] : null;
                                $termResultArr[$index]['student_id']          		  =   $value->studentID;
                                $termResultArr[$index]['total_exam_marks']    		  =   $marks['total_exam_marks'];
                                $termResultArr[$index]['obtain_exam_marks']   		  =   $marks['obtain_exam_marks'];
                                $termResultArr[$index]['total_test_marks']    		  =   $marks['total_test_marks'];
                                $termResultArr[$index]['obtain_test_marks']   		  =   $marks['obtain_test_marks'];
                                $termResultArr[$index]['total_assignment_marks']    =   $marks['total_assignment_marks'];
                                $termResultArr[$index]['obtain_assignment_marks']   =   $marks['obtain_assignment_marks'];
                                $termResultArr[$index]['total_project_marks'] 	    =   $marks['total_project_marks'];
                                $termResultArr[$index]['obtain_project_marks']	    =   $marks['obtain_project_marks'];
                     		$index++;
                    	}
                  }
                  if(empty($value->studentSubjectTermsResult))
                    {
                       		 
                    }else{
                             
                          foreach ($value->studentSubjectTermsResult as  $submarks) {
                             
                                $termSubjectResultArr[$k]['session_id']          		=   $value->session_id;
                                $termSubjectResultArr[$k]['term_id']             		=   $submarks['term_id'];
                                $termSubjectResultArr[$k]['subject_id']             	=   $submarks['subject_id'];
                                $termSubjectResultArr[$k]['term_name']           		=   !empty($submarks['term_name']) ? $submarks['term_name'] : null;
                                $termSubjectResultArr[$k]['student_id']          		=   $value->studentID;
                                $termSubjectResultArr[$k]['total_exam_marks']    		=   $submarks['total_exam_marks'];
                                $termSubjectResultArr[$k]['obtain_exam_marks']   		=   $submarks['obtain_exam_marks'];
                                $termSubjectResultArr[$k]['total_test_marks']    		=   $submarks['total_test_marks'];
                                $termSubjectResultArr[$k]['obtain_test_marks']   		=   $submarks['obtain_test_marks'];
                                $termSubjectResultArr[$k]['total_assignment_marks']     =   $submarks['total_assignment_marks'];
                                $termSubjectResultArr[$k]['obtain_assignment_marks']    =   $submarks['obtain_assignment_marks'];
                                $termSubjectResultArr[$k]['total_project_marks'] 	    =   $submarks['total_project_marks'];
                                $termSubjectResultArr[$k]['obtain_project_marks']	    =   $submarks['obtain_project_marks'];
                     		$k++;
                    	}
                  }
               $j++;
          }
       }else{
           return false;
       }
       //prd($resultArr);
       if(count($resultArr) > 0)
       {
                // pr($termSubjectResultArr);
                // pr($termResultArr);
                //     prd($resultArr);
                foreach ($resultArr as  $value) {
                  $schoolID = $value['school_id'];
                  $studentID = $value['student_id'];
                  $currentSession   = get_current_session($schoolID);
                  $currentSessionID = $currentSession->id;
                 
                  $num_rows = resultExist($studentID,$value['session_id']);
                  $this->db->select('id');
                  $this->db->from('result_term_data');
                  $this->db->where('student_id',$studentID);
                  $this->db->where('session_id',$value['session_id']);
                  $query = $this->db->get();
                  $termsrows=$query->num_rows();
                  if($num_rows>0 && $termsrows>0)
                    {
                  //echo "num_rows result exists"; die;
                      continue;
                    }else{
                    $this->db->where('student_id',$studentID);
                    $this->db->where('session_id',$value['session_id']);
                    $this->db->delete('result_term_data');
                    $this->db->insert('result',$value);
                         //echo $this->db->affected_rows();die;
                    	 if($this->db->affected_rows() == 1)
                         {
                            $resultID = $this->db->insert_id();
                            
                            // Record save in subject and term wise in subjectwise term result.
                            $subjectRes = $this->subjectwiseTermResult($termSubjectResultArr,$studentID,$resultID);
                       //      break; 
                       //print_r($subjectRes);die;
                            foreach ($termResultArr as $termData) {
                              $termData['result_id'] = $resultID;
                                if($termData['student_id'] == $studentID){
                                  $this->db->insert('result_term_data',$termData);
                                }
                            }
                            
                         }else{
                            return false;
                         }    
                            // Update Total marks and grade and percent student-wise
                           $finalMarkUpdate = $this->updateFinalMarks($studentID,$schoolID,$value['session_id']);                 
                    }                     
                }
                return 1;
        }else{
               return false;
        }
    
   } 
   public function subjectwiseTermResult($termSubjectResultArr,$studentID,$resultID)
   {
   		//prd($termSubjectResultArr);
   		foreach ($termSubjectResultArr as $termSubjectData) {
// prd($termSubjectData);
			

   			$student_id = $termSubjectData['student_id'];
   			$term_id 	= $termSubjectData['term_id'];
   			$subject_id = $termSubjectData['subject_id'];
   			$session_id = $termSubjectData['session_id'];
   			
			    $data =	subjectResultExist($student_id,$session_id,$term_id,$subject_id);
          //echo $this->db->last_query(); 
          //print_r($data);die; 
          if(!empty($data->term_id) == $term_id && !empty($data->subject_id) == $subject_id && !empty($data->session_id) == $session_id && !empty($data->student_id==$student_id) ){
              //echo "AAxZC";die;
              	if(!empty($termSubjectData['obtain_exam_marks']) && !empty($termSubjectData['total_exam_marks']) )
              	{
              		unset($termSubjectData['obtain_test_marks']);
              		unset($termSubjectData['total_test_marks']);
              		unset($termSubjectData['obtain_assignment_marks']);
              		unset($termSubjectData['total_assignment_marks']);
              		unset($termSubjectData['obtain_project_marks']);
              		unset($termSubjectData['total_project_marks']);

              		$this->db->where('id',$data->id);
                	$this->db->update('result_term_subject_data',$termSubjectData); 

              	}elseif ( !empty($termSubjectData['obtain_test_marks']) && !empty($termSubjectData['total_test_marks']) ) {

              		unset($termSubjectData['obtain_exam_marks']);
              		unset($termSubjectData['total_exam_marks']);
              		unset($termSubjectData['obtain_assignment_marks']);
              		unset($termSubjectData['total_assignment_marks']);
              		unset($termSubjectData['obtain_project_marks']);
              		unset($termSubjectData['total_project_marks']);

              		$this->db->where('id',$data->id);
                	$this->db->update('result_term_subject_data',$termSubjectData);

              	}elseif ( !empty($termSubjectData['obtain_assignment_marks']) && !empty($termSubjectData['total_assignment_marks']) ) {
              		
              		unset($termSubjectData['obtain_exam_marks']);
              		unset($termSubjectData['total_exam_marks']);
              		unset($termSubjectData['obtain_test_marks']);
              		unset($termSubjectData['total_test_marks']);
              		unset($termSubjectData['obtain_project_marks']);
              		unset($termSubjectData['total_project_marks']);

              		$this->db->where('id',$data->id);
                	$this->db->update('result_term_subject_data',$termSubjectData);
              	
              	}elseif ( !empty($termSubjectData['obtain_project_marks']) && !empty($termSubjectData['total_project_marks']) ) {
              		
              		unset($termSubjectData['obtain_test_marks']);
              		unset($termSubjectData['total_test_marks']);
              		unset($termSubjectData['obtain_assignment_marks']);
              		unset($termSubjectData['total_assignment_marks']);
              		unset($termSubjectData['total_exam_marks']);
              		unset($termSubjectData['obtain_exam_marks']);

              		$this->db->where('id',$data->id);
                	$this->db->update('result_term_subject_data',$termSubjectData);
              	}else{
              		// continue;
              	}
                
              
                }else{
                  //echo "XZC";die;
	                if( ($termSubjectData['student_id'] == $studentID) ){
	                	$termSubjectData['result_id'] = $resultID;
	                  $this->db->insert('result_term_subject_data',$termSubjectData);
	                }
                }
	// prd($data);
        }
        // echo $update; die;
   }
   public function updateFinalMarks($student_id,$school_id,$currentSessionID)
   {
      // Student-wise sum of total term marks
      $studentTermsTotalMarks = termwise_overall_marks($student_id,$currentSessionID);
      // prd($studentTermsTotalMarks);
      if($studentTermsTotalMarks){
          foreach ($studentTermsTotalMarks as $value) {
        
            $finalPercent           = round( ($value['totalObtain']/$value['totalMarks'])*100);
            $finalGrade             =  check_grades($school_id,$finalPercent);
            $termMarksUpdateArr = array(
                  'total_term_marks'     => $value['totalMarks'],
                  'obtain_term_marks'    => $value['totalObtain'],
                  'term_percent'         => $finalPercent,
                  'term_grade'           => $finalGrade
            );
            $this->db->where(['id'=>$value['id'],'student_id'=>$value['student_id'] ]);
            $this->db->update('result_term_data',$termMarksUpdateArr);
          }
      }
      
       // Student-wise overall total marks
      $studentMarks = studentOverAllMarksDetails($student_id,$currentSessionID);
      if($studentMarks){
          
          $finalPercent       = round( ($studentMarks->totalObtain/$studentMarks->totalMarks)*100);
          $finalGrade         =  check_grades($school_id,$finalPercent);
          $dataUpdateArr = array(
                'overall_total_marks' => $studentMarks->totalMarks,
                'overall_marks_obtain' => $studentMarks->totalObtain,
                'overall_percent' => $finalPercent,
                'overall_grade' =>$finalGrade
          );
          $this->db->where(['student_id'=>$student_id,'session_id'=>$currentSessionID]);
          $this->db->update('result',$dataUpdateArr);
          return ($this->db->affected_rows() ? $this->db->affected_rows():0); 
      }
   }
   private function getStudentsTermsResult($studentID,$schoolId,$session_id='')
   {
    // $studentID=57;
    if($session_id==''){
      $currentSession   = get_current_session($schoolId);
      $session_id = $currentSession->id;
     }
       $termsList = orderByTermsList($schoolId,$session_id);
       //prd($termsList);
      if(count($termsList)>0)
      {
        // Get Term wise total marks from exam,test,project and assignments.
      	$termwise_overall_result = array();
	      $i=0;
	      foreach ($termsList as $term) 
	      {
	        $termwise_overall_result[$i]['exam'] = $this->getExamUserTermMarks($studentID,$term->term_id,$session_id);
          $termwise_overall_result[$i]['test'] = $this->getTestUserTermMarks($studentID,$term->term_id,$session_id);
	        $termwise_overall_result[$i]['assignment'] = $this->getAssignmentUserTermMarks($studentID,$term->term_id,$session_id);
	        $termwise_overall_result[$i]['project'] = $this->getProjectUserTermMarks($studentID,$term->term_id,$session_id);
	        $i++;
	      }
        //prd($termwise_overall_result);
      	// Remove empty subarray data in above Array
      	$overAllTermDataArr = array();
      	foreach ($termwise_overall_result as  $termData) {
      		if( (empty($termData['exam'])) &&  empty($termData['test'])  && empty($termData['assignment'])  && empty($termData['project'])  )
      		{

	      	}else{
            $overAllTermDataArr[] = $termData;
	      	}
      	}
        // prd($overAllTermDataArr);
      // New Final data to save term wise data table
      $finalTermDataArr = array();
      // $examMode = array('0'=>'exam','1'=>'test','2'=>'assignment','3'=>'project');
      $k=0;
      foreach ($overAllTermDataArr as $termData) {
        // prd($termData);
        	if( (count($termData['exam']) > 0) || (count($termData['test']) > 0) || (count($termData['assignment']) > 0) || (count($termData['project']) > 0) )
	      	{

            if( !empty($termData[ 'exam' ]['term_id']) && !empty($termData[ 'exam' ]['user_id']) )
            {
              // Set Data value for exam
              $finalTermDataArr[$k]['term_id'] 			          = !empty($termData[ 'exam' ]['term_id'])  ? $termData['exam']['term_id']: null;
  				    $finalTermDataArr[$k]['student_id'] 		        = !empty($termData[ 'exam' ]['user_id'])  ? $termData['exam']['user_id'] : null;
  	      		$finalTermDataArr[$k]['term_name'] 			        = !empty($termData['exam']['term_name'])  ? $termData['exam']['term_name']: null;
            
            }else if( !empty($termData[ 'test' ]['term_id']) && !empty($termData[ 'test' ]['user_id']) )
            {
              // Set Data value for Test
              $finalTermDataArr[$k]['term_id']                = !empty($termData[ 'test' ]['term_id'])  ? $termData['test']['term_id']: null;
              $finalTermDataArr[$k]['student_id']             = !empty($termData[ 'test' ]['user_id'])  ? $termData['test']['user_id'] : null;
              $finalTermDataArr[$k]['term_name']              = !empty($termData['test']['term_name'])  ? $termData['test']['term_name']: null;
            
            }else if( !empty($termData[ 'assignment' ]['term_id']) && !empty($termData[ 'assignment' ]['user_id']) )
            {
              // Set Data value for Assignement
              $finalTermDataArr[$k]['term_id']                = !empty($termData[ 'assignment' ]['term_id'])  ? $termData['assignment']['term_id']: null;
              $finalTermDataArr[$k]['student_id']             = !empty($termData[ 'assignment' ]['user_id'])  ? $termData['assignment']['user_id'] : null;
              $finalTermDataArr[$k]['term_name']              = !empty($termData['assignment']['term_name'])  ? $termData['assignment']['term_name']: null;
            
            }else if( !empty($termData[ 'project' ]['term_id']) && !empty($termData[ 'project' ]['user_id']) )
            {
              // Set Data value for Project
              $finalTermDataArr[$k]['term_id']                = !empty($termData[ 'project' ]['term_id'])  ? $termData['project']['term_id']: null;
              $finalTermDataArr[$k]['student_id']             = !empty($termData[ 'project' ]['user_id'])  ? $termData['project']['user_id'] : null;
            }else{
              // Set Data value for Project
              $finalTermDataArr[$k]['term_id']                = null;
              $finalTermDataArr[$k]['student_id']             = null;
              $finalTermDataArr[$k]['term_name']              = null;
            }
            

	      		$finalTermDataArr[$k]['total_exam_marks'] 	        = !empty($termData['exam']['totalExamMarks'])    ? $termData['exam']['totalExamMarks'] : 0; 
	      		$finalTermDataArr[$k]['obtain_exam_marks'] 	        = !empty($termData['exam']['totalExamObtained']) ? $termData['exam']['totalExamObtained'] : 0;
            $finalTermDataArr[$k]['total_test_marks']           = !empty($termData['test']['totalTestMarks'])     ? $termData['test']['totalTestMarks'] : 0; 
            $finalTermDataArr[$k]['obtain_test_marks']        = !empty($termData['test']['totalTestObtained'])  ? $termData['test']['totalTestObtained'] : 0; 
            $finalTermDataArr[$k]['total_assignment_marks']   = !empty($termData['assignment']['assignmentTotalMarks'])    ? $termData['assignment']['assignmentTotalMarks'] : 0; 
            $finalTermDataArr[$k]['obtain_assignment_marks']  = !empty($termData['assignment']['assignmentTotalObtained']) ? $termData['assignment']['assignmentTotalObtained'] : 0; 
            $finalTermDataArr[$k]['total_project_marks']      = !empty($termData['project']['projectTotalMarks'])    ? $termData['project']['projectTotalMarks'] : 0;
            $finalTermDataArr[$k]['obtain_project_marks']     = !empty($termData['project']['projectTotalObtained']) ? $termData['project']['projectTotalObtained']: 0;
	      	}
	       $k++;
      }
      //prd($finalTermDataArr); 
        return $finalTermDataArr ? $finalTermDataArr :array();
      }else{
        return false;
      }
   }
   private function getExamUserTermMarks($user_id,$term_id,$session_id='')
   {
      if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
      }
   	  $where = array('mb.session_id'=>$session_id,'mb.user_id'=>$user_id,'mb.term_id'=>$term_id,'e.exam_category'=>'graded','e.exam_mode'=>'exam');
      $this->db->select('SUM(mb.total_marks) as totalExamMarks, SUM(mb.marks_obtained) as totalExamObtained,mb.user_id,mb.term_id,mb.term_name,e.id as exam_id,e.exam_mode');
      $this->db->from('exam_marks_obtain as mb');
      $this->db->join('exam as e','e.id=mb.exam_id','inner');
      $this->db->where($where);
      $this->db->group_by('mb.user_id');
      $this->db->group_by('mb.term_id');
      $query = $this->db->get();
      $result = $query->row();
      return (array)$result ? (array)$result : array();
   }
   private function getTestUserTermMarks($user_id,$term_id,$session_id='')
   {
    if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
    }
      $where = array('mb.session_id'=>$session_id,'mb.user_id'=>$user_id,'mb.term_id'=>$term_id,'e.exam_category'=>'graded','e.exam_mode'=>'test');
      $this->db->select('SUM(mb.total_marks) as totalTestMarks, SUM(mb.marks_obtained) as totalTestObtained,mb.user_id,mb.term_id,mb.term_name,e.id as exam_id,e.exam_mode');
      $this->db->from('exam_marks_obtain as mb');
      $this->db->join('exam as e','e.id=mb.exam_id','inner');
      $this->db->where($where);
      $this->db->group_by('mb.user_id');
      $this->db->group_by('mb.term_id');
      $query = $this->db->get();
      $result = $query->row();
      return (array)$result ? (array)$result : array();
   }
   private function getAssignmentUserTermMarks($user_id,$term_id,$session_id='')
   {
    if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
    }
      $where = array('am.session_id'=>$session_id,'am.user_id'=>$user_id,'am.term_id'=>$term_id,'a.category'=>'graded');
      $this->db->select('SUM(am.total_marks) as assignmentTotalMarks, SUM(am.marks_obtained) as assignmentTotalObtained,am.user_id,am.term_id,a.id as assignment_id');
      $this->db->from('assignment_marks_obtain as am');
      $this->db->join('assignment as a','a.id=am.assignment_id','inner');
      $this->db->where($where);
      $this->db->group_by('am.user_id');
      $this->db->group_by('am.term_id');
      $query = $this->db->get();
      $result = $query->row();
      // lq();
      return (array)$result ? (array)$result : array();
    }
    private function getProjectUserTermMarks($user_id,$term_id,$session_id='')
    {
      if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
      }
      $where = array('pm.session_id'=>$session_id,'pm.user_id'=>$user_id,'pm.term_id'=>$term_id,'p.category'=>'graded');
      $this->db->select('SUM(pm.total_marks) as projectTotalMarks, SUM(pm.marks_obtained) as projectTotalObtained,pm.user_id,pm.term_id,p.id as project_id');
      $this->db->from('project_marks_obtain as pm');
      $this->db->join('project as p','p.id=pm.project_id','inner');
      $this->db->where($where);
      // $this->db->group_by('mb.user_id');
      $this->db->group_by('pm.term_id');
      $query = $this->db->get();
      $result = $query->row();
      return (array)$result ? (array)$result : array();
    }

    private function getStudentsSubjectTermsResult($studentID,$schoolId,$session_id='')
    {
      // $studentID=49;
        // Get Term wise total marks from exam,test,project and assignments.
        $termwise_overall_subject_result = array();
    
          $termwise_overall_subject_result['exam']       = $this->getExamSubjectwiseTermMarks($studentID,$session_id);
          $termwise_overall_subject_result['test']        = $this->getTestSubjectwiseTermMarks($studentID,$session_id);
          $termwise_overall_subject_result['assignment']        = $this->getAssignmentSubjectwiseTermMarks($studentID,$session_id);
          $termwise_overall_subject_result['project']        = $this->getProjectSubjectwiseTermMarks($studentID,$session_id);
         
       	 $overAllSubjectTermDataArr = array_merge($termwise_overall_subject_result['exam'],$termwise_overall_subject_result['test'], $termwise_overall_subject_result['assignment'] , $termwise_overall_subject_result['project']);

          // New Final data to save term wise data table
          $finalSubjectTermData = array();
          $k=0;
          foreach ($overAllSubjectTermDataArr as $key => $subjectTermData) 
          {
                    if( (!empty($subjectTermData['totalExamObtained'])) || (!empty($subjectTermData['totalTestObtained'])) || (!empty($subjectTermData['assignmentTotalObtained'])) || (!empty($subjectTermData['projectTotalObtained'])) )
                    {

                          $finalSubjectTermData[$k]['term_id']           		= !empty($subjectTermData['term_id']) ? $subjectTermData['term_id']: null;
                          $finalSubjectTermData[$k]['student_id']        		= !empty($subjectTermData['user_id']) ? $subjectTermData['user_id'] : null;
                          $finalSubjectTermData[$k]['subject_id']        		= !empty($subjectTermData['subject_id']) ? $subjectTermData['subject_id'] : null;
                          $finalSubjectTermData[$k]['term_name']         		= !empty($subjectTermData['term_name']) ? $subjectTermData['term_name']: null;
                        
                          $finalSubjectTermData[$k]['total_exam_marks']         = !empty($subjectTermData['totalExamMarks'])   ? $subjectTermData['totalExamMarks'] : 0; 
                          $finalSubjectTermData[$k]['obtain_exam_marks']        = !empty($subjectTermData['totalExamObtained']) ? $subjectTermData['totalExamObtained'] : 0;

                          $finalSubjectTermData[$k]['total_test_marks']         = !empty($subjectTermData['totalTestMarks'])    ? $subjectTermData['totalTestMarks'] : 0; 
                          $finalSubjectTermData[$k]['obtain_test_marks']        = !empty($subjectTermData['totalTestObtained']) ? $subjectTermData['totalTestObtained'] : 0; 

                          $finalSubjectTermData[$k]['total_assignment_marks']   = !empty($subjectTermData['assignmentTotalMarks'])    ? $subjectTermData['assignmentTotalMarks'] : 0; 
                          $finalSubjectTermData[$k]['obtain_assignment_marks']  = !empty($subjectTermData['assignmentTotalObtained']) ? $subjectTermData['assignmentTotalObtained'] : 0; 

                          $finalSubjectTermData[$k]['total_project_marks']      = !empty($subjectTermData['projectTotalMarks'])       ? $subjectTermData['projectTotalMarks'] : 0;
                          $finalSubjectTermData[$k]['obtain_project_marks']     = !empty($subjectTermData['projectTotalObtained'])    ? $subjectTermData['projectTotalObtained']: 0;
               }
                    $k++;
        }
      // prd($overAllSubjectTermDataArr);
        return $finalSubjectTermData ? $finalSubjectTermData :array();
  }
   private function getExamSubjectwiseTermMarks($user_id,$session_id='')
   {
     if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
     }
      // $where = array('mb.user_id'=>$user_id,'mb.term_id'=>$term_id,'e.exam_category'=>'graded','e.exam_mode'=>'exam');
      $where = array('mb.session_id'=>$session_id,'mb.user_id'=>$user_id,'e.exam_category'=>'graded','e.exam_mode'=>'exam');
      $this->db->select('SUM(mb.total_marks) as totalExamMarks, SUM(mb.marks_obtained) as totalExamObtained,mb.user_id,mb.term_id,mb.subject_id,mb.term_name,e.id as exam_id,e.exam_mode');
      $this->db->from('exam_marks_obtain as mb');
      $this->db->join('exam as e','e.id=mb.exam_id','inner');
      $this->db->where($where);
      $this->db->group_by('mb.subject_id');
      $this->db->group_by('mb.term_id');
      $query = $this->db->get();
      // lq();
      $result = $query->result_array();
      return $result ? $result : array();
   }
   private function getTestSubjectwiseTermMarks($user_id,$session_id='')
   {
     if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
     }
      // $where = array('mb.user_id'=>$user_id,'mb.term_id'=>$term_id,'e.exam_category'=>'graded','e.exam_mode'=>'test');
      $where = array('mb.session_id'=>$session_id,'mb.user_id'=>$user_id,'e.exam_category'=>'graded','e.exam_mode'=>'test');
      $this->db->select('SUM(mb.total_marks) as totalTestMarks, SUM(mb.marks_obtained) as totalTestObtained,mb.user_id,mb.term_id,mb.subject_id,mb.term_name,e.id as exam_id,e.exam_mode');
      $this->db->from('exam_marks_obtain as mb');
      $this->db->join('exam as e','e.id=mb.exam_id','inner');
      $this->db->where($where);
      $this->db->group_by('mb.subject_id');
      $this->db->group_by('mb.term_id');
      $query = $this->db->get();
      $result = $query->result_array();
      return $result ? $result : array();
   }
   private function getAssignmentSubjectwiseTermMarks($user_id,$session_id='')
   {
        // $where = array('am.user_id'=>$user_id,'am.term_id'=>$term_id,'a.category'=>'graded');
      if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
      }
      $where = array('am.session_id'=>$session_id,'am.user_id'=>$user_id,'a.category'=>'graded');
      $this->db->select('SUM(am.total_marks) as assignmentTotalMarks, SUM(am.marks_obtained) as assignmentTotalObtained,am.user_id,am.term_id,am.subject_id,a.id as assignment_id');
      $this->db->from('assignment_marks_obtain as am');
      $this->db->join('assignment as a','a.id=am.assignment_id','inner');
      $this->db->where($where);
      $this->db->group_by('am.subject_id');
      $this->db->group_by('am.term_id');
      $query = $this->db->get();
      $result = $query->result_array();
      return $result ? $result : array();
    }
    private function getProjectSubjectwiseTermMarks($user_id,$session_id='')
    {
        // $where = array('pm.user_id'=>$user_id,'pm.term_id'=>$term_id,'p.category'=>'graded');
      if($session_id==''){
      $userDetail = $this->session->all_userdata();
      $school_id = $userDetail['user_data']['id']; 
      $session_id= get_current_session($school_id)->id;
      }
      $where = array('pm.session_id'=>$session_id,'pm.user_id'=>$user_id,'p.category'=>'graded');
      $this->db->select('SUM(pm.total_marks) as projectTotalMarks, SUM(pm.marks_obtained) as projectTotalObtained,pm.user_id,pm.term_id,pm.subject_id,p.id as project_id');
      $this->db->from('project_marks_obtain as pm');
      $this->db->join('project as p','p.id=pm.project_id','inner');
      $this->db->where($where);
      $this->db->group_by('pm.subject_id');
      $this->db->group_by('pm.term_id');
      $query = $this->db->get();
      // lq();
      $result = $query->result_array();
      return $result ? $result : array();
    }

    public function resultIsApproved($postData)
    {
      //print_r($postData);die;
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        //$session_id= get_current_session($school_id)->id;
        $session_id=$postData['session_id'];
        if( !empty($postData['student_id']) && !empty($postData['term_id']) && !empty($postData['resultStatus']) )
        {
          $updateArr = array(
              'is_approved' => $postData['resultStatus'],
              'reason'    => !empty($postData['reason']) ? ($postData['reason']) : null
          );

          if( ($postData['term_id'] == 'all') && ($postData['resultStatus'] == 'disapproved') )
          {
            $resultUpdateArr = array(
                'is_approved'          => 'disapproved',
                'overall_total_marks'  => 0, 
                'overall_marks_obtain' => 0, 
                'overall_percent'      => 0, 
                'overall_grade'        => 'F',
                'updated_at'           => date('Y-m-d H:i:s')
            );
            $this->db->where([ 'student_id'=>$postData['student_id'] ]);
            $this->db->update('result',$resultUpdateArr);

            $this->db->where([ 'student_id'=>$postData['student_id'] ]);
            $this->db->where([ 'session_id'=>$session_id ]);
          }else if( ($postData['term_id'] == 'all')  && ($postData['resultStatus'] == 'approved') )
          {
          	$resultUpdateArr = array(
                'is_approved'          => 'approved',
                'updated_at'           => date('Y-m-d H:i:s')
            );
            $this->db->where([ 'student_id'=>$postData['student_id'] ]);
            $this->db->update('result',$resultUpdateArr);

            $this->db->where([ 'student_id'=>$postData['student_id'] ]);
            $this->db->where([ 'session_id'=>$session_id ]);

          }else{
            $this->db->where(['student_id'=>$postData['student_id'],'term_id'=>$postData['term_id'] ]);
            $this->db->where([ 'session_id'=>$session_id ]);
          }
          // prd($updateArr);
            $this->db->update('result_term_subject_data',$updateArr);
            
            return ($this->db->affected_rows() ? $this->db->affected_rows() : 0 );
        }else{
            return 0;
        }
    }
    public function generateStudentResult($postData,$session_id='')
    {
      if($session_id==''){
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $session_id= get_current_session($school_id)->id;
      }
        if(!empty($postData['student_id']))
        {
              $this->db->trans_start();
              
              $tables = array('result', 'result_term_data','result_term_subject_data','activities_term_result','activities_subject_term_result'); 
              $this->db->where('student_id', $postData['student_id']);
              $this->db->where('session_id', $session_id);
              $this->db->delete($tables);
              
              $this->db->trans_complete();
            
            if($this->db->trans_status() === FALSE)
              return false;
            else
              return true;
        }
    }
    public function creatStudentActivityResult($students,$session_id,$school_id){
      $ordertermdata=orderByTermsList($school_id,$session_id);
      //print_r($ordertermdata);die;
      //$termdataArr=array();
      $studentArr=array();
        if(!empty($ordertermdata)){
            foreach($ordertermdata as $termdata){
              
              $studentArr['term_id']=$termdata->term_id;
              $studentArr['term_name']=$termdata->termname;
                if(!empty($students)){
                 
                  foreach($students as $student_data){
                    if(isset($studentArr['subject_id'])){
                      unset($studentArr['subject_id']);
                    }
                    if(isset($studentArr['result_id'])){
                      unset($studentArr['result_id']);
                    }
                    if(isset($where['subject_id'])){
                      unset($where['subject_id']);
                    }
                    
                    $studentArr['student_id']=$student_data->studentID;
                    $studentArr['class_id']=$student_data->class_id;
                    $studentArr['session_id']=$student_data->session_id;
                    $studentArr['school_id']=$student_data->schoolId;
                    $this->db->select('id','subject');
                    $this->db->from('subjects');
                    $this->db->where('class',$student_data->class_id);
                    $this->db->where('type','Activity');
                    $this->db->where('status',1);
                    $sData=$this->db->get();
                    $resultData=$sData->result();
                    if(!empty($resultData)){
                      
                      $where['student_id'] = $studentArr['student_id'];
                      $where['class_id'] = $studentArr['class_id'];
                      $where['session_id'] = $studentArr['session_id'];
                      $where['school_id'] = $studentArr['school_id'];
                      $where['term_id'] = $studentArr['term_id'];
                      $this->db->select('id');
                      $this->db->from('activities_term_result');
                      $this->db->where($where);
                      $checktermData=$this->db->get();
                      //echo $this->db->last_query();die;
                      $resultermData=$checktermData->row();
                      if($resultermData){
                        $last_id = $resultermData->id;
                      }else{
                        $studentArr['created_at']=date('Y-m-d H:i:s');
                        $this->db->insert('activities_term_result',$studentArr);
                        $last_id = $this->db->insert_id();
                      }

                      foreach($resultData as $subject_data){
                        $studentArr['result_id']=$last_id;
                        $studentArr['subject_id']=$subject_data->id;
                        $where['subject_id'] = $subject_data->id;
                        $this->db->select('*');
                        $this->db->from('activities_subject_term_result');
                        $this->db->where($where);
                        $query=$this->db->get();
                        $getRow=$query->num_rows();
                        if($getRow>0){
                          
                        }else{
                          $this->db->insert('activities_subject_term_result',$studentArr);
                        }
                      }
                    }
                  }
                }
            }

            /* Final activities result */
            $studentArr=array();
            $where=array();
            if(!empty($students)){
                 
              foreach($students as $student_data){
                if(isset($studentArr['subject_id'])){
                  unset($studentArr['subject_id']);
                }
                if(isset($studentArr['final_result_id'])){
                  unset($studentArr['final_result_id']);
                }
                if(isset($where['subject_id'])){
                  unset($where['subject_id']);
                }
                
                $studentArr['student_id']=$student_data->studentID;
                $studentArr['class_id']=$student_data->class_id;
                $studentArr['session_id']=$student_data->session_id;
                $studentArr['school_id']=$student_data->schoolId;
                $this->db->select('id','subject');
                $this->db->from('subjects');
                $this->db->where('class',$student_data->class_id);
                $this->db->where('type','Activity');
                $this->db->where('status',1);
                $sData=$this->db->get();
                $resultData=$sData->result();
                if(!empty($resultData)){
                  
                  $where['student_id'] = $studentArr['student_id'];
                  $where['class_id'] = $studentArr['class_id'];
                  $where['session_id'] = $studentArr['session_id'];
                  $where['school_id'] = $studentArr['school_id'];
                  $this->db->select('id');
                  $this->db->from('activities_final_result');
                  $this->db->where($where);
                  $checktermData=$this->db->get();
                  $resultermData=$checktermData->row();
                  if($resultermData){
                    $last_id = $resultermData->id;
                  }else{
                    $studentArr['created_at']=date('Y-m-d H:i:s');
                    $this->db->insert('activities_final_result',$studentArr);
                    $last_id = $this->db->insert_id();
                  }

                  foreach($resultData as $subject_data){
                    $studentArr['final_result_id']=$last_id;
                    $studentArr['subject_id']=$subject_data->id;
                    $where['subject_id'] = $subject_data->id;
                    $this->db->select('*');
                    $this->db->from('activities_final_subject_result');
                    $this->db->where($where);
                    $query=$this->db->get();
                    $getRow=$query->num_rows();
                    if($getRow>0){
                      
                    }else{
                      $this->db->insert('activities_final_subject_result',$studentArr);
                    }
                  }
                }
              }
            }

        }
    }
    public function getStudentsActivityTermsResult($student_id='',$school_id='',$session_id,$term_id='')
    {
    	$grantResultArr=array();
    	$resultArr=array();
		$this->db->select('name');
		$this->db->from('activities_performance');
		//$this->db->where('school_id',$school_id);
		$actData=$this->db->get();
		$result=$actData->result_array();
		$activity_key=array('is_beginner','is_intermediate','is_advanced','is_expert');
		$i=0;
		if(!empty($result)){
			$resultArr[$i]['term_id']=$term_id;
			$resultArr[$i]['subject']="Activities";
			$resultArr[$i]['is_beginner']=$result[0]['name'];
			$resultArr[$i]['is_intermediate']=$result[1]['name'];
			$resultArr[$i]['is_advanced']=$result[2]['name'];
			$resultArr[$i]['is_expert']=$result[3]['name'];
			$resultArr[$i]['class_id']='';
			$resultArr[$i]['subject_id']='';
			$resultArr[$i]['student_id']='';
      $resultArr[$i]['remarks']='Remarks';
      if($term_id == 'all_terms')
				{
				$sql = 'SELECT sd.is_beginner,sd.session_id,sd.is_intermediate,sd.is_advanced,sd.is_expert,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				s.subject,sd.subject_id,sd.is_approved,sd.class_id,sd.student_id,sd.remarks,sd.reason 
						FROM activities_final_subject_result AS sd
						LEFT JOIN child as c ON c.id = sd.student_id
						INNER JOIN (select * from subjects where status=1) as s ON s.id = sd.subject_id
						WHERE `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.'  order by sd.id ';
			}else{
				$sql = 'SELECT sd.term_id,sd.session_id,is_beginner,is_intermediate,is_advanced,is_expert,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				s.subject,sd.is_approved,sd.subject_id,sd.class_id,sd.student_id,sd.remarks,sd.reason
						FROM activities_subject_term_result AS sd
						LEFT JOIN child as c ON c.id = sd.student_id
						INNER JOIN (select * from subjects where status=1) as s ON s.id = sd.subject_id
						WHERE `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.' AND sd.school_id = '.$school_id.' order by sd.term_id ';
      
    }

			$query=$this->db->query($sql);
			if($query->num_rows() > 0){
      $totalResultData=$query->result_array();
      for($i=0;$i<count($totalResultData);$i++){
        
        if($term_id=='all_terms'){
          $totalResultData[$i]['term_id']=$term_id;
          //print_r($totalResultData[$i]);die;
        }
        
        array_push($resultArr,$totalResultData[$i]);
      }
				return (count($resultArr) > 0) ? $resultArr: array();
			}else{
				return array();
			}
    	}else{
			return array();
		}
  }
  public function activityResultUpdate($postData)
  {
    $table='activities_subject_term_result';
    $userDetail = $this->session->all_userdata();
    $school_id = $userDetail['user_data']['id']; 
    $schoolId=$school_id;
		//$session_id= get_current_session($schoolId)->id;
    	$where = array(
			'session_id'=> $postData['session_id'],
			'school_id'=> $schoolId,
			'class_id'=> $postData['class_id'],
			'student_id'=> $postData['student_id'],
			'subject_id'=> $postData['subject_id'],
		);
		if($postData['term_id']!='all_terms'){
			$where['term_id']= $postData['term_id'];
		}
		if($postData['term_id']=='all_terms'){
			$table='activities_final_subject_result';
		}
		$postData = array(
			'is_beginner'=> $postData['is_beginner'],
			'is_intermediate'=> $postData['is_intermediate'],
			'is_advanced'=> $postData['is_advanced'],
			'is_expert'=> $postData['is_expert'],
			'remarks'=> $postData['remarks'],
		);
			$this->db->where($where);
      $this->db->update($table,$postData);
			return ($this->db->affected_rows() ? $this->db->affected_rows() : 0 );
  }
  public function activityResultIsApproved($postData)
    {
        $userDetail = $this->session->all_userdata();
        $school_id = $userDetail['user_data']['id']; 
        $schoolId=$school_id;
        $session_id= $postData['session_id'];
        if( ( !empty($postData['student_id']) && !empty($postData['term_id']) )|| ( !empty($postData['is_approved']) ) )
        {
          $updateArr = array(
              'is_approved' => $postData['is_approved'],
              'reason'    => !empty($postData['reason']) ? ($postData['reason']) : ''
          );
		  	
          if( ($postData['term_id'] == 'all_terms') )
          {
			
			$this->db->where('session_id',$session_id);
			$this->db->where('school_id',$schoolId);
			$this->db->where('class_id',$postData['class_id']);
      $this->db->where('student_id',$postData['student_id']);
			$this->db->update('activities_final_result',$updateArr);
			
			$this->db->where('session_id',$session_id);
			$this->db->where('school_id',$schoolId);
			$this->db->where('class_id',$postData['class_id']);
            $this->db->where('student_id',$postData['student_id']);
			$this->db->update('activities_final_subject_result',$updateArr);
			//$this->db->last_query();die;

          }else{
			$this->db->where('term_id',$postData['term_id'] );
			$this->db->where('session_id',$session_id);
			$this->db->where('school_id',$schoolId);
			$this->db->where('class_id',$postData['class_id']);
            $this->db->where('student_id',$postData['student_id']);
			$this->db->update('activities_term_result',$updateArr);
			$this->db->where('term_id',$postData['term_id'] );
			$this->db->where('session_id',$session_id);
			$this->db->where('school_id',$schoolId);
			$this->db->where('class_id',$postData['class_id']);
      $this->db->where('student_id',$postData['student_id']);
      $this->db->update('activities_subject_term_result',$updateArr);
      //echo $this->db->last_query();die;
		  }
            return ($this->db->affected_rows() ? $this->db->affected_rows() : 0 );
        }else{
            return 0;
        }
    }
}
