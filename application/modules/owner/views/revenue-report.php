<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 align-self-center">
                    <div class="page-icon">
                        <i class="icon-laptop_windows"></i>
                    </div>
                    <div class="page-title">
                        <h5>Revenue Report</h5>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
                    <div class="right-actions">
                        <!-- <a href="#" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="left" title="Download Reports">
                                                            <i class="icon-download4"></i>
                                                    </a> -->
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->
    <!-- BEGIN .main-content -->
    <div class="main-content">

        <?php // $this->load->view('filter-list.php'); ?>
        
      <!--------------- Custom Filter ----------->
        <div class="card">
            <div class="card-header">Generate Report</div>
            <div class="row ml-0 mr-0 pt-3 pb-0">
                <div class="col-md-12 mb-3">
                    <a class="btn btn-primary" href="#!/reportParent"><i class="fas fa-user-secret"></i> Parent</a>
                    <a class="btn btn-success" href="#!/reportStudent"><i class="fas fa-user-graduate"></i> Student</a>
                    <a class="btn btn-info" href="#!/reportTeacher"><i class="fas fa-chalkboard-teacher"></i> Teacher</a>
                    <a class="btn btn-dark" href="#!/reportSchool"><i class="fas fa-school"></i> School</a>
                    <a class="btn btn-warning" href="#!/reportDriver"><i class="fas fa-car"></i> Driver</a>
                    <a class="btn btn-danger" href="#!/reportRevenue"><i class="fas fa-file-invoice-dollar"></i> Revenue</a>

                </div>
            </div>
        </div>

        <div class="card filter-card">
            <div class="card-header"><i class="icon-funnel"></i> Filter</div>
            <div class="row ml-0 mr-0 pt-3 pb-0">

                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="controls"> 
                            <ui-select multiple ng-model="parent.countryCodes" ng-disabled="parent.countryCodes.disabled" ng-change="getAllSchool(parent.countryCodes)" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                                <ui-select-match placeholder="Select Country">{{$item.country}}</ui-select-match>
                                <ui-select-choices repeat="cc.id as cc in countryCodes | propsFilter: {country: $select.search}">
                                    <div>{{cc.country}} </div>                                         
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                </div>      



                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="controls"> 

                            <ui-select multiple ng-model="parent.schoolLists" ng-disabled="parent.schoolLists.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                                <ui-select-match placeholder="Select School">{{$item.school}}</ui-select-match>
                                <ui-select-choices repeat="sc.id as sc in schoolLists | propsFilter: {school: $select.search}">
                                    <div>{{sc.school}} </div>                                         
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                </div>

<!--                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="controls"> 

                            <ui-select multiple ng-model="parent.classSectionList" ng-disabled="parent.schoolList.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;">  
                                <ui-select-match placeholder="Select Class & Section">{{$item.class}}{{$item.section}}</ui-select-match>
                                <ui-select-choices repeat="lc.id as lc in classSectionList | propsFilter: {class: $select.search}">
                                    <div>{{lc.class}} {{lc.section}}</div>                                         
                                </ui-select-choices>
                            </ui-select>
                        </div>
                    </div>
                </div>-->



<!--        <input ng-model="parent.fromdate" id="fromdate" type="hidden" class="form-control"  />
<input ng-model="parent.todate" id="todate"  type="hidden" class="form-control" />-->

                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">From Date</label> <input ng-model="parent.fromdate" id="fromdate" type="date" class="form-control"  />
                    </div>

                </div>


                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label class="form-label">To Date</label> <input ng-model="parent.todate" id="todate"  type="date" class="form-control" />
                    </div>

                </div>



                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <input class="btn btn-primary" type="button" ng-click="getReport(parent)" value="Search">

                    </div>
                </div>

            </div>
        </div>

    <!--------------- End Custom Filter ----------->
        
    
    
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-title float-left">
                                    <h4 class="mb-0">Revenue Listing</h4>
                                </div>
                                <div class="page-title float-right">
                                        <!-- <a href="#" class="btn btn-info"><i class="icon-export"></i> Export</a> -->
                                    <input class="btn btn-primary" type="button" ng-click="exportCSV()" value="Export as Csv">
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive white-space-nowrap">
                      <table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
                      
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>School Name</th>
                                    <th>Email ID</th>
                                    <th>Address</th>
                                    <th>City</th>
                                    <th>Pincode</th>
                                    <th>Subscription plan</th>
                                    <th>Subscription validity</th>
                                    <th>Subscription amount(NGN) </th>
                                    <th>Subscription period</th>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="res in searchingData">
                                 <td>#{{$index + 1}}</td>
                                 <td>{{res.school_name}} </td>  
                                 <td>{{res.email}}</td>
                                 <td>{{res.location}} </td>
                                 <td>{{res.city}} </td>
                                 <td>{{res.pincode}} </td>
                                 <td>{{res.subTitle}}</td>
                                 <td>{{res.validity}}</td>
                                 <td>{{res.amount}}</td>
                                 <td>{{res.period}}</td>
                                 
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
<?php $this->load->view('multiselect.php'); ?>


