<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-tree"></i>
                    </div>
                    <div class="page-title">
                        <h5>Edit Currency</h5>
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
                            <div class="form-group">
                                <label class="form-label">Currency Name*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_name" ng-model="currency_name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Currency Code*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_code" ng-model="currency_code">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Symbol *</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_symbol" ng-model="currency_symbol">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Rate (1$)*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_rate" ng-model="currency_rate">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" ng-click="updateCurrency()" value="Update">
                                
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