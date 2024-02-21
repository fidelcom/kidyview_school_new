<div class="app-main">
                <!-- BEGIN .main-heading -->
                <header class="main-heading">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                                <div class="page-icon">
                                    <i class="icon-calendar3"></i>
                                </div>
                                <div class="page-title">
                                    <h5>Request day off Details</h5>
                                </div>
                            </div>
                            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                                <div class="right-actions">
                                     <a href="#!/request-day-off" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
								<!--<a href="#" class="btn btn-primary">Add School</a> -->
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
							
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Name</span></div>
								<div class="col-md-10">{{ dayoffDetails.name }} </div>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Role</span></div>
								<div class="col-md-10 text-capitalize">{{ dayoffDetails.user_type }}</div>
							</div>
						
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Date</span></div>
								<div class="col-md-10">{{ dayoffDetails.from_date +' to '+ dayoffDetails.to_date }}</div>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Total Days</span></div>
								<div class="col-md-10">{{ dayoffDetails.number_of_days ? dayoffDetails.number_of_days+' Days' : ''}}</div>
							</div>

							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Working Days</span></div>
								<div class="col-md-10">{{ dayoffDetails.working_days ? dayoffDetails.working_days+' Days' : '' }} </div>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Reason</span></div>
								<div class="col-md-10 text-capitalize text-bold">{{ dayoffDetails.reason ? dayoffDetails.reason : ' ' }}</div>
							</div>
							
							<div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Status</span></div>
								<div class="col-md-10 text-capitalize" ng-if="dayoffDetails.status == 'created' " style="color: darkblue;"><i class="icon-check"></i> {{ dayoffDetails.status ? dayoffDetails.status : ' ' }}</div>
								<div class="col-md-10 text-success text-capitalize" ng-if="dayoffDetails.status == 'Approve' "><i class="icon-check"></i> {{ dayoffDetails.status ? dayoffDetails.status : ' ' }}</div>
								<div class="col-md-10 text-danger text-capitalize" ng-if="dayoffDetails.status == 'Deny' "><i class="icon-check"></i> {{ dayoffDetails.status ? dayoffDetails.status : ' ' }}</div>
							</div>
							
							<!-- <div class="row mb-3">
								<div class="col-md-2"><span class="text-bold">Attachments</span></div>
								<div class="col-md-10 text-success">
									<div class="attachment-mail m-0 p-0">
										<p>
											<span><i class="fa fa-paperclip"></i> 2 attachments — </span>
											<a href="#">Download all attachments</a> | <a href="#">View all images</a>
										</p>
										<ul>
											<li>
												<a class="atch-thumb" href="#"> <img src="https://chawtechsolutions.ch/kidyview/img/school/038a27bae5162c0bf4b2bddb99d56a6a.jpg" alt="image upload" class="doctor-pic">
													</a><div class="links"><a class="atch-thumb" href="#">
														</a><a href="#">View</a> - <a href="#">Download</a>
													</div>
											</li>
											<li>
												<a class="atch-thumb" href="#"> <img src="https://chawtechsolutions.ch/kidyview/img/school/038a27bae5162c0bf4b2bddb99d56a6a.jpg" alt="image upload" class="doctor-pic">
													</a><div class="links"><a class="atch-thumb" href="#">
														</a><a href="#">View</a> - <a href="#">Download</a>
													</div>
											</li>
										</ul>
										<div class="clearfix"></div>
									</div>
								</div>
							</div> -->
							
							
                        </div>
                    </div>
                    <!-- Row end -->
                </div>
                <!-- END: .main-content -->
            </div>