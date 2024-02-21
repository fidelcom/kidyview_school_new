BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-dashboard"></i>
							</div>
							<div class="page-title mt-2">
								<h5>View Class Schedule</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<!-- <a href="add-school.html" class="btn btn-primary">Add School</a>
								<a href="#" class="btn btn-primary">Add School</a> -->
							</div>
						</div>
					</div>
				</div>
			</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body full-detail">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<select ng-model="school_type" class="form-control">
                                        <option value="" selected="selected" disabled="disabled">School Type </option>
                                        <option ng-repeat="type in schoolTypeList" ng-value="type.value">{{type.name}}</option>
                                    </select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
		                                <!-- <div class="controls"> -->
		                                    <ui-select ng-model="ob.class" theme="select2" title="Select " style="width:300px;">
		                                        <ui-select-match placeholder="Select Class">{{$select.selected.class}} {{$select.selected.section}}</ui-select-match>
		                                        <ui-select-choices repeat="lc.id as lc in classList | propsFilter: {class: $select.search}">
		                                          <div>{{lc.class}} {{lc.section}}</div>                                          
		                                        </ui-select-choices>
		                                    </ui-select>
		                                <!-- </div> -->
								</div>
							</div>
							<div class="col-md-4 text-right">
								<div class="form-group">
									<button type="button" class="btn btn-primary br-0">Search</button>
								</div>
							</div>
						</div>
						<div class="table-responsive time_table">
							<table width="100%" border="0" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<th class="day">Day</th>
										<th class="text-center">I</th>
										<th class="text-center">II</th>
										<th class="text-center">III</th>
										<th class="text-center">IV</th>
										<th class="text-center">V</th>
									</tr>
									<tr ng-repeat="day in days">
										<td class="day">{{day.val}}</td>
										<td><span>Subject Name</span> Teacher Name <a href="edit-time-table.html" class="edit_col"><i class="icon-edit2"></i></a></td>
										<td><span>Subject Name</span> Teacher Name <a href="edit-time-table.html" class="edit_col"><i class="icon-edit2"></i></a></td>
										<td>- <a href="edit-time-table.html" class="edit_col"><i class="icon-edit2"></i></a></td>
										<td>- <a href="edit-time-table.html" class="edit_col"><i class="icon-edit2"></i></a></td>
										<td>- <a href="edit-time-table.html" class="edit_col"><i class="icon-edit2"></i></a></td>
									</tr>
								
							</tbody></table>
						</div>
					</div>					
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main