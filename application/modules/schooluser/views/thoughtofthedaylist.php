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
						<h5>Thought of the day</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-thoughtoftheday" class="btn btn-primary"> <i class="icon-plus2"></i> Add Thought</a>
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
									<th class="title-th" data-animate="Time" data-toggle="tooltip" data-original-title="Though Title" data-placement="top">Title</th>
									<th class="date-th" data-animate="Time" data-toggle="tooltip" data-original-title="Date" data-placement="top">Date</th>
									<th class="description-th" data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Description" data-placement="top">Description</th>
									<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Author Name" data-placement="top">Author</th>
									<th class="text-right" data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Action" data-placement="top">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr dir-paginate="thought in thoughtList|filter:search|itemsPerPage:pageSize">
									<td>{{thought.title}}</td>
									<td>{{thought.formattedDate}}</td>
									<td>{{thought.description}}</td>
									<td>{{thought.author_name}}</td>
									<td class="action text-right">
										<a href="#!/edit-thoughtoftheday/{{thought.thoughtID}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
										<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-trash"></i></a>
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
		template-url="asset/js/dirPagination.tpl.html">
		</dir-pagination-controls>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->