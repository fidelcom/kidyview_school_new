<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Privilege</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
							<div class="right-actions">
								<a href="#!/add-privilege" class="btn btn-primary"> <i class="icon-plus2"></i> Add Privilege</a>
							</div>
						</div>
					</div>
				</div>
			</header>
			<!-- END: .main-heading -->
			<!-- BEGIN .main-content -->
			<div class="main-content update-dt-list-update update-dt-list-update-n privilage-r-table">
				<div class="card">				
					<div class="card-body">
					<div class="table-responsive">	
				<table datatable="ng" class="table table-striped table-bordered">
				<thead>
						<tr>
							<th>S. No</th>
							<th ng-click="sort('role')" class="sorting-tb">Role
								<span class="glyphicon sort-icon" ng-show="sortKey=='role'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th class="privilege-th">Privilege</th>
							<th class="action-th">Action</th>
						</tr>
				</thead>		
					<tbody>
						<tr ng-repeat="privilege in privilegeList">
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
				</div>
			</div>
				</div>
				<!-- Card end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		