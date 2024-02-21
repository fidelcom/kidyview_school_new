<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
            <div class="page-icon">
                <i class="icon-subscriptions"></i>
            </div>
            <div class="page-title">
                <h5>Manage Voucher</h5>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
            <div class="right-actions">
                <a href="#!/add-voucher" class="btn btn-primary"><i class="icon-plus2"></i> Add Voucher</a>
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
                <div class="row set-tb-search">
                    <div class="col-md-12">
						<div class="table-responsive white-space-nowrap">
							<table datatable="ng" class="table table-striped table-bordered">
								<thead>
									<tr>
									<th>Voucher Code</th>
									<th>Product ID</th>
									<th>Points</th>
									<th>Usage / Limit</th>
									<th>Expiry Date</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="v in voucherList">
									<td>{{v.voucher_code}}</td>
									<td>{{v.code}}</td>
									<td>{{v.points}}</td>
									<td>{{v.quantity}}</td>
									<td>{{v.expire_date|myDate}}</td>
									<td class="text-right action">
										<a  href="#!/edit-voucher/{{v.voucherID}}"><i class="icon-edit2" title="Edit"></i></a>
										<a ng-click="delete(v.id)"><i class="icon-trash2" title="Delete"></i></a>
									</td>
									</tr>
								</tbody>
							</table>	
						</div>
                    </div>
                </div>    
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->