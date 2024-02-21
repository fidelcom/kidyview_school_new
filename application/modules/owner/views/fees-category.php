<!-- BEGIN .app-main -->
<div class="app-main">
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-payment"></i>
							</div>
							<div class="page-title">
								<h5>Fee Category</h5>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="right-actions add-2px d-flex">
								<a href="#!/add-fees-category" class="btn btn-primary"><i class="icon-plus2"></i> Add Category</a>
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
						<!-- <div id="payment-listing_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer"> -->
						<div class="row">
							<div class="col-sm-12">
							<table id="payment-listing" datatable="ng" class="table  table-responsive">
							<thead>
								<tr role="row">
									<th>S.N.</th>
									<th>Fee Category</th>
									<th>Fee Description</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								
							<tr role="row" class="odd" ng-repeat="cat in feesCategory">
									<td class="sorting_1">{{ $index+1 }} </td>
									<td class="capitalize">{{ cat.category}}</td>
									<td class="capitalize">{{ cat.description}}</td>
									<td class="action">
										<a href="#!/edit-fees-category/{{cat.encrypt_id}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
										<a href="javascript:void(0);" ng-click="delete(cat.id)" data-toggle="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-trash"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			<!-- </div> -->
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
