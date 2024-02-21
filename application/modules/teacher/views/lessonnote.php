
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
						<h5>Lesson & Note</h5>
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
							<div class="form-group ">
					                <label class="form-label">Select Term<em>*</em></label>
                                                        <select class="form-control" ng-model="term" ng-change="getdaterange(term)">
                                                                <option value="" selected="selected" >Select Term</option>
                                                                <option ng-repeat="term in newtermList" value="{{term.id}}">{{term.termname}} </option>
                                                        </select>
							</div>
							
						</div>
                                                  
                                                  <div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Activity Type<em>*</em></label>
                                                        <select class="form-control" selected="selected"  ng-model="activitytype">
                                                               <option value="" selected="selected" >Activity Type</option>
                                                                <option value="class work">class work</option>
                                                                <option value="home work">home work</option>
                                                        </select>
							</div>
							
						</div>   
                                                    
                                                </div>     
                                                
                                            
                                               <div class="row">   
                                                    <div class="col-md-6 col-sm-6 col-xs-6">

                                                            <div class="form-group ">
                                                            <label class="form-label">From Date<em>*</em></label>
                                                            <input type="date" onkeydown="return false" ng-model="fromdate" class="form-control" id="fromdate">
                                                            </div>
                                                   </div>     

                                                    <div class="col-md-6 col-sm-6 col-xs-6">    
                                                            <div class="form-group">
                                                            <label class="form-label">To Date<em>*</em></label>
                                                            <input type="date" onkeydown="return false" ng-model="todate" class="form-control" id="todate">
                                                            </div>

                                                    </div>
                                               </div>
                                    
                                    
                                               <div class="row">
                                                      
                                                <div class="col-md-12 col-sm-12">
                                                    
                                                   
							<div class="form-group ">
					                <label class="form-label">Topic<em>*</em></label>
                                                        <input type="text" class="form-control" ng-model="topic"   placeholder="Enter Topic">
							</div>
							
                                                   
                                                    
							
							
						</div>    
                                                
                                                
                                                    
                                                </div> 
                                    
                                    
                                              <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">     
                                                <div class="form-group ">
					                <label class="form-label">Share With Teacher</label>
                                                        
                                                       <!-- <span class="sharespan"><input type="checkbox" id="class_share" ng-model="class_share" value="1"> Class</span>-->
                                                       <span class="sharespan"><input type="radio"  name="teacher_share" ng-model="teacher_share" value="1">View Only</span>
                                                        <span class="sharespan"><input type="radio" name="teacher_share" ng-model="teacher_share"  value="2">Edit & View</span>
                                                        <span class="sharespan"><input type="radio" name="teacher_share" ng-model="teacher_share" ng-checked="true" value="0">Self(Private)</span>
                                                        
							</div> 
                                                    </div> 
                                               </div> 
                                    
                                    
                                              <div class="row">
                                              
                                                  
                                                  <div class="col-md-6 col-sm-6 col-xs-12 teacherrow" style="display:none;">
                                                      
                                                      <div class="labelbox">
                                                         <span class="form-label">Teacher<span>*</em></span> 
                                                          <span class="form-label actionall teacherall">Select All</span> 
                                                       </div>    
                                                        <div class="databox">
                                                            <span ng-repeat="teacher in allteacher" >
                                                                <input type="checkbox" value="{{teacher.id}}" class="listteacher" name="listteacher" ng-model="teacherlist">  {{teacher.teacher}}
                                                            </span>
                                                        </div> 
                                               	
						   </div>
                                                
                                                   <!--div class="col-md-6 col-sm-6 col-xs-12">
                                                       <div class="labelbox">
                                                         <span class="form-label">Class<span>*</em></span> 
                                                          <span class="form-label actionall classall">Select All</span> 
                                                       </div>    
                                                        <div class="databox">
                                                            <span ng-repeat="classes in allclass" >
                                                                <input type="checkbox" value="{{classes.id}}" class="listclass" name="listclass"  ng-model="lessonclass"> {{classes.classname}}
                                                            </span>
                                                            <select class="form-control select-new" ng-model="lessonsubject">
                                                                <option value="" selected="selected" >Select Subject</option>
                                                                <option ng-repeat="subject in allsubject" value="{{subject.id}}">{{subject.subject}} - {{subject.subject_code}}</option>
                                                        </select>
                                                        </div>    
                                                  </div>
                                                  -->
                                              </div>  
                                              <div class="row">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group ">
                                                <label class="form-label">Class</label>
                                                <select class="form-control" name="listclass" ng-model="lessonclass" ng-change="getsubject(lessonclass)">
                                                        <option value="" selected="selected" >Select Class</option>
                                                        <option ng-repeat="classes in allclass" value="{{classes.id}}">{{classes.classname}}</option>
                                                </select>
                                                </div>
                                                </div>
                                                </div>   
                                              <div class="row">
                                              <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Subject</label>
                                                        <select class="form-control select-new" ng-model="lessonsubject">
                                                                <option value="" selected="selected" >Select Subject</option>
                                                                <option ng-repeat="subject in allsubject" value="{{subject.id}}">{{subject.subject}} - {{subject.subject_code}}</option>
                                                        </select>
							</div>
							
						</div>
                                               </div>
                                               <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Student Notes</label>
                                                        <textarea class="form-control" ng-model="student_notes"></textarea>
							</div>
							
						</div>
                                                </div>
                                               <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Objective</label>
                                                        <textarea class="form-control" ng-model="objectives"></textarea>
							</div>
							
						</div>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Material</label>
                                                        <textarea class="form-control" ng-model="material"></textarea>
							</div>
							
						</div>
                                                </div>
                                    
                                                <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group ">
					                <label class="form-label">Concept Introduction</label>
                                                        <textarea class="form-control" ng-model="introduction"></textarea>
							</div>
							
						</div>
                                                </div>
                                    
                                                <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
							<!--<div class="form-group ">
					                <label class="form-label">Attachment</label>
                                                        <input class="form-control" id="document"  ng-model="document" type="file">
							</div>-->
                                                        <div class="row form-group">
                                                        <div class="col-md-3 pr-0">
                                                                <label>Attachment</label>
                                                        </div>
                                                        <div class="col-md-6 pl-0">
                                                                <div class="btn-uploadprof uploadlogo d-inline-block">
                                                                <span class="pl-3 pr-3">
                                                                <i class="fas fa-upload text-white"></i>
                                                                <input class="files file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" multiple accept="image/png, image/jpeg, application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,audio/*,video/*" type="file" onchange="angular.element(this).scope().SelectFile(event)">
                                                                <span>Upload</span>
                                                                </span>
                                                                </div>
                                                                <div class="col-md-12 prev-section mt-2" ng-repeat="prev in PreviewImage">
                                                                <div class="row">
                                                                <div class="col-md-12 fpUploadImg">
                                                                <i class="icon-trash2" ng-click="remove($index);"></i>
                                                                <div class="upload-preview-box">{{prev.name}}</div>
                                                                </div>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-12 prev-section mt-2" ng-repeat="prev in editAttachmentData">
                                                                <div class="row">
                                                                <div class="col-md-12 fpUploadImg">
                                                                <i class="icon-trash2" ng-click="removeEdit(prev,$index);"></i>
                                                                <div class="upload-preview-box">{{prev.file}}</div>
                                                                </div>
                                                                </div>
                                                                </div>	
                                                        </div>
					</div>
							
						</div>
                                                </div>
                                    
                                                <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
<!--                                                    <button class="btn btn-primary"  ng-click="addNote()">Add Note</button>-->
                                                    <button ng-disabled="is_disabled" class="btn btn-primary" ng-click="addNote()" >Add Note</button>
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

<style>
.sharespan{
margin-left: 20px;    
}
.actionall{
float: right;
font-size: 15px;
cursor: pointer;
}

.databox {
margin: 5px 0px 15px 0px;
padding:  2px 0px 2px 0px;
border: 1px #ccc solid; 
max-height: 120px; 
overflow: auto;
}
.databox span{
display: block;
padding: 1px 10px 2px 10px;    
}
</style>