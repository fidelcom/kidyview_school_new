<!-- BEGIN .app-main -->
<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="icon-clock"></i>
                    </div>
                    <div class="page-title">
                        <h5>Edit Subject</h5>
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
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Subject<em>*</em></label>
                                <div class="controls">
                                    <input type="text" ng-model="subject" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Type<em>*</em></label>
                                <div class="controls">
                                    <select class="form-control" name="type" id="type" ng-model="type">
                                    <option value="">Select Type</option>
                                    <option value="Non Activity">Non Activity</option>
                                    <option value="Activity">Activity</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Class<em>*</em></label>
                                <div class="controls">
                                    <ui-select ng-model="ob.class" theme="select2" title="Select " style="width:300px;">
                                        <ui-select-match placeholder="Select Class">{{$select.selected.class}} {{$select.selected.section}}</ui-select-match>
                                        <ui-select-choices repeat="lc.id as lc in classList | propsFilter: {class: $select.search}">
                                            <div>{{lc.class}} {{lc.section}}</div>                                          
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Teacher<em>*</em></label>
                                <div class="controls">
                                    <ui-select ng-model="ob.teacher" theme="select2" title="Select " style="width:300px;">
                                        <ui-select-match placeholder="Select Subject Teacher">{{$select.selected.teacherfname}} {{$select.selected.teachermname}} {{$select.selected.teacherlname}}</ui-select-match>
                                        <ui-select-choices repeat="tc.id as tc in TeacherList | propsFilter: {teacherfname: $select.search}">
                                            <div>{{tc.teacherfname}} {{$select.selected.teachermname}} {{tc.teacherlname}}</div>                                          
                                        </ui-select-choices>
                                    </ui-select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description<em>*</em></label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="pic[0]" class="thumb">
									<img ng-show="photo != ''" src="<?= base_url();?>img/subject/{{photo}}" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ngf-select ng-model="pic" accept="image/png, image/jpeg" type="file" />
										<span>Change Photo</span>
									</span>
								</div>
							</div>
						</div>
                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3">
                            <div class="form-group">
                                <button class="btn btn-primary" ng-click="editSubject()">Update</button>
                                <a class="btn btn-secondary" href="#!/subject-list">Back To List</a>
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