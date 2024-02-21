<!-- BEGIN .app-main -->
<div class="app-main">
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-wallet"></i>
							</div>
							<div class="page-title">
								<h5>Subscription Amount</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/fee-suscription" class="btn btn-primary"> <i class="icon-plus2"></i> Create Subscription Amount</a>
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
							<div class="col-sm-12">
							<table id="payment-listing" datatable="ng" class="table  table-responsive">
							<thead>
								<tr role="row">
									<th>S.N.</th>
									<th>School Type</th>
									<th>Class</th>
									<th>Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr role="row" class="odd" ng-repeat="data in feeSuscriptionList">
									<td class="sorting_1">{{ $index+1 }}</td>
									<td class="sorting_1">{{ data.school_type }}</td>
									<td class="sorting_1">{{ data.class }}</td>
									<td>{{ data.amount +' '+ data.currency}}  </td>
									<td class="action">
										<!-- <a href="#!/fees-details/{{ fees.id_encrypt }}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i>
										</a> -->

										<!-- <a href="javascript:void(0);" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a> -->

										<a ng-click="subscriptionAmountDelete(data.id)"><i class="icon-trash"></i></a>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
