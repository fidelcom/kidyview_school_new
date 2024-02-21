<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
							<div class="page-icon">
								<i class="icon-coin-dollar"></i>
							</div>
							<div class="page-title">
								<h5>Revenues</h5>
							</div>
						</div>
						<!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
							<div class="right-actions">
								<a href="#" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="left" title="Download Reports">
									<i class="icon-download4"></i>
								</a> 
							</div>
						</div>-->
					</div>
				</div>
			</header>
			<!-- END: .main-heading -->
			<!-- BEGIN .main-content -->
			<div class="main-content">
				<!-- Row start -->
				<div class="row gutters">
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body bg-pink">
								<div class="stats-widget">
									<div class="stats-widget-body">
										<!-- Row start -->
										<ul class="no-gutters">
											<a class="row d-flex" href="javascript:void(0);">
												<li class="ml-2 mr-4 mt-1">
													<i class="icon-school"></i>
												</li>
												<li class=" ">
													<h3 class="title"><sup>₦</sup>{{graphDatas.totalRevenue}}<small>Total Revenue</small></h3>
												</li>
											</a>
										</ul>
									</div>
									<!-- <div class="stats-widget-header">
										<i class="icon-facebook"></i>
									</div> -->
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body bg-primary">
								<div class="stats-widget">
									<div class="stats-widget-body">
										<!-- Row start -->
										<ul class="no-gutters">
											<a class="row d-flex" href="javascript:void(0);">
											<li class="ml-2 mr-4 mt-1">
												<i class="icon-coin-dollar ic2"></i>
											</li>
											<li class=" ">
												<h3 class="title"><sup>₦</sup>{{graphDatas.current_month_revenue}}<small>This Month Revenue</small></h3>
											</li>
											</a>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
						<div class="card">
							<div class="card-body bg-info">
								<div class="stats-widget">
									<div class="stats-widget-body">
										<!-- Row start -->
										<ul class="no-gutters">
											<a class="row d-flex" href="javascript:void(0);">
											<li class="ml-2 mr-4 mt-1">
												<i class="icon-payment"></i>
											</li>
											<li class=" ">
												<h3 class="title"><sup>₦</sup>{{graphDatas.current_year_revenue}}<small>This Year Revenue</small></h3>
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
							<div class="card-header">Revenues <span class="text-dark">(₦{{graphData.with_day_revenue}})</span>
								<div class="btn-group custom-btn-group float-right" role="group">
									<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==0}"  ng-click="getRevenueGraph('0')">Today</button>
									<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==1}" ng-click="getRevenueGraph('1')">Yesterday</button>
									<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==7}" ng-click="getRevenueGraph('7')">7 Days</button>
									<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==15}" ng-click="getRevenueGraph('15')">15 days</button>
									<button type="button" class="btn btn-outline-primary btn-sm btn-rounded" ng-class="{'getbyday': currclass==30}" ng-click="getRevenueGraph('30')">30 days</button>
								</div>
							</div>
							
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
							</div>
						</div>
					</div>
				</div>
				<!-- Row end -->
			</div>
			<!-- END: .main-content -->
		</div>

<script src="<?php echo base_url(); ?>adminasset/js/morris/morris.min.js"></script>
