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
						<h5>View Lesson and Notes</h5>
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
				<div class="row">
					<div class="col-md-1 col-sm-12 col-xs-12"></div>
					<div class="col-md-11 col-sm-12 col-xs-12">
					<form id="commentfrm" class="commentfrm">
						<div class="card-body vendor-full-detail p-0">
							<div class="row mt-4">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Term :</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">	{{term}}</div>
							</div>
                            <div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Activity Type:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{activitytype}} </div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">From Date :</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{fromdate}} </div>
							</div>
                            <div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">To Date:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{todate}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Subject:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{lessonsubject}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Topic:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">	{{topic}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Student Notes:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">	{{student_notes}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Objective:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{objectives}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Material:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{material}}</div>
							</div>
							<div class="row">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Concept Introduction:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">{{introduction}}</div>
							</div>
							<!--<div class="row" ng-if="attachment!=''">
								<div class="col-md-4 col-lg-4 col-sm-5 col-12 pr-0">Attachment:</div>
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 text-highligh">
									<a href="<?=base_url()?>/img/teacher/{{attachment}}" download="true">Download</a> 
								</div>
							</div>--> 
						<div class="row" ng-if="attachmentArray.length>0">
						<div class="col-md-3 col-lg-3 col-sm-12">Attachments</div>
						<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
						<div class="btn-group send_btn DownloadAll">
							<a href="javascript:void(0);" ng-click="lessondownload(notesdata.id);" class="btn btn-info btn-sm"><i class="icon-download3"></i> Download All</a>
						</div>			
						</div>
						</div>
						<div class="row">
						<div class="col-md-3 col-lg-3 col-sm-12"></div>
						<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
						<div class="row" ng-repeat="attach in attachmentArray">
							<div class="col-sm-6 col-md-6 col-lg-6 col-sm-12">
							<p>{{attach.attachment}}</p>
							</div>
							<div class="col-sm-6 col-md-6 col-lg-6 col-sm-12">				
								<div class="single-attachment BottonBox">
									<div class="btn-group send_btn">
										<a target="_blank" class="btn-primary btn btn-sm" href="{{attach.downloadurl}}"><i class="icon-eye2"></i> <span>view</span></button>
										<a target="_self" download="{{attach.attachment}}" href="{{attach.downloadurl}}" class="btn btn-info btn-sm"><i class="icon-download3"></i> <span>Download </span></a>
									</div>
								</div>
							</div>
								
						</div>
						</div>
						</div>            
							<hr />
							<div class="classboard-comment">
								<h5 class="text-primary mb-3 mt-2">Comments</h5>
								<div class="comment-form mb-3">
									<form action="" method="post">
										<div class="form-group position-relative">
										<input type="text" ng-model="comment" name="comment" class="form-control" placeholder="Add Comments" />
											<button type="button" ng-click="addComment()" class="btn btn-primary">Comment</button>
										</div>
									</form>
								</div>
							</div>
							<div class="rply-classboard-comment pl-3">
							
								<div class="media media-class-board pt-2 pb-3" ng-repeat="comment in notesdata.commentData">
								<a href="javascript:void(0);" class="float-left" ng-show="comment.user_type=='School'"> 
								<img ng-show="comment.photo!=''" alt="" src="<?php echo base_url();?>img/school/{{comment.photo}}" class="img-circle" width="40">
								<img ng-show="comment.photo==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-fluid" width="40">
								</a>
								<a href="javascript:void(0);" class="float-left" ng-show="comment.user_type=='Student'"> 
								<img ng-show="comment.photo!=''" alt="" src="<?php echo base_url();?>img/child/{{comment.photo}}" class="img-circle" width="40">
								<img ng-show="comment.photo==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-fluid" width="40">
								</a>
								<a href="javascript:void(0);" class="float-left" ng-show="comment.user_type=='Teacher'"> 
								<img ng-show="comment.photo!=''" alt="" src="<?php echo base_url();?>img/teacher/{{comment.photo}}" class="img-circle" width="40">
								<img ng-show="comment.photo==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-fluid" width="40">
								</a>
								<div class="media-body">
								<h6 class="m-0">{{comment.uname}}</h6>
								<p class="m-0">{{comment.comment}}</p>
								</div>
								<div class="pp-links" ng-if="comment.is_delete==1">
										<a href="javascript:void(0);" ng-click="deleteComment(comment,comment.id,$index);" class="btn btn-primary mt-2"><i class="fas fa-trash-alt" ></i></a>
									</div>
								</div>
								
							</div>
							<div class="row mt-5">
								<div class="col-md-8 col-lg-8 col-sm-7 col-12 offset-md-4 offset-sm-5 text-highligh">
									<a class="btn btn-secondary" href="#!/note-list">Back To List</a>
								</div>
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
<style>
.commentfrm textarea {
min-height: 300px;
max-height: 300px;
}    
</style>    