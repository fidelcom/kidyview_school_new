<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-user-plus"></i>
							</div>
							<div class="page-title">
								<h5>Submitted Exam and Test Student-wise</h5>
							</div>
						</div>
						
					</div>
				</div>
			</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body">
						<!-- <form class="form-inline float-left mb-0 mb-md-3">
							<div class="">
								<input type="text" ng-model="search" class="form-control" placeholder="Search">
							</div>
						</form> -->
						
							<table datatable="ng" class="table table-striped table-bordered table-responsive custom-scrollbar">
								<thead>
									<tr>
										<th>S.No.</th>
										<th>Assessment Name</th>
										<th>Student Name</th>
										<th>Class</th>
										<th>Duration</th>
										<th>Subject</th>
										<th>No. of Question</th>
										<th>Status</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="exam in examsSubmitted">
										<!-- {{examsSubmitted}} -->
										<td>{{$index+1}}</td>
										<td>{{ exam.exam_name}}</td>
										<td>{{ exam.stud_name}}</td>
										<td>{{ exam.class}}</td>
										<td>{{ exam.exam_duration}} Mins</td>
										<td>{{ exam.subject}}</td>
										<td>{{ exam.total_question}}</td>
										<td ng-if=" (exam.exam_category == 'graded') "><span class="badge label-success">{{ (exam.grade) ? 'Graded' : 'Assessment Checking' }}</span></td>
										<td ng-if=" (exam.exam_category == 'non-graded') "><span class="badge label-danger">{{ (exam.grade) ? 'Mark Received' : 'Assessment Checking' }}</span></td>


										<td class="action text-right">
											<!-- <a href="#" data-toggle="tooltip" data-original-title="Edit" data-placement="top"><i class="icon-edit2"></i></a> -->
											<a href="#!/view-submit-exam/{{exam.id}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
											<!-- <a href="#" data-toggle="tooltip" data-original-title="Delete" data-placement="top"><i class="icon-trash"></i></a> -->
										</td>
									</tr>
								</tbody>
							</table>
								<!-- <div ng-if="examsSubmitted.length > 0">
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
								</div> -->
						
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main