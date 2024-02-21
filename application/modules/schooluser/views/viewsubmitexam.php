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
								<h5>View Submitted Assessment</h5>
							</div>
						</div>
					</div>
				</div>
			</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-header">
						<h4 class="mb-0">{{ studentExamDetails.exam_name}}</h4>
					</div>
					<div class="card-body full-detail">
						<ul>
							<li><span class="text-mdm">Assessment Category:</span>{{ (studentExamDetails.exam_category=='non-graded') ? 'Non Graded':'Graded' }}</li>
							<li><span class="text-mdm">Assessment Mode:</span>{{ (studentExamDetails.exam_mode=='exam') ? 'Exam':'Test' }}</li>
							
							<li ng-if="(studentExamDetails.exam_type=='textual')"><span class="text-mdm">Assessment Type:</span>{{ (studentExamDetails.exam_type=='textual') ? 'Non-Multiple Choice' : '' }}</li>
							<li ng-if="(studentExamDetails.exam_type=='multiple')"><span class="text-mdm">Assessment Type:</span>{{ (studentExamDetails.exam_type=='multiple') ? 'Multiple Choice' : '' }}</li>
							<li ng-if="(studentExamDetails.exam_type=='non-multiple')"><span class="text-mdm" >Assessment Type:</span>{{ (studentExamDetails.exam_type=='non-multiple') ? 'Mixed Choice' : '' }}</li>

							<li><span class="text-mdm">Student Name:</span> {{ studentExamDetails.stud_name}}</li>
							<li><span class="text-mdm">Class:</span> {{ studentExamDetails.class}}</li>
							<li><span class="text-mdm">Duration:</span> {{ studentExamDetails.exam_duration}}</li>
							<li><span class="text-mdm">Subject:</span> {{ studentExamDetails.subject}}</li>
							<li><span class="text-mdm">No. of Question:</span> {{ studentExamDetails.total_question}}</li>
							
							<li ng-if="(studentExamDetails.exam_category=='non-graded')"><span class="text-mdm">Total Marks:</span> {{ studentExamDetails.total_marks }}</li>
							<!-- <li><span class="text-mdm">Marks Obtained:</span>-</li> -->
							<li ng-if="(studentExamDetails.exam_category=='non-graded')"><span class="text-mdm">Marks Obtained:</span>{{ (studentExamDetails.marks_obtained) ? studentExamDetails.marks_obtained : '-'}}</li>
							<li ng-if="(studentExamDetails.exam_category=='non-graded')"><span class="text-mdm">Percentage:</span>{{(studentExamDetails.percentage) ? studentExamDetails.percentage+'%' : '-' }}</li>
							<li ng-if="(studentExamDetails.exam_category=='graded')"><span class="text-mdm">Grade:</span>{{ (studentExamDetails.grade) ? studentExamDetails.grade : '-' }}</li>

							<li ng-if=" (studentExamDetails.exam_category == 'graded') "><span class="text-mdm">Status:</span>  <span class="badge label-success">{{ (studentExamDetails.grade) ? 'Graded' : 'Assessment Checking' }} </span></li>
							<li ng-if=" (studentExamDetails.exam_category == 'non-graded') "><span class="text-mdm">Status:</span> <span class="badge label-danger"> {{ (studentExamDetails.grade) ? 'Mark Received' : 'Assessment Checking' }} </span></li>

						</ul>
						<a href="#!/submitted-exam-details/{{studentExamDetails.id}}" class="btn btn-primary mt-2">View Submitted Answers</a>
					</div>
					
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main