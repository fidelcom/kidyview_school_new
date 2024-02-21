<!-- END: .app-side -->            <!-- BEGIN .app-main -->
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
			<h5>Edit Class Board</h5>
		</div>
	</div>
</div>
</div>
</header>
<!-- BEGIN .main-content -->
<div class="main-content">
<!-- Row start -->
<div class="row same-height-card">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	<div class="card dataTables_wrapper">
		<div class="card-body">
		<div class="error" ng-show="errormsg">{{errormsg}}</div>
			<form>
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Classroom Name</label>
					</div>
					<div class="col-md-6 pl-3 pl-md-0">
						<input type="text" class="form-control" ng-model="classroom" name="classroom" value='' />
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Select Class</label>
					</div>
					<div class="col-md-6 pl-3 pl-md-0">
						<div class="form-group multi-dorpdown-list">
							<div class="controls">
								<select class="form-control" ng-model="class" ng-change="getStudentList();" >
									<option value="">Select Class</option>
									<option value="{{class.id}}" ng-repeat="class in classData">{{class.classname}}</option>
								</select>
							</div>
						</div>
					</div>
				</div>
				
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Select Students</label>
					</div>
					
					<div class="col-md-6 pl-3 pl-md-0">
						<div class="form-group multi-dorpdown-list"> 
						<div ng-dropdown-multiselect="" options="studentData" selected-model="student" checkboxes="true" extra-settings="setting1"></div>
							<!--<div class="controls">
								<select class="form-control" multiple="multiple" ng-model="student" >
									<option value="{{student.id}}" ng-repeat="student in studentData">{{student.childname}}</option>
								</select>
							</div>-->
						</div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Description</label>
					</div>
					<div class="col-md-6 pl-3 pl-md-0">
						<textarea class="form-control" rows="4" ng-model="description" name="description"></textarea>
					</div>
				</div>
				<div class="row form-group mt-3">
					<div class="col-md-3 pr-0">
					</div>
					<div class="col-md-6 pl-3 pl-md-0">
						<button type="button" ng-click="editClassboard();" class="btn btn-primary">Update</button>
						<a href="#!/classboard-list" class="btn btn-danger">Cancel</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->