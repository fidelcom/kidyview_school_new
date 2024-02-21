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
						<h5>Add Parents</h5>
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
				<p>Note* : You have to enter atleast one parent detail section between father or mother to add parent. </p>
				<form name="myForm">
					<div class="divide-box row">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Father Name<em>*</em></label>
								<div class="row">
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="fatherfname" placeholder="Father First Name">
									</div>
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="fatherlname" placeholder="Father Last Name">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Occupation</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="fatheroccupation">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email Id<em>*</em></label>
								<div class="controls">
									<input type="email" name="fatheremail" class="form-control input" ng-model="fatheremail">
									<span class="help-block">
										<span ng-show="myForm.fatheremail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.fatheremail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mobile<em>*</em></label>
								<div class="controls">
									<input class="form-control" name="fatherphone" type="text" ng-model="fatherphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.fatherphone.$invalid && myForm.fatherphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.fatherphone.$valid && myForm.fatherphone.$touched">Valid</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address (<small>Full Address</small>)</label>
								<div class="controls">
									<input class="form-control" ng-model="fatheraddress" id="fatheraddress" ng-change="getAutoSuggesions('fatheraddress');" />
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="fcity" id="fatheraddresslocality" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="fstate" id="fatheraddressadministrative_area_level_1" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Postal Code</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="fpincode" id="fatheraddresspostal_code" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="fcountry" id="fatheraddresscountry" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="fatherphoto[0]" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="fpic" ng-model="fatherphoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="divide-box row">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mother Name<em>*</em></label>
								<div class="row">
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="motherfname" placeholder="Mother First Name" >
									</div>
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="motherlname" placeholder="Mother Last Name">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Occupation</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="motheroccupation">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email Id<em>*</em></label>
								<div class="controls">
									<input type="email" name="motheremail" class="form-control input" ng-model="motheremail">
									<span class="help-block">
										<span ng-show="myForm.motheremail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.motheremail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mobile<em>*</em></label>
								<div class="controls">
									<input class="form-control" name="motherphone" type="text" ng-model="motherphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.motherphone.$invalid && myForm.motherphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.motherphone.$valid && myForm.motherphone.$touched">Valid</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address (<small>Full Address</small>)</label>
								<div class="controls">
								<input class="form-control" ng-model="motheraddress" id="motheraddress" ng-change="getAutoSuggesions('motheraddress');" />
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="mcity" id="motheraddresslocality" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="mstate" id="motheraddressadministrative_area_level_1" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Postal Code</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="mpincode" id="motheraddresspostal_code" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="mcountry" id="motheraddresscountry" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="motherphoto[0]" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="mpic" ng-model="motherphoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					
					<div class="divide-box row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Emergency Contact Name</label>
								<div class="row">
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="emergencyfname" placeholder="emergency First Name" >
									</div>
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="emergencylname" placeholder="emergency Last Name">
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email Id</label>
								<div class="controls">
									<input type="email" name="emergencyemail" class="form-control input" ng-model="emergencyemail">
									<span class="help-block">
										<span ng-show="myForm.emergencyemail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.emergencyemail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mobile</label>
								<div class="controls">
									<input class="form-control" name="emergencyphone" type="text" ng-model="emergencyphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.emergencyphone.$invalid && myForm.emergencyphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.emergencyphone.$valid && myForm.emergencyphone.$touched">Valid</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address (<small>Full Address</small>)</label>
								<div class="controls">
									<input class="form-control" ng-model="emergencyaddress" id="emergencyaddress" ng-change="getAutoSuggesions('emergencyaddress');" />
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="ecity" id="emergencyaddresslocality" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="estate" id="emergencyaddressadministrative_area_level_1" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Postal Code</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="epincode" id="emergencyaddresspostal_code" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="ecountry" id="emergencyaddresscountry" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="emergencyphoto[0]" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="epic" ng-model="emergencyphoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					
					<div class="divide-box row">
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Guardian Name</label>
								<div class="row">
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="guardianfname" placeholder="Guardian First Name" >
									</div>
									<div class="controls col-md-6 col-sm-6">
										<input type="text" class="form-control" ng-model="guardianlname" placeholder="Guardian Last Name">
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email Id</label>
								<div class="controls">
									<input type="email" name="guardianemail" class="form-control input" ng-model="guardianemail">
									<span class="help-block">
										<span ng-show="myForm.guardianemail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.guardianemail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mobile</label>
								<div class="controls">
									<input class="form-control" name="guardianphone" type="text" ng-model="guardianphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.guardianphone.$invalid && myForm.guardianphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.guardianphone.$valid && myForm.guardianphone.$touched">Valid</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address (<small>Full Address</small>)</label>
								<div class="controls">
									<input class="form-control" ng-model="guardianaddress" id="guardianaddress" ng-change="getAutoSuggesions('guardianaddress');" />
								</div>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="gcity" id="guardianaddresslocality" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="gstate" id="guardianaddressadministrative_area_level_1" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Postal Code</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="gpincode" id="guardianaddresspostal_code" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="gcountry" id="guardianaddresscountry" disabled="true"/>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="guardianphoto[0]" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="gpic" ng-model="guardianphoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<button class="btn btn-primary" ng-disabled="myForm.$invalid" ng-click="addParent()" name="submit">Add Parent</button>
								<a class="btn btn-secondary" href="#!/parent-list">Back To List</a>
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