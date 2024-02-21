<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-user-plus"></i>
							</div>
							<div class="page-title">
								<h5>{{ name }} - ( Question Lists) </h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-question/{{examEncrpID}}" class="btn btn-primary" ng-if="examDateTime > current_datetime"> <i class="icon-plus2"></i> Add Question</a>
							</div>
						</div>
					</div>
				</div>
	</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body">
						<form class="form-inline float-left mb-0 mb-md-3">
							<div class="">
								<input type="text" ng-model="search" class="form-control" placeholder="Search">
							</div>
						</form>
						<div class="table-responsive">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Question</th>
										
										<th>Exam Date</th>
										<th>Exam Time</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
								<tr dir-paginate="ques in questionList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize" current-page="currentPage">

										<td>{{pageSize * (currentPage-1)+$index+1}}</td>
										<td>{{ques.question}}</td>
										
										<td>{{ques.exam_date}}</td>
										<td>{{ques.exam_time}}</td>
										<td class="action text-right">
											<a href="#!/edit-question/{{
											ques.id}}" data-toggle="tooltip" data-original-title="Edit" data-placement="top" ng-if="examDateTime > current_datetime"><i class="icon-edit2"></i></a>
											
											<a href="#!/details-question/{{ques.id}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>

											<a ng-click="questionDelete(ques.ques_id)" title="Delete" ng-if="(examDateTime > current_datetime) && (exam_date_time > current_datetime)"><i class="icon-trash"></i></a>
										</td>
									</tr>	
								</tbody>
							</table>
						
					<div ng-if="questionList.length > 0">
							<div class="clearfix"></div>
								<dir-pagination-controls
								max-size="10" class="mb-3 float-right"
								direction-links="true"
								boundary-links="true">
								</dir-pagination-controls>
								<dir-pagination-controls
								max-size="10"
								direction-links="true" class="float-left"
								boundary-links="true"
								template-url="<?php echo base_url(); ?>asset/js/dirPagination.tpl.html">
								</dir-pagination-controls>
							</div>
						</div>
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main