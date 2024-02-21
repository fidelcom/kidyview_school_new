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
                        <h5>Lesson & Notes</h5>
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
                
                <div class="row set-tb-search">
                    <div class="col-md-12">
						<div class="table-responsive white-space-nowrap">
							<table datatable="ng" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No.</th>
                                                                                <th>Term</th>
                                                                                <th>Topic</th>
                                                                                <th>Subject</th>
										<th>Activity Type</th>
                                                                                <th>Share With Teacher</th>
                                                                                <th>Share With Class</th>
                                                                                <th>Status</th>
                                                                          	<th>Created Date</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="lessonnote in lessonnotelist">
										<td>{{$index + 1}}</td>
                                                                                <td>{{lessonnote.termname}}</td>
										<td>{{lessonnote.topic}}</td>
										<td>{{lessonnote.subjectname}}</td>
							                        <td>{{lessonnote.activity_type}}</td>
                                                                                <td ng-if="lessonnote.sharewithteacher == '1' ">yes</td>
                                                                                <td ng-if="lessonnote.sharewithteacher == '0' ">No</td>
                                                                                <td ng-if="lessonnote.sharewithclass == '1' ">Yes</td>
                                                                                <td ng-if="lessonnote.sharewithclass == '0' ">No</td>
                                                                                
                                                                                <td ng-if="lessonnote.status == '1' ">Active</td>
                                                                                <td ng-if="lessonnote.status == '0' ">Inactive</td>
                                                                                <td>{{lessonnote.created_date}}</td>
                                                                                <td class="text-right action">
											<a  href="#!/view-note/{{lessonnote.lessonID}}"><i class="icon-eye" title="View"></i></a>
                                                                                        <a ng-if="lessonnote.status == '1'"><i class="fas fa-toggle-on" ng-click="noteDisabled(lessonnote.id, 0);"></i></a>
                                                                                        <a ng-if="lessonnote.status == '0'"><i class="fas fa-toggle-off" ng-click="noteDisabled(lessonnote.id, 1);"></i></a>
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