<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 mb-3 mb-sm-0 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Sub Admin Role</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
							<div class="right-actions">
								<a href="#!/add-role" class="btn btn-primary"> <i class="icon-plus2"></i> Add Role</a>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- END: .main-heading -->
			<!-- BEGIN .main-content -->
			<div class="main-content update-dt-list-update">
				<div class="card">				
					<div class="card-body">
					<div class="table-responsive">	
				<table datatable="ng" class="table table-striped table-bordered">
				<thead>
						<tr>
							<th>S. No</th>
							<th ng-click="sort('name')" class="sorting-tb">Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='name'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="role in roleList">
							<td>{{$index + 1}}</td>
							
							<td>{{role.name}}</td>
					
							<td class="action">
								<a href="#!/edit-role/{{role.roleID}}"><i class="icon-edit2" title="Edit"></i></a>
								<!--<a ng-if="role.status == '1'"><i class="fas fa-toggle-on" ng-click="roleDisabled(role.id, '0');"></i></a>
								<a ng-if="role.status == '0'"><i class="fas fa-toggle-off" ng-click="roleDisabled(role.id, '1');"></i></a>
								-->
								<a ng-click="roleDelete(role.id)"><i class="icon-trash2" title="Delete"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
						</div>
			</div>
				</div>
				<!-- Card end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		