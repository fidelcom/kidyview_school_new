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
						<h5>{{name}}  ( Details View )
					<a class="btn btn-secondary" href="#!/exam"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back To List</a>
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
								<li><span>School:</span> {{  school_name }}</li>
								<li><span>Class Name:</span> {{ class }} - {{ section }}</li>
								<li><span>Subject Name:</span> {{ subjectName }}</li>
								<li><span>Exam Time:</span> {{exam_time_format}}</li>
								<li><span>Exam Date:</span> {{ exam_date_format }}</li>
								<li><span>Last Submission Date:</span> {{last_submission_date_format}}</li>
								<li><span>Exam Duration:</span> {{exam_duration}}</li>
								<li><span>Total Marks:</span> {{total_marks}}</li>
								<li><span>Total Questions:</span> {{total_question}}</li>
								<li><span>Instructions:</span> {{exam_instruction}}</li>
								<li><span>No of attempt:</span> {{exam_attempt_no}}</li>
								<li><span>Created On:</span> {{created_at}}</li>
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