<!--BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
							<div class="page-icon">
								<a href="#!/student-list">	<i class="icon-arrow-back"></i></a>
							</div>
							<div class="page-title ml-3 align-self-center">
								<h5>Student Details</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<!-- <a href="add-school.html" class="btn btn-primary">Add School</a>
								<a href="#" class="btn btn-primary">Add School</a> -->
							</div>
						</div>
					</div>
				</div>
			</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content ">
				<div class="card children-details">
					<div class="card-body children-data">
						<div class="row">
							<div class="col-md-3 col-sm-12 col-xs-12">
								<div class="profileimg-new mt-2">
									<img ng-show="childphoto != ''" class="img-fluid" src="<?=base_url();?>img/child/{{childphoto}}" alt="User profile" />
									<img ng-show="childphoto == ''" class="img-fluid" src="<?= base_url(); ?>img/article/noImage.png" />
								</div>
							</div>
							<div class="col-md-9 col-sm-12 col-xs-12">
								<div class="card-body full-detail clearfix p-0">
									<ul>
										<li class="pl-0"><span>Registration ID:</span> {{ childRegisterId  }}</li>
										<li class="pl-0"><span>Username:</span> {{ child_login_id  }}</li>
										<li class="pl-0"><span>Student First Name:</span> {{childfname}} </li>
										<li class="pl-0"><span>Student Middle Name:</span> {{childmname}}</li>
										<li class="pl-0"><span>Student Last Name:</span>  {{childlname}}</li>
										<li class="pl-0"><span>Class and Section:</span> {{class}}-{{section}}</li>
										<li class="pl-0"><span>Gender:</span> {{childgender}}</li>
										<li class="pl-0"><span>Student Email-id:</span> {{childemail}}</li>
										<li class="pl-0"><span>Father Name:</span> {{fatherfname}} {{fatherlname}}</li>
										<li class="pl-0"><span>Father's Email-id:</span> {{fatheremail}}</li>
										<li class="pl-0"><span>Address:</span> {{childaddress}}</li>
										<!-- <li><span>Mother Mail:</span> {{motheremail}}</li> -->
									</ul>
									<div class="clearfix"></div>
									<div class="row">
										<div class="col-md-12 mt-2 mb-2"><label class="mb-0"><b>Attached Certificate</b></label></div>
										<div class="col-md-5">
											<a class="group1" rel="gallery1" href="javascript:void(0);" title="">
												<img ng-show="childcertificate != ''" class="img-fluid" src="<?=base_url();?>img/child/{{childcertificate}}" alt="User profile" />
												<img ng-show="childcertificate == ''" class="img-fluid" src="<?= base_url(); ?>img/article/noImage.png" />

											</a>
										</div>
										<div class="col-md-5">

											<!-- <a class="group1" rel="gallery1" href="javascript:void(0);" title=""><img class="img-fluid" src="img/cer2.jpg"></a> -->
										</div>
									</div>
									<div class="clearfix"></div>
									<div class="row">
										<div class="col-md-12 col-sm-12 col-xs-12 mt-2">
											<a class="btn btn-secondary ml-0" href="#!/student-list"><i class="icon-arrow-back"></i> Back To List</a>
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
<!-- END: .app-main