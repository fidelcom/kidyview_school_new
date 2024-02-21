<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
        <div class="page-icon">
        <a href="#!/note-list"> <i class="icon-arrow-back"></i></a>
        </div>
        <div class="page-title">
            <h5>Comment list</h5>
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
                
                <div class="row set-tb-search">
                    <div class="col-md-12">
						<div class="table-responsive white-space-nowrap">
							<table datatable="ng" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="width: 10%;"><center>S.No.</center></th>
                                                                                <th style="width: 20%;"><center>Note Topic</center></th>
                                                                                <th style="width: 55%;"><center>Comment</center></th>
                                                                              	<th style="width: 15%;"><center>Comment Date</center></th>
										
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="comments in commentdata">
                                                                            <td style="width: 10%;">{{$index + 1}}</td>
                                                                                <td> {{comments.topic}}</td>
										<td>{{comments.comment}}</td>
										<td >{{comments.created_date}}</td>
                                                                          	</td>
									</tr>
								</tbody>
							</table>	
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