<?php 
	$schoolDetail 	= $this->session->all_userdata();
	$schoolID 		= $schoolDetail['user_data']['id'];
	$schoolPhoto 	= $schoolDetail['user_data']['pic'];
	$schoolName 	= $schoolDetail['user_data']['school_name'];
	$schoolEmail 	= $schoolDetail['user_data']['email'];
?>
<div class="app-main">
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
					<div class="page-icon">
						<i class="icon-laptop_windows"></i>
					</div>
					<div class="page-title">
						<h5 class="username"><?=$schoolName ?></h5>
						<h6 class="sub-heading">Dashboard</h6>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<!-- Row start -->
		<div class="row gutters dashboard-head">
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
				<div class="card">
					<div class="card-body bg-primary small-box">
						<div class="stats-widget ">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="#!/parent-list">
										<li class="ml-2 mr-2 mt-1">
											<i class="icon-school ic2"></i>
										</li>
										<li class=" ">
											<h3 class="title">{{studentList.length}}<small>Total Number Of Students</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
				<div class="card">
					<div class="card-body bg-pink small-box">
						<div class="stats-widget ">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="#!/teacher-list">
										<li class="ml-2 mr-2 mt-1">
											<i class="icon-user-tie"></i>
										</li>
										<li class=" ">
											<h3 class="title">{{teacherList.length}}<small>Total Number Of Teachers</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
				<div class="card">
					<div class="card-body bg-info small-box">
						<div class="stats-widget ">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="#!/driver-list">
										<li class="ml-2 mr-2 mt-1">
											<i class="fas fa-car"></i>
										</li>
										<li class=" ">
											<h3 class="title">{{driverList.length}}<small>Total Number Of Drivers</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6">
				<div class="card">
					<div class="card-body bg-success small-box">
						<div class="stats-widget ">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="javascript:void(0);">
										<li class="ml-2 mr-2 mt-1">
											<i>
												<img src="<?php echo base_url(); ?>img/nig.png" alt="Naira Currency" />
											</i>
										</li>
										<li class="">
											<h3 class="title">{{sumfees}}<small>Total Fees</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
		<!-- Row start -->
		
		<div class="row same-height-card">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card dataTables_wrapper">
					<div class="card-header f20"><i class="icon-user-plus mr-1"></i> Parents
						<span class="float-right">
							<a href="javascript:void(0);">
								<i class="icon-eye2"></i>
							</a>
						</span>
					</div>
					<div class="card-body small-font">
						<div class="table-responsive">
						<table id="inbox-table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Father Name</th>
									<th>Mother Name</th>
									<th>Guardian Name</th>
									<th>Address</th>
									<th>Email</th>
									<th>Phone</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr dir-paginate="parent in parentList|itemsPerPage:5">
									<td>{{$index + 1}}</td>
									<td>{{parent.fatherfname}} {{parent.fatherlname}}</td>
									<td>{{parent.motherfname}} {{parent.motherlname}}</td>
									<td>{{parent.guardianfname}} {{parent.guardianlname}}</td>
									<td>{{parent.fatheraddress}}</td>
									<td>{{parent.fatheremail}}</td>
									<td>{{parent.fatherphone}}</td>
									<td class="action">
										<a href="#!/parent-detail/{{parent.parentID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
									</td>
								</tr>															
							</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
				<div class="card dataTables_wrapper update-card-wrapper h-100">
					<div class="card-header f20"><i class="icon-user-tie mr-1"></i> Teacher
						<span class="float-right">
							<a href="javascript:void(0);">
								<i class="icon-eye2"></i>
							</a>
						</span>
					</div>
					<div class="card-body small-font">
						<div class="table-responsive tb-overflow">
							<table id="inbox-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Name</th>
										<!--<th>Email</th>
										<th>Spouse/Father Name</th>-->
										<th>Subject</th>
										<th>Phone</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr dir-paginate="teacher in teacherList|itemsPerPage:5">
										<td>{{$index + 1}}</td>
										<td>{{teacher.teacherfname}} {{teacher.teachermname}} {{teacher.teacherlname}}</td>
										<!--<td>{{teacher.teacheremail}}</td>
										<td>{{teacher.spousename}}</td>-->
										<td>{{teacher.subjectteacher}}</td>
										<td>{{teacher.teacherphone}}</td>
										<td class="action">
											<a href="#!/teacher-detail/{{teacher.teacherID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
				<div class="card dataTables_wrapper update-card-wrapper h-100">
					<div class="card-header f20"><i class="icon-calendar3 mr-1"></i> Events
						<span class="float-right">
							<a href="javascript:void(0);">
								<i class="icon-eye2"></i>
							</a>
						</span>
					</div>
					<div class="card-body small-font">
						<div class="table-responsive">
						<table id="events-table" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Event Name" data-placement="top">Event Name</th>
									<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Time" data-placement="top">Time</th>
									<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Message" data-placement="top">Event Type</th>
									<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Action" data-placement="top">Action</th>
								</tr>
								</thead>
								<tbody>
									<tr dir-paginate="event in eventList|itemsPerPage:5">
										<td>{{event.title}}</td>
										<td class="nowrap">{{event.formattedDate}}</td>
										<td ng-show="event.is_paid == '0'">Free</td>
										<td ng-show="event.is_paid == '1'">Paid</td>
										<td class="action"><a href="#!/event-detail/{{event.eventID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
					<div class="card dataTables_wrapper update-card-wrapper h-100">
						<div class="card-header f20"><i class="icon-cake mr-1"></i> Student's Birthday
							<span class="float-right">
								<a href="javascript:void(0);">
									<i class="icon-eye2"></i>
								</a>
							</span>
						</div>
						<div class="card-body small-font">
							<div class="table-responsive">
							<table id="birthday-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Student Name" data-placement="top">Student Name</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Parents Name" data-placement="top">Father's Name</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Std. & Sec." data-placement="top">Std. & Sec.</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Date" data-placement="top">Date</th>
									</tr>
								</thead>
								<tbody>
									<tr dir-paginate="student in studentList|itemsPerPage:5">
										<td>{{student.childfname}} {{student.childlname}}</td>
										<td>{{student.fatherfname}} {{student.fatherlname}}</td>
										<td>{{student.childclass}}, {{student.childsection}}</td>
										<td>{{student.formattedDOB}}</td>
									</tr>
								</tbody>
							</table>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-3">
					<div class="card dataTables_wrapper update-card-wrapper h-100">
						<div class="card-header f20"><i class="icon-news mr-1"></i> Article
							<span class="float-right">
								<a href="javascript:void(0);">
									<i class="icon-eye2"></i>
								</a>
							</span>
						</div>
						<div class="card-body small-font">
							<div class="table-responsive">
							<table id="artical-table" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Artical" data-placement="top">Artical</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Complete Address" data-placement="top">Posted By</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Posted By" data-placement="top">Date</th>
										<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Action" data-placement="top">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>scrapbook workshop</td>
										<td>Admin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>Halloween paprty</td>
										<td>subadmin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>scrapbook workshop</td>
										<td>Parent</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>make & take</td>
										<td>subadmin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>scrapbook workshop</td>
										<td>Admin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>Halloween paprty</td>
										<td>subadmin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void0;" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
									</tr>
									<tr>
										<td>Halloween paprty</td>
										<td>subadmin</td>
										<td>12-11-2019</td>
										<td class="action"><a href="javascript:void(0);" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a></td>
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
</div>