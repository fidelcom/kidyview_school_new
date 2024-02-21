<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
					<div class="page-icon">
						<i class="icon-th-list mt-2"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>Gift Management</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-gift" class="btn btn-primary"> <i class="icon-plus2"></i> Add Gift</a>
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
						<div class="form-group">
							<label>Search</label>
							<input type="text" ng-model="search" class="form-control" placeholder="Search">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="search">items per page</label>
							<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
						</div>
					</div>
				</div>
				<div class="table-responsive white-space-nowrap">
					<table class="table parents-listing-c table-striped table-bordered">
						<thead>
							<tr>
								<th>Product ID</th>
								<th>Name</th>
								<th>Amount</th>
								<th>Points</th>
								<th>Brand</th>
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr dir-paginate="gift in giftList|filter:search|itemsPerPage:pageSize">
								<td>{{gift.code}}</td>
								<td>{{gift.name}}</td>
								<td>{{gift.amount}}</td>
								<td>{{gift.points}}</td>
								<td>{{gift.brand}}</td>
								<td class="action text-right">
									<a href="#!/edit-gift/{{gift.giftID}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
									<a ng-if="gift.status == '1'">
										<i class="fas fa-toggle-on" ng-click="giftDisabled(gift.id, 0);"></i>
									</a>
									<a ng-if="gift.status == '0'">
										<i class="fas fa-toggle-off" ng-click="giftDisabled(gift.id, 1);"></i>
									</a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<dir-pagination-controls
				max-size="10" class="mt-3 mb-5 mb-5 float-left"
				direction-links="true"
				boundary-links="true">
				</dir-pagination-controls>
				<dir-pagination-controls
				max-size="10"
				direction-links="true" class=" mt-3 mb-5 float-right display_nmbr"
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