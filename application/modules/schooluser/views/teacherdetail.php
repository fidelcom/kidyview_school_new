<!-- BEGIN .app-main -->
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
						<h5>{{teacherfname}} {{teachermname}} {{teacherlname}}</h5>
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
					<div class="col-md-3 col-sm-12 col-xs-12">
						<div class="profileimg mtp-0">
							<img ng-show="teacherphoto != ''" class="img-fluid" src="<?=base_url();?>img/teacher/{{teacherphoto}}" alt="User profile" />
							<img ng-show="teacherphoto == ''" class="img-fluid" src="<?= base_url(); ?>img/article/noImage.png" />
						</div>
					</div>
					<div class="col-md-9 col-sm-12 col-xs-12">
						<div class="card-body full-detail p-0">
							<ul>
								<li class="current_class"><span>Name:</span> {{teacherfname}} {{teachermname}} {{teacherlname}}</li>
								<li><span>Email Id:</span> {{teacheremail}}</li>
								<li><span>Contact Number:</span> {{teacherphone}}</li>
								<li><span>Gender:</span> {{teachergender}}</li>
								<li><span>Marital Status:</span> {{maritalStatus}}</li>
								<li><span>Spouse/Father Name:</span> {{spousename}}</li>
								<li><span>Date of Joining:</span> {{date_of_joining}}</li>
								<li><span>Education:</span> <p ng-repeat="qualification in qualifications">{{qualification}}</p></li>
								<li><span>Blood Group:</span> {{bloodgroup}}</li>
								<li><span>Religion:</span> {{religion}}</li>
								<li class="teachertype"><span>Teacher Type:</span> <div class="Schooltype" ng-repeat = "schoolType in schoolTypeArr"><p ng-if="schoolType == '0'">PreSchool</p> <p ng-if="schoolType == '1'"> Primary</p> <p ng-if="schoolType == '2'"> Secondary</p> <p ng-if="schoolType == '3'"> College</p></div></li>
								<li><span>Teaching Class:</span> <p ng-repeat="class in classes">{{class}}</p></li>
								<!-- <li><span>Teaching Subjects:</span> <p ng-repeat="subject in subjectList">{{subject}}</p></li> -->
								<!-- <li><span>Subject:</span> {{subjectteacher}}</li> -->
								<li><span>Address:</span> {{teacheraddress}}</li>
							</ul>
						</div>
					</div>
					<a class="btn btn-secondary mt-2" href="#!/teacher-list">Back To List</a>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main