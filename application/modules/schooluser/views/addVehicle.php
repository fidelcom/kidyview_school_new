<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">

                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <div class="page-title">
                        <h5>Vehicle  Management (Add Vehicle)</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">
                        <div class="right-actions"><a href="#!/vehicle-list" class="btn btn-primary">  Vehicle List </a>  </div>
                    </div>
                    <div class="right-actions">
                        <div class="right-actions"><a href="#!/driver-list" class="btn btn-primary"> <i class="icon-plus2"></i> Driver List</a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- END: .main-heading -->
    <!-- BEGIN .main-content -->
    <div class="main-content ">
        <div class="card children-details">
            <div class="card-body children-data">
                <form action="">
                    <div class="row">
                         <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Vehicle name*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="vehicle_name" ng-model="vehicle_name">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Vehicle number*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="vehicle_number" ng-model="vehicle_number">
                                </div>
                            </div>
                        </div>
                        
                       
                        
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Plate number*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="plate_number" ng-model="plate_number">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Add Route Number*</label>
                                <div class="controls">
                                      <select ng-model="routes" class="form-control" id="routes" >
                                        <option value="" selected="selected" >Please Select Route</option>
                                        <option ng-repeat="route in routeList" value="{{route.id}}">{{route.name}}</option>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Vehicle type </label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="vehicle_type" ng-model="vehicle_type">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Vehicle brand</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="vehicle_brand" ng-model="vehicle_brand">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Model</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="model" ng-model="model">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Colour</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="colour" ng-model="colour">
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Upload Image</label>
                                <div class="col-md-12">
                                    <div class="upload-preview-box upload-img-view" ng-show="isImage(fileExt)">
                                        <img  ngf-src="vehiclephoto[0]" class="thumb">
                                    </div>
                                </div>
                                <div class="btn-uploadprof mt-0">
                                    <span>
                                        <i class="icon-camera-outline"></i>
                                        <input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ng-model="vehiclephoto" accept="image/png, image/jpeg" type="file" />
                                        <span>Upload Photo</span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" value="Add Vehicle" ng-click="addVehicle()">
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