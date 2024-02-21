<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
					<div class="page-icon">
						<i class="icon-email"></i>
					</div>
					<div class="page-title">
						<h5>Messages</h5>
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
					<div class="col-md-12 col-sm-12 col-xs-12">
						
						<div id="frame">
							<div class="content">
								<div class="messages">
									<ul>
										<li ng-repeat="msg in msgInfo">
											<div ng-if ="msg.sender == msgInfo[0].senderDetails.id" class="replies">
												<img src="<?= base_url();?>img/teacher/{{msg.senderDetails.photo}}" alt="" />
												<div class="txt-msg-box">
													<div class="msg-content-m">
														<p>{{msg.message}}</p>
														<div ng-if="msg.attachments.length != 0" class="msg-attached-img"><img ng-repeat="file in msg.attachments" src="<?= base_url();?>img/message/{{file.file}}" /></div>
													</div>
													<div class="msg-time-blk">{{msg.time_elapsed}}</div>
												</div>
											</div>
											<div ng-if ="msg.sender == msgInfo[0].recieverDetails.id" class="sent">
												<img src="<?= base_url();?>img/teacher/{{msg.senderDetails.photo}}" alt="" />
												<div class="txt-msg-box">
													<div class="msg-content-m">
														<p>{{msg.message}}</p>
														<div ng-if="msg.attachments.length != 0" class="msg-attached-img"><img ng-repeat="file in msg.attachments" src="<?= base_url();?>img/message/{{file.file}}" /></div>
													</div>
													<div class="msg-time-blk">{{msg.time_elapsed}}</div>
												</div>
											</div>
										</li>
									</div>
									<div class="message-input"ng-if="schoolID == msgInfo[0].senderDetails.id || schoolID == msgInfo[0].recieverDetails.id">
										<div class="wrap">
											<form>
												<input type="text" ng-model="message" placeholder="Write your message...">
												<span class="file-btn-msg"><input type="file" ngf-select="" ngf-change="onChange($files)" name="pic[]" ng-model="pic" multiple=""></span>
												<button class="submit" ng-click="composemessage(message, msgInfo[0].senderDetails.id, msgInfo[0].recieverDetails.id)"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
												<form>
												</div>
											</div>
										</div>
										
									</div>
								</div>
							</div>
						</div>
						<a class="btn btn-secondary" href="#!/message-list">Back To List</a>
						<!-- Row end -->
					</div>
					<!-- END: .main-content -->
				</div>
			<!-- END: .app-main -->											