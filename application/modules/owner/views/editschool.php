<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 d-flex">
					<div class="page-icon">
						<i class="icon-school mt-2"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>Edit School</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-4">
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
			<div class="card-body">
				<form name="myForm">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">School Name</label>
								<div class="controls">
									<input type="text" class="form-control" id="full-name" value="" ng-model="schoolname">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="email" id="emailid" disabled>
								</div>
							</div>
						</div>
                                            
                                            
						<div class="col-md-6 col-sm-6 col-xs-12">
                                                    <div class="row">
                                                        
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country* </label>
								<div class="controls">
                                                                    
                                                                    <select ng-model="countrycode" class="form-control" id="countrycode">
                                                                    <option >Please Select</option>
                                                                    <option selected="{{countrycode == country.id}}"  ng-repeat="country in countryCodes" value="{{country.id}}" >{{country.name}}</option>
                                                                    </select>
                                                                    
								</div>
							</div>
                                                        </div>
                                                        
                                                        
                                                        <div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Phone Number</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="phone" id="phone" name="phone" ng-intl-tel-input="" data-default-country="in">
                                                                         <span class="help-block" ng-show="myForm.phone.$invalid && myForm.phone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.phone.$valid && myForm.phone.$touched">Valid</span>
								</div>
							</div>
                                                      </div>
                                                      </div>   
						</div>
                                            
                                            
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Average No of Student</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="avgStudent">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Average No. of Staff</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="avgStaff">
								</div>
							</div>
						</div>
<!--						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Currency</label>
								<div class="controls">
									 <input type="text" class="form-control" ng-model="currency"> 
									
									<select class="form-control" ng-model="currency">
									<option value="" selected="selected">Select Currency</option>
                                                                        <option selected="{{currency == curr.id}}"  ng-repeat="curr in currencies" value="{{curr.id}}" >{{curr.currency_name}}</option>
                                                                        
										
									</select>
								</div>
							</div>
						</div>-->
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Area</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="area">
								</div>
							</div>
						</div>

                                                <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Bank Name<em>*</em></label>
												<div class="controls">
													<input type="text" class="form-control" ng-model="bank_name">
												</div>
											</div>
										</div>
                                                                                
                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Account Number<em>*</em></label>
												<div class="controls">
													<input type="text" class="form-control" ng-model="account_number" numericonly>
												</div>
											</div>
										</div>
                                                                                
                                                                                 <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Sort Code<em>*</em></label>
												<div class="controls">
													<input type="text" class="form-control" ng-model="sort_code">
												</div>
											</div>
										</div> 

                                                                                <div class="col-md-6 col-sm-6 col-xs-12">
											<div class="form-group">
												<label class="form-label">Sub Account Number<em>*</em></label>
												<div class="controls">
													<input type="text" class="form-control" ng-model="sub_acc_number">
												</div>
											</div>
										</div>      


						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Location</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="location">Address goes here</textarea>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">City</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="city">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">State</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="state">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">Pin Code</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="pincode">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mission</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="mission"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Vision</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="vision"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Core Values</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="coreValues"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Motto</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="motto"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Other Information</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="otherinfo"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group select_mutli">
								<label class="form-label">School Type</label>
								<div class="controls">
									<select class="form-control" ng-init="schoolType = array[schoolTypeNew]" ng-model="schoolType" multiple="multiple">
									<option value="{{type.value}}" ng-repeat="type in schoolTypeList">{{type.name}}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="form-group">
								<label class="form-label">Social Media Handle</label>
								<div class="row controls">
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<input type="text" class="form-control" placeholder="Facebook link" ng-model="facebook">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<input type="text" class="form-control" placeholder="Twitter link" ng-model="twitter">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<input type="text" class="form-control" placeholder="YouTube link" ng-model="youtube">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<input type="text" class="form-control" placeholder="Linkedin link" ng-model="linkdin">
									</div>
									<div class="col-md-6 col-sm-6 col-xs-12 form-group">
										<input type="text" class="form-control" ng-model="skypeid">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 mb-3">
							<div class="profileimg">
								<div class="del-prof-img profileImageHeader" style="cursor: pointer;"><i class="icon-trash" ng-click="removeProfilePic()"></i></div>
								<img class="img-fluid img-circle" src="<?php echo base_url(); ?>img/school/{{pic}}" alt="User profile" />
							</div>
							<div class="btn-uploadprof">
								<span>
									<i class="icon-camera-outline"></i>
									<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" type="file">
									<span>Change Logo</span>
								</span>
							</div>
						</div>
						<div class="form-group col-md-12">
							<button class="btn btn-info" style="cursor: pointer;" ng-click="updateProfileSchool();">Save Changes</button>
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