<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
							<div class="page-icon">
								<i class="icon-dashboard mt-2"></i>
							</div>
							<div class="page-title ml-3 align-self-center">
								<h5>View Class Schedule</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<!-- <a href="add-school.html" class="btn btn-primary">Add School</a> -->
								<a href="#!/class-schedule" class="btn btn-primary"><i class="fa fa-backward"></i> Back</a>
							</div>
						</div>
					</div>
				</div>
			</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body full-detail">
						<ul>
							<li><span>School Type :</span> {{ name }}</li>
							<li><span>Lectures Count:</span> {{ no_periods }}</li>
							<li class="date_lact">
								<h4>Lectures Time</h4>
								<div ng-repeat="time in scheduletime track by $index">
									<span>Lectures {{$index+1}}</span> {{time.start_time}} To {{time.end_time}}
								</div>
								
							</li>
						</ul>
					</div>					
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->