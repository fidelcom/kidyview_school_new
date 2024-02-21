<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-calendar3"></i>
                    </div>
                    <div class="page-title">
                        <h5>Update Meal</h5>
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
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Meal For</label>
                                <div class="controls">
                                    <select readonly="true" ng-model="mealPlan.school_type" class="form-control">
                                        <option ng-disabled="true" ng-repeat="m in schoolTypeList" ng-value="m.value">{{m.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>                                              
                        <div class="col-md-4 col-sm-4 col-xs-12">                           
                            <div class="form-group">
                                <label class="form-label">Date From</label>
                                <div class="controls">
                                    <input readonly="true" class="form-control" placeholder="From Date" ng-model="mealPlan.from_date" />
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Date To</label>
                                <div class="controls">
                                    <input readonly="true" class="form-control" placeholder="To Date" ng-model="mealPlan.to_date" />
                                    
                                </div>
                            </div>
                        </div>
<!--                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <label class="form-label">&nbsp;</label>
                            <button id="addmeal-btn" type="button" class="btn btn-primary btn-success" ng-click="createMealList()">Add Meal</button>
                        </div>-->
                        <div class="col-md-12">
                            <div id="looprow" style="display: block;">
                                <!-- Start repeat row -->
                                <div class="loop-row" ng-repeat="x in mealPlan.detailList">
                                    <div class="row head-block">
                                        <div class="col-sm-12">
                                            <h5 class="text-primary mt-3 mb-3">Date {{x.for_date}}</h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Breakfast</label>
                                                <div class="controls">
                                                    <input ng-model="mealPlan.detailList[$index].breakfast" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Snacks</label>
                                                <div class="controls">
                                                    <input ng-model="mealPlan.detailList[$index].snacks" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <div class="form-group">
                                                <label class="form-label">Meal</label>
                                                <div class="controls">
                                                    <input ng-model="mealPlan.detailList[$index].meal" type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end repeat row -->
                            </div>
                        </div>


                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" ng-click="saveMealPlan()" name="submit" value="Submit">
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