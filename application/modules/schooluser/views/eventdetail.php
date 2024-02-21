<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-5 align-self-center">
					<div class="page-icon">
						<i class="icon-calendar3"></i>
					</div>
					<div class="page-title">
						<h5>Events Details</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 mt-2 mt-sm-0">
					<div class="right-actions">
						<a href="#!/add-event" class="btn btn-primary"> <i class="icon-plus2"></i> Add Events</a>
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
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="vendor-full-detail">
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Event Title:</div>
								<div class="col-md-9 col-lg-9 col-sm-9  text-highligh">{{title}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Visiblity:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh div-sep">
									<ul class="visibility-text">
										<li ng-repeat = "visiblityaccess in visiblityArr"><span ng-if="visiblityaccess == '0'">Teacher</span>  <span ng-if="visiblityaccess == '1'"> Parent</span></li>
									</ul>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Date & Time:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh">{{formattedDate}} {{time}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Address:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh">{{address}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Detail:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh">{{description}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Event Type:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh" ng-if="is_paid == '0'">Free</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh" ng-if="is_paid == '1'">Paid</div>
							</div>
							<div class="row" ng-if="is_paid == '1'">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Event Amount:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh">{{amount}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0">Photo:</div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh">
									<div class="certificates upload-ph-div-img">
										<a class="group" rel="gallery1" title="{{title}}"><img style="" src="<?=base_url() ?>img/event/{{pic}}" /></a>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-3 pr-0"></div>
								<div class="col-md-9 col-lg-9 col-sm-9 text-highligh"><a class="btn btn-secondary ml-0" href="#!/event-list">Back To List</a></div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->