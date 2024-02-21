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
                        <h5>Vehicle Management (Add Route)</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
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
        <div class="card">
            <div class="card-body">
                <form action="">
                    <div class="row">
                        
                        <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="form-label"> Route Title* </label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="route_title" ng-model="route_title" >
                                </div>
                            </div>
                        </div>
                       
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Route Start*</label>
                                <div class="controls">
                                    <input type="text" class="form-control"  id="route_start" ng-model="route_start" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Route End*</label>
                                <div class="controls">
                                    <input type="text" class="form-control"  id="route_end" ng-model="route_end" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-10 route-data">
                                    <div class="form-group route-data-div">
                                        <label class="form-label">Add Route Stops :  </label>
                                        <div class="stoplist">
                                            
                                            <div class="controls input-group">
                                                <input type="text" class="form-control routrstopcell"  placeholder="Enter Stop"   id="route_stops_0" name="route_stops[]" ng-model="route_stops[0]" >
                                                <input type="text" readonly="true" class="form-control stopcell latitude" placeholder="Enter Latitude"  id="latitude_0" name="latitude[]" ng-model="latitude[0]" value="21">
                                                <input type="text" readonly="true" class="form-control stopcell longitude" placeholder="Enter Longitude " id="longitude_0" name="longitude[]" ng-model="longitude[0]" value="255">
                                               <!-- <span class="input-group-btn "><button class="btn btn-default removeStop" type="button">Remove</button></span>-->
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button type="button" class="btn btn-default btn-sm add-route"><i class="icon-plus2"></i> Add More Stop</button>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" value="Add Route" ng-click="addRoute()">
                            </div>
                        </div>

                    </div>
                    
                </form>
              
            </div>
        </div>
        
        <div class="card">
			<div class="card-body">
				<div class="table-responsive white-space-nowrap">
				 <table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
					<thead>
						<tr>
							<th>S.No.</th>
							<th>Route Title</th>
							<th>Route Code</th>
							<th>Route Start</th>
							<th>Route End</th>
							<th>Route Stops</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						 <tr ng-repeat="route in routeList">
							<td>{{$index + 1}}</td>
							<td>{{route.route_title}}</td>
							<td>{{route.route_code}}</td>
							<td>{{route.route_start}}</td>
							<td>{{route.route_end}}</td>
							<td>
                                                            <p ng-repeat="routes in route.stops">
                                                                {{routes}}
                                                            </p>
                                                           </td>
							<td class="action">
                                                      
                                                       <a href="javascript:void(0);" ng-click="deleteRoute(route.id)"><i class="icon-delete" title="Delete"></i></a>     
                                                        <a href="#!/edit-route/{{route.id}}"><i class="icon-edit2" title="Edit"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
				</div>
                            
                      <div class="col-md-12 col-sm-12 col-xs-12 mt-3" > 
                           <p class="assign">{{resultReturn}} </p>
                           <p class="assign" ng-repeat="use in preused"> 
                             {{$index+1}} - {{use.usedvehicle}} 
                           <p>
                       </div>
                            
                            
			</div>
		</div>
        
        
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<style>
.assign {color:#ff0000;font-size: 12px !important}
.routrstopcell {width: 60% !important; margin: 5px;}
.stopcell {width: 40% !important; margin: 5px;}
</style>
