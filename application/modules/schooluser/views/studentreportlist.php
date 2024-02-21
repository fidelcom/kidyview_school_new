<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
					<div class="page-icon">
						<i class="icon-file-text mt-2"></i>
					</div>
					<div class="page-title align-self-center ml-3">
						<h5>Reports</h5>
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
			<div class="row mt-2 bg-light m-0 p-2">
				<div class="col-md-4 align-self-center">
					<div class="form-group">
						<label class="mr-2 align-self-center">Class:</label> 
						<select class="form-control" ng-model="classId" ng-change="getAllStudentForClass(classId)">
							<option value="0">--Select Class--</option>
							<option ng-repeat="class in classList" value="{{class.id}}">{{class.class}} - {{class.section}}</option>
						</select>
					</div>
				</div>
				<div class="col-md-4 d-none d-md-block"></div>
				<div class="col-md-4 align-self-center">
					<div class="searchblock-n">
						<div class="form-group">
							<label>Search</label>
							<input type="text" ng-model="search" class="form-control" placeholder="Search">
						</div>
					</div>
				</div>
			</div>
			<hr />
			<div class="card-body mt-0">
				<div class="table-responsive">
					<table class="table parents-listing-c table-striped table-bordered">
						<thead>
							<tr>
								<th>Student Name</th>
								<th>Email</th>
								<th>Register Id</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-if="studentList.length != 0" ng-repeat="student in studentList">
								<td>{{student.childfname}} {{student.childmname}} {{student.childlname}}</td>
								<td>{{student.childemail}}</td>
								<td>{{student.childRegisterId}}</td>
								<td class="action">
									<a href="#!/report-view/{{student.studentID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
								</td>
							</tr>
							<!--tr ng-if="studentList.length == '0'">No Records Found..</tr-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->