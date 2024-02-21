<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
					<div class="page-icon">
						<i class="icon-user-plus"></i>
					</div>
					<div class="page-title">
						<h5>Parents</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
				<div class="right-actions">
					<button ng-click="opentSendFormData();" class="btn btn-primary" href="javascript:void(0);">Send Student Form</button>
					<a href="#!/add-parent" class="btn btn-primary"> <i class="icon-plus2"></i> Add Parents</a>
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
				<div class="row">
					<div class="col-md-6">
						<label>Search</label>
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
					<div class="col-md-6">
						<label for="search">items per page:</label>
						<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
					</div>
								
				</div>
				
				<div class="row">
					<div class="col-md-12">
						<div class="table-responsive table-md-overflow table-sm-overflow">
				<table class="table result_parenets_filter parents-listing-c table-striped table-bordered  tbrs-new">
					<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('fatherfname')" class="sorting-tb">Father Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='fatherfname'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Mother Name</th>
							<th>Guardian Name</th>
							<th>Address</th>
							<th ng-click="sort('fatheremail')" class="sorting-tb add-break-word">Email
								<span class="glyphicon sort-icon" ng-show="sortKey=='fatheremail'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Phone</th>
                                                        <th>Call To Driver </th>
                                                        <th>Created  Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="parent in parentList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							<td>{{parent.fatherfname}} {{parent.fatherlname}}</td>
							<td>{{parent.motherfname}} {{parent.motherlname}}</td>
							<td>{{parent.guardianfname}} {{parent.guardianlname}}</td>
							<td>{{ (parent.fatheraddress) ? parent.fatheraddress : parent.motheraddress }}</td>
							<td class="add-break-word">{{ (parent.fatheremail) ? parent.fatheremail : parent.motheremail }}</td>
							<td>{{ (parent.fatherphone) ? parent.fatherphone : parent.motherphone }}</td>
                                                        <td>
                                                        <a ng-if="parent.is_call_enable == '1'"><i class="fas fa-toggle-on" ng-click="callDisabled(parent.id, 0);"></i></a>
                                                        <a ng-if="parent.is_call_enable == '0'"><i class="fas fa-toggle-off" ng-click="callDisabled(parent.id, 1);"></i></a>    
                                                            
                                                        </td>
							  <td>{{parent.created_date}}</td>
                                                        <td class="action">
								<a href="#!/parent-detail/{{parent.parentID}}"><i class="icon-eye" title="View"></i></a>
								<a href="#!/edit-parent/{{parent.parentID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-if="parent.status == '1'"><i class="fas fa-toggle-on" ng-click="parentDisabled(parent.id, 0);"></i></a>
								<a ng-if="parent.status == '0'"><i class="fas fa-toggle-off" ng-click="parentDisabled(parent.id, 1);"></i></a>
							</td>
						</tr>															
					</tbody>
				</table>
				</div>
				<dir-pagination-controls
				max-size="10" class="float-right"
				direction-links="true"
				boundary-links="true">
				</dir-pagination-controls>
				
				<dir-pagination-controls
				max-size="10"
				direction-links="true" class="float-left"
				boundary-links="true"
				template-url="<?php echo base_url(); ?>asset/js/dirPagination.tpl.html">
				</dir-pagination-controls>
					</div>
				</div>
			
				
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<div class="modal fade custom_modal" id="selectStudentList" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">×</button>
			  <h4 class="modal-title">Send student form</h4>
			</div>
			<div class="modal-body">
				<form class="ng-pristine ng-invalid ng-invalid-required">
			
					<div class="row form-group">
					
						<div class="col-md-12">
						<div ng-dropdown-multiselect="" options="parentList" selected-model="parent" checkboxes="true" selectedToTop="true" extra-settings="setting1" translation-texts="settingCustomTexts"></div>       
						</div>
						<div class="col-md-12">
						<input type="checkbox" ng-model="isNewParent" value=""/> Send to New Parent      
						</div>
						<div class="col-md-12" ng-show="isNewParent">
						<div ng-repeat="parentData in inputoptions">
						<input type="email" name="email" placeholder="Enter parent email" ng-model="parentData.email" value=""/> 
						<i class="icon-trash2" ng-click="removeNewParentData($index)" ng-if="$index>0"></i>
						</div>		
						<button type="button" ng-click="addNewParentData()">Add More</button>      
						</div>
					</div>
					 
					<div class="row form-group mt-3">
						
						<div class="col-md-12">
							<button ng-click="sendStudentFormLink()" class="btn btn-primary">Send</button>
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
</div>