<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 mb-0 mb-sm-0 mb-md-3 align-self-center">
					<div class="page-icon">
						<i class="icon-user-tie"></i>
					</div>
					<div class="page-title">
						<h5>Teachers</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 ">
					<div class="right-actions">
						<a href="#!/add-teacher" class="btn btn-primary"> <i class="icon-plus2"></i> Add Teacher</a>
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
				<form class="form-inline float-none float-md-left src-mobile">
					<div class="form-group mb-3 mb-md-0">
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
				</form>
				<div class="form-inline float-none float-md-right mb-3 item-form-mg">
					<label class="mr-0 mr-md-2" for="search" class="mr-1">Items per page:</label>
					<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
				<table class="table result_teacher_filter table-striped table-bordered table-responsive tbrs-new">
					<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('teacherfname')" class="sorting-tb">Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='teacherfname'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('teacheremail')" class="sorting-tb">Email
								<span class="glyphicon sort-icon" ng-show="sortKey=='teacheremail'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Spouse/Father Name</th>
							<th>Subject</th>
							<th>Phone</th>
                                                        <th>Signature</th>
                                                         <th>Call To Driver </th>
                                                        <th>Created  Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="teacher in teacherList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							<td>{{teacher.teacherfname}} {{teacher.teachermname}} {{teacher.teacherlname}}</td>
							<td>{{teacher.teacheremail}}</td>
							<td>{{teacher.spousename}}</td>
							<td>{{teacher.subjectteacher}}</td>
							<td>{{teacher.teacherphone}}</td>
                                                        
                                                        <td ng-if="teacher.signatureImg==''">
                                                            No Signature Found  
                                                        </td>
                                                        <td ng-if="teacher.signatureImg!=''">
                                                            <img   src="<?= base_url() ?>img/teacher/{{teacher.signatureImg}}" alt="User profile"  width="80" height="50" />   
                                                        </td>
                                                        
                                                         <td>
                                                        <a ng-if="teacher.is_call_enable == '1'"><i class="fas fa-toggle-on" ng-click="callDisabled(teacher.id, 0);"></i></a>
                                                        <a ng-if="teacher.is_call_enable == '0'"><i class="fas fa-toggle-off" ng-click="callDisabled(teacher.id, 1);"></i></a>    
                                                            
                                                        </td>
                                                        
                                                        <td>{{teacher.created_date}}</td>
							<td class="action">
								<a href="#!/teacher-detail/{{teacher.teacherID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
								<a href="#!/edit-teacher/{{teacher.teacherID}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
								<a ng-if="teacher.status == '1'"><i class="fas fa-toggle-on" ng-click="teacherDisabled(teacher.id, 0);"></i></a>
								<a ng-if="teacher.status == '0'"><i class="fas fa-toggle-off" ng-click="teacherDisabled(teacher.id, 1);"></i></a>
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
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->