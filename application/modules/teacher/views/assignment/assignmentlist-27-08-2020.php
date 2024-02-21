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
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
			<div class="right-actions">
			<a href="#!/create-assignment" class="btn btn-primary"> <i class="icon-plus2"></i> New Assignment</a>
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
				<div class="row mt-2 mb-3">
				<div class="col-md-4">
				<!--	<select class="form-control" id="">
						<option>2nd - A</option>
						<option>2nd - B</option>
						<option>3rd - B</option>
						<option>4th - B</option>
					</select>-->
				</div>
			</div>
				<table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
						<tr>
							<th>S.No.</th>
							<th class="sorting-tb">Assignment Name</span></th>
							<th class="sorting-tb">Subject</th>
							<th class="sorting-tb">Class</th>
							<th>Date Of Submission</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="assignment in assignmentData">
							<td>{{$index + 1}}</td>
							<td>{{assignment.title}} 	</td>
							<td>{{assignment.subject}}</td>
							<td>{{assignment.classname}}</td>
							<td>{{assignment.submission_date|date:"dd MMM y"}}</td>
							<td class="action">
							<a href="#!/assignment-detail/{{assignment.assignmentID}}"><i class="icon-eye" title="View"></i></a>
							<a href="#!/edit-assignment/{{assignment.assignmentID}}" data-toggle="tooltip" data-original-title="View Detail" data-placement="top"><i class="icon-edit2"></i></a>
							<a href="javascript:void(0);" ng-click="deleteAssignment(assignment.id)"><i class="icon-trash"></i></a>
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