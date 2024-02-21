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
								<div class="col-md-3">
									<label>Select School Type</label>
								</div>
								<div class="col-md-9">
									<input ng-disabled="true" ng-model="name" type="text" class="form-control">
								</div>
							</div>

							<div class="row form-group">
								<div class="col-md-3">
									<label>No. of Lectures</label>
								</div>
								<div class="col-md-9">
									<input ng-disabled="true" ng-model="no_periods" type="text" class="form-control">
								</div>
							</div>
							
							<div class="row mt-4 form-group">
								<div class="col-md-3"></div>
								<div class="col-md-9">
									<div class="lecture_time_list update-lec-list" ng-repeat="time in scheduletime">
										<div class="lec_list">
											<div class="row">
												<div class="col-md-4">
													<div class="form-group">
														<label><span>Start Time</span></label>
														<input class="form-control" type="time" ng-model="time.startTime" onkeydown="return false"/>
													</div>
												</div>
												<div class="col-md-4">
													<label><span>End Time</span></label>
													<input class="form-control" type="time" ng-model="time.endTime" onkeydown="return false"/>
												</div>
												<div class="col-md-4">
													<label><span>Lecture Name</span></label>
													<input class="form-control" type="text" ng-model="time.lectName"/>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div> 
							
							<div class="row form-group mt-3">
								<div class="col-md-3">
								</div>
								<div class="col-md-6">
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