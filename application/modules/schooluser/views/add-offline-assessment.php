BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
				<header class="main-heading">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                                <div class="page-icon">
                                    <i class="icon-user-tie"></i>
                                </div>
                                <div class="page-title">
                                    <h5>Create Offline Assessment</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
                    <div class="">
                        <div class="add-teacher">
                            <form action="">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                               <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Category<em>*</em></label>
                                                    <div class="controls">
                                                        <select class="form-control" ng-model="exam_category">
                                                            <option value="" selected="selected">Select Category</option>
                                                            <option value="graded">Graded Assessment</option>
                                                            <option value="non-graded">Non-Graded Assessment</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Mode<em>*</em></label>
                                                    <div class="controls">
                                                        <select class="form-control" ng-model="exam_mode">
                                                            <option value="" selected="selected">Select Mode</option>
                                                            <option value="exam">Exam</option>
                                                            <option value="test">Test</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                             <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Session<em>*</em></label>
                                                    <div class="controls">
                                                        <select class="form-control" ng-model="session">
                                                            <option value="" selected="selected">Select Session</option>
                                                            <option value="{{sessionstart+'-'+sessionend}}" selected="selected">{{academicsession}}</option>
                                                           <!--  <option value="<?php echo date('Y').'-'.(date('Y')+1);?>">
                                                                <?php echo date('Y').'-'.(date('Y')+1);?>
                                                            </option>
                                                            <option value="<?php echo (date('Y')+1).'-'.(date('Y')+2);?>">
                                                                <?php echo (date('Y')+1).'-'.(date('Y')+2);?>
                                                            </option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Name<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="text" ng-model="name" class="form-control" required="required" placeholder="Enter exam name">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Class<em>*</em></label>
                                                    <div class="controls">
                                                      	 <ui-select ng-model="ob.class" theme="select2" title="Select" ng-change="getSubjects(ob.class)" style="width:300px;" >
					                                        <ui-select-match placeholder="Select Class">{{$select.selected.class}} {{$select.selected.section}}</ui-select-match>
					                                        <ui-select-choices repeat="lc.id as lc in classList | propsFilter: {class: $select.search}">
					                                          <div>{{lc.class}} {{lc.section}}</div>                                          
					                                        </ui-select-choices>
					                                    </ui-select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Select Subject<em>*</em></label>
                                                    <div class="controls">
                                                        <ui-select ng-model="ob.subject" theme="select2" title="Select" style="width:300px;">
															<ui-select-match placeholder="Select Subject">{{$select.selected.subject}}</ui-select-match>
															<ui-select-choices repeat="sb.subject_id as sb in SubjectList | propsFilter: {subject: $select.search}">
																<div>{{sb.subject}} </div>
															</ui-select-choices>
														</ui-select>
                                                    </div>
                                                </div>
                                            </div>
                                           <!--  <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Total Questions<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="text" ng-model="total_question" class="form-control digit-only" required="required" placeholder="Enter total questions ">
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Total Marks<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="text" ng-model="total_marks" class="form-control digit-only" required="required" placeholder="Enter total marks ">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Duration Time<em>*</em> (In Minutes)</label>
                                                    <div class="controls">
                                                        <input type="text" class="form-control digit-only" required="required" ng-model="exam_duration" placeholder="Duration filled based on minute.">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Date<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="date" class="form-control" required="required" ng-model="exam_date" min="<?=date('Y-m-d')?>" onkeydown="return false">
                                                    </div>
                                                </div>
                                            </div>
											<div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Time<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="time" class="form-control" required="required" ng-model="exam_time" onkeydown="return false">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Assessment Submission Date<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="date" class="form-control" required="required" ng-model="last_submission_date" min="<?=date('Y-m-d')?>" onkeydown="return false">
                                                    </div>
                                                </div>
                                            </div>
                                      
                                            <div class="col-md-6 col-sm-6 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Add Instruction<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="text" ng-model="exam_instruction" class="form-control" required="required" placeholder="Enter exam related instruction">
                                                    </div>
                                                </div>
                                            </div>
                                      

                                           <div class="col-md-12 col-sm-12 col-xs-12 mt-0">
												<button ng-click="addOfflineExam()" class="btn btn-primary">Submit</button>
												<a href="#!/offline-assessment" class="btn btn-danger">Cancel</a>
											</div>
                                            
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
<!-- END: .app-main