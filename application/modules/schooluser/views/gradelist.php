<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-laptop_windows"></i>
					</div>
					<div class="page-title">
						<h5>Grade System</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-grade" class="btn btn-primary"> <i class="icon-plus2"></i> Add Grade</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<!-- Row start -->
		<div class="row same-height-card">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label>Search</label>
							<input type="text" ng-model="search" class="form-control" placeholder="Search">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="search">items per page:</label>
							<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
						</div>
					</div>
				</div>
				<div class="card dataTables_wrapper">
					
					<div class="card-body">
					<div class="table-responsive">
						<table id="inbox-table" class="table table-striped table-bordered">
							<thead>
								<tr>

									<th class="title-th" data-animate="Time" data-toggle="tooltip" data-original-title="Though Title" data-placement="top">Sr No.</th>
									<th class="title-th" data-animate="Time" data-toggle="tooltip" data-original-title="Though Title" data-placement="top">Grade name</th>
									<th class="date-th" data-animate="Time" data-toggle="tooltip" data-original-title="Date" data-placement="top">Min Pecentage</th>
									<th class="description-th" data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Description" data-placement="top">Max Pecentage</th>
									<th class="text-right" data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Action" data-placement="top">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr dir-paginate="grade in gradeList|filter:search|itemsPerPage:pageSize" current-page="currentPage">
									<td>{{pageSize * (currentPage-1)+$index+1}}</td>
									<td>{{ grade.grade_name  }}</td>
									<td>{{ grade.min_percent }}</td>
									<td>{{ grade.max_percent }}</td>
									<td class="action text-right">
										<a href="#!/edit-grade/{{grade.id}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
										<a ng-click="deleteGrade(grade.id)" data-toggle="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-trash"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
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
		template-url="<?php echo base_url(); ?>asset/js/dirPagination.tpl.html">
		</dir-pagination-controls>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->