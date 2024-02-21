<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-dashboard"></i>
							</div>
							<div class="page-title mt-2">
								<h5>Edit Schedule</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<!-- <a href="add-school.html" class="btn btn-primary">Add School</a>
								<a href="#" class="btn btn-primary">Add School</a> -->
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
						<form>
							
							
							<div class="row form-group">
								<div class="col-md-3 pr-0">
									<label>Select School Type</label>
								</div>
								<div class="col-md-6 pl-0">
									<input ng-disabled="true" ng-model="name" type="text" class="form-control">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-3 pr-0">
									<label>No. of Lectures</label>
								</div>
								<div class="col-md-6 pl-0">
									<input ng-disabled="true" ng-model="no_periods" type="text" class="form-control">
								</div>
							</div>
							
							<div class="row mt-4 form-group">
								<div class="col-md-3 pr-0"></div>
								<div class="col-md-7 pl-0">
									<div class="lecture_time_list" ng-repeat="time in scheduletime">
										<div class="lec_list">
											<span>Start Time</span>
											<input class="form-control" type="time" ng-model="time.startTime"/>
											<span>End Time</span>
											<input class="form-control" type="time" ng-model="time.endTime"/>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row form-group mt-3">
								<div class="col-md-3 pr-0">
								</div>
								<div class="col-md-6 pl-0">
									<button type="submit" ng-click="editSchedule(scheduletime,scheduleID)" class="btn btn-primary">Update</button>
									<a href="#!/class-schedule" class="btn btn-danger">Cancel</a>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->