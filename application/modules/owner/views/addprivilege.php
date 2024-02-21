<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Add Privilege</h5>
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
						<form>
							<div class="row">
							
							<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Role<em>*</em></label>
										<div class="controls">
										<select class="form-control mb-4" ng-model="role">
										<option value="">Select Role</option>
										<option ng-repeat="role in activeRoleList" value="{{role.id}}">{{role.name}}</option>
										</select> <a href="#!/add-role">Add New Role</a>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="permission-container full-width">
										<div class="row heading">
											<div class="col-md-6"><label class="form-label">Module</label></div>
											<div class="col-md-6"><label class="form-label">Privileges</label></div>
										</div>
										<div class="row" ng-repeat="module in permissionRoleList">
											<div class="col-md-6  col-sm-6 col-xs-6">
												<div class="form-check">
													<label class="form-check-label">{{module.module_name}}
														<input class="form-check-input" type="checkbox" ng-model="module.module_name" ng-click="checlAllPrivilege(module)" ng-true-value="module.module_name" ng-checked="module.view==1 || module.add==1 || module.edit==1 || module.delete==1">
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
											<div class="col-md-6  col-sm-6 col-xs-6">
												<div class="row">
													<div class="col-md-3 col-sm-3 col-xs-6">
														<div class="form-check">
															<label class="form-check-label">View
																<input class="form-check-input" type="checkbox" ng-model="module.view" ng-true-value='1'>
																<span class="checkmark"></span>
															</label>
														</div>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6">
														<div class="form-check">
															<label class="form-check-label">Add
																<input class="form-check-input" type="checkbox" ng-model="module.add" ng-true-value='1' >
																<span class="checkmark"></span>
															</label>
														</div>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6">
														<div class="form-check">
															<label class="form-check-label">Edit
																<input class="form-check-input" type="checkbox" ng-model="module.edit" ng-true-value='1'>
																<span class="checkmark"></span>
															</label>
														</div>
													</div>
													<div class="col-md-3 col-sm-3 col-xs-6">
														<div class="form-check">
															<label class="form-check-label">Delete
																<input class="form-check-input" type="checkbox" ng-model="module.delete" ng-true-value='1'>
																<span class="checkmark"></span>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
									<button class="btn btn-primary" ng-click="addPrivilege()">Submit</button>
									<a class="btn btn-secondary" href="#!/privilege-list">Back To List</a>
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