<div class="app-main">
                <!-- BEGIN .main-heading -->
                <header class="main-heading">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                                <div class="page-icon">
                                    <i class="icon-calendar3"></i>
                                </div>
                                <div class="page-title">
                                    <h5>Request day off</h5>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                <div class="right-actions">
                                    <!-- <a href="add-school.html" class="btn btn-primary">Add School</a>
                                <a href="#" class="btn btn-primary">Add School</a> -->
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
                        <div class="table-responsive day-req-table">
                            <table id="dayoff-listing"  datatable="ng" class="table result_parenets_filter parents-listing-c table-striped table-bordered table-responsive">
                             
                                <thead>
                                    <!-- <tr id="filters">
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr> -->
                                    <tr>
                                        <th>S.No.</th>
                                        <th class="white-space-r">Name</th>
                                        <th class="white-space-r">Role</th>
                                        <th class="white-space-r">Date From</th>
                                        <th class="white-space-r">Date To</th>
                                        <th class="white-space-r">Total Applied Days</th>
                                        <th class="white-space-r">Working Days</th>
                                        <th class="white-space-r">Status</th>
                                        <th class="add-break-word">Reason</th>
                                        <th class="white-space-r text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="dayoff in dayOff">
                                        <td class="white-space-r">{{ $index+1 }}</td>
                                        <td class="white-space-r">{{ dayoff.name ? dayoff.name : '' }}</td>
                                        <td class="white-space-r text-capitalize">{{ dayoff.user_type ? dayoff.user_type : '' }}</td>
                                        <td class="white-space-r">{{ dayoff.from_date ? dayoff.from_date : '' }}</td>
                                        <td class="white-space-r">{{ dayoff.to_date ? dayoff.to_date : '' }}</td>
                                        <td class="white-space-r">{{ dayoff.number_of_days ? dayoff.number_of_days+' days' : ''}} </td>
                                        <td class="white-space-r">{{ dayoff.working_days ? dayoff.working_days+' days' : '' }} </td>

                                        <td class="white-space-r">
                                            <span class="badge text-danger text-capitalize" 
                                            ng-if="dayoff.status == 'Denied' ">{{ dayoff.status ? dayoff.status : '' }} </span>
                                            
                                            <span class="badge text-success text-capitalize" ng-if="dayoff.status == 'Approved' ">{{ dayoff.status ? dayoff.status : '' }} </span>

                                            <span class="badge text-capitalize" ng-if="dayoff.status == 'created' " style="color: darkblue;">{{ dayoff.status ? dayoff.status : '' }} </span>

                                        </td>
                                        
                                        <td class="add-break-word"><span class="note text-capitalize">{{ dayoff.reason ? dayoff.reason : ' ' }}</span></td>
                                        <td class="action text-right white-space-r action-button-match">
                                            <a href="#!/request-day-off-details/{{dayoff.concat_id_encrypt}}" data-toggle="tooltip" data-original-title="View Details" data-placement="top"><i class="icon-eye"></i></a>
                                            
                                            <!-- <button type="button" class="btn n-btn btn-info" data-toggle="tooltip" data-original-title="Download" data-placement="top"><i class="icon-download"></i></button> -->
                                            <button type="button" class="btn-success" data-toggle="tooltip" data-original-title="Approved" data-placement="top" ng-click="dayoffStatus(dayoff.id,dayoff.user_type,'Approved')"><i class="icon-check" style="cursor:pointer;"></i></button>
                                            <button type="button" class="btn-danger" data-toggle="tooltip" data-original-title="Deny" data-placement="top" ng-click="dayoffStatus(dayoff.id,dayoff.user_type,'Denied')"><i class="icon-close" style="cursor: pointer;"></i></button>
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