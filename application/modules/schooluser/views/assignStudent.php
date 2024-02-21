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
                        <h5>Vehicle Management (Assign Students To Driver)</h5>
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
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Driver Name</label>
                                <div class="controls">
                                    <select ng-model="driver" class="form-control" id="driver"  ng-change="getDriverAssignList()">
                                        <option value="" selected="selected" >Please Select Driver</option>
                                        <option ng-repeat="drivers in driverList" value="{{drivers.id}}">{{drivers.driverfname}} {{drivers.driverlname}} ({{drivers.drivercode}})</option>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 routeSection">
                            <div class="form-group">
                                <label class="form-label">Vehicle & Vehicle Route</label>
                                <div class="controls">
                                    <p class="routeName"></p>
                                    <span class="d-inline"  ng-repeat="routeList in routeListData">
                                       {{routeList}} 
                                    </span>
                                    
                                </div>
                            </div>
                        </div>
                        
                        
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Select Class & Section</label>
                                <div class="controls">
                                   <select ng-model="classSection" class="form-control" id="routes"  ng-change="getAllStudents()">
                                        <option value="" selected="selected" >Please Select Class & Section</option>
                                        <option ng-repeat="list in classSectionList" value="{{list.id}}">{{list.class}} {{list.section}}</option>
                                    </select> 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12" style="z-index:9999;">
                            <label class="form-label">Select Student</label>
                            <span class="all-check"><input type="checkbox" class="checkall" /> check All </span>
                            <div class="controls">


                                <div id="list1" class="dropdown-check-list" tabindex="100">
                                    <span class="anchor">Select Student</span>
                                    <ul class="items" >
                                        <li ng-repeat="item in childLists">
                                            <input type="checkbox" class="childcheck" ng-model="students" name="student[]" value="{{item.id}}"  />{{item.childfname}} {{item.childmname}}  {{item.childlname}} ({{item.childRegisterId}})
                                        </li>

                                    </ul>
                                </div>


                            </div>
                        </div>

                       <div class="col-md-12 col-sm-12 col-xs-12 mt-3" > 
                           <p class="assign">{{resultReturn}} </p>
                           <p class="assign" ng-repeat="assign in preassign"> 
                             ({{$index+1}}).{{assign.assigned}} 
                           <p>
                       </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" value="Add Student"  ng-click="assignStudents()">
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
							<th>Driver Name & Code</th>
							<th>Student Name</th>
                                                        <th>Class & Section</th>
                                                    	<th>Created Date</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="assignList in assignLists">
						
							<td>{{$index + 1}}</td>
							<td>{{assignList.driver}}</td>
							<td>{{assignList.student}}</td>
                                                        <td>{{assignList.classsection}}</td>
                                                        <td>{{assignList.created}}</td>
                                                       
							<td>
							<a href="javascript:void(0);" ng-click="UnlinkStudent(assignList.id,assignList.driverID)">UnLink Student</a>  
							</td>
						</tr>
					</tbody>
				</table>
				
			</div>
                  </div>
            
            
        </div>
    </div>
    <!-- END: .main-content -->
</div>

<style>
    .dropdown-check-list {
        display: inline-grid;
        width: 100%;
        position:relative
    }

    .dropdown-check-list .anchor {
        position: relative;
        cursor: pointer;
        display: inline-block;
        padding: 5px 50px 5px 10px;
        border: 1px solid #ccc;
        z-index: 1000;

    }

    .dropdown-check-list .anchor:after {
        position: absolute;
        content: "";
        border-left: 2px solid black;
        border-top: 2px solid black;
        padding: 5px;
        right: 10px;
        top: 20%;
        -moz-transform: rotate(-135deg);
        -ms-transform: rotate(-135deg);
        -o-transform: rotate(-135deg);
        -webkit-transform: rotate(-135deg);
        transform: rotate(-135deg);
    }

    .dropdown-check-list .anchor:active:after {
        right: 8px;
        top: 21%;

    }

    .dropdown-check-list ul.items {
        padding: 2px;
        display: none;
        margin: 0;
        border: 1px solid #ccc;
        border-top: none;
        z-index: 1000;
    }

    .dropdown-check-list ul.items li {
        list-style: none;
        z-index: 999999;
    }

    .dropdown-check-list.visible .anchor {
        color: #0094ff;
    }

    .dropdown-check-list.visible .items {
        display: block;
        z-index: 1000;
        position: absolute;
        width: 100%;
        top: 36px;
        width: 100%;
        right: 0;
        left: 0;
        background: #fff;
    }

    .dropdown-check-list ul {
        min-height:0px;
        max-height:250px;
        overflow-y: scroll;
    }

    .all-check {
        float: right;
        color: #006e7c !important;
    }
    .assign {color:#ff0000;font-size: 12px !important}
    .d-inline {
    padding: 4px 7px 4px 7px;
    margin: 4px 4px 4px 4px;
    background-color: #777;
    display: inline-block !important;
    font-size: 14px;
    color:#fff
    }
    .routeName {font-weight:bold }
    .childcheck {margin-right: 5px;}
    
</style>
<!-- END: .app-main -->

<script type="text/javascript">
    var checkList = document.getElementById('list1');
    $('.items').click(function (evt) {
        event.stopPropagation(evt);

    });

    $('.all-check').click(function (evt) {
        event.stopPropagation(evt);

    });


    $('.anchor').click(function (evt) {

        event.stopPropagation(evt);

        if (checkList.classList.contains('visible')) {
            checkList.classList.remove('visible');
            checklength = 0;
        } else {
            checkList.classList.add('visible');
            checklength = 1;
        }
    });

    $('body').click(function (evt) {
        checkList.classList.remove('visible');
    });
</script>