<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-calendar"></i>
							</div>
							<div class="page-title mt-2">
								<h5>Scheduler</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-schedule" class="btn btn-primary"> <i class="icon-plus2"></i> Add</a>
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
						<table id="inbox-table" datatable="ng" class="table table-striped table-bordered table-responsive">
							<thead>
								<tr>
									<th>S.No.</th>
									<th>School Type</th>
									<th>Lectures Count</th>
									<th class="text-right">Action</th>
								</tr>
							</thead>
							<tbody>

					    			 <tr ng-repeat="s in scheduleList">
                                        <td>{{$index + 1}}</td>
                                        <td>{{s.name}}</td>
                                        <td>{{s.no_periods}}</td>
                                        <td class="action text-right">
											<a href="#!/view-schedule-details/{{s.scheduleID}}"><i class="icon-eye" title="View"></i></a>
											<a href="#!/edit-schedule/{{s.scheduleID}}"><i class="icon-pencil2" title="Edit"></i></a>
											<a ng-click="scheduleDelete(s.id)"><i class="icon-trash2" title="Delete"></i></a>
										</td>
                                    </tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Row end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		