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
                        <h5>Driver Students</h5>
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
				 <table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
				
					<thead>
						<tr>
							<th>S.No.</th>
							<!--<th>Driver Name & Code</th>-->
							<th>Student Name</th>
                                                        <th>Class & Section</th>
                                                  	<th>Action</th>
						</tr>
					</thead>
					<tbody>  <tr ng-repeat="assignList in assignLists">
						
							<td>{{$index + 1}}</td>
							<!--<td>{{assignList.driver}}</td>-->
							<td>{{assignList.student}}</td>
                                                        <td>{{assignList.classsection}}</td>
                                                       
							<td>
							<a target="_blank" href="#!/journeyLogStudents/{{assignList.student_id+'-'+assignList.driverID}}">View Journey Log</a>  
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


<!-- END: .app-main -->

