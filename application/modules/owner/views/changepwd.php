<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-user"></i>
					</div>
					<div class="page-title">
						<h5>Admin Profile</h5>
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
						<a class="nav-link active" id="home-tab" data-toggle="tab" data-target="#home" role="tab" aria-controls="home" aria-selected="true">Update Profile</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" id="profile-tab" data-toggle="tab" data-target="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-12">
								<div class="profileimg">
									<div class="del-prof-img"><i class="icon-trash" ng-click="removeProfilePic()"></i></div>
									<img class="img-fluid img-circle profilePic" src="<?php echo base_url(); ?>img/admin/{{photo}}" alt="User profile" />
								</div>
								<div class="btn-uploadprof">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" type="file">
										<span>Change Picture</span>
									</span>
								</div>
								
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<form>
                                    <div class="form-group">
                                        <label>Full Name</label>
                                        <input type="text" id="profileUserName" ng-model="fullname" class="form-control" />
									</div>
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <input type="email" ng-model="email" class="form-control" readonly />
									</div>
                                    <div class="form-group">
                                        <label>Phone Number</label>
                                        <input type="tel" ng-model="phonenumber" class="form-control" />
									</div>
                                    <div class="form-group">
                                        <label>Location</label>
                                        <input type="text" ng-model="location" class="form-control" />
									</div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" ng-click="updateProfile()">Save Changes</button>
									</div>
								</form>
							</div>
						</div>
					</div>
					<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<div class="col-md-8 col-sm-9 col-xs-10">
							<p ng-show="errormsg != ''" style="color:red; font-size:18px">{{errormsg}}</p>
							<p ng-show="successmsg != ''" style="color:green; font-size:18px">{{successmsg}}</p>
							<form>
								<div class="form-group">
									<label for="oldPassword">Old Password</label>
									<input type="password" ng-model="opsw" class="form-control">
								</div>
								<div class="form-group">
									<label for="newPassword">New Password</label>
									<input type="password" ng-model="npsw" name="psw" class="form-control">
								</div>
								<div class="form-group">
									<button class="btn btn-primary" name="submit" ng-click="changePassword();">Change Now</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>

<script>
    $(document).ready(function() {
		
		
        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
				
                reader.onload = function(e) {
                    $('.profile-pic').attr('src', e.target.result);
				}
				
                reader.readAsDataURL(input.files[0]);
			}
		}
		
		
        $(".file-upload").on('change', function() {
            readURL(this);
		});
		
        $(".upload-button").on('click', function() {
            $(".file-upload").click();
		});
	});
	
</script>
