<!DOCTYPE html>
<html lang="en" ng-app="KidyviewSchool">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="GeeksLabs">
<link rel="shortcut icon" href="img/fav.png">
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
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

<body>
<?php 
		$errorMessage = $this->session->userdata();
	?>
<section class="signup_wrapper" style="background: url('<?php echo base_url();?>asset/images/<?php echo $bgimage;?>') no-repeat center bottom / cover;">
	<div class="subscription-plan-list" id="subscription_plan_list">
		<div class="subscription_boxes">
			<?php if(!empty($subscriptionData)){
			foreach($subscriptionData as $subscription){?>
				<div class="subscription_bx">
					<div class="plan-head">
					<div class="package_price"><span>₦ <?php echo number_format($subscription['amount'],2);?> <span><?php echo $subscription['validity'];?></span></span></div>
						<h2><?php echo $subscription['name'];?> </h2>
						<p>Maximum Number of student - <?php echo $subscription['no_of_student'];?> </p>		
					</div>
					<div class="top-plan">
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
					<a href="<?php echo base_url();?>schoollogin/signup" class="trynow btn btn-primary">Try it Now</a>
					</div>
				</div>
			<?php 
			}
			} ?>
		</div>
		<div class="clearfix"></div>
		
	</div>
</section>

<!-- javascripts -->
<script src="<?php echo base_url();?>asset/js/jquery.js"></script>
<!-- bootstrap -->
<script src="<?php echo base_url();?>asset/js/bootstrap.min.js"></script>
<!-- nice scroll -->
<script src="<?php echo base_url();?>asset/js/jquery.scrollTo.min.js"></script>
<script src="<?php echo base_url();?>asset/js/jquery.nicescroll.js" type="text/javascript"></script>
<script>
$(function() {
	$(".do-nicescroll").niceScroll({});
});
</script>
</body>
</html>