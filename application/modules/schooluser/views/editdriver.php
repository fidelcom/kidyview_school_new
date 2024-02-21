<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="fas fa-car"></i>
					</div>
					<div class="page-title">
						<h5>Edit Driver</h5>
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
				<form class="DriverDetails" name="myForm">
					<div class="divide-box row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<label class="form-label">Driver Name<em>*</em></label>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">						
										<div class="controls">
											<input type="text" ng-model="driverfname" class="form-control" placeholder="First name">
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<div class="controls">
											<input type="text" ng-model="driverlname" class="form-control" placeholder="Last name">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email ID<em>*</em></label>
								<div class="controls">
									<input type="email" name="driveremail" class="form-control input" ng-model="driveremail">
									<span class="help-block">
										<span ng-show="myForm.driveremail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.driveremail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Phone Number<em>*</em></label>
								<div class="controls">
									<input class="form-control" name="driverphone" type="text" ng-model="driverphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.driverphone.$invalid && myForm.driverphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.driverphone.$valid && myForm.driverphone.$touched">Valid</span>
								</div>
							</div>
						</div>
                                            
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Select Vehicle<em>*</em></label>
                                                    <div class="controls">
                                                        <select ng-model="drivervehicle" class="form-control" id="drivervehicle" >
                                                            <option value="" selected="selected" >Please Select Vehicle</option>
                                                            <option ng-selected="{{vehicle.id == drivervehicle}}"  ng-repeat="vehicle in vehicleList" value="{{vehicle.id}}">{{vehicle.vehicle_name}} ({{vehicle.vcode}}) ({{vehicle.routepath}}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            
						<!--<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Device Number<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="driverdeviceId" class="form-control">
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Vehicle Number<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="drivervehicle" class="form-control">
								</div>
							</div>
						</div>
                                            
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Route (from-to)<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="driverroute" class="form-control">
								</div>
							</div>
						</div>	-->
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">License Number<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="driverlicense" class="form-control">
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">License Expire Date<em>*</em></label>
								<div class="controls">
									<input type="date" onkeydown="return false" ng-model="driverLicenseExpire" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Change Image</label>
								<div class="btn-uploadprof mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic"  ng-model="driverphoto" type="file">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<div class="profileimg">
								<img class="img-fluid img-circle" src="<?=base_url()?>img/driver/{{driverphoto}}" alt="User profile" />
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<div class="form-group" style="line-height:1.1;">								<label class="form-label">Change Documents <span class="dftcolor">(Insurance, Registration No., Pollution etc.)</span></label>
								<div class="btn-uploadprof mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="document"  ng-model="driverdocument" type="file">
										<span>Change Document</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<div class="profileimg">
								<img class="img-fluid img-circle" src="<?=base_url()?>img/driver/{{driverdocument}}" alt="User Document" />
							</div>
						</div>
						<div class="col-lg-12 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address<em>*</em></label>
								<div class="controls">
									<input class="form-control" ng-model="driveraddress" id="driveraddress" ng-change="getAutoSuggesions('driveraddress');" />
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Postal code</label>
								<div class="controls">
									<input type="text" ng-model="dpincode" class="form-control" id="driveraddresspostal_code" disabled="true"/>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">City </label>
								<div class="controls">
									<input type="text" ng-model="dcity" class="form-control" id="driveraddresslocality" disabled="true"/>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" ng-model="dstate" class="form-control" id="driveraddressadministrative_area_level_1" disabled="true"/>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country</label>
								<div class="controls">
									<input type="text" ng-model="dcountry" class="form-control" id="driveraddresscountry" disabled="true"/>
								</div>
							</div>
						</div>
					</div>
					<div class="divide-box row">
						<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
							<label class="form-label">Emergency Person Name<em>*</em></label>
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">						
										<div class="controls">
											<input type="text" ng-model="emergencyfname" class="form-control" placeholder="First name">
										</div>
									</div>
								</div>
								
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<div class="controls">
											<input type="text" ng-model="emergencylname" class="form-control" placeholder="Last name">
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Contact number<em>*</em></label>
								<div class="controls">
									<input class="form-control" name="emergencyphone" type="text" ng-model="emergencyphone" ng-intl-tel-input="" data-default-country="in" />
									<span class="help-block" ng-show="myForm.emergencyphone.$invalid && myForm.emergencyphone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.emergencyphone.$valid && myForm.emergencyphone.$touched">Valid</span>
								</div>
							</div>
						</div>	
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email id<em>*</em></label>
								<div class="controls">
									<input type="email" name="emergencyemail" class="form-control input" ng-model="emergencyemail">
									<span class="help-block">
										<span ng-show="myForm.emergencyemail.$error.required">Email Address is required.</span>
										<span ng-show="myForm.emergencyemail.$error.email">Not a valid email!</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 mt-2 p-0">
						<div class="form-group">
							<button class="btn btn-primary" ng-disabled="myForm.$invalid" ng-click="editDriver()">Update Driver</button>
							<a class="btn btn-secondary" href="#!/driver-list">Back To List</a>
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