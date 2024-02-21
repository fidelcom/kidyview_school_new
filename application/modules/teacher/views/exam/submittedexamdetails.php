<!-- BEGIN .app-main -->
<div class="app-main">
   <!-- BEGIN .main-heading -->
   <header class="main-heading">
      <div class="container-fluid">
         <div class="row">
            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 d-flex">
               <div class="page-icon">
                  <i class="icon-laptop_windows"></i>
               </div>
               <div class="page-title align-self-center ml-3">
                  <h5>Submitted Exam Details</h5>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 text-right align-self-center">
               <h6>Status: <span class="text-success">{{examinfo.exam_status}}</span></h6>
            </div>
         </div>
      </div>
   </header>
   <!-- END: .main-heading -->
   <!-- BEGIN .main-content -->
   <div class="main-content">
      <!-- Row start -->
      <div class="card dataTables_wrapper">
         <div class="card-body theme-dtl-pg small-font">
            <div class="row">
               <div class="col-md-9">
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Name</strong></div>
                     <div class="col-md-8">{{examinfo.name}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Date</strong></div>
                     <div class="col-md-8">{{(examinfo.exam_date|myDate)+' '+examinfo.exam_time}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Duraration</strong></div>
                     <div class="col-md-8">{{examinfo.examduration}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Session</strong></div>
                     <div class="col-md-8">{{examinfo.session}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Mode</strong></div>
                     <div class="col-md-8">{{examinfo.exam_mode}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Type</strong></div>
                     <div class="col-md-8">{{examinfo.exam_type}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Exam Category</strong></div>
                     <div class="col-md-8">{{examinfo.exam_category}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Student Name</strong></div>
                     <div class="col-md-8">{{examinfo.studentname}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Class</strong></div>
                     <div class="col-md-8">{{examinfo.classname}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Subject</strong></div>
                     <div class="col-md-8">{{examinfo.subject}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Subject Code</strong></div>
                     <div class="col-md-8">{{examinfo.subject_code}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Submitted Date</strong></div>
                     <div class="col-md-8">{{examinfo.submitted_date|myDate}}</div>
                  </div>
                  
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Total Questions</strong></div>
                     <div class="col-md-8">{{examinfo.total_question}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Total Marks</strong></div>
                     <div class="col-md-8">{{examinfo.total_marks}}</div>
                  </div>
                  <div class="row mt-2" ng-if="examinfo.obtain_id!=null && examinfo.exam_category=='non-graded'">
                     <div class="col-md-4"><strong>Marks Received</strong></div>
                     <div class="col-md-8">{{examinfo.marks_obtained}}</div>
                  </div>
                  <div class="row mt-2" ng-if="examinfo.obtain_id!=null && examinfo.exam_category=='graded'">
                     <div class="col-md-4"><strong>Grade</strong></div>
                     <div class="col-md-8"> {{examinfo.grade!=''?examinfo.grade:'N/A'}}</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Instruction</strong></div>
                     <div class="col-md-8">{{examinfo.exam_instruction}}</div>
                  </div>
                  <div class="row mt-2 mt-md-3 mb-2 mb-md-3" ng-hide="isviewQuestion">
                     <div class="col-md-3">
                        <a href="javascript:void(0);" ng-click="viewQuestion();" class="btn btn-primary">View Questions</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 profileimg">
                  <img ng-if="examinfo.childphoto!=''" class="img-fluid" src="<?php echo base_url();?>img/child/{{examinfo.childphoto}}"/>
                  <img ng-if="examinfo.childphoto==''" class="img-fluid" src="<?php echo base_url();?>img/noImage.png"/>
               </div>
            </div>
            <hr class="mt-3 mb-3">
        <div class="question-block-e" ng-repeat="ques in examinfo.getUserExamAnswerData" ng-show="isviewQuestion">
        <div class="row">
            <div class="col-md-10"><span class="text-mdm text-mdm-ques">Question: {{$index+1}}</span> {{ques.question}}</div>
            <div class="col-md-2 text-left text-md-right"><span class="question-marks text-danger">({{ques.question_marks}} Marks)</span></div>
           
            
            <div class="col-md-12 answer-col mt-2">
                <div class="row"> 
					<div class="col-md-2 col-sm-3">
						<div class="text-danger ans-mdm">Answer:</div>
					</div>
					<div class="col-md-2 col-sm-3" ng-repeat="opt in ques.option_value" ng-if="opt.isUserAnswer=='true' || opt.isUserAnswer==true">
						<div ng-if="ques.question_type!='textual'">
                  <div class="form-radio" ng-if="ques.question_type=='multiple'">
							<div ng-class="{'text-green':ques.answer.indexOf(opt.option)!=-1,'text-red':ques.answer.indexOf(opt.option)==-1}">{{opt.option}}</div>
						</div>
						<div class="form-radio" ng-if="ques.question_type=='radio'">
						<div ng-class="{'text-green':ques.answer==opt.option,'text-red':ques.answer!=opt.option}">{{opt.option}}</div>
						</div>

						<div class="form-radio" ng-if="ques.question_type=='boolean'">
						<div ng-class="{'text-green':ques.answer==opt.option,'text-red':ques.answer!=opt.option}">{{opt.option}}</div>
						</div>
                  </div>
                  <!--<div class="col-md-2 col-sm-3" style="text-align:right" ng-if="ques.question_type!='textual'">
						<div class="form-radio">
							<span class="RedIconBox"><i class="fas fa-times"></i></span>
							<span class="greenIconBox"><i class="fas fa-check"></i></span>
						</div>						
					</div>-->
					</div>
               
					<div class="col-md-8 answer-col" ng-show="ques.question_type=='textual'" ng-repeat="opt in ques.option_value">{{opt.isUserAnswer}}</div> 
					 
                </div>
                <div class="row" ng-if="ques.question_type!='textual'"> 
					<div class="col-md-2 col-sm-3">
						<div class="text-danger">Correct Answer:</div>
					</div>
					<div class="col-md-7 col-sm-7">
						<div class="form-radio">
							<div>{{ques.answer}}</div>
						</div>						
					</div>               
                </div>
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