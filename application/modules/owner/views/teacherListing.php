<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
                    <div class="page-icon">
                        <i class="icon-school mt-2"></i>
                    </div>
                    <div class="page-title ml-3 align-self-center">
                        <h5>Teacher Management</h5>
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
                    <div class="col-md-4 col-lg-6">
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
										<th>Teacher Name</th>
										<th>Email Id</th>
										<th>Address</th>
										<th>City</th>
										<th>Pin Code</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="x in dataList">
										<td>{{x.teacherfname}} {{x.teachermname}} {{x.teacherfname}}</td>
										<td>{{x.teacheremail}}</td>
										<td>{{x.teacheraddress}}</td>
										<td>{{x.tcity}}</td>
										<td>{{x.tpincode}}</td>
										<td class="text-right action">
											<a href="#!/teacher-view/{{x.teacherID}}" alt="{{x.id}}"><i class="icon-eye"></i></a>
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