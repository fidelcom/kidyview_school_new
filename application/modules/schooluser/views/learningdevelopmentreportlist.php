<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-code"></i>
					</div>
					<div class="page-title">
						<h5>Learning & Development Report</h5>
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
				<div class="d-filter-block">
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
					
					<div class="row">
						<!--div class="col-md-4">
							<label>Teacher Name</label>
							<select class="form-control">
								<option value="" selected>Select Teacher</option>
								<option value="">Steve Jones</option>
								<option value="">Nicholas</option>
								<option value="">Aamannguaq</option>
								<option value="">James William</option>
								<option value="">Alexandru</option>
								<option value="">Daniel</option>
								<option value="">Jonas</option>
								<option value="">Ben Stock</option>
							</select>
						</div>
						<div class="col-md-4">
							<label>Category</label>
							<select class="form-control" ng-model="search">
								<option value="" selected>Select Category</option>
								<option value="Personal">Personal</option>
								<option value="Communication & Language">Communication & Language</option>
								<option value="Mathematics">Mathematics</option>
								<option value="Understanding the World">Understanding the World</option>
							</select>
						</div>
					</div-->
				</div>
				<div class="table-responsive">
				<table id="inbox-table" class="table table-striped table-bordered cate-table-new">
					<thead>
						<tr>
							<th data-animate="Time" data-toggle="tooltip" data-original-title="Teacher Name" data-placement="top">Teacher Name</th>
							<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Student Name" data-placement="top">Student Name</th>
							<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Category" data-placement="top">Category</th>
							<th data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Result" data-placement="top">Result</th>
							<th class="text-right" data-animate="animated fadeIn" data-toggle="tooltip" data-original-title="Action" data-placement="top">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="LearningDevelopmentReport in LearningDevelopmentReportList|filter:search|itemsPerPage:pageSize">
							<td>{{LearningDevelopmentReport.teacherfname}} {{LearningDevelopmentReport.teacherlname}}</td>
							<td>{{LearningDevelopmentReport.childfname}} {{LearningDevelopmentReport.childmname}} {{LearningDevelopmentReport.childlname}}</td>
							<td>{{LearningDevelopmentReport.category_name}}</td>
							<td>{{LearningDevelopmentReport.answer}}</td>
							<td class="action text-right">
								<a href="#!/learning-and-development-report-detail/{{LearningDevelopmentReport.learningDevelopmentReportListID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
								<!--a href="#" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
								<a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-trash"></i></a-->
							</td>
						</tr>
					</tbody>
				</table></div>
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
		
		<!-- Card end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->