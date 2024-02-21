<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-user"></i>
					</div>
					<div class="page-title">
						<h5>Sub Admin List</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-4">
					<div class="right-actions">
						<a href="#!/add-subadmin" class="btn btn-primary"> <i class="icon-plus2"></i> Add Sub Admin</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content subadmin-list-update">
		<div class="card">
			<div class="card-body">
				<div class="clearfix"></div>
				<div class="table-responsive">
				<table datatable="ng" class="table table-striped table-bordered">
				<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('name')" class="sorting-tb">Name
							<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Desination</th>
							<th ng-click="sort('email')" class="sorting-tb">Email
								<span class="glyphicon sort-icon" ng-show="sortKey=='email'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('phone')" class="sorting-tb">Phone
							<span class="glyphicon sort-icon" ng-show="sortKey=='phone'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Role</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="parent in subadminList">
							<td>{{$index + 1}}</td>
							<td>{{parent.name}} 	</td>
							<td>{{parent.designation}}</td>
							<td>{{parent.email}}</td>
							<td>{{parent.phone}}</td>
							<td>{{parent.role}}</td>
							<td class="action">
								<a href="#!/subadmin-detail/{{parent.subadminID}}"><i class="icon-eye" title="View"></i></a>
								<a href="#!/edit-subadmin/{{parent.subadminID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-if="parent.status == '1'"><i class="fas fa-toggle-on" ng-click="subadminDisabled(parent.id, 0);"></i></a>
								<a ng-if="parent.status == '0'"><i class="fas fa-toggle-off" ng-click="subadminDisabled(parent.id, 1);"></i></a>
								<a ng-click="subadminDelete(parent.id)"><i class="icon-trash2" title="Delete"></i></a>
							</td>
						</tr>															
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