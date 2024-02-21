<div class="app-main">
                <!-- BEGIN .main-heading -->
                <header class="main-heading">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
                                <div class="page-icon">
                                    <i class="icon-laptop_windows"></i>
                                </div>
                                <div class="page-title">
                                    <h5>Faqs</h5>
                                    <h6 class="sub-heading">Dashboard</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>
                <!-- END: .main-heading -->
                <!-- BEGIN .main-content -->
                <div class="main-content faq-student">
                   <div class="accordion-section clearfix mt-3">
  
						  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
							<div class="panel panel-default" ng-repeat="faq in faqData">
							  <div class="panel-heading p-3 mb-3" role="tab" id="heading{{$index}}">
								<h3 class="panel-title">
								  <span class="collapsed" role="button" title="" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$index}}" aria-expanded="true" aria-controls="collapse0">
									<small class="srl-number">{{$index+1}}</small> {{faq.question}}
								  </span>
								</h3>
							  </div>
							  <div id="collapse{{$index}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$index}}">
								<div class="panel-body px-3 mb-4">
								  <p>{{faq.answer}}</p>
								 
								</div>
							  </div>
							</div>
						  </div>
					  
					</div>
                </div>
                <!-- END: .main-content -->
            </div>