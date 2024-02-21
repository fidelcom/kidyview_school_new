<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-file-text"></i>
							</div>
							<div class="page-title">
								<h5>Add Student Attendance</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/student-attendance" class="btn btn-primary"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
							</div>
						</div> 
					</div>
				</div>
			</header>
			<!-- END: .main-heading -->
			<!-- BEGIN .main-content -->
			<!-- <div class="main-content">
				<div class="card">
					<div class="card-body">
						<form>
							<div class="row">
							 	<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Class</label>
										<div class="controls">
											<select id="select_class" class=" form-control"ng-model="class_id"ng-change="getClassStudents()">
												<option value="{{cs.id}}" ng-repeat="cs in classList">{{cs.class+" "+cs.section}}</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Students</label>
										
										<div class="controls">
												<ui-select multiple ng-model="multiStudents.studentID" ng-disabled="multiStudents.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;" required="required">
													<ui-select-match placeholder="Select Students">{{$item.label}}</ui-select-match>
													<ui-select-choices repeat="c in students | propsFilter:{label:$select.search}">
														<div>{{c.label}} </div>
													</ui-select-choices>
												</ui-select>
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Date</label>
										<div class="controls">
											<input type="date" class="form-control" ng-model="attendance_date" id="driver-name">
										</div>
									</div>
								</div>
							
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
										<input class="btn btn-primary" type="button"  ng-click="addStudentAttendance()" name="submit" value="Submit">
										<input class="btn btn-info" type="reset" value="Reset">
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
				
			</div> -->
			<!-- END: .main-content -->


			<!-- BEGIN .main-content -->
			<div class="main-content">
				<div class="card">
					<div class="card-body">
						<form action="driver-device-listing.html">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Class</label>
										<div class="controls">
											<select id="select_class" class=" form-control"ng-model="class_id"ng-change="getClassStudents()">
												<option value="{{cs.id}}" ng-repeat="cs in classList">{{cs.class+" "+cs.section}}</option>
											</select>
										</div>
									</div>
								</div>

								<!-- <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Students</label>
										
										<div class="controls">
												<ui-select multiple ng-model="multiStudents.studentID" ng-disabled="multiStudents.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;" required="required">
													<ui-select-match placeholder="Select Students">{{$item.label}}</ui-select-match>
													<ui-select-choices repeat="c in students | propsFilter:{label:$select.search}">
														<div>{{c.label}} </div>
													</ui-select-choices>
												</ui-select>
										</div>
									</div>
								</div> -->
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Date</label>
										<div class="controls">
											<input type="date" class="form-control" id="driver-name" ng-model="attendance_date" required="required" max="<?php echo date("Y-m-d"); ?>">
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div id="class_one" class="attendance-b-table">
										<div id="school-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
											<div class="row">
												<div class="col-sm-12">
											<table id="school-listing" datatable="ng" class="table table-striped table-bordered table-responsive">
											<thead>
												<tr>
													<th class="text-left sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Teacher Name: activate to sort column ascending" style="width: 189px;">Student Name</th>
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="
															Check In
													
													: activate to sort column ascending" style="width: 166px;">
														<label class="form-check-label d-inline-block w-auto">
															<!-- <input class="form-check-input" type="checkbox"> -->
															 <input type="checkbox" ng-model="model.allCheckedInItemsSelected" ng-change="selectAllCheckedIn()"  required="required" />
															<span class="checkmark"></span>Check In
														</label>
													</th>
													<th class="sorting_desc" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="
															Check Out
													: activate to sort column ascending" style="width: 186px;" aria-sort="descending">
														<label class="form-check-label d-inline-block w-auto">
															<input type="checkbox" ng-model="model.allCheckedOutItemsSelected" ng-change="selectAllCheckedOut()" required="required">
															<span class="checkmark"></span>Check Out
														</label>
													</th>
												</tr>
											</thead>
											<tbody>

												<tr ng-repeat="val in model.classStudents" >
										
													<td class="text-left">  {{val.child}}</td>

													<input type="hidden" mg-model="attendance_date" name="attendance_date">
													<td class="">
														<label class="form-check-label">
															<input 
															class="form-check-input" 
															type="checkbox" 
															ng-model="val.checkin_status" 
															ng-true-value="true" 
															ng-false-value="false" 
															ng-change="selectPartialCheckedinAttendance(val.checkin_status)"  
															ng-class="{selected: val.checkin_status}">
															<span class="checkmark"></span>
														</label>
													</td>
													<td class="sorting_1">
														<label class="form-check-label">
															<input 
															class="form-check-input" 
															type="checkbox" 
															ng-model="val.checkout_status" 
															ng-true-value="true" 
															ng-false-value="false" 
															ng-change="selectPartialCheckoutAttendance(val.checkout_status)"  
															ng-class="{selected: val.checkout_status}"
															>
															<span class="checkmark"></span>
														</label>
													</td> 
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
										<input class="btn btn-primary" type="button"  value="Submit" ng-click="studentAttendanceData()">
										<input class="btn btn-info" type="reset" value="Reset">
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
				<!-- Row end -->
			</div>
			<!-- END: .main-content -->
		</div>