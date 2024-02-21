<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-news"></i>
					</div>
					<div class="page-title">
						<h5>Add Subsciption Amount</h5>
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
				<form name="myForm">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">School Type<em>*</em></label>
								<div class="controls">
									<select class="form-control" ng-model="subscription.school_type">
										<option value="" selected="selected">Select School Type</option>
											<option ng-repeat="type in schoolTypeList" value="{{ type.value }}">{{ type.name }}</option>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
								<div class="form-group">
									<label class="form-label">Class &amp; Section<em>*</em></label>
									<div class="controls">
                                  	 <ui-select ng-model="subscription.class_id" theme="select2" title="Select"  style="width:300px;" >
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
								<label class="form-label">Subscription Amount (Monthly)<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="subscription.amount" placeholder="Amount">
								</div>
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="addFeeSubscription(subscription)" name="submit">Add</button>
								<a class="btn btn-secondary" href="#!/fee-subscription-list">Back To List</a>
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