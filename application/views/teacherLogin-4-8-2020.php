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

</head>

<body ng-controller="teacherloginCtrl">
<style>
.main-footer{display:none;}
</style>
<body class="login-background">
<section class="login_wrapper">			
	<div class="login-container student-login-form">				
		<div class="login-form">					
			<div class="login_Box">						
				<div class="logo_text logo-position">							
					<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>							
				</div>
				<p ng-if="status == 'error' || message!=''">
					<span style="color:red">
						<span>{{error}}</span>
					</span>
				</p>						
				<form name="loginform">	
					<div class="form-group">							
						<label for="user_login">Phone Number</label>								
						<input type="text" name="phnno" ng-model="phnno" class="input" ng-intl-tel-input="" data-default-country="in">					
					</div>	 OR					
					<div class="form-group">							
						<label for="user_login">Email Address</label>								
						<input type="text" name="email" ng-model="email" id="email" class="input">					
					</div>										
					<div class="clearfix"></div>
					<div class="submit mt-2">		 						
						<input type="button" ng-click="loginForTeacher()" id="sign-in" class="btn btn-accent btn-block" value="VERIFY">
					</div>							
				</form>						
			</div>					
		</div>				
						
		<div class="login-image" style="background:url(<?php echo base_url();?>asset/images/<?php echo $image;?>) no-repeat center;background-size: cover;">					
										
				</div>
	</div>	
</section>

<!-- Otp Modal -->


<div id="otppopup" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
			<div class="modal-header">								
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>	
				<h4 class="modal-title" ng-if="phnno!=''">Verify Mobile Number</h4>
				<h4 class="modal-title" ng-if="email!=''">Verify Email ID</h4>								
			</div>
            <div class="modal-body text-center">
				<div class="success" ng-show="success!=''">{{success}}</div>
				<div class="success" ng-show="otpsuccess!=''">{{otpsuccess}}</div>
	
                <form class="mt-2" method="post" action="choose-subscription.html">
                    <div class="form-group">
                        <input type="text" ng-model="otp" class="form-control text-center" placeholder="Enter OTP Recieved" />
						<div class="error" ng-show="otperror!=''">{{otperror}}</div>
					</div>
                    <div class="form-group">
                        <input type="button" class="btn btn-primary" name="submit" value="SIGNIN" ng-click="verifyotp();" />
				
						<a href="javascript:void(0);" ng-click="resendotp();">Resend OTP</a>
						<div class="success" ng-show="resendsuccess!=''">{{resendsuccess}}</div>
						<div class="error" ng-show="resenderror!=''">{{resenderror}}</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>
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
				angular.module('KidyviewSchool', ['ngIntlTelInput','ngPatternRestrict']).controller('teacherloginCtrl', function($scope, $http, $window) {

					var xapikey   = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
					$scope.email = '';
					$scope.phnno = '';
					
					$scope.loginForTeacher = function() {
						$scope.otperror='';
						$scope.resendsuccess='';
						$scope.success='';
						$scope.error='';
						if($scope.phnno==undefined){
							$scope.error = 'Please check your phone number.';
							return false;
						}
						if($scope.email != '' && $scope.phnno!='')
						{
							$scope.error = 'Please fill any one.';
							return false;
						}
						if($scope.email == '' && $scope.phnno=='')
						{
							$scope.error = 'Email or Phone Number is required.';
							return false;
						}
						var formData = {
							"email": $scope.email,
							"phnno": $scope.phnno
						};
						$http.post(BASE_URL + 'api/teachers/auth/validateTeacherLogin', formData, {
							headers: {
								'Content-type': 'application/json',
								'x-api-key':xapikey
							}
							}).then(function(response) {
								//alert(response.status);
							if (response.status == 200) {
								$scope.error='';
								angular.element("#otppopup").modal('show');
								$scope.success=response.data.message;
								$scope.user_id=response.data.user_id;
							}
							}, function(error) {
							$scope.success='';
							$scope.error=error.data.message;
						});
						
					}
					$scope.verifyotp = function() {
						var formData = {
							"otp": $scope.otp,
							"user_id": $scope.user_id
						};
						$http.post(BASE_URL + 'api/teachers/auth/verifyotp', formData, {
							headers: {
								'Content-type': 'application/json',
								'x-api-key':xapikey
							}
							}).then(function(response) {
							if (response.status == 200) {
								$scope.otperror='';
								$scope.otpsuccess=response.data.message;
								$window.location.href = BASE_URL + 'teacher';	
							}
							}, function(error) {
								$scope.otpsuccess='';
								$scope.otp='';
								$scope.otperror=error.data.message;
								});
					}
					$scope.resendotp = function() {
						var formData = {
							"email": $scope.email,
							"phnno": $scope.phnno
						};
						$http.post(BASE_URL + 'api/teachers/auth/resendotp', formData, {
							headers: {
								'Content-type': 'application/json',
								'x-api-key':xapikey
							}
							}).then(function(response) {
								//alert(response.status);
							if (response.status == 200) {
								$scope.resenderror='';
								$scope.otperror='';
								$scope.resendsuccess=response.data.message;
								$scope.user_id=response.data.user_id;
							}
							}, function(error) {
							$scope.otperror='';
							$scope.resendsuccess='';
							$scope.resenderror=response.data.message;
						});
						
					}
				});
				
			</script>
	<script src="<?php echo base_url(); ?>asset/js/intlTelInput.min.js"></script>
	<script src="<?php echo base_url(); ?>asset/js/utils.js"></script>
	<script src="<?php echo base_url(); ?>asset/js/ng-intl-tel-input.js"></script>
	<script src="<?php echo base_url(); ?>asset/js/ng-pattern-restrict.min.js"></script>
	
</body>
</html>