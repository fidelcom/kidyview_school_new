<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-streetview"></i>
					</div>
					<div class="page-title">
						<h5>Update Gift</h5>
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
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Gift Title<em>*</em></label>
								<div class="controls">
									<input type="text" ng-model="title" class="form-control">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Points<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="points" pattern="^[0-9]+$" ng-pattern-restrict>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Actual Price<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="amount">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Discount Type</label>
								<div class="controls">
								<select class="form-control" ng-model="discount_type">
									<option value="">Select Discount Type</option>
									<option value="percentage">Percentage</option>
									<option value="value">Value</option>
								</select>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Discount</label>
								<div class="controls">
								<input type="text" class="form-control" ng-disabled="discount_type==''" ng-model="discount_value" allow-decimal-numbers>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Brand<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="brand">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Quantity<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="quantity" pattern="^[0-9]+$" ng-pattern-restrict>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description</label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box" ng-show="photo != '' || imgPrev!=''">
									<img ng-show="isImage(fileExt)" ngf-src="pic[0]" class="thumb">
									<img ng-show="photo != ''" src="<?= base_url();?>img/gift/{{photo}}" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo upload-photo-event">	
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" accept="image/png, image/jpeg" ng-model="pic" type="file">
										<span>change Photo</span>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="editGift()" name="submit">Update</button>
								<a class="btn btn-secondary" href="#!/gift-list">Back To List</a>
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