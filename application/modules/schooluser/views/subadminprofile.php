<?php 
$schoolDetail 	= $this->session->all_userdata();
$schoolID 	= $schoolDetail['user_data']['id'];
$schoolPhoto 	= $schoolDetail['user_data']['pic'];
$schoolName 	= $schoolDetail['user_data']['school_name'];
$schoolEmail 	= $schoolDetail['user_data']['email'];
?>
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-office"></i>
					</div>
					<div class="page-title">
						<h5>Profile</h5>
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
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="profile-tab" data-toggle="tab" data-target="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" ng-click="getSchoolDetails()" id="home-tab" data-toggle="tab" data-target="#home" role="tab" aria-controls="home" aria-selected="true">Update Profile</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<p ng-show="errormsg != ''" style="color:red; font-size:18px">{{errormsg}}</p>
                        <p ng-show="successmsg != ''" style="color:green; font-size:18px">{{successmsg}}</p>
						<div class="col-md-8 col-sm-9 col-xs-10">
							<form>
								<div class="form-group">
									<label class="form-label">Old Password</label>
									<div class="controls">
										<input type="password" ng-model="opsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">New Password</label>
									<div class="controls">
										<input type="password" ng-model="npsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Confirm New Password</label>
									<div class="controls">
										<input type="password" ng-model="cpsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary" name="submit" ng-click="changePassword();">Change Now</button>
								</div>
							</form>
						</div>
					</div>
					
					
					<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row">
							<div class="col-md-3 col-sm-4 col-xs-12">
								<div class="profileimg">
									<div class="del-prof-img profileImageHeader"><i class="icon-trash" ng-click="removeProfilePic()"></i></div>
									<img class="img-fluid img-circle" src="<?php echo base_url(); ?>img/school/subadmin/{{pic}}" alt="User profile" />
								</div>
								<div class="btn-uploadprof">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" type="file">
										<span>Change Logo</span>
									</span>
								</div>
							</div>
							<div class="col-md-9 col-sm-8 col-xs-12">
								<form name="myForm">
									<div class="row">
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Name<em>*</em></label>
												<div class="controls">
													<input type="text" class="form-control" id="full-name" value="" ng-model="name">
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Email<em>*</em></label>
												<div class="controls">
                                                                                                    <input type="text" class="form-control" ng-model="email" id="emailid" disabled>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Phone Number<em>*</em></label>
												<div class="controls">
													<input class="form-control" name="phone" type="text" ng-model="phone" ng-intl-tel-input="" data-default-country="in" />
													<span class="help-block" ng-show="myForm.phone.$invalid && myForm.phone.$touched">Invalid</span>
													<span class="help-blockValid ng-hide" ng-show="myForm.phone.$valid && myForm.phone.$touched">Valid</span>
												</div>
											</div>
										</div>
										<div class="col-md-12 col-sm-12 col-xs-12">
											<div class="form-group">
												<label class="form-label">Location<em>*</em></label>
												<div class="controls">
													<textarea type="text" class="form-control" ng-model="address">Address goes here</textarea>
												</div>
											</div>
										</div>										
										<div class="form-group col-md-12">
											<button class="btn btn-primary" ng-disabled="myForm.$invalid" ng-click="updateProfile()">Save Changes</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>