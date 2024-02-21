<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
	<div class="row">

		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
			<div class="page-icon">
				<i class="icon-user"></i>
			</div>
			<div class="page-title">
				<h5>Edit Sub Admin</h5>
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
<div class="main-content">
<div class="card">
	<div class="card-body">
		<form name="myForm">
			<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="form-group">
					<label class="form-label">Select Role<em>*</em></label>
					<div class="controls">
					<select class="form-control" ng-model="role">
					<option value="">Select Role</option>
					<option ng-repeat="role in activeRoleList" value="{{role.id}}">{{role.name}}</option>
					</select> <a href="#!/add-role">Add New Role</a>
					</div>
				</div>
			</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Name<em>*</em></label>
						<div class="controls">
							<input type="text" class="form-control" id="sub-admin-name" ng-model="name" placeholder="Name">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Email Id<em>*</em></label>
						<div class="controls">
							<input type="email" class="form-control" id="sub-admin-id" ng-model="email" placeholder="Email Address">
							<span class="help-block">
							<span ng-show="myForm.email.$error.required">Email Address is required.</span>
							<span ng-show="myForm.email.$error.email">Not a valid email!</span>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Phone Number<em>*</em></label>
						<div class="controls">
						<input class="form-control" name="phone" type="text" ng-model="phone" ng-intl-tel-input="" data-default-country="in" />
						<span class="help-block" ng-show="myForm.phone.$invalid && myForm.phone.$touched">Invalid</span>
						<span class="help-blockValid ng-hide" ng-show="myForm.phone.$valid && myForm.phone.$touched">Valid</span>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Designation<em>*</em></label>
						<div class="controls">
							<input type="text" class="form-control" id="sub-admin-phone" ng-model="designation" placeholder="Designation">
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Password</label>
						<div class="controls">
							<input type="password" class="form-control" id="password" ng-model="password" placeholder="Password">
							<span class="help-block" ng-show="myForm.password.$dirty && myForm.password.$invalid">
							Pasword must be at least 6 characters long.
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-4 col-sm-4 col-xs-12">
					<div class="form-group">
						<label class="form-label">Confirm Password</label>
						<div class="controls">
							<input type="password" class="form-control" name="confirmpassword" id="confirmpassword" ng-model="confirmpassword" placeholder="Confirm Password" compare-to="password">
							<span class="help-block" ng-show="myForm.confirmpassword.$dirty && myForm.confirmpassword.$invalid">
							Not matched to password.
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="form-label">Address (<small>Full Address</small>)<em>*</em></label>
						<div class="controls">
						<input class="form-control" ng-model="address" id="address" ng-change="getAutoSuggesions('address');" />
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
						<label class="form-label">Country</label>
						<div class="controls">
						<input type="text" class="form-control" ng-model="country" id="addresscountry" disabled="true"/>
					</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
						<label class="form-label">State</label>
						<div class="controls">
							<input type="text" class="form-control" ng-model="state" id="addressadministrative_area_level_1" disabled="true"/>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
						<label class="form-label">City</label>
						<div class="controls">
						<input type="text" class="form-control" ng-model="city" id="addresslocality" disabled="true"/>
					</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-12">
					<div class="form-group">
						<label class="form-label">Pin Code</label>
						<div class="controls">
							<input type="text" class="form-control" ng-model="pincode" pattern="^[0-9]+$" ng-pattern-restrict id="addresspostal_code" disabled="true"/>
						</div>
					</div>
				</div>

				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="form-label">Other Information</label>
						<textarea class="form-control" ng-model="otherinfo" rows="5"></textarea>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
								<img ng-show="isImage(fileExt)" ngf-src="photo[0]" class="thumb">
								<img class="img-fluid img-circle" src="<?=base_url() ?>img/school/subadmin/{{pics}}" alt="User profile" />
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ng-model="photo" accept="image/png, image/jpeg" type="file" />
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
				<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
				<div class="form-group">
					<button class="btn btn-primary" ng-disabled="myForm.$invalid" ng-click="editSubadmin()" name="submit">Edit Sub Admin</button>
					<a class="btn btn-secondary" href="#!/subadmin-list">Back To List</a>
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