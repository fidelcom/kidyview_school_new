<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
<div class="page-icon">
    <i class="fa fa-list-alt"></i>
</div>
<div class="page-title">
    <h5>Result</h5>
</div>
</div>
<!--<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
<div class="right-actions">
    <a href="add-result.html" class="btn btn-primary"> <i class="icon-plus2"></i> Add Result</a>
</div>
</div>-->
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<div class="card-body small-font">
		<div class="table-responsive">
		<div class="row rowFilter-head">
		<div class="col-md-4">
			<select class="form-control" ng-model="class_id" ng-change="getResultList()"> 
				<option value="">Select Class</option>
				<option value="{{class.id}}" ng-repeat="class in classArray | unique : 'id'">{{class.name}}</option>
			</select>
        </div>
		</div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div id="class_one">
            <table datatable="ng" class="table result_class_filter table-striped table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="text-left">Students Name</th>
                        <th>Father Name</th>
                        <th>Class</th>
                        <th>Class Teacher</th>
                        <th ng-repeat="term in resultData[0].termData">{{term.termname}}</th>
                        <th>total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="result in resultData">
                        <td class="text-left">{{result.studentname}}</td>
                        <td>{{result.parent_name}}</td>
                        <td>{{result.classname}}</td>
                        <td>{{result.classTeacher.teachername}}</td>
                        <td ng-repeat="term in result.termData">
                        <span ng-if="term.id">{{term.obtain_term_marks+' / '+term.total_term_marks}}</span>
                        </td>
                        <td>
                        <span ng-if="result.overall_total_marks>0">{{result.overall_marks_obtain}} / {{result.overall_total_marks}}</span></td>
                        <td class="action">
                            <a href="#!/result-detail/{{result.studentID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
                        </td>
                    </tr>
                
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->