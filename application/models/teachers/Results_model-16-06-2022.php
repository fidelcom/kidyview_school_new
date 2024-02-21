<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Results_model extends CI_Model
	{
		
		public function getResultList($schoolID='',$teacher_id='',$filterbydate='',$class_id='',$subject_id='',$category=''){
			$assignClassId=$this->getAssignedClassId($teacher_id);	
			$sql='SELECT r.*,CONCAT(c.class," " ,c.section) as classname,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname from result r left join child ch ON r.student_id=ch.id left join class c ON r.class_id=c.id  left join sessions si ON r.session_id=si.id WHERE r.is_approved="approved"';	
		   if($class_id!=''){
		   	   $sql .= ' AND r.class_id="'.$class_id.'"';
		   }else{
			   $sql .= ' AND r.class_id IN ('.$assignClassId.')';   
		   }  
		   $sql .= ' AND si.current_sesion=1';
		   $sql .= ' ORDER BY r.id DESC';
		   $query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
				$data_user = $query->result_array();
				for($i=0;$i<count($data_user);$i++){
					$termData= orderByTermsList($schoolID);
					if(!empty($termData)){
						for($j=0;$j<count($termData);$j++){
							$data_user[$i]['classTeacher']=$this->getClassTeacher($data_user[$i]['class_id']);
							$getResultTermData=$this->getResultTermData($data_user[$i]['id'],$termData[$j]->term_id);
							$data_user[$i]['termData'][$j]=$getResultTermData;
							$data_user[$i]['termData'][$j]['termname']=$termData[$j]->termname;
						}
						}
				}
				return $data_user;
				
            }else{
                return array();
            }
		}
		public function getClassTeacher($class_id=''){
            $sql='SELECT id,CONCAT(t.teacherfname," " ,t.teachermname," " ,t.teacherlname) as teachername FROM teacher t where t.assignclassteacher IN ('.$class_id.')';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->row();
				return $data_user;
            }else{
                return '';
            }
		}	
		public function getResultTermData($result_id='',$term_id){
            $sql='SELECT * FROM result_term_data rt where rt.term_id="'.$term_id.'" AND rt.result_id="'.$result_id.'" ORDER BY id';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->result_array();
				return $data_user[0];
            }else{
                return array();
            }
		}
		public function getAssignedClassId($teacher_id=''){
            $sql='SELECT assignclassteacher FROM teacher t where t.id ='.$teacher_id.'';
			$query=$this->db->query($sql);
			if($query->num_rows() > 0)
			{
                $data_user = $query->row('assignclassteacher');
				return $data_user;
            }else{
                return '';
            }
		}
		public function getStudentExamDetails($student_id,$school_id)
		{
		$session_id= get_current_session($school_id)->id;	
		$where = array('r.session_id'=>$session_id,'c.schoolId'=>$school_id,'c.id'=>$student_id,'c.status'=>1);
		$this->db->select('c.id as studentID,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as stud_name,c.childphoto,c.schoolId,p.id as parent_id,CONCAT(p.fatherfname," ",p.fatherlname) as father_name,CONCAT(p.motherfname," ",p.motherlname) as mother_name,c.childclass as class_id,CONCAT(cs.class," ",cs.section) as class,t.id as teacher_id,CONCAT(t.teacherfname," ",t.teachermname," ",t.teacherlname) as teacher_name,r.overall_total_marks,r.overall_marks_obtain,r.overall_grade,r.overall_percent');
		$this->db->from('child as c');
		$this->db->join('result as r','r.student_id = c.id','left');
		$this->db->join('parent as p','p.id = c.parent_id','left');
		$this->db->join('class as cs','cs.id = c.childclass','left');
		$this->db->join('teacher as t','t.id = cs.classteacher','left');
		$this->db->where($where);
		$query = $this->db->get();

		if($query->num_rows() > 0)
		{
		$studentResultDetails = $query->result_array();

		$studentTermsResult = $this->subjectwiseTermData($student_id,$school_id);

		// prd($studentTermsResult);
		$studentResultDetails = array_map(function($v) use($studentTermsResult) {
		foreach($studentTermsResult as $term){

			if($term->student_id == $v['studentID']){
				$v['termListData'][] = $term;
			}
		}
		return $v;
		},$studentResultDetails);

		$dataArray = array(
		'termsList'=>orderByTermsList($school_id),
		'studentsList'=>$studentResultDetails
		);
		// prd($dataArray);
		return $dataArray;
		}else{
		return array();
		}
	}
	public function subjectwiseTermData($student_id,$school_id)
	{
		$session_id= get_current_session($school_id)->id;
		$where = array('rs.session_id'=>$session_id,'rs.student_id'=>$student_id,'rs.is_approved'=>'approved');
		$this->db->select('rs.*,s.subject');
		$this->db->from('result_term_subject_data as rs');
		$this->db->join('subjects as s','s.id=rs.subject_id','inner');
		$this->db->where($where);
		$query = $this->db->get();
		$subjectTermData = $query->result();
//	prd($subjectTermData);	
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
	public function getSubjectGrandsResult($student_id,$school_id)
   	{
		$schoolId=$this->token->school_id;
        $session_id= get_current_session($schoolId)->id;
      $myClassRank = getStudentClassRank($student_id);
      $this->db->select('term_id,student_id,subject_id,sb.subject,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
      $this->db->from('result_term_subject_data');
      $this->db->join('subjects as sb' ,'sb.id=result_term_subject_data.subject_id','inner');
	  $this->db->where('student_id',$student_id);
	  $this->db->where('session_id',$session_id);
	  $this->db->where('is_approved','approved');
      $this->db->group_by('subject_id');
      $query  = $this->db->get();
      $result = $query->result_array();
      // prd($result);
      $finalDataArr = array();
      $i=0;
      foreach ($result as  $value) {

        $finalPercent           = round( ($value['totalObtainAssesment']/$value['totalTermAssesment'])*100);
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
	  $this->db->where('student_id',$student_id);
	  $this->db->where('session_id',$session_id);
	  $this->db->where('is_approved','approved');
      $query  = $this->db->get();
      $grandTotal = (array)$query->row();

      $finalPercent           = round( ($grandTotal['grandObtainAssesment']/$grandTotal['grandAssesment'])*100);
      $finalGrade             =  check_grades($school_id,$finalPercent);
      $grandTotal['grade'] = $finalGrade;
      $grandTotal['myClassRank'] = $myClassRank;
      
      $finalDataArr = ['finalDataArr'=>$finalDataArr,'grandTotal' => $grandTotal];
      // prd($finalDataArr);
      return $finalDataArr ? $finalDataArr : array();

   }
   public function calculateSubjectTermResult($student_id,$school_id)
	{	   $session_id= get_current_session($school_id)->id;
		   $this->db->select('is_approved,term_id,student_id,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
		   $this->db->from('result_term_subject_data');
		   $this->db->where('student_id',$student_id);
		   $this->db->where('session_id',$session_id);
		   $this->db->where('is_approved','approved');
		   $this->db->group_by('term_id');
		   $query  = $this->db->get();
		   $result = $query->result_array();
		   // prd($result);
		   $finalDataArr = array();
		   $i=0;
		   foreach ($result as  $value) {
	 
			 $finalPercent           = round( ($value['totalObtainAssesment']/$value['totalTermAssesment'])*100);
			 $finalGrade             =  check_grades($school_id,$finalPercent);
	 
			 $finalDataArr[$i]        = $value;
			 $finalDataArr[$i]['grade'] = $finalGrade;
			 $i++;
		   }
	 
		   // prd($finalDataArr);
		   return $finalDataArr ? $finalDataArr : array();
		}
	public function termsList($school_id)
	{
		$session_id= get_current_session($school_id)->id;
		$where = array('schoolId'=>$school_id,'status'=>'1','academicsession'=>$session_id);
		$terms =  $this->db->select('id,termname,')->where($where)->get('terms')->result_array();
		if(count($terms)>0)
		{
			$all = array('id'=>'all_terms','termname'=>'all_terms');
				array_push($terms,$all);
				return (count($terms) > 0 ) ? $terms : array();
		}else{
			return array();
		}
	}
	public function getStudentsByClass($classID,$school_id,$search=false)
	{ 
		$currentDate = date('Y-m-d');
			$sql = 'SELECT `c`.`id`,CONCAT(c.childfname," ",`c`.`childmname`," ",c.childlname) AS  studentName,c.childphoto,CONCAT(pa.fatherfname," ",pa.fatherlname) AS fatherName,CONCAT(pa.motherfname," ",pa.motherlname) AS motherName,CONCAT(cs.class," ",cs.section) AS class,CONCAT(tc.teacherfname," ",tc.teachermname," ",tc.teacherlname) AS teacher
				 FROM `child` AS `c`
				 LEFT JOIN (SELECT * FROM `student_attendance` WHERE student_attendance.date = "'.$currentDate.'") sa ON `sa`.`student_id` = `c`.`id`
				
				 LEFT JOIN parent as pa ON `pa`.`id` = `c`.`parent_id`
				 LEFT JOIN class as cs ON `cs`.`id` = `c`.`childclass`
				 LEFT JOIN teacher as tc ON `tc`.`id` = `cs`.`classteacher`
				 WHERE `c`.`childclass` = '.$classID.' AND `c`.`status` = 1 AND `c`.`schoolId` = '.$school_id.' ';
				if(!empty($search))
				{
					$sql .= "AND ( c.childfname like '%".$search."%'";
					 $sql .= " OR c.childmname like '%".$search."%'";
					 $sql .= " OR c.childlname like '%".$search."%')";
				}
		
			$query=$this->db->query($sql);
			
			if($query->num_rows() > 0){
				$result =  $query->result_array();
				// prd($result);
				if(count($result) >0){
						$classStudents = array();
						$i=0;
						foreach ($result as $key => $value) {
							$studentGrade = $this->getFinalGrades($value['id']);
							// prd($studentGrade);

							$classStudents[$i] = $value;
							$classStudents[$i]['result'] = !empty($studentGrade['overall_grade']) ? $studentGrade['overall_grade'] :"";
							$classStudents[$i]['generateResult'] = "true/false";
							$i++;
						}
						// prd($classStudents);
						return $classStudents;
				}else{
					return false;
				}
			}
		    else{
            	return false;
		    }
    }
    public function getFinalGrades($student_id)
    {
    	return $this->db->select('overall_grade')->where('student_id',$student_id)->get('result')->row_array();
    }
    public function getStudentsTermsResult($postData)
    {
    	// prd($postData);
    	$term_id = $postData['term_id'];
    	$student_id = $postData['student_id'];
    	$school_id = $this->token->school_id;
        $session_id= get_current_session($school_id)->id;
		// Calculate subject wise result of subject term
		$termResult = $this->subjectwiseTermData($student_id,$school_id);    	
	        	
    	if($term_id == 'all_terms')
    	{
    		$is_approved = 'approved';
    		 $sql = 'SELECT
			    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
			    s.subject,sd.is_approved,sd.reason,
			    SUM(sd.`total_exam_marks`) AS totalExamMarks,
			    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
			    SUM(sd.`total_test_marks`) AS totalTestMarks,
			    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
			    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
			    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
			    SUM(sd.`total_project_marks`) AS totalProjectMarks,
			    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks
			   
				FROM
				    `result_term_subject_data` AS sd
				LEFT JOIN child as c ON c.id = sd.student_id
				LEFT JOIN subjects as s ON s.id = sd.subject_id
				WHERE
				    `student_id` = '.$student_id.' AND `sd`.`is_approved` = "'.$is_approved.'" AND `sd`.`session_id` = "'.$session_id.'"
				GROUP BY
				    sd.subject_id ';

    	}else{
    		$sql = 'SELECT
			    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
			    s.subject,sd.is_approved,sd.reason,
			    SUM(sd.`total_exam_marks`) AS totalExamMarks,
			    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
			    SUM(sd.`total_test_marks`) AS totalTestMarks,
			    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
			    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
			    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
			    SUM(sd.`total_project_marks`) AS totalProjectMarks,
			    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks
			   
				FROM
				    `result_term_subject_data` AS sd
				LEFT JOIN child as c ON c.id = sd.student_id
				LEFT JOIN subjects as s ON s.id = sd.subject_id
				WHERE
				    `student_id` = '.$student_id.' AND sd.term_id = '.$term_id.' AND `sd`.`session_id` = "'.$session_id.'"
				GROUP BY
				    sd.subject_id ';
    	}
    	
		$query=$this->db->query($sql);
		// lq();
			if($query->num_rows() > 0)
	        {
	        	 $result = $query->result_array();
    	    	 // prd($result);
	        	 $totalResultData = array();
	        	 $i=0;
	        	 $totalMarks = 0;
	        	 $totalObtainMarks = 0;
	        	 foreach ($result as $value) {
	        	 	// prd(count($result));
	        	 	$totalResultData[$i] = $value;
	        	 	$totalResultData[$i]['reason'] = !empty($value['reason']) ? $value['reason'] : '' ;
	        	 	$totalResultData[$i]['totalMarks'] = $value['totalExamMarks'] + $value['totalTestMarks'] + $value['totalAssignmentMarks'] + $value['totalProjectMarks'];
	        	 	$totalResultData[$i]['totalObtainMarks'] = $value['obtainExamMarks'] + $value['obtainTestMarks'] + $value['obtainAssignmentMarks'] + $value['obtainProjectMarks'];

	        	 	 $finalPercent           = round( ( $totalResultData[$i]['totalObtainMarks'] / $totalResultData[$i]['totalMarks'] ) *100 );
			      	 $finalGrade             =  check_grades($school_id,$finalPercent);

	        	 	$totalResultData[$i]['grade'] = !empty($finalGrade) ? $finalGrade : '';
	        	 // prd($totalResultData);
	        	 	$totalResultData[$i]['is_approved'] = !empty($value['is_approved']) ? $value['is_approved'] : '' ;
	        	 	$i++;
	        	 }

	        	 $grandResult = $this->getGrandTotalResult($postData);
	        	 // lq();
	        	 // prd($totalResultData);
	        	 return (count($result) > 0) ? array('result'=>$totalResultData,'grandResult'=>$grandResult) : array();
	        }   
		    else{
            	return array();
		    }
    	
    }
    public function getGrandTotalResult($postData)
    {
    	$school_id = $this->token->school_id;

    	$term_id = $postData['term_id'];
		$student_id = $postData['student_id'];
		$session_id= get_current_session($school_id)->id;
    	$myClassRank = getStudentClassRank($student_id,$session_id);
    	if($term_id == 'all_terms')
    	{
	    	$sql = 'SELECT
				    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				    s.id as subject_id,s.subject,sd.is_approved,sd.reason,
				    SUM(sd.`total_exam_marks`) AS totalExamMarks,
				    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
				    SUM(sd.`total_test_marks`) AS totalTestMarks,
				    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
				    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
				    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
				    SUM(sd.`total_project_marks`) AS totalProjectMarks,
				    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks,
				    SUM(sd.`total_assessment_marks`) AS grandAssesment,
	                SUM(sd.`obtain_assessment_marks`) AS grandObtainAssesment
				   
					FROM
					    `result_term_subject_data` AS sd
					LEFT JOIN child as c ON c.id = sd.student_id
					LEFT JOIN subjects as s ON s.id = sd.subject_id
					WHERE
					    `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.' AND `is_approved` = "approved" ';
		}else{

				    	$sql = 'SELECT
				    sd.term_id,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				    s.id as subject_id,s.subject,sd.is_approved,sd.reason,
				    SUM(sd.`total_exam_marks`) AS totalExamMarks,
				    SUM(sd.`obtain_exam_marks`) AS obtainExamMarks,
				    SUM(sd.`total_test_marks`) AS totalTestMarks,
				    SUM(sd.`obtain_test_marks`) AS obtainTestMarks,
				    SUM(sd.`total_assignment_marks`) AS totalAssignmentMarks,
				    SUM(sd.`obtain_assignment_marks`) AS obtainAssignmentMarks,
				    SUM(sd.`total_project_marks`) AS totalProjectMarks,
				    SUM(sd.`obtain_project_marks`) AS obtainProjectMarks,
				    SUM(sd.`total_assessment_marks`) AS grandAssesment,
	                SUM(sd.`obtain_assessment_marks`) AS grandObtainAssesment
				   
					FROM
					    `result_term_subject_data` AS sd
					LEFT JOIN child as c ON c.id = sd.student_id
					LEFT JOIN subjects as s ON s.id = sd.subject_id
					WHERE
					    `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.' AND sd.term_id = '.$term_id.'  ';
		}

			$query=$this->db->query($sql);
		
			if($query->num_rows() > 0){

	        	$result =  $query->row_array();

	        	 $grandObtainAssesment = !empty($result['grandObtainAssesment']) ? $result['grandObtainAssesment'] : 0;
	        	 $grandAssesment = !empty($result['grandAssesment']) ? $result['grandAssesment'] : 0;	
	        	 if($grandObtainAssesment && $grandAssesment){
	        	  	$finalPercent           = round( ($grandObtainAssesment/$grandAssesment)*100);
			      	$finalGrade             =  check_grades($school_id,$finalPercent);
	        	 }else{
	        	  	$finalPercent           = '-';
			      	$finalGrade             = '-';
	        	 }
			      $result['grade'] = $finalGrade;
			      $result['myClassRank'] = !empty($grandObtainAssesment) ? $myClassRank : '-' ;
			      $result['reason'] = !empty($result['reason']) ? $result['reason'] : '-' ;
			      $result['term_id'] = !empty($postData['term_id']) ? $term_id : '' ;
			      $result['is_approved'] = !empty($result['is_approved']) ? $result['is_approved'] : '' ;

			      $res = $this->updateFinalResultMarks($grandAssesment,$grandObtainAssesment,$finalPercent,$finalGrade,$student_id);
			      // lq();
			      // prd($res);
			      // if($res)
			      // 	continue;
			      // else
			      // 	return false;
			      	
			      return (count($result) > 0) ? $result : array();
			}
	        else{
            	return array();
	        }
    }
    protected function updateFinalResultMarks($grandAssesment,$grandObtainAssesment,$finalPercent,$finalGrade,$student_id)
    {
		$schoolId=$this->token->school_id;
        $session_id= get_current_session($schoolId)->id;
    	$where = array('student_id'=> $student_id,'session_id'=> $session_id);
    
    	$updateData = array(
	        'overall_total_marks'  => $grandAssesment,
	        'overall_marks_obtain' => $grandObtainAssesment,
	        'overall_grade'        => $finalGrade,
	        'overall_percent'      => $finalPercent
    	);
    	// prd($updateData);
      $this->db->where($where);
      $this->db->update('result',$updateData);
      $this->db->affected_rows() ? $this->db->affected_rows() : false;
   	}
    public function resultIsApproved($postData)
    {
      	$schoolId=$this->token->school_id;
        $session_id= get_current_session($schoolId)->id;
        if( ( !empty($postData['student_id']) && !empty($postData['term_id']) )|| ( !empty($postData['resultStatus']) ) )
        {
          $updateArr = array(
              'is_approved' => $postData['resultStatus'],
              'reason'    => !empty($postData['reason']) ? ($postData['reason']) : null
          );

          if( ($postData['term_id'] == 'all_terms') && ($postData['resultStatus'] == 'disapproved') )
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
          }else if( ($postData['term_id'] == 'all_terms')  && ($postData['resultStatus'] == 'approved') )
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
    public function generateStudentResult($student_id)
    {
		$schoolId=$this->token->school_id;
        $session_id= get_current_session($schoolId)->id;
		$this->db->delete('result_term_subject_data', array('student_id' => $student_id,'session_id' => $session_id));
		$this->db->delete('result', array('student_id' => $student_id,'session_id' => $session_id));
		$this->db->delete('result_term_data', array('student_id' => $student_id,'session_id' => $session_id));
		$this->db->delete('activities_term_result', array('student_id' => $student_id,'session_id' => $session_id));
		$this->db->delete('activities_subject_term_result', array('student_id' => $student_id,'session_id' => $session_id));
		return $this->db->affected_rows();
	}
	public function getStudentsActivityTermsResult($postData)
    {
    	$grantResultArr=array();
    	$resultArr=array();
    	$term_id = $postData['term_id'];
    	$student_id = $postData['student_id'];
    	$school_id = $this->token->school_id;
		$session_id= get_current_session($school_id)->id;
		//$session_id=43;
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
			$resultArr[$i]['is_approved']='';
			$resultArr[$i]['student_id']='';
			$resultArr[$i]['remarks']='';
			$resultArr[$i]['reason']='';

			if($term_id == 'all_terms')
				{
				$sql = 'SELECT sd.is_beginner,sd.is_intermediate,sd.is_advanced,sd.is_expert,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				s.subject,sd.is_approved,sd.class_id,sd.student_id,sd.remarks,sd.reason 
						FROM activities_final_subject_result AS sd
						LEFT JOIN child as c ON c.id = sd.student_id
						LEFT JOIN subjects as s ON s.id = sd.subject_id
						WHERE `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.'  order by sd.id ';

			}else{
				$sql = 'SELECT sd.term_id,is_beginner,is_intermediate,is_advanced,is_expert,CONCAT(c.childfname," ",c.childmname," ",c.childlname) as student,
				s.subject,sd.is_approved,sd.subject_id,sd.class_id,sd.student_id,sd.remarks,sd.reason 
						FROM activities_subject_term_result AS sd
						LEFT JOIN child as c ON c.id = sd.student_id
						LEFT JOIN subjects as s ON s.id = sd.subject_id
						WHERE `student_id` = '.$student_id.' AND sd.session_id = '.$session_id.' AND sd.term_id = '.$term_id.' order by sd.term_id ';
			}

			$query=$this->db->query($sql);
			if($query->num_rows() > 0){
				$totalResultData=$query->result_array();
				foreach($totalResultData as $tdaya){
					array_push($resultArr,$tdaya);
				}
				return (count($result) > 0) ? array('result'=>$resultArr,'grandResult'=>array()) : array();
				/* if($term_id == 'all_terms')
    			{
					return (count($result) > 0) ? array('result'=>array(),'grandResult'=>$resultArr) : array();
				}else{
					return (count($result) > 0) ? array('result'=>$resultArr,'grandResult'=>array()) : array();
				}*/
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
      	$schoolId=$this->token->school_id;
		$session_id= get_current_session($schoolId)->id;
    	$where = array(
			'session_id'=> $session_id,
			'school_id'=> $schoolId,
			'class_id'=> $postData['class_id'],
			'student_id'=> $postData['student_id'],
			'subject_id'=> $postData['subject_id'],
		);
		if($postData['term_id']!=''){
			$where['term_id']= $postData['term_id'];
		}
		if($postData['term_id']==''){
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
      	$schoolId=$this->token->school_id;
        $session_id= get_current_session($schoolId)->id;
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
		  }
            return ($this->db->affected_rows() ? $this->db->affected_rows() : 0 );
        }else{
            return 0;
        }
    }
}