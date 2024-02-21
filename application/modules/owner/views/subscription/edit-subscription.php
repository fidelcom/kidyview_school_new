<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
    <div class="container-fluid">
        <div class="row">
            
            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                <div class="page-icon">
                    <i class="icon-subscriptions"></i>
                </div>
                <div class="page-title">
                    <h5>Edit Subscription</h5>
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
            <div  style="color:red" class="error" ng-show="errormsg!=''">{{errormsg}}</div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Title <em>*</em></label>
                            <div class="controls">
                                <input type="text" class="form-control" ng-model="name">
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Subscription Type <em>*</em></label>
                            <div class="controls select_mutli">
                                <select class="form-control" ng-model="type" ng-change="amount=0">
                                <option value="{{type.val}}" ng-repeat="type in subscriptionTypeArray">{{type.label}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Validity <em>*</em></label>
                            <div class="controls">
                                <select class="form-control" ng-model="validity">
                                    <option value="">Select Validity</option>
                                    <option value="{{validity.val}}" ng-repeat="validity in validityArray">{{validity.label}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Amount (NGN)<em>*</em></label>
                            <div class="controls">
                                <input type="text" class="form-control" allow-decimal-numbers ng-model="amount">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Maximum number of children<em>*</em></label>
                            <div class="controls">
                                <input type="text" class="form-control" numericonly ng-model="no_of_student">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="permission-container">
                            <ul>
                                <li class="hdng">
                                    <div class="form-check">
                                        <label class="form-check-label">Select All Modules
                                        <input class="form-check-input" ng-model="checkAll" type="checkbox" ng-click="checkAllData(featureList,checkAll)" ng-true-value="'1'" ng-false-value="'0'"/>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                                <li ng-repeat="feature in featureList">
                                    <div class="form-check">
                                        <label class="form-check-label">{{feature.module_name}}
                                            <input class="form-check-input" type="checkbox" ng-model="feature.is_enable" ng-true-value="'1'">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" rows="5" ng-model="description"></textarea>
                        </div>
                    </div>
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <input class="btn btn-primary" ng-click="editSubscription();" name="submit" value="Update">
                            <a class="btn btn-secondary" href="#!/subscription-list">Back To List</a>
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