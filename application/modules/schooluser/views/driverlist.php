<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 mb-3 mb-sm-0 align-self-center">
					<div class="page-icon">
						<i class="fas fa-car"></i>
					</div>
					<div class="page-title mob-lineheight">
						<h5>Driver & Device Management</h5>
					</div>
				</div>
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12">
					<div class="right-actions"><a href="#!/add-driver" class="btn btn-primary"> <i class="icon-plus2"></i> Add Driver</a></div>
					<div class="right-actions" style="margin-right:5px;"><a href="#!/add-vehicle" class="btn btn-primary"> <i class="icon-plus2"></i> Add Vehcle</a></div>
					<div class="right-actions" style="margin-right:5px;"><a href="#!/add-route" class="btn btn-primary"> <i class="icon-plus2"></i> Add Route</a></div>
					<div class="right-actions" style="margin-right:5px;"><a href="#!/assign-student" class="btn btn-primary"> <i class="icon-plus2"></i> Assign Student</a></div>
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
							<th >Driver Name & Code</th>
							
							<th>Mobile Number</th>
                                                        <th>License Number</th>
                                                    	<th>Vehicle Name & Code</th>
							<th>Vehicle Number</th>
							<th>Vehicle Route</th>
                                                        <th>Created Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="driver in driverList"> 
						
							<td>{{$index + 1}}</td>
							<td>{{driver.driverfname}} {{driver.driverlname}} ({{driver.drivercode}})({{driver.driveremail}})</td>
							<td>{{driver.driverphone}}</td>
                                                        <td>{{driver.driverlicense}}</td>
                                                        <td>{{driver.vehicle_name}} ({{driver.vcode}})</td>
							<td>{{driver.vehicle_number}}</td>
							<td>{{driver.routepath}}</td>
                                                        <td>{{driver.created_date}}</td>
                                                         
							<td class="action">
                                                                <a target="_blank" href="#!/track-driver/{{driver.driverID}}"><i class="fa fa-automobile" title="Track Driver"></i></a>
                                                                <a target="_blank" href="#!/view-students/{{driver.driverID}}"><i class="fa fa-file" title="View Students"></i></a>
								<a href="#!/driver-detail/{{driver.driverID}}"><i class="icon-eye" title="View"></i></a>
								<a href="#!/edit-driver/{{driver.driverID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-if="driver.status == '1'"><i class="fas fa-toggle-on" ng-click="driverDisabled(driver.id, 0);"></i></a>
								<a ng-if="driver.status == '0'"><i class="fas fa-toggle-off" ng-click="driverDisabled(driver.id, 1);"></i></a>
							</td>
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