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
                                    <h5>Add Grade</h5>
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
					<!-- <div class="row">
						 <div class="col-sm-4 pb-3" ng-repeat="val in totalGrade">
		                    <label for="grade_name">Grade Name</label> 
								<input class="form-control" ng-model="val.grade_name"  type="text" >
		                  </div>
		                  <div class="col-sm-4 pb-3">
		                    <label for="min">Grade Min Value</label> 
								<input class="form-control" ng-model="val.min_percent" type="text" >
		                  </div>
		                  <div class="col-sm-4 pb-3">
		                    <label for="max">Grade Max Value</label> 
								<input class="form-control" ng-model="val.max_percent" type="text" >
		                  </div>
                	</div> -->
                	 <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div id="looprow" style="display: block;">
                            <label class="form-label">Add Grade </label> &nbsp;&nbsp;<button ng-click="addGrade()" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                            <!-- Start repeat row -->
                            <div class="loop-row" ng-repeat="x in data.info">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Grade Name</label>
                                            <div class="controls">
                                                <input ng-model="data.info[$index].grade_name" type="text" class="form-control" placeholder="Grade Name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Grade Min Value</label>
                                            <div class="controls">
                                                <input ng-model="data.info[$index].min_percent" type="text" class="form-control" placeholder="Min Percentage">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label class="form-label">Grade Max Value</label>
                                            <div class="controls">
                                                <input ng-model="data.info[$index].max_percent" type="text" class="form-control" placeholder="Max Percentage">
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>
                            <!-- end repeat row -->
                        </div>
                        </div>
		                         <div class="row">
		                        <div class="col-md-12 col-sm-12 col-xs-12 mt-3 ml-3">
		                            <div class="form-group">
		                                <input class="btn btn-primary" type="button" ng-click="saveGrades()" name="submit" value="Submit">
		                                <a class="btn btn-secondary" href="#!/grade-list">Back To List</a>
		                            </div>
		                        </div>
		                    </div>
                    </div>
				</form>
			</div>
		</div>		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main