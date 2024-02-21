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
						<h5>List Of Submitted Assignments</h5>
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
							<th ng-click="sort('subject')" class="sorting-tb">Subject
							<span class="glyphicon sort-icon" ng-show="sortKey=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('submission_date')" class="sorting-tb">Date Of Submission
							<span class="glyphicon sort-icon" ng-show="sortKey=='submission_date'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('subject')" class="sorting-tb">Submitted Date
							<span class="glyphicon sort-icon" ng-show="sortKey=='subject'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Status</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="assignment in studentSubmitAssignmentData">
							<td>{{$index + 1}}</td>
							<td>{{assignment.title}} 	</td>
							<td>{{assignment.classname}}</td>
							<td>{{assignment.teachername}}</td>
							<td>{{assignment.subject}}</td>
							<td><span ng-class="{'text-green':(assignment.currDate|date:'yyyy-MM-dd')<=assignment.submission_date,'text-red':(assignment.currDate|date:'yyyy-MM-dd')>assignment.submission_date}">{{assignment.submission_date|myDate}}</span></td>
							<td><span ng-class="{'text-green':(assignment.datesubmited|date:'yyyy-MM-dd')<=assignment.submission_date,'text-red':(assignment.datesubmited|date:'yyyy-MM-dd')>assignment.submission_date}">{{assignment.datesubmited|myDate}}</span></td>
							<td><span ng-class="{'text-green':(assignment.assignment_status=='Graded' || assignment.assignment_status=='Marks Obtained')}">	{{assignment.assignment_status}}</span></td>
							<td class="action text-right">
								<a href="#!/submit-assignment-detail/{{assignment.assignmentID}}"><i class="icon-eye" title="View"></i></a>
								<a href="#!/edit-submit-assignment/{{assignment.assignmentID}}" ng-if="assignment.currdate<=assignment.submission_date && (assignment.no_of_attempt>1 || assignment.no_of_attempt=='')"><i class="icon-edit"></i></a>
								<a ng-if="assignment.currdate<=assignment.submission_date && (assignment.no_of_attempt>1 || assignment.no_of_attempt=='')" ng-click="deleteSubmitAssignment(assignment.asid,$index);"><i class="icon-trash2"></i></a>
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