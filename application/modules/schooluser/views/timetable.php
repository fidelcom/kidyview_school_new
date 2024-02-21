<!--BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
							<div class="page-icon">
								<i class="icon-dashboard mt-2"></i>
							</div>
							<div class="page-title ml-3 align-self-center">
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
									<select ng-model="school_type" class="form-control" ng-change="schoolType()" ng-options="option.value as option.name for option in schoolTypeList">
                                        <option selected="selected" value="">Select School Type</option>
                                        <!-- <option ng-repeat="type in schoolTypeList" ng-value="type.value">{{type.name}}</option> -->
                                    </select>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
		                                <!-- <div class="controls"> -->
		                                    <ui-select ng-model="ob.class" theme="select2" title="Select" ng-change="checkSchedule()" style="width:300px;">
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
									<!-- <button type="button" class="btn btn-primary br-0">Search</button> -->
								</div>
							</div>
						</div>
						<div class="table-responsive time_table white-space-nowrap">
							<table class="table table-striped table-bordered table-responsive custom-scrollbar" width="100%" border="0" cellpadding="1" cellspacing="1">
								<tbody>
									<tr>
										<th class="day">Day</th>
										<th class="text-center" ng-repeat="pd in day_timeTable[0].lectureList track by $index">LT-{{$index+1}} <br/> [{{pd.name }} {{pd.start_time}} TO {{pd.end_time}} ]</th>
									</tr>
									
									<tr ng-repeat="tt in day_timeTable">
										<td class="day">{{tt.val}}</td>
										<td class="td-35" ng-repeat="pd in tt.lectureList" ng-modal="pd.period_id"><span>{{pd.subject ? pd.subject : 'Subject Name'}}</span> {{pd.teacher_name ? pd.teacher_name : 'Teacher Name'}} <button class="edit_col" ng-click='assignTeacher(pd)'><i class="icon-edit2"></i></button></td>

									</tr>
							</tbody></table>
						</div>
					</div>					
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
		<!-- Modal -->
	  <div class="modal fade custom_modal" id="myModal" role="dialog">
		<div class="modal-dialog">
		  <!-- Modal content-->
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal">&times;</button>
			  <h4 class="modal-title">Edit Time Table</h4>
			</div>
			<div class="modal-body">
				<form>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Select Teacher</label>
						</div>
						<div class="col-md-8">
							 <div class="controls">
							<ui-select ng-model="periodEdit.teacher_id" theme="select2" title="Select " style="width:300px;">
								<ui-select-match placeholder="Select Subject Teacher">{{$select.selected.teacherfname}} {{$select.selected.teacherlname}}</ui-select-match>
								<ui-select-choices repeat="tc.id as tc in TeacherList | propsFilter: {teacherfname: $select.search}">
									<div>{{tc.teacherfname}} {{tc.teacherlname}}</div>
								</ui-select-choices>
							</ui-select>
						</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Select Subject</label>
						</div>
						<div class="col-md-8">
							<ui-select ng-model="periodEdit.subject_id" theme="select2" title="Select" style="width:300px;">
								<ui-select-match placeholder="Select Subject">{{$select.selected.subject}}</ui-select-match>
								<ui-select-choices repeat="sb.subject_id as sb in SubjectList | propsFilter: {subject: $select.search}">
									<div>{{sb.subject}} </div>
								</ui-select-choices>
							</ui-select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Zoom Link</label>
						</div>
						<div class="col-md-8">
							<input type="text" ng-model="periodEdit.zoom_link" class="form-control" placeholder="Enter Link (Optional)">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label>Other Information</label>
						</div>
						<div class="col-md-8">
							<input type="text" ng-model="periodEdit.other_info" class="form-control" placeholder="Enter information (Optional)">
						</div>
					</div>
					<div class="row form-group mt-3">
						<div class="col-md-4">
						</div>
						<div class="col-md-8">
							<button ng-click="updateTimeTable()" class="btn btn-primary">Submit</button>
							<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-danger">Cancel</a>
						</div>
					</div>
				</form>
			</div>
		  </div>
		</div>
	  </div>

</div>
<!-- END: .app-main