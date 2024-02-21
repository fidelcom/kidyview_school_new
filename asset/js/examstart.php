<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
    <div class="page-icon">
    <i class="icon-user-tie"></i>
    </div>
    <div class="page-title ml-3 align-self-center">
        <h5>Exam Resume</h5>
    </div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<div class="card-header mb-3">
<div class="row">
    <div class="col-md-8">
        <h4 class="mb-0 mt-1">{{examinfo.name}}</h4>
    </div>
    <!--<div class="col-md-4 text-left text-md-right">
        <a href="javascript:void(0);" class="btn btn-success btn-sm">Resume</a>
    </div>-->
</div>
</div>
<div class="card-body small-font">
<div class="row">
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Class:</span> {{examinfo.classname}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Subject:</span> {{examinfo.subject}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Duration:</span> {{examinfo.examduration}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Exam Date:</span> {{(examinfo.exam_date|myDate)+' '+examinfo.exam_time}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Total Marks:</span> {{examinfo.total_marks}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Attempt Allowed:</span> {{examinfo.exam_attempt_no}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Attempt Made:</span> {{examinfo.no_of_attempt!=null?examinfo.no_of_attempt:0}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Last Submission Date:</span> {{examinfo.last_submission_date|myDate}}
    </div>
    <div class="col-md-4 mb-3">
        <span class="text-mdm mr-2">Instruction:</span> {{examinfo.exam_instruction}}
    </div>
    <div class="col-md-6 mb-2">
        <span class="text-mdm mr-2">Remaining Time:</span> {{hours}} Hours {{minutes}} Minutes {{seconds}} Seconds
    </div>
</div>
<hr class="mb-3" />
<div>
        {{question1 | json}}
        <div>
            <label data-ng-repeat="choice in question1.choices">
                <input type="radio" name="response" value="true" ng-click="setChoiceForQuestion(question1, choice)"/>
                    {{choice.text}}
            </label>
        </div>
        <div>
            <label data-ng-repeat="choice in question2.choices">
                <input type="radio" name="response" data-ng-model="choice.isUserAnswer" value="true" />
                    {{choice.text}}
            </label>
        </div>
    </div>
<form>
    <div class="question-block-e" ng-repeat="ques in examinfo.examQuestionData">
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
    <div class="row">
        <div class="col-md-12">
            <button type="button" ng-click="StopTimer();submitExam();" class="btn btn-primary">Submit</button>
            <a href="#!exam-list" class="btn btn-danger">Cancel</a>
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
<div class="modal fade show" id="examModal" style="display: none; padding-right: 0px;">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
    <div class="modal-body">
        <div class="del-comment-text text-center">
            <h6>Your exam time has been expire.Are you want to submit exam?</h6>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-primary">Yes</button>
            <a href="#!exam-list">No</a>
        </div>
    </div>
</div>
</div>
</div>