<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-calendar"></i>
							</div>
							<div class="page-title">
								<h5>Add Holiday</h5>
							</div>
						</div>
						<!--<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								 <a href="add-school.html" class="btn btn-primary">Add School</a>
								<a href="#" class="btn btn-primary">Add School</a>
							</div>
						</div> -->
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
										<label class="form-label">Session<em>*</em></label>
										<div class="controls">
										<select class="form-control" ng-model="academicsession">
										<option ng-repeat="session in sessionList" value="{{session.id}}">{{session.academicsession}}</option>
										</select>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Holiday Title<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="holidaytitle">
										</div>
									</div>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Date<em>*</em></label>
										<div class="controls">
										<input type="date" onkeydown="return false" class="form-control" ng-model="holiday_date">
										</div>
									</div>
								</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
									<button class="btn btn-primary" ng-click="editHoliday()">Update</button>
									<a class="btn btn-secondary" href="#!/holiday-list">Back To List</a>
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