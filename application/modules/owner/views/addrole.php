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
								<h5>Add Role</h5>
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
										<label class="form-label">Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="name" required="">
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
									<button class="btn btn-primary" ng-click="addRole()">Submit</button>
									<a class="btn btn-secondary" href="#!/role-list">Back To List</a>
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