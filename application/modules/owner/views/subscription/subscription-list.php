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
                <h5>Subscription Management</h5>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
            <div class="right-actions">
                <a href="#!/add-subscription" class="btn btn-primary"><i class="icon-plus2"></i> Add Subscription</a>
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
										<th>S.No.</th>
										<th>Subscription Name</th>
										<th>Type</th>
										<th>Validity</th>
                                        <th>Amount (NGN)</th>
                                        <th>Maximum number of children</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="subscription in subscriptionList">
										<td>{{$index + 1}}</td>
										<td>{{subscription.name}}</td>
										<td>{{subscription.type}}</td>
										<td>{{subscription.validity}}</td>
                                        <td>{{subscription.amount}}</td>
                                        <td>{{subscription.no_of_student}}</td>
										<td class="text-right action">
											<a  href="#!/subscription-detail/{{subscription.subscriptionID}}"><i class="icon-eye" title="View"></i></a>
                                            <a  href="#!/edit-subscription/{{subscription.subscriptionID}}"><i class="icon-edit2" title="Edit"></i></a>
                                            <a ng-if="subscription.status == '1'"><i class="fas fa-toggle-on" ng-click="subscriptionDisabled(subscription, '0');"></i></a>
                                            <a ng-if="subscription.status == '0'"><i class="fas fa-toggle-off" ng-click="subscriptionDisabled(subscription, '1');"></i></a>
                                            <a ng-click="delete(subscription.id)"><i class="icon-trash2" title="Delete"></i></a>
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