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
               <h6>Status: <span class="text-success">Submitted</span></h6>
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
                     <div class="col-md-8">{{examinfo.exam_duration}}</div>
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
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Marks Received</strong></div>
                     <div class="col-md-8">100</div>
                  </div>
                  <div class="row mt-2">
                     <div class="col-md-4"><strong>Instruction</strong></div>
                     <div class="col-md-8">{{examinfo.exam_instruction}}</div>
                  </div>
                  <div class="row mt-2 mt-md-3 mb-2 mb-md-3">
                     <div class="col-md-3">
                        <a href="javascript:void(0);" ng-click="viewQuestion();" class="btn btn-primary">View Questions</a>
                     </div>
                  </div>
               </div>
               <div class="col-md-3 profileimg">
                  <img class="img-fluid" src="<?php echo base_url();?>img/child/{{examinfo.childphoto}}" />
               </div>
            </div>
        <div class="question-block-e" ng-repeat="ques in examinfo.getUserExamAnswerData" ng-show="viewQuestion">
        <div class="row">
            <div class="col-md-3"><span class="text-mdm">Question: {{$index+1}}</span></div>
            <div class="col-md-9 text-left text-md-right"><span class="question-marks text-danger">({{ques.question_marks}} Marks)</span></div>
            <div class="col-md-12 mt-2">{{ques.question}}</div>
            
            <div class="col-md-12 answer-col mt-2">
                <div class="row"> 
                    <div class="col-md-2 col-sm-6" ng-repeat="opt in ques.option_value">
                    <div class="form-radio" ng-show="ques.question_type=='multiple'">
                            <label class="">{{opt.option}}</label> &nbsp;&nbsp;&nbsp;&nbsp; &nbsp;
                                <input class="form-check-input" ng-model="opt.isUserAnswer" type="checkbox" value="true">
                        </div>
                        <div class="form-radio" ng-show="ques.question_type=='radio'">
                            <label class="form-check-label">
                                <input class="form-check-input" ng-model="opt.isUserAnswer" type="radio"  value="true" ng-click="setChoiceForQuestion(ques,opt)"/>
                                <span class="checkmark"></span>{{opt.option}}
                            </label>
                        </div>

                        <div class="form-radio" ng-show="ques.question_type=='boolean'">
                            <label class="form-check-label">{{opt.option}}
                                <input class="form-check-input" ng-model="opt.isUserAnswer" type="radio"  value="true" ng-click="setChoiceForQuestion(ques, opt)"/>
                                <span class="checkmark"></span>
                            </label>
                        </div>

                    </div>      
                    
                </div>
            </div>
            <div class="col-md-12 answer-col mt-2" ng-show="ques.question_type=='textual'" ng-repeat="opt in ques.option_value">
                <textarea class="form-control"  rows="5" ng-model="opt.isUserAnswer" placeholder="Type your answer"></textarea>
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