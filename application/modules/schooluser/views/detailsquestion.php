BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-user-tie"></i>
					</div>
					<div class="page-title">
						<h5>{{question}}  ( Details View )
					<!-- <a class="btn btn-secondary" href="#!/questions"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back To List</a> -->
						</h5>
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
					<div class="col-md-12">
						<div class="card-body full-detail p-0">
							<ul>
								<li><span>Exam Name:</span>{{ name }}</li>
								<li><span>Question:</span> {{  question }}</li>
								<li><span>Question Mark:</span> {{  question_marks }}</li>
								<li><span>Question Type:</span> {{  question_type }}</li>
								<li><span>Answer:</span> {{  (answer) ? answer : '-' }}</li>
								<!-- <li>
									<div ng-repeat="Values in option_value track by $index">
									<div ng-repeat="(key, data) in Values">
									
									<span>Option Values:</span>
									</div>
								</li> -->
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main