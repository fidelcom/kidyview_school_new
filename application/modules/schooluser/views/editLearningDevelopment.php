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
                        <h5>Update</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">

                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->
    <!-- BEGIN .main-content -->
    <div class="main-content">
        <div class="card">
            <div class="card-body">
                <form action="driver-device-listing.html">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Class</label>
                                <div class="controls">
                                    <select ng-model="data.class_id" class="form-control">
                                        <option ng-repeat="m in classList" ng-value="m.id">{{m.class}} {{m.section}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>                                              
                        <div class="col-md-6 col-sm-6 col-xs-12">                           
                            <div class="form-group">
                                <label class="form-label">Name</label>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Name" ng-model="data.name" />                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Question</label>
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Question" ng-model="data.detail.question" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Option <button ng-click="addNewOption()" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></label>
                                <div class="input-group mb-3" ng-repeat="x in options">
                                    <input type="text" class="form-control" ng-model="options[$index].text" />
                                    <div class="input-group-append">
                                        <button ng-click="removeOption($index)" type="button" class="btn btn-danger input-group-text"><i class="fa">×</i></button>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="looprow" style="display: block;">
                            <label class="form-label">Info</label><button ng-click="addInfo()" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                            <!-- Start repeat row -->
                            <div class="loop-row" ng-repeat="x in data.info">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <div class="controls">
                                                <input ng-model="data.info[$index].title" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <div class="controls">
                                                <input ng-model="data.info[$index].detail" type="text" class="form-control">
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <!-- end repeat row -->
                        </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" ng-click="saveData()" name="submit" value="Submit">
                                <input class="btn btn-info" type="reset" value="Reset">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <!-- Row end -->
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->