<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
                    <div class="page-icon">
                        <i class="icon-drag_handle"></i>
                    </div>
                    <div class="page-title ml-3 align-self-center">
                        <h5>Feedback</h5>
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
                      
                        <select ng-model="userType" class="form-control" ng-change="getuserFeedback(userType)">
                            <option value="" selected="selected" >Please Select</option>
                            <option ng-repeat="opt in optionsList" value="{{opt.name}}">{{opt.name}}</option>
                            
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
                                                                                <th>Name</th>
										<th>User Type</th>
										<th>Day & Date</th>
										<th>School Name</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="feed in feedback">
										<td>{{$index + 1}}</td>
                                                                                <td>{{feed.fname}}</td>
										<td>{{feed.user_type}}</td>
										<td>{{feed.created}}</td>
										<td>{{feed.school}}</td>
										<td class="text-right action">
											<a  href="#!/feedback-view/{{feed.id}}"><i class="icon-eye" title="View"></i></a>
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