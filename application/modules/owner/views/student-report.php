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
                        <h5>Student Report</h5>
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

        <?php $this->load->view('filter-list.php'); ?>
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="page-title float-left">
                                    <h4 class="mb-0">Student Listing</h4>
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
                                    <th>Student Name</th>
                                    <th>Class</th>
                                    <th>Father Name</th>
                                    <th>Mother Name</th>
                                    <th>Address</th>
                                    <th>Phone</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="res in searchingData">
                                 <td>#{{$index + 1}}</td>
                                 <td>{{res.school_name}} </td>  
                                 <td>{{res.childfname}} {{res.childmname}} {{res.childlname}}</td>
                                 <td>{{res.class}} {{res.section}}</td>
                                 <td>{{res.fatherfname}} {{res.fatherlname}} </td>
                                 <td>{{res.motherfname}} {{res.motherlname}}</td>
                                 <td>{{res.fatheraddress}}</td>
                                 <td>{{res.fatherphone}}</td>
                                 
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


