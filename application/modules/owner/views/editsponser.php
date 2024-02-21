<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Update Sponsor </h5>
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
										<label class="form-label">Company Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="title" required="">
										</div>
									</div>
								</div>
                                                            
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Link<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="link" required="">
										</div>
									</div>
								</div>
                                                                
                                                       <div class="col-lg-6 col-md-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label"></label>
								<div class="col-md-12">
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="upload-preview-box upload-img-view" ng-show="isImage(fileExt)">
                                                                            <img  ngf-src="logophoto[0]" class="thumb">
                                                                            </div>
                                                                             <div>
                                                                             <img ng-if="logo!='' " src="<?= base_url();?>img/sponser/{{logo}}" alt="" width="100" height="80"  />
                                                                             </div>
                                                                        </div>
                                                                       
                                                                       
                                                                    </div>  
                                                                   
                                                                </div>
                                                               
                                                               
                                                                
                                                                
								<div class="btn-uploadprof mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ng-model="logophoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Logo</span>
									</span>
								</div>
							</div>
						</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
									<button class="btn btn-primary" ng-click="updateSponser()">Update Sponsor </button>
									
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