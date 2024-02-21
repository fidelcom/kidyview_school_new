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
                                    <h5>Add Questions</h5>
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
                                        <input type="hidden" ng-model="question_marks_total" 
                                        value= {{(question_marks_total)}}>
                                         <input type="hidden" ng-model="total_marks" value={{total_marks}}>
                                         <input type="hidden" ng-model="total_question" value={{total_question}}>
                                         <input type="hidden" ng-model="question_qty" value={{question_qty}}>
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Enter Question<em>*</em></label>
                                                    <div class="controls">
                                                       <textarea class="form-control" ng-model="question" rows="5" placeholder="Enter your question" required="required"></textarea>
                                                    </div>
                                                </div>
                                            </div>
											
										    <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Marks Contain<em>*</em></label>
                                                    <div class="controls">
                                                        <input type="text" ng-model="question_marks" class="form-control digit-only" placeholder="Enter question mark" required="required">
                                                    </div>
                                                </div>
                                            </div>

                                           
                                            <div class="col-md-8 col-sm-8 col-xs-12">
                                                <div class="form-group">
                                                    <label class="form-label">Multiple Choice Question<em>*</em></label>
                                                    <div class="controls">
                                                        <select id="questionType" ng-model="question_type"  class="form-control" ng-change="selectChoice(question_type)" required="required">
                                                            <option value="" selected="">Select</option>
                                                            <option value="multiple" ng-if="exam_type != 'textual'">Multiple choice question</option>
                                                            <option value="radio" ng-if="exam_type != 'textual'">Radio option</option>
                                                            <option value="boolean" ng-if="exam_type != 'textual'">True and False</option>
                                                            <option value="textual" ng-if="exam_type != 'multiple'">Textual</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
											
											<div class="col-md-8 col-sm-8 col-xs-12" >
												<div id="multi-choice-ques" class="hide-ques" ng-if="question_type == 'multiple'">
														<div class="copydiv-Block" ng-repeat="ma in multiAnswer track by $index">
															<div class="rpt-multiChoise form-group mb-0">
																<input type="text" ng-model="ma.optionVal" class="form-control mb-3" placeholder="add answer {{$index+1}} (one answer is mandatory )" required="required">
															</div>
														</div>
												</div>
                                                <div id="redio-opt-ques" class="hide-ques" ng-if="question_type == 'radio'">
														<div class="copydiv-Block" ng-repeat="ma in multiAnswer track by $index">
															<div class="rpt-multiChoise form-group mb-0">
																<input type="text" ng-model="ma.optionVal" class="form-control mb-3" placeholder="add answer {{$index+1}} (one answer is mandatory )" required="required">
															</div>
														</div>
												</div>
											
    											<div id="textual-ques" class="hide-ques" ng-if="(question_type == 'textual')" ng-repeat="ma in multiAnswer">
    													<!-- <input type="text" name="textual" ng-model="ma.optionVal" class="form-control" placeholder="add answer"> -->
    												</div>

                                            <div class="col-md-8 col-sm-8 col-xs-12" id="answerDiv" ng-if="(question_id != null) && (question_type != 'textual') ">
                                                <div class="form-group">
                                                    <label class="form-label">Add Answer<em>*</em></label>
                                                    <div class="controls">
                                                        <ui-select multiple ng-model="multiAnswers.values" ng-disabled="multiAnswers.values.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;" required="required">
                                                        <ui-select-match placeholder="Select answers">{{$item.option}}</ui-select-match>
                                                        <ui-select-choices repeat="val in quesValues | propsFilter:{option:$select.search}">
                                                            <div>{{val.option}} </div>
                                                        </ui-select-choices>
                                                    </ui-select>
                                                    </div>
                                                </div>
                                                        <input type="hidden" ng-model="question_id">
                                            </div>
    										
											<div class="col-md-12 col-sm-12 col-xs-12 mt-2">
												<button type="button" ng-click="addQuestion()" ng-if="question_id == null" id="addQuestion" class="btn btn-primary">Submit</button>
                                                <button type="button" ng-click="addAnswersChoices()" ng-if="(question_id != null) && (question_type != 'textual')" ng-model="questStatus" class="btn btn-primary">Add Answer</button>
												<a href="#!/exam" class="btn btn-danger">Cancel</a>
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
<!-- END: .app-main -->
<script>  
$(document).ready(function(){
    // $("#answerDiv").hide();
    // $('#questionType').on('change', function() {
    //   if ( (this.value == 'radio') || (this.value == 'multiple') || (this.value == 'boolean'))
    //     $("#answerDiv").show();
    //   else
    //     $("#answerDiv").hide();
    // });
});
</script> 