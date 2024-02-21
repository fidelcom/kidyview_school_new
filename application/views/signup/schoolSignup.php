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
	<script src="<?php echo base_url();?>asset/js/jquery.js"></script>
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
<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/intlTelInput.css" />
</head>

<body ng-controller="schoolregisterCtrl">
<?php 
		$errorMessage = $this->session->userdata();
	?>
<section class="signup_wrapper" style="background: url('<?php echo base_url();?>asset/images/<?php echo $bgimage;?>') no-repeat center bottom / cover;">
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
				<div class="registration_form">
					<section class="login_content">
					<!-- ng-submit="signupform.$valid && registerForSchool()" -->
						<form role="form" ng-submit="registerForSchool()" class="signup-popup" name="signupform" id="signupform" novalidate>
							
                                                   <div>
				                        <select ng-model="countrycode" class="form-control" name="countrycode" id="countrycode" required >
                                                        <option value="" selected="selected" >Please Select</option>
                                                        <?php if(!empty($countryData)){
                                                         foreach($countryData as $country){ ?>
                                                        <option  value="<?php echo $country['id'];?>" ><?php echo $country['country'];?></option>
                                                        <?php }} ?>
                                                        </select>
                                                       <br> 
                                                   </div>
                                                    
                                                    
									<span ng-show="signupform.countrycode.$dirty">
									<span class="color-red fs12 error_span" ng-show="signupform.countrycode.$error.required">Country  is required.</span>
									</span>
                                                    
                                                    
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
							<span class="color-red fs12 error_span" ng-show="signupform.email2.$dirty && signupform.email2.$invalid">
								<span ng-show="signupform.email2.$error.required">Email is required.</span>
								<span ng-show="signupform.email2.$error.email">Invalid email address.</span>
							</span>
							<div class="mb-2">
								<input type="text" name="phone" ng-intl-tel-input="" data-default-country="in" class="form-control" ng-model="phone" placeholder="Phone Number"
									required/>
							</div>
							<span class="color-red fs12 error_span" ng-show="signupform.phone.$invalid && signupform.phone.$touched">Invalid</span>
							<span class="help-blockValid ng-hide" ng-show="signupform.phone.$valid && myForm.fatherphone.$touched">Valid</span>
							<div>
								<input type="text" class="form-control" ng-model="bank_name" placeholder="BanK Name"
								 />
								</div>
								<span ng-show="signupform.name.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.bank_name.$error.required">Bank Name is required.</span>
								</span>
							<div>
							<div>
								<input type="text" class="form-control" ng-model="account_number" placeholder="Bank Account Number"  numericonly />
								</div>
								<span ng-show="signupform.name.$dirty">
								<span class="color-red fs12 error_span" ng-show="signupform.account_number.$error.required">Account Number is required.</span>
								</span>
							<div>
							<div>
								<input type="text" class="form-control" ng-model="sort_code" placeholder="Sort Code (Optional)"
								/>
								</div>
							<div>
								<input type="password" id="psw" ng-model="psw" name="psw" class="form-control"
									placeholder="Password" required>
							</div>
							<span class="color-red fs12 error_span" ng-show="signupform.psw.$dirty">
								<span ng-show="signupform.psw.$error.required">Password is required.</span>
							</span>
							<div>
								<input type="password" id="cpsw" ng-model="cpsw" compare-to="psw" name="cpsw" class="form-control"
								placeholder="Confirm Password" required>
							</div>
							<span class="color-red fs12 error_span" ng-show="signupform.cpsw.$dirty">
								<span ng-show="signupform.cpsw.$error.required">Confirm Password is required.</span>
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
            
            <div style="display: inline;text-align: center;padding: 10px;">
           
            <select  class="form-control" name="currency" id="currency" required  style="display: inline-block;width: 300px;">
            <option value="0">Please Select</option>
            <option value="1">Nigerian Naira</option>
            </select>  
                
           <span style="color: #f00;padding-left: 15px;font-weight: 500;">Note: The selected currency will be shown/applicable in the overall application.</span>     
                
            </div>
            
		<div class="subscription_boxes">
			<?php if(!empty($subscriptionData)){
                        $count =0;     
			foreach($subscriptionData as $subscription){
                        $count++;    
				
				?>
				<div class="subscription_bx">
					<form name="signup_subscription<?php echo $subscription['id'];?>" action="<?php echo base_url();?>SchoolSignup/payment" method="post">
						<input type="hidden" name="subscription_id" value="<?php echo $subscription['id'];?>"/>
                                                <input type="hidden" class="hidden_currencycode" name="hidden_currencycode" value="1"/> 
                                                <input type="hidden" class="hidden_countrycode" name="hidden_countrycode" value=""/>
						<input type="hidden" class="hidden_school_name" name="hidden_school_name" value=""/>
						<input type="hidden" name="hidden_school_email" class="hidden_school_email" value=""/>
						<input type="hidden" name="hidden_school_phone" class="hidden_school_phone" value=""/>
						<input type="hidden" name="hidden_school_password" class="hidden_school_password" value=""/>
						<input type="hidden" name="hidden_school_id" class="hidden_school_id" value=""/>
						<input type="hidden" name="hidden_bank_name" class="hidden_bank_name" value=""/>
						<input type="hidden" name="hidden_account_number" class="hidden_account_number" value=""/>
						<input type="hidden" name="hidden_sort_code" class="hidden_sort_code" value=""/>
						<div class="plan-head">
						<div class="package_price">
                                                    <span id="planPrice_<?php echo $count;?>">₦ <?php echo number_format($subscription['amount'],2);?> <span><?php echo $subscription['validity'];?></span></span>
							</div>
							<h2><?php echo $subscription['name'];?> </h2>
							<p>Maximum Number of student - <?php echo $subscription['no_of_student'];?> </p>		
						</div>
						
						<div class="top-plan">
							
							
							<?php /* if($subscription['type']=='Free'){
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
							<?php } */ ?>
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
			} 
                        ?>
                    
                        
		</div>
		<div class="clearfix"></div>
		<div class="back-container">
			<button class="trynow btn btn-primary" ng-click="goBackToSignUp();">Go back to Registration form</button>	
		</div>
	</div>
</section>

<!-- javascripts -->

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
	$(".do-nicescroll").niceScroll({});
</script>
<script>
	'use strict';
	angular.module('KidyviewSchool', ['ngIntlTelInput']).controller('schoolregisterCtrl', function ($scope, $http, $window) {
		$scope.usertype = "school";
		var xapikey = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';

			$scope.registerForSchool = function () {
			if($scope.name=='' || $scope.email2==''  || $scope.countrycode=='' || $scope.phone=='' || $scope.psw==''){
				return false;
			}
			$scope.status='';
			localStorage.setItem('school_name', $scope.name);
			localStorage.setItem('email', $scope.email2);
			localStorage.setItem('phone', $scope.phone);
			localStorage.setItem('psw', $scope.psw);
			var formData = {
				"school_name": $scope.name,
                                "countrycode": $scope.countrycode,
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
                                        $scope.currencyList($scope.countrycode);
					$("#subscription_plan_list").show();
					$("#login_container").hide();
                    $(".hidden_countrycode").val($scope.countrycode);
					$(".hidden_school_name").val($scope.name);
					$(".hidden_school_email").val($scope.email2);
					$(".hidden_school_phone").val($scope.phone);
					$(".hidden_school_password").val($scope.psw);
					$(".hidden_bank_name").val($scope.bank_name);
					$(".hidden_account_number").val($scope.account_number);
					$(".hidden_sort_code").val($scope.sort_code);
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
                
                
                $scope.currencyList = function (countrycode) {
                  $.ajax({
                     url:BASE_URL + 'schoolLogin/allCurrency',
                     method: 'post',
                     data: {countrycode:countrycode},
                     dataType: 'json',
                     success: function(response){
                       var content = response;
                       $.each(content, function(i, val) {
                         if(content[i].id!='1')  
                         $('#currency').append( '<option value="'+content[i].id+'">'+content[i].currency_name+'</option>' );  
                       });
                   }
                 });  
                }
                
                $("#currency").change(function() {
                if($(this).val()=='0'){
                    $('.trynow').prop('disabled', true); 
                    return false;
                } 
                $('.trynow').prop('disabled', false);
                $('.hidden_currencycode').val($(this).val());
                $.ajax({
                     url:BASE_URL + 'schoolLogin/newAmount',
                     method: 'post',
                     data: {currencyID:$(this).val()},
                     dataType: 'json',
                     success: function(response){
                       var content = response;
                       $.each(content, function(i, val) {
                        var validity = content[i].validity; 
                        var currency_symbol = content[i].new_currency_symbol; 
                        var newamount = content[i].new_currency_converted_amount; 
                        $('#planPrice_'+i).html(currency_symbol+' '+newamount+'<span>'+validity+'</span>');
                       });
                   }
                 });  
                });
 
                
                

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
<script src="<?php echo base_url(); ?>asset/js/intlTelInput.min.js"></script>
<script src="<?php echo base_url(); ?>asset/js/utils.js"></script>
<script src="<?php echo base_url(); ?>asset/js/ng-intl-tel-input.js"></script>
</body>

</html>

