<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
	<div class="row">
		
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
			<div class="page-icon">
				<i class="icon-subscriptions"></i>
			</div>
			<div class="page-title">
				<h5>Subscription Management</h5>
			</div>
		</div>
	</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
	<?php 
		if($this->session->flashdata('error')){
		echo "<span style='color:red'>".$this->session->flashdata('error')."</span>";
		}if($this->session->flashdata('msg')){
		echo "<span style='color:green'>".$this->session->flashdata('msg')."</span>";
		}
	?>

	<?php /*<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" ng-repeat="subscription in getSubscriptionList">
			<div class="card subscription-card">
				<div class="card-body">
					<input type="radio" required name="subscription_id" ng-checked="subscription.status=='Active'" value="{{subscription.id}}"/>
					<label>
						<h5>{{subscription.name}}</h5>
						<p><span class="highlight-text-head">Subscription Type:</span> {{subscription.type}}</p>
						<p><span class="highlight-text-head">Subscription Validity:</span> {{subscription.validity}}</p>
						<p><span class="highlight-text-head">Amount:</span> <span class="text-blue text-bold">NGN {{subscription.amount}}</span></p>
					</label>
				</div>
			</div>
		</div>
		
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">
			<div class="form-group">
				<input class="btn btn-primary" type="submit" name="submit" value="Update Subscription">
			</div>
		</div>
	</div> */ ?>

	<div class="plans_boxes">
		<h4>Current Subscription Plan</h4>
		<div class="row mb-4">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" ng-repeat="subscription in getSubscriptionList" ng-show="$index==0">
			<div class="card subscription-card">
				<div class="card-body">
					<input type="radio" ng-checked="subscription.status=='Active'" name="subscription_id" value="{{subscription.id}}"/>
					<label>
						<h5>{{subscription.name}}</h5>
						<p><span class="highlight-text-head">Subscription Type:</span> {{subscription.type}}</p>
						<p><span class="highlight-text-head">Subscription Validity:</span> {{subscription.validity}}</p>
						<p><span class="highlight-text-head">No. of Students:</span> {{subscription.no_of_student}}</p>
						<p><span class="highlight-text-head">Start Date:</span> {{subscription.start_date}}</p>
						<p><span class="highlight-text-head">End Date:</span> {{subscription.end_date}}</p>
						<p><span class="highlight-text-head">Amount:</span> <span class="text-blue text-bold">{{subscription.currency}} {{subscription.amount}}</span></p>
					</label>
					<a href="javascript:void(0);" type="button" ng-click="benefitModal(subscription)" class="subs_btn">View Benefits</a>
				</div>
			</div>
		</div>
		</div>
		<hr />
		<h4>Active Subscription Plans</h4>
		<form name="signup_subscription" action="<?php echo base_url();?>SchoolSignup/payment" method="post">
		<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12" ng-repeat="subscription in getSubscriptionList" ng-show="$index!=0">
			<div class="card subscription-card">
				<div class="card-body">
					<input type="radio" required name="subscription_id" value="{{subscription.id}}"/>
                                        <input type="hidden" required name="hidden_currencycode" value="{{subscription.user_currency_id}}"/>
					<label>
						<h5>{{subscription.name}}</h5>
						<p><span class="highlight-text-head">Subscription Type:</span> {{subscription.type}}</p>
						<p><span class="highlight-text-head">Subscription Validity:</span> {{subscription.validity}}</p>
						<p><span class="highlight-text-head">No. of Students:</span> {{subscription.no_of_student}}</p>
						<p><span class="highlight-text-head">Amount:</span> <span class="text-blue text-bold">{{subscription.user_currency_code}}  {{subscription.user_currency_symbol}} {{subscription.user_currency_amount}}</span></p>
					</label>
					<a href="javascript:void(0);" type="button" ng-click="benefitModal(subscription)" class="subs_btn">View Benefits</a>
				</div>
			</div>
		</div>
		
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-4">
			<div class="form-group">
				<input class="btn btn-primary" type="submit" name="submit" value="Update Subscription">
			</div>
		</div>
		</div>
		</form>
	</div>


<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->


<div id="benefitModal" class="modal fade ben_modal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Subscription Benefits</h4>
      </div>
      <div class="modal-body">
        <ul class="do-nicescroll">
			<li ng-show="feature.is_enable=='1'" ng-repeat="feature in subscriptionData.feature">{{feature.module_name}}</li>
		</ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script src="<?php echo base_url()?>asset/js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript">
	$(".do-nicescroll").niceScroll({});
</script>

