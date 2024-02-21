
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-office"></i>
					</div>
					<div class="page-title">
						<h5>Profile</h5>
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
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="nav-item">
						<a class="nav-link active" id="profile-tab" data-toggle="tab" data-target="#profile" role="tab" aria-controls="profile" aria-selected="false">Change Password</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" ng-click="getSchoolDetails()" id="home-tab" data-toggle="tab" data-target="#home" role="tab" aria-controls="home" aria-selected="true">View Profile</a>
					</li>
				</ul>
				<div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
						<p ng-show="errormsg != ''" style="color:red; font-size:18px">{{errormsg}}</p>
                        <p ng-show="successmsg != ''" style="color:green; font-size:18px">{{successmsg}}</p>
						<div class="col-md-8 col-sm-9 col-xs-10">
							<form>
								<div class="form-group">
									<label class="form-label">Old Password</label>
									<div class="controls">
										<input type="password" ng-model="opsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">New Password</label>
									<div class="controls">
										<input type="password" ng-model="npsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Confirm New Password</label>
									<div class="controls">
										<input type="password" ng-model="cpsw" class="form-control">
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-primary" name="submit" ng-click="changePassword();">Change Now</button>
								</div>
							</form>
						</div>
					</div>
					
					
					<div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div class="main-content">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="profileimg">
						<div class="del-prof-img profileImageHeader"><i class="icon-trash" ng-click="removeProfilePic(studentData.childphoto)"></i></div>
							<img ng-show="studentData.childphoto != ''" class="img-fluid img-circle" src="<?=base_url();?>img/child/{{studentData.childphoto}}" alt="Student profile" />
							<img ng-show="studentData.childphoto == ''" class="img-fluid img-circle" src="<?= base_url(); ?>img/default-profilePic.png" />
						</div>
					</div>
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="card-body full-detail">
							<ul>
								<li class="current_class"><span>Name:</span>{{studentData.childfname+' '+studentData.childmname+' '+studentData.childlname}}</li>
								<li><span>Date Of Birth:</span> {{studentData.childdob}}</li>
								<li><span>Gender:</span> {{studentData.childgender}}</li>
								<li><span>Reg. ID:</span> {{studentData.childRegisterId}}</li>
								<li><span>Address:</span> {{studentData.childaddress}}</li>
								<li><span>Blood Group:</span> {{studentData.childbg}}</li>
								<li><span>Health Details:</span> {{studentData.healthdetail?studentData.healthdetail:'N/A'}}</li>
								<li><span>Email Id:</span> {{studentData.childemail?studentData.childemail:'N/A'}}</li>
								<li><span>Allergy:</span> {{studentData.allergy?studentData.allergy:'N/A'}}</li>
								<li><span>Special Needs:</span> {{studentData.specialneed?studentData.specialneed:'N/A'}}</li>
								<li><span>Applicable Medication:</span> {{studentData.applicablemedication?studentData.applicablemedication:'N/A'}}</li>
								<li><span>View Certificate:</span> <a target="_blank" download="{{studentData.childcertificate}}" href="<?php echo base_url();?>img/child/{{studentData.childcertificate}}"><i class="fa fa-file"></i></a></li>
								<li><span>Hobies:</span> <input type="text" ng-model="hobies" class="form-control" name="hobies" placeholder="Please enter your hobies"/><i ng-click="addHobies(hobies)" class="fa fa-plus"></i></li>
								<li>
								<ul>

								<li ng-repeat="hobieList in studentHobieData track by $index"><input type="text" ng-class="{'AddBorder':studentHobieData[$index].id==editHobieObj.id}" ng-readonly="studentHobieData[$index].id!=editHobieObj.id" ng-model="studentHobieData[$index].hobie_name"/> <i class="icon-edit2" ng-show="studentHobieData[$index].id!=editHobieObj.id" ng-click="editHobieButton(hobieList);"></i> <i class="icon-save2" ng-show="studentHobieData[$index].id==editHobieObj.id" ng-click="updateHobie(hobieList);"></i> <i ng-click="hobieDelete(hobieList.id,hobieList)" class="icon-trash2"></i></li>
								</ul>

								</li>
								<li><span>Quotes:</span> <input type="text" ng-model="quotes" class="form-control" name="quotes" placeholder="Please enter your quotes"/><i class="fa fa-plus" ng-click="addQuotes(quotes)"></i></li>
								<li>
								<ul>
								<li ng-repeat="quoteList in studentQuoteData track by $index"><input type="text" ng-class="{'AddBorder':studentQuoteData[$index].id==editQuoteObj.id}" ng-readonly="studentQuoteData[$index].id!=editQuoteObj.id" ng-model="studentQuoteData[$index].quote_name"/> <i class="icon-edit2" ng-show="studentQuoteData[$index].id!=editQuoteObj.id" ng-click="editQuoteButton(quoteList);"></i> <i class="icon-save2" ng-show="studentQuoteData[$index].id==editQuoteObj.id" ng-click="updateQuote(quoteList);"></i> <i ng-click="quoteDelete(quoteList.id,quoteList)" class="icon-trash2"></i></li>
								</ul>
								</li>
							</ul>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>