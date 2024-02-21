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
                <h5>Subscription Details</h5>
            </div>
        </div>
        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
            <div class="right-actions">
                <a href="#!/add-subscription" class="btn btn-primary"><i class="icon-plus2"></i> Add Subscription</a>
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
        <div class="row">
            <div class="col-md-9 col-sm-12 col-xs-12">
                <div class="card-body vendor-full-detail">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Title:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{name}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Subscription Type:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{type}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Validity:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{validity}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Amount:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{amount}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Maximum number of children:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{no_of_student}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Features:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">
                        <span class="show_permission" ng-repeat="feature in subscriptioninfo.featureData">
                            <span>{{feature.module_name}}</span>
                            <i ng-show="feature.is_enable=='1'" class="icon-tick bg-success"></i>
                            <i ng-show="feature.is_enable=='0'" class="icon-cross3 bg-danger"></i>
                        </span>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-12">Description:</div>
                        <div class="col-md-8 col-lg-8 col-sm-12 text-highligh">{{description}}</div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12 pl-0 pl-md-3">
            <div class="form-group">
            <a class="btn btn-secondary" href="#!/subscription-list">Back To List</a>
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