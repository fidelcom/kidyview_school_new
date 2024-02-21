<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-code"></i>
					</div>
					<div class="page-title">
						<h5>learning and devopment Detail</h5>
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
					<!-- <div class="col-md-3 col-sm-12 col-xs-12"> -->
					<!-- <div class="profileimg"> -->
					<!-- <img class="img-fluid img-circle" src="img/father.jpg" alt="User profile" /> -->
					<!-- </div> -->
					<!-- </div> -->
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="card-body full-detail full-dtl-landd">
							<h6 class="text-blue">Teacher Details</h6>
							<div class="row">
								<div class="col-md-4">Teacher Name:</div>
								<div class="col-md-8">{{teacherfname}} {{teacherlname}}</div>
							</div>
							<div class="row">
								<div class="col-md-4">Teacher Email Id:</div>
								<div class="col-md-8">{{teacheremail}}</div>
							</div>
							
							<h6 class="mt-3">Student Details</h6>
							<div class="row">
								<div class="col-md-4">Student Name:</div>
								<div class="col-md-8">{{childfname}} {{childmname}} {{childlname}}</div>
							</div>
							<div class="row">
								<div class="col-md-4">Class:</div>
								<div class="col-md-8">{{student_class}}</div>
							</div>
							<div class="row">
								<div class="col-md-4">Section:</div>
								<div class="col-md-8">{{student_section}}</div>
							</div>
							<h6 class="mt-3">Other Details</h6>
							<div class="row">
								<div class="col-md-4">Category:</div>
								<div class="col-md-8">{{category_Name}}</div>
							</div>
							<div class="row">
								<div class="col-md-4">{{category_Name}} Summary:</div>
								<div class="col-md-8">{{answer}}</div>
							</div>
							<div class="row">
								<div class="col-md-4">Summary:</div>
								<div class="col-md-8">{{other_answer}}</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<a class="btn btn-secondary" href="#!/learning-and-development-report-list">Back To List</a>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->