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
                        <h5>Students Pick Up and Drop off Log</h5>
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
				
                                <div class="table-responsive white-space-nowrap">
                                    <table  class="table" id="mytab">
				
					<thead>
						<tr>
							
							<th>Date</th>
                                                        <th colspan="2"><center>Pick up time</center></th>
                                                  	<th colspan="2"><center>Drop off time</center></th>
						</tr>
                                                <tr>
							<td></td>
							<td><center>Start</center></td>
                                                        <td><center>End</center></td>
                                                        <td><center>Start</center></td>
                                                        <td><center>End</center></td>
                                                       
							
                                                  
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="logDataStudent in logData">
						
							<td>{{logDataStudent.created_date}}</td>
							<td><center>{{logDataStudent.pickup_starttime}}</center></td>
                                                        <td><center>{{logDataStudent.pickup_endtime}}</center></td>
                                                       <td><center>{{logDataStudent.dropoff_starttime}}</center></td>
                                                       <td><center>{{logDataStudent.dropoff_endtime}}</center></td>
						</tr>
					</tbody>
				</table>
				
			</div>
                  </div>
            
            
        </div>
    </div>
    <!-- END: .main-content -->
</div>


<!-- END: .app-main -->

