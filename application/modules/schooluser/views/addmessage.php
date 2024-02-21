<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
					<div class="page-icon">
						<i class="icon-email"></i>
					</div>
					<div class="page-title">
						<h5>New message</h5>
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
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="inbox-body">
							<div class="mail-list">
								<div class="compose-mail">
									<form method="post">
										<div class="row">
											<div class="col-md-4 col-sm-4 col-xs-12 mb-2">
												<div class="form-group">
													<select class="form-control" ng-model="usertype" ng-change="getAllUser(usertype);">
														<option value="0">--Select--</option>
														<option value="Teacher">Teachers</option>
														<option value="Parent">Parent</option>
													</select>
												</div>
											</div>
											<div class="col-md-8 col-sm-4 col-xs-12 mb-2">
											<div ng-dropdown-multiselect="" options="userList" selected-model="user" checkboxes="true" extra-settings="setting1"></div>
                                    
									        </div>
												<!--<div class="form-group">
													<select class="form-control" ng-model="user">
														<option value="0">--Select--</option>
														<option ng-repeat="user in userList" value="{{user.id}}">{{user.fname}} {{user.lname}}</option>
													</select>
												</div>-->
											</div>
										</div>
										<div class="form-group col-md-12">
											<textarea class="form-control" ng-model="message" placeholder="Message"></textarea>
										</div>
										<div class="mt-4 col-md-12">
											<div class="btn-group send_btn">
												<button class="btn btn-primary btn-sm mr-3" ng-click="composemessage()"><i class="fa fa-check"></i> Send</button>
												<button class="btn btn-sm btn-default" ng-click="discarddetails()"><i class="fa fa-times"></i> Discard
												</button>
											</div>
											<div class="btn-uploadprof">
												<div class="upload-preview-box" ng-repeat ="data in previewData track by $index">
													<img src="{{data.src}}" class="thumb">
													<span ng-click="remove(data)" class="remove-photo"><i class="fa fa-close"></i></span>
												</div>
											</div>
											<div class="add-attach uploadlogo ">
												<span>
													<input class="files file-upload" ngf-select="" ngf-change="onChange($files)" name="pic[]" ng-model="pic" type="file" multiple="">
													<i class="icon-attachment4"></i>
												</span>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->