<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Privilege</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-privilege" class="btn btn-primary"> <i class="icon-plus2"></i> Add Privilege</a>
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
					<form class="form-inline float-left mb-3">
					<div class="form-group">
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
				</form>
				
				<div class="form-inline float-right mb-3">
					<label for="search">items per page:</label>
					<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
				
						
						<table class="table parents-listing-c table-striped table-bordered table-responsive">
					<thead>
						<tr>
							<th>S. No</th>
							<th ng-click="sort('role')" class="sorting-tb">Role
								<span class="glyphicon sort-icon" ng-show="sortKey=='role'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Privilege</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="privilege in privilegeList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							
							<td>{{privilege.role}} </td>
							<td>
							<div class="tb_prilist">
								<span class="hdng"><span>Module</span><span>View</span><span>Add</span><span>Edit</span><span>Delete</span></span>
								<span ng-repeat="module in privilege.moduleData" ng-if="privilege.viewData[$index] == '1' || privilege.editData[$index] == '1' || privilege.addData[$index] == '1' || privilege.editData[$index] == '1' || privilege.deleteData[$index] == '1'" >
									<span>{{module}}</span>
									<span ng-show="privilege.viewData[$index]==1" class="text-success"><i class="icon-tick"></i></span>
									<span ng-show="privilege.viewData[$index]==0" class="text-danger"><i class="icon-cross3"></i></span>
									<span ng-show="privilege.addData[$index]==1" class="text-success"><i class="icon-tick"></i></span>
									<span ng-show="privilege.addData[$index]==0" class="text-danger"><i class="icon-cross3"></i></span>
									<span ng-show="privilege.editData[$index]==1" class="text-success"><i class="icon-tick"></i></span>
									<span ng-show="privilege.editData[$index]==0" class="text-danger"><i class="icon-cross3"></i></span>
									<span ng-show="privilege.deleteData[$index]==1" class="text-success"><i class="icon-tick"></i></span>
									<span ng-show="privilege.deleteData[$index]==0" class="text-danger"><i class="icon-cross3"></i></span>
								</span>
							</div>
							</td>
					 
							<td class="action">
								<a href="#!/edit-privilege/{{privilege.privilegeID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-click="privilegeDelete(privilege.role_id)"><i class="icon-trash2" title="Delete"></i></a>
                                
							</td>
						</tr>
					</tbody>
				</table>
				<dir-pagination-controls
				max-size="10" class="mb-3 float-left"
				direction-links="true"
				boundary-links="true">
				</dir-pagination-controls>
				<div class="clearfix"></div>
				<dir-pagination-controls
				max-size="10"
				direction-links="true" class="float-left"
				boundary-links="true"
				template-url="asset/js/dirPagination.tpl.html">
				</dir-pagination-controls>		
			</div>
				</div>
				<!-- Card end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		