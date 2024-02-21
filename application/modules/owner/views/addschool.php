<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-school"></i>
					</div>
					<div class="page-title">
						<h5>Add School</h5>
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
								<label class="form-label">School Name*</label>
								<div class="controls">
									<input type="text" class="form-control" id="full-name" ng-model="schoolname">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Email*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="email" id="emailid">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
                                                    
                                                    <div class="row">
                                                    
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">Country*</label>
								<div class="controls">
                                                                    
                                                                    <select ng-model="countrycode" class="form-control" id="countrycode" ng-change="getCountryCurrency(countrycode)">
                                                                    <option value="" selected="selected" >Please Select</option>
                                                                    <option ng-repeat="country in countryCodes" value="{{country.id}}" >{{country.name}}</option>
                                                                    </select>
                                                                    
								</div>
							</div>
                                                    </div>
                                                        
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                        <div class="form-group">
                                                                <label class="form-label">Currency *</label>
                                                                <div class="controls">

                                                                <select class="form-control" ng-model="currency">
                                                                <option value="" selected="selected">Select Currency</option>
                                                                <option selected="{{currency == curr.id}}"  ng-repeat="curr in currencies" value="{{curr.id}}" >{{curr.currency_name}}</option>
                                                                </select>
                                                                </div>
                                                        </div>
                                                    </div>
                                                        
                                                         
                                                    
                                                    
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">Phone Number*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="phone" id="phone" name="phone" ng-intl-tel-input="" data-default-country="in">
                                                                        <span class="help-block" ng-show="myForm.phone.$invalid && myForm.phone.$touched">Invalid</span>
									<span class="help-blockValid ng-hide" ng-show="myForm.phone.$valid && myForm.phone.$touched">Valid</span>
								</div>
							</div>
                                                    </div>    
                                                        
						</div>
                                              </div>
                                            
                                            
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                    
                                                <div class="row">
                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-group">
                                                                        <label class="form-label">Bank Name<em>*</em></label>
                                                                        <div class="controls">
                                                                                <input type="text" class="form-control" ng-model="bank_name">
                                                                        </div>
                                                                </div>
                                                        </div>

                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-group">
                                                                        <label class="form-label">Account Number<em>*</em></label>
                                                                        <div class="controls">
                                                                                <input type="text" class="form-control" ng-model="account_number" numericonly>
                                                                        </div>
                                                                </div>
                                                    </div>

                                                    <div class="col-md-4 col-sm-4 col-xs-12">
                                                                <div class="form-group">
                                                                        <label class="form-label">Sort Code<em>*</em></label>
                                                                        <div class="controls">
                                                                                <input type="text" class="form-control" ng-model="sort_code">
                                                                        </div>
                                                                </div>
                                                    </div>
                                                </div>
                                                
                                                
                                             </div>   
                                            
                                            
                                             
                                            
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Average No of Student*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="avgStudent">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Average No. of Staff*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="avgStaff">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Area*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="area">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Location*</label>
								<div class="controls">
									<textarea type="text" class="form-control" ng-model="location">Address goes here</textarea>
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">City*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="city">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">State*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="state">
								</div>
							</div>
						</div>
						<div class="col-md-4 col-sm-4 col-xs-12">
							<div class="form-group">
								<label class="form-label">Pin Code*</label>
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
										<input type="text" class="form-control" placeholder="SKype Id" ng-model="skypeid">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-3 col-sm-4 col-xs-12">
							<div class="btn-uploadprof">
								<span>
									<i class="icon-camera-outline"></i>
									<input class="file-upload" id="pic" ng-model="photo" type="file">
									<span>Upload Logo</span>
								</span>
							</div>
						</div>
						<div class="form-group col-md-12">
							<button class="btn btn-primary" ng-click="addSchool();">Add School</button>
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