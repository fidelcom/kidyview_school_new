<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
			<div class="page-icon">
				<i class="icon-user-tie"></i>
			</div>
			<div class="page-title">
				<h5>List of Student</h5>
			</div>
		</div>
	</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<div class="card border-none viewDataListing">
		
	<div class="card-body small-font p-0 mt-2">
		<ul class="nav nav-tabs nav-pills justify-content-end pb-2" id="switch-view" role="tablist">
			<li class="nav-item">
				<span class="nav-link active" id="listView-tab" ng-click="showList();"><i class="fa fa-list" aria-hidden="true"></i></span>
			</li>
			<li class="nav-item">
				<span class="nav-link" id="ridView-tab" ng-click="showGridList();"><i class="fa fa-th-large" aria-hidden="true"></i></span>
			</li>
		</ul>
		<div class="tab-content border-none" id="myTabContent-listgridView">
			
			<div class="tab-pane fade show" id="listView" style="display:block;">
				<table datatable="ng" class="table table-striped table-bordered table-responsive">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Photo</th>
							<th>Student Name</th>
							<th>Hobby</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="student in studentData">
							<td>{{$index+1}}</td>
							<td>
							<a href="#!/student-details/{{student.studentID}}" class="avatar">
								<img ng-show="student.childphoto!=''" src="<?php echo base_url();?>img/child/{{student.childphoto}}" alt="student">
								<img ng-show="student.childphoto==''" src="<?php echo base_url();?>img/noImage.png" alt="student">
							</a>
							</td>
							<td>{{student.childname}}</td>
							<td>{{student.hobie?student.hobie:'N/A'}}</td>
							<td class="action text-right">
								<a href="#!/student-details/{{student.studentID}}"><i class="icon-eye"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			
			<!-- tab for grid view -->
			<div class="tab-pane fade show" id="gridView" style="display:none;">
				<div class="row">
				<div class="col-md-12">
				<form class="form-inline float-left mb-3">
				<div class="form-group">
					<input type="text" ng-model="search" class="form-control" placeholder="Search">
				</div>
				</form>
				<div class="form-inline float-right mb-3">
				<label for="search">items per page:</label> 
				<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
				</div>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-4 col-xs-12 mb-3" dir-paginate="student in studentData|filter:search|itemsPerPage:pageSize">
						<div class="card col-updated-card h-10">
							<div class="card-body album_bx">
								<figure>
									<a href="#!/student-details/{{student.studentID}}" class="img-fluid">
										<img ng-show="student.childphoto!=''" src="<?php echo base_url();?>img/child/{{student.childphoto}}" alt="student">
										<img ng-show="student.childphoto==''" src="<?php echo base_url();?>img/noImage.png" alt="student">
									</a>
								</figure>
								<div class="cont">
									<h4>{{student.childname}}</h4>
									<span>{{student.hobie?student.hobie:'N/A'}}</span>
									<a class="btn btn-primary btn-sm" href="#!/student-details/{{student.studentID}}" ><i class="icon-eye"></i> View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
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
				template-url="<?php echo base_url();?>asset/js/dirPagination.tpl.html">
				</dir-pagination-controls>
			</div>
			
		</div>
	
	
	
	
	
		
	</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>