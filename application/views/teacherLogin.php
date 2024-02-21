<!doctype html>
<html lang="en" ng-app="KidyviewSchool">
<head>
    <title>Kidyview-Teacher Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content=" " />
    <meta name="keywords" content=" " />
    <meta name="author" content=" " />
    <link rel="shortcut icon" href="<?php echo base_url(); ?>teacherasset/img/favicon.png" />
    <!-- Common CSS -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/fonts/icomoon/icomoon.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/all.css" />
<!-- Global css ----->
    <link href="<?php echo base_url(); ?>teacherasset/css/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url(); ?>teacherasset/css/global.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/intlTelInput.css" />
	<script src="<?php echo base_url(); ?>teacherasset/js/jquery.js"></script>
	<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>
	<style>
	.main-footer{display:none;}
	</style>
</head>

<body ng-controller="teacherloginCtrl" class="login-background" style="background-image: url('<?php echo base_url();?>asset/images/<?php echo $loginImage->bg_image;?>');">
<section class="login_wrapper">			
	<div class="login-container student-login-form">				
		<div class="login-form">					
			<div class="login_Box">						
				<div class="logo_text logo-position">							
					<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>							
				</div>
				<p class="color-red fs14" ng-if="status == 'error' || message!=''">
					{{message}}
				</p>						
				<form name="loginform">							
					<div class="form-group">							
						<label for="user_login">Email Address*</label>								
						<input type="text" name="username" ng-model="username" id="username" class="input">						
					</div>							
					<div class="form-group">								
						<label for="user_pass">Password*</label>								
						<input type="password" name="password" id="password" ng-model="password" class="input">
					</div>							
					<span class="float-right">								
						<a href="javascript:void(0);" data-toggle="modal" data-target="#forgot-password"> Forgot Password?</a>			
					</span>			
					<div class="clearfix"></div>
					<div class="submit mt-2">		 						
						<input type="button" ng-click="loginForStudent()" name="submit" id="sign-in" class="btn btn-accent btn-block" value="Sign In">
					</div>							
				</form>						
			</div>					
		</div>				
						
		<div class="login-image" style="background-image: url('<?php echo base_url();?>asset/images/<?php echo $loginImage->image;?>');"></div>
	</div>	
</section>

<!-- Modal -->
<div id="forgot-password" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">								
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	<h4 class="modal-title">Forgot Password ?</h4>								
			</div>
            <div class="modal-body text-center">
			<p class="color-green fs14" ng-if="sucmessage != ''">
				{{sucmessage}}
			</p>
			<p class="color-red fs14" ng-if="errmessage != ''">
				{{errmessage}}
			</p>
			<span class="mb-2">Enter your Email to get your password.</span>
				<div class="clearfix"></div>
                <form class="mt-2" name="forgotPassform">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control text-center" name="email" ng-model="email" placeholder="Enter Your Email" />
						<span class="color-red fs12 error_span" ng-show="forgotPassform.email.$error.required">Email Address is required.</span>
					</div>
                    <div class="form-group btn-inline">
                        <button type="submit" ng-click="forgotPasswordStudent(email)"  class="btn btn-primary" />Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Otp Modal -->
	<!-- BEGIN .main-footer -->
	<footer class="main-footer fixed-btm">
		Copyright kidyview 2019.
	</footer>
	<!-- END: .main-footer -->
</div>
<!-- END: .app-wrap -->

    
<script src="<?php echo base_url(); ?>teacherasset/js/tether.min.js"></script>
<script src="<?php echo base_url(); ?>teacherasset/js/bootstrap.min.js"></script>
<script>
    var BASE_URL = "<?php base_url(); ?>";
	'use strict';
	angular.module('KidyviewSchool', []).controller('teacherloginCtrl', function($scope, $http, $window) {

		var xapikey   = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
		$scope.username = '';
		$scope.password = '';
		$scope.loginForStudent = function() {
			
			if($scope.username == '')
			{
				$scope.message = 'Email Address is required.';
				return false;
			}
			else if($scope.password == '')
			{
				$scope.message = 'Password is required.';
				return false;
			}
			var formData = {
				"username": $scope.username,
				"password": $scope.password
			};
			$http.post(BASE_URL + 'api/teachers/auth/validateTeacherLogin', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key':xapikey
				}
				}).then(function(response) {
				if (response.status == 200) {
					$scope.errormsg='';
					$window.location.href = BASE_URL + 'teacher';
				}
				}, function(error) {
				$scope.status = "error";
				$scope.message = error.data.message;
			});
			
		}
		
		$scope.email='';
		$scope.forgotPasswordStudent = function(email) {
			if($scope.email == '')
			{
				$scope.errmessage = 'Please enter your user name.';
				return false;
			}
			var formData = {
				"email": email
			};
			$http.post(BASE_URL + 'api/teachers/auth/forget_passwordForTeacher', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key':xapikey
				}
				}).then(function(response) {
				if (response.status == 200) {
					$scope.errmessage = "";
					$scope.sucmessage = "Reset Password Mail has been sent on your parent email id.";
				}
				}, function(error) {
					console.log(error);
				$scope.status = "error";
				$scope.sucmessage = "";
				$scope.errmessage = error.data.message;
			});
			
		}
	});
	
</script>
	
</body>
</html>