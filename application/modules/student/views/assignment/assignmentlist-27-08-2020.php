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
						<h5>List of Assignments</h5>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content custom-manage-slt">
		<div class="card">
			<div class="card-body">
				<div class="clearfix"></div>
				<select class="assignment-option-s form-control" ng-model="datefilter" ng-change="getStudentAssignmentList();" >
					<option value="">All</option>
					<option value="late">Past Assignment </option>
					<option value="new">Current Assignment </option>
				</select>
				<table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('title')" class="sorting-tb">Assignment Name
							<span class="glyphicon sort-icon" ng-show="sortKey=='title'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('classname')" class="sorting-tb">Class
								<span class="glyphicon sort-icon" ng-show="sortKey=='classname'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('teachername')" class="sorting-tb">Teacher
								<span class="glyphicon sort-icon" ng-show="sortKey=='teachername'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							
							<th ng-click="sort('submission_date')" class="sorting-tb">Date Of Submission
							<span class="glyphicon sort-icon" ng-show="sortKey=='submission_date'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('subject')" class="sorting-tb">Subject
							<span class="glyphicon sort-icon" ng-show="sortKey=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="assignment in studentAssignmentData">
							<td>{{$index + 1}}</td>
							<td>{{assignment.title}} 	</td>
							<td>{{assignment.classname}}</td>
							<td>{{assignment.teachername}}</td>
							<td><span ng-class="{'text-green':(assignment.currDate|date:'yyyy-MM-dd')<=assignment.submission_date,'text-red':(assignment.currDate|date:'yyyy-MM-dd')>assignment.submission_date}">{{assignment.submission_date|date:"dd MMM y"}}</span></td>
							<td>{{assignment.subject}}</td>
							<td class="action">
								<a href="#!/assignment-detail/{{assignment.assignmentID}}"><i class="icon-eye" title="View"></i></a>
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