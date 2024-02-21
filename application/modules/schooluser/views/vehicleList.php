<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="page-title">
                        <h5>Vehicle  Management (Vehicle List)</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">
                        <div class="right-actions"><a href="#!/add-vehicle" class="btn btn-primary"> <i class="icon-plus2"></i> Add Vehicle </a> </div>
                    </div>
                    <div class="right-actions">
                        <div class="right-actions"><a href="#!/driver-list" class="btn btn-primary"> <i class="icon-plus2"></i> Driver List </a> </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->
    <!-- BEGIN .main-content -->
    <div class="main-content ">
        
        
        <div class="card">
			<div class="card-body">
				<div class="table-responsive white-space-nowrap">
				 <table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
					<thead>
						<tr>
							<th>S.No.</th>
							
							<th>Vehicle Name</th>
					                <th>Vehicle Number</th>
							<th>Plate Number</th>
                                                        <th>Route Title & Code</th>
                                                        <th>Route Path</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						 <tr ng-repeat="vehicle in vehicleList">
							<td>{{$index + 1}}</td>
							<td>{{vehicle.vehicle_name}} ({{vehicle.vcode}})</td>
							<td>{{vehicle.vehicle_number}}</td>
                                                        <td>{{vehicle.plate_number}}</td>
							<td>{{vehicle.route_title}}({{vehicle.route_code}})</td>
                                                         <td>{{vehicle.routepath}}</td>
							<td class="action">
                                                            <a href="javascript:void(0);" ng-click="deleteVehicle(vehicle.id)"><i class="icon-delete" title="Delete"></i></a>
                                                        <a href="#!/edit-vehicle/{{vehicle.id}}"><i class="icon-edit2" title="Edit"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
				</div>
			</div>
		</div>
        
        
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->