<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-laptop_windows"></i>
					</div>
					<div class="page-title">
						<h5>Submitted Project</h5>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="card">
			<div class="card-body small-font">
			<div class="table-responsive">
			<div class="row rowFilter-head">
			<div class="col-md-4">
				<select class="form-control" ng-model="class_id" ng-change="getStudentSubmitedProjectList()"> 
					<option value="">Select Class</option>
					<option value="{{class.id}}" ng-repeat="class in classArray | unique : 'id'">{{class.name}}</option>
				</select>
			</div>
			<div class="col-md-4">
				<select class="form-control" ng-model="subject_id" ng-change="getStudentSubmitedProjectList()"> 
					<option value="">Select Subject</option>
					<option value="{{subject.id}}" ng-repeat="subject in subjectArray | unique : 'id'">{{subject.name}}</option>
				</select>
			</div>
			<div class="col-md-4">
				<select class="form-control" ng-model="category" ng-change="getStudentSubmitedProjectList()"> 
					<option value="">Select Category</option>
					<option value="{{category.name}}" ng-repeat="category in categoryArray | unique : 'name'">{{category.name}}</option>
				</select>
			</div>
			</div>
				<table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
						<tr>
							<th>S.No.</th>
							<th>Project Name</th>
							<th>Student Name</th>
							<th>Subject</th>
							<th>Class</th>
							<th>Late Days</th>
							<th>Submitted Date</th>
							<th>Status</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="assignment in studentSubmitAssignmentData">
							<td>{{$index + 1}}</td>
							<td>{{assignment.title}} 	</td>
							<td>{{assignment.studentname}}</td>
							<td>{{assignment.subject}}</td>
							<td>{{assignment.classname}}</td>
							<td>{{assignment.latedays}}</td>
							<td>{{assignment.datesubmited|date:"dd MMM y"}}</td>
							<td>
							<span ng-class="{'text-green':(assignment.project_status=='Graded' || assignment.project_status=='Marks Assigned')}">	{{assignment.project_status}}</span>
							</td>
							<td class="action text-right">
								<a href="#!/submited-project-detail/{{assignment.assignmentID}}"><i class="icon-eye" title="View"></i></a>
							</td>
						</tr>															
					</tbody>
				</table>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->