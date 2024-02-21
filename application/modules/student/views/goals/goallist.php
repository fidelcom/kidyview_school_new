<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
            <div class="page-icon">
            <i class="fas fa-gift"></i>
            </div>
            <div class="page-title align-self-center ml-3">
                <h5>Goals & Points Earned</h5>
            </div>
        </div>
    </div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->

<div class="row same-height-card">
    
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="card dataTables_wrapper">
            <div class="card-header">
                <div class="row">
                    
                    <!--
                    <div class="col-md-3">
                        <select class="form-control md-w-25">
                            <option value=" ">Select</option>
                            <option value="Acheived"></option>
                            <option value="Not Acheived"></option>
                        </select>
                    </div>-->
                </div>
            </div>
            <div class="card-body small-font">
                <table datatable="ng" class="table table-striped table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Goal Title</th>
                            <th>Created By</th>
                            <th>Points Earned</th>
                            <th>Completion Date</th>
                            <th>Status</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="goal in goalData">
                            <td>{{$index+1}}</td>
                            <td>{{goal.title}}</td>
                            <td>{{goal.uname}} ({{goal.user_type}})</td>
                            <td>{{goal.points}}</td>
                            <td>{{goal.completion_date|myDate}}</td>
                            <td><span ng-class="{'text-green':goal.status=='Active' || goal.status=='Achived','text-red':goal.status=='Inactive' || goal.status=='Not Achived'}">{{goal.status}}</span></td>
                            <td class="action text-right">
                                <a href="#!goal-details/{{goal.goalID}}" data-toggle="tooltip" data-original-title="View Details" data-placement="top"><i class="icon-eye"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->