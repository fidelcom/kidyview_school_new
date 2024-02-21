<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-user-plus"></i>
					</div>
					<div class="page-title">
						<h5>Final Report Card ( {{studentExamDetails.studentsList[0].stud_name}} )</h5>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="card">
			<div class="card-body">
				<div class="student_detail">
					<div class="profileimg">
						<!-- <img class="img-fluid" src="https://chawtechsolutions.ch/kidyview/img/school/038a27bae5162c0bf4b2bddb99d56a6a.jpg" alt="User profile"> -->

						<img ng-show="studentExamDetails.studentsList[0].childphoto != ''" class="img-fluid" src="<?= base_url(); ?>img/child/{{studentExamDetails.studentsList[0].childphoto}}" alt="User profile" />
						<img ng-show="studentExamDetails.studentsList[0].childphoto == ''" class="img-fluid" src="<?= base_url(); ?>img/article/noImage.png" />
					</div>
					<div class="full-detail">
						<ul>
							<li><span>Student Name</span> {{studentExamDetails.studentsList[0].stud_name}}</li>
							<li><span>Father Name</span> {{studentExamDetails.studentsList[0].father_name ? studentExamDetails.studentsList[0].father_name : 'N/A'}}</li>
							<li><span>Mother Name</span> {{studentExamDetails.studentsList[0].mother_name ? studentExamDetails.studentsList[0].mother_name: 'N/A'}}</li>
							<li><span>Class &amp; Section</span> {{studentExamDetails.studentsList[0].class ? studentExamDetails.studentsList[0].class : 'N/A' }}</li>
							<li><span>Teacher Name</span> {{studentExamDetails.studentsList[0].teacher_name ? studentExamDetails.studentsList[0].teacher_name : 'N/A'}}</li>
							<li><span>Result</span> <span class="text-danger">{{studentExamDetails.studentsList[0].overall_grade ? studentExamDetails.studentsList[0].overall_grade : 'N/A'}}</span></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>

				<div class="row mt-4">
					<div class="col-md-12 col-sm-12 col-xs-12 mb-5" ng-repeat="term in studentExamDetails.termsList">
						<div class="parent_box with_table mb-0 bg-light auto-height">
							<h2>{{term.termname}}</h2>
							<div class="saperator-div mb-4">
								<h3>Graded Subjects</h3>
								<table class="table table-striped table-bordered table-responsive text-left">
									<thead class="bg-primary text-white">
										<tr>
											<th class="text-left">Subject</th>
											<th>Exams</th>
											<th>Tests</th>
											<th>Assignment</th>
											<th>Project</th>
											<th>Max Marks</th>
											<th>Obtained Marks</th>
											<th>Grade</th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="termData in termListData" ng-if="(termData.term_id == term.term_id)">
											<td colspan="7" ng-if="(termData.term_id != term.term_id)">{{ 'N/A' }}</td>
											<td class="text-left">{{ (termData.subject ? termData.subject : 'N/A') }}</td>

											<td>
												<span ng-if="(termData.obtain_exam_marks != '0')">
													{{ (termData.obtain_exam_marks ? termData.obtain_exam_marks: '-') }}
												</span>
												<span ng-if="(termData.obtain_exam_marks == '0')">
													{{ '-' }}
												</span>
											</td>
											<td>
												<span ng-if="(termData.obtain_test_marks != '0')">
													{{ (termData.obtain_test_marks ? termData.obtain_test_marks: '-') }}
												</span>
												<span ng-if="(termData.obtain_test_marks == '0')">
													{{ '-' }}
												</span>
											</td>
											<td>
												<span ng-if="(termData.obtain_assignment_marks != '0')">
													{{ (termData.obtain_assignment_marks ? termData.obtain_assignment_marks: '-') }}
												</span>
												<span ng-if="(termData.obtain_assignment_marks == '0')">
													{{ '-' }}
												</span>
											</td>
											<td>
												<span ng-if="(termData.obtain_project_marks != '0')">
													{{ (termData.obtain_project_marks ? termData.obtain_project_marks: '-') }}
												</span>
												<span ng-if="(termData.obtain_project_marks == '0')">
													{{ '-' }}
												</span>
											</td>

											<td>{{ (termData.total_assessment_marks)? termData.total_assessment_marks :'-' }}</td>
											<td>{{ (termData.obtain_assessment_marks)? termData.obtain_assessment_marks :'-'}}</td>
											<td>{{ (termData.assessment_grade)? termData.assessment_grade :'-'}}</td>
										</tr>
									</tbody>
									<tfoot class="bg-dark text-white">
										<tr ng-repeat="termTotal in totalTermResult" ng-if="(termTotal.term_id == term.term_id)">
											<th class="text-left">Grand Total</th>
											<th>{{ (termTotal.totalTermObtainExam == '0') ? '-' : termTotal.totalTermObtainExam +"/"+ termTotal.totalTermExam  }}</th>
											<th>{{ (termTotal.totalTermTestObtain == '0') ? '-' : termTotal.totalTermTestObtain +"/"+ termTotal.totalTermTest  }}</th>
											<th>{{ (termTotal.totalTermAssignObtain == '0') ? '-' : termTotal.totalTermAssignObtain +"/"+ termTotal.totalTermAssign }}</th>
											<th>{{ (termTotal.totalTermProjObtain == '0') ? '-' : termTotal.totalTermProjObtain +"/"+ termTotal.totalTermProj }}</th>
											<th>{{ (termTotal.totalTermAssesment == '0') ? '-' : termTotal.totalTermAssesment }}</th>
											<th>{{ (termTotal.totalObtainAssesment == '0') ? '-' : termTotal.totalObtainAssesment }}</th>
											<th>{{ termTotal.grade }}</th>
										</tr>

									</tfoot>
								</table>

								<table class="table table-striped table-bordered table-responsive text-left mt-4">	
								<tfoot class="bg-dark text-white">
										<tr ng-repeat="termTotal in totalTermResult" ng-if="(termTotal.term_id == term.term_id)">
											<th class="text-center" colspan="2" style="color: red;background: white;">Result Status</th>
											<th class="text-center" colspan="3" style="color: blue;background: white;"> {{(termTotal.is_approved) ? termTotal.is_approved.toUpperCase() : '-'}}</th>
										</tr>

										<tr ng-repeat="termTotal in totalTermResult" ng-if="(termTotal.term_id == term.term_id) && (termTotal.is_approved == 'disapproved')">
											<th class="text-center" colspan="2" style="color: red;background: white;">Deny Reason</th>
											<th class="text-center" colspan="2" style="color: orange;background: white;"> {{(termTotal.reason) ? termTotal.reason.toUpperCase() : '-'}}</th>
										</tr>


									</tfoot>
								</table>
								<form class="mt-3" action=" ">
									<div class="row">
										<div class="col-md-12 text-left">
											<div class="form-group">
												<input type="radio" ng-model="resultStatus" name="resultStatus" value="approved"> Approve Result
											</div>
											<div class="form-group">
												<input type="radio" ng-model="resultStatus" name="resultStatus" value="disapproved"> Deny Result
											</div>
											<div class="form-group">
												<textarea class="form-control" ng-model="reason" rows="5" placeholder="Enter your question" required="required"></textarea>
											</div>
											<div class="form-group">
												<button type="button" class="btn btn-primary" ng-click="approveDisapproveResult(term.term_id,studentExamDetails.studentsList[0].studentID,resultStatus,reason)">Save</button>
											</div>
										</div>

									</div>
								</form>
							</div>

							<div class="saperator-div mb-4">
								<h3>Activities</h3>
								<table class="table table-striped table-bordered table-responsive text-left activity-table">
									<thead class="bg-primary text-white">
										<tr>
											<th class="text-left">{{studentExamDetails.getStudentsActivityTermsResult[0].subject}}</th>
											<th>{{studentExamDetails.getStudentsActivityTermsResult[0].is_beginner}}</th>
											<th>{{studentExamDetails.getStudentsActivityTermsResult[0].is_intermediate}}</th>
											<th>{{studentExamDetails.getStudentsActivityTermsResult[0].is_advanced}}</th>
											<th>{{studentExamDetails.getStudentsActivityTermsResult[0].is_expert}}</th>
											<th>{{studentExamDetails.getStudentsActivityTermsResult[0].remarks}} </th>
										</tr>
									</thead>
									<tbody>
										<tr ng-repeat="activityresult in studentExamDetails.getStudentsActivityTermsResult" ng-if="(activityresult.term_id == term.term_id)"> 
											<td>{{activityresult.subject}}</td>

											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_beginner" ng-change="updateActivities(activityresult,'1','0','0','0')" ng-true-value="'1'" >
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_intermediate" ng-change="updateActivities(activityresult,'0','1','0','0')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_advanced" ng-change="updateActivities(activityresult,'0','0','1','0')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_expert" ng-change="updateActivities(activityresult,'0','0','0','1')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td><input type="text" class="form-control" ng-keyup="updateActivities(activityresult,activityresult.is_beginner,activityresult.is_intermediate,activityresult.is_advanced,activityresult.is_expert)" ng-model="activityresult.remarks"></td>

										</tr>
									</tbody>

								</table>
								<table class="table table-striped table-bordered table-responsive text-left mt-4">	
								<tfoot class="bg-dark text-white">
										<tr ng-repeat="activityresult in studentExamDetails.getStudentsActivityTermsResult" ng-if="(activityresult.term_id == term.term_id) && $index%4==0">
											<th class="text-center" colspan="2" style="color: red;background: white;">Result Status</th>
											<th class="text-center" colspan="3" style="color: blue;background: white;"> {{(studentExamDetails.getStudentsActivityTermsResult[$index].is_approved) ? studentExamDetails.getStudentsActivityTermsResult[$index].is_approved.toUpperCase() : '-'}}</th>
										</tr>

										<tr ng-repeat="activityresult in studentExamDetails.getStudentsActivityTermsResult" ng-if="(activityresult.term_id == term.term_id) && ($index%4==0) && (studentExamDetails.getStudentsActivityTermsResult[$index].is_approved == 'disapproved')">
											<th class="text-center" colspan="2" style="color: red;background: white;">Deny Reason</th>
											<th class="text-center" colspan="2" style="color: orange;background: white;"> {{(studentExamDetails.getStudentsActivityTermsResult[$index].reason) ? studentExamDetails.getStudentsActivityTermsResult[$index].reason.toUpperCase() : '-'}}</th>
										</tr>


									</tfoot>
								</table>
								<div ng-repeat="activityresult in studentExamDetails.getStudentsActivityTermsResult" ng-if="(activityresult.term_id == term.term_id) && $index%4==0">
								<form class="mt-3" action=" " >
									<div class="row">
										<div class="col-md-12 text-left">
											<div class="form-group">
											<input type="radio" ng-model="studentExamDetails.getStudentsActivityTermsResult[$index].is_approved" name="allresultStatus" value="approved"> Approve Result
											</div>
											<div class="form-group">
												<input type="radio" ng-model="studentExamDetails.getStudentsActivityTermsResult[$index].is_approved" name="allresultStatus" value="disapproved"> Deny Result
											</div>
											<div class="form-group">
												<textarea class="form-control" ng-model="studentExamDetails.getStudentsActivityTermsResult[$index].reason" rows="5" placeholder="Enter your question" required="required"></textarea>
											</div>
											<div class="form-group">
												<button type="button" class="btn btn-primary" ng-click="approveDisapproveActivityResult(studentExamDetails.getStudentsActivityTermsResult[$index])">Save</button>
											</div>
										</div>

									</div>
								</form>
								</div>
							</div>
						
						</div>
					</div>

					<div class="col-md-12 col-sm-12 col-xs-12 mb-5">
						<div class="parent_box with_table mb-0 bg-light">
							<div class="h5 text-left text-primary">Final Result <span class="h5 float-right"><span class="text-danger">Class Position:</span> <span class="text-primary">{{ (grandTotalMarks.myClassRank)?grandTotalMarks.myClassRank:'NA' }}</span></span></div>
						
							<div class="saperator-div mb-4">
							<table class="table table-striped table-bordered table-responsive text-left">
								<thead class="bg-primary text-white">
									<tr>
										<th class="text-left">Subject</th>
										<th>Exams</th>
										<th>Tests</th>
										<th>Assignment</th>
										<th>Project</th>
										<th>Max Marks</th>
										<th>Obtained Marks</th>
										<th>Grade</th>
										<!-- <th class="text-right">Percentage</th> -->
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="marks in totalGrandResult">
										<td class="text-left">{{marks.subject}}</td>
										<td>
											<span ng-if="(marks.totalTermObtainExam != '0')">
												{{ (marks.totalTermObtainExam ? marks.totalTermObtainExam: '-') }}
											</span>
											<span ng-if="(marks.totalTermObtainExam == '0')">
												{{ '-' }}
											</span>
										</td>
										<td>
											<span ng-if="(marks.totalTermTestObtain != '0')">
												{{ (marks.totalTermTestObtain ? marks.totalTermTestObtain: '-') }}
											</span>
											<span ng-if="(marks.totalTermTestObtain == '0')">
												{{ '-' }}
											</span>
										</td>

										<td>
											<span ng-if="(marks.totalTermAssignObtain != '0')">
												{{ (marks.totalTermAssignObtain ? marks.totalTermAssignObtain: '-') }}
											</span>
											<span ng-if="(marks.totalTermAssignObtain == '0')">
												{{ '-' }}
											</span>
										</td>
										<td>
											<span ng-if="(marks.totalTermProjObtain != '0')">
												{{ (marks.totalTermProjObtain ? marks.totalTermProjObtain: '-') }}
											</span>
											<span ng-if="(marks.totalTermProjObtain == '0')">
												{{ '-' }}
											</span>
										</td>

										<td>
											<span ng-if="(marks.totalTermAssesment != '0')">
												{{ (marks.totalTermAssesment ? marks.totalTermAssesment : '-') }}
											</span>
											<span ng-if="(marks.totalTermAssesment == '0')">
												{{ '-' }}
											</span>
										</td>
										<td>
											<span ng-if="(marks.totalObtainAssesment != '0')">
												{{ (marks.totalObtainAssesment ? marks.totalObtainAssesment : '-') }}
											</span>
											<span ng-if="(marks.totalObtainAssesment == '0')">
												{{ '-' }}
											</span>
										</td>
										<td>{{ (marks.grade)? marks.grade :'-'}}</td>
									</tr>

								</tbody>
								<tfoot class="bg-dark text-white">
									<tr ng-if="grandTotalMarks.length !='0'">
										<th class="text-left">Grand Total</th>
										<th>{{ (grandTotalMarks.grandObtainExam == '0') ? '-' : grandTotalMarks.grandObtainExam +"/"+ grandTotalMarks.grandExam  }}</th>
										<th>{{ (grandTotalMarks.grandTestObtain == '0') ? '-' : grandTotalMarks.grandTestObtain +"/"+ grandTotalMarks.grandTest  }}</th>
										<th>{{ (grandTotalMarks.grandAssignObtain == '0') ? '-' : grandTotalMarks.grandAssignObtain +"/"+ grandTotalMarks.grandAssign  }}</th>
										<th>{{ (grandTotalMarks.grandProjObtain == '0') ? '-' : grandTotalMarks.grandProjObtain +"/"+ grandTotalMarks.grandProject  }}</th>
										<th>{{ (grandTotalMarks.grandAssesment == '0') ? '-' : grandTotalMarks.grandAssesment  }}</th>
										<th>{{ (grandTotalMarks.grandObtainAssesment == '0') ? '-' : grandTotalMarks.grandObtainAssesment  }}</th>
										<th>{{ (grandTotalMarks.grade) ? grandTotalMarks.grade : '-' }}</th>
										</td>
									</tr>
								</tfoot>
							</table>
							<form class="mt-3" action=" ">
								<div class="row">
									<div class="col-md-12 text-left">
										<div class="form-group">
											<input type="radio" ng-model="resultStatus" name="allresultStatus" value="approved"> Approve Result
										</div>
										<div class="form-group">
											<input type="radio" ng-model="resultStatus" name="allresultStatus" value="disapproved"> Deny Result
										</div>
										<div class="form-group">
											<textarea class="form-control" ng-model="reason" rows="5" placeholder="Enter your question" required="required"></textarea>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary" ng-click="approveDisapproveResult(term='all',studentExamDetails.studentsList[0].studentID,resultStatus,reason)">Save</button>
										</div>
									</div>

								</div>
							</form>
							</div>
							<div class="saperator-div mb-4">
									<h3>Activities</h3>
									<table class="table table-striped table-bordered table-responsive text-left activity-table">
										<thead class="bg-primary text-white">
										<tr>
											<th class="text-left">{{studentExamDetails.getStudentsActivityFinalResult[0].subject}}</th>
											<th>{{studentExamDetails.getStudentsActivityFinalResult[0].is_beginner}}</th>
											<th>{{studentExamDetails.getStudentsActivityFinalResult[0].is_intermediate}}</th>
											<th>{{studentExamDetails.getStudentsActivityFinalResult[0].is_advanced}}</th>
											<th>{{studentExamDetails.getStudentsActivityFinalResult[0].is_expert}}</th>
											<th>{{studentExamDetails.getStudentsActivityFinalResult[0].remarks}} </th>
										</tr>
										</thead>
										<tbody>
											<tr ng-repeat="activityresult in studentExamDetails.getStudentsActivityFinalResult" ng-if="$index>0"> 
											<td>{{activityresult.subject}}</td>

											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_beginner" ng-change="updateActivities(activityresult,'1','0','0','0')" ng-true-value="'1'" >
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_intermediate" ng-change="updateActivities(activityresult,'0','1','0','0')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_advanced" ng-change="updateActivities(activityresult,'0','0','1','0')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td>
											<label class="form-check-label"><input class="form-check-input" type="checkbox" ng-model="activityresult.is_expert" ng-change="updateActivities(activityresult,'0','0','0','1')" ng-true-value="'1'">
													<span class="checkmark"></span>
												</label>
											</td>
											<td><input type="text" class="form-control" ng-keyup="updateActivities(activityresult,activityresult.is_beginner,activityresult.is_intermediate,activityresult.is_advanced,activityresult.is_expert)" ng-model="activityresult.remarks"></td>

											</tr>
										</tbody>

									</table>
									<table class="table table-striped table-bordered table-responsive text-left mt-4">	
								<tfoot class="bg-dark text-white">
										<tr>
											<th class="text-center" colspan="2" style="color: red;background: white;">Result Status</th>
											<th class="text-center" colspan="3" style="color: blue;background: white;"> {{(studentExamDetails.getStudentsActivityFinalResult[1].is_approved) ? studentExamDetails.getStudentsActivityFinalResult[1].is_approved.toUpperCase() : '-'}}</th>
										</tr>

										<tr ng-if="(studentExamDetails.getStudentsActivityFinalResult[1].is_approved == 'disapproved')">
											<th class="text-center" colspan="2" style="color: red;background: white;">Deny Reason</th>
											<th class="text-center" colspan="2" style="color: orange;background: white;"> {{(studentExamDetails.getStudentsActivityFinalResult[1].reason) ? studentExamDetails.getStudentsActivityFinalResult[1].reason.toUpperCase() : '-'}}</th>
										</tr>


									</tfoot>
								</table>
									<form class="mt-3" action=" ">
								<div class="row">
									<div class="col-md-12 text-left">
										<div class="form-group">
											<input type="radio" ng-model="studentExamDetails.getStudentsActivityFinalResult[1].is_approved" name="allresultStatus" value="approved"> Approve Result
										</div>
										<div class="form-group">
											<input type="radio" ng-model="studentExamDetails.getStudentsActivityFinalResult[1].is_approved" name="allresultStatus" value="disapproved"> Deny Result
										</div>
										<div class="form-group">
											<textarea class="form-control" ng-model="studentExamDetails.getStudentsActivityFinalResult[1].is_approved" rows="5" placeholder="Enter your question" required="required"></textarea>
										</div>
										<div class="form-group">
											<button type="button" class="btn btn-primary" ng-click="approveDisapproveActivityResult(studentExamDetails.getStudentsActivityFinalResult[1])">Save</button>
										</div>
									</div>

								</div>
							</form>
							</div>
						
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>