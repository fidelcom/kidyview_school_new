
<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-user-plus"></i>
							</div>
							<div class="page-title">
								<h5>Online Assessment</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-exam" class="btn btn-primary"> <i class="icon-plus2"></i> Create</a>
							</div>
						</div>
					</div>
				</div>
	</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body">
						<table id="myTable" datatable="ng" class="table table-striped table-bordered table-responsive custom-scrollbar">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Assessment Name</th>
										<th>Class</th>
										<th>Subject</th>
										<th>Assessment Date</th>
										<th>Last Date</th>
										<!-- <th>Assessment Time</th>
										<th>Duration (Min.)</th> -->
										<th>Type</th>
										<!-- <th>Category</th> -->
										<!-- <th>Session</th> -->
										<th>Status</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
								<tr ng-repeat="exam in examList">

										<td>{{$index+1}}</td>
										<td>{{exam.name}}</td>
										<td>{{exam.class}} - {{exam.section}} </td>
										<td>{{exam.subject}}</td>
										<td>{{exam.exam_date}}</td>
										<td>{{exam.last_submission_date}}</td>
										<!-- <td>{{exam.exam_time}}</td> -->
										<!-- <td>{{exam.exam_duration}}</td> -->
										<td>{{exam.exam_mode}}</td>
										<!-- <td>{{exam.exam_category}}</td> -->
										<!-- <td>{{exam.session}}</td> -->
										<td ng-if="(exam.exam_date_time <= exam.current_datetime) && (exam.exam_last_datetime >= exam.current_datetime)"><span class="badge label-success text-center">OnGoing</span></td>
										<td ng-if="(exam.exam_date_time > exam.current_datetime) && (exam.exam_last_datetime > exam.current_datetime)"><span class="badge label-warning text-center">Not Started</span></td>
										<td ng-if="(exam.exam_last_datetime < exam.current_datetime) && (exam.exam_date_time < exam.current_datetime)"><span class="badge label-danger text-center">Locked</span></td>
										<td class="action text-right">
											<button ng-click="unlockExam(exam)" ng-if="exam.exam_date_time < exam.current_datetime" title="Exam Unlock"><i class="fas fa-unlock"></i></button>

											<a href="#!/questions/{{exam.id}}" data-toggle="tooltip" data-original-title="Add Question" data-placement="top"><i class="fas fa-plus"></i></a>
											<a href="#!/edit-exam/{{exam.id}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top" ng-if="exam.exam_date_time > exam.current_datetime"><i class="icon-edit2"></i></a>
											<a href="#!/details-exam/{{exam.id}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
											<a ng-click="examDelete(exam.exam_id)" title="Delete" ng-if="exam.exam_date_time > exam.current_datetime"><i class="icon-trash" ></i></a>
										</td>
									</tr>	
								</tbody>
							</table>
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->



			<!-- Modal -->
	  <div class="modal fade custom_modal" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Select Student For Unlock Exam</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Exam List</label>
						</div>
						<div class="col-md-8">
							 	<select class="form-control" ng-model="unlockData.exam_id" required="required">
							 		<option value="">Select Exam</option>
							 		<option value="{{unlockData.exam_id}}">{{unlockData.name}}</option>
							 	</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Students List</label>
						</div>
						<div class="col-md-8">
							<ui-select multiple ng-model="unlockData.studentID" ng-disabled="unlockData.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;" required="required">
								<ui-select-match placeholder="Select Students">{{$item.stud_name}}</ui-select-match>
								<ui-select-choices repeat="student in studentList | propsFilter:{stud_name:$select.search}">
									<div>{{student.stud_name}} </div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					 
					<div class="row form-group mt-3">
						<div class="col-md-4">
						</div>
						<div class="col-md-8">
							<button ng-click="unlockExamForUsers()" class="btn btn-primary">Submit</button>
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	  </div>

</div>
<!-- END: .app-main-->