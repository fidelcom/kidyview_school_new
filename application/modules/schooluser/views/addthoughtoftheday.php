<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-photo"></i>
					</div>
					<div class="page-title">
						<h5>Thought of the Day</h5>
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
						
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="form-label">Title</label>
								<div class="controls">
									<input type="text" ng-model="title" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description<em>*</em></label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-8 col-sm-8 col-xs-12">
							<div class="form-group">
								<label class="form-label">Author Name</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="author">
								</div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="addThoughtoftheday()" name="submit">Submit</button>
								<a class="btn btn-secondary" href="#!/thoughtoftheday-list">Back To List</a>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->