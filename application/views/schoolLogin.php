<!DOCTYPE html>
<html lang="en" ng-app="KidyviewSchool">
	
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
		<link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
		</head>
	
	<body ng-controller="schoolloginCtrl" style="background-image: url('<?php echo base_url();?>asset/images/<?php echo $bgimage;?>');">
		<?php 
			$errorMessage = $this->session->userdata();
		?>
		<section class="login_wrapper">
			<a class="hiddenanchor" id="signup"></a>
			<a class="hiddenanchor" id="signin"></a>
			<div class="login-container" id="login_container">
				<div class="login-form">
					<div class="login_Box">
						<div class="logo_text logo-position">
							<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>
						</div>
						<p class="color-red fs14" ng-if="status == 'error'">
							{{message}}
						</p>
						<select class="select-l-input" name="usertype" id="usertype" ng-model="usertype">
							<option value="school">School</value>
							<option value="schoolsubadmin">Sub Admin</value>
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
								<input type="submit" name="submit" id="sign-in" ng-click="loginForSchool()" class="btn btn-accent btn-block" value="Sign In" />
							</p>
						</form>
						Don't have an account? <a href="<?=base_url()?>schoollogin/signup" class="to_register">  Sign up here  </a>
						<!-- Don't have an account? <a href="#signup" class="to_register" data-toggle="modal" data-target="#create-account-popup"> Sign up here  </a> -->
					</div>
				</div>
				<div class="login-image" style="background:url(<?php echo base_url();?>asset/images/<?php echo $image;?>) no-repeat center;background-size: cover;">					
										
				</div>
			</div>
			<div class="subscription-plan-list" id="subscription_plan_list" style="display:none">
			<div class="subscription_boxes">
			<?php if(!empty($subscriptionData)){
			foreach($subscriptionData as $subscription){?>
			<div class="subscription_bx">
			<form name="signup_subscription<?php echo $subscription['id'];?>" action="<?php echo base_url();?>SchoolSignup/payment" method="post">
				<input type="hidden" name="subscription_id" value="<?php echo $subscription['id'];?>"/>
				<input type="hidden" class="hidden_school_id" name="hidden_school_id" value=""/>
				<div class="plan-head">
					<h2><?php echo $subscription['name'];?> </h2>		
				</div>
				
				<div class="top-plan">
					
					<div class="package_price"><span>₦ <?php echo number_format($subscription['amount'],2);?> <span><?php echo $subscription['validity'];?></span></span></div>
					<?php
					if(!empty($subscriptionData)){
					?>		
					<div class="plan-body do-nicescroll">
						<ul>
						<?php
						foreach($subscription['featureData'] as $feature){
						?>
							<li><?php echo $feature['module_name'];?></li>
						<?php } ?>	
						</ul>	
					</div>
					<?php } ?>
				</div>
				<div class="plan-foot">
					<input class="trynow btn btn-primary" type="submit" name="submit" value="Try it Now"/>
				</div>
				
			</form>
			</div>
			<?php 
			}
			} ?>
			</div>
			<div class="clearfix"></div>
			<div class="back-container">
			<button class="trynow btn btn-primary" ng-click="goBackToSignUp();">Go back to login page</button>	
			</div>
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
								<p class="color-green fs14 error_span" ng-if="sucmessage != ''">
									{{sucmessage}}
								<p class="color-red fs14 error_span" ng-if="errmessage != ''">
									{{errmessage}}
								</p>
								<p>Enter your email address to get your password.</p>
								<input type="email" name="username" ng-model="userName" placeholder="Email Address" autocomplete="off" class="form-control placeholder-no-fix" required="" />
								<span ng-show="forgotPassform.username.$error.required">Email Address is required.</span>
								<span ng-show="forgotPassform.username.$error.email">Not a valid email!</span>
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
	
	<!-- create account popup -->
	<div id="create-account-popup" class="modal" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Create Account</h4>
			</div>
				<div class="modal-body create-account-popup">
				<div class="registration_form">
					<section class="login_content">
						<form role="form" class="signup-popup" name="signupform" id="signupform" ng-submit="signupform.$valid && registerForSchool()" novalidate >
							<p class="color-green fs14" ng-if="status2 == 'success'">                
								{{message}}
							</p>
							<p class="color-red fs14" ng-if="status2 == 'error'">                
								{{message}}
							</p>
							<div>
								<input type="text" class="form-control" ng-model="name" placeholder="School Name" required="" />
							</div>
							<span ng-show="signupform.name.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.name.$error.required">School Name is required.</span>
							</span>
							<div>
								<input type="email" id="email2" ng-model="email2" name="email2" class="form-control" placeholder="Email ID" required="">
							</div>
							<span ng-show="signupform.email2.$dirty && signupform.email2.$invalid">
								<span class="color-red fs12 error_span" ng-show="signupform.email2.$error.required">Email is required.</span>
								<span class="color-red fs12 error_span" ng-show="signupform.email2.$error.email">Invalid email address.</span>
							</span>
							<div>
								<input type="text" class="form-control" ng-model="phone" placeholder="Phone Number" required="" />
							</div>
							<span ng-show="signupform.phone.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.phone.$error.required">School Phone Number is required.</span>
							</span>
							<div>
								<input type="password" id="psw" ng-model="psw" name="psw"  class="form-control" placeholder="Password" required="">
							</div>
							<span ng-show="signupform.psw.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.psw.$error.required">Password is required.</span>
							</span>
							<div>
								<input type="password"  id="cpsw" ng-model="cpsw" name="cpsw"  class="form-control" placeholder="Confirm Password" required="">
							</div>
							<span ng-show="signupform.cpsw.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.cpsw.$error.required">Confirm Password is required.</span>
							</span>
							<div class="clearfix"></div>
							<!--div class="">
								<input type="submit" class="btn btn-primary" value="Create Account" ng-click="registerForSchool()" />
								<input type="reset" class="btn btn-warning" value="Cancel"  data-dismiss="modal"  />
							</div-->
							<div class="">
								<button type="submit" ng-disabled="signupform.email2.$dirty && signupform.email2.$invalid || signupform.name.$invalid || signupform.phone.$invalid || signupform.psw.$invalid || signupform.cpsw.$invalid"  class="btn btn-primary">Signup</button>
								<button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
							</div>
							<br />
							<div class="separator text-center alreadylogin">
								<p class="change_link">Already a member ?
									<a href="<?=base_url()?>schoollogin" class="to_register"> Log in </a>
								</p>
								<div class="clearfix"></div>
								<div>
								</div>
							</div>
						</form>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- javascripts -->
<script src="<?php echo base_url();?>asset/js/jquery.js"></script>
<!-- bootstrap -->
<script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="<?php echo base_url();?>asset/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url();?>asset/js/jquery.nicescroll.js" type="text/javascript"></script>
<!--script src="<?php //echo base_url();?>asset/js/scripts.js"></script-->

<script type="text/javascript" src="<?php echo base_url();?>asset/js/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url(); ?>asset/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
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
	angular.module('KidyviewSchool', []).controller('schoolloginCtrl', function($scope, $http, $window) {
		$scope.usertype="school";
		var xapikey   = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
		$scope.loginForSchool = function() {
			
			var formData = {
				"email": $scope.email,
				"password": $scope.password,
				"usertype": $scope.usertype
			};
			$(".hidden_school_id").val('');
			$http.post(BASE_URL + 'api/auth/validateSchoolLogin', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key':xapikey
				}
				}).then(function(response) {
				if (response.status == 200) {
				localStorage.setItem("TOKEN",response.data.token);
				$window.location.href = BASE_URL + 'schooluser';
				}
				}, function(error) {
				if(error.data.error=='notSubscribed'){
						var Gritter = function () {
						$.gritter.add({
							title: 'error',
							text: error.data.message
						});
						$("#subscription_plan_list").show();
						$("#login_container").hide();
						$(".hidden_school_id").val(error.data.data);
					}();
				}else{
				$(".hidden_school_id").val('');
				$scope.status = "error";
				$scope.message = error.data.message;
				}
				
			});
			
		}
		$scope.goBackToSignUp = function () {
			$("#subscription_plan_list").hide();
			$("#login_container").show();
		}
		$scope.registerForSchool = function()
		{
			var formData = {
				"school_name": $scope.name,
				"email": $scope.email2,
				"phone": $scope.phone,
				"password": $scope.psw,
				"confirm_password": $scope.cpsw
			};
			$http.post(BASE_URL + 'api/auth/signupSchool', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key':xapikey
				}
				}).then(function (res)
			{
				$scope.status2 = res.data.status;
				if (res.data.status == "success")
				{
					$scope.message = res.data.message;
				}
				if (res.data.status == "error")
				{
					$scope.message = res.data.error;
				}
			}, function(error)
			{
				$scope.status2 = error.data.status;
				if (error.data.error.confirm_password)
				{
					$scope.message = error.data.error.confirm_password;
				}
				else
				{
					$scope.message = error.data.error;
				}
			});
		}
		
		$scope.forgotPasswordAdmin = function(userName) {
			
			var formData = {
				"email": userName
			};
			$http.post(BASE_URL + 'api/auth/forget_passwordForSchool', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key':xapikey
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