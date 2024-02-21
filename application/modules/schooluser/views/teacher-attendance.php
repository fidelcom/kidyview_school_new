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
								<h5>Teacher Attendance</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-teacher-attendance" class="btn btn-primary"> <i class="icon-plus2"></i> Add Attendance</a>
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
						<h4 class="mb-3">Search</h4>
						<div class="row">
						
								<div class="col-md-4 col-sm-4 col-lg-4 col-12">
								<div class="form-group">
									<div class="controls">
										<select class="form-control" ng-model="month" ng-change="getAllTeachersAttendance()">
												<option value="" selected="selected">Select Month</option>
											<option value="{{month.val}}"  ng-repeat="month in monthName">{{month.name}}</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-md-4 col-sm-4 col-lg-4 col-12">
								<div class="form-group">
									<div class="controls">
										<select class="form-control" ng-model="year" ng-change="getAllTeachersAttendance()">
											 <option value="" selected="selected">Select Year</option>
											 <option value="2020">2020</option>
											 <option value="2021">2021</option>
											<!-- <option value="{{month.val}}"  ng-repeat="month in monthName">{{month.name}}</option> -->
										</select>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="card">
					<div class="card-body">
						<div id="school-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
							<div class="row">
								<div class="col-sm-12">
									<table id="school-listing" ng="datatable" class="table school-listing-c table-striped table-bordered table-responsive attendance_table dataTable no-footer custom-scrollbar" role="grid" aria-describedby="school-listing_info">
									<thead>
										<tr role="row">
											<th class="text-left sorting_asc" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Students: activate to sort column descending" style="width: 139px;">Teachers</th>
											
											<th  ng-repeat="date in dates" style="width: 20px;">{{ date }}</th>

											<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="31: activate to sort column ascending" style="width: 20px;">Attendace Summary</th>
										</tr>
									</thead>
							<tbody>

								<tr role="row" class="odd" ng-repeat="teacher in teacherAttendance" ng-if="teacherAttendance.length > '0' ">
									<td class="text-left sorting_1">{{teacher.teacher}}</td>
								<!-- <div class="loading-spiner" ng-if="(loading == 'true') && teacherAttendance.length == '0' "><img src="http://www.nasa.gov/multimedia/videogallery/ajax-loader.gif" /> </div> -->
										<td ng-repeat="date in teacher.current_month_dates" class="show-request-msg">

											<span ng-repeat="holiday in teacher.get_holidays_with_name"  class="text-danger">
												
												<span ng-if="date == holiday.for_date">
													<b>H</b>
													<div class="custom-request-popup">
														<p>{{holiday.title}}</p>
													</div>
												</span>

												

											</span>
											
											<span ng-repeat="attendance in teacher.teacherAttendance" ng-if="date == attendance.date">
												<i class="fas fa-check text-success"></i>
												<div class="custom-request-popup">
													<p>Chech-in time : {{attendance.checkin_time}}</p>
													<p>Chech-out time : {{attendance.checkout_time}}</p>
												</div>	
											</span>	

											<!-- <span ng-init="checkOnlyAttendance(date,teacher.teacher_id,attendance.date)">
														<i class="fas fa-check text-success"></i>
														<i class="fas fa-times text-warning"></i>	
														<div class="custom-request-popup">
															<p>{{'Absent'}}</p>
														</div>
											</span> -->

											<!-- <span ng-repeat="absent in teacher.teacherAbsentDates">
												<span   ng-if=" (date == absent)">
													<i class="fas fa-times text-warning"></i>	
														<div class="custom-request-popup">
															<p>{{'Absent'}}</p>
														</div>
												</span>
											</span>	 -->



											<!-- <span ng-repeat="absent in teacher.teacherAbsentDates">
												<span  ng-repeat="attendance in teacher.teacherAttendance" ng-if="(date == attendance.date) && (date == absent)">
													
												</span>
											</span>	
											<span ng-repeat="absent in teacher.teacherAbsentDates">
												<span  ng-repeat="attendance in teacher.teacherAttendance" ng-if="(date != attendance.date) && (date == absent)">
													<i class="fas fa-times text-warning"></i>	
														<div class="custom-request-popup">
															<p>{{'Absent'}}</p>
														</div>
												</span>
											</span>	 -->

										</td>
										
									<td>
										<p><span style="color: blue;">Total Class Days:</span> 
											<span class="text-danger">{{ (teacher.total_class_days) ? teacher.total_class_days : '0' }}</span>
										</p>
										<p><span style="color: blue;">Days Attended:</span> 
											<span class="text-success">{{ (teacher.myTotalAttendance) ? teacher.myTotalAttendance : '0' }}</span>
										</p>
										<p><span style="color: blue;">Days Absent:</span> 
											<span class="text-danger"> {{(teacher.total_absent_days) ? teacher.total_absent_days : '0' }}</span></p>
										
									</td>
								</tr>
								<tr role="row" class="odd"  ng-if="teacherAttendance.length == '0' ">
									<td colspan="{{colspan}}" class="text-center">No record found.</td>
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