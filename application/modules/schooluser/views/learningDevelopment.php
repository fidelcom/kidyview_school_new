<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-code"></i>
                    </div>
                    <div class="page-title">
                        <h5>Learning &amp; Development</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">
                        <a href="#!/add-learning-and-development" class="btn btn-primary"> <i class="icon-plus2"></i> Add Learning &amp; Development</a>
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
                <table datatable="ng" class="table parents-listing-c table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S.No.</th>                                                
                            <th>Name</th>
                            <th>Class</th>
                            <th>Section</th>
                            <th class="text-right">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="m in dataList">
                            <td>{{$index + 1}}</td>
                            <td>{{m.name}}</td>
                            <td>{{m.class_name}}</td>
                            <td>{{m.section}}</td>
                            <td class="action text-right">
                                    <a href="#!/edit-learning-and-development/{{m.id}}"><i class="icon-edit2" title="Edit"></i></a>
                                    <a href="javascript:void(0);" ng-click="deleteList(m.id)" title="Delete"><i class="icon-trash"></i></a>
                                    
                            </td>
                        </tr>																
                    </tbody>
                </table>
				</div>
            </div>
        </div>
        <!-- Card end -->

        <!-- Card end -->
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->