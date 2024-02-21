<?php 
	$schoolDetail 	= $this->session->all_userdata();
	$schoolID 		= $schoolDetail['user_data']['id'];
	$schoolPhoto 	= $schoolDetail['user_data']['pic'];
	$schoolName 	= $schoolDetail['user_data']['school_name'];
	$schoolEmail 	= $schoolDetail['user_data']['email'];
?>
<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-calendar3"></i>
					</div>
					<div class="page-title">
						<h5>Add Events</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
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
				<form>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Event Title<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="eventtitle">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group multi-dorpdown-list">
								<label class="form-label">Select event visibility<em>*</em></label>
								<div class="controls">
                                                                    <ui-select multiple ng-model="objE.eventvisiblity" theme="select2" title="Select User" style="min-width:300px;">
                                                                        <ui-select-match placeholder="Select User">{{$item.name}}</ui-select-match>
                                                                        <ui-select-choices repeat="person.val as person in userTypeList | propsFilter: {name: $select.search}">
                                                                          <div>{{person.name}}</div>
                                                                        </ui-select-choices>
                                                                    </ui-select>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Date<em>*</em></label>
								<div class="controls">
									<input type="date" onkeydown="return false" class="form-control" ng-model="eventdate" min="<?=date('Y-m-d')?>">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Time<em>*</em></label>
								<div class="controls">
									<input type="time" class="form-control" ng-model="eventtime">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Event Type<em>*</em></label>
								<select class="form-control select-new" ng-model="eventtype">
									<option value="0">Free</option>
									<option value="1">Paid</option>
								</select>
							</div>
						</div>
						
						<div class="col-md-6 col-sm-6 col-xs-12" ng-if="eventtype == '1'">
							<div class="form-group">
								<label class="form-label">Amount<em>*</em></label>
								<div class="div-value two">
									<div class="controls">
										<input type="text" class="form-control" ng-model="$parent.eventamount" placeholder="Enter Event Amount">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Address<em>*</em></label>
								<div class="controls">
									<textarea class="form-control" ng-model="eventaddress"></textarea>
								</div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="controls">
									<textarea class="form-control" ng-model="eventdesc"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div ng-show="isImage(fileExt)" class="upload-preview-box">
									<img ngf-src="eventphoto[0]" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo upload-photo-event">	
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" accept="image/png, image/jpeg" ng-model="eventphoto" type="file">
										<span>Upload Photo</span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-1 mt-md-3">
							<div class="form-group">
								<button class="btn btn-primary" onclick="this.disabled=true" ng-click="addEvent()" name="submit">Submit</button>
								<a class="btn btn-secondary" href="#!/event-list">Back To List</a>
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