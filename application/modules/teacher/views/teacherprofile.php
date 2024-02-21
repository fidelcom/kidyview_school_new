
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
						<a class="nav-link" id="home-tab" data-toggle="tab" data-target="#home" role="tab" aria-controls="home" aria-selected="true">View Profile</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<p ng-show="errormsg != ''" style="color:red; font-size:18px">{{errormsg}}</p>
                        <p ng-show="successmsg != ''" style="color:green; font-size:18px">{{successmsg}}</p>
						<form class="teacher-profile-fm">
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
					<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row">
							<div class="col-md-4 col-lg-3 col-sm-12 col-xs-12">
								<div class="profileimg">
									<div ng-show="teacherData.teacherphoto != ''" class="del-prof-img profileImageHeader"><i class="icon-trash" ng-click="removeProfilePic(teacherData)"></i></div>
									<img ng-show="teacherData.teacherphoto != ''" class="img-fluid" src="<?=base_url();?>img/teacher/{{teacherData.teacherphoto}}" alt="Teacher Photo" />
									<img ng-show="teacherData.teacherphoto == ''" class="img-fluid" src="<?= base_url(); ?>img/default-profilePic.png" />
								</div>
								<div class="btn-uploadprof mt-2">
									<span>
										<i class="icon-camera-outline"></i>
										<input type="file" onchange="angular.element(this).scope().ImageUpload(this)" class="file-upload ng-pristine ng-valid ng-touched ng-empty" id="pic">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
							<div class="col-md-8 col-lg-9 col-sm-12 col-xs-12">
								<div class="full-detail mt-2">
									<ul>
										<li><span>Name:</span>{{teacherData.teachername}}</li>
										<li><span>Email Id:</span> {{teacherData.teacheremail?teacherData.teacheremail:'N/A'}}</li>
										<li><span>Phone Number:</span> {{teacherData.teacherphone?teacherData.teacherphone:'N/A'}}</li>
										<li><span>Subjects:</span> {{teacherData.subject?teacherData.subject:'N/A'}}</li>
										<li><span>Class Teacher:</span> {{teacherData.assignclass?teacherData.assignclass:'N/A'}}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!--tab2-->
				</div>
			</div>
			<!-- Row end -->
		</div>
		<!-- END: .main-content -->
	</div>