<?php 
	$adminDetail 	= $this->session->userdata();
	$adminName 		= $adminDetail['user_data']['full_Name'];
	$adminPhoto 	= $adminDetail['user_data']['photo'];
	
?>
<!-- BEGIN .app-main -->
<div class="app-main test-css">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 d-flex">
					<div class="page-icon">
						<i class="icon-laptop_windows mt-2"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>Dashboard</h5>
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="right-actions">
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
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
				<div class="card">
					<div class="card-body bg-pink">
						<div class="stats-widget">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="javascript:void(0)">
										<li class="ml-2 mr-2 mt-1">
											<i class="icon-school"></i>
										</li>
										<li class=" ">
											<h3 class="title">{{schoolListing.length}}<small>Number of Schools</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
				<div class="card">
					<div class="card-body bg-primary">
						<div class="stats-widget">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="javascript:void(0);">
										<li class="ml-2 mr-2 mt-1">
											<i>
												<img src="<?php echo base_url(); ?>img/nig.png" alt="Naira Currency" />
											</i>
										</li>
										<li class=" ">
											<h3 class="title"><sup>₦</sup>{{revenue}}<small>Total Revenues</small></h3>
										</li>
									</a>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
				<div class="card">
					<div class="card-body bg-info">
						<div class="stats-widget">
							<div class="stats-widget-body">
								<!-- Row start -->
								<ul class="no-gutters">
									<a class="row d-flex" href="javascript:void(0);">
										<li class="ml-2 mr-2 mt-1">
											<i class="icon-payment"></i>
										</li>
										<li class=" ">
											<h3 class="title">{{transaction}}<small>Payments Received</small></h3>
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
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card bg-primary-light">
					<div class="card-header">Revenues <span class="text-dark">(₦{{revenue}})</span>
						<div class="btn-group custom-btn-group float-right" role="group">
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass=='all'}" ng-click="getAllForDashboard('all')" >All</button>
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==0}" ng-click="getAllForDashboard('0')" >Today</button>
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==1}" ng-click="getAllForDashboard('1')">Yesterday</button>
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==7}" ng-click="getAllForDashboard('7')">7 Days</button>
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==15}" ng-click="getAllForDashboard('15')">15 days</button>
							<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==30}" ng-click="getAllForDashboard('30')">30 days</button>
				</div>
					</div>
					<?php /* 
					<div class="card-body">
						<!-- Row start -->
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<div class=" ">
									<div id="barColors" class="chart-height"></div>
								</div>
								<div class="download-details">
									<p>Revenues of last year</p>
								</div>
							</div>
						</div>
						<!-- Row end -->
					</div> */?>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Recent school information</div>
					<div class="card-body">
						<div class="table-responsive white-space-nowrap">
							<table id="schoolinfo" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th data-animate=" animated fadeIn" data-toggle="tooltip" data-original-title="School Name" data-placement="top">School Name</th>
										<th data-animate=" animated fadeIn" data-toggle="tooltip" data-original-title="Email Id" data-placement="top">Email id</th>
										<th data-animate="Address" data-toggle="tooltip" data-original-title="Complete Address" data-placement="top">Address</th>
										<th data-animate="Address" data-toggle="tooltip" data-original-title="City" data-placement="top">City</th>
										<th data-animate="Address" data-toggle="tooltip" data-original-title="Pin Code" data-placement="top">Pin Code</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="school in schoolListing">
										<td>{{school.school_name}}</td>
										<td>{{school.email}}</td>
										<td>{{school.location}}</td>
										<td>{{school.city}}</td>
										<td>{{school.pincode}}</td>
										<td class="text-right action"><a href="#!/school-view/{{school.schoolID}}" alt="{{school.id}}"><i class="icon-eye"></i></a></td>
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
<!-- END: .app-main -->