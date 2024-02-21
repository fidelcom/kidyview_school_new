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
								<h5>Fees</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-fees" class="btn btn-primary"> <i class="icon-plus2"></i> Create Fees</a>
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
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<div class="col-md-3">
								<div class="form-group">
										<!-- <label class="form-label">Select Class</label> -->
										<div class="controls">
											<select id="select_class" class="form-control" ng-model="class_id" ng-change="getfeesList()">
												<option value="">Select Class</option>
												<option value="{{cs.id}}" ng-repeat="cs in classList">{{cs.class+" "+cs.section}}</option>
											</select>
                                                                                    
										</div>                                      
									</div>
								</div>
								<div class="col-md-3">
								<div class="form-group">
										<select class="form-control" id="sessionID" ng-model="sessionID" ng-change="getfeesList()">
											<option ng-repeat="session in sessionList" value="{{session.id}}">{{session.academicsession}}</option>
										</select>
									</div>
								</div>
								<div class="col-md-6 text-right">
								<div class="right-actions">
									<button ng-click="getStudentData();" class="btn btn-primary" href="javascript:void(0);">Download Fees Card</button>
									</div>
								</div>
							</div>
									
									
									
								</div>
							<div class="col-sm-12">
							<table id="payment-listing" datatable="ng" class="table  table-responsive">
							<thead>
								<tr role="row">
									<th>S.N.</th>
									<th>Class</th>
									<th>Amount</th>
									<th>Subscription Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<tr role="row" class="odd" ng-repeat="fees in feesList">
									<td class="sorting_1">{{ $index+1 }}</td>
									<td class="sorting_1">{{ fees.class }}</td>
									<td> {{ fees.fee_amount ? fees.currency_symbol+fees.fee_amount : '-' }} </td>
									<td> {{ fees.suscription_fee ? fees.currency_symbol+fees.suscription_fee : '-' }} </td>
									<td class="action">
										<a href="#!/fees-details/{{ fees.id_encrypt }}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i>
										</a>
										<a href="#!/edit-fees/{{ fees.id_encrypt }}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>

										<a ng-click="feeDelete(fees.id)"><i class="icon-trash"></i></a>
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
<div class="modal fade custom_modal" id="selectStudentList" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">×</button>
			  <h4 class="modal-title">Download Fees Report Card</h4>
			</div>
			<div class="modal-body">
				<form class="ng-pristine ng-invalid ng-invalid-required">
			
					<div class="row form-group">
						
						<div class="col-md-12">
							<select class="form-control" name="student_id" ng-model="student_id">
							<option value="">Select Student</option>
							<option value="{{child.id}}" ng-repeat="child in classStudents">{{child.studentName}}</option>
							</select>
						</div>
					</div>
					 
					<div class="row form-group mt-3">
						
						<div class="col-md-12">
							<button ng-click="downloadFeeCard()" class="btn btn-primary">Submit</button>
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
</div>
