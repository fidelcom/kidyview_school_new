<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-3 mb-sm-0 align-self-center">
					<div class="page-icon">
						<i class="fas fa-credit-card"></i>
					</div>
					<div class="page-title mob-lineheight">
						<h5>Payment History</h5>
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
							<th >Taxation Number</th>
							<th>Student Name</th>
                                                        <th>Class</th>
                                                   	<th>Father Name</th>
							<th>amount</th>
                                                        <th>currency</th>
				                        <th>Payment Status </th>
                                                        <th>Transaction Status  </th>
                                                        <th>Transaction Date </th>
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="transaction in transactionList" ng-if="transaction.is_paid=='paid'">
                                  
							<td>{{$index + 1}}</td>
							<td>{{transaction.tx_ref}}</td>
							<td>{{transaction.studentName}}</td>
                                                        <td>{{transaction.className}}{{transaction.classSection}}</td>
                                                        <td>{{transaction.fatherlname}}</td>
							<td>{{transaction.amount}}</td>
							<td>{{transaction.currency}}</td>
                                                        <td>{{transaction.is_paid}}</td>
                                                         <td>{{transaction.transaction_status}}
                                                            
                                                                 <a download="true"  href ="<?php echo base_url().'api/Invoicedownload/feesinvoice/';?>{{transaction.tx_ref}}">    
                                                                    <i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red;"></i>
                                                                 <a/>
                                                         </td>
                                                         <td>{{transaction.transaction_date}}</td>
                                          
						</tr>
					</tbody>
				</table>
				
			</div>
                  </div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->