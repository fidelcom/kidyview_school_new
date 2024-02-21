<!DOCTYPE html>
<html lang="en" ng-app="KidyviewAdmin">	
		
	<head>		
		<meta charset="utf-8">		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">		
		<meta name="description" content="">
		<meta name="author" content="GeeksLabs">		
		<link rel="shortcut icon" href="img/fav.png">		
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>		
		<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>		
		<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>		
		<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>		
		<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>		
		<title>Welcom to Kidy View</title>		
				
		<!-- Bootstrap CSS -->		
		<link href="<?php echo base_url();?>asset/css/bootstrap.min.css" rel="stylesheet">		
		<!-- bootstrap theme -->		
		<!--link href="<?php echo base_url();?>asset/css/bootstrap-theme.css" rel="stylesheet"-->		
		<!--external css-->		
		<!-- font icon -->		
		<link href="<?php echo base_url();?>asset/css/elegant-icons-style.css" rel="stylesheet" />		
		<link href="<?php echo base_url();?>asset/css/font-awesome.min.css" rel="stylesheet" />		
		<!-- Custom styles -->		
		<link href="<?php echo base_url();?>asset/css/style.css" rel="stylesheet">		
		<link href="<?php echo base_url();?>asset/css/responsive.css" rel="stylesheet" />		
				
	</head>	
		
	<body ng-controller="adminloginCtrl" style="background-image: url('<?php echo base_url();?>asset/images/<?php echo $bgimage;?>');">
		<?php 			
			$errorMessage = $this->session->userdata();			
			//print_r($errorMessage);			
		?>		
			
			<?php /* <div class="Logo_Wrapper">			
			<div class="logo_text">			
			<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>			
			</div>			
			</div> */ ?>
	
		<section class="login_wrapper">			
			<div class="login-container">				
				<div class="login-form">					
					<div class="login_Box">						
						<div class="logo_text logo-position">							
							<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>							
						</div>						
						<p class="color-red fs14" ng-if="status == 'error'">
							{{message}}						
						</p>	
						<select class="select-l-input" name="usertype" id="usertype" ng-model="usertype">
						<option value="admin">Admin</value>
						<option value="adminsubadmin">Sub Admin</value>
						</select>					
						<form name="loginform" name="loginform" novalidate>							
							<p>								
								<label for="user_login">Email Address*</label>								
								<input type="email" name="email" ng-model="email" id="email" class="input" required="" />									
								<span class="color-red fs12 error_span" ng-show="loginform.email.$error.required">Email Address is required.</span>									
								<span class="color-red fs12 error_span" ng-show="loginform.email.$error.email">Not a valid email!</span>				
							</p>							
							<p>								
								<label for="user_pass">Password*</label>
								<input type="password" name="password" ng-model="password" id="password" class="input" required="" />
								<span class="color-red fs12 error_span" ng-show="loginform.password.$error.required">Password is required.</span>
								<span class="color-red fs12 error_span" id="wrongPassword"></span>
							</p>							
							<span class="pull-right">								
								<a data-toggle="modal" href="#myModal"> Forgot Password?</a>								
							</span>							
							<p class="submit">								
								<input type="submit" name="submit" id="sign-in" ng-click="loginForAdmin()" class="btn btn-accent btn-block" value="Sign In" />								
							</p>							
						</form>						
					</div>					
				</div>				
								
				<div class="login-image" style="background:url(<?php echo base_url();?>asset/images/<?php echo $image;?>) no-repeat center;background-size: cover;">					
										
				</div>				
								
				<div>					
				</div>				
			</section>			
			<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="1" id="myModal" class="modal Fpass">				
				<div class="modal-dialog">					
					<div class="modal-content">						
						<form name="forgotPassform" class="form">							
							<div class="modal-header">								
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>								
								<h4 class="modal-title">Forgot Password ?</h4>								
							</div>							
							<div class="modal-body">
								<p class="color-green fs12 error_span" ng-if="sucmessage != ''">
									{{sucmessage}}
								</p>
								<p class="color-red fs12 error_span" ng-if="errmessage != ''">
									{{errmessage}}
								</p>								
								<p>Enter your email address to get your password.</p>								
								<input type="email" name="username" ng-model="userName" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix" required="" />								
									<span class="color-red fs12 error_span" ng-show="forgotPassform.username.$error.required">Email Address is required.</span>
									<span class="color-red fs12 error_span" ng-show="forgotPassform.username.$error.email">Not a valid email!</span>
							</div>							
							<div class="modal-footer">
								<button class="btn btn-success" ng-click="forgotPasswordAdmin(userName)" type="submit">Submit</button>								
								<button data-dismiss="modal" class="btn btn-default" type="button">Cancel</button>								
							</div>							
						</form>						
					</div>					
				</div>				
			</div>			
			<!-- modal -->			
			<!-- javascripts -->			
			<script src="<?php echo base_url();?>asset/js/jquery.js"></script>			
			<!-- bootstrap -->			
			<script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>			
			<!-- nice scroll -->			
			<script src="<?php echo base_url();?>asset/js/jquery.scrollTo.min.js"></script>			
			<script src="<?php echo base_url();?>asset/js/jquery.nicescroll.js" type="text/javascript"></script>			
			<!--script src="<?php //echo base_url();?>asset/js/scripts.js"></script-->			
						
			<script type="text/javascript" src="<?php echo base_url();?>asset/js/bootstrap-datetimepicker.js"></script>			
			<script>				
				var BASE_URL = "<?php base_url(); ?>";				
								
			</script>			
			<script type="text/javascript">				
				$('.form_datetime').datetimepicker({					
					//language:  'fr',					
					weekStart: 1,					
					todayBtn: 1,					
					autoclose: 1,					
					todayHighlight: 1,					
					startView: 2,					
					forceParse: 0,					
					showMeridian: 1					
				});				
				$('.form_date').datetimepicker({					
					language: 'fr',					
					weekStart: 1,					
					todayBtn: 1,					
					autoclose: 1,					
					todayHighlight: 1,					
					startView: 2,					
					minView: 2,					
					forceParse: 0					
				});				
				$('.form_time').datetimepicker({					
					language: 'fr',					
					weekStart: 1,					
					todayBtn: 1,					
					autoclose: 1,					
					todayHighlight: 1,					
					startView: 1,					
					minView: 0,					
					maxView: 1,					
					forceParse: 0					
				});				
								
			</script>			
			<script>				
				'use strict';				
				angular.module('KidyviewAdmin', []).controller('adminloginCtrl', function($scope, $http, $window) {					
					$scope.usertype="admin";
					var xapikey   = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
					$scope.loginForAdmin = function() {						
												
						var formData = {							
							"email": $scope.email,							
							"password": $scope.password,
							"usertype": $scope.usertype						
						};						
						$http.post(BASE_URL + 'api/auth/validateAdminLogin', formData, {							
							headers: {								
								'Content-type': 'application/json',								'x-api-key':xapikey								
							}							
							}).then(function(response) {							
							if (response.status == 200) {								
								$window.location.href = BASE_URL + 'owner';								
							}							
							}, function(error) {							
							$scope.status = "error";							
							$scope.message = "Invalid login credentials!!";							
						});						
												
					}					
										
					$scope.forgotPasswordAdmin = function(userName) {						
												
						var formData = {							
							"email": userName							
						};						
						$http.post(BASE_URL + 'api/auth/forget_password', formData, {							
							headers: {								
								'Content-type': 'application/json',								'x-api-key':xapikey								
							}							
							}).then(function(response) {							
							if (response.status == 200) {								
								$scope.errmessage = "";								
								$scope.sucmessage = "Reset Password Mail has been sent on your email id.";								
							}							
							}, function(error) {							
							$scope.status = "error";							
							$scope.sucmessage = "";							
							$scope.errmessage = "Something went wrong, Please try again later.";							
							});							
												
						}						
												
						});						
												
						</script>						
						</body>						
												
						</html>						
												