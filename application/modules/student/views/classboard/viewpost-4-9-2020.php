<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 align-self-center">
	<div class="page-icon">
		<i class="fas fa-chalkboard-teacher"></i>
	</div>
	<div class="page-title">
		<h5>Class board</h5>
	</div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->

<div class="row same-height-card">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 view-classboard">
<div class="card" ng-repeat="post in classboardPostData track by $index">
	<div class="card-body small-font">
		<div class="inbox-body no-pad">
			<section class="mail-list">
				<div class="mail-sender pt-0 pb-0">
					<div class="media">
						<a href="javascript:void(0);" class="float-left"> <img alt="" src="<?php echo base_url();?>img/teacher/{{post.teacherphoto}}" class="img-circle" width="40">
					</a>
						<div class="media-body ">
							<div class="days-left-con position-relative">{{post.created|date:"dd MMM y"}}</div>
							<h4>{{post.teachername}}</h4>
							<small class="text-muted">{{post.classname}}</small>

						</div>

					</div>
				</div>
				<div class="view-mail">
					<p>{{post.description}}</p>
				</div>
				<div class="attachment-mail">
					<ul>
						<li ng-repeat="attachment in post.attachmentData">
						<a class="atch-thumb" target="_blank" href="<?php echo base_url();?>img/classboard/post/{{attachment.file}}"> 
						<img  ng-show="attachment.type=='image'" src="<?php echo base_url();?>img/classboard/post/{{attachment.file}}" alt="image" class="doctor-pic">
						<img  ng-show="attachment.type=='pdf'" src="<?php echo base_url();?>img/pdficon.png" alt="pdf" class="doctor-pic">
						<img  ng-show="attachment.type=='doc'" src="<?php echo base_url();?>img/doc-img.png" alt="doc" class="doctor-pic">
						</a>
						</li>
						
					</ul>
					<div class="clearfix"></div>
				</div>

			</section>
		</div>
	</div>
	<div class="chat-wrapper col-md-12">
		<p class="chat-scroll">{{post.commentData.length}} comments</p>
		<div class="comment-container">

			<div class="chat chat-left" ng-repeat="comment in post.commentData">
				<div class="chat-avatar">
					<a href="javascript:void(0);" class="avatar" ng-show="comment.user_type=='Student'"> <img alt="" src="<?php echo base_url();?>img/child/{{comment.photo}}" class="img-fluid rounded-circle" width="40">
					</a>
					<a href="javascript:void(0);" class="avatar" ng-show="comment.user_type=='Teacher'"> <img alt="" src="<?php echo base_url();?>img/teacher/{{comment.photo}}" class="img-fluid rounded-circle" width="40">
					</a>
				</div>
				<div class="chat-body">

					<div class="chat-bubble">
						<div class="chat-content">
							<h5>{{comment.uname}}</h5>
							<p>{{comment.comment}}</p>
							<span class="chat-time">{{comment.created}}</span>
						</div>
						<span class="delete-chat" ng-if="comment.is_deleted==1"><i ng-click="deleteComment(post,comment.id,$index);" class="icon-trash2"></i></span>
					</div>
				</div>
			</div>
			
		</div>
		<div class="chat-footer">
			<div class="message-bar">
				<div class="message-inner">
					<div class="message-area">
						<div class="input-group">
							<textarea class="form-control" ng-model="postcomment[$index]" placeholder="Type message..."></textarea>
							<span class="input-group-append">
								<button ng-click="comment(post,$index);" class="btn btn-primary" type="button"><i class="icon-send"></i></button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="TcrLoadmore" ng-show="countclassboardPostData>limit && classboardPostData.length<countclassboardPostData"><a href="javascript:void(0)" ng-click="loadMoreClassboardPostList();">Load More</a></div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->