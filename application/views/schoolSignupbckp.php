<!DOCTYPE html>
<html lang="en" ng-app="KidyviewSchool">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="GeeksLabs">
<link rel="shortcut icon" href="img/fav.png">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet'
	type='text/css'>
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

<body ng-controller="schoolregisterCtrl">
<?php 
		$errorMessage = $this->session->userdata();
	?>
<section class="signup_wrapper" style="background-image: url('<?php echo base_url();?>asset/images/<?php echo $bgimage;?>');">
	<a class="hiddenanchor" id="signup"></a>
	<a class="hiddenanchor" id="signin"></a>
	<div class="login-container" id="login_container">
		<div class="login-form">
			<div class="login_Box">
				<div class="logo_text logo-position">
					<a><img src="<?php echo base_url();?>img/small_logo.png" alt=""></a>
				</div>
				<p class="color-red fs14" ng-if="status == 'error'">
					{{message}}>
				</p>
				<div class="registration_form">
					<section class="login_content">
					<!-- ng-submit="signupform.$valid && registerForSchool()" -->
						<form role="form" ng-submit="registerForSchool()" class="signup-popup" name="signupform" id="signupform" novalidate>
							<div>
								<input type="text" class="form-control" ng-model="name" placeholder="School Name"
									required />
							</div>
							<span ng-show="signupform.name.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.name.$error.required">School Name is required.</span>
							</span>
							<div>
								<input type="email" id="email2" ng-model="email2" name="email2" class="form-control" placeholder="Email Id" required="" >
							</div>
							<span ng-show="signupform.email2.$dirty && signupform.email2.$invalid">
								<span class="color-red fs12 error_span" ng-show="signupform.email2.$error.required">Email is required.</span>
								<span class="color-red fs12 error_span" ng-show="signupform.email2.$error.email">Invalid email address.</span>
							</span>
							<div>
								<input type="text" class="form-control" numericonly ng-model="phone" placeholder="Phone Number"
									required/>
							</div>
							<span ng-show="signupform.phone.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.phone.$error.required">School Phone Number is
									required.</span>
							</span>
							<div>
								<input type="password" id="psw" ng-model="psw" name="psw" class="form-control"
									placeholder="Password" required>
							</div>
							<span ng-show="signupform.psw.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.psw.$error.required">Password is required.</span>
							</span>
							<div>
								<input type="password" id="cpsw" ng-model="cpsw" compare-to="psw" name="cpsw" class="form-control"
									placeholder="Confirm Password" required>
							</div>
							<span ng-show="signupform.cpsw.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.cpsw.$error.required">Confirm Password is required.</span>
							</span>
							<span ng-show="signupform.cpsw.$invalid">
							<span class="color-red fs12 error_span" ng-show="signupform.cpsw.$error.compareTo"> Confirm Password not matched.</span>
								
							</span>
							<div class="clearfix"></div>
							<div class="">
							<button type="submit" ng-disabled="signupform.$invalid" class="btn btn-primary" id="signup">Signup</button>
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

				<!-- Don't have an account? <a href="#signup" class="to_register" data-toggle="modal" data-target="#create-account-popup"> Sign up here  </a> -->
			</div>
		</div>
		<div class="login-image"
			style="background:url(<?php echo base_url();?>asset/images/<?php echo $image;?>) no-repeat center;background-size: cover;">

		</div>
	</div>
	<div class="subscription-plan-list" id="subscription_plan_list" style="display:none">
	<?php if(!empty($subscriptionData)){
	foreach($subscriptionData as $subscription){?>
	<form name="signup_subscription<?php echo $subscription['id'];?>" action="<?php echo base_url();?>SchoolSignup/payment" method="post">
	<input type="hidden" name="subscription_id" value="<?php echo $subscription['id'];?>"/>
	<input type="text" class="hidden_school_name" name="hidden_school_name" value=""/>
	<input type="hidden" name="hidden_school_email" class="hidden_school_email" value=""/>
	<input type="hidden" name="hidden_school_phone" class="hidden_school_phone" value=""/>
	<input type="hidden" name="hidden_school_password" class="hidden_school_password" value=""/>
	<div class="single-plan">
		<div class="top-plan">
			<div class="plan-head">
				<h2><?php echo $subscription['name'];?> </h2>		
			</div>
			<?php
			if(!empty($subscriptionData)){
			?>		
			<div class="plan-body">
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
			<?php if($subscription['type']=='Free'){
				if($subscription['validity']=='Monthly'){
					$validity=" 1 Month";
				}elseif($subscription['validity']=='Quarterly'){
					$validity=" 3 Months";
				}elseif($subscription['validity']=='Quarterly'){
					$validity=" 1 Year";
				}
				?>
			<p>Try free for <?php echo $validity;?></p>
			<?php }elseif($subscription['type']=='Paid'){?>
			<p><?php echo round($subscription['amount'],2);?>$ <?php echo $subscription['validity'];?></p>
			<?php } ?>
			<input class="trynow btn btn-primary" type="submit" name="submit" value="Try it Now"/>
		</div>
	</div>
	</form>
	<?php 
	}
	} ?>	
	<div class="back-container">
		<button class="trynow btn btn-primary" ng-click="goBackToSignUp();">Go back to Registration form</button>	
	</div>
</div>
</section>

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
	var BASE_URL = "<?php echo base_url(); ?>";
</script>
<script type="text/javascript">
	$(".subscription-plan-list").hide();
	/*
	$("button").click(function(){
		$(".login-container").hide();
		$(".subscription-plan-list").show();
	})
	$("button.trynow").click(function(){
		alert("dfdf");
		$(".login-container").show();
		$(".subscription-plan-list").hide();
	})
	*/
	
</script>
<script>
	'use strict';
	angular.module('KidyviewSchool', []).controller('schoolregisterCtrl', function ($scope, $http, $window) {
		$scope.usertype = "school";
		var xapikey = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';

			$scope.registerForSchool = function () {
			if($scope.name=='' || $scope.email2=='' || $scope.phone=='' || $scope.psw==''){
				return false;
			}
			$scope.status='';
			localStorage.setItem('school_name', $scope.name);
			localStorage.setItem('email', $scope.email2);
			localStorage.setItem('phone', $scope.phone);
			localStorage.setItem('psw', $scope.psw);
			var formData = {
				"school_name": $scope.name,
				"email": $scope.email2,
				"phone": $scope.phone,
				"password": $scope.psw,
				"confirm_password": $scope.cpsw
			};
			
			$http.post(BASE_URL + 'api/auth/checkSchoolEmail', formData, {
				headers: {
					'Content-type': 'application/json',
					'x-api-key': xapikey
				}
			}).then(function (res) {
			
				$scope.status = res.data.status;;
				if (res.data.status == "success") {
					$scope.message = res.data.message;
					$("#subscription_plan_list").show();
					$("#login_container").hide();
					$(".hidden_school_name").val($scope.name);
					$(".hidden_school_email").val($scope.email2);
					$(".hidden_school_phone").val($scope.phone);
					$(".hidden_school_password").val($scope.psw);
				}
				if (res.data.status == "error") {
					$scope.message = res.data.message;
				}
			}, function (error) {
				
				$scope.status = error.data.status;
				$scope.message = error.data.message;
				
			});
		}

		$scope.goBackToSignUp = function () {
			$("#subscription_plan_list").hide();
			$("#login_container").show();
		}

	}).directive("compareTo", function ()  
	{  
	return {  
		require: "ngModel",  
		scope:  
		{  
			confirmPassword: "=compareTo"  
		},  
		link: function (scope, element, attributes, modelVal)  
		{  
			modelVal.$validators.compareTo = function (val)  
			{  
				return val == scope.confirmPassword;  
			};  
			scope.$watch("confirmPassword", function ()  
			{  
				modelVal.$validate();  
			});  
		}  
	};  
	}).directive('numericonly', function () {  
  	return {  
      require: 'ngModel',  
      link: function (scope, element, attr, ngModelCtrl) {  
          function fromUser(text) {  
              var transformedInput = text.replace(/[^0-9]/g, '');  
              if (transformedInput !== text) {  
                  ngModelCtrl.$setViewValue(transformedInput);  
                  ngModelCtrl.$render();  
              }  
              return transformedInput;   
          }  
          ngModelCtrl.$parsers.push(fromUser);  
      }  
  };
});
</script>
</body>

</html>