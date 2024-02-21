<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-clock"></i>
                    </div>
                    <div class="page-title">
                        <h5>Subjects</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">
                         <a ng-if="class_ID!=''" href="#!/class-list" class="btn btn-primary"> <i class="icon-plus2"></i> Back</a>
                        <a ng-if="class_ID==''"href="#!/add-subject" class="btn btn-primary"> <i class="icon-plus2"></i> Add Subject</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->
    <!-- BEGIN .main-content -->
    <div class="main-content subadmin-list-update">
        <div class="card">
            <div class="card-body">
			<div class="table-responsive white-space-nowrap">
                <table datatable="ng" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th>Subject</th>
                            <th>Type</th>
                            <th>Class</th>
                            <th>Teacher</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="subjects in subjectList">
                            <td>{{$index + 1}}</td>
                            <td>{{subjects.subject}}</td>
                            <td>{{subjects.type}}</td>
                            <td>{{subjects.class_name}} {{subjects.section}}</td>
                            <td>{{subjects.teacherfname}} {{subjects.teachermname}} {{subjects.teacherlname}}</td>
                            <td class="action text-right">
                                <a href="#!/edit-subject/{{subjects.subjectID}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a>
                                <a ng-if="subjects.status == '1'"><i class="fas fa-toggle-on" ng-click="subjectsDisabled(subjects.id, 0);"></i></a>
                                <a ng-if="subjects.status == '0'"><i class="fas fa-toggle-off" ng-click="subjectsDisabled(subjects.id, 1);"></i></a>
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
<!-- END: .app-main -->