<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
                    <div class="page-icon">
                        <i class="fas fa-car mt-2"></i>
                    </div>
                    <div class="page-title ml-3 align-self-center">
                        <h5>Driver Management</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">

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
                        <select ng-model="school_id" class="form-control" ng-change="getData()">
                            <option ng-value="x.id" ng-repeat="x in schoolList">{{x.school_name}}</option>
                        </select>
                    </div>
                </div>
                <div class="row set-tb-search">
                    <div class="col-md-12">
						<div class="table-responsive white-space-nowrap">
							<table datatable="ng" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Driver Name</th>
										<th>Mobile Number</th>
										<th>Device Number</th>
										<th>Bus Number</th>
										<th>License Number</th>
										<th>Route</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="driver in dataList">
										<td>{{$index + 1}}</td>
										<td>{{driver.driverfname}} {{driver.driverlname}}</td>
										<td>{{driver.driverphone}}</td>
										<td>{{driver.driverdeviceId}}</td>
										<td>{{driver.driverVechiclenumber}}</td>
										<td>{{driver.driverlicense}}</td>
										<td>{{driver.driverroute}}</td>
										<td class="text-right action">
											<a  href="#!/driver-view/{{driver.driverID}}"><i class="icon-eye" title="View"></i></a>
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