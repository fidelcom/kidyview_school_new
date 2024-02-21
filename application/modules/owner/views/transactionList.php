BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-school"></i>
					</div>
					<div class="page-title">
						<h5>Transaction History</h5>
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
				<div class="table-responsive white-space-nowrap">
				<table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
				
					<thead>
						<tr>
							<th>S.No.</th>
                                                    	<th>Transaction Id</th>
					           	<th>Paid Amount</th>
							<th>Currency</th>
                                                        <th>Exchange Currency Rate</th>
                                                        <th>Payment Type</th>
                                                        <th>Subcription Plan</th>
				                        <th>Transaction Status  </th>
                                                        <th>Transaction Date </th>
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="transaction in transactionList">
						
							<td>{{$index + 1}}</td>
                                                 	<td>{{transaction.transaction_id}}</td>
				                        <td>{{transaction.amount}}</td>
							<td>{{transaction.currency}}</td>
                                                        <td>{{transaction.currency_rate}}</td>
                                                         <td>{{transaction.payment_type}}</td>
                                                        <td>
                                                            {{transaction.sub_name}}
                                                           {{transaction.sub_plan_amount}} ({{transaction.sub_currency}}) 
                                                        </td>
                                                         <td>{{transaction.status}}</td>
                                                         <td>{{transaction.payment_date}}</td>
							
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main