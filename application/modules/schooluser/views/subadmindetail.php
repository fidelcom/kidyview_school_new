<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-user"></i>
					</div>
					<div class="page-title">
						<h5>{{name}}</h5>
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
							<img ng-show="pics != ''" class="img-fluid img-circle" src="<?=base_url();?>img/school/subadmin/{{pics}}" alt="User profile" />
							<img ng-show="pics == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/article/noImage.png" />
						</div>
					</div>
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="card-body full-detail p-0">
							<ul>
								<li class="current_class"><span>Name:</span> {{name}} </li>
								<li><span>Email Id:</span> {{email}}</li>
								<li><span>Contact Number:</span> {{phone}}</li>
								<li><span>Designation:</span> {{designation}}</li>
								<li><span>Address:</span> {{address}} {{city}} {{state}} {{country}} {{pincode}}</li>
								<li><span>Other Info:</span> {{otherinfo}}</li>
								<li><span></span><a class="btn btn-secondary mt-3 ml-0" href="#!/subadmin-list">Back To List</a></li>
							</ul>
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