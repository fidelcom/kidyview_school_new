<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-clock"></i>
					</div>
					<div class="page-title">
						<h5>Add Term</h5>
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
				<form>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Term Session<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="term">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Academic Session<em>*</em></label>
								<div class="controls">
									<select class="form-control" ng-model="academicsession" ng-change="gettermdaterange(sessionListData)">
									<option value="0">--Select Session--</option>
									<option ng-repeat="session in sessionListData" value="{{session.id}}" ng-selected="selected">{{session.academicsession}}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Term Start<em>*</em></label>
								<div class="controls">
									<input type="date" id="termstart" class="form-control" ng-model="termstart">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Term End<em>*</em></label>
								<div class="controls">
									<input type="date" id="termend" class="form-control" ng-model="termend">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="addTerm()" name="submit">Submit</button>
								<a class="btn btn-secondary" href="#!/term-list">Back To List</a>
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