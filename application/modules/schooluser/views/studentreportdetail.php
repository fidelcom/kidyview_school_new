<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-file-text"></i>
                    </div>
                    <div class="page-title">
                        <h5>Reports</h5>
                        
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
            <div class="row btn-filter-group mt-2 pl-3">
                <div class="col-md-12">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary mr-0 pl-5 pr-5 active tab" ng-click="getreporttype('daily');">Daily</button>
                        <button type="button" class="btn btn-primary mr-0 pl-5 pr-5 tab" ng-click="getreporttype('monthly');">Monthly</button>
                        <button type="button" class="btn btn-primary pl-5 pr-5 tab" ng-click="getreporttype('term');">Term</button>
                    </div>
                </div>
            </div>
            <div class="card-body mt-0 pt-0" ng-show="reporttype == 'daily'">
                <div class="row mt-2 bg-light m-0 p-2">
                    <div class="col-md-6 align-self-center">

                        <div class="searchblock-n">

                            <div class="input-group mb-3">
                                <input type="date"   ng-model="termDate"   class="form-control">
                                <div class="input-group-append">
                                    <button style="margin-left:10px;" type="button" ng-click="getDailyReports()" class="btn btn-primary">Get Report</button>
                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="row mt-2 pl-3 pr-3 m-0 p-2">
                    <div class="col-md-4 align-self-center"></div>
                    <div class="col-md-4 pr-0 align-self-center text-right">
                        <span class="text-bold">Feed Check In Time:</span> {{checkData.checkIn}}
                    </div>
                    <div class="col-md-3 pl-0 pr-0 align-self-center text-right">
                        <span class="text-bold">Check Out Time:</span> {{checkData.checkOut}}
                    </div>
<!--                    <div class="col-md-1 text-right pl-0">
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
                    </div>-->
                </div>
                <hr />
                <div class="col-md-12" >
                    <table datatable="ng" class="table table-striped table-bordered">


                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Created By</th>
                                <th>Message</th>
                                <th>Options</th>
                                <th>other</th>
                                <th>Report Type</th>
                                <th>Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="report in reports">
                                <td>{{$index + 1}}</td>
                                <td>{{report.fname}}  {{report.lname}}</td>
                                <td>{{report.message}}</td>
                                <td>{{report.options}}</td>
                                <td>{{report.other}}</td>
                                <td>{{report.report_type}}</td>
                                <td>{{report.on_date}}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-body mt-0 pt-0" ng-show="reporttype == 'monthly'">
                <div class="row mt-2 bg-light m-0 p-2">
                    <div class="col-md-4 align-self-center">
                        <div class="d-flex">
                            <span class="mr-2 align-self-center">Month:</span> 
                            <select class="form-control" ng-model="monthtly_month">
                                <option value="" selected="selected">Select Month</option>
                                <option value="{{month.val}}"  ng-repeat="month in monthName">{{month.name}}</option>
                            </select>
                           
                        </div>
                         
                        
                    </div>
                    
                   <div class="col-md-5 align-self-center">
                        <div class="d-flex">
                        <span class="mr-2 align-self-center">Year:</span> 
                            <select class="form-control" ng-model="monthtly_year">
                                <option value="" selected="selected">Select Year</option>
                                <option value="{{y}}"  ng-repeat="y in yearList">{{y}}</option>
                            </select>
                         <button style="margin-left:10px;" type="button" ng-click="getReportByMonth()" class="btn btn-primary">Get Report</button>
                         </div>
                     </div>
                    
                </div>
               
                
                <div class="row mt-2 pl-3 pr-3 m-0 p-2">
                    <div class="col-md-4 align-self-center"></div>
                    <div class="col-md-4 pr-0 align-self-center text-right">
                        <span class="text-bold">Feed Check In Time:</span> {{checkData.checkIn}}
                    </div>
                    <div class="col-md-3 pl-0 pr-0 align-self-center text-right">
                        <span class="text-bold">Check Out Time:</span> {{checkData.checkOut}}
                    </div>
<!--                    <div class="col-md-1 text-right pl-0">
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
                    </div>-->
                </div>
                
                <hr />
                <div class="col-md-12" >
                    <table datatable="ng" class="table table-striped table-bordered">


                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Created By</th>
                                <th>Message</th>
                                <th>Report Month</th>
                                <th>Created Date</th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="report in monthReports">
                                <td>{{$index + 1}}</td>
                                <td>{{report.fname}}  {{report.lname}}</td>
                                <td>{{report.detail}}</td>
                                <td>{{report.for_month}}</td>
                                <td>{{report.created_date}}</td>
                           

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="card-body mt-0 pt-0" ng-show="reporttype == 'term'">
                <div class="row mt-2 bg-light m-0 p-2">
                    <div class="col-md-6 align-self-center">

                        <div class="searchblock-n">

                            <div class="input-group mb-3">
                                <span class="mr-2 align-self-center"> Term :</span> 
                            <select class="form-control" ng-model="term">
                                <option value="" selected="selected">Select Term</option>
                                <option value="{{term.id}}"  ng-repeat="term in terms">{{term.termname}}</option>
                            </select>
                         <button style="margin-left:10px;" type="button" ng-click="getReportTerms()" class="btn btn-primary">Get Report</button>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="row mt-2 pl-3 pr-3 m-0 p-2">
                    <div class="col-md-4 align-self-center"></div>
                    <div class="col-md-4 pr-0 align-self-center text-right">
                        <span class="text-bold">Feed Check In Time:</span> {{checkData.checkIn}}
                    </div>
                    <div class="col-md-3 pl-0 pr-0 align-self-center text-right">
                        <span class="text-bold">Check Out Time:</span> {{checkData.checkOut}}
                    </div>
<!--                    <div class="col-md-1 text-right pl-0">
                        <a href="javascript:void(0);" class="btn btn-primary btn-sm" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
                    </div>-->
                </div>
                <hr />
                <div class="col-md-12" >
                    <table datatable="ng" class="table table-striped table-bordered">


                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Created By</th>
                                <th>Message</th>
                                <th>Term</th>
                                <th>Created Date</th>
                                

                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="report in termReports">
                                <td>{{$index + 1}}</td>
                                <td>{{report.fname}}  {{report.lname}}</td>
                                <td>{{report.detail}}</td>
                                <td>{{report.termname}}</td>
                                <td>{{report.created_date}}</td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            
            <a class="btn btn-secondary" href="#!/student-report">Back To List</a>
            <!-- Row end -->
        </div>
        <!-- END: .main-content -->
    </div>
    <!-- END: .app-main -->