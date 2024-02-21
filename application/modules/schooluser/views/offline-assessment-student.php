<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="fas fa-book-reader"></i>
					</div>
					<div class="page-title">
						<h5>Offline Assessment Student List
						<a class="btn btn-secondary" href="#!/offline-assessment" class="btn btn-primary float-right"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back To List</a>

						</h5>
						<!-- <a href="#!/offline-assessment" class="btn btn-primary float-right">Back</a> -->
					</div>
				</div>
		
			</div>
		</div>
	</header>
	<!-- BEGIN .main-content -->
		<div class="main-content">
				<div class="card">
					<div class="card-body offline-exam-card">
						<div class="row no-gutters">
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Exam Name</div>
									<hr>
									<div class="examDtl mb-0">{{name}}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Class</div>
									<hr>
									<div class="examDtl mb-0">{{class}}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Subject</div>
									<hr>
									<div class="examDtl mb-0">{{subject}}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Total Marks</div>
									<hr>
									<div class="examDtl mb-0">{{total_marks}}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Exam Date</div>
									<hr>
									<div class="examDtl mb-0">{{ exam_date }}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Submission Date</div>
									<hr>
									<div class="examDtl mb-0">{{ last_submission_date }}</div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Exam Time</div>
									<hr>
									<div class="examDtl mb-0">{{ exam_time }}</div>
								</div>
							</div>
							
							<div class="col-md-3">
								<div class="bg-light">
									<div class="h6">Duration</div>
									<hr>
									<div class="examDtl mb-0">{{ exam_duration +' Mins' }}</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="bg-light">
									<div class="h6">Instructions</div>
									<hr>
									<div class="examDtl mb-0">{{ exam_instruction }}</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="card">
					<div class="card-body">
						<!-- <form class="form-inline float-left mb-0 mb-md-3">
							<div class="">
								<input type="text" ng-model="search" class="form-control" placeholder="Search">
							</div>
						</form> -->
						<span ng-if="( last_submission_datetime >= current_datetime) || ( marks_validity_extends < current_datetime)" class="text-danger text-center" >Please wait untill submission date not expired or Validity Expired. To allocate marks.</span>
						

							<table datatable="ng" class="table table-striped table-bordered table-responsive">
								<thead>
									<tr>
										<th>Registration Id</th>
										<th>Student Name</th>
										<th>Total Marks</th>
										<!-- <th>Marks Obtain</th> -->
										<th>Add Mark</th>
										<!-- <th>Mark Status</th> -->
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr  ng-repeat="student in classStudents">
										
										<td class="sorting">{{ student.childRegisterId }} </td>
										<td class="sorting">{{ student.child }}</td>
										<td class="sorting">{{ total_marks }}  </td>
										<!-- <td>
											<span ng-if="user_id == student.child_id">
												{{ myMarksObtained ? myMarksObtained : '-' }}
											</span>
											<span ng-if="user_id != student.child_id">
												{{  '-' }}
											</span>
										</td> -->
										<!-- <td>{{ marks_obtained ? marks_obtained : '-' }}</td> -->

										<td ng-if="( last_submission_datetime < current_datetime) && ( marks_validity_extends >= current_datetime )">
											
												<input type="text" numericonly ng-model="student.marks_obtain" name="marks_obtain" placeholder="marks" style="width: 80px;" />
										</td>
										<!-- <td class="text-success" ng-if="(studentID == student.child_id )">Marked</td> -->

										<td ng-if="( last_submission_datetime >= current_datetime) || ( marks_validity_extends < current_datetime)" colspan="2">
											<span class="text-center text-danger text-bold">-</span>
										</td>
											
										<td class="action text-right" ng-if="( last_submission_datetime < current_datetime ) && ( marks_validity_extends >= current_datetime )">

											<button type="button" class="btn btn-primary" ng-click="marksUpdate(student.child_id,examData,student.marks_obtain)">Update</button>
										</td>
									</tr>
								
								</tbody>
							</table>
						
					<!-- <div ng-if="examList.length > 0">
							<div class="clearfix"></div>
								<dir-pagination-controls max-size="10" class="mb-3 float-right" direction-links="true" boundary-links="true">
								</dir-pagination-controls>
								<dir-pagination-controls max-size="10" direction-links="true" class="float-left" boundary-links="true" template-url="<?php echo base_url(); ?>asset/js/dirPagination.tpl.html">
								</dir-pagination-controls>
							</div> -->
						</div>
					</div>
				</div>
				<!-- Row end -->
			
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
<!-- END: .app-main