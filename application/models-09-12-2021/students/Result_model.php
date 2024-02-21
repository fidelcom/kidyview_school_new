<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	class Result_model extends CI_Model
	{
		public function getResultList($schoolID='',$student_id='',$filterbydate='',$class_id='',$subject_id='',$category=''){
			$sql='SELECT r.*,CONCAT(c.class," " ,c.section) as classname,CONCAT(ch.childfname," " ,ch.childmname," " ,ch.childlname) as studentname from result r left join child ch ON r.student_id=ch.id left join class c ON r.class_id=c.id  left join sessions si ON r.session_id=si.id WHERE r.is_approved="approved"';	
			$sql .= ' AND r.class_id="'.$class_id.'"'; 
			$sql .= ' AND r.student_id="'.$student_id.'"'; 
			$sql .= ' AND si.current_sesion=1';
			//echo $sql;die;
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
		 public function getResultDetails($id=''){
			 $sql='SELECT * FROM result r where r.id="'.$id.'"';
			 $query=$this->db->query($sql);
			 if($query->num_rows() > 0)
			 {
				 $data_user = $query->result_array();
				 return $data_user[0];
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
			 //$sql='SELECT * FROM result_term_data rt where rt.term_id="'.$term_id.'" AND rt.result_id="'.$result_id.'" AND rt.is_approved="approved" ORDER BY id';
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
		public function getStudentExamDetails($student_id,$school_id)
		{
		$where = array('c.schoolId'=>$school_id,'c.id'=>$student_id,'c.status'=>1);
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
			$where = array('rs.student_id'=>$student_id,'rs.is_approved'=>'approved');
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
	public function getSubjectGrandsResult($student_id,$school_id)
   	{
     $myClassRank = getStudentClassRank($student_id);
      $this->db->select('term_id,student_id,subject_id,sb.subject,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
      $this->db->from('result_term_subject_data');
      $this->db->join('subjects as sb' ,'sb.id=result_term_subject_data.subject_id','inner');
	  $this->db->where('student_id',$student_id);
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
		{
		   $this->db->select('is_approved,term_id,student_id,SUM(total_exam_marks) as totalTermExam,SUM(obtain_exam_marks) as totalTermObtainExam,SUM(total_test_marks) as totalTermTest,SUM(obtain_test_marks) as totalTermTestObtain,SUM(total_assignment_marks) as totalTermAssign,SUM(obtain_assignment_marks) as totalTermAssignObtain,SUM(total_project_marks) as totalTermProj,SUM(obtain_project_marks) as totalTermProjObtain,SUM(total_assessment_marks) as totalTermAssesment,SUM(obtain_assessment_marks) as totalObtainAssesment');
		   $this->db->from('result_term_subject_data');
		   $this->db->where('student_id',$student_id);
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
			
	}		