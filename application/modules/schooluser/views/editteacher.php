<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-user-tie"></i>
					</div>
					<div class="page-title">
						<h5>Edit Teacher</h5>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="">
			<div class="add-teacher">
				<form name="myForm">
					<div class="card">
						<div class="card-body">
							<div class="row">
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">First Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="teacherfname">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Middle Name</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="teachermname">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Last Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="teacherlname">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Email Id<em>*</em></label>
										<div class="controls">
											<input type="email" name="teacheremail" class="form-control input" ng-model="teacheremail">
											<span class="help-block">
												<span ng-show="myForm.teacheremail.$error.required">Email Address is.</span>
												<span ng-show="myForm.teacheremail.$error.email">Not a valid email!</span>
											</span>
										</div>
									</div>
								</div>
							<div class="col-md-4 col-sm-6 col-xs-12">
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
							<div class="col-md-4 col-sm-6 col-xs-12">
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
<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Contact Number<em>*</em></label>
										<div class="controls">
											<input class="form-control" name="teacherphone" type="text" ng-model="teacherphone" ng-intl-tel-input="" data-default-country="in" />
											<span class="help-block" ng-show="myForm.teacherphone.$invalid && myForm.teacherphone.$touched">Invalid</span>
											<span class="help-blockValid ng-hide" ng-show="myForm.teacherphone.$valid && myForm.teacherphone.$touched">Valid</span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Gender<em>*</em></label>
										<div class="controls">
											<select class="form-control" ng-model="teachergender">
												<option value="Male">Male</option>
												<option value="Female">Female</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Marital Status<em>*</em></label>
										<div class="controls">
											<select class="form-control" ng-model="maritalStatus">
												<option value="Single">Single</option>
												<option value="Married">Married</option>
												<option value="Divorced">Divorced</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Spouse Name/Father Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="spousename">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Contact Number of Spouse/Father<em>*</em></label>
										<div class="controls">
											<input class="form-control" name="spousenumber" type="text" ng-model="spousenumber" ng-intl-tel-input="" data-default-country="in" />
											<span class="help-block" ng-show="myForm.spousenumber.$invalid && myForm.spousenumber.$touched">Invalid</span>
											<span class="help-blockValid ng-hide" ng-show="myForm.spousenumber.$valid && myForm.spousenumber.$touched">Valid</span>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Date of Joining<em>*</em></label>
										<div class="controls">
											<input type="date" onkeydown="return false" class="form-control" ng-model="date_of_joining" max="<?=date('Y-m-d')?>">
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Blood Group</label>
										<div class="controls">
											<select class="form-control" ng-model="bloodgroup">
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
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Date of Birth<em>*</em></label>
										<div class="controls">
											<input type="date" onkeydown="return false" class="form-control" ng-model="date_of_birth" max="<?=date('Y-m-d')?>">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Religion</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="religion">
										</div>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group multi-dorpdown-list">
										<label class="form-label">School Type<em>*</em></label>
										<div class="controls">
											<select class="form-control" ng-init="schoolType = array[schoolType]" ng-model="schoolType" multiple="multiple">
											<option value="{{type.value}}" ng-repeat="type in schoolTypeList">{{type.name}}</option>
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group multi-dorpdown-list">
										<label class="form-label">Assign Class Teacher<em>*</em></label>
										<div class="controls">
											<select class="form-control" ng-model="assignclassteacher" multiple="multiple">
												<option ng-repeat="class in classList" value="{{class.id}}" ng-selected="{{assignclassteacher.indexOf(class.id.toString())!=-1}}">{{class.class}} - {{class.section}}</option>
											</select>
											<!--select class="form-control" ng-init="assignclassteacher = array[assignteacher]" ng-model="assignclassteacher" ng-options="obj as (obj.class + '-' + obj.section) for obj in classList track by obj.id" multiple="multiple"></select-->
										</div>
									</div>
								</div>
								<!-- <div class="col-md-4 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Subject Teacher</label>
										<div class="controls">
											<select class="form-control" ng-model="subjectteacher">
												<option ng-repeat="subject in subjectList" value="{{subject.subject}}">{{subject.subject}}</option>
											</select>
										</div>
									</div>
								</div> -->
								
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-label">Address<em>*</em></label>
										<div class="controls">
											<input class="form-control" ng-model="teacheraddress" id="teacheraddress" ng-change="getAutoSuggesions('teacheraddress');" />
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Country</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="tcountry" id="teacheraddresscountry" disabled="true"/>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">State</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="tstate" id="teacheraddressadministrative_area_level_1" disabled="true"/>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">City</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="tcity" id="teacheraddresslocality" disabled="true"/>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Postal Code</label>
										<div class="controls">
											<input type="text" class="form-control" ng-model="tpincode" id="teacheraddresspostal_code" disabled="true"/>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12 mt-2">
									<div class="form-group">
										<label class="form-label">Upload Profile Image<em>*</em></label>
										<div class="btn-uploadprof uploadcertificate" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload" id="teacherphoto" accept="image/png, image/jpeg" ng-model="teacherphoto" type="file">
												<span>Browse</span>
											</span>
										</div>
									</div>
								</div>
								
								<div class="col-md-6 col-sm-6 col-xs-12 mt-2">
									<div class="form-group">
										<label class="form-label">Upload Health Certificate</label>
										<div class="btn-uploadprof uploadcertificate" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="health" ng-model="health" type="file">
												<span>Browse</span>
											</span>
										</div>
									</div>
								</div>
                                                                
                                                                
                                                                
                                                                
								
								<div class="col-md-6 col-sm-6 col-xs-12 mt-2">
									<div class="form-group">
										<label class="form-label">Upload Identification Document</label>
										<div class="btn-uploadprof uploadcertificate" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="identification" ng-model="identification" type="file">
												<span>Browse</span>
											</span>
										</div>
									</div>
								</div>
                                                                
                                                                
                                                                <div class="col-md-6 col-sm-6 col-xs-12 mt-2">
									<div class="form-group">
										<label class="form-label">Upload Signature Image</label>
                                                                                
                                                                                
                                                                                
										<div class="btn-uploadprof uploadcertificate" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="signatureImg" ng-model="signatureImg" type="file">
												<span>Browse</span>
											</span>
										</div>
									</div>
								</div>
                                                                
                                                                
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-body row">
							
							<div class="col-md-12 col-sm-12 col-xs-12 multilist-container">
								<label class="form-label">Education Qualification</label>
								<div class="bg-container col-md-12">
									<div class="heading">
										<div class="row">
											<div class="col-md-2">
												<label class="form-label">Qualification</label>
											</div>
											<div class="col-md-2">
												<label class="form-label">Year of Passing</label>
											</div>
											<div class="col-md-2">
												<label class="form-label">Percentage</label>
											</div>
											<div class="col-md-2">
												<label class="form-label">Board</label>
											</div>
											<div class="col-md-3">
												<label class="form-label">Upload Certificate</label>
											</div>
										</div>
									</div>
									<div class="row education-row" ng-repeat="educationalfield in educationalfields track by $index">
										<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="form-group">
												
												<div class="controls">
													<input type="text" name="qualification" class="form-control" ng-model="educationalfields[$index].qualification" />
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="form-group">
												
												<div class="controls">
													<input type="text" pattern="^[0-9]+$" ng-pattern-restrict name="yearofpassing" class="form-control" ng-model="educationalfields[$index].year_of_passing" />
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="form-group">
												
												<div class="controls">
													<input type="text" pattern="^[0-9]+$" ng-pattern-restrict name="percentage" class="form-control" ng-model="educationalfields[$index].percentage" />
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="form-group">
												
												<div class="controls">
													<input type="text" name="board" class="form-control" ng-model="educationalfields[$index].board" />
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12">
											<div class="form-group">
												
												<div class="btn-uploadprof education-proff uploadcertificate">
													<span>
														<i class="icon-camera-outline"></i>
														<input type="hidden" ng-model="educationalfields[$index].educationcertificate" />
														<input class="file-upload" name="qualificationCertificate"type="file" id="educationcertificate{{$index}}" onchange="angular.element(this).scope().uploadEducationCertificate(this.files, angular.element(this).scope().$index)"/>
														<span>Browse</span>
													</span>
												</div>
											</div>
										</div>
										<div class="col-md-2 col-sm-2 col-xs-12 ">
											<div class="form-group float-right">
												<button type="button" ng-show="$index == 0" class="add-btn" ng-click="addEducationalFields()">
												<i>+</i><span>Add</span></button>
												<button type="button" ng-show="$index > 0" class="add-btn delete-btn" ng-click="removeEducationalFields($index)">
												<i class="icon-trash"></i><span>Delete</span></button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="card">
						<div class="card-body row">
							<div class="col-md-12">
								<label class="form-label">Previous Work Experience<em>*</em></label>
								<div class="row">
									<div class="col-md-3 col-sm-6">
										
										<div class="form-radio">
											<label class="form-check-label">Fresher
												<input class="form-check-input" ng-model="workexp" type="radio" name="exp" value="fresher" id="Fresher">
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
									<div class="col-md-3 col-sm-6">
										<div class="form-radio">
											<label class="form-check-label">Experience
												<input class="form-radio-input" ng-model="workexp" type="radio" name="exp" value="experience" id="experience">
												<span class="checkmark"></span>
											</label>
										</div>
									</div>
								</div>
								<div class="col-md-12 exp-container">
									<div class=" multilist-container">
										
										<div class="heading ">
											<div class="row">
												<div class="col-md-2">
													<label class="form-label">School Name</label>
												</div>
												<div class="col-md-1 p0">
													<label class="form-label">Number of Years</label>
												</div>
												<div class="col-md-2">
													<label class="form-label">Designation</label>
												</div>
												<div class="col-md-2">
													<label class="form-label">Date From</label>
												</div>
												<div class="col-md-2">
													<label class="form-label">Date To</label>
												</div>
												<div class="col-md-3">
													<label class="form-label">Upload Employer Certificate</label>
												</div>
												
											</div>
										</div>
										<div class="row exp-row" ng-repeat="experiancefield in experiancefields track by $index">
											<div class="col-md-2 col-sm-2 col-xs-12">
												<div class="form-group">
													
													<div class="controls">
														<input type="text" class="form-control" ng-model="experiancefields[$index].schoolname">
													</div>
												</div>
											</div>
											<div class="col-md-1 col-sm-1 col-xs-12">
												<div class="form-group">
													
													<div class="controls">
														<input type="text" pattern="^[0-9]+$" ng-pattern-restrict class="form-control" ng-model="experiancefields[$index].numofyears">
													</div>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<div class="form-group">
													
													<div class="controls">
														<input type="text" class="form-control" ng-model="experiancefields[$index].designation">
													</div>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<div class="form-group">
													
													<div class="controls">
														<input type="date" onkeydown="return false" class="form-control" ng-model="experiancefields[$index].datefrom" max="">
													</div>
												</div>
											</div>
											<div class="col-md-2 col-sm-2 col-xs-12">
												<div class="form-group">
													
													<div class="controls">
														<input type="date" onkeydown="return false" class="form-control" ng-model="experiancefields[$index].dateto" max="">
													</div>
												</div>
											</div>
											
											<div class="col-md-3 col-sm-3 col-xs-12  inline-flex ">
												<div class="form-group exp-wrapper d-inline-flex  ">
													
													<div class="btn-uploadprof education-proff uploadcertificate d-inline-flex  ">
														<span>
															<i class="icon-camera-outline"></i>
															<input type="hidden" ng-model="experiancefields[$index].experiencecertificate" />
															<input class="file-upload" name="experiencecertificate"type="file" id="experiencecertificate{{$index}}" onchange="angular.element(this).scope().uploadExperienceCertificate(this.files, angular.element(this).scope().$index)"/>
															<span>Browse</span>
														</span>
													</div>
												</div>
												<div class="form-group d-inline-flex float-right">
													<button type="button" ng-show="$index == 0" class="add-btn" ng-click="addExperianceFields()">
												<i>+</i><span>Add</span></button>
												<button type="button" ng-show="$index > 0" class="add-btn delete-btn" ng-click="removeExperianceFields($index)">
												<i class="icon-trash"></i><span>Delete</span></button>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>
						</div>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 mt-2 p-0">
						<div class="form-group">
							<button class="btn btn-primary" ng-disabled="myForm.$invalid" ng-click="editTeacher()">Update Teacher</button>
							<a class="btn btn-secondary" href="#!/teacher-list">Back To List</a>
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