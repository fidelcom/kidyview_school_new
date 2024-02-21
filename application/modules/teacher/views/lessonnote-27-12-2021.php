
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
                                                
                                                <div class="col-md-6 col-sm-6 col-xs-6">
							<div class="form-group ">
					                <label class="form-label">Subject<em>*</em></label>
                                                        <select class="form-control select-new" ng-model="lessonsubject">
                                                                <option value="" selected="selected" >Select Subject</option>
                                                                <option ng-repeat="subject in allsubject" value="{{subject.id}}">{{subject.subject}} - {{subject.subject_code}}</option>
                                                        </select>
							</div>
							
						</div>
                                                      
                                                <div class="col-md-6 col-sm-6">
                                                    
                                                   
							<div class="form-group ">
					                <label class="form-label">Topic<em>*</em></label>
                                                        <input type="text" class="form-control" ng-model="topic"   placeholder="Enter Topic">
							</div>
							
                                                   
                                                    
							
							
						</div>    
                                                
                                                
                                                    
                                                </div> 
                                    
                                    
                                              <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">     
                                                <div class="form-group ">
					                <label class="form-label">Share With</label>
                                                        
                                                        <span class="sharespan"><input type="checkbox" id="class_share" ng-model="class_share" value="1"> Class</span>
                                                        <span class="sharespan"><input type="radio"  name="teacher_share" ng-model="teacher_share" value="1"> Share Teacher With View Only</span>
                                                        <span class="sharespan"><input type="radio" name="teacher_share" ng-model="teacher_share"  value="2"> Share Teacher With Edit & View</span>
                                                        <span class="sharespan"><input type="radio" name="teacher_share" ng-model="teacher_share" ng-checked="true" value="0"> No Share With Teachers</span>
                                                        
							</div> 
                                                    </div> 
                                               </div> 
                                    
                                    
                                              <div class="row">
                                              
                                                   <div class="col-md-6 col-sm-6 col-xs-12 classrow" style="display:none;">
                                                       <div class="labelbox">
                                                         <span class="form-label">Class<span>*</em></span> 
                                                          <span class="form-label actionall classall">Select All</span> 
                                                       </div>    
                                                        <div class="databox">
                                                            <span ng-repeat="classes in allclass" >
                                                                <input type="checkbox" value="{{classes.id}}" class="listclass" name="listclass"  ng-model="lessonclass"> {{classes.class}} - {{classes.section}}
                                                            </span>
                                                        </div>    
                                                  </div>
                                                  
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
							<div class="form-group ">
					                <label class="form-label">Attachment</label>
                                                        <input class="form-control" id="document"  ng-model="document" type="file">
							</div>
							
						</div>
                                                </div>
                                    
                                                <div class="row">
                                                <div class="col-md-6 col-sm-6 col-xs-12">
<!--                                                    <button class="btn btn-primary"  ng-click="addNote()">Add Note</button>-->
                                                    <button class="btn btn-primary" ng-click="addNote()" >Add Note</button>
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