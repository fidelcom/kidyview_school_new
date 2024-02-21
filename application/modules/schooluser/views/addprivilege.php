<?php 
	$schoolDetail 	= $this->session->all_userdata();
	$schoolID 		= $schoolDetail['user_data']['id'];
	$schoolPhoto 	= $schoolDetail['user_data']['pic'];
	$schoolName 	= $schoolDetail['user_data']['school_name'];
	$schoolEmail 	= $schoolDetail['user_data']['email'];
?>
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
							
							<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									<div class="form-group">
										<label class="form-label">Role<em>*</em></label>
										<div class="controls">
										<select class="form-control" ng-model="role">
										<option value="">Select Role</option>
										<option ng-repeat="role in activeRoleList" value="{{role.id}}">{{role.name}}</option>
										</select>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 mb-3">
									 <a class="float-right btn btn-primary" href="#!/add-role">Add New Role</a>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12 permission-container full-width">
							<div class="row heading">
								<div class="col-md-6 col-sm-5 col-6"><h5 class="mt-1">Module</h5></div>
								<div class="col-md-6 col-sm-7 col-6"><h5 class="mt-1">Privileges</h5></div>
							</div>
							<div class="row sm-text-label" ng-repeat="module in permissionRoleList">
								<div class="col-md-6 col-sm-5 col-12">
									<div class="form-check">
										<label class="form-check-label">{{module.module_name}}
											<input class="form-check-input" type="checkbox" ng-model="module.module_name" ng-click="checlAllPrivilege(module)" ng-true-value="module.module_name" ng-checked="module.view==1 || module.add==1 || module.edit==1 || module.delete==1">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
								<div class="col-md-6 col-sm-7 col-12">
									<div class="row">
										<div class="col-md-3 col-sm-6 col-6">
											<div class="form-check">
												<label class="form-check-label">View
													<input class="form-check-input" type="checkbox" ng-model="module.view" ng-true-value='1'>
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="col-md-3 col-sm-6 col-6">
											<div class="form-check">
												<label class="form-check-label">Add
													<input class="form-check-input" type="checkbox" ng-model="module.add" ng-true-value=	'1' >
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="col-md-3 col-sm-6 col-xs-6">
											<div class="form-check">
												<label class="form-check-label">Edit
													<input class="form-check-input" type="checkbox" ng-model="module.edit" ng-true-value='1'>
													<span class="checkmark"></span>
												</label>
											</div>
										</div>
										<div class="col-md-3 col-sm-6 col-xs-6">
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