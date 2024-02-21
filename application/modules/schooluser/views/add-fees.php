<!-- BEGIN .app-main -->
<div class="app-main">
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-wallet"></i>
							</div>
							<div class="page-title">
								<h5>Add Fee</h5>
							</div>
						</div>
						 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="right-actions add-2px d-flex">
									<a href="#!/fees-list" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
						<form action="driver-device-listing.html">
							<div class="row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Select Session</label>
										<div class="controls">
											<select class="form-control" ng-model="fees.session_id">
												<option value="" selected="selected">Select session</option>
												<option ng-repeat="session in sessions" value="{{session.id}}">{{ session.academicsession}}</option>
											</select>
										</div>
									</div>
								</div>
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">School Type</label>
										<div class="controls">
											<select class="form-control" ng-model="fees.school_type" ng-change="getClasses(fees.school_type)">
												<option value="" selected="selected">Select School Type</option>
													<option ng-repeat="type in schoolTypeList" value="{{ type.value }}">{{ type.name }}</option>
											</select>
										</div>
									</div>
								</div>
							
									<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Class &amp; Section</label>
										<div class="controls">
                                      	 <ui-select ng-model="fees.class_id" theme="select2" title="Select"  style="width:300px;" ng-click="getSubscriptionAmount(fees.class_id)" >
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
										<label class="form-label">Fee Amount</label>
										<div class="controls">
											<input type="text" ng-model="fees.fee_amount" class="form-control digit-only" id="device-no" placeholder="Amount">
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Fee</label>
										<div class="controls select_mutli withborder">

											<ui-select multiple ng-model="fees.category_ids" ng-disabled="fees.disabled" close-on-select="false" theme="select2" title="Select" style="width:300px;">
												<ui-select-match placeholder="Select Fees">{{$item.category}}</ui-select-match>
												<ui-select-choices repeat="cat in feesCategory | propsFilter:{category:$select.search}">
													<div>{{cat.category}} </div>
												</ui-select-choices>
											</ui-select>

											<!-- <select class="form-control multicheck" multiple="multiple">
												<option ng-repeat="cat in feesCategory" value="{{ cat.id }}">{{ cat.category }}</option>
											</select> -->
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Fee Type</label>
										<div class="controls">
											<select class="form-control" ng-model="fees.fee_type">
												<option value="1" selected="selected" ng-disabled="fees.disabled">Monthly</option>
												 <option value="2">Quarterly</option> 
												 <option value="3">Yearly</option> 
											</select>
										</div>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Comment</label>
										<div class="controls">
											<textarea class="form-control" ng-model="fees.description"></textarea>
										</div>
									</div>
								</div>
								<div class="clearfix"></div>
								<div class="col-md-6 col-sm-6 col-xs-6 mt-3 mb-1">
									<div class="form-check">
										<label class="form-check-label">Include Subscription
											<span ng-show="subAmount" class="text-center label label-danger">{{subscriptionAmount.amount ? subscriptionAmount.amount : '0'  }}</span>
											<input class="form-check-input" type="checkbox" name="parents" ng-click="isInclude()" id="add_suscription_fee">
											<span class="checkmark"></span>
										</label>
									</div>
                                                                    <input type="hidden" ng-model="fees.suscription_fee" value="{{ subscriptionAmount.amount ? subscriptionAmount.amount : '0' }}" id="suscription_fee">
								</div>
						
								<div class="clearfix"></div>


								<!-- <div  ng-show="subAmount" class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Subscription Amount {{subscriptionAmount.amount ? subscriptionAmount.amount : '0'  }}</label>
										<div class="controls">
											<input type="text" class="form-control" id="vehical-no" ng-model="fees.suscription_fee" value="{{ subscriptionAmount.amount ? subscriptionAmount.amount : '0' }}">
										</div>
									</div>
								</div> -->

								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
										<input class="btn btn-primary" type="button" ng-click="addFees(fees)" value="Submit">
										<input type="reset" class="btn btn-info" type="reset" value="Reset">
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
