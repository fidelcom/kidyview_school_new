BEGIN .app-main -->
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
						<h5>Edit Parent</h5>
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
					<div class="divide-box row">
						<div class="col-md-6 col-sm-6 col-xs-12">
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
									<input class="form-control" ng-model="fatheraddress" id="fatheraddress" ng-change="getAutoSuggesions('fatheraddress');" autocomplete="false" />
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
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="profileimg">
									<img ng-if="(fatherphoto)" class="img-fluid img-circle" src="<?=base_url() ?>img/parent/{{fatherphoto}}" alt="User profile" />
									<img ng-if="(fatherphoto == '')" class="img-fluid img-circle" src="<?=base_url() ?>img/noImage.png" alt="User profile" />
								</div>
								<div class="btn-uploadprof uploadlogo">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" id="fpic" accept="image/png, image/jpeg" ng-model="fatherphoto" type="file">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="divide-box row">
						<div class="col-md-6 col-sm-6 col-xs-12">
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
									<input class="form-control" ng-model="motheraddress" id="motheraddress" ng-change="getAutoSuggesions('motheraddress');" autocomplete="false" />
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
						<div class="col-md-6 col-sm-12 col-xs-12">
							<div class="form-group">
								<!-- <div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="motherphoto[0]" class="thumb">
								</div> -->
								<div class="profileimg">
									<img ng-if="(motherphoto)" ngf-select="" ngf-change="onChange($files)" class="img-fluid img-circle" src="<?=base_url() ?>img/parent/{{motherphoto}}" alt="User profile" />
									<img ng-if="(motherphoto == '')" ngf-select="" ngf-change="onChange($files)" class="img-fluid img-circle" src="<?=base_url() ?>img/noImage.png" alt="User profile" />
								</div>
								<div class="btn-uploadprof uploadlogo">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" id="mpic" accept="image/png, image/jpeg" ng-model="motherphoto" type="file">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
					</div>
					 
					<div class="divide-box row">
						<div class="col-md-6 col-sm-6 col-xs-12">
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
									<input class="form-control" ng-model="emergencyaddress" id="emergencyaddress" ng-change="getAutoSuggesions('emergencyaddress');" autocomplete="false" />
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
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<div class="profileimg">
									<img ng-if="(emergencyphoto)" class="img-fluid img-circle" src="<?=base_url() ?>img/parent/{{emergencyphoto}}" alt="User profile" />
									<img ng-if="(emergencyphoto == '')" class="img-fluid img-circle" src="<?=base_url() ?>img/noImage.png" alt="User profile" />
								</div>
								<div class="btn-uploadprof uploadlogo">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" id="epic" accept="image/png, image/jpeg" ng-model="emergencyphoto" type="file">
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-9 col-xs-12">
							<div class="form-group mt-0 mb-0 mt-md-3 float-left float-md-right">
								<button type="button" class="btn btn-primary open-children" ng-show="childId == ''">Add Child</button>
								<button type="button" class="btn btn-primary open-children" ng-show="childId != ''">Add More Child</button>
							</div>
						</div>
					</div>
					
					<!--div class="divide-box row">
						<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="form-label">Guardian Name<em>*</em></label>
						<div class="row">
						<div class="controls col-md-6">
						<input type="text" class="form-control" ng-model="guardianfname" placeholder="Guardian First Name" >
						</div>
						<div class="controls col-md-6">
						<input type="text" class="form-control" ng-model="guardianlname" placeholder="Guardian Last Name">
						</div>
						</div>
						</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12">
						<div class="form-group">
						<label class="form-label">Email Id<em>*</em></label>
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
						<label class="form-label">Phone<em>*</em></label>
						<div class="controls">
						<input class="form-control" name="guardianphone" type="text" ng-model="guardianphone" ng-intl-tel-input="" data-default-country="in" />
						<span class="help-block" ng-show="myForm.guardianphone.$invalid && myForm.guardianphone.$touched">Invalid</span>
						<span class="help-blockValid ng-hide" ng-show="myForm.guardianphone.$valid && myForm.guardianphone.$touched">Valid</span>
						</div>
						</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="form-group">
						<label class="form-label">Address (<small>Full Address</small>)<em>*</em></label>
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
						<input type="text" class="form-control" ng-model="gpincode" pattern="^[0-9]+$" ng-pattern-restrict id="guardianaddresspostal_code" disabled="true"/>
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
						<div class="col-md-3 col-sm-3 col-xs-12">
						<div class="form-group">
						<div class="profileimg">
						<img class="img-fluid img-circle" src="<?=base_url() ?>img/parent/{{guardianphoto}}" alt="User profile" />
						</div>
						<div class="btn-uploadprof uploadlogo">
						<span>
						<i class="icon-camera-outline"></i>
						<input class="file-upload" id="gpic" accept="image/png, image/jpeg" ng-model="guardianphoto" type="file">
						<span>Change Photo</span>
						</span>
						</div>
						</div>
						</div>
					</div-->
					<div class="card-body children-data edit_children">
						<form>
							<div class="row">
								<!-- <div class="col-md-3 col-sm-3 col-xs-12">
									<div class="form-group">
										<label class="form-label">Registration ID<em>*</em></label>
										<div class="controls">
											<input type="text" ng-model="childRegisterId" class="form-control">
										</div>
									</div>
								</div> -->
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">First Name<em>*</em></label>
										<div class="controls">
											<input type="text" ng-model="childfname" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Middle Name</label>
										<div class="controls">
											<input type="text" ng-model="childmname" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Last Name<em>*</em></label>
										<div class="controls">
											<input type="text" ng-model="childlname" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
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
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Class<em>*</em></label>
										<div class="controls">
											<select class="form-control" ng-model="childclass">
												<option ng-repeat="class in classList"  value="{{class.id}}">{{class.class}} - {{class.section}}</option>
											</select>
										</div>
									</div>
								</div>
								<!--div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
									<label class="form-label">Section<em>*</em></label>
									<div class="controls">
									<select class="form-control" ng-model="childsection">
									<option ng-repeat="section in sectionList" value="{{section.section}}">Section {{section.section}}</option>
									</select>
									</div>
									</div>
								</div-->
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Date of Birth<em>*</em></label>
										<div class="controls">
											<input type="date" onkeydown="return false" ng-model="childdob" class="form-control" max="<?=date('Y-m-d')?>">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Email ID<em>*</em></label>
										<div class="controls">
											<input type="email" ng-model="childemail" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Health Detail</label>
										<div class="controls">
											<input type="text" ng-model="childhealthdetail" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Allergy</label>
										<div class="controls">
											<input type="text" ng-model="childallergy" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Special Need</label>
										<div class="controls">
											<input type="text" ng-model="childSpecialneed" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<label class="form-label">Applicable Medication</label>
										<div class="controls">
											<input type="text" ng-model="childApplicablemedication" class="form-control">
										</div>
									</div>
								</div>
								<div class="col-md-4 col-sm-4 col-xs-12">
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
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<div class="upload-preview-box">
											<img ng-show="isImage(fileExt)" ngf-src="childphoto[0]" class="thumb">
										</div>
										<label class="form-label">Upload Image</label>
										<div class="btn-uploadprof" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ng-model="childphoto" accept="image/png, image/jpeg,image/jpg" type="file" />
												<span>Upload Photo</span>
											</span>
											<!-- <span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="childphoto" type="file">
												<span>Upload Photo</span>
											</span> -->
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<div class="upload-preview-box">
											<img ng-show="isImage(fileExt)" ngf-src="childcertificate[0]" class="thumb">
										</div>
										<label class="form-label">Upload Certificates</label>
										<div class="btn-uploadprof" style="width:300px;">
											<span>
												<i class="icon-camera-outline"></i>
												<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="certificate" ng-model="childcertificate" type="file">
												<span>Upload Certificate</span>
											</span>
										</div>
									</div>
									<div class="form-group float-right">
										<button class="btn btn-primary" ng-disabled="isChildSubmit" ng-click="addChild()">Save Child</button>
									</div>
								</div>
							</div>
						</form>
					</div>
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group float-left">
								<button class="btn btn-primary btn-sm" ng-disabled="myForm.$invalid" ng-click="editParent()" name="submit">Update Parent</button>
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
<!-- END: .app-main	