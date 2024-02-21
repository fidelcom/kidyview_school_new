<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-news"></i>
                    </div>
                    <div class="page-title">
                        <h5>Transfer Class</h5>
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
                <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h2 class="transferheading">From</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Session<em>*</em></label>
                                        <div class="controls">
                                            <select class="form-control" name="from_session" ng-model="tranferData.from_session" ng-change="getAllClassChild()">
                                                <option value="">Select Session</option>
                                                <option value="{{session.id}}" ng-repeat="session in sessionList">{{session.academicsession}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Class & Section<em>*</em></label>
                                        <div class="controls">
                                            <select class="form-control" ng-model="tranferData.from_class" ng-change="getAllClassChild()">
                                                <option value="">Select Class</option>
                                                <option value="{{class.id}}" ng-repeat="class in classList">{{class.class}}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group select_mutli add_subject">
                                        <label class="form-label">Children<em>*</em></label>
                                        <div class="controls">
                                        <div ng-dropdown-multiselect="" options="childData" selected-model="tranferData.child" checkboxes="true" extra-settings="setting1"></div>
                                    
                                        </div>
                                    </div>
                                </div>
                            </div>									
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <h2 class="transferheading">To</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Session<em ng-show="tranferData.is_outside==''">*</em></label>
                                        <div class="controls">
                                        <select class="form-control" name="to_session" ng-model="tranferData.to_session">
                                            <option value="">Select Session</option>
                                            <option value="{{session.id}}" ng-repeat="session in sessionNewList">{{session.academicsession}}</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Class & Section<em ng-show="tranferData.is_outside==''">*</em></label>
                                        <div class="controls">
                                        <select class="form-control" ng-model="tranferData.to_class">
                                            <option value="">Select Class</option>
                                            <option value="{{class.id}}" ng-repeat="class in classList">{{class.class}}</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-label">Outside from school<em></em></label>
                                        <div class="controls">
                                        <select class="form-control" ng-model="tranferData.is_outside" ng-change="isOutside(tranferData.is_outside)">
                                            <option value="">Select</option>
                                            <option value="1">Yes</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>									
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" ng-disabled="isTransferSubmit" ng-click="transferChild()" type="button" name="submit" value="Transfer">
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