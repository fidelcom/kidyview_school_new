<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
    <div class="container-fluid">
        <div class="row">

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
                <div class="page-icon">
                    <i class="icon-wallet"></i>
                </div>
                <div class="page-title">
                    <h5>Update Voucher</h5>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
				<div class="right-actions add-2px d-flex">
					<a href="#!/voucher-list" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
 Back</a>
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
							<div class="form-group">
								<label class="form-label">Voucher Name*</label>
								<div class="controls">
									<input type="text" class="form-control" name="name" id="name" ng-model="voucherObj.name">
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Quantity*</label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="voucherObj.quantity" id="quantity" name="voucherObj.quantity" pattern="^[0-9]+$" ng-pattern-restrict>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Redeem Points*</label>
								<div class="controls">
									<input type="text" class="form-control" name="points" id="points" ng-model="voucherObj.points" pattern="^[0-9]+$" ng-pattern-restrict>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Mapped with (Product ID)*</label>
								<div class="controls">
								<ui-select ng-model="voucherObj.product_id" theme="select2" title="Select " style="width:300px;">
									<ui-select-match placeholder="Select Product">{{$select.selected.name}}</ui-select-match>
									<ui-select-choices repeat="v.id as v in voucherList | propsFilter: {name: $select.search}">
										<div>{{v.name}}</div>                                          
									</ui-select-choices>
								</ui-select>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Expiry Date*</label>
								<div class="controls">
									<input type="date" class="form-control" name="expire_date" name="expire_date" ng-model="voucherObj.expire_date">
								</div>
							</div>
						</div>
						<!--<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group select_mutli">
								<label class="form-label">Status</label>
								<div class="controls">
									<select class="form-control">
										<option value="0">Active</option>
										<option value="1">Inactive</option>
									</select>
								</div>
							</div>
						</div>-->
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="controls">
									<textarea type="text" class="form-control" name="description" id="description" ng-model="voucherObj.description"></textarea>
								</div>
							</div>
						</div>
						
						<div class="form-group col-md-12">
							<button class="btn btn-primary" ng-click="editVoucher();">Update</button>
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
