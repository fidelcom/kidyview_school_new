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
								<h5>Student Attendance</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-student-attendance" class="btn btn-primary"> <i class="icon-plus2"></i> Add Attendance</a>
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
						<h4 class="mb-3">Filter By</h4>
						<div class="row">
							<div class="col-md-4 col-sm-4 col-lg-4 col-12">
								<div class="form-group">
									<div class="controls">
											<select id="select_class" class=" form-control" ng-model="class_id" ng-change="getAllStudentsAttendance()">
												<option value="" selected="selected">Select Class</option>
												<option value="{{cs.id}}" ng-repeat="cs in classList">{{cs.class+" "+cs.section}}</option>
											</select>
									</div>
								</div>
							</div>
						
							<div class="col-md-4 col-sm-4 col-lg-4 col-12">
								<div class="form-group">
									<div class="controls">
										<select class="form-control" ng-model="month" ng-change="getAllStudentsAttendance()">
												<option value="" selected="selected">Select Month</option>
											<option value="{{month.val}}"  ng-repeat="month in monthName">{{month.name}}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-lg-4 col-12">
								<div class="form-group">
									<div class="controls">
										<select class="form-control" ng-model="year" ng-change="getAllStudentsAttendance()">
											 <option value="" selected="selected">Select Year</option>
											 <option value="2020">2020</option>
											 <option value="2021">2021</option>
											<!-- <option value="{{month.val}}"  ng-repeat="month in monthName">{{month.name}}</option> -->
										</select>
									</div>
								</div>
							</div>
						<!-- 	<div class="col-md-3 col-sm-3 col-lg-3 col-12">
								<div class="form-group">
									<div class="controls">
										<button class="btn btn-primary" type="button">Search Now</button>
									</div>
								</div>
							</div> -->
						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div id="school-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="row">
								<div class="col-sm-12">
								<table id="school-listing" class="table school-listing-c table-striped table-bordered table-responsive attendance_table	dataTable no-footer custom-scrollbar" role="grid" aria-describedby="school-listing_info">
									<thead>
										<tr role="row">
											<th class="text-left sorting_asc" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Students: activate to sort column descending" style="width: 139px;">Students</th>
											
											<th  ng-repeat="date in dates" style="width: 20px;">{{ date }}</th>

											<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="31: activate to sort column ascending" style="width: 20px;">Attendace Summary</th>
										</tr>
									</thead>
							<tbody>
								<tr role="row" class="odd" ng-repeat="student in attendanceList">
									<td class="text-left sorting_1">{{student.student}}</td>
										<td ng-repeat="date in student.current_month_dates" class="show-request-msg">
											
											<span ng-repeat="holiday in student.get_holidays_with_name" ng-if="date == holiday.for_date" class="text-danger">
													<b>H</b>
													<div class="custom-request-popup">
														<p>{{holiday.title}}</p>
													</div>
											</span>
											
											<span ng-repeat="attendance in student.studentAttendance" ng-if="date == attendance.date">
													<i class="fas fa-check text-success"></i>									
											</span>
											
										</td>
										
									<td>
										<p><span style="color: blue;">Total Class Days:</span> 
											<span class="text-danger">{{ (student.total_class_days) ? student.total_class_days : '0' }}</span>
										</p>
										<p><span style="color: blue;">Days Attended:</span> 
											<span class="text-success">{{ (student.myTotalAttendance) ? student.myTotalAttendance : '0' }}</span>
										</p>
										<p><span style="color: blue;">Days Absent:</span> 
											<span class="text-danger"> {{(student.total_absent_days) ? student.total_absent_days : '0' }}</span></p>
										
									</td>
								</tr>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
				<!-- Row end -->
	</div>
			<!-- END: .main-content -->
</div>