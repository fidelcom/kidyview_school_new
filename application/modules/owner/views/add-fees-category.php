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
                    <h5>Add Fee Category</h5>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
				<div class="right-actions add-2px d-flex">
					<a href="#!/fees-category" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i>
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
                            <form action="#">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Category Name</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" id="driver-name" ng-model="category" placeholder="category">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <div class="controls">
                                                <textarea class="form-control" id="driver-name" ng-model="description" placeholder="description"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 mt-2">
                                        <div class="form-group">
                                            <input class="btn btn-primary" type="button" name="submit" value="Submit" ng-click="addCategory()">
                                            <input class="btn btn-info" type="reset" value="Reset">
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
