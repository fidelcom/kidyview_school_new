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
								<h5>Add Teacher Attendance</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								 <a href="#!/teacher-attendance" class="btn btn-primary"> <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
						<form action="driver-device-listing.html">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">School Type</label>
										<div class="controls">
											<select ng-model="schoolType" class="form-control" ng-change="getTeachersBySchoolType()" ng-options="option.value as option.name for option in schoolTypeList">
		                                        <option selected="selected" value="">Select School Type</option>
		                                    </select>
										
										</div>
									</div>
								</div>
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
													<th class="text-left sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Teacher Name: activate to sort column ascending" style="width: 189px;">Teacher Name</th>
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
													</th><th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Check In Time: activate to sort column ascending" style="width: 192px;">Check In Time</th><th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Check Out Time: activate to sort column ascending" style="width: 206px;">Check Out Time</th></tr>
											</thead>
											<tbody>

												<tr ng-repeat="val in model.teachersList" >
										
													<td class="text-left">  {{val.teacher}}</td>

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
													<td>
														<input type="time" class="form-control time-control" ng-model="val.checkin_time">
													</td>
													
													<td>
														<input type="time" class="form-control time-control" ng-model="val.checkout_time">
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
										<input class="btn btn-primary" type="button"  value="Submit" ng-click="teacherAttendanceData()">
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