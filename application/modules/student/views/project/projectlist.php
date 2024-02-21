<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="far fa-file-alt"></i>
					</div>
					<div class="page-title">
						<h5>List of Projects</h5>
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
				<div class="clearfix"></div>
				<select class="assignment-option-s form-control" ng-model="datefilter" ng-change="getStudentAssignmentList();" >
					<option value="">All</option>
					<option value="late">Past Project </option>
					<option value="new">Current Project </option>
				</select>
				<table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('title')" class="sorting-tb">Project Name
							<span class="glyphicon sort-icon" ng-show="sortKey=='title'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Unlock Date
							</th>
							<th ng-click="sort('teachername')" class="sorting-tb">Teacher
								<span class="glyphicon sort-icon" ng-show="sortKey=='teachername'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th class="sorting-tb">Attempts Allowed</th>
							<th class="sorting-tb">Attempts Made</th>
							<th ng-click="sort('submission_date')" class="sorting-tb">Date Of Submission
							<span class="glyphicon sort-icon" ng-show="sortKey=='submission_date'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('subject')" class="sorting-tb">Subject
							<span class="glyphicon sort-icon" ng-show="sortKey=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="assignment in studentAssignmentData">
							<td>{{$index + 1}}</td>
							<td>{{assignment.title}} 	</td>
							<td>{{assignment.open_submission_date?(assignment.open_submission_date|myDate):'N/A'}}</td>
							<td>{{assignment.teachername}}</td>
							<td>{{assignment.no_of_attempt?assignment.no_of_attempt:'N/A'}}</td>
							<td>{{assignment.userAttemptCount}}</td>
							<td><span ng-class="{'text-green':(assignment.currDate|date:'yyyy-MM-dd')<=assignment.submission_date,'text-red':(assignment.currDate|date:'yyyy-MM-dd')>assignment.submission_date}">{{assignment.submission_date|myDate}}</span></td>
							<td>{{assignment.subject}}</td>
							<td class="action text-right">
								<a ng-show="assignment.isAssignmentOpen==1" href="#!/project-detail/{{assignment.assignmentID}}"><i class="icon-eye" title="View"></i></a>
								<a ng-show="assignment.isAssignmentOpen==0" title="Project Locked"><i class="fas fa-lock"></i></a>
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