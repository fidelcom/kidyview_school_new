<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-streetview"></i>
					</div>
					<div class="page-title">
						<h5>Driver Details</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						
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
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="profileimg">
							<img ng-show="driverphoto != ''" class="img-fluid img-circle" src="<?=base_url()?>img/driver/{{driverphoto}}" alt="User profile" />
							<img ng-show="driverphoto == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/article/noImage.png" />
						</div>
					</div>
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="card-body vendor-full-detail">
							<div class="row mt-4">
								<div class="col-md-4 col-lg-4 col-sm-12">School Name:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">	{{schoolName}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Driver Name:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{driverfname}} {{driverlname}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Device Number:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{driverdeviceId}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Vehicle Number:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">	{{drivervehicle}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">License Number:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{driverlicense}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">License Expiry Date:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{formattedDate}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Phone Number:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{driverphone}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Address:</div>
								<div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{driveraddress}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-12">Route</div>
								<div class="col-md-12 col-lg-12 col-sm-12 text-highligh mt-2">
									{{driverroute}} <!--a class="theme-link" href="javascript:void(0);">Track Route</a>
									<div class="google-map-view mt-3">
										<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2482.432100921254!2d-3.2421375846909837!3d51.523634017337784!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x486e1bb1cd60a097%3A0xea0b421b5d79f720!2sTraffic%20Wales!5e0!3m2!1sen!2sin!4v1573476986376!5m2!1sen!2sin" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
									</div-->
								</div>
							</div>
						</div>
						<a class="btn btn-secondary" href="#!/driver-list">Back To List</a>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->