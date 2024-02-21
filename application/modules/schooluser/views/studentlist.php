<!--BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-user-plus"></i>
					</div>
					<div class="page-title">
						<h5>Students</h5>
						<div ng-show="succImport=='1'" style="color:green;">Data has been imported successfully.</div>
						<div ng-show="succImport=='0'" style="color:red;">Data not imported.Please try again.</div>	
						
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a  ng-if="class_ID!=''" href="#!/class-list" class="btn btn-primary"> <i class="icon-plus2"></i> Back</a>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#csvModal">Import CSV</button>
					</div>	
				</div>
			</div>
		</div>
	</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body">
						<div class="clearfix"></div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group float-none float-md-left"  ng-if="class_ID==''">
									<label class="mr-3">Search by class</label>
									<select class="form-control" ng-model="classID" ng-change="getStudentsByclassID(classID)">
										<option value="" selected="selected" disabled="disabled">Select Class</option>
										<option ng-repeat="cl in classList" value="{{cl.id}}">{{cl.class}}-{{cl.section}}</option>
									</select>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Search</label>
									<input type="text" ng-model="search" class="form-control" placeholder="Search">
								</div>
							</div>
						</div>
						
						<form class="form-inline float-left mb-0 mb-md-3">
							
						</form>
						<div class="table-responsive">
						<table class="table result_parenets_filter parents-listing-c table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>Registration ID</th>
									<th>Username</th>
									<th ng-click="sort('childfname')" class="sorting-tb">Student Name
									<span class="glyphicon sort-icon" ng-show="sortKey=='childfname'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
									</th>
									<th>Class &amp; Section</th>
									<th>Gender</th>
									<th ng-click="sort('fatherfname')">Parent Name
									<span class="glyphicon sort-icon" ng-show="sortKey=='fatherfname'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span></th>
									<th>Address</th>
                                                                        <th>Created Date</th>
									<th class="text-right">Action</th>
								</tr>
							</thead>
							<tbody>
							<tr dir-paginate="sd in studentData|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize" current-page="currentPage">
									<td>{{pageSize * (currentPage-1)+$index+1}}</td>
									<td>{{sd.childRegisterId }}</td>
									<td>{{sd.child_login_id }}</td>
									<td>{{sd.childfname }} {{sd.childmname}} {{sd.childlname}}</td>
									<td>{{sd.class }}-{{sd.section}}</td>
									<td>{{sd.childgender }}</td>
									<td>{{sd.fatherfname }} {{sd.fatherlname}}</td>
									<td>{{sd.childaddress }}</td>
                                                                         <td>{{sd.created_date}}</td>
									{{sd}}
									<td class="action text-right">
										<a href="#!/student-detail/{{sd.childID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
										<a href="#!/edit-child/{{sd.childID}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
										<a ng-if="sd.status == '1'"><i class="fas fa-toggle-on" ng-click="studentDisabled(sd.student_id, 0);"></i></a>
										<a ng-if="sd.status == '0'"><i class="fas fa-toggle-off" ng-click="studentDisabled(sd.student_id, 1);"></i></a>
									</td>
								</tr>								
							</tbody>
						</table>
						</div>
						<!-- <div class="range-label float-left">Displaying {{ pageSize * (currentPage-1)+$index+1 }} - {{ pageSize*currentPage }} of {{ studentData.length }}</div> -->
						<div class="clearfix"></div>
						<dir-pagination-controls
						max-size="10" class="mb-3 float-right"
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
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main-->
<div class="modal fade custom_modal" id="csvModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">×</button>
			  <h4 class="modal-title">Import CSV</h4>
			</div>
			<div class="modal-body">
				<form class="ng-pristine ng-invalid ng-invalid-required" method="post" enctype="multipart/form-data" action="">
			
					<div class="row form-group">
						<div class="col-md-12">
							<input class="file-upload" required ngf-select="" name="csvFile" ngf-change="onChange($files)" id="pic" accept=".csv" type="file" />
						</div>
					</div>
					<div class="row form-group mt-3">
						<div class="col-md-12">
							<button type="button" ng-click="ImportCsvData()" class="btn btn-primary">Upload</button>
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
</div>