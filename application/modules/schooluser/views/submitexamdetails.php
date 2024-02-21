<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
							<div class="page-icon">
								<i class="icon-user-tie"></i>
							</div>
							<div class="page-title">
								<h5>View Submitted Answers</h5>
							</div>
						</div>
					</div>
				</div>
			</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-header mb-3">
						<div class="row">
							<div class="col-md-8">
								<h4 class="mb-0 mt-1">{{ studentExamDetails.exam_name }}</h4>
							</div>
							<div class="col-md-4 text-left text-md-right">
								<span class="badge label-success" ng-if="(studentExamDetails.marks_obtained !=null)">Checked</span>
							</div>
						</div>
					</div>
				<div class="card-body">
					<form>
						<div class="row">
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Assessment Category:</span> <span class="text-success">{{ (studentExamDetails.exam_category=='non-graded') ? 'Non Graded':'Graded' }}</span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Assessment Mode:</span> <span class="text-success">{{ (studentExamDetails.exam_mode=='exam') ? 'Exam' : 'Test'  }}</span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Assessment Type:</span> <span class="text-success">{{ (studentExamDetails.exam_type=='non-multiple') ? 'Non Multiple Choice' : 'Multiple Choice' }}</span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Assessment Name:</span> <span class="text-success">{{ studentExamDetails.exam_name }} </span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Student Name:</span> <span class="text-success">{{ studentExamDetails.stud_name }}</span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Class:</span> <span class="text-success">{{ studentExamDetails.class }} </span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Duration:</span> <span class="text-success">{{ studentExamDetails.exam_duration }} </span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Subject:</span> <span class="text-success">{{ studentExamDetails.subject }} </span>
							</div>
							<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Number of Question:</span> <span class="text-success">{{ studentExamDetails.total_question }} </span>
							</div>
	<!-- 						<div class="col-md-4 mb-3">
								<span class="text-mdm mr-2">Status:</span> <span class="badge label-success">Pending</span>
							</div> -->
							<div class="col-md-4 mb-3" ng-if=" (studentExamDetails.exam_category == 'graded') ">
								<span class="text-mdm mr-2">Status:</span> <span class="badge label-success">{{ (studentExamDetails.grade) ? 'Graded' : 'Assessment Checking' }}</span>
							</div>
							<div class="col-md-4 mb-3" ng-if=" (studentExamDetails.exam_category == 'non-graded') ">
								<span class="text-mdm mr-2">Status:</span> <span class="badge label-danger">{{ (studentExamDetails.grade) ? 'Mark Received' : 'Assessment Checking' }}</span>
							</div>

						
 							<div class="col-md-4 mb-3" ng-if="(studentExamDetails.exam_category=='non-graded')">
								<span class="text-mdm mr-2">Total Marks:</span> <span class="text-danger">{{ studentExamDetails.total_marks }} </span>
							</div>
							<div class="col-md-4 mb-3" ng-if="(studentExamDetails.exam_category=='non-graded')">
								<span class="text-mdm mr-2">Marks Obtained:</span> <span class="text-success">{{ (studentExamDetails.marks_obtained) ? studentExamDetails.marks_obtained : '-'}}</span>
							</div>
							<div class="col-md-4 mb-3" ng-if="(studentExamDetails.exam_category=='non-graded')">
								<span class="text-mdm mr-2">Percentage:</span> <span class="text-danger">{{(studentExamDetails.percentage) ? studentExamDetails.percentage+'%' : '-' }} </span>
							</div>
							<div class="col-md-4 mb-3" ng-if="(studentExamDetails.exam_category == 'graded')">
								<span class="text-mdm mr-2">Grade:</span> <span class="text-danger">{{ (studentExamDetails.grade) ? studentExamDetails.grade : '-' }} </span>
								
							</div>
						</div>
						
						<div class="question-block-e" ng-repeat="ques in questionList track by $index">

							<div class="row">
								<div class="col-md-12 qstn">
								<span class="text-mdm q">Q{{$index+1}}. {{ ques.question }}</span>
								<span class="question-marks pull-right">({{ ques.question_marks }} Marks)</span></div>
								<!-- <div class="col-md-12 mt-2" ng-repeat="opt in ques.option_value"><span>Options:</span> &nbsp;&nbsp;&nbsp;&nbsp; <span class="text-danger">{{ opt.option }}</span> </div> -->
							
								<div class="col-md-12 mt-2 ans" ng-repeat="ans in ques.answer_value" ng-if="(ans.isUserAnswer=='true') || (ans.isUserAnswer==true) || (ans.isUserAnswer!='false') ">
						
									<span class="pull-left" ng-if="(ques.question_type != 'textual')">Ans: <span> {{ ans.option }}</span> </span>

									<span class="pull-left" ng-if="(ques.question_type == 'textual') && (ans.isUserAnswer!='false')">Ans: <span> {{ ans.isUserAnswer }}</span> </span>
									
									<p class="text-center" ng-if="(ques.question_type != 'textual')">Correct answer: <span class="text-success">{{ ques.answer }}</span></p>
									
									<p ng-show = "( (ques.answer.split(',').indexOf(ans.option) > -1) == true)" ng-if="(ques.question_type != 'textual') &&  (studentExamDetails.marks_obtained !=null)" class="text-success"><i class="fa fa-check" aria-hidden="true"></i></p>

									<p ng-show = "( (ques.answer.split(',').indexOf(ans.option) > -1) == false)" ng-if="(ques.question_type != 'textual') &&  (studentExamDetails.marks_obtained !=null)" class="text-danger"><i class="fa fa-close" aria-hidden="true"></i></p>
									
									<p ng-if="(ans.option != ques.answer) && (ans.option == ques.answer) &&  (studentExamDetails.marks_obtained !=null)"><i class="fa fa-close" aria-hidden="true"></i> Did not attempt answer</p>

									<div class="give-marks pull-right">
										<input type="text" class="form-control digit-only" ng-if="((ques.question_type == 'multiple') || (ques.question_type == 'boolean') || (ques.question_type == 'radio')) && (ans.option == ques.answer) && (studentExamDetails.exam_type == 'non-multiple') &&  (studentExamDetails.marks_obtained ==null)"  ng-model="ques.question_marks" ng-disabled="true" />
										
										<input type="text" class="form-control" ng-if="((ques.question_type == 'multiple') || (ques.question_type == 'boolean') || (ques.question_type == 'radio')) && (ans.option != ques.answer) && (studentExamDetails.exam_type == 'non-multiple') &&  (studentExamDetails.marks_obtained ==null)"  value="0" ng-disabled="true" />
									</div> 
								</div>

								<!-- Before Submitted Exam Enabled mark for textaul -->
								<input type="number" class="form-control digit-only" ng-if="(ques.question_type == 'textual') && (studentExamDetails.exam_type != 'multiple') &&  (studentExamDetails.marks_obtained == null)"  ng-model="questionList[$index].marks_obtain" min="0" max="{{ ques.question_marks }}" onkeydown="return false"/>
								<!-- After Submitted Exam disabled mark for textaul -->
								<input type="text" class="form-control" ng-if="(ques.question_type == 'textual') && (studentExamDetails.exam_type != 'multiple') &&  (studentExamDetails.marks_obtained !=null)" ng-model="ques.question_mark_obtain" ng-disabled='true' />
							</div>
						</div>
						<!-- {{studentExamDetails}} -->
						<!-- {{studentExamDetails.exam_category}} -->
						<!-- <h6 ng-if="(studentExamDetails.exam_type != 'multiple') && (studentExamDetails.marks_obtained !=null)" class="label badge-danger text-center">Note* : This assessment ( {{ studentExamDetails.exam_name }} ) has been checked. </h6> -->
								<button type="submit" class="btn btn-success ml-3" style="cursor: pointer;" ng-click="calculateMarks(studentExamDetails.answer_id,studentExamDetails.total_marks)" ng-if="(studentExamDetails.exam_type != 'multiple') && (studentExamDetails.marks_obtained ==null)">Submit</button>
						</form>
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<script>
	$("[type='number']").keypress(function (evt) {
    evt.preventDefault();
});
</script>