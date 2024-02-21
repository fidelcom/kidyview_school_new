<?php 
	$schoolDetail 	= $this->session->all_userdata();
	// echo "<pre>"; print_r($schoolDetail); die;
	$schoolID 		= $schoolDetail['user_data']['id'];
	$schoolPhoto 	= $schoolDetail['user_data']['pic'];
	$schoolName 	= $schoolDetail['user_data']['school_name'];
	$schoolEmail 	= $schoolDetail['user_data']['email'];
?>
<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-calendar"></i>
							</div>
							<div class="page-title mt-2">
								<h5>Add Schedule</h5>
							</div>
						</div>
						<!--<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								 <a href="add-school.html" class="btn btn-primary">Add School</a>
								<a href="#" class="btn btn-primary">Add School</a>
							</div>
						</div> -->
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
									<label>Select School Type <em class="text-danger">*</em></label>
								</div>
								<div class="col-md-6 pl-0">
									<select ng-model="school_type" class="form-control">
                                        <option ng-repeat="m in schoolTypeList" ng-value="m.value">{{m.name}}</option>
                                    </select>
								</div>
							</div>
							
							<div class="row form-group">
								<div class="col-md-3 pr-0">
									<label>No. of Lectures<em class="text-danger">*</em></label>
								</div>
								<div class="col-md-6 pl-0">
									<select class="form-control" ng-model="lecture_counts" ng-change="getPeriodTime(lecture_counts)">
										<option ng-repeat="c in lecture_count" value="{{c.count}}">{{c.count}}</option>
									</select>
								</div>
							</div>
							
							<div class="row mt-4 form-group">
								<div class="col-md-3 pr-0"></div>
								<div class="col-md-7 pl-0">
									<div class="lecture_time_list" ng-repeat="x in scheduleTime" >
										
										<div class="lec_list">
											<span>Lecture Name</span>
											<input class="form-control" ng-model="x.name" type="text" name="name" placeholder="Lecture name" required="required">
											<span>{{x.start_level}}</span>
											<input class="form-control" ng-model="x.start_time" type="time" name="start_time" onkeydown="return false">
											<span>{{x.end_level}}</span>
											<input class="form-control" ng-model="x.end_time" type="time" name="end_time" onkeydown="return false">
										</div>
										
									</div>
								</div>
							</div>
							
							<div class="row form-group mt-3">
								<div class="col-md-3 pr-0">
								</div>
								<div class="col-md-6 pl-0">
									<button type="button" class="btn btn-primary" ng-click="createSchedule()">Create</button>
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