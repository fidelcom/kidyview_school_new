<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 d-flex">
					<div class="page-icon">
						<i class="icon-user-plus mt-2"></i>
					</div>
					<div class="page-title align-self-center ml-3">
						<h5>{{fatherfname}} {{fatherlname}}</h5>
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
					<!--div class="col-md-12 emergency_cont">
						<h4>Emergency Contact : +91 1234567890</h4>
					</div-->
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="parent_box">
							<h2>Father Detail</h2>
							<div class="profileimg">
								<img class="img-fluid img-circle" ng-show="fatherphoto != ''" src="<?=base_url() ?>img/parent/{{fatherphoto}}" alt="User profile" />
								<img ng-show="fatherphoto == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/article/noImage.png" />
							</div>
							<div class="name">
								{{fatherfname}} {{fatherlname}} <span>{{fatheroccupation}}</span>
							</div>
							<ul>
								<li><i class="fa fa-envelope"></i> {{fatheremail}}</li>
								<li><i class="fa fa-phone"></i> {{fatherphone}}</li>
								<li><i class="fa fa-map-marker"></i> {{fatheraddress}}</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="parent_box">
							<h2>Mother Detail</h2>
							<div class="profileimg">
								<img class="img-fluid img-circle" ng-show="motherphoto != ''" src="<?=base_url() ?>img/parent/{{motherphoto}}" alt="User profile" />
								<img ng-show="motherphoto == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/article/noImage.png" />
							</div>
							<div class="name">
								{{motherfname}} {{motherlname}} <span>{{motheroccupation}}</span>
							</div>
							<ul>
								<li><i class="fa fa-envelope"></i> {{motheremail}}</li>
								<li><i class="fa fa-phone"></i> {{motherphone}}</li>
								<li><i class="fa fa-map-marker"></i> {{motheraddress}}</li>
							</ul>
						</div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12">
						<div class="parent_box">
							<h2>Emergency Contact Detail</h2>
							<div class="profileimg">
								<img class="img-fluid img-circle" ng-show="emergencyphoto != ''" src="<?=base_url() ?>img/parent/{{emergencyphoto}}" alt="User profile" />
								<img ng-show="emergencyphoto == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/article/noImage.png" />
							</div>
							<div class="name">
								{{emergencyfname}} {{emergencylname}} <span>&nbsp;</span>
							</div>
							<ul>
								<li><i class="fa fa-envelope"></i> {{emergencyemail}}</li>
								<li><i class="fa fa-phone"></i> {{emergencyphone}}</li>
								<li><i class="fa fa-map-marker"></i> {{emergencyaddress}}</li>
							</ul>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="mn_box edit_child mt-3 mt-md-3">
							<h3>Children Detail</h3>
							<div ng-show="childId == ''">
								<span>
									No Records Found!!
								</span>
							</div>
							<div ng-show="childId != ''">
								<div class="childeren_bx" ng-repeat="child in childinfo">
									<div class="profileimg">
										<img ng-show="child.childphoto != ''" src="<?= base_url() ?>img/child/{{child.childphoto}}" alt="User profile" />
										<img ng-show="child.childphoto == ''" src="<?= base_url(); ?>img/article/noImage.png" alt="User profile" />
									</div>
									<ul>
										<li><span>Registraton ID</span> {{child.childRegisterId}}</li>
										<li><span>Name</span> {{child.childfname}} {{child.childmname}} {{child.childlname}}</li>
										<li><span>Gender</span> {{child.childgender}}</li>
										<li><span>Class & Section</span> {{child.class}} -{{child.section}}</li>
										<li><span>Date of Birth</span> {{child.childDOB}}</li>
										<li><span>Email Id</span> {{child.childemail}}</li>
										<li><span>Blood Group</span> {{child.childbg}}</li>
										<li><span>Address</span> {{child.childaddress}}</li>
									</ul>
									<div class="certificates">
									</div>
									<div ng-show="child.child_login_id==''">
									<button class="btn btn-primary" ng-click="generateUserPass(fatherfname,motherfname,fatheremail,motheremail,child.id,child.childRegisterId,child.childfname,child.childmname,child.childlname);"> Generate login details</button>
									</div>
									<div ng-hide="child.child_login_id==''">
									<button class="btn btn-primary" ng-click="showChildLoginDetail(child.child_login_id,child.password,child.childfname,child.childmname,child.childlname);"> Show login details</button>
									</div>
									<div class="edit_icon" title="Edit Child"><a href="#!/edit-child/{{child.childID}}"><i class="fas fa-pen"></i></a></div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12">
						<div class="mn_box edit_child mt-4 mt-md-3">
							<h3>Guardian Detail</h3>
							<div ng-show="guardianinfo.length == 0">
								<span>
									No Records Found!!
								</span>
							</div>
							<div ng-show="guardianinfo.length > 0">
								<div class="childeren_bx" ng-repeat="guardian in guardianinfo">
									<div class="profileimg">
										<img ng-show="guardian.photo != ''" src="<?= base_url() ?>img/parent/{{guardian.photo}}" alt="User profile" />
										<img ng-show="guardian.photo == ''" src="<?= base_url(); ?>img/article/noImage.png" alt="User profile" />
									</div>
									<ul>
										<li><span>Name</span> {{guardian.fname}} {{guardian.lname}}</li>
										<li><span>Email Id</span> {{guardian.email}}</li>
										<li><span>Phone Number</span> {{guardian.phone}}</li>
										<li><span>Address</span> {{guardian.address}}</li>
									</ul>
									<div class="certificates">
									</div>
									<!--div class="edit_icon" title="Edit Guardian"><a href=""><i class="fas fa-pen"></i></a></div-->
								</div>
							</div>
						</div>
					</div>
					<a class="btn btn-secondary mt-2" href="#!/parent-list">Back To List</a>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<!--- student login pop up--------->
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="1" id="childLoginDetailModal" class="modal Fpass">
				<div class="modal-dialog">
					<div class="modal-content">
						<form name="forgotPassform" class="form">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Child Login Details</h4>
							</div>
							<div class="modal-body">
	
								<p><span>Child Name: </span>{{cfullname}}</p>
								<p><span>Login Id: </span>{{cloginid}}</p>
								<p><span>Password: </span>{{cpassword}}</p>
							</div>
						</form>
					</div>
				</div>
			</div>