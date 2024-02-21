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
            <h5>Notes</h5>
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
										<th>S.No.</th>
                                                                                <th>Term</th>
                                                                                <th>Topic</th>
                                                                                <th>Subject</th>
										<th>Activity Type</th>
                                                                            	<th>Created Date</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="lessonnote in lessonnotelist">
										<td>{{$index + 1}}</td>
                                                                                <td>{{lessonnote.termname}}</td>
										<td>{{lessonnote.topic}}</td>
										<td>{{lessonnote.subjectname}}</td>
                                                                                <td>{{lessonnote.activity_type}}</td>
							                        <td>{{lessonnote.created_date}}</td>
                                                                                <td class="text-right action">
                                                                                <span>
                                                                                <a  href="#!/view-note/{{lessonnote.lessonID}}"><i class="icon-eye" title="View Note"></i></a>
                                                                                <!--<a  href="#!/comment-list/{{lessonnote.lessonID}}"><i class="icon-list" title="View Comment"></i></a>
                                                                                -->
                                                                                </span>     
                                                                               
                                                                                   
                                                                                    
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