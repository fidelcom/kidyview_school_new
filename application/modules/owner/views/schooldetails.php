<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
					<div class="page-icon">
						<i class="icon-school"></i>
					</div>
					<div class="page-title">
						<h5>School Details</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
					<div class="right-actions">
						<a href="#!/add-school" class="btn btn-primary"> <i class="icon-plus2"></i> Add School</a>
					</div>
				</div>
			</div>
			
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="card">
			<div class="card-body p-0">
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="card-body vendor-full-detail">
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">School Name:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolname}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Email Id:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{email}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Skype Id:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{skypeid}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Phone Number:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{phone}}</div>
							</div>
                                                    
                                                        <div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Country:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{countryName}}</div>
							</div>
                                                    
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Area</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{area}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Total Staff</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{avgStaff}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Total Students</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{avgStudent}}</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription Type</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolinfo.subscriptiondetails.type?schoolinfo.subscriptiondetails.type:'N/A'}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription Name</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolinfo.subscriptiondetails.name?schoolinfo.subscriptiondetails.name:'N/A'}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription Validity</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
									<div>{{schoolinfo.subscriptiondetails.days?schoolinfo.subscriptiondetails.days+' days' :'N/A'}}</div>
									<!--<div>Remaining 2 Months</div>-->
								</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription Start Date</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolinfo.subscriptiondetails.start_date?schoolinfo.subscriptiondetails.start_date:'N/A'}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription End Date</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolinfo.subscriptiondetails.end_date?schoolinfo.subscriptiondetails.end_date:'N/A'}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Subscription Status</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{schoolinfo.subscriptiondetails.status?schoolinfo.subscriptiondetails.status:'N/A'}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Vision</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{vision}}</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3col-sm-12">Mission</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{mission}}</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Core Values</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{coreValues}}</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Motto</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{motto}}</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Social Media Handle</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
									<ul>
										<li><a href="#">Facebook Url: </a><p>{{facebook}}</p></li>
										<li><a href="#">Twitter Url: </a><p>{{twitter}}</p></li>
										<li><a href="#">YouTube Url: </a><p>{{youtube}}</p></li>
										<li><a href="#">Linkedin Url: </a><p>{{linkdin}}</p></li>
									</ul>
								</div>
							</div>
							
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Other Information</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{otherinfo}}</div>
							</div>
							<div class="row">
								<div class="col-md-3 col-lg-3 col-sm-12">Address:</div>
								<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{location}}
									<!--div class="address-g-map mt-3">
										<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12700.390134786185!2d-8.826154372620957!3d37.26911420377096!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd1b3f0a04431fa5%3A0x97ecf42b8641f3fd!2sBarranco%20da%20Vaca%2C%20Aljezur%2C%20Portugal!5e0!3m2!1sen!2sin!4v1573480161085!5m2!1sen!2sin" width="100%" height="250" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
									</div-->
								</div>
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