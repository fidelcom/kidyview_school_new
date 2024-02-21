<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-file-text"></i>
							</div>
							<div class="page-title">
								<h5>Result</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<!-- <a href="#!/add-result" class="btn btn-primary"> <i class="icon-plus2"></i> Add Result</a> -->
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
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
										<!-- <label class="form-label">Select Class</label> -->
										<div class="controls">
											<select id="select_class" class="form-control" ng-model="class_id" ng-change="getStudentsResultList()">
												<option value="">Select Class</option>
												<option value="{{cs.id}}" ng-repeat="cs in classList">{{cs.class+" "+cs.section}}</option>
											</select>
                                                                                    
										</div>
                                                                                
                                                                                
                                                                                
									</div>
									<div class="form-group float-none float-md-left">
										<select class="form-control" id="sessionID" ng-model="sessionID" ng-change="getStudentsResultList()">
											<option ng-repeat="session in sessionList" value="{{session.id}}">{{session.academicsession}}</option>
										</select>
									</div>
								</div>
								
								<div class="col-md-4 col-sm-4 col-xs-12">
									<div class="form-group">
									<button type="button" ng-click="exportResult()" class="btn btn-primary">Download as csv</button>
									
								</div>
								</div>    

								<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="row">
											<div class="col-sm-12">
											<table datatable="ng" class="table table-striped table-bordered table-responsive">
											<thead>
												<tr role="row">
													<th class="text-left sorting_asc" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Sr No: activate to sort column descending" style="width: 126px;">Sr no.</th>
													<th class="text-left sorting_asc" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Students Name: activate to sort column descending" style="width: 126px;">Students Name</th>
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Father Name: activate to sort column ascending" style="width: 107px;">Father Name</th>
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Class: activate to sort column ascending" style="width: 48px;">Class</th>
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Class Teacher: activate to sort column ascending" style="width: 117px;">Class Teacher</th>
													
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Term 1: activate to sort column ascending" style="width: 55px;" ng-repeat="term in termsList">{{term.termname}}
													</th>
													
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="total: activate to sort column ascending" style="width: 45px;">total</th>
													<th class="sorting" tabindex="0" aria-controls="school-listing" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending" style="width: 79px;">Action</th>
												</tr>
											</thead>
											<tbody>
												
											<tr role="row" class="odd" ng-repeat="result in studentsList">
													<td>{{$index + 1}}</td>
													<td class="text-left sorting_1">{{result.stud_name}}</td>
													<td>{{( result.father_name ? result.father_name : result.mother_name)}}</td>
													<td>{{result.class}}</td>
													<td>{{result.teacher_name}}</td>
													<td ng-repeat="term in termsList">
														<span ng-repeat="termData in result.termListData" ng-if="(termData.term_id == term.term_id)">
															{{ (termData.obtainTermMarks ? termData.obtainTermMarks+'/'+termData.totalTermMarks: 'N/A') }}
														</span>
													</td>
													<td>{{(result.overall_marks_obtain ? result.overall_marks_obtain+'/'+result.overall_total_marks: 'N/A')}}</td>
													
													<td class="action">
														<a href="#!/result-deatil/{{result.studentID}}/{{result.session_id}}" data-toggle="tooltip" data-original-title="View" title="View Details Result" data-placement="top"><i class="icon-eye"></i></a>

														<button type="button" ng-click="generateResult(result.student_id)" class="ng-scope" title="Generate Result"><i class="fa fa-trophy" style="cursor: pointer;"></i></button>
														<a href="<?php echo base_url();?>download/result/{{result.schoolId}}/{{result.student_id}}/{{result.session_id}}" data-toggle="tooltip" data-original-title="Download" title="Download Report Card" data-placement="top"><i class="icon-download"></i></a>
														<!-- <button ng-click="approveDisapproveResult(exam)"  title="Approve" class="ng-scope"><i class="fas fa-unlock"></i></button> -->
														<!-- <button ng-click="test(result.studentID)"  title="Approve" class="ng-scope"><i class="icon-check"></i></button> -->

														<!-- <button class="green" data-toggle="tooltip" data-original-title="Approve" data-placement="top" ><i class="icon-check"></i></button> -->
														<!-- <button   >Approved</button> -->
														<!-- <button  ng-click="approveDisapproveResult(term='all',result.studentID,resultStatus,'null')" class="red" data-toggle="tooltip" data-original-title="Disapprove" data-placement="top"><i class="icon-cross"></i></button> -->

													
														<!-- <a href="javascript:void(0);" class="red" data-toggle="tooltip" data-original-title="Reject" data-placement="top"><i class="icon-cross"></i></a> -->
													</td>
												</tr>
											
											</tbody>
										</table>
									</div>
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