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
		<h5>List of Teacher</h5>
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
	<ul class="nav nav-tabs nav-pills justify-content-end pb-2" id="pills-tab" role="tablist">
	<li class="nav-item">
		<span class="nav-link active" id="listView-tab" ng-click="showList();"><i class="fa fa-list" aria-hidden="true"></i></span>
	</li>
	<li class="nav-item">
		<span class="nav-link" id="ridView-tab" ng-click="showGridList();"><i class="fa fa-th-large" aria-hidden="true"></i></span>
	</li>
	</ul>
	<div class="tab-content border-none" id="pills-tabContent">
		<div class="tab-pane fade show " id="listView" style="display:block;">
			<table datatable="ng" class="table table-striped table-bordered table-responsive">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Photo</th>
						<th>Teacher Name</th>
						<th>Subject</th>
						<!--<th>Hobby</th>-->
						<th>Assign Class</th>
						<th class="text-right">Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="teacher in teacherData">
						<td>{{$index+1}}</td>
						<td>
						<a href="#!/teacher-details/{{teacher.teacherID}}" class="avatar">
                            <img ng-show="teacher.teacherphoto!=''" src="<?php echo base_url();?>img/teacher/{{teacher.teacherphoto}}" alt="teacher">
							<img ng-show="teacher.teacherphoto==''" src="<?php echo base_url();?>img/noImage.png" alt="teacher">
						</a>
						</td>
						<td>{{teacher.teachername}}</td>
						<td>{{teacher.subject}}</td>
						<!--<td>Photography</td>-->
						<td>{{teacher.assignclass}}</td>
						<td class="action text-right">
							<a href="#!/teacher-details/{{teacher.teacherID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
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
				<div class="col-md-4 col-sm-4 col-xs-12 mb-3 ng-scope" dir-paginate="teacher in teacherData|filter:search|itemsPerPage:pageSize">
					<div class="card col-updated-card h-100">
						<div class="card-body album_bx gridViewShow-p">
							<figure>
								<a href="#!/teacher-details/{{teacher.teacherID}}" class="avatar">
									<img ng-show="teacher.teacherphoto!=''" src="<?php echo base_url();?>img/teacher/{{teacher.teacherphoto}}" alt="teacher">
									<img ng-show="teacher.teacherphoto==''" src="<?php echo base_url();?>img/noImage.png" alt="teacher">
								</a>
							</figure>
							<div class="cont">
								<h4 class="mb-2">{{teacher.teachername}}</h4>
								<span class="mb-2">{{teacher.subject}}</span>
								<div class="classSubject mb-2">{{teacher.assignclass}}</div>
								<a class="btn btn-primary btn-sm" href="#!/teacher-details/{{teacher.teacherID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i> View Details</a>
								
							</div>
						</div>
					</div>
				</div>
				
			</div>
			<dir-pagination-controls
			max-size="1" class="mb-3"
			direction-links="true"
			boundary-links="true">
			</dir-pagination-controls>
			<div class="clearfix"></div>
			<dir-pagination-controls
			max-size="1"
			direction-links="true" class=" "
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