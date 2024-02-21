<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-clock"></i>
					</div>
					<div class="page-title">
						<h5>Discussion Categories</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-discussioncat" class="btn btn-primary"> <i class="icon-plus2"></i> Add Discussion Category</a>
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
		
				<div class="table-responsive white-space-nowrap">
				<table class="table parents-listing-c table-striped table-bordered">
					<thead>
						<tr>
							<th>S. No</th>
							<th ng-click="sort('class')" class="sorting-tb">Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='class'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="discussionCat in discussionCatList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize" current-page="currentPage">
							<td>{{pageSize * (currentPage-1)+$index+1}}</td>
							<td>{{discussionCat.name}}</td>
							<td class="action text-right">
								<a href="#!/edit-discussioncat/{{discussionCat.discussionCatID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-if="discussionCat.status == '1'">
                                    <i class="fas fa-toggle-on" ng-click="discussionCatDisabled(discussionCat.id, 0);"></i>
								</a>
                                
								<a ng-if="discussionCat.status == '0'">
									<i class="fas fa-toggle-off" ng-click="discussionCatDisabled(discussionCat.id, 1);"></i>
								</a>
                                
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
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
