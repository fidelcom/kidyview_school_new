<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-user-plus"></i>
					</div>
					<div class="page-title">
						<h5>Edit Child</h5>
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
				<form name="myForm">
					<div class="row">
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Registration ID<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="childRegisterId" class="form-control" readonly="readonly">
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">First Name<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="childfname" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Middle Name</label>
								<div class="controls">
									<input type="text" ng-model="childmname" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Last Name<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="childlname" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Gender<em>*</em></label>
								<div class="controls">
									<select class="form-control" ng-model="childgender">
										<option value="Male">Male</option>
										<option value="Female">Female</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Class<em>*</em></label>
								<div class="controls">
									<select class="form-control" ng-model="childclass">
										<option ng-repeat="class in classList"  value="{{class.id}}">{{class.class}} - {{class.section}}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Date of Birth<em>*</em></label>
								<div class="controls">
									<input type="date" onkeydown="return false" ng-model="childdob" class="form-control" max="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email ID<em>*</em></label>
								<div class="controls">
									<input type="email" name="childemail" ng-model="childemail" class="form-control">
									<span class="help-block">
										<span ng-show="myForm.childemail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.childemail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Health Detail</label>
								<div class="controls">
									<input type="text" ng-model="childhealthdetail" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Allergy</label>
								<div class="controls">
									<input type="text" ng-model="childallergy" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Special Need</label>
								<div class="controls">
									<input type="text" ng-model="childSpecialneed" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Applicable Medication</label>
								<div class="controls">
									<input type="text" ng-model="childApplicablemedication" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Blood group</label>
								<div class="controls">
									<select class="form-control" ng-model="childbg">
										<option value="A+">A Positive</option>
										<option value="A-">A Negative</option>
										<option value="B+">B Positive</option>
										<option value="B-">B Negative</option>
										<option value="AB+">AB Positive</option>
										<option value="AB-">AB Negative</option>
										<option value="O+">O Positive</option>
										<option value="O-">O Negative</option>
										<option value="unknown">Unknown</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Current Address</label>
								<div class="controls">
									<textarea class="form-control" ng-model="childaddress"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<!-- <div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="childphoto[0]" class="thumb">
								</div> -->
								<label class="form-label">Upload Image</label>
								<div class="childprofileimg">
									<img ng-if="(childphoto)" ngf-change="onChange($files)" src="<?= base_url() ?>img/child/{{childphoto}}" alt="User profile" />
									<img ng-if="(childphoto == '')" class="img-fluid img-circle" src="<?=base_url() ?>img/noImage.png" alt="User profile" />
								</div>
								<div class="btn-uploadprof" style="width:200px;">								
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" id="pic" ngf-select="" ngf-change="onChange($files)" accept="image/png, image/jpeg" ng-model="childphoto" type="file">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<!-- <div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="childcertificate[0]" class="thumb">
								</div> -->
								<label class="form-label">Upload Certificates</label>
								<div class="childprofileimg">
									<img ng-if="(childcertificate)" ngf-change="onChange($files)" src="<?= base_url() ?>img/child/{{childcertificate}}" alt="User profile" />
									<img ng-if="(childcertificate == '')" ngf-change="onChange($files)" class="img-fluid img-circle" src="<?=base_url() ?>img/noImage.png" alt="User profile" />
								</div>
								<div class="btn-uploadprof" style="width:300px;">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" id="certificate" ng-model="childcertificate" type="file">
										<span>Change Certificate</span>
									</span>
								</div>
							</div>
							<div class="form-group">
								<button class="btn btn-primary btn-sm" ng-disabled="myForm.$invalid" ng-click="editChild()">Update Child</button>
								<a class="btn btn-secondary btn-sm" href="#!/parent-list">Back To List</a>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->