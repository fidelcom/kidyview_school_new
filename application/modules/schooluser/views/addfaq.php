<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-comment"></i>
					</div>
					<div class="page-title mt-2">
						<h5>Add FAQs</h5>
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
							<!-- 	<div class="form-group">
									<label class="form-label">User-Type<em>*</em></label>
										<select class="form-control" ng-model="user_type">
											<option value="Student">Student</option>
											<option value="Teacher">Teacher</option>
										</select>
								</div> -->
								<div class="form-group">
									<label class="form-label">Question<em>*</em></label>
									<div class="controls">
										<textarea class="form-control" ng-model="question" rows="4" cols="50" placeholder="Enter your question Here ?"></textarea>
									</div>
								</div>
								<div class="form-group">
									<label class="form-label">Answer<em>*</em></label>
									<div class="controls">
										<textarea class="form-control" ng-model="answer" rows="4" cols="50" placeholder="Enter your answer Here."></textarea>
									</div>
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="form-group">
									<button class="btn btn-primary" ng-click="addFaq()" name="submit">Add FAQ</button>
									<a class="btn btn-secondary" href="#!/school-faq">Back To List</a>
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