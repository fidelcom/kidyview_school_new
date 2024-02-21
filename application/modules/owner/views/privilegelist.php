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
					<div class="card-body srch-mob-wdth">
					
				
					<div class="table-responsive">	
					<table datatable="ng" class="table table-striped table-bordered">
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
						<tr ng-repeat="privilege in privilegeList">
							<td>{{$index + 1}}</td>
							
							<td>{{privilege.role}} </td>
							<td class="set-width-style"> 
							<div class="binding-grp"><b><span class="mdm">Module</span> <span class="w-sc">View</span>  <span class="w-sc">Add</span> <span class="w-sc">Edit</span> <span class="w-sc">Delete</span></b>
							<br/>
							<span ng-repeat="module in privilege.moduleData" ng-if="privilege.viewData[$index] == '1' || privilege.editData[$index] == '1' || privilege.addData[$index] == '1' || privilege.editData[$index] == '1' || privilege.deleteData[$index] == '1'" > <span class="mdm">{{module}}</span> 
							<i ng-show="privilege.viewData[$index]==1" class="icon-tick" style="color:#0dbe1a;"></i>
							<i ng-show="privilege.viewData[$index]==0" class="icon-cross3" style="color:#f00;"></i>
							<i ng-show="privilege.addData[$index]==1" class="icon-tick" style="color:#0dbe1a;"></i>
							<i ng-show="privilege.addData[$index]==0" class="icon-cross3" style="color:#f00;"></i>
							<i ng-show="privilege.editData[$index]==1" class="icon-tick" style="color:#0dbe1a;"></i>
							<i ng-show="privilege.editData[$index]==0" class="icon-cross3" style="color:#f00;"></i>
							<i ng-show="privilege.deleteData[$index]==1" class="icon-tick" style="color:#0dbe1a;"></i>
							<i ng-show="privilege.deleteData[$index]==0" class="icon-cross3" style="color:#f00;"></i>
							<br/></span>
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
		